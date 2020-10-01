<?php

class OrderHelper extends CApplicationComponent
{
    public static function CreateOrderInfo($data = array())
    {
        $order = OrderInfo::model()->findByAttributes(['order_id' => $data['order_id']]);
        if ($order) {
            $order->attributes = $data;
            $order->modified_date = date('Y-m-d H:i:s');
        } else {
            $order = new OrderInfo();
            $order->attributes = $data;
            $order->created_date = date('Y-m-d H:i:s');
        }
        if(isset($data['order_comment'])){
            $order->order_comment = $data['order_comment'];
        }
        $order->save(false);
        return $order->order_info_id;
    }

    //Old CreateOrderPayment which is still in use...so not to delete it
    public static function CreateOrderPayment($data = array())
    {
        $model = OrderPayment::model()->findByAttributes(['order_info_id' => $data['order_info_id']]);
        if ($model) {
            $model->attributes = $data;
            $model->modified_at = date('Y-m-d H:i:s');
        } else {
            $model = new OrderPayment();
            $model->attributes = $data;
            $model->created_at = date('Y-m-d H:i:s');
        }
        $model->save(false);
        return $model->payment_id;
    }

    //New order payment function supporting multiple payments for a single order
    public static function orderPayment($order_info_id, $total, $denomination_id, $payment_ref_id, $payment_status, $payment_mode,
                                        $transaction_mode, $payment_date, $created_at){
        $orderPayment = new OrderPayment();
        $orderPayment->order_info_id = $order_info_id;
        $orderPayment->total = $total;
        $orderPayment->denomination_id = $denomination_id;
        $orderPayment->payment_ref_id = $payment_ref_id;
        $orderPayment->payment_status = $payment_status;
        $orderPayment->payment_mode = $payment_mode;
        $orderPayment->transaction_mode = $transaction_mode;
        $orderPayment->payment_date = $payment_date;
        $orderPayment->created_at = $created_at;
        $orderPayment->save(false);
    }

    public static function getSubscriptionDurationDenomination($number)
    {
        $denomination = '';
        if ($number == 1)
            $denomination = 'Days';
        elseif ($number == 2)
            $denomination = 'Weeks';
        elseif ($number == 3)
            $denomination = 'Months';
        elseif ($number == 4)
            $denomination = 'Years';
        return $denomination;
    }

    //Create New Invoice Number
    public static function getInvoiceNumber()
    {
        $connection = Yii::app()->db;
        $currentYear = date('y');
        //finding missing invoice no if available in database.
        $row = "SELECT (t1.invoice_number + 1) as gap_starts_at, (SELECT MIN(t3.invoice_number) -1 FROM order_info t3 WHERE t3.invoice_number > t1.invoice_number) as gap_ends_at FROM order_info t1 WHERE NOT EXISTS (SELECT t2.invoice_number FROM order_info t2 WHERE t2.invoice_number = t1.invoice_number + 1) AND t1.invoice_number LIKE '" . $currentYear . "%' HAVING gap_ends_at IS NOT NULL";
        $command = $connection->createCommand($row);
        $missingInvoice = $command->queryRow();
        if (empty($missingInvoice['gap_starts_at'])) {

            $prefix = $currentYear;
            $maxInvoice = Yii::app()->db->createCommand()
                ->select('max(invoice_number) as invoice_num')
                ->from('order_info')
                ->queryRow();
            if (isset($maxInvoice['invoice_num'])) {
                $currentYear = date('y');
                $LastInvoiceYear = substr($maxInvoice['invoice_num'], 0, 2);
                if ($currentYear == $LastInvoiceYear) {
                    $newInvoice = str_pad(((int)$maxInvoice['invoice_num'] + 1), 4, '0', STR_PAD_LEFT);
                } else {
                    $newInvoice = $currentYear . str_pad(1, 4, '0', STR_PAD_LEFT);
                }
                // $newInvoice = str_pad(((int)$maxInvoice['invoice_num'] + 1), 4, '0', STR_PAD_LEFT);
            } else {
                $newInvoice = $prefix . str_pad(1, 4, '0', STR_PAD_LEFT);
            }
            return $newInvoice;
        } else {
            $newInvoice = $missingInvoice['gap_starts_at'];
            return $newInvoice;
        }

    }

    //Get PayPal access token
    public static function getPayPalAccessToken()
    {

        $base64String = Yii::app()->params['PayPalClientId'].":".Yii::app()->params['PayPalSecretId'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => Yii::app()->params['PayPalUrl']."/v1/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ".base64_encode($base64String),
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $logs = new CbmLogs();
            $logs->status = 2;
            $logs->created_date = date('Y-m-d H:i:s');
            $logs->log = "PayPal initialization error: " .$err;
            $logs->save(false); // saving logs
        } else {
            $result = json_decode($response);
            return $result->access_token;
        }
    }

