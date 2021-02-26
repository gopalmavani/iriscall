<?php
class WalletHelper extends CApplicationComponent {

    public static function addToWallet($userId, $walletTypeId, $transactionType, $referenceId, $referenceNum,
                                       $transactionComment, $denominationID, $transactionStatus, $portalId,
                                       $creditAmount, $createdDate){
        $wallet = new Wallet();
        $wallet->user_id = $userId;
        $wallet->wallet_type_id = $walletTypeId;
        $wallet->transaction_type = $transactionType;
        $wallet->reference_id = $referenceId;
        $wallet->reference_num = $referenceNum;
        $wallet->transaction_comment = $transactionComment;
        $wallet->denomination_id = $denominationID;
        $wallet->transaction_status = $transactionStatus;
        $wallet->portal_id = $portalId;
        $wallet->amount = $creditAmount == '' ? 0 : $creditAmount;
        $wallet->created_at = $createdDate;
        $wallet->save(false);
    }

    public static function multipleDataInsert($table_name, $data){
        $connection = Yii::app()->db->getSchema()->getCommandBuilder();
        $chunked_array = array_chunk($data, 5000);
        foreach ($chunked_array as $chunk_array){
            $command = $connection->createMultipleInsertCommand($table_name, $chunk_array);
            $command->execute();
            $logMessage = count($chunk_array)." records were inserted in ".$table_name.PHP_EOL;
            file_put_contents('protected/runtime/insert.log', $logMessage, FILE_APPEND);
        }
    }

    public static function getReserveWalletBalance($user_id){
        $reserve_wallet_entity = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>Yii::app()->params['ReserveWallet']]);
        if(empty($reserve_wallet_entity)){
            $reserve_wallet = Yii::app()->db->createCommand()
                ->select('sum(case when transaction_type = 0 then amount else 0 end) as credit_amt, sum(case when transaction_type = 1 then amount else 0 end) as debit_amt')
                ->from('wallet')
                ->where('user_id=:uId',[':uId'=>$user_id])
                ->andWhere('transaction_status!=:tStatus',[':tStatus'=>Yii::app()->params['WalletRejectedTransactionStatus']])
                ->queryRow();
        }else{
            $reserve_wallet = Yii::app()->db->createCommand()
                ->select('sum(case when transaction_type = 0 then amount else 0 end) as credit_amt, sum(case when transaction_type = 1 then amount else 0 end) as debit_amt')
                ->from('wallet')
                ->where('user_id=:uId',[':uId'=>$user_id])
                ->andWhere('wallet_type_id=:wId',[':wId'=>$reserve_wallet_entity->wallet_type_id])
                ->andWhere('transaction_status!=:tStatus',[':tStatus'=>Yii::app()->params['WalletRejectedTransactionStatus']])
                ->queryRow();
        }
        $reserve_wallet_balance = $reserve_wallet['credit_amt'] - $reserve_wallet['debit_amt'];
        return $reserve_wallet_balance;
    }

    /*
     * Commission, Affiliate and Payout Earnings are considered in User Wallet Earnings
     * */
    public static function getUserWalletEarnings($user_id){
        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
        $walletData = Yii::app()->db->createCommand()
            ->select('sum(case when transaction_type = 0 then amount else 0 end) as credit_amt, sum(case when transaction_type = 1 then amount else 0 end) as debit_amt')
            ->from('wallet')
            ->where('user_id=:uid',[':uid'=>$user_id])
            //->andWhere(['in','reference_id',[$affiliate_reference->reference_id, $cashback_reference->reference_id, $payout_reference->reference_id]])
            ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
            ->andWhere('transaction_status!=:ts',[':ts'=>Yii::app()->params['WalletRejectedTransactionStatus']])
            ->queryRow();
        $balance = round($walletData['credit_amt'], 5) - round($walletData['debit_amt'], 5);
        return $balance;
    }

    /*
     * Get total affiliate commission
     * */
    public static function getAffiliateWalletEarnings($user_id){
        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
        $affiliate_reference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Affiliate Commission']);
        $walletData = Yii::app()->db->createCommand()
            ->select('sum(case when transaction_type = 0 then amount else 0 end) as credit_amt, sum(case when transaction_type = 1 then amount else 0 end) as debit_amt')
            ->from('wallet')
            ->where('user_id=:uid',[':uid'=>$user_id])
            ->andWhere(['in','reference_id',[$affiliate_reference->reference_id]])
            ->andWhere('wallet_type_id=:wId',[':wId'=>$userWallet->wallet_type_id])
            ->andWhere('transaction_status!=:ts',[':ts'=>Yii::app()->params['WalletRejectedTransactionStatus']])
            ->queryRow();
        $balance = round($walletData['credit_amt'], 5) - round($walletData['debit_amt'], 5);
        return $balance;
    }
}