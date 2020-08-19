<?php

//require __DIR__ .'/../../vendor/autoload.php';
require_once Yii::app()->basePath . '/vendors/stripe-php/init.php';

class OrderController extends Controller
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
        $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->id]);
        /*if ($action->id != 'login' && $action->id != 'receiveStripeHooks' && $action->id != 'createapiorder') {
            if (Yii::app()->session['userid'] != $user->password) {
                $this->redirect(Yii::app()->createUrl('home/login'));
            }
        }*/
        if (Yii::app()->user->isGuest && $action->id != 'receiveStripeHooks'){
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

    /*
     * API for generating voucher for UTIT client
     * */
    public function actionCreateAPIOrder(){
        $response = [];
        try {
            $data = CJSON::decode(Yii::app()->request->rawBody, true);
            if(isset($data['OrderId']) && isset($data['CustomerEmailAddress']) && isset($data['OrderTotal']) && isset($data['OrderDate']) && isset($data['OrderItems'])){
                $user = UserInfo::model()->findByAttributes(['email'=>$data['CustomerEmailAddress']]);
                if(isset($user->email)){
                    $model = new VoucherInfo();
                    $model->voucher_name = 'CBM_Voucher_UTIT';
                    $model->voucher_code = VoucherHelper::random_strings('10');
                    $model->start_time = date('Y-m-d', strtotime($data['OrderDate']))." 00:00:00";
                    $model->end_time = date('Y-m-d H:i:s', strtotime($model->start_time. '+1 years'));
                    $model->voucher_comment = json_encode($data);
                    $model->voucher_origin = 'API';
                    $model->voucher_status = 1;

                    $voucherRef = VoucherReference::model()->findByPk(2);
                    $model->reference_id = $voucherRef->id;
                    $model->type = $voucherRef->type;
                    $model->value = $voucherRef->value;

                    $model->user_id = $user->user_id;
                    $model->user_name = $user->full_name;
                    $model->email = $user->email;

                    $model->created_at = date('Y-m-d H:i:s');
                    $model->save(false);

                    //VoucherHelper::voucherMail($model->voucher_code);

                    $response['status'] = 'Success';
                    $response['description'] = 'Voucher was created successfully';
                } else {
                    $response['status'] = 'Failure';
                    $response['description'] = 'Customer email not present in system';
                }
            } else {
                $response['status'] = 'Failure';
                $response['description'] = 'Please specify All required fields';
            }
        } catch (Exception $e){
            $response['status'] = 'Failure';
            $response['description'] = 'Internal Server Error: '.$e->getMessage()." /nTrace: ".$e->getTraceAsString();
        }
        echo json_encode($response);
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $id = Yii::app()->user->id;
        if ($id == 1) {
            $orders = OrderInfo::model()->findAll();
        } else {
            $orders = Yii::app()->db->createCommand()
                ->select('*')
                ->from('order_info')
                ->where('user_id=:id', [':id' => $id])
                ->order('created_date DESC')
                ->queryAll();
        }
        $pendingOrders = 0;
        //Order Status
        /*
         * 0 -> Canceled
         * 1 -> Success
         * 2 -> Pending
         * */
        foreach ($orders as $order) {
            if ($order['order_status'] == 2) {
                $pendingOrders += 1;
            }
        }
        $userInfo = UserInfo::model()->findByPk($id);
        $cbm_user_licenses = CbmUserLicenses::model()->findByAttributes(['email' => $userInfo->email]);
        if (isset($cbm_user_licenses)) {
            $available_licenses = $cbm_user_licenses->available_licenses;
            $in_use_licenses = $cbm_user_licenses->total_licenses - $cbm_user_licenses->available_licenses;
        } else {
            $available_licenses = 0;
            $in_use_licenses = 0;
        }

        $count_licenses = Yii::app()->db->createCommand()
            ->select('sum(total_licenses) as qty')
            ->from('cbm_user_licenses')
            ->where('email=:email', [':email' => $userInfo->email])
            ->queryRow();

        if (is_null($count_licenses['qty']))
            $count = 0;
        else
            $count = $count_licenses['qty'];

        $this->render('index',
            array(
                'orders' => $orders,
                'licenses' => $count,
                'pendingOrders' => $pendingOrders,
                'in_use_licenses' => $in_use_licenses,
                'available_licenses' => $available_licenses
            ));

    }

    /**
     * This is the success action that is invoked
     * when an after there is a successful payment
     */
    public function actionSuccess()
    {
        if (isset($_GET['orderID'])) {
            $orderId = $_GET['orderID'];
            OrderHelper::addLog("1", "Success action called for order Id: ".$orderId);
            $model = OrderInfo::model()->findByAttributes(['order_id' => $orderId]);
            if (empty($model->invoice_number)) {

                $userInfo = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);

                $model->order_status = 1;
                $voucher_code = $model->voucher_code;
                if(!empty($voucher_code) && $model->netTotal == 0){
                    $model->invoice_number = '';
                } else {
                    $model->invoice_number =  OrderHelper::getInvoiceNumber();
                    $model->invoice_date = date('Y-m-d H:i:s');
                }

                //Update voucher details
                if(!empty($voucher_code)){
                    VoucherHelper::updateVoucherToSuccess($voucher_code, $model->order_info_id);
                }
                $model->modified_date = date('Y-m-d H:i:s');
                $model->save(false);

                $paymentMethods = OrderPayment::model()->findAllByAttributes(['order_info_id' => $model->order_info_id]);
                foreach ($paymentMethods as $paymentMethod){
                    $payment = OrderPayment::model()->findByPk($paymentMethod->payment_id);
                    $payment->payment_date = date('Y-m-d H:i:s');
                    $payment->payment_status = 1;
                    $payment->payment_ref_id = $_GET['PAYID'];
                    $payment->modified_at = date('Y-m-d H:i:s');
                    $payment->save(false);
                }

                //Update Wallet reserve wallet tuple Status if applicable
                //Below code won't get executed as it is a bit obsolete because ideally no wallet tuple should be in pending state
                //------------------------------------------------------------------------------------------------------------------------//
                $reserve_wallet_entity = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>Yii::app()->params['ReserveWallet']]);
                $wallet_tuple = Wallet::model()->findByAttributes([
                    'wallet_type_id'=>$reserve_wallet_entity->wallet_type_id,
                    'transaction_type'=>Yii::app()->params['DebitTransactionType'],
                    'reference_num'=>$orderId
                ]);
                if(isset($wallet_tuple->wallet_id)){
                    $wallet_tuple->transaction_status = Yii::app()->params['WalletApprovedTransactionStatus'];
                    $wallet_tuple->modified_at = date('Y-m-d H:i:s');
                    $wallet_tuple->save(false);
                }
                //------------------------------------------------------------------------------------------------------------------------//

                if ($model->order_status == 1) {
                    $userInfo->modified_at = date('Y-m-d H:i:s');
                    $userInfo->save();

                    $orderItem = OrderLineItem::model()->findAllByAttributes(['order_info_id' => $model->order_info_id]);
                    foreach ($orderItem as $item) {

                        $tradingProductIds = Yii::app()->db->createCommand()
                            ->select('p.product_id')
                            ->from('product_info p')
                            ->join('product_category pc', 'p.product_id = pc.product_id')
                            ->join('categories c', 'c.category_id = pc.category_id')
                            ->where('c.category_name=:cn', [':cn'=>Yii::app()->params['TradingProductCategory']])
                            ->queryColumn();
                        if(!in_array($item->product_id, $tradingProductIds)){
                            // user cashback licenses if not created then create it
                            ServiceHelper::modifyCBMUserLicenses($userInfo->user_id, $userInfo->email, $item->item_qty, $item->item_qty);
                        }

                        $orderLicense = new CbmOrderLicenses();
                        $orderLicense->user_id = $userInfo->user_id;
                        $orderLicense->order_info_id = $model->order_info_id;
                        $orderLicense->product_id = $item->product_id;
                        $orderLicense->product_name = $item->product_name;
                        $orderLicense->licenses = $item->item_qty;
                        $orderLicense->modified_date = date('Y-m-d H:i:s');
                        $orderLicense->save(false);
                    }
                }
                $cbm_accounts = CbmAccounts::model()->findAllByAttributes(['email_address' => $userInfo->email]);
                OrderHelper::generateAffiliateCommission($model->order_id);
                OrderHelper::orderConfirmationMail($model->order_info_id);
                //OrderHelper::updateUserStatus($model->order_id);

                foreach ($cbm_accounts as $cbm_account){
                    if (isset($cbm_account->login)) {
                        OrderHelper::generateCBMNodes($cbm_account->login);
                    }
                }
                $this->redirect(Yii::app()->createUrl('/order/detail/' . $model->order_id));
            }
        }
    }

    /**
     * Whenever there is a request for an order, an pending order
     * is placed by below action. This is called before any request to payment system.
     */
    public function actionAddOrder()
    {
        try {
            $userDetail = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
            //Reserve wallet entities
            $reserve_wallet_payment_entity = Payment::model()->findByAttributes(['gateway'=>Yii::app()->params['ReserveWallet']]);
            $reserve_wallet_entity = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>Yii::app()->params['ReserveWallet']]);
            //User wallet entities
            $user_wallet_payment_entity = Payment::model()->findByAttributes(['gateway'=>Yii::app()->params['UserWallet']]);
            $user_wallet_entity = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);

            //Find Next Order Id
            $lastOrder = Yii::app()->db->createCommand()
                ->select('max(order_id) as order_id')
                ->from('order_info')
                ->queryRow();
            if (isset($lastOrder['order_id'])) {
                $orderId = $lastOrder['order_id'] + 1;
            } else {
                $orderId = 1;
            }

            $orderInfo['order_id'] = $orderId;
            $orderInfo['vat'] = doubleval($_POST['vat_amount']);
            if($_POST['payment'] == 'Reserved-Pending')
                $orderInfo['order_status'] = 3;
            else
                $orderInfo['order_status'] = 2;
            $orderInfo['user_id'] = $userDetail->user_id;
            $orderInfo['user_name'] = $userDetail->full_name;
            $orderInfo['email'] = $userDetail->email;
            if ($_POST['address'] == 'personal') {
                $userDetail->building_num = $_POST['building_num'];
                $userDetail->street = $_POST['street'];
                $userDetail->city = $_POST['city'];
                $userDetail->country = $_POST['country'];
                $userDetail->region = $_POST['region'];
                $userDetail->postcode = $_POST['postcode'];
                $orderInfo['building'] = $_POST['building_num'];
                $orderInfo['street'] = $_POST['street'];
                $orderInfo['city'] = $_POST['city'];
                $orderInfo['country'] = $_POST['country'];
                $orderInfo['region'] = $_POST['region'];
                $orderInfo['postcode'] = $_POST['postcode'];
            } else {
                $userDetail->vat_number = $_POST['vat_number'];
                $userDetail->business_name = $_POST['business_name'];
                $userDetail->busAddress_building_num = $_POST['busAddress_building_num'];
                $userDetail->busAddress_street = $_POST['busAddress_street'];
                $userDetail->busAddress_city = $_POST['busAddress_city'];
                $userDetail->busAddress_country = $_POST['busAddress_country'];
                $userDetail->busAddress_region = $_POST['busAddress_region'];
                $userDetail->busAddress_postcode = $_POST['busAddress_postcode'];
                $orderInfo['vat_number'] = $_POST['vat_number'];
                $orderInfo['company'] = $_POST['business_name'];
                $orderInfo['building'] = $_POST['busAddress_building_num'];
                $orderInfo['street'] = $_POST['busAddress_street'];
                $orderInfo['city'] = $_POST['busAddress_city'];
                $orderInfo['country'] = $_POST['busAddress_country'];
                $orderInfo['region'] = $_POST['busAddress_region'];
                $orderInfo['postcode'] = $_POST['busAddress_postcode'];
            }
            $userDetail->modified_at = date('Y-m-d H:i:s');
            $userDetail->save(false);
            $orderInfo['netTotal'] = doubleval($_POST['net_total']);
            $orderInfo['orderTotal'] = doubleval($_POST['order_total']);
            $orderInfo['vat_percentage'] = doubleval($_POST['vat_percentage']);
            $orderInfo['order_origin'] = $_POST['order_origin'];
            $orderInfo['discount'] = doubleval($_POST['discount']);
            $orderInfo['created_date'] = date('Y-m-d H:i:s');
            if(isset($_POST['voucher_code'])){
                $orderInfo['voucher_code'] = $_POST['voucher_code'];
                $orderInfo['voucher_discount'] = $_POST['voucher_code_discount'];
            }
            if (isset($_POST['order_comment'])) {
                $orderComment = $_POST['order_comment'];
            } else {
                $orderComment = "Order Comment not passed";
            }
            $orderInfo['order_comment'] = $orderComment;
            $orderInfoStatus = OrderHelper::CreateOrderInfo($orderInfo);

            if ($orderInfoStatus) {
                $notification_status = NotificationSettings::model()->findByAttributes(['event' => 'Order Create']);
                if ($notification_status->enabled == 1) {
                    $users = ($orderInfo['user_id']) ? ' of user <a href="' . Yii::app()->createUrl('admin/userInfo/view') . '/' . $orderInfo['user_id'] . '"> ' . $orderInfo['user_name'] . '</a>' : '';
                    $amount = ($orderInfo['orderTotal']) ? ' &euro;' . $orderInfo['orderTotal'] : '';
                    $body = 'Order placed for ' . $amount . $users . ' received.';
                    $url = Yii::app()->createUrl('admin/orderInfo/view') . "/" . $orderInfoStatus;
                    $nid = NotificationHelper::AddNotitication('Order placed', $body, 'general', $orderInfo['user_id'], 0, $url);
                }
                $cartItem = Yii::app()->db->createCommand()
                    ->select('pi.product_id,c.qty,c.amount,pi.sku,pi.image,pi.price,pi.name,pi.description')
                    ->from('cart c')
                    ->join('product_info pi','pi.product_id=c.product_id')
                    ->where('user_id=:uId', [':uId'=>Yii::app()->user->Id])
                    ->queryAll();
                if(!empty($cartItem)){
                    foreach($cartItem as $cart){
                        $orderLineItem = new OrderLineItem();
                        $orderLineItem->order_info_id = $orderInfoStatus;
                        $orderLineItem->product_name = $cart['name'];
                        $orderLineItem->product_id = $cart['product_id'];
                        $orderLineItem->item_qty = $cart['qty'];
                        $orderLineItem->item_price = $cart['price'];
                        $orderLineItem->item_disc = $cart['price'] - $cart['amount'];
                        $orderLineItem->product_sku = $cart['sku'];
                        $orderLineItem->save(false);

                    }
                }
                if (isset($_POST['payment_reference_id']))
                    $payment_reference_id = $_POST['payment_reference_id'];
                else
                    $payment_reference_id = "Payment ref not passed";

                $netTotal = $_POST['net_total'];
                $payableAmount = $_POST['payable_amount'];

                if($_POST['payment'] == 'Reserved-Pending'){
                    //Create a direct order from reserve wallet
                    $primary_payment = Yii::app()->params['ReserveWallet'];
                    OrderHelper::orderPayment($orderInfoStatus, $payableAmount, 1,
                        $reserve_wallet_payment_entity->gateway." ".$payment_reference_id,
                        2, $reserve_wallet_payment_entity->payment_id, $reserve_wallet_payment_entity->gateway,
                        date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
                } else {
                    $paid_through_wallet = $netTotal - $payableAmount;
                    if($paid_through_wallet == $netTotal)
                        $primary_payment = "Wallet";
                    if($paid_through_wallet > 0){
                        //For calculation purpose
                        $unpaid_amount_through_wallet = $paid_through_wallet;
                        $user_wallet_paid_amount = 0;
                        $reserve_wallet_paid_amount = 0;
                        //Available Balances
                        $reserve_wallet_balance = WalletHelper::getReserveWalletBalance($userDetail->user_id);
                        $user_wallet_balance = WalletHelper::getUserWalletEarnings($userDetail->user_id);
                        //First User wallet is considered in case of both wallets are selected
                        //A checkbox is present only if it is on
                        if(isset($_POST['user_wallet_cbox'])){
                            if($paid_through_wallet <= $user_wallet_balance){
                                $user_wallet_paid_amount = $paid_through_wallet;
                                $unpaid_amount_through_wallet -= $paid_through_wallet;
                            } else {
                                $user_wallet_paid_amount = $user_wallet_balance;
                                $unpaid_amount_through_wallet -= $user_wallet_balance;
                            }
                            $payment_mode = $user_wallet_payment_entity->payment_id;
                            $payment = $user_wallet_payment_entity->gateway;
                            OrderHelper::orderPayment($orderInfoStatus, $user_wallet_paid_amount, 1, $payment_reference_id,
                                2, $payment_mode, $payment, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));

                            //Approved Status wallet tuple for user wallet as wallet cannot be in pending state
                            $deduction_comment = "User Wallet Deduction";
                            WalletHelper::addToWallet($userDetail->user_id, $user_wallet_entity->wallet_type_id, Yii::app()->params['DebitTransactionType'],
                                6, $orderId, $deduction_comment, 1, Yii::app()->params['WalletApprovedTransactionStatus'],
                                1, $user_wallet_paid_amount, date('Y-m-d H:i:s'));
                        }

                        if(isset($_POST['reserve_wallet_cbox'])){
                            //Reserved wallet is logically only considered when user wallet was not enough
                            if($unpaid_amount_through_wallet > 0){
                                //Here the only option logically remains is reserved wallet payment of remaining amount
                                $reserve_wallet_paid_amount = $unpaid_amount_through_wallet;

                                $payment_mode = $reserve_wallet_payment_entity->payment_id;
                                $payment = $reserve_wallet_payment_entity->gateway;
                                OrderHelper::orderPayment($orderInfoStatus, $reserve_wallet_paid_amount, 1, $payment_reference_id,
                                    2, $payment_mode, $payment, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));

                                //Approved Status wallet tuple for reserve wallet as wallet cannot be in pending state
                                $deduction_comment = "Reserve Wallet Deduction";
                                WalletHelper::addToWallet($userDetail->user_id, $reserve_wallet_entity->wallet_type_id, Yii::app()->params['DebitTransactionType'],
                                    6, $orderId, $deduction_comment, 1, Yii::app()->params['WalletApprovedTransactionStatus'],
                                    1, $reserve_wallet_paid_amount, date('Y-m-d H:i:s'));
                            }
                        }
                    }
                    $paid_through_payment_system = $netTotal - $paid_through_wallet;
                    if($paid_through_payment_system > 0){

                        if ($_POST['payment'] == 'bank') {
                            $primary_payment = "Bank Transfer";
                            $primary_payment_mode = 2;
                        } elseif ($_POST['payment'] == 'stripe') {
                            $primary_payment = "Stripe";
                            $primary_payment_mode = 3;
                        } elseif ($_POST['payment'] == 'paypal') {
                            $primary_payment = "PayPal";
                            $primary_payment_mode = 4;
                        } elseif ($_POST['payment'] == 'Reserved-Pending') {
                            $primary_payment = $reserve_wallet_payment_entity->gateway;
                            $primary_payment_mode = $reserve_wallet_payment_entity->payment_id;
                        } elseif ($_POST['payment'] == 'ingenico') {
                            $primary_payment = "Ingenico";
                            $primary_payment_mode = 1;
                        } else {
                            $primary_payment = "Wallet";
                        }
                        OrderHelper::orderPayment($orderInfoStatus, $paid_through_payment_system, 1, $payment_reference_id,
                            2, $primary_payment_mode, $primary_payment, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
                    }

                    //Voucher payment through wallet
                    if(($paid_through_wallet == 0) && ($paid_through_payment_system == 0)){
                        OrderHelper::orderPayment($orderInfoStatus, 0, 1, $payment_reference_id,
                            2, $user_wallet_payment_entity->payment_id, $user_wallet_payment_entity->gateway, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
                    }
                }

                $message = 'Order Placed.';
                $date = date('Y-m-d H:i:s');
                //$url is the define for redirect order details link page.
                NotificationHelper::pusherNotification($message, $date, $url, $orderInfoStatus, $userDetail->full_name, $userDetail->user_id, $_POST['net_total'], $nid);

                $result = [];
                $result['payment'] = $primary_payment;
                $result['orderId'] = $orderId;
                Yii::app()->db->createCommand("DELETE FROM cart WHERE `user_id` = " . Yii::app()->user->getId())->execute();
                echo json_encode($result);
            }
        } catch (Exception $e) {
            $logs = new CbmLogs();
            $logs->status = 2;
            $logs->created_date = date('Y-m-d H:i:s');
            $logs->log = "Add Order error: " . $e->getMessage();
            $logs->save(false); // saving logs
        }
    }

    /*
     * Update Stripe related details
     * */
    public function actionUpdateStripeDetails()
    {
        $netTotal = $_POST['netTotal'];
        $selectedOption = $_POST['selected_option'];
        $orderId = (isset($_POST['order_id'])) ? $_POST['order_id'] : 0;
        $fullName = (isset($_POST['full_name'])) ? $_POST['full_name'] : '';
        $email = (isset($_POST['email'])) ? $_POST['email'] : '';
        $sourceId = (isset($_POST['source_id'])) ? $_POST['source_id'] : '';

        \Stripe\Stripe::setApiKey(Yii::app()->params['StripeSecretKey']);

        $customer = \Stripe\Customer::create([
            "email" => $email,
            "payment_method" => $sourceId,
        ]);

        /*$charge = \Stripe\Charge::create([
            'amount' => round($netTotal, 2) * 100,
            'currency' => 'EUR',
            'customer' => $customer->id,
            'source' => $sourceId,
            'metadata' => [
                'orderId' => $orderId,
                'full_name' => $fullName
            ],
            'receipt_email' => $email
        ]);*/
        //Here sourceId is the payment Method Id
        $intent = \Stripe\PaymentIntent::create([
            'payment_method' => $sourceId,
            'amount' => round($netTotal, 2) * 100,
            'customer' => $customer->id,
            'currency' => 'EUR',
            'confirmation_method' => 'manual',
            'confirm' => true,
            'metadata' => [
                'orderId' => $orderId,
                'full_name' => $fullName
            ],
            'receipt_email' => $email
        ]);


        /*if ($charge->paid == 1 || $charge->paid == true) {
            $result = [
                'paid' => true,
                'chargeId' => $charge->id
            ];
        } else {
            $result = [
                'paid' => false,
                'chargeId' => $charge->id
            ];
        }
        echo json_encode($result);*/

        if ($intent->status == 'requires_action' &&
            $intent->next_action->type == 'use_stripe_sdk') {
            # Tell the client to handle the action
            echo json_encode([
                'status' => false,
                'requires_action' => true,
                'secret' => $intent->id
            ]);
        } else if ($intent->status == 'succeeded') {
            # The payment didn’t need any additional actions and completed!
            # Handle post-payment fulfillment
            echo json_encode([
                'status' => true,
                'secret' => $intent->id
            ]);
        } else {
            # Invalid status
            http_response_code(500);
            echo json_encode([
                'status' => false,
                'error' => 'Invalid PaymentIntent status',
                'secret' => $intent->id
            ]);
        }
    }

    /*
     * To authorize Stripe Async Payment
     * loaded after validation from stripe
     * after successful validation, one needs to
     * create and charge the source
     * */
    public function actionAuthorizeStripeAsyncPayment()
    {
        $netTotal = $_GET['netTotal'];
        $orderId = (isset($_GET['order_id'])) ? $_GET['order_id'] : 0;
        $order = OrderInfo::model()->findByAttributes(['order_id'=>$orderId]);
        $user = UserInfo::model()->findByPk($order->user_id);
        $sourceId = (isset($_GET['source'])) ? $_GET['source'] : '';
        \Stripe\Stripe::setApiKey(Yii::app()->params['StripeSecretKey']);
        $source = Stripe\Source::retrieve($sourceId);

        OrderHelper::addLog("1", "Authorize async payment action called for order Id: ".$orderId." and sourceID : ".$sourceId);
        if($source->status == 'chargeable'){
            $customer = \Stripe\Customer::create([
                "email" => $user->email,
                "source" => $sourceId,
            ]);

            $charge = \Stripe\Charge::create([
                'amount' => round($netTotal, 2) * 100,
                'currency' => 'EUR',
                'customer' => $customer->id,
                'source' => $sourceId,
                'metadata' => [
                    'orderId' => $orderId,
                    'full_name' => $user->full_name
                ],
                'receipt_email' => $user->email
            ]);

            if ($charge->paid == 1 || $charge->paid == true) {
                OrderHelper::addLog("1", "Authorize async payment-calling success action.");
                $successURL = Yii::app()->createAbsoluteUrl('order/success') . '?orderID=' . $orderId . '&PAYID=' . $charge->id;
                $this->redirect($successURL);
            } elseif ($charge->status == 'pending') {
                OrderHelper::addLog("1", "Authorize async payment-calling pending action.");
                $pendingURL = Yii::app()->createAbsoluteUrl('order/pending') . '?orderID=' . $orderId . '&PAYID=' . $charge->id;
                $this->redirect($pendingURL);
            } else {
                OrderHelper::addLog("1", "Authorize async payment-calling cancel action.");
                $cancelURL = Yii::app()->createAbsoluteUrl('order/cancel') . '?orderID=' . $orderId . '&PAYID=' . $charge->id;
                $this->redirect($cancelURL);
            }
        } else {
            OrderHelper::addLog("1", "Authorize async payment-calling cancel action with source status: ".$source->status);
            $detailURL = Yii::app()->createAbsoluteUrl('order/detail') .'/'. $orderId;
            $this->redirect($detailURL);
        }
    }

    /*
     * Update stripe payment transaction mode
     * */
    public function actionUpdateStripeOrderPayment(){
        if(isset($_POST['order_id'])){
            $order = OrderInfo::model()->findByAttributes(['order_id'=>$_POST['order_id']]);
            $stripePayment = Payment::model()->findByAttributes(['gateway'=>'Stripe']);
            if(isset($order->order_id)){
                $orderPayments = OrderPayment::model()->findAllByAttributes(['order_info_id'=>$order->order_info_id]);
                foreach ($orderPayments as $orderPayment){
                    if(isset($orderPayment->order_info_id) && ($orderPayment->payment_mode == $stripePayment->payment_id)){
                        if(isset($_POST['selected_option'])){
                            $orderPayment->transaction_mode = $_POST['selected_option'];
                        } else {
                            $orderPayment->transaction_mode = "Stripe";
                        }
                        $orderPayment->save(false);
                    }
                }
            }
        }
    }

    //Stripe Hooks
    public function actionReceiveStripeHooks(){
        \Stripe\Stripe::setApiKey(Yii::app()->params['StripeSecretKey']);
        $input = file_get_contents("php://input");
        $event_json = json_decode($input);

        OrderHelper::addLog("1", "Stripe hook received with event type: ".$event_json->type." and payment ref: ".$event_json->data->object->id);
        if($event_json->type == 'charge.succeeded'){
            $payment_ref_id = $event_json->data->object->id;
            $payment = OrderPayment::model()->findByAttributes(['payment_ref_id'=>$payment_ref_id]);
            if(isset($payment->order_info_id)) {
                $model = OrderInfo::model()->findByAttributes(['order_info_id' => $payment->order_info_id]);
                if (empty($model->invoice_number)) {

                    $userInfo = UserInfo::model()->findByAttributes(['user_id' => $model->user_id]);
                    $orderInfo = $model->attributes;
                    $orderInfo['order_status'] = 1;
                    $orderInfo['invoice_number'] = OrderHelper::getInvoiceNumber();

                    $model->order_status = 1;
                    $model->invoice_number = $orderInfo['invoice_number'];
                    $model->invoice_date = date('Y-m-d H:i:s');
                    $model->modified_date = date('Y-m-d H:i:s');
                    $model->save(false);

                    $orderInfoStatus = OrderHelper::CreateOrderInfo($orderInfo);

                    $orderPayment = $payment->attributes;
                    $orderPayment['modified_at'] = date('Y-m-d H:i:s');
                    $orderPayment['payment_date'] = date('Y-m-d H:i:s');
                    $orderPayment['total'] = $model->netTotal;
                    $orderPayment['payment_status'] = 1;
                    $orderPaymentStatus = OrderHelper::CreateOrderPayment($orderPayment);

                    if ($orderInfoStatus) {
                        $orderItem = OrderLineItem::model()->findAllByAttributes(['order_info_id' => $model->order_info_id]);
                        foreach ($orderItem as $item) {

                            $proDetail = ProductInfo::model()->findByPk($item->product_id);
                            // cbm user licenses if not created then create it
                            ServiceHelper::modifyCBMUserLicenses($userInfo->user_id, $userInfo->email, $item->item_qty, $item->item_qty);

                            $orderLicense = new CbmOrderLicenses();
                            $orderLicense->user_id = $userInfo->user_id;
                            $orderLicense->order_info_id = $model->order_info_id;
                            $orderLicense->product_id = $proDetail->product_id;
                            $orderLicense->product_name = $proDetail->name;
                            $orderLicense->licenses = $item->item_qty;
                            $orderLicense->modified_date = date('Y-m-d H:i:s');
                            $orderLicense->save(false);
                            Yii::app()->db->createCommand("DELETE FROM cart WHERE `user_id` = " . Yii::app()->user->getId())->execute();
                        }
                    }
                    OrderHelper::updateToSuccess($model->order_id);
                }
            }
        }
        http_response_code(200);
    }

    public function actionDecline()
    {
        $this->render('decline');
    }

    /**
     * Order cancel action
     */
    public function actionCancel()
    {
        if (isset($_GET['orderID'])) {
            $orderId = $_GET['orderID'];
        } elseif ($_POST['order_id']){
            $orderId = $_POST['order_id'];
        } else {
            $orderId = "";
        }

        $model = OrderInfo::model()->findByAttributes(['order_id' => $orderId]);
        if(isset($model->order_id)){
            $model->order_status = 0;
            $model->modified_date = date('Y-m-d H:i:s');
            $model->save(false);

            $orderPayments = OrderPayment::model()->findAllByAttributes(['order_info_id'=>$model->order_info_id]);
            foreach ($orderPayments as $orderPayment){
                $orderPayment->payment_status = 0;
                $orderPayment->modified_at = date('Y-m-d H:i:s');
                $no_reference_payment_modes = [2, 5, 6];
                if(!in_array($orderPayment->payment_mode, $no_reference_payment_modes)){
                    if(isset($_GET['PAYID']))
                        $orderPayment->payment_ref_id = $_GET['PAYID'];
                } else {
                    //Cancel the wallet transaction
                    if($orderPayment->payment_mode == 5){
                        //Reserve Wallet
                        $wallet_type_id = 8;
                    } else {
                        $wallet_type_id = 1;
                    }
                    $wallet = Wallet::model()->findByAttributes(['wallet_type_id'=>$wallet_type_id,
                        'reference_num'=>$model->order_id]);
                    if(isset($wallet->wallet_id)){
                        $wallet->transaction_status = Yii::app()->params['WalletRejectedTransactionStatus'];
                        $wallet->modified_at = date('Y-m-d H:i:s');
                        $wallet->save(false);
                    }
                }
                $orderPayment->save(false);
            }
        }

        if (isset($_GET['orderID'])) {
            $this->render('cancel');
        } else {
            return "Order Cancelled";
        }
    }

    //Order in pending state
    public function actionPending(){
        if (isset($_GET['orderID'])) {
            $model = OrderInfo::model()->findByAttributes(['order_id' => $_GET['orderID']]);

            $model->order_status = 2;
            $model->modified_date = date('Y-m-d H:i:s');
            $model->save(false);

            $orderPayment = OrderPayment::model()->findByAttributes(['order_info_id'=>$model->order_info_id]);
            $orderPayment->payment_status = 2;
            $orderPayment->payment_ref_id = $_GET['PAYID'];
            $orderPayment->modified_at = date('Y-m-d H:i:s');
            $orderPayment->save(false);

            $this->redirect(Yii::app()->createUrl('/order/detail/' . $model->order_id));
        }
    }

    /*
     * Add response to order comments
     * */
    public function actionAddResponse()
    {
        if (isset($_POST['order_id'])) {
            $orderId = $_POST['order_id'];
            $order = OrderInfo::model()->findByAttributes(['order_id' => $orderId]);
            $order->order_comment = json_encode($_POST['response']);
            $order->modified_date = date('Y-m-d H:i:s');
            $order->save(false);
        }
    }

    public function actionException()
    {
        $this->render('exception');
    }

    /**
     * This is the detail action that is invoked
     * when an order is placed.
     */
    public function actionDetail($id)
    {
        $order = OrderInfo::model()->findByAttributes(['order_id' => $id]);
        $orderLineItem = OrderLineItem::model()->findAllByAttributes(['order_info_id' => $order->order_info_id]);

        $orderPayment = OrderPayment::model()->findAllByAttributes(['order_info_id' => $order->order_info_id]);
        $orderStatus = CylFieldValues::model()->findByAttributes(['field_id' => 101, 'predefined_value' => $order->order_status]);

        $this->render('detail',
            array(
                'order' => $order,
                'orderStatus' => $orderStatus,
                'orderlineitem' => $orderLineItem,
                'orderpayment' => $orderPayment,
                'status' => $orderStatus,
            ));
    }

    /*
     * Reserve wallet index page for pending orders
     * */
    public function actionReserveWallet(){
        $userId = Yii::app()->user->getId();
        $user = UserInfo::model()->findByPk($userId);

        //Reserve Wallet Earnings
        $reserve_wallet_balance = WalletHelper::getReserveWalletBalance($user->user_id);

        //Pending Order list
        $orders = Yii::app()->db->createCommand()
            ->select('*')
            ->from('order_info')
            ->where('user_id=:id', [':id' => $userId])
            ->andWhere('order_status=:os',[':os'=>3])
            ->order('created_date DESC')
            ->queryAll();

        $this->render('reserve-wallet-settings', [
            'reserve_wallet_balance' => $reserve_wallet_balance,
            'reserve_wallet_commission_status' => $user->reserve_wallet_commission_status,
            'pending_orders' => $orders
        ]);
    }

    /*
     * Pending order index for reserve wallet
     * */
    public function actionPendingOrder(){
        $userId = Yii::app()->user->getId();
        $user = UserInfo::model()->findByPk($userId);
        $product = ProductInfo::model()->findByPk(1);

        $productPricing = Yii::app()->db->createCommand()
            ->select('*')
            ->from('product_pricing')
            ->where('is_cluster=:ic',[':ic'=>1])
            ->andWhere('licenses<=:lc',[':lc'=>255])
            ->queryAll();

        $productPricingDetails = array();
        foreach ($productPricing as $item){
            $temp = array();
            $temp['id'] = $item['id'];
            $temp['licenses'] = $item['licenses'];
            $temp['price_per_license'] = $item['price_per_license'];
            $temp['is_cluster'] = $item['is_cluster'];
            $productPricingDetails[$item['id']] = $temp;
        }

        $this->render('pending-order', [
                'product' => $product,
                'product_pricing' => $productPricingDetails,
                'user' => $user
            ]
        );
    }

    /*
     * Reserved-Pending Order confirmation from user side
     * */
    public function actionConfirmPendingOrder(){
        if(isset($_POST['order_id'])){
            $orderId = $_POST['order_id'];
            $paymentMode = $_POST['payment_mode'];
            OrderHelper::completeOrderSuccess($orderId, $paymentMode);
        }
    }

    /*
     * Get netTotal based on order-id
     * */
    public function actionGetOrderAmount(){
        if(isset($_POST['order_id'])) {
            $orderId = $_POST['order_id'];
            $order = OrderInfo::model()->findByAttributes(['order_id'=>$orderId]);
            if(isset($order->order_id)){
                echo $order->netTotal;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*
     * Validate coupon code
     * */
    public function actionValidateCouponCode(){
        $result = [];
        if(isset($_POST['coupon_code'])){
            $userId = Yii::app()->user->getId();
            $user = UserInfo::model()->findByPk($userId);

            $voucher = VoucherHelper::validateCouponCode($_POST['coupon_code'], $user->email);
            if(isset($voucher['id'])){
                $result['title'] = 'Congratulations';
                $result['status'] = 'success';
                $result['message'] = 'Your coupon is applied';
                $result['quantity'] = $voucher['value'];
            } else {
                $result['title'] = 'Sorry';
                $result['status'] = 'error';
                $result['message'] = 'The coupon code entered is invalid';
            }
        } else {
            $result['title'] = 'Sorry';
            $result['status'] = 'warning';
            $result['message'] = 'Coupon code is not received by system';
        }
        echo json_encode($result);
    }

    /*
     * get post value
     * */
    public function getPostValue($var){
        if(isset($_POST[$var])){
            return $_POST[$var];
        } else {
            return '';
        }
    }
}
