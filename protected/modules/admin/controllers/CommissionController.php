<?php

class CommissionController extends CController {

    public $final_comm_array = [];
    public function accessRules()
    {
        return [
            [
                'allow',
                'actions' => ['updatemt4'],
                'users' => ['*'],
            ],
            ['deny', // deny all users
                'users' => ['*'],
            ],
        ];
    }

    public function actionIndex(){
        $this->render('index');
    }

    /*
     * Following action takes place during commission distribution of Fifty euro matrix
     * Perform commission's month withdrawals
     * Distribute CashBack earnings
     * Distribute Backup
     * Distribute Floating corporate
     * Distribute UpCycling
     * Distribute FAN/GPA
     * Distribute Company Matrix
     * Add to Company excess
     * */
    public function actionDistributeCommission(){

        ini_set('memory_limit', '-1');
        set_time_limit(0);

        if(isset($_POST['start_date'])){
            $myDateTime = DateTime::createFromFormat('F, Y', $_POST['start_date']);
            $start_month = $myDateTime->format('m');
            $start_year = $myDateTime->format('Y');
        } else {
            $start_month = date('m');
            $start_year = date('Y');
        }
        $start_month = 6;
        $start_year = 2020;
        $summaryMessage = CommissionHelper::distributeCommission($start_month, $start_year);
        echo $summaryMessage;
    }

    /*
     * Update Fibo Parent Trace
     * */
    public function actionUpdateFiboParentTrace(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        MatrixHelper::updateParentTrace();
    }

