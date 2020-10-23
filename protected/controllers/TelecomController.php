<?php

class TelecomController extends Controller
{
    public $layout = 'main';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
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
     * Index page
     */
    public function actionIndex(){
        $user = UserInfo::model()->findByPk(Yii::app()->user->Id);
        $telecom_user = TelecomUserDetails::model()->findByAttributes(['user_id'=>$user->user_id]);

        if(isset($telecom_user->user_id)){
            $telecom_accounts = TelecomAccountDetails::model()->findAllByAttributes(['user_id' => $telecom_user->user_id]);
            $this->render('index', [
                'telecom_user' => $telecom_user,
                'telecom_accounts' => $telecom_accounts
            ]);
        } else {
            $this->redirect(Yii::app()->createUrl('telecom/pricing'));
        }
    }

    /*
     * Product pricing for telecom products
     * */
    public function actionPricing(){
        $user = UserInfo::model()->findByPk(Yii::app()->user->Id);
        $product_data = Yii::app()->db->createCommand()
            ->select('pc.product_id, p.name, p.description , p.image, p.price')
            ->from('product_category pc')
            ->join('product_info p','pc.product_id=p.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['TelecomProductCategory']])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->queryAll();

        $cartData = Yii::app()->db->createCommand()
            ->select('c.product_id, c.cart_id, name, p.image, qty, amount')
            ->from('cart c')
            ->join('product_info p','c.product_id=p.product_id')
            ->where('user_id=:uId', [':uId'=>Yii::app()->user->getId()])
            ->queryAll();

        $telecom_accounts = TelecomAccountDetails::model()->findAllByAttributes(['user_id' => $user->user_id]);
        if(count($telecom_accounts) > 0){
            $first_account = false;
        } else {
            $first_account = true;
        }

        $this->render('pricing',
            array(
                'products' => $product_data,
                'user' => $user,
                'cartData' => $cartData,
                'first_account' => $first_account
            )
        );
    }

    /*
     * View Telecom details
     * */
    public function actionView($id){
        $telecom_user = TelecomUserDetails::model()->findByPk($id);

        $this->render('view', [
            'model' => $telecom_user
        ]);
    }
}
