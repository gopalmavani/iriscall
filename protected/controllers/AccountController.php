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
        if (Yii::app()->user->isGuest && $action->id != 'receiveStripeHooks'){
            $this->redirect(Yii::app()->createUrl('home/login'));
        }
        return parent::beforeAction($action);

    }

    /**
     * Create account
     * for a mobile connection
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
            $telecom_user_details->attributes = $_POST;
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

            if(isset($_POST['phone_number']) && $_POST['phone_number'] != ''){
                $telecom_account = TelecomAccountDetails::model()->findByAttributes(['user_id'=>$user_id, 'phone_number'=>$_POST['phone_number']]);
                if(isset($telecom_account->phone_number)){
                    $telecom_account->modified_at = date('Y-m-d H:i:s');
                } else {
                    $telecom_account = new TelecomAccountDetails();
                }
                $telecom_account->attributes = $_POST;
                $telecom_account->user_id = $user->user_id;
                $telecom_account->email = $user->email;
                $telecom_account->save(false);
            } else {
                $telecom_account = new TelecomAccountDetails();
            }
            Yii::app()->user->setFlash('success', 'Account details changed successfully');
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
     * Upload files
     * */
    public function actionUploadfiles(){
        if(isset($_FILES)){
            $user_id = Yii::app()->user->id;
            $uploadDir = 'uploads/'.$user_id.'/';
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