    /*
     * Commission distribution for ten euro matrix
     * */
    public function actionCommissionDistributionForTenEuro(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        //Empty the global array in case it is filled
        $GLOBALS['final_comm_array'] = [];

        if(isset($_POST['start_date'])){
            $start_month = date('m',strtotime($_POST['start_date']));
            $start_year = date('Y',strtotime($_POST['start_date']));
        } else {
            $start_month = date('m');
            $start_year = date('Y');
        }
        $multipleLogin = Yii::app()->db->createCommand()
            ->select('login')
            ->from('cbm_accounts')
            ->queryColumn();
        //To take only CBM login
        $commissions = Yii::app()->db->createCommand()
            ->select('sum(commission) as commission, login')
            ->from('cbm_commission')
            ->where('month=:mt',[':mt'=>$start_month])
            ->andWhere('year=:yr',[':yr'=>$start_year])
            ->andWhere(['in','login',$multipleLogin])
            ->group('login')
            ->queryAll();
        foreach ($commissions as $record){
            $cbmAccount = CbmAccounts::model()->findByAttributes(['login'=>$record['login']]);
            $user = UserInfo::model()->findByAttributes(['email'=>$cbmAccount->email_address]);
            $accounts = CbmUserAccounts::model()->findAllByAttributes(['login'=>$record['login'], 'matrix_id'=>2]);
            $totalAccounts = count($accounts);
            if($totalAccounts > 0){
                echo "<p style='color: green; margin-bottom: 0'>Distributing a total of " .$record['commission']. " euro commission for ".$cbmAccount->email_address." ". $totalAccounts ." accounts.</p>";
                $commPerNode = $record['commission']/$totalAccounts;
                $commissionSchemes = CbmCommissionScheme::model()->findAllByAttributes(['matrix_id'=>2]);
                foreach ($accounts as $account){
                    //echo "<br> For account num ".$account->user_account_num." and node Id ".$account->matrix_node_num."<br>";
                    $remainingCommission = $commPerNode;
                    $schemeNumber = 0;
                    while ($remainingCommission > 0){
                        if($account->user_ownership == 'HALF'){
                            $maxAmount = $commissionSchemes[$schemeNumber]->max_amount/2;
                            if(!is_null($commissionSchemes[$schemeNumber]->max_earnings))
                                $maxEarnings = $commissionSchemes[$schemeNumber]->max_earnings/2;
                            else
                                $maxEarnings = null;
                        } else {
                            $maxAmount = $commissionSchemes[$schemeNumber]->max_amount;
                            $maxEarnings = $commissionSchemes[$schemeNumber]->max_earnings;
                        }
                        if(($remainingCommission >= $maxAmount) && (!is_null($maxEarnings))){
                            $distributionAmount = $maxAmount;
                            $remainingCommission -= $distributionAmount;
                        } else {
                            //Check in Backup wallet only for SwimLane earnings
                            $backupScheme = CbmCommissionScheme::model()->findByAttributes(['scheme'=>'Backup Cycle', 'matrix_id'=>2]);
                            if($commissionSchemes[$schemeNumber]->scheme == 'Swimlane'){
                                $backupWalletCredit =  Yii::app()->db->createCommand()
                                    ->select('sum(amount) as amount')
                                    ->from('wallet_commission')
                                    ->where('wallet_type_id=:id',[':id'=>$backupScheme->wallet_type_id])
                                    ->andWhere('transaction_type=:typ',[':typ'=>Yii::app()->params['CreditTransactionType']])
                                    ->andWhere('to_node_id=:tNId',[':tNId'=>$account->matrix_node_num])
                                    ->queryRow();
                                $backupWalletDebit =  Yii::app()->db->createCommand()
                                    ->select('sum(amount) as amount')
                                    ->from('wallet_commission')
                                    ->where('wallet_type_id=:id',[':id'=>$backupScheme->wallet_type_id])
                                    ->andWhere('transaction_type=:typ',[':typ'=>Yii::app()->params['DebitTransactionType']])
                                    ->andWhere('from_node_id=:fNId',[':fNId'=>$account->matrix_node_num])
                                    ->queryRow();
                                $debitTransactionType = Yii::app()->params['DebitTransactionType'];
                                if(isset($backupWalletCredit['amount'])){
                                    if(isset($backupWalletDebit['amount'])){
                                        $backupWalletAmount = round($backupWalletCredit['amount'],5) - round($backupWalletDebit['amount'],5);
                                    } else {
                                        $backupWalletAmount = $backupWalletCredit['amount'];
                                    }
                                    //echo "Backup Wallet Amount: ".$backupWalletAmount."<br>";
                                    if($backupWalletAmount > 0){
                                        $requiredAmount = $maxAmount - $remainingCommission;
                                        if($requiredAmount >= $backupWalletAmount){
                                            $withdrawAmount = $backupWalletAmount;
                                        } else {
                                            $withdrawAmount = $requiredAmount;
                                        }
                                        $distributionAmount = $remainingCommission + $withdrawAmount;
                                        $withdrawAmount = round($withdrawAmount, 5);

                                        echo "<br><p style='color: green; margin-bottom: 0'> Node Id ".$account->matrix_node_num." received ".$withdrawAmount." from backup wallet.Hooray!!</p><br> ";
                                        //Withdrawal entry in Wallet
                                        $deduction_comment = "Deduction for userId ".$user->user_id." and nodeId ".$account->matrix_node_num;
                                        //addToWallet($userId, $walletTypeId, $transactionType, $referenceId, $referenceNum, $transactionComment, $denominationID, $transactionStatus, $portalId, $creditAmount, $CreatedDate)
                                        //WalletHelper::addToWallet($user->user_id, $backupScheme->wallet_type_id, 1, 4, $account->matrix_id, $deduction_comment, 1, 2, 1, $withdrawAmount, date('Y-m-d H:i:s'));
                                        WalletHelper::addToWalletCommission($user->user_id, $backupScheme->wallet_type_id, $withdrawAmount, null, $user->user_id, $account->matrix_node_num, null, date('m'), date('Y'), $debitTransactionType, $deduction_comment, 2);
                                    } else {
                                        $distributionAmount = $remainingCommission;
                                    }
                                } else {
                                    $distributionAmount = $remainingCommission;
                                }
                            } else {
                                $distributionAmount = $remainingCommission;
                            }
                            $remainingCommission = 0;
                        }
                        CommissionHelper::nodeWiseDistribution($account, $commissionSchemes[$schemeNumber], $distributionAmount, $start_month, $start_year);
                        $schemeNumber++;
                    }
                }
            }
        }
    }

