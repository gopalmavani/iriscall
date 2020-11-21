<?php
require_once Yii::app()->basePath . '/vendors/stripe-php/init.php';
class ProductController extends Controller
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
        //Action that needs to be allowed for guest user
        $allowedActionArr = ['getVatPercentage'];
        if (Yii::app()->user->isGuest && !in_array($action->id, $allowedActionArr)) {
            $this->redirect(Yii::app()->createUrl('home/login'));
        }
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
        $cashback_product_data = Yii::app()->db->createCommand()
            ->select('pc.product_id, p.name, p.description , p.image, p.price')
            ->from('product_category pc')
            ->join('product_info p','pc.product_id=p.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['CashbackProductCategory']])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->queryAll();

        $trading_product_data_ids = Yii::app()->db->createCommand()
            ->select('pc.product_id')
            ->from('product_category pc')
            ->join('product_info p','pc.product_id=p.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['TradingProductCategory']])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->queryColumn();

        $user = UserInfo::model()->findByPk(Yii::app()->user->Id);
        //For temporary basis, we will be going with only one voucher at a time
        $available_vouchers = VoucherHelper::getAvailableVouchers($user->email);

        if(!is_null($user->street) && ($user->street != '') && !is_null($user->country) && ($user->country != '') && !is_null($user->city) && ($user->city != '')){
            $checkout_eligible = 'true';
        } else {
            $checkout_eligible = 'false';
        }

        if(empty($user->business_name )){
            $companyAdd = false;
        }else{
            $companyAdd = true;
        }

        //Reserve Wallet
        $reserve_wallet_balance = WalletHelper::getReserveWalletBalance($user->user_id);
        //User Wallet
        $user_wallet_balance = WalletHelper::getUserWalletEarnings($user->user_id);
        $total_available_balance = $reserve_wallet_balance + $user_wallet_balance;

        $cartData = Yii::app()->db->createCommand()
            ->select('c.product_id, c.cart_id, name, p.image, qty, amount')
            ->from('cart c')
            ->join('product_info p','c.product_id=p.product_id')
            ->where('user_id=:uId', [':uId'=>Yii::app()->user->getId()])
            ->queryAll();

        $this->render('index',
            array(
                'product' => $cashback_product_data,
                'trading_product_data_ids' => json_encode($trading_product_data_ids),
                'checkout_eligible' => $checkout_eligible,
                'companyAdd' => $companyAdd,
                'user' => $user,
                'cartData' => $cartData,
                'reserve_wallet_balance' => $reserve_wallet_balance,
                'user_wallet_balance' => $user_wallet_balance,
                'total_available_balance' => $total_available_balance,
                'available_vouchers' => $available_vouchers
            )
        );
    }

    /*
     * Product pricing page
     * */
    public function actionPricing()
    {
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

        $this->render('pricing',
            array(
                'products' => $product_data,
                'user' => $user,
                'cartData' => $cartData
            )
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionCancel()
    {
        $this->render('cancel');
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionException()
    {
        $this->render('exception');
    }

    public function actionDetail($id)
    {
        $product = ProductInfo::model()->findByAttributes(['product_id' => $id]);
        $this->render('detail',
            array(
                'product' => $product
            ));
    }

    //Checkout action
    public function actionCheckout($id){
        //Required for ajax purpose
        $product = Yii::app()->db->createCommand()
            ->select('*')
            ->from('product_info')
            ->where('product_id=:pId',[':pId'=>$id])
            ->queryRow();
        $userId = Yii::app()->user->Id;

        //Required for ajax purpose
        $userDetails = Yii::app()->db->CreateCommand()
            ->select('*')
            ->from('user_info')
            ->where('user_id=:id',[':id'=>$userId])
            ->queryRow();

        if(!empty($userDetails['business_name'])){
            $isBusinessEnabled = 1;
        }
        else{
            $isBusinessEnabled = 0;
        }
        $payments = Payment::model()->findAll();

        //Get Latest order ID
        $order = OrderInfo::model()->find(array('order' => 'order_id DESC'));
        if ($order == '') {
            $orderId = 1;
        } else {
            $orderId = $order['order_id'] + 1;
        }

        /*if(date('Y-m-d H:i:s') >= $product['sale_start_date'] && date('Y-m-d H:i:s') <= $product['sale_end_date'])
            $finalPrice = $product['sale_price'];
        else
            $finalPrice = $product['price'];*/
        $this->render('checkout',
            array(
                'product' => $product,
                //'finalPrice' => $finalPrice,
                'payments' => $payments,
                'isBusinessEnabled' => $isBusinessEnabled,
                'orderId' => $orderId,
                'userDetail' => $userDetails
            ));
    }

    public function actionAddToCart()
    {
        $product = ProductInfo::model()->findByAttributes(['product_id' => $_POST['id']]);
        $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
        $checkCart = Cart::model()->findByAttributes(['user_id' => Yii::app()->user->getId(), 'product_id' => $_POST['id']]);
        if ($checkCart){
            $checkCart->qty = $checkCart->qty+1;
            if($checkCart->save()){
                $cartItem = Cart::model()->findAllByAttributes(['user_id' => $user->user_id]);
                $count = count($cartItem);
                $_SESSION['addalCart'] = $product->name." added to cart";
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
                $cartItem = Cart::model()->findAllByAttributes(['user_id' => $user->user_id]);
                $count = count($cartItem);
                $_SESSION['addCart'] = $product->name." added to cart";
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

    public function actionAddToWishlist()
    {
        $product = ProductInfo::model()->findByAttributes(['product_id' => $_POST['id']]);
        $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
        $checkWishlist = Wishlist::model()->findByAttributes(['user_id' => Yii::app()->user->getId(), 'product_id' => $_POST['id']]);
        if ($checkWishlist){
            $_SESSION['allWish'] = $product->name." is already in wishlist";
            echo json_encode([
                'token' => 0,
                'msg' => $product->name." is already in wishlist"
            ]);

        }else{
            $wishlist = new Wishlist();
            $wishlist->product_id = $product->product_id;
            $wishlist->user_id = $user->user_id;
            $wishlist->created_at = date('Y-m-d H:i:s');

            if($wishlist->save()){
                $_SESSION['addWish'] = $product->name." added to wishlist successfully";
                echo json_encode([
                    'token' => 1,
                    'msg' => $product->name." added to wishlist"
                ]);
            }else{
                echo json_encode([
                    'token' => 0
                ]);
            }
        }


    }

    public function actionRemoveFromCart()
    {
        $sum = [];
        $res = Yii::app()->db->createCommand()
            ->delete('cart','product_id=:pId and user_id=:uId',[':pId'=>$_POST['id'], ':uId'=>Yii::app()->user->getId()]);

        $cart = Cart::model()->findAllByAttributes(['user_id' => Yii::app()->user->getId()]);
        foreach ($cart as $carts){
            $cartProduct = ProductInfo::model()->findByAttributes(['product_id' => $carts->product_id]);
            $sum[] = $carts->qty*$cartProduct->price;
        }
        $cartItem = Cart::model()->findAllByAttributes(['user_id' => Yii::app()->user->getId()]);
        if(1 == 1){
            echo json_encode([
                'token'=> 1,
                'cartCount' => count($cartItem),
                'cartTotal' => array_sum($sum),
                'id'=> $_POST['id']
            ]);
        }else{
            echo json_encode([
                'token' => 0
            ]);
        }
    }

    public function actionResetCart()
    {
        Yii::app()->db->createCommand()->truncateTable('cart');
        $cart = Cart::model()->findAll();
        if (!$cart){
            echo json_encode([
                'token' => 1
            ]);
        }else{
            echo json_encode([
                'token' =>0
            ]);
        }
    }

    //Action to get vat percentage
    public function actionGetVatPercentage(){
        $country_id = $_POST['country_id'];
        if($country_id == ''){
            echo '0';
        } else {
            $vat_type = $_POST['vat_type'];
            if($vat_type == 'personal'){
                $vat = Countries::model()->findByPk($country_id)->personal_vat;
            } else {
                $vat = Countries::model()->findByPk($country_id)->business_vat;
            }
            echo $vat;
        }
    }

    //Action to get next license Id from product_pricing_table
    public function actionGetLicenseId(){
        $license = $_POST["licenseNum"];
        if(!empty($license)){
            $product_pricing = Yii::app()->db->createCommand()
                ->select('*')
                ->from('product_pricing')
                ->where('licenses=:l',[':l'=>$license])
                ->order('licenses asc')
                ->queryRow();
            if(isset($product_pricing['id'])){
                echo json_encode([
                    'present' => true,
                    'id' => $product_pricing['id'],
                    'product_price' => $product_pricing['price_per_license']
                ]);
            } else {
                $next_product_id = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('product_pricing')
                    ->where('licenses>=:l',[':l'=>$license])
                    ->order('licenses asc')
                    ->queryRow();
                $previous_product_pricing = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('product_pricing')
                    ->where('licenses<=:l',[':l'=>$license])
                    ->order('licenses desc')
                    ->queryRow();
                echo json_encode([
                    'present' => false,
                    'id' => (int)$next_product_id['id'],
                    'product_price' => $previous_product_pricing['price_per_license']
                ]);
            }
        } else {
            echo "0";
        }
    }

    //Action to license price based upon licenseNumber
    public function actionGetLicensePrice(){
        $license = $_POST["licenseNum"];
        $product_id = $_POST["product_id"];
        if(!empty($license) && $license != 0 && !empty($product_id)){
            $array = ServiceHelper::getDiscountedPrice($license, $product_id);
            echo json_encode([
                'id' => (int)$product_id,
                'subTotal' => $array['subTotal'],
                'discount' => $array['discount'],
                'itemPrice' => $array['item_price']
            ]);
        } else {
            echo json_encode([
                'id' => 0,
                'subTotal' => 0,
                'discount'=>0,
                'itemPrice' => 0
            ]);
        }
    }
}
