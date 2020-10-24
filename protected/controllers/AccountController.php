<?php
require_once ('plugins/tcpdf_min/tcpdf.php');
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
        if (Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->createUrl('home/login'));
        }
        return parent::beforeAction($action);

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
            //$telecom_accounts = TelecomAccountDetails::model()->findAllByAttributes(['user_id'=>$user_id]);
        } else {
            $telecom_user_details = new TelecomUserDetails();
            $telecom_user_details->setAttributes($user->attributes, false);

            $userPayoutInfo = UserPayoutInfo::model()->findByAttributes(['user_id'=>$user_id]);
            if(isset($userPayoutInfo->user_id)){
                $telecom_user_details->setAttributes($userPayoutInfo->attributes, false);
            }
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
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['TelecomProductCategory']])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->queryAll();

        if(!empty($_POST)){
            $telecom_user_details->setAttributes($_POST, false);
            $telecom_user_details->user_id = $user->user_id;
            $telecom_user_details->email = $user->email;
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

            $telecom_account = new TelecomAccountDetails();
            $telecom_account->setAttributes($_POST, false);
            $telecom_account->user_id = $user->user_id;
            $telecom_account->email = $user->email;
            $telecom_account->telecom_request_status = 0;
            $telecom_account->save(false);

            Yii::app()->user->setFlash('success', 'Account details changed successfully');
            $this->redirect(Yii::app()->createUrl('telecom/index'));
        } else {
            $telecom_account = new TelecomAccountDetails();
        }

        $this->render('create', [
            'user' => $user,
            'telecom_user_detail' => $telecom_user_details,
            'telecom_details_presence' => $telecom_details_present,
            'telecom_documents' => $telecom_documents,
            'telecom_account' => $telecom_account,
            'tariff_product_id' => $tariff_product_id,
            'products' => $product_data
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
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['TelecomProductCategory']])
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

    public function actionGeneratePDF(){
        set_time_limit(-1);
        $this->layout = false;
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
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
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

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

        // set text shadow effect
        //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        // Set some content to print
        /*$html =
        '<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
        <i>This is the first example of TCPDF library.</i>
        <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
        <p>Please check the source code documentation and other examples for further information.</p>
        <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>';*/

        $pdf->setJPEGQuality(75);
        // Print text using writeHTMLCell()
        $image = 'data:image/png;base64,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';
        $imageContent = file_get_contents($image);
        $path = tempnam(sys_get_temp_dir(), 'prefix');

        file_put_contents ($path, $imageContent);

//        print('<pre>');
//        print $path;
//        //print $imageContent;
//        exit;
        $img = '<img src="' . $path . '">';
        $pdf->writeHTML($img, true, false, true, false, '');
        $pdf->Image('@' . $imageContent, 55, 19, '', '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        //$encodedData = str_replace(' ','+',$image);
        //$imgdata = base64_decode($encodedData);

        // The '@' character is used to indicate that follows an image data stream and not an image file name
        //$pdf->Image('@'.$imgdata);
        //$pdf->Image('images/graph-product1.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

        //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_001.pdf', 'I');

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
            $uploadDir = 'protected/runtime/uploads/'.$user_id.'/';
            if(!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            if(isset($_FILES['passport']['name'])){
                $uploadFile = $uploadDir . basename($_FILES['passport']['name']);
                $documentId = 1;
                if(move_uploaded_file($_FILES['passport']['tmp_name'], $uploadFile)){
                    $documentPath = $uploadDir . $_FILES['passport']['name'];
                    $this->addDocumentPathToDB($user_id, $documentId, $documentPath);
                }
            }
            if(isset($_FILES['sepa']['name'])){
                $uploadFile = $uploadDir . basename($_FILES['sepa']['name']);
                $documentId = 2;
                if(move_uploaded_file($_FILES['sepa']['tmp_name'], $uploadFile)){
                    $documentPath = $uploadDir . $_FILES['sepa']['name'];
                    $this->addDocumentPathToDB($user_id, $documentId, $documentPath);
                }
            }
            if(isset($_FILES['articles_of_association']['name'])){
                $uploadFile = $uploadDir . basename($_FILES['articles_of_association']['name']);
                $documentId = 3;
                if(move_uploaded_file($_FILES['articles_of_association']['tmp_name'], $uploadFile)){
                    $documentPath = $uploadDir . $_FILES['articles_of_association']['name'];
                    $this->addDocumentPathToDB($user_id, $documentId, $documentPath);
                }
            }
        }
    }

    protected function addDocumentPathToDB($userId, $documentId, $documentPath){
        $document = new TelecomUserDocuments();
        $document->user_id = $userId;
        $document->document_id = $documentId;
        $document->document_path = $documentPath;
        $document->save(false);
    }
}
