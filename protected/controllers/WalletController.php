<?php

class WalletController extends Controller
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
        }
        return parent::beforeAction($action);

    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        setlocale(LC_MONETARY, 'nl_NL.UTF-8');
        $userId = Yii::app()->user->getId();
        $user = UserInfo::model()->findByPk($userId);
        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);


        //To calculate max Balance
        $walletData = Yii::app()->db->createCommand()
            ->select('sum(case when transaction_type = 0 then amount else 0 end) as credit_amt')
            ->from('wallet')
            ->where('user_id=:uid',[':uid'=>$userId])
            ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
            ->queryRow();
        $maxBalance = $walletData['credit_amt'];
        $balance = WalletHelper::getUserWalletEarnings($userId);

        //Total Payouts
        $payout_reference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Payout']);
        $payoutRef = Yii::app()->db->createCommand()
            ->select('sum(amount) as amount')
            ->from('wallet')
            ->where('user_id=:uid',[':uid'=>$userId])
            ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
            ->andWhere('transaction_type=:type',[':type'=>Yii::app()->params['DebitTransactionType']])
            ->andWhere('reference_id=:rId',[':rId'=>$payout_reference->reference_id])
            ->queryRow();
        if(isset($payoutRef['amount'])){
            $totalPayouts = $payoutRef['amount'];
        } else {
            $totalPayouts = 0;
        }

        $this->render('index', [
            'balance' => $balance,
            'max_balance' => $maxBalance,
            'total_payout' => $totalPayouts
        ]);
    }

    public function actionGetAllTransactionsData(){
        if(isset($_POST['data'])){
            $requiredAttr = $_POST['data'];

            /*
             *  Static All Transactions Values
             *  0 -> All
             *  1 -> Cash back Earnings
             *  2 -> Affiliates
             *  3 -> Payouts
             *  4 -> Order Payments
             * */

            //For Affiliate earnings commission scheme
            $affiliate_reference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Affiliate Commission']);
            //For Payouts
            $payout_reference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Payout']);
            //For Order Payment reference
            $order_payment_reference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>Yii::app()->params['WalletTransactions']]);
            //For Reserve Wallet
            $userId = Yii::app()->user->getId();
            $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
            $allTransactionsData = [];

            foreach ($requiredAttr as $item){
                if($item == 0){
                    //The below query will give wrong result as reference number is required for grouping in payout
                    //while it is not required for others
                    //Moreover item with zero value has been removed from frontend and Cashback reference has also been removed
                    $commissionRecords = Yii::app()->db->createCommand()
                        ->select('sum(amount) as amount, transaction_comment, transaction_status, reference_id, reference_num')
                        ->from('wallet')
                        ->where('user_id=:uid',[':uid'=>$userId])
                        ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
                        ->andWhere('transaction_type=:type',[':type'=>Yii::app()->params['CreditTransactionType']])
                        ->andWhere(['in','reference_id',[$affiliate_reference->reference_id, $payout_reference->reference_id]])
                        ->group('reference_id, transaction_comment, transaction_status, reference_id, reference_num')
                        ->order('created_at desc')
                        ->queryAll();

                }   elseif ($item == 1){
                    //Direct sales commissiom
                    $commissionRecords = Yii::app()->db->createCommand()
                        ->select('sum(amount) as amount, transaction_comment, transaction_status, reference_id, reference_num, created_at')
                        ->from('wallet')
                        ->where('user_id=:uid',[':uid'=>$userId])
                        ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
                        ->andWhere('transaction_type=:type',[':type'=>Yii::app()->params['CreditTransactionType']])
                        ->andWhere(['like','transaction_comment','%Direct Sale Bonus due to order_id%'])
                        ->group('reference_id, transaction_comment, transaction_status, reference_num, created_at')
                        ->order('created_at desc')
                        ->queryAll();
                } elseif ($item == 2){
                    //Affiliates
                    $commissionRecords = Yii::app()->db->createCommand()
                        ->select('amount, transaction_comment, transaction_status, transaction_type, reference_id, reference_num, created_at')
                        ->from('wallet')
                        ->where('user_id=:uid',[':uid'=>$userId])
                        ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
                        ->andWhere('reference_id=:rId',[':rId'=>$affiliate_reference->reference_id])
                        ->order('created_at desc')
                        ->queryAll();
                } elseif ($item == 3){
                    //Payouts
                    $commissionRecords = Yii::app()->db->createCommand()
                        ->select('sum(amount) as amount, transaction_comment, transaction_status, reference_id, reference_num, created_at')
                        ->from('wallet')
                        ->where('user_id=:uid',[':uid'=>$userId])
                        ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
                        ->andWhere('transaction_type=:type',[':type'=>Yii::app()->params['DebitTransactionType']])
                        ->andWhere('reference_id=:rId',[':rId'=>$payout_reference->reference_id])
                        ->group('reference_id, transaction_comment, transaction_status, reference_num')
                        ->order('created_at desc')
                        ->queryAll();
                } else {
                    $commissionRecords = [];
                }

                foreach ($commissionRecords as $record){
                    $temp = array();
                    $comment = explode('order_id',$record['transaction_comment']);
                    if($comment[0] != "Direct Sale Bonus due to " && $record['reference_id'] == $affiliate_reference->reference_id){
                        //For Affiliate Reference
                        $level = substr($record['transaction_comment'], 6, 1);
                        $temp['scheme'] = "Affiliate Earning";
                        $temp['date'] = date('d F, Y',strtotime($record['created_at']));
                        $dateArr = explode('order_id',$record['transaction_comment']);
                        $order = OrderInfo::model()->findByAttributes(['order_id'=>$record['reference_num']]);
                        $order_user = UserInfo::model()->findByPk($order->user_id);
                        if($level == 1){
                            $temp['description'] = 'Tier <i class="tier-circle tier1">'.$level.'</i> From '.
                                '<i class="fa fa-user tier1" data-toggle="kt-tooltip" data-placement="top" title="Customer - '.$order_user->full_name.'"></i>';
                        } else {
                            $parent = UserInfo::model()->findByPk($order_user->sponsor_id);
                            $temp['description'] = 'Tier <i class="tier-circle tier2">'.$level.'</i> From '.
                                '<i class="fa fa-user tier2" data-toggle="kt-tooltip" data-placement="top" title="Affiliate - '.$parent->full_name.'"></i>';
                        }
                        $transaction_type = $record['transaction_type'];
                        $reference_id = $affiliate_reference->reference_id;
                        $uniqueness_checker = "affiliate_level_".$level."_".trim($dateArr[1])."_with_transaction_type_".$transaction_type;
                    } elseif (isset($order_payment_reference->reference_id) && ($record['reference_id'] == $order_payment_reference->reference_id)){
                        //For Order Payment Reference
                        $temp['scheme'] = "Order Payment";
                        $temp['date'] = date('d F, Y',strtotime($record['created_at']));
                        $temp['description'] = "Order No. ".$record['reference_num'];
                        $transaction_type = Yii::app()->params['DebitTransactionType'];
                        $reference_id = $order_payment_reference->reference_id;
                        $uniqueness_checker = $record['transaction_comment']. " For order No. ".$record['reference_num'];
                    }  elseif ($record['reference_id'] == $payout_reference->reference_id){
                        //For Payout Reference
                        $temp['scheme'] = "Payout";
                        $temp['date'] = date('d F, Y',strtotime($record['created_at']));
                        $temp['description'] = $record['transaction_comment'];
                        $transaction_type = Yii::app()->params['DebitTransactionType'];
                        $reference_id = $payout_reference->reference_id;
                        $uniqueness_checker = "payout_with_comment_".str_replace(" ","_",$record['transaction_comment'])."_".$record['reference_num'];
                    } else {
                        $transaction_type = Yii::app()->params['CreditTransactionType'];
                        $reference_id = $record['reference_id'];
                        if($record['reference_num'] == $userId){
                            $from = "Self";
                        }else{
                            $user = UserInfo::model()->findByPk($record['reference_num']);
                            $from = $user->full_name;
                        }
                        $str = stristr($record['transaction_comment'], 'order');
                        $order_id = trim($str, 'order');

                        $temp['scheme'] = "Commission";
                        $temp['date'] = date('d F, Y',strtotime($record['created_at']));
                        $temp['description'] = $record['transaction_comment'];
                        $uniqueness_checker = "commission_from_".$order_id;
                    }
                    $temp['earnings'] = '€'.money_format('%(#1n',$record['amount']);
                    $temp['transaction_status'] = ServiceHelper::getTransactionStatusDetails($record['transaction_status'], $transaction_type, $reference_id);
                    $temp['sorting_date'] = $record['created_at'];
                    $allTransactionsData[$uniqueness_checker] = $temp;
                }
            }
            echo json_encode($allTransactionsData);
        }
    }

    public function actionGetPayoutData(){
        //For Payouts
        $payout_reference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Payout']);
        $userId = Yii::app()->user->getId();
        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
        $payoutData = [];

        $commissionRecords = Yii::app()->db->createCommand()
            ->select('sum(amount) as amount, transaction_comment, transaction_status, reference_id, reference_num, created_at')
            ->from('wallet')
            ->where('user_id=:uid',[':uid'=>$userId])
            ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
            ->andWhere('transaction_type=:type',[':type'=>Yii::app()->params['DebitTransactionType']])
            ->andWhere('reference_id=:rId',[':rId'=>$payout_reference->reference_id])
            ->group('reference_id, transaction_comment, transaction_status, reference_id, reference_num, created_at')
            ->order('created_at desc')
            ->queryAll();

        foreach ($commissionRecords as $record){
            $temp = array();

            $temp['date'] = date('d F, Y',strtotime($record['created_at']));
            $temp['description'] = $record['transaction_comment'];
            $temp['earnings'] = '€'.money_format('%(#1n',$record['amount']);
            $temp['transaction_status'] = ServiceHelper::getTransactionStatusDetails($record['transaction_status'], Yii::app()->params['DebitTransactionType'], $payout_reference->reference_id);
            $temp['earning_date'] = date('F, Y',strtotime($record['reference_num']));

            $uniqueness_checker = "payout_with_comment_".str_replace(" ","_",$record['transaction_comment'])."_".$record['reference_num'];
            $payoutData[$uniqueness_checker] = $temp;
        }
        echo json_encode($payoutData);
    }

    //Direct sales commissiom data
    public function actionGetCommissionData(){
        $userId = Yii::app()->user->getId();
        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
        $commissionData = [];

        $commissionRecords = Yii::app()->db->createCommand()
            ->select('sum(amount) as amount, transaction_comment, transaction_status, reference_num, created_at')
            ->from('wallet')
            ->where('user_id=:uid',[':uid'=>$userId])
            ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
            ->andWhere('transaction_type=:type',[':type'=>Yii::app()->params['CreditTransactionType']])
            ->andWhere(['like','transaction_comment','%Direct Sale Bonus due to order_id%'])
            ->group('transaction_comment, transaction_status, reference_num, created_at')
            ->order('created_at desc')
            ->queryAll();

        foreach ($commissionRecords as $record){
            if($record['reference_num'] == $userId){
                $from = "Self";
            }else{
                $user = UserInfo::model()->findByPk($record['reference_num']);
                $from = $user->full_name;
            }
            $str = stristr($record['transaction_comment'], 'order_id');
            $order_id = trim($str, 'order_id');
            $temp = array();

            $temp['date'] = $from;
            $temp['description'] = $record['transaction_comment'];
            $temp['earnings'] = '€'.money_format('%(#1n',$record['amount']);
            $temp['transaction_status'] = $order_id;
            $temp['earning_date'] = date('d F, Y',strtotime($record['created_at']));

            $uniqueness_checker = "commission_from_".$order_id;
            $commissionData[$uniqueness_checker] = $temp;
        }
        echo json_encode($commissionData);
    }

    public function actionGetOrderPaymentData(){
        //For Order Payment reference
        $order_payment_reference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>Yii::app()->params['WalletTransactions']]);
        //For Reserve Wallet
        $reserveWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>Yii::app()->params['ReserveWallet']]);
        $userId = Yii::app()->user->getId();
        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
        $orderPaymentData = [];

        $commissionRecords = Yii::app()->db->createCommand()
            ->select('amount, transaction_comment, transaction_status, reference_id, reference_num, created_at')
            ->from('wallet')
            ->where('user_id=:uid',[':uid'=>$userId])
            ->andWhere(['in','wallet_type_id',[$userWallet->wallet_type_id, $reserveWallet->wallet_type_id]])
            ->andWhere('transaction_type=:type',[':type'=>Yii::app()->params['DebitTransactionType']])
            ->andWhere('reference_id=:rId',[':rId'=>$order_payment_reference->reference_id])
            ->order('created_at desc')
            ->queryAll();

        foreach ($commissionRecords as $record){
            $temp['description'] = "Order No. ".$record['reference_num'];
            $temp['earning_date'] = date('d F, Y',strtotime($record['created_at']));
            $temp['date'] = date('d F, Y',strtotime($record['created_at']));
            $uniqueness_checker = $record['transaction_comment']. " For order No. ".$record['reference_num'];
            $temp['earnings'] = '€'.round($record['amount'],2);
            $temp['transaction_status'] = ServiceHelper::getTransactionStatusDetails($record['transaction_status'], Yii::app()->params['DebitTransactionType'], $order_payment_reference->reference_id);
            $orderPaymentData[$uniqueness_checker] = $temp;
        }
        echo json_encode($orderPaymentData);
    }

    public function actionGetAffiliateData(){
        if(isset($_POST['data'])){
            $requiredAttr = $_POST['data'];

            /*
             *  Static Affiliate Values
             *  0 -> All
             *  1 -> Level One Affiliate Data
             *  2 -> Level Two Affiliate Data
             * */

            //For Affiliate earnings commission scheme
            $affiliate_reference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Affiliate Commission']);
            $userId = Yii::app()->user->getId();
            $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
            $affiliateData = [];

            foreach ($requiredAttr as $item){
                if($item == 0){
                    $commissionRecords = Yii::app()->db->createCommand()
                        ->select('wallet_id, amount, reference_num, transaction_type, transaction_comment, transaction_status, created_at')
                        ->from('wallet')
                        ->where('user_id=:uid',[':uid'=>$userId])
                        ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
                        ->andWhere('reference_id=:rId',[':rId'=>$affiliate_reference->reference_id])
                        ->order('created_at desc')
                        ->queryAll();

                } elseif ($item == 1){
                    $commissionRecords = Yii::app()->db->createCommand()
                        ->select('wallet_id, amount, reference_num, transaction_type, transaction_comment, transaction_status, created_at')
                        ->from('wallet')
                        ->where('user_id=:uid',[':uid'=>$userId])
                        ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
                        ->andWhere('reference_id=:rId',[':rId'=>$affiliate_reference->reference_id])
                        ->andWhere(['like','transaction_comment','%Level 1%'])
                        ->order('created_at desc')
                        ->queryAll();
                } elseif ($item == 2){
                    $commissionRecords = Yii::app()->db->createCommand()
                        ->select('wallet_id, amount, reference_num, transaction_type, transaction_comment, transaction_status, created_at')
                        ->from('wallet')
                        ->where('user_id=:uid',[':uid'=>$userId])
                        ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
                        ->andWhere('reference_id=:rId',[':rId'=>$affiliate_reference->reference_id])
                        ->andWhere(['like','transaction_comment','%Level 2%'])
                        ->order('created_at desc')
                        ->queryAll();
                } else {
                    $commissionRecords = [];
                }

                foreach ($commissionRecords as $record){
                    $temp = array();
                    $tier = substr($record['transaction_comment'], 6, 1);
                    if($tier == 1){
                        $order = OrderInfo::model()->findByAttributes(['order_id'=>$record['reference_num']]);
                        $order_user = UserInfo::model()->findByPk($order->user_id);
                        $temp['tier'] = '<i class="tier-circle tier1">'.$tier.'</i>';
                        $temp['from'] = '<div class="custom-tier-1-tooltip custom-tooltip">
                                                <i class="fa fa-user-circle tier-1-color" style="font-size: x-large"></i>
                                                <i class="fa fa-user tier1" data-toggle="kt-tooltip" data-placement="top" title="Customer - '.$order_user->full_name.'"></i>
                                         </div>';
                    } else {
                        $order = OrderInfo::model()->findByAttributes(['order_id'=>$record['reference_num']]);
                        $order_user = UserInfo::model()->findByPk($order->user_id);
                        $parent = UserInfo::model()->findByPk($order_user->sponsor_id);
                        $temp['tier'] = '<i class="tier-circle tier2">'.$tier.'</i>';
                        $temp['from'] = '<div class="custom-tier-2-tooltip custom-tooltip">
                                                <i class="fa fa-user-circle tier-2-color" style="font-size: x-large"></i>
                                                <i class="fa fa-user tier2" data-toggle="kt-tooltip" data-placement="top" title="Affiliate - '.$parent->full_name.'"></i>
                                         </div>';
                    }
                    $temp['earnings'] = '€'.money_format('%(#1n',$record['amount']);
                    $temp['transaction_status'] = ServiceHelper::getTransactionStatusDetails($record['transaction_status'], $record['transaction_type'], $affiliate_reference->reference_id);
                    $temp['order_id'] = $record['reference_num'];
                    $temp['date'] = date('d F, Y',strtotime($record['created_at']));
                    $temp['transaction_type'] = $record['transaction_type'];
                    $affiliateData[$record['wallet_id']] = $temp;
                }
            }
            echo json_encode($affiliateData);
        }
    }

    /**
     * check withdraw amount available in account
     * @return bool
     */
    public function actionCheckWithdrawAmount(){

        $query = Yii::app()->db->createCommand()
            ->select('d.*,SUM(IF(w.transaction_type=0,w.amount,0)) as credit,SUM(IF(w.transaction_type=1,w.amount,0)) as debit')
            ->from('wallet w')
            ->join('denomination d','d.denomination_id = w.denomination_id')
            ->where('w.user_id = '. Yii::app()->user->getId().' group by w.denomination_id')
            ->queryAll();

        $availableAmount = $query[0]['credit'] - $query[0]['debit'];


        if($_POST['amount'] > $availableAmount){
            echo json_encode([
                'token' => 0,
            ]);
        }else{
            echo json_encode([
                'token' => 1,
            ]);
        }
    }

    /**
     * withdraw funds into wallet
     */
    public function actionWithdrawFunds(){
        $result = false;

        $query = Yii::app()->db->createCommand()
            ->select('d.*,SUM(IF(w.transaction_type=0,w.amount,0)) as credit,SUM(IF(w.transaction_type=1,w.amount,0)) as debit')
            ->from('wallet w')
            ->join('denomination d','d.denomination_id = w.denomination_id')
            ->where('w.user_id = '. Yii::app()->user->getId().' group by w.denomination_id')
            ->queryAll();

        $CashBalance = $query[0]['credit'] - $query[0]['debit'];

        $wallet = new Wallet();
        $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);

        $wallet->user_id = Yii::app()->user->getId();
        $wallet->wallet_type_id = 1;
        $wallet->transaction_type = 1;
        $wallet->reference_id = 3;
        $wallet->reference_num = $user->user_id;
        $wallet->transaction_comment = 'Withdraw by ' .$user->full_name. '('.$user->user_id.') to Netteler account';
        $wallet->denomination_id = 1;
        $wallet->transaction_status = 2;
        $wallet->portal_id = 1;
        $wallet->amount = $_POST['amount'];
        $wallet->created_at = date('Y-m-d H:i:s');
        $wallet->modified_at = date('Y-m-d H:i:s');

        if ($wallet->validate()) {
            if($wallet->save()){
                echo json_encode([
                    'token' => 1,
                    'cbalance' => $CashBalance - $_POST['amount']
                ]);
            }else{
                echo json_encode([
                    'token' => 0,
                ]);
            }
        }
    }
}
