<?php

class WithdrawalController extends CController
{
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return UserIdentity::accessRules();
    }

    public function actionIndex(){

        $unprocessed_withdrawals_arr = Yii::app()->db->createCommand()
            ->select('login, email, close_time, sum(profit) as unprocessed_withdrawal')
            ->from('cbm_deposit_withdraw')
            ->where('type=:type',[':type'=>'Withdraw'])
            ->andWhere('is_accounted_for=:ia', [':ia'=>0])
            ->group('login, email')
            ->having('sum(profit) <= -50')
            ->queryAll();

        $unprocessed_deposits_arr = Yii::app()->db->createCommand()
            ->select('login, email, close_time, sum(profit) as unprocessed_deposit')
            ->from('cbm_deposit_withdraw')
            ->where('type=:type',[':type'=>'Deposit'])
            ->andWhere('is_accounted_for=:ia', [':ia'=>0])
            ->group('login, email')
            ->having('sum(profit) >= 50')
            ->queryAll();

        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
        $commissionReference = Yii::app()->db->createCommand()
            ->select('reference_id')
            ->from('wallet_meta_entity')
            ->where(['like', 'reference_key', '%Commission Transactions%'])
            ->queryColumn();
        $last_commission_execution_date = Yii::app()->db->createCommand()
            ->select('*')
            ->from('wallet')
            ->where('wallet_type_id=:wId', [':wId' => $userWallet->wallet_type_id])
            ->andWhere('transaction_type=:tt', [':tt' => Yii::app()->params['CreditTransactionType']])
            ->andWhere(['in', 'reference_id', $commissionReference])
            ->order('created_at desc')
            ->queryRow();
        $allowed_processing_date = date('Y-m-d H:i:s', strtotime($last_commission_execution_date['created_at'].'+15 days'));
        $unprocessed_data = [];
        foreach ($unprocessed_withdrawals_arr as $value){
            $temp = $value;
            $temp['unprocessed_deposit'] = 0;
            $temp['deposit_login'] = '';
            $temp['withdrawal_login'] = $value['login'];
            //$temp['received_at'] = date('j M,y', strtotime($value['close_time']));
            //$temp['due_date'] = date('j M,y', strtotime($value['close_time'].'+15 days'));
            $temp['received_at'] = date('Y-m-d', strtotime($value['close_time']));
            $temp['due_date'] = date('Y-m-d', strtotime($value['close_time'].'+15 days'));
            if($value['close_time'] < $allowed_processing_date){
                $temp['valid_for_process'] = 1;
            } else {
                $temp['valid_for_process'] = 0;
            }
            //$temp['valid_for_process'] = CommissionHelper::previousMonthCommissionCheck($value['close_time']);
            $unprocessed_data[$value['email']] = $temp;
        }

        foreach ($unprocessed_deposits_arr as $value){
            if(key_exists($value['email'], $unprocessed_data)){
                $unprocessed_data[$value['email']]['unprocessed_deposit'] = $value['unprocessed_deposit'];
                $unprocessed_data[$value['email']]['deposit_login'] = $value['login'];
                $withdrawalValue = abs($unprocessed_data[$value['email']]['unprocessed_withdrawal']);
                $depositValue = $value['unprocessed_deposit'];
                if(($withdrawalValue - $depositValue) <= 50){
                    $unprocessed_data[$value['email']]['valid_for_process'] = 1;
                }
            } else {
                $temp = $value;
                $temp['unprocessed_withdrawal'] = 0;
                $temp['withdrawal_login'] = '';
                $temp['deposit_login'] = $value['login'];
                $temp['received_at'] = date('Y-m-d', strtotime($value['close_time']));
                $temp['due_date'] = date('Y-m-d', strtotime($value['close_time'].'+15 days'));
                $temp['valid_for_process'] = '0';
                $unprocessed_data[$value['email']] = $temp;
            }
        }

        $this->render('index', [
            'unprocessed_data' => $unprocessed_data
        ]);
    }

    public function actionView(){
        if(isset($_GET['email'])){
            $email = $_GET['email'];
            $unprocessedWithdrawals = Yii::app()->db->createCommand()
                ->select('ticket, login, email, close_time, profit as unprocessed_withdrawal')
                ->from('cbm_deposit_withdraw')
                ->where('type=:type',[':type'=>'Withdraw'])
                ->andWhere('is_accounted_for=:ia', [':ia'=>0])
                ->andWhere('email=:email', [':email'=>$email])
                ->queryAll();

            $unprocessedDeposits = Yii::app()->db->createCommand()
                ->select('ticket, login, email, close_time, profit as unprocessed_withdrawal')
                ->from('cbm_deposit_withdraw')
                ->where('type=:type',[':type'=>'Deposit'])
                ->andWhere('is_accounted_for=:ia', [':ia'=>0])
                ->andWhere('email=:email', [':email'=>$email])
                ->queryAll();

            //$fakeDepositsEmail = CronHelper::fakeDepositArray();
            /*if(in_array($email, $fakeDepositsEmail)){
                $process_validity = false;
            } else {
                $process_validity = true;
            }*/

            $this->render('view',[
                'email' => $email,
                //'processValidity' => $process_validity,
                'unprocessedDeposit' => $unprocessedDeposits,
                'unprocessedWithdrawal' => $unprocessedWithdrawals
            ]);
        }
    }

    public function actionProcess(){
        $response = [];
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $withdrawals = [];
            $deposits = [];
            if(isset($_POST['withdrawals'])){
                $withdrawals = $_POST['withdrawals'];
            }
            if(isset($_POST['deposits'])){
                $deposits = $_POST['deposits'];
            }

            //$account = CbmAccounts::model()->findByAttributes(['login'=>$login]);
            $withdrawal_transaction = Yii::app()->db->createCommand()
                ->select('login, email, close_time, sum(profit) as unprocessed_withdrawal')
                ->from('cbm_deposit_withdraw')
                ->where('type=:type',[':type'=>'Withdraw'])
                ->andWhere('is_accounted_for=:ia', [':ia'=>0])
                ->andWhere('email=:lg', [':lg'=>$email])
                ->andWhere(['in', 'ticket', $withdrawals])
                ->queryRow();

            $deposit_transaction = Yii::app()->db->createCommand()
                ->select('login, email, close_time, sum(profit) as unprocessed_deposit')
                ->from('cbm_deposit_withdraw')
                ->where('type=:type',[':type'=>'Deposit'])
                ->andWhere('is_accounted_for=:ia', [':ia'=>0])
                ->andWhere('email=:lg', [':lg'=>$email])
                ->andWhere(['in', 'ticket', $deposits])
                ->queryRow();

            $accountedTickets = array_merge($withdrawals, $deposits);
            $difference = abs($withdrawal_transaction['unprocessed_withdrawal']) - abs($deposit_transaction['unprocessed_deposit']);
            $msg = '';

            //New Code
            if($difference >= 50){
                //Re-assign nodes
                $reassign_count = abs($deposit_transaction['unprocessed_deposit'])/50;
                if($reassign_count > 0){
                    $msg .= WithdrawalHelper::reassignNodes($withdrawal_transaction['login'], $deposit_transaction['login'], $reassign_count);
                }
                //Nodes needs to be revoked
                $msg .= "Nodes worth ".$difference." euro needs to be revoked <br>";
                $msg .= WithdrawalHelper::revokeAccounts($email, $withdrawal_transaction['login'], $difference);
            } elseif($difference <= -50){
                //Re-assign nodes
                $reassign_count = abs($withdrawal_transaction['unprocessed_withdrawal'])/50;
                $msg .= WithdrawalHelper::reassignNodes($withdrawal_transaction['login'], $deposit_transaction['login'], $reassign_count);
                $amt = abs($difference);
                //New Nodes to be created
                $msg .= "Nodes worth ".$amt." euro needs to be created <br>";
                $msg .= WithdrawalHelper::createAccounts($email, $deposit_transaction['login'], $amt);
            } else {
                //Re-assign nodes
                $reassign_count = abs($withdrawal_transaction['unprocessed_withdrawal'])/50;
                $reassign_count = ceil($reassign_count);
                $msg .= WithdrawalHelper::reassignNodes($withdrawal_transaction['login'], $deposit_transaction['login'], $reassign_count);
            }

            //Update all CBM user accounts balance and equity
            $cbmAccounts = CbmAccounts::model()->findAllByAttributes(['email_address' => $email]);
            $msg .= "<h5>Account Summary</h5>";
            foreach ($cbmAccounts as $account){
                $cbmUserAccounts = CbmUserAccounts::model()->findAllByAttributes(['login'=>$account->login]);
                $usedAccounts = count($cbmUserAccounts);
                if ($usedAccounts > 0) {
                    $newBalance = $account->balance / $usedAccounts;
                    $newEquity = $account->equity / $usedAccounts;
                } else {
                    $newBalance = 0;
                    $newEquity = 0;
                }
                //Update details in the user_account table
                $res = Yii::app()->db->createCommand()
                    ->update('cbm_user_accounts', array(
                        'balance' => $newBalance,
                        'equity' => $newEquity,
                        'modified_at' => date('Y-m-d H:i:s')
                    ), 'login=:lg', array(':lg' => $account->login));
                $msg .= "Balance and Equity were updated for <span class='strong'>".$account->login."</span> <br>";
            }

            //Update deposit-withdraw transaction w.r.t email
            $updateQuery = 'update cbm_deposit_withdraw set is_accounted_for=1, modified_at="'.date('Y-m-d H:i:s').'" where email="'.$email.
                '" and ticket in ('.implode(',', $accountedTickets).') and is_accounted_for=0';
            Yii::app()->db->createCommand($updateQuery)->execute();
            $msg .= "Deposits and Withdrawals with tickets ".implode(',', $accountedTickets)." were updated for <span class='strong'>".$email."</span> <br>";

            $response['status'] = 'Success';
            $response['msg'] = $msg;
        } else {
            $response['status'] = 'Failure';
        }
        echo json_encode($response);
    }
}