    /*
     * UpCycling and Corporate account wallet check
     * */
    public function actionProfitCheckForCorporateAndUpCycling(){

        $cbmUserAccounts = CbmUserAccounts::model()->findAllByAttributes(['matrix_id'=>1]);
        $debitTransactionType = Yii::app()->params['DebitTransactionType'];
        foreach ($cbmUserAccounts as $userAccount){
            $user = UserInfo::model()->findByAttributes(['email'=>$userAccount->email_address]);
            echo "Profit check for ".$userAccount->email_address." and node num: ".$userAccount->matrix_node_num."<br>";
            $upCycleScheme = CbmCommissionScheme::model()->findByAttributes(['scheme'=>'Upcycling','matrix_id'=>1]);
            $upCyclingCreditCommission = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount')
                ->from('wallet')
                ->where('wallet_type_id=:tId',[':tId'=>$upCycleScheme->wallet_type_id])
                ->andWhere('user_id=:uId',[':uId'=>$user->user_id])
                ->andWhere('transaction_type=:typ',[':typ'=>Yii::app()->params['CreditTransactionType']])
                ->andWhere('reference_id=:rId',[':rId'=>4])
                ->andWhere('reference_num=:nodeId',[':nodeId'=>$userAccount->matrix_node_num])
                ->queryRow();
            $upCyclingDebitCommission = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount')
                ->from('wallet')
                ->where('wallet_type_id=:tId',[':tId'=>$upCycleScheme->wallet_type_id])
                ->andWhere('user_id=:uId',[':uId'=>$user->user_id])
                ->andWhere('transaction_type=:typ',[':typ'=>$debitTransactionType])
                ->andWhere('reference_id=:rId',[':rId'=>4])
                ->andWhere('reference_num=:nodeId',[':nodeId'=>$userAccount->matrix_node_num])
                ->queryRow();
            $effectiveUpCyclingCommission = $upCyclingCreditCommission['amount'] - $upCyclingDebitCommission['amount'];
            echo "Effective UpCycling Commission: ".$effectiveUpCyclingCommission."<br>";
            $requiredUpCyclingCommission = 5;
            if($effectiveUpCyclingCommission >= $requiredUpCyclingCommission){

                //Withdrawal tuple in wallet
                $deduction_comment = "Upcycling deduction from userId ".$user->user_id." and nodeId ".$userAccount->matrix_node_num;
                //WalletHelper::addToWallet($user->user_id, 5, 1, 4, 1, $deduction_comment, 1, 2, 1, $requiredUpCyclingCommission, date('Y-m-d H:i:s'));
                WalletHelper::addToWalletCommission($user->user_id, $upCycleScheme->wallet_type_id, $requiredUpCyclingCommission, null, $user->user_id, $userAccount->matrix_node_num, null, date('m'), date('Y'), $debitTransactionType, $deduction_comment, 2);
                //Add to profit Withdrawals for generating transfer request
                $this->addToProfitWithdrawals($userAccount->login, 'toLogin', $requiredUpCyclingCommission, $userAccount->email_address, '');
            }

            $floatingCorporateScehme = CbmCommissionScheme::model()->findByAttributes(['scheme'=>'Floating corporate','matrix_id'=>1]);
            $corporateCreditCommission = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount')
                ->from('wallet')
                ->where('wallet_type_id=:tId',[':tId'=>$floatingCorporateScehme->wallet_type_id])
                ->andWhere('user_id=:uId',[':uId'=>$user->user_id])
                ->andWhere('transaction_type=:typ',[':typ'=>Yii::app()->params['CreditTransactionType']])
                ->andWhere('reference_id=:rId',[':rId'=>4])
                ->andWhere('reference_num=:nodeId',[':nodeId'=>$userAccount->matrix_node_num])
                ->queryRow();
            $corporateDebitCommission = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount')
                ->from('wallet')
                ->where('wallet_type_id=:tId',[':tId'=>$floatingCorporateScehme->wallet_type_id])
                ->andWhere('user_id=:uId',[':uId'=>$user->user_id])
                ->andWhere('transaction_type=:typ',[':typ'=>$debitTransactionType])
                ->andWhere('reference_id=:rId',[':rId'=>4])
                ->andWhere('reference_num=:nodeId',[':nodeId'=>$userAccount->matrix_node_num])
                ->queryRow();
            $effectiveCorporateCommission = $corporateCreditCommission['amount'] - $corporateDebitCommission['amount'];
            echo "Effective Corporate Commission: ".$effectiveCorporateCommission."<br><br>";
            $requiredCorporateCommission = 5;
            if($effectiveCorporateCommission >= $requiredCorporateCommission){

                //Withdrawal tuple in wallet
                $deduction_comment = "Floating corporate deduction from userId ".$user->user_id." and nodeId ".$userAccount->matrix_node_num;
                //WalletHelper::addToWallet($user->user_id, 4, 1, 4, 1, $deduction_comment, 1, 2, 1, $requiredCorporateCommission, date('Y-m-d H:i:s'));
                WalletHelper::addToWalletCommission($user->user_id, $floatingCorporateScehme->wallet_type_id, $requiredCorporateCommission, null, $user->user_id, $userAccount->matrix_node_num, null, date('m'), date('Y'), $debitTransactionType, $deduction_comment, 2);
                //Add to profit Withdrawals for generating transfer request
                $this->addToProfitWithdrawals($userAccount->login, 'toLogin', $requiredCorporateCommission, $userAccount->email_address, '');
            }
        }
    }

