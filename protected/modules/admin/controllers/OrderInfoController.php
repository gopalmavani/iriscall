<?php

class OrderInfoController extends CController
{
    /**
     * @return array action filters
     */


    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return UserIdentity::accessRules();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        date_default_timezone_set('Europe/Berlin');
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'itemModel' => OrderLineItem::model()->findAllByAttributes(['order_info_id' => $id]),
            'paymentModel' => OrderPayment::model()->findAllByAttributes(['order_info_id' => $id])
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        date_default_timezone_set('Europe/Berlin');
        $model = new OrderInfo;
        $orderItem = new OrderLineItem();
        $orderPayment = new OrderPayment();
        $productSubscription = new ProductSubscription();

        if (isset($_POST['OrderInfo']) && isset($_POST['OrderLineItem']) && isset($_POST['OrderPayment'])) {
            $userId = $_POST['OrderInfo']['user_id'];
            $userInfo = UserInfo::model()->findByAttributes(['user_id' => $userId]);
            if ($_POST['OrderInfo']['company'] == '') {
                $model->country = $userInfo->country;
                $model->building = $userInfo->building_num;
                $model->street = $userInfo->street;
                $model->city = $userInfo->city;
                $model->region = $userInfo->region;
                $model->postcode = $userInfo->postcode;
            } else {
                $model->country = $userInfo->busAddress_country;
                $model->building = $userInfo->busAddress_building_num;
                $model->street = $userInfo->busAddress_street;
                $model->city = $userInfo->busAddress_city;
                $model->region = $userInfo->busAddress_street;
                $model->postcode = $userInfo->busAddress_postcode;
            }

            //Get Invoice Number
            $model->invoice_number = OrderHelper::getInvoiceNumber();
            //Get Latest order ID
            $Order = OrderInfo::model()->find(array('order' => 'order_id DESC'));
            if ($Order == '') {
                $model->order_id = 1;
            } else {
                $model->order_id = $Order['order_id'] + 1;
            }
            $model->user_id = $userId;
            $model->user_name = $userInfo->full_name;
            $model->email = $userInfo->email;
            $model->order_origin = 'Admin';
            $model->created_date = date('Y-m-d H:i:s');
            $model->invoice_date = date('Y-m-d H:i:s');

            //Temporary commenting out Subscription code
            //Please do not delete below code
            /*if($_POST['ProductSubscription']['duration']!='')
            {
                $productSubscription->attributes = $_POST['ProductSubscription'];
                $productSubscription->user_id = $userInfo->user_id;
                $productSubscription->user_name  = $userInfo->full_name;
                $productSubscription->email  = $userInfo->email;
                $productSubscription->product_name = $_POST['OrderLineItem']['product_name']['0'];
                $productSubscription->product_details = $proDetail->short_description;
                $productSubscription->subscription_price = $proDetail->price;
                $productSubscription->starts_at= $_POST['ProductSubscription']['starts_at'];
                $productSubscription->payment_mode = $_POST['OrderPayment']['payment_mode'];
                $productSubscription->subscription_status = 0;

                $renewaldate = '';

                if ($_POST['ProductSubscription']['duration_denomination'] == 1 ){
                    $renewaldate = date('Y-m-d H:i:s', time() + $_POST['ProductSubscription']['duration']*24 * 60 * 60);
                }elseif ($_POST['ProductSubscription']['duration_denomination'] == 2 ){
                    $week = "+".$_POST['ProductSubscription']['duration']." week";
                    $renewaldate = date('Y-m-d H:i:s', strtotime($week, strtotime(date("Y-m-d H:i:s"))));
                }elseif ($_POST['ProductSubscription']['duration_denomination'] == 3 ){
                    $month = "+".$_POST['ProductSubscription']['duration']." months";
                    $renewaldate = date('Y-m-d H:i:s', strtotime($month, strtotime(date("Y-m-d H:i:s"))));
                }elseif ($_POST['ProductSubscription']['duration_denomination'] == 4 ){
                    $year = "+".$_POST['ProductSubscription']['duration']." years";
                    $renewaldate = date('Y-m-d H:i:s', strtotime($year, strtotime(date("Y-m-d H:i:s"))));
                }

                $productSubscription->next_renewal_date = $renewaldate;
                $productSubscription->created_at = date('Y-m-d H:i:s');

                if ($productSubscription->save()) {
                    $OrderSubMap = new OrderSubscriptionMapping;
                    $OrderSubMap->subscription_id = $productSubscription->s_id;
                    $OrderSubMap->order_id = $model->order_id;
                    $OrderSubMap->created_at = date('Y-m-d H:i:s');
                    $OrderSubMap->save();
                } else{
                    echo "<pre>";
                    print_r($productSubscription->getErrors()); die;
                }
            }*/

            // Order All item price,discount,total,net total
            $totalArray = $this->getOrderAllTotal($_POST['OrderLineItem']);
            $model->orderTotal = $totalArray['orderTotal'];
            $model->discount = $totalArray['orderDiscount'];
            $model->vat = $_POST['OrderInfo']['vat'];
            $model->vat_percentage = $_POST['OrderInfo']['vat_percent'];
            $model->netTotal = $totalArray['orderTotal'] - $totalArray['orderDiscount'] + $_POST['OrderInfo']['vat'];

            if ($model->save()) {

                $orderPayment->attributes = $_POST['OrderPayment'];
                $orderPayment->created_at = date('Y-m-d H:i:s');
                $orderPayment->total = $model->netTotal;
                $orderPayment->order_info_id = $model->order_info_id;
                $orderPayment->denomination_id = 1;
                $paymentModeInt = $_POST['OrderPayment']['payment_mode'];
                if ($paymentModeInt == 1) {
                    $orderPayment->transaction_mode = 'Ingenico';
                } elseif ($paymentModeInt == 2) {
                    $orderPayment->transaction_mode = 'Bank Transfer';
                } elseif ($paymentModeInt == 3) {
                    $orderPayment->transaction_mode = 'Stripe';
                } else {
                    $orderPayment->transaction_mode = 'Paypal';
                }

                $orderPayment->save(false);

                $this->saveOrderItem($_POST['OrderLineItem'], $model->order_info_id);

                foreach ($_POST['OrderLineItem']['product_id'] as $key => $value) {

                    // add user affiliate level amount
                    $affiliateData = ProductAffiliate::model()->findAllByAttributes(['product_id' => $_POST['OrderLineItem']['product_id'][$key]]);

                    if (!empty($affiliateData)) {
                        $affLevel = [];
                        foreach ($affiliateData as $affKey => $affiliate) {
                            $affLevel[$affKey] = $affiliate->aff_level;
                        }
                        $maxValue = max($affLevel);
                        $userParents = CJSON::decode(BinaryTreeHelper::GetParentTrace($model->user_id, $maxValue));
                        foreach ($userParents as $parent) {
                            if (in_array($parent['level'], $affLevel)) {
                                //Credit transaction type
                                $transaction_type = 0;
                                //User Wallet type
                                $wallet_type = 1;
                                //Affiliate reference Id
                                $affiliate_id = 3;
                                //Transaction comment
                                $comment = "From UserId-" . $model->user_id . ", Level-" . $parent['level'];
                                //Denomination Id
                                $denominationId = 1;
                                //Transaction Status
                                $transaction_status = 1;
                                //TPW portal
                                $portal_id = 1;
                                // get affiliate
                                $affiliateDetails = ProductAffiliate::model()->findByAttributes(['product_id' => $_POST['OrderLineItem']['product_id'][$key], 'aff_level' => $parent['level']]);
                                $affAmount = $affiliateDetails->amount * $_POST['OrderLineItem']['item_qty'][$key];

                                //Add to wallet
                                WalletHelper::addToWallet($parent['userId'], $wallet_type, $transaction_type, $affiliate_id, $userId, $comment, $denominationId, $transaction_status, $portal_id, $affAmount, date('Y-m-d H:i:s'));
                            }
                        }
                    }

                    //License Update
                    $prodDetail = ProductInfo::model()->findByPk($_POST['OrderLineItem']['product_id'][$key]);
                    $cbm_account = CbmAccounts::model()->findByAttributes(['email_address' => $userInfo->email, 'agent' => $prodDetail->agent]);

                    ServiceHelper::modifyCBMUserLicenses($userInfo->user_id, $userInfo->email, $_POST['OrderLineItem']['item_qty'][$key], $_POST['OrderLineItem']['item_qty'][$key]);

                    $orderLicense = new CbmOrderLicenses();
                    $orderLicense->user_id = $userInfo->user_id;
                    $orderLicense->order_info_id = $model->order_info_id;
                    $orderLicense->product_id = $prodDetail->product_id;
                    $orderLicense->product_name = $prodDetail->name;
                    $orderLicense->licenses = $_POST['OrderLineItem']['item_qty'][$key];
                    $orderLicense->modified_date = date('Y-m-d H:i:s');
                    $orderLicense->save(false);
                    if (!empty($cbm_account)) {
                        OrderHelper::generateCBMNodes($cbm_account->login);
                    }
                }
                OrderHelper::orderConfirmationMail($model->order_info_id);
                //OrderHelper::updateUserStatus($model->order_id);
                $this->redirect(array('view', 'id' => $model->order_info_id));
            }
        }
        $products = Yii::app()->db->createCommand()->select('product_id,price')->from('product_info')->queryAll();
        $productPrice = [];
        foreach($products as $value){
            $productPrice[$value['product_id']] = $value['price'];
        }
        //echo '<pre>';print_r($productPrice);die;
        $this->render('create', array(
            'model' => $model,
            'orderItem' => $orderItem,
            'orderPayment' => $orderPayment,
            'productSubscription' => $productSubscription,
            'productPrice' => $productPrice
        ));

    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        date_default_timezone_set('Europe/Berlin');
        $model = $this->loadModel($id);
        $orderItem = OrderLineItem::model()->findAllByAttributes(['order_info_id' => $model->order_info_id]);
        $orderPayment = OrderPayment::model()->findAllByAttributes(['order_info_id' => $model->order_info_id]);
        $userInfo = OrderInfo::model()->findByAttributes(['order_info_id' => $id]);
        
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['OrderInfo']) && isset($_POST['OrderLineItem']) && isset($_POST['OrderPayment'])) {
            $previousOrderStatus = $model->order_status;
            $model->attributes = $_POST['OrderInfo'];
            $model->modified_date = date('Y-m-d H:i:s');
            if ($model->validate()) {
                $model->attributes = $_POST['OrderInfo'];

                // Delete Order Item
                // $oldItems = OrderLineItem::model()->findAllByAttributes(['order_info_id' => $model->order_info_id]);
                // if(!empty($oldItems)){
                //     foreach ($oldItems as $key => $value) {
                //         if (!in_array($value->product_id, $_POST['OrderLineItem']['product_id'])) {
                //             OrderLineItem::model()->deleteAllByAttributes(['order_info_id' => $model->order_info_id, 'product_id' => $value['product_id']]);
                //         }
                //     }
                // }
                // Update/create Order Line Item
                $orderItemAttributes = $_POST['OrderLineItem'];
                foreach ($orderItemAttributes['product_name'] as $j=>$productItems){
                    $ord = OrderLineItem::model()->findAllByAttributes(['product_name' => $productItems]);
                    if(empty($ord)){
                        $product = ProductInfo::model()->findAllByAttributes(['name' => $productItems]);
                        $newOrderItem = new OrderLineItem();
                        if(!empty($product)){
                            $new = 0;
                            $newOrderItem->product_id = $product[$new]['product_id'];
                            $newOrderItem->product_sku = $product[$new]['sku'];
                            $new++;
                        }else{
                            $newOrderItem->product_id = '';
                            $newOrderItem->product_sku = '';
                        }
                        $newOrderItem->order_info_id = $id;
                        $newOrderItem->product_name = $orderItemAttributes['product_name'][$j];
                        $newOrderItem->item_qty = $orderItemAttributes['item_qty'][$j];
                        $newOrderItem->item_disc = $orderItemAttributes['item_disc'][$j];
                        $newOrderItem->item_price = $orderItemAttributes['item_price'][$j];
                        $newOrderItem->comment = $orderItemAttributes['comment'][$j];
                        $newOrderItem->created_at = date('Y-m-d H:i:s');
                        $newOrderItem->save(false);
                    }else{
                        foreach($ord as $oldProduct){
                            $oldProduct->item_qty = $orderItemAttributes['item_qty'][$j];
                            $oldProduct->item_disc = $orderItemAttributes['item_disc'][$j];
                            $oldProduct->item_price = $orderItemAttributes['item_price'][$j];
                            $oldProduct->comment = $orderItemAttributes['comment'][$j];
                            $oldProduct->modified_at = date('Y-m-d H:i:s');
                            $oldProduct->save(false);
                        }
                    }
                }
                
                // Update or create Order Line Item
                // $orderItemArray = $_POST['OrderLineItem'];
                // $_POST['OrderLineItem']['product_name'][0] = $_POST['OrderLineItem']['product_id'][0]
                // $this->saveOrderItem($_POST['OrderLineItem'],$model->order_info_id);

                // Update Order All item price,discount,total,net total
                $totalArray = $this->getOrderAllTotal($_POST['OrderLineItem']);
                $model->orderTotal = $totalArray['orderTotal'];
                $model->discount = $totalArray['orderDiscount'];
                $model->netTotal = $totalArray['orderTotal'] + $model->vat;

                // Update Order Payment
                $orderPaymentAttributes = $_POST['OrderPayment'];
                foreach ($orderPaymentAttributes['payment_id'] as $k=>$orderPaymentAttributeId){
                    $orderPaymentModel = OrderPayment::model()->findByPk($orderPaymentAttributeId);
                    $orderPaymentModel->payment_mode = $orderPaymentAttributes['payment_mode'][$k];
                    $orderPaymentModel->payment_status = $orderPaymentAttributes['payment_status'][$k];
                    $orderPaymentModel->payment_ref_id = $orderPaymentAttributes['ref_id'][$k];
                    $orderPaymentModel->total = $orderPaymentAttributes['amount'][$k];
                    $orderPaymentModel->payment_date = $orderPaymentAttributes['payment_date'];
                    $orderPaymentModel->modified_at = date('Y-m-d H:i:s');

                    $paymentModeInt = $orderPaymentAttributes['payment_mode'][$k];
                    if ($paymentModeInt == 1) {
                        $orderPaymentModel->transaction_mode = 'Ingenico';
                    } elseif ($paymentModeInt == 2) {
                        $orderPaymentModel->transaction_mode = 'Bank Transfer';
                    } elseif ($paymentModeInt == 3) {
                        $orderPaymentModel->transaction_mode = 'Stripe';
                    } elseif ($paymentModeInt == 5) {
                        $orderPaymentModel->transaction_mode = Yii::app()->params['ReserveWallet'];
                    } else {
                        $orderPaymentModel->transaction_mode = 'Paypal';
                    }

                    $orderPaymentModel->save(false);
                }
                //Payment is not successful
                if(in_array(0, $orderPaymentAttributes['payment_status'])){
                    $model->order_status = 0;
                } elseif (in_array(2, $orderPaymentAttributes['payment_status'])){
                    $model->order_status = 2;
                } else {
                    //Payment is successful
                    $model->order_status = 1;
                }
                if ($model->order_status == 1) {
                    //If status is changed from pending to success
                    if ($previousOrderStatus == 2) {
                        $invoice_no = OrderHelper::getInvoiceNumber();
                        $model->invoice_number = $invoice_no;
                        $model->invoice_date = date('Y-m-d H:i:s');

                        //Add Licenses to CBM Order Licenses
                        // foreach ($orderItem as $item) {
                        //     $orderLicense = new CbmOrderLicenses();
                        //     $orderLicense->user_id = $userInfo->user_id;
                        //     $orderLicense->order_info_id = $model->order_info_id;
                        //     $orderLicense->product_id = $item->product_id;
                        //     $orderLicense->product_name = $item->product_name;
                        //     $orderLicense->licenses = $item->item_qty;
                        //     $orderLicense->modified_date = date('Y-m-d H:i:s');
                        //     $orderLicense->save(false);

                        //     ServiceHelper::modifyCBMUserLicenses($userInfo->user_id, $userInfo->email, $item->item_qty, $item->item_qty);
                        // }
                    }
                } else {
                    $model->invoice_number = '';
                    if($model->order_status == 0){
                        //Cancel the wallet transaction
                        if(in_array(5, $orderPaymentAttributes['payment_mode'])){
                            //Reserve Wallet
                            $wallet_type_id = 8;
                        } else {
                            $wallet_type_id = 1;
                        }
                        /*if($orderPayment->payment_mode == 5){
                            //Reserve Wallet
                            $wallet_type_id = 8;
                        } else {
                            $wallet_type_id = 1;
                        }*/
                        $wallet = Wallet::model()->findByAttributes(['wallet_type_id'=>$wallet_type_id,
                            'reference_num'=>$model->order_id]);
                        if(isset($wallet->wallet_id)){
                            $wallet->transaction_status = Yii::app()->params['WalletRejectedTransactionStatus'];
                            $wallet->modified_at = date('Y-m-d H:i:s');
                            $wallet->save(false);
                        }
                    }
                }
                if ($model->save()) {
                    if($model->order_status == 1 and $previousOrderStatus!=1){
                        OrderHelper::updateToSuccess($model->order_id);
                        $voucher_code = $model->voucher_code;
                        if(!empty($voucher_code)){
                            VoucherHelper::updateVoucherToSuccess($voucher_code, $model->order_info_id);
                        }
                    }
                    $this->redirect(array('view', 'id' => $model->order_info_id));
                }
            }
        }
        $productName = Yii::app()->db->createCommand()->select('product_id,name,price')->from('product_info')->queryAll();
        $price = [];
        foreach($productName as $value){
            $price[$value['product_id']] = $value['price'];
        }
        $this->render('update', array(
            'model' => $model,
            'orderItem' => $orderItem,
            'orderPayment' => $orderPayment,
            'productName' => $productName,
            'price' => $price
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        date_default_timezone_set('Europe/Berlin');
        $orders = OrderLineItem::model()->findByAttributes(['order_info_id' => $id]);
        if (!empty($orders)) {
            OrderLineItem::model()->deleteAll("order_info_id ='" . $id . "'");
        }
        $orderPayment = OrderPayment::model()->findByAttributes(['order_info_id' => $id]);
        if (!empty($orderPayment)) {
            OrderPayment::model()->deleteAll("order_info_id ='" . $id . "'");
        }
        $creditMemo = OrderCreditMemo::model()->findByAttributes(['order_info_id' => $id]);
        if (!empty($creditMemo)) {
            OrderCreditMemo::model()->deleteAll("order_info_id ='" . $id . "'");
        }
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->redirect(['admin']);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        date_default_timezone_set('Europe/Berlin');
        $model = new OrderInfo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrderInfo']))
            $model->attributes = $_GET['OrderInfo'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*
    * Credit Memo
    */
    public function actionCreditMemo($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order = OrderInfo::model()->findByPk($_POST['order_info_id']);
            $licenseCount = CbmUserLicenses::model()->findByAttributes(['user_id'=>$order->user_id]);

            $creditMemo = new OrderCreditMemo();
            $creditMemo->order_info_id = $order->order_info_id;
            $creditMemo->invoice_number = $order->invoice_number;
            $creditMemo->vat = $order->vat;
            $creditMemo->order_total = $_POST['refund_amount'];
            $creditMemo->refund_amount = $order->netTotal;
            $creditMemo->created_at = date('Y-m-d H:i:s');

            //As CBM is for only one product - CBM Licenses
            $cancelled_qty = $_POST['OrderCreditMemo']['qty_refund'][0];
            if(($licenseCount->available_licenses >= $cancelled_qty)){
                if ($creditMemo->save()) {
                    foreach ($_POST['OrderCreditMemo']['order_line_item_id'] as $key => $value) {
                        if ($_POST['OrderCreditMemo']['qty_refund'][$key] >= 0) {
                            $orderCreditItem = new OrderCreditItems();
                            $orderCreditItem->credit_memo_id = $creditMemo->credit_memo_id;
                            $lineItem = OrderLineItem::model()->findByPk($value);
                            $orderCreditItem->attributes = $lineItem->attributes;
                            $orderCreditItem->product_price = ($lineItem->item_price-$lineItem->item_disc);
                            $orderCreditItem->order_item_qty = $lineItem->item_qty;
                            $orderCreditItem->refund_item_qty = $_POST['OrderCreditMemo']['qty_refund'][$key];
                            $orderCreditItem->save(false);
                        }
                    }
                    //Put Order in canceled state
                    $order->order_status = 0;
                    $order->modified_date = date('Y-m-d H:i:s');
                    $order->save(false);

                    //Generate refunds
                    OrderHelper::generateRefundAffiliates($order->order_id);

                    //Remove available licenses
                    $licenseCount->total_licenses -= $cancelled_qty;
                    $licenseCount->available_licenses -= $cancelled_qty;
                    $licenseCount->modified_at = date('Y-m-d H:i:s');
                    $licenseCount->save(false);

                    $url = Yii::app()->createUrl('admin/orderCreditMemo');
                    $this->redirect($url);
                } else {
                    print('<pre>');
                    print_r($creditMemo->errors);
                    exit;
                }
            } else {
                $model = $this->loadModel($id);
                $orderItem = OrderLineItem::model()->findAll('order_info_id =' . $model->order_info_id);
                $creditMemo = new OrderCreditMemo();
                $this->render('creditMemo', [
                    'order' => $model,
                    'orderItem' => $orderItem,
                    'creditMemo' => $creditMemo,
                    'error' => 'Licenses are used already...order cannot be cancelled'
                ]);
            }
        } else {
            $model = $this->loadModel($id);
            $orderItem = OrderLineItem::model()->findAll('order_info_id =' . $model->order_info_id);
            $creditMemo = new OrderCreditMemo();
            $this->render('creditMemo', [
                'order' => $model,
                'orderItem' => $orderItem,
                'creditMemo' => $creditMemo,
                'error' => ''
            ]);
        }
    }

    /**
     * Old One
     * Credit Memo Create using post
     */
    public function actionCreditMemoCreate()
    {
        date_default_timezone_set('Europe/Berlin');

        $creditMemo = new OrderCreditMemo();

        if (isset($_POST)) {
            try {
                //get Product Name
                $productPrice = ProductInfo::model()->findByAttributes(['product_id' => $_POST['productId']]);
                $refundAmount = $productPrice->price * $_POST['qty'];

                // Add details in credit memo
                $creditMemo->product_id = $_POST['productId'];
                $creditMemo->order_info_id = $_POST['orderId'];
                $creditMemo->qty_refunded = $_POST['qty'];
                $creditMemo->invoice_number = $_POST['invoiceNo'];
                $creditMemo->memo_status = $_POST['status'];
                $creditMemo->amount_to_refund = $refundAmount;
                $creditMemo->created_at = date('Y-m-d H:i:s');
                $creditMemo->modified_at = date('Y-m-d H:i:s');
                // validate credit memo
                if ($creditMemo->validate()) {
                    $creditMemo->save();
                }

                $orderItem = OrderLineItem::model()->findByAttributes(['order_info_id' => $_POST['orderId'], 'product_id' => $_POST['productId']]);
                $oldQty = $orderItem->item_qty;
                // set new quantity
                $newQty = $oldQty - $_POST['qty'];

                $memoPrice = $_POST['qty'] * $productPrice->price;
                $newPrice = $orderItem->item_price - $memoPrice;
                $orderItem->item_price = $newPrice;

                $orderItem->item_qty = $newQty;
                $orderItem->modified_at = date('Y-m-d H:i:s');
                $orderItem->save();
                $orderItem = OrderLineItem::model()->findByAttributes(['order_info_id' => $_POST['orderId'], 'product_id' => $_POST['productId']]);
                $orderQty = $orderItem->item_qty;
                if ($orderQty <= 0) {
                    OrderLineItem::model()->deleteAllByAttributes(['order_info_id' => $_POST['orderId'], 'product_id' => $_POST['productId']]);
                }

                $orderInfo = OrderInfo::model()->findByAttributes(['order_info_id' => $_POST['orderId']]);
                // set order total
                $oldTotal = $orderInfo->orderTotal;
                $newTotal = $oldTotal - $memoPrice;
                $orderInfo->orderTotal = $newTotal;

                // set order NetTotal
                $oldNetTotal = $orderInfo->netTotal;
                $newNetTotal = $oldNetTotal - $memoPrice;
                $orderInfo->netTotal = $newNetTotal;

                $orderInfo->modified_date = date('Y-m-d H:i:s');
                $orderInfo->save();
                $result = [
                    'result' => true,
                ];

            } catch (Exception $e) {
                $result = [
                    'result' => false,
                    'error' => $newNetTotal,
                ];
            }
        }
        echo json_encode($result);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return OrderInfo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = OrderInfo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param OrderInfo $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-info-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
    * Load address using user_id of user
    */
    public function actionLoadAddresses()
    {
        $data = AddressMapping::model()->findAll('user_id=:user_id',
            array(':user_id' => (int)$_POST['user_id']));


        $data = CHtml::listData($data, 'address_mapping_id', 'address_id');
        echo "<option value=''>Select Address</option>";
        foreach ($data as $value => $addressMappId) {
            $addressMappData = Addresses::model()->find('address_id=:address_id',
                array(':address_id' => (int)$addressMappId));
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($addressMappData->building_no . ', ' . $addressMappData->street . ', ' . $addressMappData->city . ', ' . $addressMappData->region), true);
        }
    }

    /*
    *
    */
    public function actionLoadPrice()
    {
        date_default_timezone_set('Europe/Berlin');

        if ($_POST['qty'] > 0) {
            $user = UserInfo::model()->findByAttributes(['user_id' => $_POST['user_id']]);
            $productDetail = ProductInfo::model()->findByPk($_POST['product_id']);
            //$productSubscription = $productDetail->is_subscription_enabled;
            $totalItemPrice = $productDetail->price * $_POST['qty'];
            $discount = $_POST['discount'];
            $totalDiscount = $_POST['qty'] * $discount;
            $subTotal = $totalItemPrice - $totalDiscount;
            $vatAmount = 0;
            $vatpercent = 0;
            if (isset($_POST['country'])) {
                $country = Countries::model()->findByAttributes(['id' => $_POST['country']]);
                $vatAmount = $subTotal * $country->personal_vat / 100;
            }
            if (isset($_POST['address'])) {
                if ($_POST['address'] == 0) {
                    $country = Countries::model()->findByAttributes(['id' => $user->country]);
                    if (empty($country)) {
                        $vatAmount = 0;
                        $vatpercent = 0;
                    } else {
                        $vatAmount = $subTotal * $country->personal_vat / 100;
                        $vatpercent = $country->personal_vat;
                    }
                } else {
                    $country = Countries::model()->findByAttributes(['id' => $user->busAddress_country]);
                    if (empty($country)) {
                        $vatAmount = 0;
                        $vatpercent = 0;
                    } else {
                        $vatAmount = $subTotal * $country->business_vat / 100;
                        $vatpercent = $country->business_vat;
                    }
                }
            }
            $vatincluded_amount = $totalItemPrice - $totalDiscount + $vatAmount;
            $result = [
                'result' => true,
                'productPrice' => $productDetail->price,
                'totalItemPrice' => $totalItemPrice,
                'vatAmount' => $vatAmount,
                'netTotal' => $vatincluded_amount,
                'subTotal' => $subTotal,
                'discount' => $discount,
                'vatpercent' => $vatpercent,
                'totalDiscount' => $totalDiscount
                //'productSubscription' => $productSubscription
            ];
        } else {
            $result = [
                'result' => false,
            ];
        }
        echo json_encode($result);
    }

    /*
    * get Address and business address
    */
    public function actionGetAddress()
    {
        date_default_timezone_set('Europe/Berlin');

        if (isset($_POST['user_id'])) {
            $users = UserInfo::model()->findByPk(['user_id' => $_POST['user_id']]);
            $country = Countries::model()->findByAttributes(['id' => $users->country]);
            $users->country = ServiceHelper::getCountryNameFromId($users->country);
            $country2 = Countries::model()->findByAttributes(['id' => $users->busAddress_country]);
            if (empty($country2)) {
                // $myresult = 'false';
            } else {
                $users->busAddress_country = ServiceHelper::getCountryNameFromId($users->busAddress_country);
                // $myresult = true;
            }
            $result = [
                'result' => true,
                'userInfo' => $users->attributes,
            ];
            //   if(empty($country2)){
            //   	$result = [
            // 	'result' => 'No',
            // ];
            //   }else{
            //   	$users->busAddress_country = $country2->country_name;
            // $result = [
            // 	'result' => true,
            // 	'userInfo' => $users->attributes,
            // ];
            //   }

        } else {
            $result = [
                'result' => false,
            ];
        }
        echo json_encode($result);
    }

    /**
     * save and update order item
     * @param $orderItemArray
     * @param $orderInfoId
     */
    protected function saveOrderItem($orderItemArray, $orderInfoId)
    {
        date_default_timezone_set('Europe/Berlin');

        foreach ($orderItemArray['product_id'] as $key => $value) {
            $product = ProductInfo::model()->findByPk($value);
            $orderItem = new OrderLineItem();
            $orderItem->order_info_id = $orderInfoId;
            $orderItem->product_name = $product->name;
            $orderItem->product_id = $product->product_id;
            $orderItem->product_sku = $product->sku;
            $orderItem->item_qty = $orderItemArray['item_qty'][$key];
            $orderItem->item_disc = $orderItemArray['item_disc'][$key];
            $orderItem->item_price = $orderItemArray['item_price'][$key];
            $orderItem->created_at = date('Y-m-d H:i:s');
            $orderItem->save(false);
        }

        /*$productname = $orderItemArray['product_name'][0];

        $productidsql = "SELECT product_id,sku from product_info WHERE product_id = "."'$productname'";
        $productinfo = Yii::app()->db->createCommand($productidsql)->queryAll();

        foreach ($orderItemArray['item_price'] as $key => $item){
            $orderItem = OrderLineItem::model()->findByAttributes(['order_info_id' => $orderInfoId, 'product_id' => $orderItemArray['product_name'][$key]]);
            if(!empty($orderItem)){
                $orderItem->item_qty = $orderItemArray['item_qty'][$key];
                $orderItem->item_disc = $orderItemArray['item_disc'][$key];
                $orderItem->item_price = $orderItemArray['item_price'][$key];
                $orderItem->modified_at = date('Y-m-d H:i:s');
                $orderItem->save();
            }else{
                // Item not exist then enter new data
                $orderItem =new OrderLineItem();
                $orderItem->order_info_id = $orderInfoId;
                $orderItem->product_name = $orderItemArray['product_name'][$key];
                $orderItem->product_id = $productinfo[$key]['product_id'];
                $orderItem->product_sku = $productinfo[$key]['sku'];
                $orderItem->item_qty = $orderItemArray['item_qty'][$key];
                $orderItem->item_disc = $orderItemArray['item_disc'][$key];
                $orderItem->item_price = $orderItemArray['item_price'][$key];
                $orderItem->created_at = date('Y-m-d H:i:s');
                $orderItem->modified_at = date('Y-m-d H:i:s');
                $orderItem->save();
            }
        }*/
    }

    /**
     * make total,net total and discount
     * @param $orderItemArray
     * @return array
     */
    protected function getOrderAllTotal($orderItemArray)
    {
        $itemPriceTotal = 0;
        $itemDiscTotal = 0;
        foreach ($orderItemArray['item_price'] as $key => $item) {
            if(!empty($orderItemArray['item_price'][$key]) && $orderItemArray['item_price'][$key] != ''){
                $itemPriceTotal += ($orderItemArray['item_price'][$key] * $orderItemArray['item_qty'][$key]);
            }
            if(!empty($orderItemArray['item_disc'][$key]) && $orderItemArray['item_disc'][$key] != ''){
                $itemDiscTotal += ($orderItemArray['item_disc'][$key] * $orderItemArray['item_qty'][$key]);
            }else{
                $itemDiscTotal += 0;
            }
            
        }
        $result = [
            'orderTotal' => $itemPriceTotal,
            'orderDiscount' => $itemDiscTotal,
            //'netTotal' => $itemPriceTotal - $itemDiscTotal
        ];
        return $result;
    }

    /**
     * @param $userLicenseData
     * @param $purchaseProductId
     */
    protected function saveUserLicenseCount($userLicenseData, $purchaseProductId)
    {
        date_default_timezone_set('Europe/Berlin');

        foreach ($userLicenseData['product_id'] as $key => $productId) {
            $product_ids = ProductLicenses::model()->findAllByAttributes(['purchase_product_id' => $productId]);
            foreach ($product_ids as $key2 => $licenseProductId) {
                $userLicenses = UserLicenses::model()->findByAttributes(['product_id' => $licenseProductId->product_id, 'user_id' => $purchaseProductId]);

                if (!empty($userLicenses)) {
                    $userLicenses->product_id = $licenseProductId->product_id;
                    $userLicenses->license_no = $licenseProductId->license_no;
                    $userLicenses->user_id = $purchaseProductId;
                    $userLicenses->is_used = 1;
                    $userLicenses->funded_on = date('Y-m-d H:i:s');
                    $userLicenses->created_at = date('Y-m-d H:i:s');
                    if ($userLicenses->validate()) {
                        $userLicenses->save();
                    }
                } else {
                    $userLicenses = new UserLicenses();
                    $userLicenses->product_id = $licenseProductId->product_id;
                    $userLicenses->license_no = $licenseProductId->license_no;
                    $userLicenses->user_id = $purchaseProductId;
                    $userLicenses->is_used = 1;
                    $userLicenses->funded_on = date('Y-m-d H:i:s');
                    $userLicenses->created_at = date('Y-m-d H:i:s');
                    if ($userLicenses->validate()) {
                        $userLicenses->save();
                    }
                }
            }
        }
    }


    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata()
    {

        $requestData = $_REQUEST;

        $model = new OrderInfo();
        $array_cols = Yii::app()->db->schema->getTable('order_info')->columns;
        $array = array();
        $i = 0;
        foreach ($array_cols as $key => $col) {
            $array[$i] = $col->name;
            $i++;
        }
        /*$columns = array(
            0 => 'user_id',
            1 => 'full_name'
        );*/
        $columns = $array;

        $sql = "SELECT  * from order_info where 1=1";

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( order_info_id LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach ($array_cols as $key => $col) {
                if ($col->name != 'order_info_id') {
                    $sql .= " OR " . $col->name . " LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql .= ")";
//			$sql.=" OR employee_age LIKE '" . $requestData['search']['value'] . "%')";

        }

        $j = 0;
        // getting records as per search parameters
        foreach ($columns as $key => $column) {
            if ($requestData['columns'][$key]['search']['value'] != '') {   //name
                //echo"<prE>";print_r($column);
                if ($column == 'user_id') {
                    $sql .= " AND  user_id = " . $requestData['columns'][$key]['search']['value'] . " ";
                } elseif ($column == 'invoice_date' && $requestData['min'] != '' && $requestData['max'] != '') {
                    $sql .= " AND cast(invoice_date as date) between '$requestData[min]' and '$requestData[max]'";
                } else {
                    $sql .= " AND $column LIKE '%" . $requestData['columns'][$key]['search']['value'] . "%' ";
                }
                //echo $sql;
            }
            $j++;
        }//die;

        // echo $sql;die;

        $count_sql = str_replace("*", "count(*) as columncount", $sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;

        if ($columns[$requestData['order'][0]['column']] == 'user_id') {
            $sql .= " ORDER BY  user_name  " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
                $requestData['length'] . "   ";
        } else {
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
                $requestData['length'] . "   ";
        }
        // $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
        // 	$requestData['length'] . "   ";

        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i = 1;

        foreach ($result as $key => $row) {
            // echo "<pre>";    print_r($row);
            $nestedData = array();
            // $nestedData[] = $row['order_info_id'];
            if (ctype_alpha($row['country'])) {
                $countrycode = $row['country'];
                $country_sql = "select country_name from countries where country_code = " . "'$countrycode'";
                $country_name = Yii::app()->db->createCommand($country_sql)->queryAll();
                if (!empty($country_name)) {
                    $row['country'] = $country_name[0]['country_name'];
                }
            } else if (is_numeric($row['country'])) {
                $countryid = $row['country'];
                $country_sql = "select country_name from countries where id = " . "'$countryid'";
                $country_name = Yii::app()->db->createCommand($country_sql)->queryAll();
                if (!empty($country_name)) {
                    $row['country'] = $country_name[0]['country_name'];
                }
            }
            $row['is_subscription_enabled'] = $row['is_subscription_enabled'] == 0 ? ('No') : ('Yes');

            $row['user_id'] = $row['user_name'] . "<br><p class='text-muted'>" . $row['email'] . "</p>";;
            foreach ($array_cols as $key => $col) {
                $nestedData[] = $row["$col->name"];
            }

            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data   // total data array
        );

        echo json_encode($json_data);
    }

    /**
     * Manages data for server side datatables.
     */
    public function actionUserwallet($id)
    {
//        echo $id;die;
        /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
        echo json_encode($alldata);*/

        $requestData = $_REQUEST;

//		$model= new wallet();
        $array_cols = Yii::app()->db->schema->getTable('wallet')->columns;
        $array = array();
        $i = 0;
        foreach ($array_cols as $key => $col) {
            $array[$i] = $col->name;
            $i++;
        }
        /*$columns = array(
            0 => 'user_id',
            1 => 'full_name'
        );*/
        $columns = $array;

        $sql = "SELECT  * from wallet where user_id=" . $id;
//		$data = Yii::app()->db->createCommand($sql)->queryAll();
//		$totalFiltered = count($data);

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( wallet_id LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach ($array_cols as $key => $col) {
                if ($col->name != 'id') {
                    $sql .= " OR " . $col->name . " LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql .= ")";
//			$sql.=" OR employee_age LIKE '" . $requestData['search']['value'] . "%')";

        }

        $j = 0;
        // getting records as per search parameters
        foreach ($columns as $key => $column) {
            if ($requestData['columns'][$key]['search']['value'] != '') {   //name
                if ($column == 'user_id') {
                    $sql .= " AND  user_id = " . $requestData['columns'][$key]['search']['value'] . " ";
                } else {
                    $sql .= " AND $column LIKE '%" . $requestData['columns'][$key]['search']['value'] . "%' ";
                }
            }
            $j++;
        }

//		echo $sql;die;

        $count_sql = str_replace("*", "count(*) as columncount", $sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;

        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";

        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i = 1;

        foreach ($result as $key => $row) {
            $nestedData = array();
            $nestedData[] = $row['wallet_id'];

            $wallettypesql = "select wallet_type from wallet_type_entity where wallet_type_id =" . "'$row[wallet_type_id]'";
            $wallettypenames = Yii::app()->db->createCommand($wallettypesql)->queryAll();

            $denominationsql = "select denomination_type from denomination where denomination_id=" . "'$row[denomination_id]'";
            $denominations = Yii::app()->db->createCommand($denominationsql)->queryAll();

            $row['wallet_type_id'] = $wallettypenames[0]['wallet_type'];
            $row['denomination_id'] = $denominations[0]['denomination_type'];

            switch ($row['transaction_status']) {
                case 0 :
                    $row['transaction_status'] = "<span align='center' class='label label-table label-warning'>Pending</span>";
                    break;
                case 1:
                    $row['transaction_status'] = "<span align='center' class='label label-table label-primary'>On Hold</span>";
                    break;
                case 2:
                    $row['transaction_status'] = "<span align='center' class='label label-table label-success'>Approved</span>";
                    break;
                case 3:
                    $row['transaction_status'] = "<span align='center' class='label label-table label-danger'>Rejected</span>";
                    break;
                default:
                    break;
            }
            switch ($row['transaction_type']) {
                case 0:
                    $row['transaction_type'] = 'Credit';
                    break;
                case 1:
                    $row['transaction_type'] = 'Debit';
                    break;
                default:
                    break;
            }

            foreach ($array_cols as $key => $col) {
                $nestedData[] = $row["$col->name"];
            }
            $data[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data   // total data array
        );

        echo json_encode($json_data);
    }
}
