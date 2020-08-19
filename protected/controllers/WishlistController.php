<?php

class WishlistController extends Controller
{
    public $layout = 'main';
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    protected function beforeAction($action)
    {
        if (Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->createUrl('home/login'));
        } /*else{
            $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->id]);
            if ($action->id != 'login'){
                if (Yii::app()->session['userid'] != $user->password){
                    $this->redirect(Yii::app()->createUrl('home/login'));
                }
            }
        }*/
        return parent::beforeAction($action);

    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $wishlist = array();
        $list = Wishlist::model()->findAllByAttributes(['user_id' => Yii::app()->user->getId()]);
        foreach ($list as $item){
            $listProduct = ProductInfo::model()->findByAttributes(['product_id' => $item->product_id]);
            // $sum[] = $item->qty*$listProduct ->price;
            $wishlist[] = [
                'product_id' => $listProduct ->product_id,
                'product_name' => $listProduct ->name,
                'product_price' => $listProduct ->price,
                'product_image' => $listProduct ->image,
                'product_summary' => $listProduct ->short_description,
            ];
        }

        $this->render('index',
            array(
                'wishlist' => $wishlist
            ));
    }

    public function actionRemoveCart()
    {
        if (isset($_POST['id'])){
            $check = Yii::app()->db->createCommand(" DELETE FROM `wishlist` WHERE product_id = " .$_POST['id'] )->execute();
            $count = Wishlist::model()->findAll();
            if ($check){
                echo json_encode([
                    'token' => 1,
                    'wishCount' => count($count),
                    'id' =>$_POST['id']
                ]);
            }
        }

    }

    public function actionAddToCart()
    {
        if (isset($_POST['id'])){
            $product = ProductInfo::model()->findByAttributes(['product_id' => $_POST['id']]);
            $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
            $checkCart = Cart::model()->findByAttributes(['user_id' => Yii::app()->user->getId(), 'product_id' => $_POST['id']]);
            if ($checkCart){
                $checkCart->qty = $checkCart->qty+1;
                if($checkCart->save()){
                    Yii::app()->db->createCommand("DELETE FROM `wishlist` WHERE user_id = $user->user_id AND product_id =  $product->product_id")->execute();
                    $cartItem = Cart::model()->findAllByAttributes(['user_id' => $user->user_id]);
                    $count = count($cartItem);
                    echo json_encode([
                        'token' => 1,
                        'cartCount' => $count,
                        'msg' => $product->name." added to cart"
                    ]);
                }else{
                    echo json_encode([
                        'token' => 0
                    ]);
                }
            }else{
                $cart = new Cart();
                $cart->product_id = $product->product_id;
                $cart->user_id = $user->user_id;
                $cart->qty = 1;
                $cart->amount = $product->price;
                $cart->created_at = date('Y-m-d H:i:s');

                if($cart->save()){
                    Yii::app()->db->createCommand("DELETE FROM `wishlist` WHERE user_id = $user->user_id AND product_id =  $product->product_id")->execute();
                    $cartItem = Cart::model()->findAllByAttributes(['user_id' => $user->user_id]);
                    $count = count($cartItem);
                    echo json_encode([
                        'token' => 1,
                        'cartCount' => $count,
                        'msg' => $product->name." added to cart"
                    ]);
                }else{
                    echo json_encode([
                        'token' => 0
                    ]);
                }
            }
        }
    }

}