    /*
     * Add normalized data from wallet_commission to
     * wallet table
     * */
    public function actionNormalizeCommission(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        if(isset($_POST['start_date'])){
            $myDateTime = DateTime::createFromFormat('F, Y', $_POST['start_date']);
            $start_month = $myDateTime->format('m');
            $start_year = $myDateTime->format('Y');
        } else {
            $start_month = date('m');
            $start_year = date('Y');
        }
        $start_month = 6;
        $start_year = 2020;
        $summaryMessage = CommissionHelper::normalizeCommission($start_month, $start_year);
        echo $summaryMessage;
    }

    //Add to profit Withdrawals table
    public function addToProfitWithdrawals($fromLogin, $toLogin, $amount, $email, $comment = ''){
        $profitWithdrawal = new ProfitWithdrawals();
        $profitWithdrawal->from_account = $fromLogin;
        $profitWithdrawal->to_account = $toLogin;
        $profitWithdrawal->amount = $amount;
        $profitWithdrawal->email = $email;
        $profitWithdrawal->comment = $comment;
        $profitWithdrawal->save(false);
    }

    //Check for pending orders
    public static function actionCheckPendingOrders(){
        CommissionHelper::checkPendingOrders();
    }

    /*
     * Commission Comparison
     * */
    public function actionComparison(){
        $agents = AgentInfo::model()->findAll();
        $cashBackReferences = [];
        foreach ($agents as $agent) {
            array_push($cashBackReferences, $agent->wallet_reference_id);
        }

        $user_wallet = WalletTypeEntity::model()->findByAttributes(['wallet_type' => 'User']);
        $creditTransactionType = Yii::app()->params['CreditTransactionType'];

        $last_commission_computation_date = Yii::app()->db->createCommand()
            ->select('max(created_at) as created_at')
            ->from('wallet')
            ->where('wallet_type_id=:typ', [':typ' => $user_wallet->wallet_type_id])
            ->andwhere(['in', 'reference_id', $cashBackReferences])
            ->andWhere('transaction_type=:tt', [':tt' => $creditTransactionType])
            ->order('created_at desc')
            ->queryRow();

        $temporary_date = strtotime(date("Y-m-20 00:00:00", strtotime($last_commission_computation_date['created_at'])));
        $minus_one_month = date("n", strtotime("-1 month", $temporary_date));
        $minus_one_month_text = date("F", strtotime("-1 month", $temporary_date));
        $minus_one_month_text_table = date("F_Y", strtotime("-1 month", $temporary_date));
        $minus_two_month = date("n", strtotime("-2 month", $temporary_date));
        $minus_two_month_text = date("F", strtotime("-2 month", $temporary_date));
        $minus_two_month_text_table = date("F_Y", strtotime("-2 month", $temporary_date));
        $last_commission_month = date('n', $temporary_date);
        $last_commission_month_text = date('F', $temporary_date);
        $year = date('Y');
        $minus_one_year = date('Y', strtotime("-1 month", $temporary_date));
        $minus_two_year = date('Y', strtotime("-2 month", $temporary_date));
        $minus_two_month_date = date('Y-m-d 00:00:00', strtotime("-2 month", $temporary_date));

        $wallet_data = Yii::app()->db->createCommand()
            ->select('user_id, sum(amount) as amount, Month(created_at) as mnt,  Year(created_at)')
            ->from('wallet')
            ->where('wallet_type_id=:typ', [':typ' => $user_wallet->wallet_type_id])
            ->andwhere(['in', 'reference_id', $cashBackReferences])
            ->andWhere('transaction_type=:tt', [':tt' => $creditTransactionType])
            //->andWhere('Year(created_at)=:yc', [':yc' => $year])
            ->andWhere('created_at>=:ct', [':ct' => $minus_two_month_date])
            ->andWhere(['in', 'Year(created_at)', [$year, $minus_one_year, $minus_two_year]])
            ->andWhere(['in', 'Month(created_at)', [$last_commission_month, $minus_two_month, $minus_one_month]])
            ->group('user_id, Month(created_at), Year(created_at)')
            ->order('Year(created_at), Month(created_at) asc')
            ->queryAll();

        $comparison_array = array();
        foreach ($wallet_data as $datum){
            if(!isset($comparison_array[$datum['user_id']]))
                $comparison_array[$datum['user_id']] = array();
            $comparison_array[$datum['user_id']][$datum['mnt']] = $datum['amount'];
        }

        //Get Earning nodes for past three months
        $earningNodesArray = array();
        $currentEarningNodes = Yii::app()->db->createCommand()
            ->select('user_id, count(DISTINCT from_node_id) as cnt')
            ->from('wallet_commission')
            ->andWhere('wallet_type_id=:wId',[':wId'=>$user_wallet->wallet_type_id])
            ->andWhere('transaction_type=:tt', [':tt' => $creditTransactionType])
            ->group('user_id')
            ->queryAll();
        $currentEarningNodesArray = array();
        foreach ($currentEarningNodes as $earningNode){
            $currentEarningNodesArray[$earningNode['user_id']] = $earningNode['cnt'];
        }
        $earningNodesArray[$last_commission_month] = $currentEarningNodesArray;

        $minusOneEarningsTableName = 'wallet_commission_'.strtolower($minus_one_month_text_table);
        $minusOneEarningNodes = Yii::app()->db->createCommand()
            ->select('user_id, count(DISTINCT from_node_id) as cnt')
            ->from($minusOneEarningsTableName)
            ->andWhere('wallet_type_id=:wId',[':wId'=>$user_wallet->wallet_type_id])
            ->andWhere('transaction_type=:tt', [':tt' => $creditTransactionType])
            ->group('user_id')
            ->queryAll();
        $minusOneEarningNodesArray = array();
        foreach ($minusOneEarningNodes as $earningNode){
            $minusOneEarningNodesArray[$earningNode['user_id']] = $earningNode['cnt'];
        }
        $earningNodesArray[$minus_one_month] = $minusOneEarningNodesArray;

        $minusTwoEarningsTableName = 'wallet_commission_'.strtolower($minus_two_month_text_table);
        $minusTwoEarningNodes = Yii::app()->db->createCommand()
            ->select('user_id, count(DISTINCT from_node_id) as cnt')
            ->from($minusTwoEarningsTableName)
            ->andWhere('wallet_type_id=:wId',[':wId'=>$user_wallet->wallet_type_id])
            ->andWhere('transaction_type=:tt', [':tt' => $creditTransactionType])
            ->group('user_id')
            ->queryAll();
        $minusTwoEarningNodesArray = array();
        foreach ($minusTwoEarningNodes as $earningNode){
            $minusTwoEarningNodesArray[$earningNode['user_id']] = $earningNode['cnt'];
        }
        $earningNodesArray[$minus_two_month] = $minusTwoEarningNodesArray;

        $detailed_array = array();
        foreach ($comparison_array as $id=>$value){
            $user = UserInfo::model()->findByPk($id);
            $temp = array();
            $temp['name'] = $user->full_name;
            $temp['email'] = $user->email;


            //SELECT DISTINCT from_node_id FROM `wallet_commission_may_2019` WHERE `user_id` = 5 AND wallet_type_id = 1 and transaction_type = 0

            if(count($value) != 3){
                if(!array_key_exists($minus_one_month, $value))
                    $value[$minus_one_month] = 0;
                if(!array_key_exists($minus_two_month, $value))
                    $value[$minus_two_month] = 0;
                if(!array_key_exists($last_commission_month, $value))
                    $value[$last_commission_month] = 0;
            }
            /*
            ksort($value);
            */
            $newValue = array();
            foreach ($value as $x=>$y){
                $temp2 = array();
                $temp2['commission'] = $y;
                if(isset($earningNodesArray[$x][$user->user_id]))
                    $temp2['earning_nodes'] = $earningNodesArray[$x][$user->user_id];
                else
                    $temp2['earning_nodes'] = 0;

                $userAccounts = Yii::app()->db->createCommand()
                    ->select('count(*) as cnt, type')
                    ->from('cbm_user_accounts')
                    ->where('email_address=:ea', [':ea'=>$user->email])
                    ->andWhere('matrix_node_num is not null')
                    ->andWhere('Month(added_to_matrix_at)<=:m',[':m'=>$x])
                    ->group('type')
                    ->queryAll();
                foreach ($userAccounts as $typeAccount){
                    $temp2[$typeAccount['type']] = $typeAccount['cnt'];
                }
                if(!array_key_exists("Self Funded", $temp2))
                    $temp2['Self Funded'] = 0;
                if(!array_key_exists("Profit Funded", $temp2))
                    $temp2['Profit Funded'] = 0;
                $newValue[$x] = $temp2;
            }
            $temp['month_details'] = $newValue;
            array_push($detailed_array, $temp);
        }

        $this->render('comparison',[
            'details' => $detailed_array,
            'last_month_text' => $last_commission_month_text,
            'minus_one_month_text' => $minus_one_month_text,
            'minus_two_month_text' => $minus_two_month_text
        ]);
    }

    /*
     * Add Specific month data from data file to wallet_commission table
     * */
    public function actionAddCommData(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $fileName = $_GET['fileName'];
        if(isset($fileName)){
            CommissionHelper::addCommissionData($fileName);
        }
    }
}