    public static function getTemporaryLogin()
    {
        $cbmAccounts = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cbm_accounts')
            ->where('login like :t', [':t' => 'T%'])
            ->queryAll();
        $newNum = 1;
        if (count($cbmAccounts) > 0) {
            foreach ($cbmAccounts as $cbmAccount) {
                $loginNum = (int)substr($cbmAccount['login'], 2);
                if ($loginNum > $newNum) {
                    $newNum = $loginNum;
                }
            }
            $newLogin = 'T' . ($newNum + 1);
        } else {
            $newLogin = 'T' . $newNum;
        }

        return $newLogin;
    }

    //Order Confirmation Mail
    public static function orderConfirmationMail($orderInfoId)
    {
        $order = OrderInfo::model()->findByPk($orderInfoId);
        $orderLineItem = OrderLineItem::model()->findAllByAttributes(['order_info_id' => $orderInfoId]);
        $orderPayment = OrderPayment::model()->findAllByAttributes(['order_info_id' => $orderInfoId]);
        $user = UserInfo::model()->findByPk($order->user_id);
        $dashBoardUrl = Yii::app()->createAbsoluteUrl('home/login');
        $orderItems = array();
        foreach ($orderLineItem as $item) {
            $product = ProductInfo::model()->findByPk($item->product_id);
            $temp = array();
            $temp['name'] = $item->product_name;
            $temp['image'] = Yii::app()->getBaseUrl(true) . $product->image;
            $temp['quantity'] = $item->item_qty;
            $temp['price'] = $item->item_price;
            array_push($orderItems, $temp);
        }
        if (isset($order->order_info_id)) {
            $mail = new YiiMailer('order', [
                'full_name' => $user->full_name,
                'first_name' => $user->first_name,
                'dashBoardURL' => $dashBoardUrl,
                'order' => $order,
                'orderItems' => $orderItems,
                'orderPayment' => $orderPayment
            ]);
            $mail->setFrom('info@cbmglobal.io', 'CBM Global');
            $mail->setSubject("Order Confirmation");
            $mail->setTo($user->email);
            $mail->send();
        }
    }

    //Affiliate Level 1 Commission
    public static function affiliateLevelOne($fromName, $toUserId)
    {
        $user = UserInfo::model()->findByPk($toUserId);
        if (isset($user->user_id) && $user->user_id != 1) {
            $mail = new YiiMailer('affiliate-level-one', [
                'from_name' => $fromName,
                'to_name' => $user->full_name
            ]);
            $mail->setFrom('info@cbmglobal.io', 'CBM Global');
            $mail->setSubject("Affiliate Level One Commission");
            $mail->setTo($user->email);
            $mail->send();
        }
    }

    //Affiliate Level 2 Commission
    public static function affiliateLevelTwo($fromName, $toUserId)
    {
        $user = UserInfo::model()->findByPk($toUserId);
        if (isset($user->user_id) && $user->user_id != 1) {
            $mail = new YiiMailer('affiliate-level-two', [
                'from_name' => $fromName,
                'to_name' => $user->full_name
            ]);
            $mail->setFrom('info@cbmglobal.io', 'CBM Global');
            $mail->setSubject("Affiliate Level Two Commission");
            $mail->setTo($user->email);
            $mail->send();
        }
    }

    //Extra License Mail
    public static function buyExtraLicense($email, $name, $license)
    {
        $mail = new YiiMailer('buy-extra-licenses', [
            'email' => $email,
            'name' => $name,
            'licenses' => $license
        ]);
        $mail->setFrom('info@cbmglobal.io', 'CBM Global');
        $mail->setSubject("Buy Extra License");
        $mail->setTo($email);
        $mail->send();
    }

