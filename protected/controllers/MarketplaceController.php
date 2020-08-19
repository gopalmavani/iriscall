<?php

class MarketplaceController extends Controller
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
        if (Yii::app()->user->isGuest) {
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
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $user = UserInfo::model()->findByPk(Yii::app()->user->Id);
        if(!empty($_POST)){
            if(!empty($_POST['deposit'])){
                $this->redirect(array('marketplace/product', 'product_id'=>$_POST['product_id'], 'deposit'=>$_POST['deposit']));
            }else{
                $this->redirect(array('marketplace/product', 'product_id'=>$_POST['product_id']));
            }
        }
        /*
         * For 8780 - 'PHN_UK_TL3I_EUR', 'PHN_UK_TL_I_EUR'
         * For 8915 - 'PHN_UK_TUM_EUR'
         * */
        //To check if the trading product is already bought
        $requiredGroups = ['PHN_UK_TL3I_EUR', 'PHN_UK_TL_I_EUR', 'PHN_UK_TUM_EUR'];
        $cbmAccountAgents = Yii::app()->db->createCommand()
            ->select('agent')
            ->from('cbm_accounts')
            ->where('email_address=:ea', [':ea'=>$user->email])
            ->andWhere(['in', 'group', $requiredGroups])
            ->queryColumn();

        $prodData = Yii::app()->db->createCommand()
            ->select('pc.product_id, p.name, p.description, ai.minimum_deposit, p.image, p.price')
            ->from('product_category pc')
            ->join('product_info p','pc.product_id=p.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->join('agent_info ai','p.agent=ai.agent_number')
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['TradingProductCategory']])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->andWhere(['not in', 'agent_number', $cbmAccountAgents])
            ->queryAll();

        $this->render('index',[
            'products' => $prodData,
            'user' => $user,
        ]);
    }

    /*
     * Second step of e-commerce displaying trip and cart items
     * */
    public function actionProduct()
    {
        $user = UserInfo::model()->findByPk(Yii::app()->user->Id);
        // create product details associative array from unstructured array
        if(!empty($_POST)){
            $product_ids = $_POST['product_id'];
            $product_qty = $_POST['step2_qty'];
            $product_price = $_POST['price'];
            $product_total = $_POST['total_amount'];
            $products_array = [];
            array_push($products_array,array(
                    "product_id"=>$product_ids[0],
                    "qty"=>$product_qty[0],
                    "price"=>$product_price[0],
                    "total"=>$product_total[0],
                )
            );
            if(isset($product_ids[1])){
                array_push($products_array,array(
                        "product_id"=>$product_ids[1],
                        "qty"=>$product_qty[1],
                        "price"=>$product_price[1],
                        "total"=>$product_total[1],
                    )
                );
            }

            if(!empty($products_array)){
                foreach ($products_array as $product){
                    $checkCart = Cart::model()->findByAttributes(['user_id' => $user->user_id, 'product_id' => $product['product_id']]);
                    $cashback_product_data = Yii::app()->db->createCommand()
                        ->select('p.product_id, price')
                        ->from('product_category pc')
                        ->join('product_info p','pc.product_id=p.product_id')
                        ->join('categories c','c.category_id=pc.category_id')
                        ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['CashbackProductCategory']])
                        ->queryRow();

                    /*if($product['product_id'] == $cashback_product_data['product_id']){
                        $response = ServiceHelper::getDiscountedPrice($product['qty'], $product['product_id']);
                        $product['price'] = $response['item_price'];
                    }*/

                    if (isset($checkCart->cart_id)) {
                        $checkCart->qty = $product['qty'];
                        $checkCart->amount = $product['total'];
                        $checkCart->modified_at = date('Y-m-d H:i:s');
                        $checkCart->save();
                    } else {
                        $cart = new Cart();
                        $cart->product_id = $product['product_id'];
                        $cart->user_id = $user->user_id;
                        $cart->qty = $product['qty'];
                        $cart->amount = $product['total'];
                        $cart->created_at = date('Y-m-d H:i:s');
                        $cart->save();
                    }
                }
                $this->redirect('checkout');
            }
        } else {
            if(isset($_GET['product_id'])){
                $product_id = $_GET['product_id'];
                if(isset($_GET['deposit'])){
                    $deposit = $_GET['deposit'];
                } else {
                    $deposit = 0;
                }
                //cashback product data
                $cashback_product_data = Yii::app()->db->createCommand()
                    ->select('p.product_id as cashback_product_id, price as cashback_product_price')
                    ->from('product_category pc')
                    ->join('product_info p','pc.product_id=p.product_id')
                    ->join('categories c','c.category_id=pc.category_id')
                    ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['CashbackProductCategory']])
                    ->queryRow();

                //trading product data
                $trading_product_data = Yii::app()->db->createCommand()
                    ->select('pi.product_id, price, minimum_self_node_balance, self_node_license_count, minimum_profit_node_balance')
                    ->from('product_info pi')
                    ->join('agent_info ai','ai.agent_number=pi.agent')
                    ->where('product_id=:pId', [':pId'=>$_GET['product_id']])
                    ->queryRow();

                $product_pricing = ProductPricing::model()->findAll();
                $trading_pricing_array = [];
                $licenses_pricing_array = [];
                $trip_id = '';
                if($deposit != 0){
                    $required_nodes = floor($deposit/$trading_product_data['minimum_self_node_balance']);
                    $required_licenses_for_node_by_deposit = $required_nodes * $trading_product_data['self_node_license_count'];
                    $price_per_license = ServiceHelper::getDiscountedPrice($required_licenses_for_node_by_deposit, $cashback_product_data['cashback_product_id']);
                } else {
                    $required_nodes = 0;
                    $required_licenses_for_node_by_deposit = 0;
                    $price_per_license = 0;
                }
                foreach ($product_pricing as $prod_price){
                    if($trip_id == ''){
                        if($prod_price->licenses * $trading_product_data['minimum_self_node_balance'] == $deposit){
                            $present = true;
                            $trip_id = $prod_price->id;
                        }else{
                            if($deposit == 0 && $prod_price->id == 1){
                                $present = true;
                                $trip_id = $prod_price->id;
                            } else {
                                $present = false;
                                $trip_id = 'new';
                            }
                        }
                    } else {
                        $present = false;
                    }

                    $required_licenses_for_node = $prod_price->licenses * $trading_product_data['self_node_license_count'];
                    $price_per_license_for_cluster = ServiceHelper::getDiscountedPrice($required_licenses_for_node, $cashback_product_data['cashback_product_id']);
                    array_push($licenses_pricing_array,[
                        'licenses' => $required_licenses_for_node,
                        'id' => $prod_price->id,
                        'node_cost' => $required_licenses_for_node * $price_per_license_for_cluster['item_price'],
                        'license_price'=>$price_per_license_for_cluster['item_price'],
                        'present'=>$present,
                    ]);

                    array_push($trading_pricing_array,[
                        'licenses' => $prod_price->licenses,
                        'id' => $prod_price->id,
                        'capital_deposit' => $prod_price->licenses * $trading_product_data['minimum_self_node_balance'],
                        'is_cluster'=>1,
                        'present'=>$present,
                    ]);
                }

                if($trip_id == 'new'){
                    array_push($licenses_pricing_array,[
                        'licenses' => $required_licenses_for_node_by_deposit,
                        'id' => $trip_id,
                        'node_cost' => $required_licenses_for_node_by_deposit * $price_per_license['item_price'],
                        'license_price'=>$price_per_license['item_price'],
                        'present'=>false,
                    ]);

                    array_push($trading_pricing_array,[
                        'licenses' => $required_nodes,
                        'id' => $trip_id,
                        'capital_deposit' => $deposit,
                        'is_cluster'=>0,
                        'present'=>false,
                    ]);
                }
                usort($trading_pricing_array, [$this, 'sortByLicenses']);
                usort($licenses_pricing_array, [$this, 'sortByLicenses']);

                //Check trading product presence in cart
                $trading_product_cart_presence =  Cart::model()->findByAttributes(['user_id' => $user->user_id, 'product_id' => $trading_product_data['product_id']]);
                if(!isset($trading_product_cart_presence->cart_id)){
                    $cart = new Cart();
                    $cart->product_id = $trading_product_data['product_id'];
                    $cart->user_id = $user->user_id;
                    //Quantity of Trading product is always one
                    $cart->qty = 1;
                    $cart->amount = 1 * $trading_product_data['price'];
                    $cart->created_at = date('Y-m-d H:i:s');
                    $cart->save(false);
                }

                if($deposit != 0){
                    $cashback_product_cart_presence = Cart::model()->findByAttributes(['user_id' => $user->user_id, 'product_id' => $cashback_product_data['cashback_product_id']]);
                    if(!isset($cashback_product_cart_presence->cart_id)){
                        $cart = new Cart();
                        $cart->product_id = $cashback_product_data['cashback_product_id'];
                        $cart->user_id = $user->user_id;
                        $cart->qty = $required_licenses_for_node_by_deposit;
                        $cart->amount = $required_licenses_for_node_by_deposit * $price_per_license['item_price'];
                        $cart->created_at = date('Y-m-d H:i:s');
                        $cart->save(false);
                    } else {
                        if($cashback_product_cart_presence->qty < $required_licenses_for_node_by_deposit){
                            $cashback_product_cart_presence->qty =  $required_licenses_for_node_by_deposit;
                            $cashback_product_cart_presence->amount = $required_licenses_for_node_by_deposit * $price_per_license['item_price'];
                            $cashback_product_cart_presence->modified_at = date('Y-m-d H:i:s');
                            $cashback_product_cart_presence->save(false);
                        }
                    }
                }
                //print_r($licenses_pricing_array);print_r($trading_pricing_array);
                //exit;
                $cartItem = Yii::app()->db->createCommand()
                    ->select('pi.product_id,c.qty,c.amount,pi.image,pi.name,pi.description')
                    ->from('cart c')
                    ->join('product_info pi','pi.product_id=c.product_id')
                    ->where('user_id=:uId', [':uId'=>$user->user_id])
                    ->queryAll();

                $this->render('product', [
                    'product_id'=>$product_id,
                    'user' => $user,
                    'trading_product' => $trading_product_data,
                    'cashback_product' => $cashback_product_data,
                    'trading_pricing_array'=>$trading_pricing_array,
                    'licenses_pricing_array'=>$licenses_pricing_array,
                    'trip_id'=>$trip_id,
                    'deposit'=>$deposit,
                    'cartItem'=>$cartItem,
                    'present'=>$present,
                    'profit_node_balance'=>$trading_product_data['minimum_profit_node_balance']
                ]);
            }
            /*$prodData = array_merge($trading_prodData,$cashbackprodData);
            $license_per_price = $prodData['minimum_self_node_balance'];
            $cashbacklicense_per_price = $prodData['cashback_product_price'];
            $i = 1;
            $license_n_ids = '';
            if(isset($_GET['deposit'])){
                foreach ($product_pricing as $prod_price){
                    $present = '';

                    $license_price = $prod_price->licenses*$license_per_price;
                    $license_n_ids =  $deposit / $license_per_price;

                    if($prod_price->licenses*$license_per_price == $_GET['deposit']){
                        $present = true;
                        $trip_id = $i;
                    }else{
                        $present = false;
                        $trip_id = 'new';
                    }
                    array_push($trading_pricing_array,[
                        'licenses'=>$prod_price->licenses,
                        'id'=>$i,
                        'price_per_license'=>$prod_price->licenses*$license_per_price,
                        'is_cluster'=>1,
                        'present'=>$present,
                    ]);
                    $license = $prod_price->licenses*$prodData['self_node_license_count'];
                    $array = $this->Getpricediscount($license,$cashbacklicense_per_price,$product_id);

                    array_push($licenses_pricing_array,[
                        'licenses'=>$license,
                        'id'=>$i,
                        'price_per_license'=>$license*$cashbacklicense_per_price,
                        'license_price'=>$cashbacklicense_per_price-$array['discount'],
                        'present'=>$present,
                    ]);
                    $i++;
                }

                if(array_search(100, array_column($trading_pricing_array, 'present')) !== False) {
                    $present = true;
                    $trip_id = '';
                    foreach ($trading_pricing_array as $treding){
                        if($treding['present'] == 1){
                            $trip_id = $treding['id'];
                        }
                    }
                } else {
                    $present = false;
                    $license_n_ids = intval($license_n_ids);
                    array_push($trading_pricing_array,[
                        'licenses'=> $license_n_ids,
                        'id'=>'new',
                        //'price_per_license'=>$prodData['price']*intval($license_n_ids),
                        'price_per_license'=>$deposit,
                        'is_cluster'=>0,
                        'present'=>$present,
                    ]);
                    $cashbacke_price = $cashbackprodData['cashback_product_price'];
                    $license_n_ids = $license_n_ids*$prodData['self_node_license_count'];

                    $array = $this->Getpricediscount($license_n_ids,$cashbacke_price,$cashbackprodData['cashback_product_id']);

                    array_push($licenses_pricing_array,[
                        'licenses'=>$license_n_ids,
                        'id'=>'new',
                        'price_per_license'=>$cashbacklicense_per_price*$license_n_ids,
                        'license_price'=>$cashbacklicense_per_price-$array['discount'],
                        'present'=>$present,
                    ]);
                }
                $keys = array_column($trading_pricing_array, 'licenses');
                array_multisort($keys, SORT_ASC, $trading_pricing_array);

                $keys2 = array_column($licenses_pricing_array, 'licenses');
                array_multisort($keys2, SORT_ASC, $licenses_pricing_array);
            }else{
                // without deposit section
                $i = 1;
                foreach ($product_pricing as $prod_price){
                    $present = '';
                    $license_price = $prod_price->licenses*$license_per_price;
                    $license_n_ids =  $license_per_price;
                    if($i == 1){
                        $present = true;
                        $trip_id = $i;
                    }
                    array_push($trading_pricing_array,[
                        'licenses'=>$prod_price->licenses,
                        'id'=>$i,
                        'price_per_license'=>$prod_price->licenses*$license_per_price,
                        'is_cluster'=>1,
                        'present'=>$present,
                    ]);
                    $license = $prod_price->licenses;
                    $license = $license*$prodData['self_node_license_count'];
                    $array = $this->Getpricediscount($license,$cashbacklicense_per_price,$product_id);

                    array_push($licenses_pricing_array,[
                        'licenses'=>$license,
                        'id'=>$i,
                        'price_per_license'=>$license*$cashbacklicense_per_price,
                        'license_price'=>$cashbacklicense_per_price-$array['discount'],
                        'present'=>$present,
                    ]);
                    $i++;
                }
                $deposit = '';
                $present = true;
                $trip_id = 1;
            }

            // update cart section here as per licenses and quantity
            if(isset($_GET['product_id']) && isset($_GET['deposit'])) {
                $product = ProductInfo::model()->findByAttributes(['product_id' => $_GET['product_id']]);
                $checkCart = Cart::model()->findByAttributes(['user_id' => Yii::app()->user->getId(), 'product_id' => $_GET['product_id']]);
                if ($checkCart) {
                } else {
                    $cart = new Cart();
                    $cart->product_id = $product->product_id;
                    $cart->user_id = $user->user_id;
                    $cart->qty = 1;
                    $cart->amount = 1*$product->price;
                    $cart->created_at = date('Y-m-d H:i:s');
                    $cart->save();
                }
                $product = ProductInfo::model()->findByAttributes(['product_id' => $prodData['cashback_product_id']]);
                $checkCart = Cart::model()->findByAttributes(['user_id' => Yii::app()->user->getId(), 'product_id' => $prodData['cashback_product_id']]);
                if ($checkCart) {
                } else {
                    $cart = new Cart();
                    $cart->product_id = $product->product_id;
                    $cart->user_id = $user->user_id;
                    $cart->qty = 1;
                    $cart->amount = 1*$product->price;
                    $cart->created_at = date('Y-m-d H:i:s');
                    $cart->save();
                }
            }else{
                $product = ProductInfo::model()->findByAttributes(['product_id' => $_GET['product_id']]);
                $checkCart = Cart::model()->findByAttributes(['user_id' => Yii::app()->user->getId(), 'product_id' => $_GET['product_id']]);
                if ($checkCart) {
                } else {
                    $cart = new Cart();
                    $cart->product_id = $product->product_id;
                    $cart->user_id = $user->user_id;
                    $cart->qty = 1;
                    $cart->amount = 1*$product->price;
                    $cart->created_at = date('Y-m-d H:i:s');
                    $cart->save();
                }
            }*/
            // Display cart times using this
        }
    }

    /*
     * To perform usort
     * */
    function sortByLicenses($a, $b){
        return $a['licenses'] - $b['licenses'];
    }

    /*
     * Third step of e-commerce displaying cart items and billing address details
     * */
    public function actionCheckout(){
        $user = UserInfo::model()->findByPk(Yii::app()->user->Id);
        $cartItem = Yii::app()->db->createCommand()
            ->select('pi.product_id,c.qty,c.amount,pi.image,pi.price,pi.name,pi.description')
            ->from('cart c')
            ->join('product_info pi','pi.product_id=c.product_id')
            ->where('user_id=:uId', [':uId'=>$user->user_id])
            ->queryAll();

        $this->render('checkout', [
                'user' => $user,
                'cartItem'=>$cartItem
            ]);
    }

    /*
     * Final step of e-commerce displaying payment details
     * */
    public function actionPayment(){
        $total_amount = $_POST['total'];
        $subtotal_amount = $_POST['subtotal'];
        $vat_amount = $_POST['vat_amount'];
        $post_data = $_POST;

        $user = UserInfo::model()->findByPk(Yii::app()->user->Id);
        $cartItem = Yii::app()->db->createCommand()
            ->select('pi.product_id,c.qty,c.amount,pi.image,pi.price,pi.name,pi.description')
            ->from('cart c')
            ->join('product_info pi','pi.product_id=c.product_id')
            ->where('user_id=:uId', [':uId'=>$user->user_id])
            ->queryAll();
        //User Wallet
        $user_wallet_balance = WalletHelper::getUserWalletEarnings($user->user_id);
        $total_available_balance = $user_wallet_balance;

        $this->render('payment', [
            'total_amount' => $total_amount,
            'subtotal'=>$subtotal_amount,
            'vat_amount'=>$vat_amount,
            'cartItem'=>$cartItem,
            'user'=>$user,
            'user_wallet_balance' => $user_wallet_balance,
            'total_available_balance' => $total_available_balance,
            'post_data'=>$post_data
        ]);
    }

    public function actionGetlicenseprice(){
        $license = $_GET['licenses'];
        $product_id = $_GET['product_id'];
        $response = ServiceHelper::getDiscountedPrice($license, $product_id);
        echo json_encode($response);
    }

    public function actionRemovefromcart(){
        if(isset($_POST['cart_id'])){
            $res = Yii::app()->db->createCommand()
                ->delete('cart','cart_id=:cId and user_id=:uId',[':cId'=>$_POST['cart_id'], ':uId'=>Yii::app()->user->getId()]);
            $cartItem = Yii::app()->db->createCommand()
                ->select('pi.product_id,c.cart_id,c.qty,c.amount,pi.image,pi.name,pi.description')
                ->from('cart c')
                ->join('product_info pi','pi.product_id=c.product_id')
                ->where('user_id=:uId', [':uId'=>Yii::app()->user->getId()])
                ->queryAll();
            foreach ($cartItem as $cart){
                $cart['image'] = Yii::app()->baseUrl . $cart['image'];
            }
            if($res){
                echo json_encode([
                    'token'=> 1,
                    'cartCount' => count($cartItem),
                    'product_id' => $_POST['product_id'],
                    'cartData'=>$cartItem,
                ]);
            }else{
                echo json_encode([
                    'token' => 0
                ]);
            }
        }else{
            echo json_encode([
                'token' => 0
            ]);
        }
    }

    public function actionAddToCart()
    {
        $product = ProductInfo::model()->findByAttributes(['product_id' => $_POST['product_id']]);
        $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
        $checkCart = Cart::model()->findByAttributes(['user_id' => Yii::app()->user->getId(), 'product_id' => $_POST['product_id']]);
        if ($checkCart){
            echo json_encode([
                'token' => 0,
                'msg' => "Already added to cart",
            ]);
        }else{
            $cart = new Cart();
            $cart->product_id = $product->product_id;
            $cart->user_id = $user->user_id;
            $cart->qty = $_POST['qty'];
            $cart->amount = $_POST['qty']*$product->price;
            $cart->created_at = date('Y-m-d H:i:s');

            if($cart->save()){
                $cartData = Yii::app()->db->createCommand()
                    ->select('pi.product_id,c.qty,c.cart_id,c.amount,pi.image,pi.price,pi.name,pi.description')
                    ->from('cart c')
                    ->join('product_info pi','pi.product_id=c.product_id')
                    ->where('user_id=:uId', [':uId'=>$user->user_id])
                    ->queryAll();
                foreach ($cartData as $cart){
                    $cart['image'] = Yii::app()->baseUrl . $cart['image'];
                }

                $cartItem = Yii::app()->db->createCommand()
                    ->select('pi.product_id,c.cart_id,c.qty,c.amount,pi.image,pi.price,pi.name,pi.description')
                    ->from('cart c')
                    ->join('product_info pi','pi.product_id=c.product_id')
                    ->where('user_id=:uId', [':uId'=>$user->user_id])
                    ->andWhere('c.product_id=:pId', [':pId' => $product->product_id])
                    ->queryRow();
                $count = count($cartItem);
                echo json_encode([
                    'token' => 1,
                    'cartCount' => $count,
                    'msg' => " added to cart",
                    'cartItem'=>$cartItem,
                    'cartData'=>$cartData,
                ]);
            }else{
                echo json_encode([
                    'token' => 0
                ]);
            }
        }
    }
}

?>