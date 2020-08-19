<?php

class WithdrawalHelper extends CApplicationComponent {

    public static function revokeAccounts($email, $login, $amt){

        $response = '';
        $response .= '<h5>Withdrawal Summary</h5>';
        $response .= "A total withdrawal-difference of <span class='strong'>" . $amt . "</span> is eligible for revoking of nodes. <br>";
        $systemId = Yii::app()->params['SystemUserId'];
        $system = UserInfo::model()->findByPk($systemId);

        //Convert amount to positive, else ceil function will result in a lesser integer
        $accounts = ceil(abs($amt) / 50);
        $availableAccountsQuery = Yii::app()->db->createCommand()
            ->select('count(*) as cnt')
            ->from('cbm_user_accounts')
            ->where('email_address=:ea', [':ea' => $email])
            ->andWhere('login=:lg', [':lg'=>$login])
            ->queryRow();
        $availableAccounts = $availableAccountsQuery['cnt'];

        //Maximum accounts to be revoked cannot be greater than available account
        //This arise because accounts are created based upon equity while withdrawal is
        //based upon balance.
        if($accounts > $availableAccounts){
            $accounts = $availableAccounts;
        }
        $accountsRevoked = 0;
        $accountsToBeRevoked = 0;
        
        while($accountsRevoked < $accounts){
            //Delete accounts that are not placed at all
            $unPlacedAccounts = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cbm_user_accounts')
                ->where('email_address=:ea', [':ea' => $email])
                ->andWhere('login=:lg', [':lg'=>$login])
                ->andWhere('matrix_node_num is null')
                ->queryAll();
            $unplaced_count = count($unPlacedAccounts);
            if ($unplaced_count > 0) {
                if ($accounts >= $unplaced_count) {
                    //Delete all unplaced accounts
                    $delete_res = Yii::app()->db->createCommand()
                        ->delete('cbm_user_accounts', 'email_address=:ea and login=:lg and isnull(matrix_node_num)', [':ea' => $email, ':lg'=>$login]);
                    $accountsRevoked += $unplaced_count;
                    $response .= "<span class='strong'>".$unplaced_count."</span> unplaced accounts were <span class='strong'>Deleted</span> <br>";
                } else {
                    $accountsNum = $accounts;
                    //for the array index
                    $delete_id = $unplaced_count - 1;
                    while ($accountsNum > 0) {
                        //Delete single unplaced account
                        $delete_res = Yii::app()->db->createCommand()
                            ->delete('cbm_user_accounts', 'email_address=:ea and user_account_id=:uaId and isnull(matrix_node_num)',
                                [':ea' => $email, ':uaId' => $unPlacedAccounts[$delete_id]['user_account_id']]);
                        $accountsNum--;
                        $delete_id--;
                        $accountsRevoked++;
                    }
                    $response .= "A total of <span class='strong'>".$accountsRevoked."</span>accounts were assigned to the system.<br>";
                }
            } else {
                $accountsToBeRevoked = $accounts - $accountsRevoked;
                //Accounts that needs to be revoked
                $cbmUserAccounts = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('cbm_user_accounts')
                    ->where('email_address=:ea', [':ea' => $email])
                    ->andWhere('login=:lg', [':lg'=>$login])
                    ->andWhere('matrix_node_num is not null')
                    ->order('user_account_id desc')
                    ->limit($accountsToBeRevoked)
                    ->queryAll();

                //Update all accounts and move their ownership to system
                foreach ($cbmUserAccounts as $userAccount) {
                    $matrix = MatrixMetaTable::model()->findByPk($userAccount['matrix_id']);
                    $withdrawalAccountNumber = CBMAccountHelper::getCBMWithdrawalAccountNumber($userAccount['user_account_num']);

                    //Update details in the matrix table
                    $res = Yii::app()->db->createCommand()
                        ->update($matrix->table_name, array(
                            'user_id' => $systemId,
                            'email' => $system->email,
                            'cbm_account_num' => $withdrawalAccountNumber
                        ), 'cbm_account_num=:cNum', array(':cNum' => $userAccount['user_account_num']));

                    //Update the CBM Account Itself
                    $account = CbmUserAccounts::model()->findByPk($userAccount['user_account_id']);
                    $account->previous_login = $account->login;
                    $account->user_account_num = $withdrawalAccountNumber;
                    $account->login = null;
                    $account->type = "System Funded";
                    $account->email_address = $system->email;
                    $account->beneficiary = $system->email;
                    $account->modified_at = date('Y-m-d H:i:s');
                    $account->save(false);
                    $accountsRevoked++;

                    //Update license in CBM User Licenses
                    ServiceHelper::modifyCBMUserLicenses('', $email, 0, 1);
                }
                $response .= "A total of <span class='strong'>".$accountsRevoked."</span> accounts were assigned to the system. <br>";
            }
        }

        return $response;
    }
    