    //Generate Affiliate Commission
    public static function generateAffiliateCommission($orderId)
    {
        $order = OrderInfo::model()->findByAttributes(['order_id' => $orderId]);
        $user = UserInfo::model()->findByPk($order['user_id']);
        $systemId = Yii::app()->params['SystemUserId'];

        //Wallet type is User
        $wallet_type = WalletTypeEntity::model()->findByAttributes(['wallet_type' => 'User']);
        $num_licenses = $order->orderTotal / Yii::app()->params['LicenseCost'];

        //credits
        $level1_credit = $num_licenses * Yii::app()->params['LevelOneAffiliateCommission'];
        $level2_credit = $num_licenses * Yii::app()->params['LevelTwoAffiliateCommission'];

        //Comments
        $level1_comment = "Level 1 Affiliate commission from user_id " . $user->user_id . " for order_id " . $orderId;
        $level2_comment = "Level 2 Affiliate commission from user_id " . $user->user_id . " for order_id " . $orderId;

        //Default parent
        $level1_user_id = $systemId;
        $level2_user_id = $systemId;

        if (isset($user->sponsor_id)) {
            $level1_parent = UserInfo::model()->findByPk($user->sponsor_id);
            $level1_user_id = $level1_parent->user_id;

            //Distribute Level One Commission
            WalletHelper::addToWallet($level1_parent->user_id, $wallet_type->wallet_type_id, 0, 3,
                $orderId, $level1_comment, 1, 2, 1, $level1_credit,
                date('Y-m-d H:i:s'));

            if (isset($level1_parent->sponsor_id)) {
                $level2_parent = UserInfo::model()->findByPk($level1_parent->sponsor_id);
                $level2_user_id = $level2_parent->user_id;

                //Distribute Level One Commission
                WalletHelper::addToWallet($level2_parent->user_id, $wallet_type->wallet_type_id, 0, 3,
                    $orderId, $level2_comment, 1, 2, 1, $level2_credit,
                    date('Y-m-d H:i:s'));

            } else {
                //Level Two Commission to System
                WalletHelper::addToWallet($systemId, $wallet_type->wallet_type_id, 0, 3,
                    $orderId, $level2_comment, 1, 2, 1, $level2_credit,
                    date('Y-m-d H:i:s'));
            }
        } else {
            //Level One Commission to System
            WalletHelper::addToWallet($systemId, $wallet_type->wallet_type_id, 0, 3,
                $orderId, $level1_comment, 1, 2, 1, $level1_credit,
                date('Y-m-d H:i:s'));

            //Level Two Commission to System
            WalletHelper::addToWallet($systemId, $wallet_type->wallet_type_id, 0, 3,
                $orderId, $level2_comment, 1, 2, 1, $level2_credit,
                date('Y-m-d H:i:s'));
        }

        self::affiliateLevelOne($user->full_name, $level1_user_id);
        self::affiliateLevelTwo($user->full_name, $level2_user_id);
    }

    public static function generateRefundAffiliates($orderId){
        $affiliateWallet = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Affiliate Commission']);
        $affiliates = Wallet::model()->findAllByAttributes([
            'reference_id'=>$affiliateWallet->reference_id,
            'reference_num'=>$orderId,
            'transaction_status'=>2
            ]);
        $order = OrderInfo::model()->findByAttributes(['order_id'=>$orderId]);
        foreach ($affiliates as $value){

            $commentArr = explode('commission',$value->transaction_comment);
            $reqComment = $commentArr[0] . 'refund' . $commentArr[1];

            //addToWallet($userId, $walletTypeId, $transactionType, $referenceId, $referenceNum,$transactionComment, $denominationID, $transactionStatus, $portalId, $creditAmount, $createdDate)
            WalletHelper::addToWallet($value->user_id, $value->wallet_type_id, Yii::app()->params['DebitTransactionType'], 3,
                $orderId, $reqComment, 1, 2, 1, $value->amount,
                $order->modified_date);
        }
    }

    public static function updateToSuccess($orderId)
    {
        $model = OrderInfo::model()->findByAttributes(['order_id' => $orderId]);

        OrderHelper::generateAffiliateCommission($model->order_id);
        OrderHelper::orderConfirmationMail($model->order_info_id);
        //OrderHelper::updateUserStatus($orderId);

        $cbm_accounts = CbmAccounts::model()->findAllByAttributes(['email_address' => $model->email]);
        foreach ($cbm_accounts as $cbm_account){
            if (isset($cbm_account->login)) {
                OrderHelper::generateCBMNodes($cbm_account->login);
            }
        }
    }

