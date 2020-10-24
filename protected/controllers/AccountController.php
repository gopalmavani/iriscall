<?php

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

    /*
     * Upload files
     * */
    public function actionUploadfiles(){
        if(isset($_FILES)){
            $user_id = Yii::app()->user->id;
            UserHelper::uploadFiles($user_id, $_FILES);
        }
    }
}