    public static function createAccounts($email, $login, $amt){
        $response = '';
        $response .= '<h5>Deposit Summary</h5>';
        $response .= "A total deposit-difference of <span class='strong'>" . $amt . "</span> is eligible for account creation.<br>";
        $requiredLicenses = floor($amt / 50);
        $cbm_user_licenses = CbmUserLicenses::model()->findByAttributes(['email'=>$email]);
        $account = CbmAccounts::model()->findByAttributes(['login'=>$login]);

        if (($cbm_user_licenses->available_licenses <= 0) || ($requiredLicenses > $cbm_user_licenses->available_licenses)) {
            echo "<p style='color: red; margin-bottom: 0'>User do not have enough license for placing nodes to FIBO. User had only " . $cbm_user_licenses->available_licenses . ', while ' . $requiredLicenses . ' were required. </p><br>';
            $cluster_count = $cbm_user_licenses->available_licenses;
        } else {
            $cluster_count = $requiredLicenses;
        }

        /*
         * get new cluster Id
         * */
        $clusterId = MatrixHelper::getNewClusterId($account->login);

        /*
         * Create CBM accounts without checking for licenses.
         * Licenses will be checked at the time of FIBO placements.
         * */
        $equalAmount = $amt / $requiredLicenses;
        $created_at = date('Y-m-d H:i:s');
        $nodePlaced = 0;
        $selfFundedCount = 0;

        //For remaining deposits
        $available_licenses = $cbm_user_licenses->available_licenses;
        for ($i = 0; $i < $requiredLicenses; $i++) {
            //Create Account
            $new_account_num = CBMAccountHelper::createCBMUserAccount($account->login, 50, 50, 'Self Funded', $email, $email, $account->agent, 1, $clusterId, $created_at);
            $selfFundedCount++;
            $account->prev_balance += $equalAmount;
            $account->prev_equity += $equalAmount;
            $account->save(false);

            if($available_licenses > 0){
                $parentAccountNum = MatrixHelper::getMatrixSponsor($new_account_num, 1);
                $resp = MatrixHelper::addToMatrix($new_account_num, $parentAccountNum);
                if ($resp != false) {
                    //updated code for licenses in CbmUserLicenses table
                    ServiceHelper::modifyCBMUserLicenses('', $email, 0, -1);
                    $nodePlaced++;
                    $available_licenses--;
                }
            }
        }


        $response .= "For email: <span class='strong'>".$email.", ".$selfFundedCount."</span> new Self funded accounts were created and <span class='strong'> ".$nodePlaced."</span> were placed from login: <span class='strong'>" .$account->login. "</span>.<br>";
        $user = UserInfo::model()->findByAttributes(['email' => $email]);
        if (isset($user->user_id)) {
            //for the notification add the database.
            $body = $requiredLicenses . ' New CBM Self Funded User accounts were created for ' . $email . ' from login '.$account->login;
            $url = Yii::app()->createUrl('admin/cbmuseraccount/index');
            $nid = NotificationHelper::AddNotitication('Add CBM Self funded user accounts', $body, 'Self-funded user accounts', $user->user_id, 0, $url);

            //for the notification add to the admin side using pusher.
            $message = $requiredLicenses . ' New CBM Self Funded User accounts from login ' . $account->login .  'were created with balance ';
            $date = date('Y-m-d H:i:s');
            //$url is the define for redirect order details link page.
            NotificationHelper::pusherNotificationVpamm($message, $date, $url, $account->login, $email, $equalAmount, $nid);
        }

        return $response;
    }

    //Reassign Nodes
    public static function reassignNodes($from_login, $to_login, $reassign_count){
        $response = '';
        $response .= '<h5>Reassign Summary</h5>';

        $cbmUserAccounts = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cbm_user_accounts')
            ->where('login=:lg',[':lg'=>$from_login])
            ->order('user_account_id desc')
            ->limit($reassign_count)
            ->queryAll();

        $to_login_account = CbmAccounts::model()->findByAttributes(['login'=>$to_login]);

        $count = 0;
        foreach ($cbmUserAccounts as $userAccount){
            $matrix = MatrixMetaTable::model()->findByPk($userAccount['matrix_id']);
            $newAccountNumber = CBMAccountHelper::getCBMAccountNumber($to_login);

            //Update details in the matrix table
            $res = Yii::app()->db->createCommand()
                ->update($matrix->table_name, array(
                    'cbm_account_num' => $newAccountNumber
                ), 'cbm_account_num=:cNum', array(':cNum' => $userAccount['user_account_num']));

            //Update the CBM Account Itself
            $account = CbmUserAccounts::model()->findByPk($userAccount['user_account_id']);
            $account->login = $to_login;
            $account->agent_num = $to_login_account->agent;
            $account->user_account_num = $newAccountNumber;
            $account->modified_at = date('Y-m-d H:i:s');
            $account->save(false);
            $count++;

            $user = UserInfo::model()->findByAttributes(['email'=>$userAccount['email_address']]);
            $activityRef = CbmActivityReference::model()->findByAttributes(['reference'=>'Reassign Nodes']);
            $comment = "Node reassigned from ".$userAccount['user_account_num']." to ".$newAccountNumber;
            $created_at = date('Y-m-d H:i:s');
            CBMActivityHelper::createCBMActivity($user->user_id, $activityRef->id, $userAccount['user_account_id'],
                " ", " ", $comment, $created_at);
        }
        $response .= "<span class='strong'> ".$count."</span> nodes were reassigned from MAM <span class='strong'>".$from_login."</span> to MAM <span class='strong'>".$to_login."</span> <br>";
        return $response;
    }
}
?>