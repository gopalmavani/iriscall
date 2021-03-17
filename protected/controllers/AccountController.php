<?php
require_once ('plugins/tcpdf_min/tcpdf.php');
require_once 'vendor/autoload.php';
class AccountController extends Controller
{
    public $layout = 'main';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    protected function beforeAction($action)
    {
        date_default_timezone_set('Europe/Berlin');

        setlocale(LC_MONETARY, 'nl_NL.UTF-8');

        //Action that needs to be allowed for guest user
        $allowedActionArr = ['createguestaccount', 'uploadfiles'];
        if (Yii::app()->user->isGuest && !in_array($action->id, $allowedActionArr)) {
            $this->redirect(Yii::app()->createUrl('home/login'));
        }
        return parent::beforeAction($action);

    }

    /*
     * Create Guest User account in Iriscall and SIO
     * */
    protected function createSIOUser($request, $userId){
        $modified_data = SSOHelper::modifyPostDataWRTSSOForNewUser($request);
        $modified_data['sponsor_id'] = Yii::app()->params['SystemUserId'];
        $modified_data['password'] = 'W3lcome@sys';
        $sso_url = Yii::app()->params['SSO_URL'];
        $user_response = CurlHelper::executeAction($sso_url."api/createUser", $modified_data, "POST");
        $user = UserInfo::model()->findByPk($userId);
        if(!is_null($user_response['success_response']) && ($user_response['success_response']['status'] == 1)){
            $user->setAttributes($request, false);
            $user->full_name = $user->first_name . ' ' . $user->last_name;
            $user->save(false);
            $user_id = $user->user_id;
        } else {
            //Delete the guest user from Iriscall
            $user->delete();
            $user_id = '';
        }
        return $user_id;
    }