    /*
     * Update complete Order to successful state
     * */
    public static function completeOrderSuccess($order_id, $payment_mode){
        $order = OrderInfo::model()->findByAttributes(['order_id'=>$order_id]);
        $orderItem = OrderLineItem::model()->findAllByAttributes(['order_info_id' => $order->order_info_id]);
        $orderPayment = OrderPayment::model()->find('order_info_id =' . $order->order_info_id);
        $reserveWalletType = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>Yii::app()->params['ReserveWallet']]);

        $cbmAgent = Yii::app()->params['CBMAgentNumber'];

        $orderPayment->payment_mode = $payment_mode;
        if ($payment_mode == 1) {
            $orderPayment->transaction_mode = 'Ingenico';
        } elseif ($payment_mode == 2) {
            $orderPayment->transaction_mode = 'Bank Transfer';
        } elseif ($payment_mode == 3) {
            $orderPayment->transaction_mode = 'Stripe';
        } elseif ($payment_mode == 5) {
            $orderPayment->transaction_mode = Yii::app()->params['ReserveWallet'];

            $transactionComment = "Reserved-Pending Order Id".$order_id." updated to success state";
            //Deduct from Reserve Wallet Balance
            WalletHelper::addToWallet($order->user_id, $reserveWalletType->wallet_type_id, Yii::app()->params['DebitTransactionType'],
                6, $order_id, $transactionComment, 1, Yii::app()->params['WalletApprovedTransactionStatus'],
                1, $order->netTotal, date('Y-m-d H:i:s'));
            //Update pending state wallet tuple of reserve-wallet to success state
            /*$wallet = Wallet::model()->findByAttributes(['wallet_type_id'=>$reserveWalletType->wallet_type_id,
                'reference_id'=>6,
                'transaction_type'=>Yii::app()->params['DebitTransactionType'],
                'reference_num'=>$order_id]);
            if(isset($wallet->wallet_id)){
                $wallet->transaction_status = Yii::app()->params['WalletApprovedTransactionStatus'];
                $wallet->modified_at = date('Y-m-d H:i:s');
                $wallet->save(false);
            }*/
        } else {
            $orderPayment->transaction_mode = 'Paypal';
        }
        $orderPayment->payment_status = 1;
        $orderPayment->payment_date = date('Y-m-d H:i:s');
        $orderPayment->modified_at = date('Y-m-d H:i:s');
        $orderPayment->save(false);

        $order->order_status = 1;
        $order->invoice_number = OrderHelper::getInvoiceNumber();
        $order->invoice_date = date('Y-m-d H:i:s');
        $order->modified_date = date('Y-m-d H:i:s');
        $order->save(false);

        //Add Licenses to CBM Order Licenses
        foreach ($orderItem as $item) {
            $orderLicense = new CbmOrderLicenses();
            $orderLicense->user_id = $order->user_id;
            $orderLicense->order_info_id = $order->order_info_id;
            $orderLicense->product_id = $item->product_id;
            $orderLicense->product_name = $item->product_name;
            $orderLicense->licenses = $item->item_qty;
            $orderLicense->modified_date = date('Y-m-d H:i:s');
            $orderLicense->save(false);

            ServiceHelper::modifyCBMUserLicenses($order->user_id, $order->email, $item->item_qty, $item->item_qty);
        }

        OrderHelper::updateToSuccess($order->order_id);
    }

    public static function updateUserStatus($orderId)
    {
        try {
            $order = OrderInfo::model()->findByAttributes(['order_id' => $orderId]);
            $user = UserInfo::model()->findByPk($order->user_id);

            if ($order->order_status == 1) {
                $orderLineItem = OrderLineItem::model()->findAllByAttributes(['order_info_id' => $order->order_info_id]);
                foreach ($orderLineItem as $item) {
                    $productId = $item->product_id;
                    $registration_step = RegistrationSteps::model()->findByAttributes(['product_id' => $productId, 'status_name' => 'BUYING LICENSES']);
                    $registration_status = RegistrationStatus::model()->findByAttributes(['user_id' => $user->user_id, 'product_id' => $productId]);
                    if (isset($registration_status->id)) {
                        if ($registration_status->step_number < $registration_step->step_number) {
                            $registration_status->step_number = $registration_step->step_number;
                            $registration_status->modified_at = date('Y-m-d H:i:s');
                        }
                    } else {
                        $registration_status = new RegistrationStatus();
                        $registration_status->user_id = $user->user_id;
                        $registration_status->product_id = $productId;
                        $registration_status->email = $user->email;
                        $registration_status->step_number = $registration_step->step_number;
                    }
                    $registration_status->save(false);
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $logs = new CbmLogs();
            $logs->status = 0;
            $logs->created_date = date('Y-m-d H:i:s');
            $logs->log = 'Update Registration Step Logs: ' . $e->getMessage();
            $logs->save(false); // saving logs
        }
    }

    public static function addLog($status, $log){
        $logs = new CbmLogs();
        $logs->status = $status;
        $logs->created_date = date('Y-m-d H:i:s');
        $logs->log = $log;
        $logs->save(false);
    }
}