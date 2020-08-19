<?php

class CBMAccountHelper extends CApplicationComponent {

    //Create CBM User Account
    public static function createCBMUserAccount($login, $balance, $equity, $type, $email, $beneficiary, $agentNum, $matrixId, $clusterId, $created_at)
    {
        $count = CbmUserAccounts::model()->findAllByAttributes(['login' => $login]);
        $accountNum = self::getCBMAccountNumber($login);
        $userAccount = new CbmUserAccounts();
        $userAccount->user_account_num = $accountNum;
        $userAccount->login = $login;
        $userAccount->balance = $balance;
        $userAccount->equity = $equity;
        $userAccount->max_balance = $balance;
        $userAccount->max_equity = $equity;
        $userAccount->type = $type;
        $userAccount->email_address = $email;
        $userAccount->beneficiary = $beneficiary;
        $userAccount->agent_num = $agentNum;
        $userAccount->matrix_id = $matrixId;
        $userAccount->cluster_id = $clusterId;
        $userAccount->created_at = $created_at;
        $userAccount->save(false);
        return $accountNum;
    }

    //Create New CBM Account Number
    public static function getCBMAccountNumber($login)
    {
        $cbmUserAccounts = CbmUserAccounts::model()->findAllByAttributes(['login' => $login]);
        $loginLength = strlen($login);
        $newNum = 1;
        if (count($cbmUserAccounts) > 0) {
            foreach ($cbmUserAccounts as $userAccount) {
                //+1 is to exclude prefix 'C'
                $accountNum = (int)substr($userAccount->user_account_num, $loginLength + 1);
                if ($accountNum > $newNum)
                    $newNum = $accountNum;
            }
            $final_account_num = 'C' . $login . ($newNum + 1);
        } else {
            $final_account_num = 'C' . $login . $newNum;
        }
        return $final_account_num;
    }

    //Create New Withdrawal CBM Account Number
    public static function getCBMWithdrawalAccountNumber($accountNum)
    {
        $systemUserAccounts = Yii::app()->db->createCommand()
            ->select('user_account_num')
            ->from('cbm_user_accounts')
            ->where('previous_login is not null')
            ->andWhere('email_address=:ea',[':ea'=>'system@system.com'])
            ->queryColumn();
        $largestNumber = 0;
        foreach ($systemUserAccounts as $systemUserAccount){
            $cPosition = strpos($systemUserAccount, 'C');
            $temp = substr($systemUserAccount, 1, $cPosition-1);
            if(is_numeric($temp)){
                $temp = (int)$temp;
                if($largestNumber < $temp)
                    $largestNumber = $temp;
            }
        }

        if (strpos($accountNum, 'W') !== false) {
            //echo 'true';
            $account_number = substr($accountNum, 1);
            $final_account_num = 'W'.($largestNumber+1).$account_number;
        } else {
            $final_account_num = 'W'.($largestNumber+1).$accountNum;
        }
        return $final_account_num;
    }

    //Check whether account is active or not depending upon group
    public static function getAccountStatus($group){
        /*
         * For 8780 - 'PHN_UK_TL3I_EUR', 'PHN_UK_TL_I_EUR'
         * For 8915 - 'PHN_UK_TUM_EUR'
         * */
        $requiredGroups = ['PHN_UK_TL3I_EUR', 'PHN_UK_TL_I_EUR', 'PHN_UK_TUM_EUR'];
        if(in_array($group, $requiredGroups)){
            return "Active";
        } else {
            return "Inactive";
        }
    }
}