    /*
     * Create Guest account for user in telecom from wordpress website
     * */
    public function actionCreateguestaccount(){
        $this->layout = 'iriscallwordpress';

        //Create a guest dummy user
        $user = new UserInfo();
        $user->first_name = 'Guest';
        $user->last_name = 'User';
        $user->full_name = 'Guest User';
        $user->email = 'guest@user-'.ServiceHelper::randomString().'.com';
        $user->save(false);

        $telecom_user_details = new TelecomUserDetails();
        $telecom_details_present = false;
        $telecom_documents = [];

        //Default personal products
        $personal_product_data = Yii::app()->db->createCommand()
            ->select('pc.product_id, p.name, p.description , p.image, p.price')
            ->from('product_category pc')
            ->join('product_info p','pc.product_id=p.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['TelecomProductPersonalCategory']])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->queryAll();
        $business_product_data = Yii::app()->db->createCommand()
            ->select('pc.product_id, p.name, p.description , p.image, p.price')
            ->from('product_category pc')
            ->join('product_info p','pc.product_id=p.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['TelecomProductBusinessCategory']])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->queryAll();

        if(!empty($_POST)){
            $userId = $this->createSIOUser($_POST, $user->user_id);
            if($userId != ''){
                $telecom_user_details->setAttributes($_POST, false);
                $user = UserInfo::model()->findByPk($userId);
                $telecom_user_details->user_id = $user->user_id;
                $telecom_user_details->email = $user->email;
                $telecom_user_details->agent_id = $user->sponsor_id;
                $telecom_user_details->send_invoice_via = 'Email';
                $telecom_user_details->invoice_detail_type = 'Standard';
                $sponsor = UserInfo::model()->findByPk($user->sponsor_id);
                $telecom_user_details->agent_name = $sponsor->full_name;
                if(isset($_POST['cc_type']) && $_POST['cc_type'] != ''){
                    $telecom_user_details->credit_card_type = $_POST['cc_type'];
                    $telecom_user_details->credit_card_number = $_POST['cc_number'];
                    $telecom_user_details->credit_card_name = $_POST['cc_name'];
                    $telecom_user_details->expiry_date_month = $_POST['cc_exp_month'];
                    $telecom_user_details->expiry_date_year = $_POST['cc_exp_year'];
                }
                if($telecom_details_present){
                    $telecom_user_details->modified_at = date('Y-m-d H:i:s');
                }
                $telecom_user_details->save(false);

                if(isset($telecom_user_details->signature) && !empty($telecom_user_details->signature)){
                    $telecom_account = new TelecomAccountDetails();
                    $telecom_account->setAttributes($_POST, false);
                    $telecom_account->user_id = $user->user_id;
                    $telecom_account->email = $user->email;
                    $telecom_account->telecom_request_status = 0;
                    $telecom_account->save(false);

                    //Registration PDF
                    $filePath = $this->generateTelecomRegistrationPDF($telecom_account->user_id, $telecom_account->id);
                    $registrationDocument = TelecomDocuments::model()->findByAttributes(['document_name' => 'Registration']);
                    $telecomDocument = new TelecomUserDocuments();
                    $telecomDocument->user_id = $telecom_account->user_id;
                    $telecomDocument->document_id = $registrationDocument->document_id;
                    $telecomDocument->document_path = $filePath;
                    $telecomDocument->save(false);

                    //Create PDF
                    if($telecom_user_details->payment_method == 'SEPA'){
                        $filePath = $this->generateSEPAPDF($telecom_account->user_id, $_POST['sepa_signature']);
                        $sepaDocument = TelecomDocuments::model()->findByAttributes(['document_name' => 'SEPA']);
                        $telecomDocument = new TelecomUserDocuments();
                        $telecomDocument->user_id = $telecom_account->user_id;
                        $telecomDocument->document_id = $sepaDocument->document_id;
                        $telecomDocument->document_path = $filePath;
                        $telecomDocument->save(false);
                    }
                }

                //Delete all Guest users if any
                UserInfo::model()->deleteAll('first_name=:fn', [':fn'=>'Guest']);
                $this->layout = 'iriscallwordpress';
                $this->render('wordpressIriscallThankYou', [
                    'success' => $user->full_name . ', your request has been generated successfully'
                ]);
            } else {
                //Delete all Guest users if any
                UserInfo::model()->deleteAll('first_name=:fn', [':fn'=>'Guest']);
                $this->layout = 'iriscallwordpress';
                $this->render('wordpressIriscallThankYou', [
                    'error' => 'Issue while saving your request at SIO, kindly contact the support'
                ]);
            }
        } else {
            $telecom_account = new TelecomAccountDetails();

            $countryArray = ServiceHelper::getCountry();
            $nationalityArray = ServiceHelper::getNationality();

            $this->render('create', [
                'user' => $user,
                'telecom_user_detail' => $telecom_user_details,
                'telecom_details_presence' => $telecom_details_present,
                'telecom_documents' => $telecom_documents,
                'telecom_account' => $telecom_account,
                'personal_products' => $personal_product_data,
                'business_products' => $business_product_data,
                'countryArray' => $countryArray,
                'nationalityArray' => $nationalityArray
            ]);
        }
    }

    /**
     * Create account
     * for a new mobile connection
     * along with new telecom user
     */
    public function actionCreate()
    {
        $user_id = Yii::app()->user->id;
        $user = UserInfo::model()->findByPk($user_id);
        $telecom_user_details = TelecomUserDetails::model()->findByAttributes(['user_id'=>$user_id]);
        $telecom_details_present = false;
        $telecom_documents = [];

        if(isset($telecom_user_details->id)){
            $telecom_details_present = true;

            $telecom_documents = TelecomUserDocuments::model()->findAllByAttributes(['user_id'=>$user_id]);
        } else {
            $telecom_user_details = new TelecomUserDetails();
            $telecom_user_details->setAttributes($user->attributes, false);
            $telecom_user_details->date_of_birth = '';

            $userPayoutInfo = UserPayoutInfo::model()->findByAttributes(['user_id'=>$user_id]);
            if(isset($userPayoutInfo->user_id)){
                $telecom_user_details->setAttributes($userPayoutInfo->attributes, false);
            }
        }

        //Default personal products
        $personal_product_data = Yii::app()->db->createCommand()
            ->select('pc.product_id, p.name, p.description , p.image, p.price')
            ->from('product_category pc')
            ->join('product_info p','pc.product_id=p.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['TelecomProductPersonalCategory']])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->queryAll();
        $business_product_data = Yii::app()->db->createCommand()
            ->select('pc.product_id, p.name, p.description , p.image, p.price')
            ->from('product_category pc')
            ->join('product_info p','pc.product_id=p.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['TelecomProductBusinessCategory']])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->queryAll();

        if(!empty($_POST)){
            $telecom_user_details->setAttributes($_POST, false);
            $telecom_user_details->user_id = $user->user_id;
            $telecom_user_details->email = $user->email;
            $telecom_user_details->agent_id = $user->sponsor_id;
            $telecom_user_details->send_invoice_via = 'Email';
            $telecom_user_details->invoice_detail_type = 'Standard';
            $sponsor = UserInfo::model()->findByPk($user->sponsor_id);
            $telecom_user_details->agent_name = $sponsor->full_name;
            if(isset($_POST['cc_type']) && $_POST['cc_type'] != ''){
                $telecom_user_details->credit_card_type = $_POST['cc_type'];
                $telecom_user_details->credit_card_number = $_POST['cc_number'];
                $telecom_user_details->credit_card_name = $_POST['cc_name'];
                $telecom_user_details->expiry_date_month = $_POST['cc_exp_month'];
                $telecom_user_details->expiry_date_year = $_POST['cc_exp_year'];
            }
            if($telecom_details_present){
                $telecom_user_details->modified_at = date('Y-m-d H:i:s');
            }
            $telecom_user_details->save(false);

            if(isset($telecom_user_details->signature) && !empty($telecom_user_details->signature)){
                $telecom_account = new TelecomAccountDetails();
                $telecom_account->setAttributes($_POST, false);
                $telecom_account->user_id = $user->user_id;
                $telecom_account->email = $user->email;
                $telecom_account->telecom_request_status = 0;
                $telecom_account->save(false);

                //Registration PDF
                $filePath = $this->generateTelecomRegistrationPDF($telecom_account->user_id, $telecom_account->id);
                $registrationDocument = TelecomDocuments::model()->findByAttributes(['document_name' => 'Registration']);
                $telecomDocument = new TelecomUserDocuments();
                $telecomDocument->user_id = $telecom_account->user_id;
                $telecomDocument->document_id = $registrationDocument->document_id;
                $telecomDocument->document_path = $filePath;
                $telecomDocument->save(false);

                //Create PDF
                if($telecom_user_details->payment_method == 'SEPA'){
                    $filePath = $this->generateSEPAPDF($telecom_account->user_id, $_POST['sepa_signature']);
                    $sepaDocument = TelecomDocuments::model()->findByAttributes(['document_name' => 'SEPA']);
                    $telecomDocument = new TelecomUserDocuments();
                    $telecomDocument->user_id = $telecom_account->user_id;
                    $telecomDocument->document_id = $sepaDocument->document_id;
                    $telecomDocument->document_path = $filePath;
                    $telecomDocument->save(false);
                }
            }

            Yii::app()->user->setFlash('success', 'Account details changed successfully');
            $this->redirect(Yii::app()->createUrl('telecom/index'));
        } else {
            $telecom_account = new TelecomAccountDetails();
        }

        $countryArray = ServiceHelper::getCountry();
        $nationalityArray = ServiceHelper::getNationality();

        $this->render('create', [
            'user' => $user,
            'telecom_user_detail' => $telecom_user_details,
            'telecom_details_presence' => $telecom_details_present,
            'telecom_documents' => $telecom_documents,
            'telecom_account' => $telecom_account,
            'personal_products' => $personal_product_data,
            'business_products' => $business_product_data,
            'countryArray' => $countryArray,
            'nationalityArray' => $nationalityArray
        ]);

    }

    /*
     * Create a new mobile connection
     * Here, telecom user is already created
     * */
    public function actionNewconnection(){
        $user_id = Yii::app()->user->id;
        $user = UserInfo::model()->findByPk($user_id);
        $telecom_user_details = TelecomUserDetails::model()->findByAttributes(['user_id'=>$user_id]);
        $telecom_account = new TelecomAccountDetails();
        if(isset($telecom_user_details->business_name) && !empty($telecom_user_details->business_name)){
            $category_name = Yii::app()->params['TelecomProductBusinessCategory'];
            $telecom_account->rate = 'Iriscall';
        } else {
            $category_name = Yii::app()->params['TelecomProductPersonalCategory'];
            $telecom_account->rate = 'Iriscall Home';
        }

        if(isset($_GET['tariff_product_id'])){
            $tariff_product_id = $_GET['tariff_product_id'];
        } else {
            $tariff_product_id = '';
        }

        $product_data = Yii::app()->db->createCommand()
            ->select('pc.product_id, p.name, p.description , p.image, p.price')
            ->from('product_category pc')
            ->join('product_info p','pc.product_id=p.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->where('c.category_name=:cName', [':cName'=>$category_name])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->queryAll();

        if(!empty($_POST)){
            $telecom_account->setAttributes($_POST, false);
            $telecom_account->user_id = $user->user_id;
            $telecom_account->email = $user->email;
            $telecom_account->telecom_request_status = 0;
            $telecom_account->save(false);
            Yii::app()->user->setFlash('success', 'Account request added successfully');

            $this->redirect(Yii::app()->createUrl('telecom/index'));
        }

        $this->render('new-connection', [
            'user' => $user,
            'telecom_user_detail' => $telecom_user_details,
            'telecom_account' => $telecom_account,
            'tariff_product_id' => $tariff_product_id,
            'products' => $product_data
        ]);
    }

    /*public function generateTelecomRegistrationPDF($user_id, $telecom_account_id){
        set_time_limit(-1);
        $this->layout = false;
        $telecom_user_details = TelecomUserDetails::model()->findByAttributes(['user_id'=>$user_id]);
        //$telecom_account_details = TelecomAccountDetails::model()->findByPk($telecom_account_id);
        $telecom_account_details = Yii::app()->db->createCommand()
            ->select('*')
            ->from('telecom_account_details t')
            ->join('product_info p', 't.tariff_plan = p.product_id')
            ->where('t.id=:tId', [':tId' => $telecom_account_id])
            ->queryRow();
        $sepa_html = $this->render('registration-pdf', ['model' => $telecom_user_details, 'account' => $telecom_account_details], true);
        $final_html = '';
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Iriscall');
        $pdf->SetTitle('Iriscall');

        // set default header data
        //$pdf->SetHeaderData(REG_PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '', array(0,64,255), array(0,64,128));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '', array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        // if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        //     require_once(dirname(__FILE__).'/lang/eng.php');
        //     $pdf->setLanguageArray($l);
        // }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        //$pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();
        // Set some content to print
        // $html =
        // '<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
        // <i>This is the first example of TCPDF library.</i>
        // <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
        // <p>Please check the source code documentation and other examples for further information.</p>
        // <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>';

        $pdf->setJPEGQuality(75);
        // Print text using writeHTMLCell()

        //SEPA HTML VIEW
        $final_html .= $sepa_html;
        $pdf->writeHTML($final_html, true, false, true, false, '');

        //Signature
        $image = $telecom_user_details->signature;
        $imageContent = file_get_contents($image);
        $path = tempnam(sys_get_temp_dir(), 'prefix');
        file_put_contents ($path, $imageContent);
        $img = '<img src="' . $path . '">';
        $pdf->writeHTML($img, true, false, true, false, '');
        $pdf->Image('@' . $imageContent, '', '', '', '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // The '@' character is used to indicate that follows an image data stream and not an image file name
        //$pdf->Image('@'.$imgdata);
        //$pdf->Image('images/graph-product1.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

        //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $filename= "registration_".$telecom_user_details->user_id."_".$telecom_user_details->first_name.".pdf";
        $filelocation = "protected/runtime/uploads/registration/"; //Linux
        if (!is_dir($filelocation)) {
            mkdir($filelocation, 0755, true);
        }

        $relative_file_path = 'protected/runtime/uploads/registration/'.$filename;
        $fileNL = getcwd() .'/'. $relative_file_path; //Linux

        $pdf->Output($fileNL, 'F');
        return $relative_file_path;
        //============================================================+
        // END OF FILE
        //============================================================+
    } */

    public function generateTelecomRegistrationPDF($user_id, $telecom_account_id)
    {

        set_time_limit(-1);
        $this->layout = false;
        $telecom_user_details = TelecomUserDetails::model()->findByAttributes(['user_id'=>$user_id]);
        //$telecom_account_details = TelecomAccountDetails::model()->findByPk($telecom_account_id);
        $telecom_account_details = Yii::app()->db->createCommand()
            ->select('*')
            ->from('telecom_account_details t')
            ->join('product_info p', 't.tariff_plan = p.product_id')
            ->where('t.id=:tId', [':tId' => $telecom_account_id])
            ->queryRow();
        $html = $this->render('registration-pdf', ['model' => $telecom_user_details, 'account' => $telecom_account_details], true);

        $mPDF1 = new \Mpdf\Mpdf(['tempDir' => Yii::getPathOfAlias('application.runtime')]);

        $mPDF1->SetHTMLHeader('
        <table width="100%" style="vertical-align: top;">
        <tr><td align="right">
            <img style="width: 120px" src="/images/logos/iriscall-logo.svg"/>
            <img style="width: 120px" src="/images/logos/tellink-logo-2.png"/>
            <hr></td>
        </tr></table>');
        $mPDF1->SetHTMLFooter('
        <hr>
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;"><tr>
        <td align="right" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
        </tr></table>
        ');
        $mPDF1->AddPageByArray([
            'margin-top' => 35
        ]);
        $mPDF1->WriteHTML($html);

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/invoiceStyle.css');

        $mPDF1->WriteHTML($stylesheet, 1);

        // The '@' character is used to indicate that follows an image data stream and not an image file name
        // $pdf->Image('@'.$imgdata);
        // $pdf->Image('images/graph-product1.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

        // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $filename= "registration_".$telecom_user_details->user_id."_".$telecom_user_details->first_name.".pdf";
        $filelocation = "protected/runtime/uploads/registration/"; //Linux
        if (!is_dir($filelocation)) {
            mkdir($filelocation, 0755, true);
        }

        $relative_file_path = 'protected/runtime/uploads/registration/'.$filename;
        $fileNL = getcwd() .'/'. $relative_file_path; //Linux

        $mPDF1->Output($fileNL, 'F');
        return $relative_file_path;
        //============================================================+
        // END OF FILE
        //============================================================+
    }

    public function generateSEPAPDF($user_id, $sepa_signature){
        set_time_limit(-1);
        $this->layout = false;
        $telecom_user_details = TelecomUserDetails::model()->findByAttributes(['user_id'=>$user_id]);
        $sepa_html = $this->render('sepa-pdf', ['model' => $telecom_user_details], true);
        $final_html = '';
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Iriscall');
        $pdf->SetTitle('Iriscall');

        // set default header data
        $pdf->SetHeaderData(SEPA_PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '', array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        /*if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }*/

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        //$pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();
        // Set some content to print
        /*$html =
        '<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
        <i>This is the first example of TCPDF library.</i>
        <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
        <p>Please check the source code documentation and other examples for further information.</p>
        <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>';*/

        $pdf->setJPEGQuality(75);
        // Print text using writeHTMLCell()

        //SEPA Initial
        $final_html .= '<img src="images/SEPA_initial.png" >';
        //$pdf->Image('images/SEPA_initial.png', 15, 30, 180, '', 'PNG', '#', '', true, 150, '', false, false, 1, false, false, false);

        //SEPA HTML VIEW
        $final_html .= $sepa_html;
        $pdf->writeHTML($final_html, true, false, true, false, '');

        //Signature
        $image = $sepa_signature;
        $imageContent = file_get_contents($image);
        $path = tempnam(sys_get_temp_dir(), 'prefix');
        file_put_contents ($path, $imageContent);
        $img = '<img src="' . $path . '">';
        $pdf->writeHTML($img, true, false, true, false, '');
        $pdf->Image('@' . $imageContent, '', 210, '', '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // The '@' character is used to indicate that follows an image data stream and not an image file name
        //$pdf->Image('@'.$imgdata);
        //$pdf->Image('images/graph-product1.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

        //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $filename= "sepa_".$telecom_user_details->user_id."_".$telecom_user_details->first_name.".pdf";
        $filelocation = "protected/runtime/uploads/sepa/"; //Linux
        if (!is_dir($filelocation)) {
            mkdir($filelocation, 0755, true);
        }

        $relative_file_path = 'protected/runtime/uploads/sepa/'.$filename;
        $fileNL = getcwd() .'/'. $relative_file_path; //Linux

        $pdf->Output($fileNL, 'F');
        return $relative_file_path;
        //============================================================+
        // END OF FILE
        //============================================================+
    }

    /*
     * Upload files
     * */
    public function actionUploadfiles(){
        if(isset($_FILES)){
            $user_id = Yii::app()->user->id;
            UserHelper::uploadFiles($user_id, $_FILES);
        }
    }

    /*
     * Remove files
     * */
    public function actionRemovefiles(){
        if(isset($_POST)){
            $user_id = Yii::app()->user->id;

            //Default
            $documentId = $_POST['document_id'];
            if (isset($files['passport']['name'])) {
                $documentId = 1;
            }
            if (isset($files['sepa']['name'])) {
                $documentId = 2;
            }
            if (isset($files['articles_of_association']['name'])) {
                $documentId = 3;
            }
            UserHelper::deleteDocumentIfPresent($user_id, $documentId);
        }
    }
}
