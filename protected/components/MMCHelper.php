<?php

class MMCHelper extends CApplicationComponent
{
    /*
     * Create New MMC Account Number
     * type = US -> user self funded node
     *        UP -> user profit funded node
     *        SS -> system node
     * */
    public static function getMMCAccountNumberSequence($login)
    {
        $cbmAccount = CbmAccounts::model()->findByAttributes(['login'=>$login]);
        $cbmUserAccounts = CbmUserAccounts::model()->findAllByAttributes(['login' => $login]);
        $loginLength = strlen($login);
        $newNum = 0;
        if (count($cbmUserAccounts) > 0) {
            foreach ($cbmUserAccounts as $userAccount) {
                //+7 is to exclude prefix
                $accountNum = (int)substr($userAccount->user_account_num, $loginLength + 7);
                if ($accountNum > $newNum)
                    $newNum = $accountNum;
            }
            //$final_account_num = 'C' . $login . ($newNum + 1);
        } else {
            //$final_account_num = 'M'.$cbmAccount->agent.$type.$login.$newNum;
        }
        return $newNum;
    }

    public static function createMMCUserAccount($accountNum, $login, $balance, $equity, $maxBalance, $maxEquity, $type, $email, $beneficiary, $agentNum, $matrixId, $clusterId, $created_at)
    {
        $userAccount = new CbmUserAccounts();
        $userAccount->user_account_num = $accountNum;
        $userAccount->login = $login;
        $userAccount->balance = $balance;
        $userAccount->equity = $equity;
        $userAccount->max_balance = $maxBalance;
        $userAccount->max_equity = $maxEquity;
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
}
?>