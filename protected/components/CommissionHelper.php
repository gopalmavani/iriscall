<?php

class CommissionHelper extends CApplicationComponent {

    //Distribute Commission
    public static function distributeCommission($start_month, $start_year){

        try {
            $MMCMatrix = MatrixMetaTable::model()->findByAttributes(['table_name' => Yii::app()->params['MMC_Matrix']]);
            $preCalculationMessage = "Action got started at ".date('Y-m-d H:i:s').PHP_EOL;
            $summaryMessage = '';
            $walletCommissionArr = [];

            $multipleLogin = Yii::app()->db->createCommand()
                ->select('login')
                ->from('cbm_accounts')
                //->where(['in', 'login', [200000778]])
                ->queryColumn();

            //To take only CBM login and as there are multiple entries of login in a sheet, sum of commission is required
            $commissions = Yii::app()->db->createCommand()
                ->select('sum(cc.commission) as commission, cc.login, ca.email_address, ca.agent, u.user_id')
                ->from('cbm_commission cc')
                ->join('cbm_accounts ca', 'ca.login = cc.login')
                ->join('user_info u', 'u.email = ca.email_address')
                ->where('month=:mt',[':mt'=>$start_month])
                ->andWhere('year=:yr',[':yr'=>$start_year])
                ->andWhere(['in','cc.login',$multipleLogin])
                ->group('cc.login')
                ->queryAll();
            /*print('<pre>');
            print_r($commissions);*/

            //specific month last date
            $specificMonthLastDate = date('Y-m-t', strtotime($start_year."-".$start_month."-1")) . " 23:59:59";
            //All accounts that are placed in matrix
            $cbm_user_account_group_arr = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cbm_user_accounts')
                //->where('login=:lg',[':lg'=>$record['login']])
                ->andWhere('matrix_id=:mId',[':mId'=>$MMCMatrix->id])
                ->andWhere('matrix_node_num is not null')
                ->andWhere('added_to_matrix_at<=:dt',[':dt'=>$specificMonthLastDate])
                ->queryAll();
            $cbm_user_account_group = [];
            foreach ($cbm_user_account_group_arr as $value){
                if(!array_key_exists($value['login'], $cbm_user_account_group)){
                    $cbm_user_account_group[$value['login']] = [];
                }
                $temp = [];
                $temp['matrix_node_num'] = $value['matrix_node_num'];
                $temp['user_ownership'] = $value['user_ownership'];
                $temp['matrix_id'] = $value['matrix_id'];
                $temp['beneficiary'] = $value['beneficiary'];
                $temp['type'] = $value['type'];
                array_push($cbm_user_account_group[$value['login']], $temp);
                unset($temp);
            }

            //Matrix Commission scheme data
            $matrixCommissionSchemeData = MatrixCommissionScheme::model()->findAll();

            //Backup wallet amount with node specific data
            $backupSchemeWalletTypeId = 3;
            //$backupScheme = CbmCommissionScheme::model()->findByAttributes(['scheme'=>'Backup Cycle', 'matrix_id'=>1]);
            $backup_wallet_entity = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'Backup']);
            $backup_wallet_group = Yii::app()->db->createCommand()
                ->select('user_id, reference_num, sum(case when transaction_type = 0 then amount else 0 end) as credit_amt, sum(case when transaction_type = 1 then amount else 0 end) as debit_amt')
                ->from('wallet')
                ->andWhere('wallet_type_id=:wId',[':wId'=>$backup_wallet_entity->wallet_type_id])
                ->andWhere('transaction_status!=:tStatus',[':tStatus'=>Yii::app()->params['WalletRejectedTransactionStatus']])
                ->group('user_id, reference_num')
                ->queryAll();
            $backup_wallet = array();
            foreach ($backup_wallet_group as $value){
                if(!array_key_exists($value['user_id'], $backup_wallet)){
                    $backup_wallet[$value['user_id']] = [];
                }
                $backup_wallet[$value['user_id']][$value['reference_num']] = round($value['credit_amt'], 3) - round($value['debit_amt'], 3);
            }
            unset($value);

            //Create log directory if not
            if(!is_dir('protected/runtime/commission_logs')){
                mkdir('protected/runtime/commission_logs', 0777, true);
            }
            $preCalculationMessage .= "Pre Calc ended at ".date('Y-m-d H:i:s').PHP_EOL;
            file_put_contents('protected/runtime/commission_logs/commission_'.$start_month.'_'.$start_year.'.log', $preCalculationMessage, FILE_APPEND);
            chmod('protected/runtime/commission_logs/commission_'.$start_month.'_'.$start_year.'.log', 0777);
            $starting_log = 'Commission calculation started at '.date('Y-m-d H:i:s').PHP_EOL.PHP_EOL;
            file_put_contents('protected/runtime/commission_logs/commission_'.$start_month.'_'.$start_year.'.log', $starting_log, FILE_APPEND);
            file_put_contents('protected/runtime/commission_logs/commission_data_'.$start_month.'_'.$start_year.'.csv', "", FILE_APPEND);
            chmod('protected/runtime/commission_logs/commission_data_'.$start_month.'_'.$start_year.'.csv', 0777);


            $schemeOneIdealTotalCommissionRecord = Yii::app()->db->createCommand()
                ->select('sum(max_amount) as total_amount')
                ->from('cbm_commission_scheme')
                ->where('scheme_id=:sId', [':sId'=>1])
                ->queryRow();
            $schemeOneIdealTotalCommission = $schemeOneIdealTotalCommissionRecord['total_amount'];
            $schemeTwoIdealTotalCommissionRecord = Yii::app()->db->createCommand()
                ->select('sum(max_amount) as total_amount')
                ->from('cbm_commission_scheme')
                ->where('scheme_id=:sId', [':sId'=>2])
                ->queryRow();
            $schemeTwoIdealTotalCommission = $schemeTwoIdealTotalCommissionRecord['total_amount'];

            //Going login specific first
            foreach ($commissions as $record){
                if(isset($record['user_id'])){
                    /*//last month date
                    $lastMonthLastDate = date('Y-m-d', strtotime('last day of previous month')) . " 23:59:59";
                    //All accounts that are placed in matrix
                    $accounts = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('cbm_user_accounts')
                        ->where('login=:lg',[':lg'=>$record['login']])
                        ->andWhere('matrix_id=:mId',[':mId'=>1])
                        ->andWhere('matrix_node_num is not null')
                        ->andWhere('added_to_matrix_at<=:dt',[':dt'=>$lastMonthLastDate])
                        ->queryAll();*/
                    if(isset($cbm_user_account_group[$record['login']])){
                        $totalAccounts = count($cbm_user_account_group[$record['login']]);

                        if($totalAccounts > 0){
                            $summaryMessage .= "<p style='color: green; margin-bottom: 0'>Distributing a total of " .$record['commission']. " euro commission for ".$record['email_address']." with login ". $record['login'] . " through " . $totalAccounts ." accounts. (".$record['commission']/$totalAccounts." euro per node)"."</p>";

                            $logMessage = 'Commission calculation started for '.$record['email_address'].' with login '. $record['login'] . ' for ' . $totalAccounts . " nodes at ".date('Y-m-d H:i:s') .PHP_EOL;
                            file_put_contents('protected/runtime/commission_logs/commission_'.$start_month.'_'.$start_year.'.log', $logMessage, FILE_APPEND);

                            //Equal node commission for all nodes in a login
                            $commPerNode = $record['commission']/$totalAccounts;

                            //Node to Scheme distribution amount is same for all nodes in a login
                            $agent = AgentInfo::model()->findByAttributes(['agent_number' => $record['agent']]);

                            //$tempMessageForNodeToScheme = "Node to Scheme distribution amount calculation stated at ".date('Y-m-d H:i:s') .PHP_EOL;
                            //For EU clients in CBM 8917 agent, commission distribution shall follow sequential distribution

                            //$tempMessageForNodeToScheme .= "Node to Scheme distribution amount calculation ended at ".date('Y-m-d H:i:s') .PHP_EOL;
                            //file_put_contents('protected/runtime/commission_logs/commission_'.$start_month.'_'.$start_year.'.log', $tempMessageForNodeToScheme, FILE_APPEND);

                            //Going node specific
                            foreach ($cbm_user_account_group[$record['login']] as $account){
                                $company_excess = 0;
                                $schemeData = array();

                                if(isset($account['matrix_node_num']) && ($account['matrix_node_num'] != '')){

                                    //Define Scheme and Ideal Total Commission
                                    $schemeId = 1;
                                    $idealTotalCommission = $schemeOneIdealTotalCommission;
                                    if($record['agent'] == Yii::app()->params['NexiMaxAgent']){
                                        $schemeId = 1;
                                        $idealTotalCommission = $schemeOneIdealTotalCommission;
                                    } else {
                                        if($record['agent'] == Yii::app()->params['UnityMaxAgent']){
                                            if($account['type'] == 'Self Funded'){
                                                $schemeId = 2;
                                                $idealTotalCommission = $schemeTwoIdealTotalCommission;
                                            } else {
                                                $schemeId = 1;
                                                $idealTotalCommission = $schemeOneIdealTotalCommission;
                                            }
                                        }
                                    }
                                    $commissionSchemes = CbmCommissionScheme::model()->findAllByAttributes(['scheme_id'=>$schemeId]);

                                    if($agent->commission_distribution_mechanism == 'Sequential'){
                                        $unUsedCommission = $commPerNode;
                                        foreach ($commissionSchemes as $scheme){
                                            if($unUsedCommission > 0){
                                                $temp = array();
                                                $temp['max_amount'] = $scheme->max_amount;
                                                $temp['max_earnings'] = $scheme->max_earnings;
                                                $temp['scheme'] = $scheme->scheme;
                                                $temp['wallet_type_id'] = $scheme->wallet_type_id;
                                                if($scheme->max_amount <= $unUsedCommission){
                                                    $schemeDistribute = $scheme->max_amount;
                                                    //For the company excess with no cap to the earnings
                                                    if(is_null($scheme->max_earnings) || $scheme->max_earnings == ''){
                                                        $schemeDistribute = $unUsedCommission;
                                                    }
                                                } else {
                                                    $schemeDistribute = $unUsedCommission;
                                                }
                                                $unUsedCommission -= $schemeDistribute;
                                                $temp['distribution_amount'] = $schemeDistribute;
                                                array_push($schemeData, $temp);
                                                unset($temp);
                                            }
                                        }
                                    } else {
                                        //For Non-EU clients with agent number including 1886, commission distribution shall follow parallel distribution
                                        foreach ($commissionSchemes as $scheme){
                                            $temp = array();
                                            $temp['max_amount'] = $scheme->max_amount;
                                            $temp['max_earnings'] = $scheme->max_earnings;
                                            $temp['scheme'] = $scheme->scheme;
                                            $temp['wallet_type_id'] = $scheme->wallet_type_id;
                                            //For parallel distribution towards all schemes, distribution amount is calculated based upon ideal commission and max amount for a scheme
                                            $schemeDistribute = $commPerNode * $scheme->max_amount / $idealTotalCommission;
                                            //Max earning is null if there is no cap to the earnings.
                                            if(is_null($scheme->max_earnings) || $scheme->max_earnings == ''){
                                                $temp['distribution_amount'] = $company_excess + $schemeDistribute;
                                            } else {
                                                if($schemeDistribute > $scheme->max_amount){
                                                    $temp['distribution_amount'] = $scheme->max_amount;
                                                    $extra_comm = $schemeDistribute - $scheme->max_amount;
                                                    $company_excess += $extra_comm;
                                                } else {
                                                    $temp['distribution_amount'] = $schemeDistribute;
                                                }
                                            }
                                            array_push($schemeData, $temp);
                                            unset($temp);
                                        }
                                    }

                                    foreach ($schemeData as $datum){
                                        if($account['user_ownership'] == 'HALF'){
                                            $maxAmount = $datum['max_amount']/2;
                                        } else {
                                            $maxAmount = $datum['max_amount'];
                                        }
                                        $tempMessage = $datum['scheme']. " amount calculation for ".$account['matrix_node_num']." stated at ".date('Y-m-d H:i:s') .PHP_EOL;
                                        if($datum['scheme'] == 'Cashback earnings' && $datum['distribution_amount'] < $maxAmount){
                                            //Check in Backup wallet only for CashBack earnings
                                            if(isset($backup_wallet[$record['user_id']])){
                                                $user_specific_backup_wallet = $backup_wallet[$record['user_id']];
                                                if(isset($user_specific_backup_wallet[$account['matrix_node_num']])){
                                                    $backupWalletAmount = round($user_specific_backup_wallet[$account['matrix_node_num']],4);

                                                    $tempDistributionAmount = round($datum['distribution_amount'], 4);
                                                    if($backupWalletAmount > 0){
                                                        $requiredAmount = round($maxAmount - $tempDistributionAmount, 4);
                                                        if($requiredAmount >= $backupWalletAmount){
                                                            $withdrawAmount = $backupWalletAmount;
                                                        } else {
                                                            $withdrawAmount = $requiredAmount;
                                                        }
                                                        $distributionAmount = $tempDistributionAmount + $withdrawAmount;

                                                        if($withdrawAmount > 0){
                                                            $summaryMessage .= "<br><p style='color: green; margin-bottom: 0'> Node Id ".$account['matrix_node_num']." received ".$withdrawAmount." from backup wallet.Hooray!!</p><br> ";
                                                            //Withdrawal entry in Wallet
                                                            $debitTransactionType = Yii::app()->params['DebitTransactionType'];
                                                            $deduction_comment = 'Deduction for userId '.$record['user_id'].' and nodeId '.$account['matrix_node_num'];

                                                            $dataAdditionString = '"'.$record['user_id'].'", "'.$backupSchemeWalletTypeId.'", "'.$withdrawAmount.'", "0", "'.
                                                                $record['user_id'].'", "'.$account['matrix_node_num'].'", "'.$account['matrix_node_num'].'", "'.$start_month.'", "'.$start_year.'", "'. $debitTransactionType.'", "'.
                                                                $deduction_comment.'", "2"'.PHP_EOL;
                                                            file_put_contents('protected/runtime/commission_logs/commission_data_'.$start_month.'_'.$start_year.'.csv', $dataAdditionString, FILE_APPEND);
                                                        }
                                                        /*$walletCommissionArr[] = [
                                                            'user_id'=>$record['user_id'],
                                                            'wallet_type_id'=>$backupScheme->wallet_type_id,
                                                            'amount'=>$withdrawAmount,
                                                            'from_level'=> null,
                                                            'from_user_id'=>$record['user_id'],
                                                            'from_node_id'=>$account['matrix_node_num'],
                                                            'to_node_id'=>null,
                                                            'month'=>$start_month,
                                                            'year'=>$start_year,
                                                            'transaction_type'=>$debitTransactionType,
                                                            'transaction_comment'=>$deduction_comment,
                                                            'transaction_status'=>2
                                                        ];*/
                                                    } else {
                                                        $distributionAmount = $datum['distribution_amount'];
                                                    }
                                                } else {
                                                    $distributionAmount = $datum['distribution_amount'];
                                                }
                                            } else {
                                                $distributionAmount = $datum['distribution_amount'];
                                            }
                                            //$tempMessage .= "Cashback distribution amount calculation for ".$account['matrix_node_num']." ended at ".date('Y-m-d H:i:s') .PHP_EOL;
                                            /*if(isset($backupWalletCredit['amount'])){
                                                if(isset($backupWalletDebit['amount'])){
                                                    $backupWalletAmount = round($backupWalletCredit['amount'],5) - round($backupWalletDebit['amount'],5);
                                                } else {
                                                    $backupWalletAmount = $backupWalletCredit['amount'];
                                                }
                                                //$summaryMessage .= "Backup Wallet Amount: ".$backupWalletAmount."<br>";

                                            } else {
                                                $distributionAmount = $datum['distribution_amount'];
                                            }*/
                                        } else {
                                            $distributionAmount = $datum['distribution_amount'];
                                        }
                                        $summaryMessage .= 'Distributing '.$distributionAmount. ' for '.$datum['scheme'].' from Node Id '.$account['matrix_node_num'].'<br>';
                                        $accountArr = [];
                                        $accountArr['matrix_node_num'] = $account['matrix_node_num'];
                                        $accountArr['matrix_id'] = $account['matrix_id'];
                                        $accountArr['beneficiary'] = $account['beneficiary'];
                                        //$tempMessage .= "Node wise distribution amount calculation for ".$account['matrix_node_num']." stated at ".date('Y-m-d H:i:s') .PHP_EOL;
                                        $nodeArray = self::nodeWiseDistribution($record['user_id'], $accountArr, $datum, $distributionAmount, $start_month, $start_year, $matrixCommissionSchemeData);
                                        //$tempMessage .= "Node wise distribution amount calculation ended at ".date('Y-m-d H:i:s') .PHP_EOL;

                                        //$walletCommissionArr = array_merge($walletCommissionArr, $nodeArray);

                                        //$tempMessage .= "Array Merge ended at ".date('Y-m-d H:i:s') .PHP_EOL;
                                        file_put_contents('protected/runtime/commission_logs/commission_'.$start_month.'_'.$start_year.'.log', $tempMessage, FILE_APPEND);
                                    }
                                } else {
                                    $summaryMessage .= "<br> Due to less licenses of ".$record['email']." ,system earned ".$commPerNode.".";
                                }
                            }

                            $logMessage = 'Commission calculation completed at'.date('Y-m-d H:i:s').PHP_EOL;
                            $logMessage .= '---------------------------------'.PHP_EOL;
                            file_put_contents('protected/runtime/commission_logs/commission_'.$start_month.'_'.$start_year.'.log', $logMessage, FILE_APPEND);
                            $summaryMessage .= 'Distribution Completed<br>';
                        }
                    }
                } else {
                    $summaryMessage .= 'User with email '.$record['email_address'].' is not present in CBM';
                }
            }

            //WalletHelper::multipleDataInsert('wallet_commission', $walletCommissionArr);
            /*$file = fopen('protected/runtime/commission_logs/commission_data_'.$start_month.'_'.$start_year.'.csv', "r");
            $insertSQL = "INSERT INTO `wallet_commission`(`user_id`, `wallet_type_id`, `amount`, `from_level`, `from_user_id`,
                      `from_node_id`, `to_node_id`, `month`, `year`, `transaction_type`, `transaction_comment`, `transaction_status`) VALUES ";
            $countVal = 0;
            $newSQL = $insertSQL;
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
            {
                if($countVal <= 10000){
                    if($countVal == 0){
                        $newSQL .= "('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]',
                      '$emapData[6]','$emapData[7]','$emapData[8]','$emapData[9]','$emapData[10]','$emapData[11]')";
                    } else {
                        $newSQL .= ",('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]',
                      '$emapData[6]','$emapData[7]','$emapData[8]','$emapData[9]','$emapData[10]','$emapData[11]')";
                    }
                    $countVal++;
                } else {
                    $countVal = 0;
                    $newSQL .= ";";
                    Yii::app()->db->createCommand($newSQL)->query();
                    $newSQL = $insertSQL;
                    $newSQL .= "('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]',
                      '$emapData[6]','$emapData[7]','$emapData[8]','$emapData[9]','$emapData[10]','$emapData[11]')";
                    $countVal++;
                }
            }
            //For last bunch of data
            if($countVal != 0){
                $newSQL .= ";";
                Yii::app()->db->createCommand($newSQL)->query();
            }
            fclose($file);*/
            self::addCommissionData("commission_data_".$start_month."_".$start_year.".csv");
            echo "CSV File has been successfully Imported.";

            $ending_log = 'Commission calculation ended at '.date('Y-m-d H:i:s').PHP_EOL.PHP_EOL;
            file_put_contents('protected/runtime/commission_logs/commission_'.$start_month.'_'.$start_year.'.log', $ending_log, FILE_APPEND);

            return $summaryMessage;
        } catch (Exception $e){
            $error_log = 'Error: '.$e->getTraceAsString();
            file_put_contents('protected/runtime/commission_logs/commission_'.$start_month.'_'.$start_year.'.log', $error_log, FILE_APPEND);
        }
    }

    //Distribute commission as per the scheme
    public static function nodeWiseDistribution($userId, $account, $scheme, $amount, $month, $year, $schemeData){
        $monthNum = $month;
        $dateObj   = DateTime::createFromFormat('!m', $month);
        $month = $dateObj->format('F');
        $systemUserId = Yii::app()->params['SystemUserId'];
        $creditTransactionType = Yii::app()->params['CreditTransactionType'];
        //$walletCommissionArr = array();
        //Direct Payout for Company profit excess
        if($scheme['scheme'] == 'Company profit excess' || $scheme['scheme'] == 'Company profit matrix'){
            $transactionComment = $scheme['scheme'].' earning from user ID '.$userId. ' and nodeId '. $account['matrix_node_num'].' for '.$month.', '.$year;
            $amount = round($amount, 5);

            $dataAdditionString = '"'.$systemUserId.'", "'.$scheme['wallet_type_id'].'", "'.$amount.'", "0", "'.
                $userId.'", "'.$account['matrix_node_num'].'", "1", "'.$monthNum.'", "'.$year.'", "'. $creditTransactionType.'", "'.
                $transactionComment.'", "2"'.PHP_EOL;
            file_put_contents('protected/runtime/commission_logs/commission_data_'.$monthNum.'_'.$year.'.csv', $dataAdditionString, FILE_APPEND);
            /*$walletCommissionArr[] = [
                'user_id'=>$systemUserId,
                'wallet_type_id'=>$scheme['wallet_type_id'],
                'amount'=>$amount,
                'from_level'=>0,
                'from_user_id'=>$userId,
                'from_node_id'=>$account['matrix_node_num'],
                'to_node_id'=>1,
                'month'=>$monthNum,
                'year'=>$year,
                'transaction_type'=>$creditTransactionType,
                'transaction_comment'=>$transactionComment,
                'transaction_status'=>2
            ];*/
        } else {
            //$data = json_decode(MatrixHelper::GetParentTrace($account['matrix_node_num'], 11, $table->table_name),true);
            $data = json_decode(MatrixHelper::getParentTraceFromDB($account['matrix_node_num']), true);

            $level_commission = array();
            foreach($schemeData as $unit)
            {
                $level_commission[$unit['level']] = $unit['percentage'];
            }
            foreach($data as $d)
            {
                $nodeUserID = (($d['user_id']=="No Node")? $systemUserId : $d['user_id']);
                $distribute_amount = $amount * $level_commission[$d['level']] / 100;

                $transactionComment = $scheme['scheme'].' earning from level ' . $d['level'] .', from user ID '.$userId. ' and nodeId '. $account['matrix_node_num'] .' to nodeId '.$d['parent_node_id'].' and to userId '.$nodeUserID.' for '.$month.', '.$year;
                $distribute_amount = round($distribute_amount, 5);

                $dataAdditionString = '"'.$nodeUserID.'", "'.$scheme['wallet_type_id'].'", "'.$distribute_amount.'", "'.$d['level'].'", "'.
                    $userId.'", "'.$account['matrix_node_num'].'", "'.$d['parent_node_id'].'", "'.$monthNum.'", "'.$year.'", "'. $creditTransactionType.'", "'.
                    $transactionComment.'", "2"'.PHP_EOL;
                file_put_contents('protected/runtime/commission_logs/commission_data_'.$monthNum.'_'.$year.'.csv', $dataAdditionString, FILE_APPEND);
                /*$walletCommissionArr[] = [
                    'user_id'=>$nodeUserID,
                    'wallet_type_id'=>$scheme['wallet_type_id'],
                    'amount'=>$distribute_amount,
                    'from_level'=>$d['level'],
                    'from_user_id'=>$userId,
                    'from_node_id'=>$account['matrix_node_num'],
                    'to_node_id'=>$d['node_id'],
                    'month'=>$monthNum,
                    'year'=>$year,
                    'transaction_type'=>$creditTransactionType,
                    'transaction_comment'=>$transactionComment,
                    'transaction_status'=>2
                ];*/
            }
        }
        //return $walletCommissionArr;
    }

    /*
     * Add normalized data from wallet_commission to
     * wallet table
     * */
    public static function normalizeCommission($start_month, $start_year){
        try {
            $systemNodeId = Yii::app()->params['SystemUserId'];
            $summaryMessage = '';

            /*$fromLoginId = Yii::app()->db->createCommand()
                ->select('matrix_node_num')
                ->from('cbm_user_accounts')
                ->where(['in', 'login', [6075129, 6075382, 6075384, 6075582, 6075612, 6075613]])
                ->queryColumn();*/

            $creditRecords = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount, user_id, wallet_type_id, to_node_id, transaction_type')
                ->from('wallet_commission')
                ->where('month=:mt',[':mt'=>$start_month])
                ->andWhere('year=:yr',[':yr'=>$start_year])
                ->andWhere('transaction_type=:tt', [':tt' => Yii::app()->params['CreditTransactionType']])
                //->andWhere(['in', 'from_node_id', $fromLoginId])
                ->group('user_id, wallet_type_id, to_node_id, transaction_type')
                ->queryAll();

            $debitRecords = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount, user_id, wallet_type_id, from_node_id, transaction_type')
                ->from('wallet_commission')
                ->where('month=:mt',[':mt'=>$start_month])
                ->andWhere('year=:yr',[':yr'=>$start_year])
                ->andWhere('transaction_type=:tt', [':tt' => Yii::app()->params['DebitTransactionType']])
                //->andWhere(['in', 'from_node_id', $fromLoginId])
                ->group('user_id, wallet_type_id, from_node_id, transaction_type')
                ->queryAll();

            $matrix = MatrixMetaTable::model()->findByAttributes(['table_name' => Yii::app()->params['MMC_Matrix']]);

            $dateObj   = DateTime::createFromFormat('!m', $start_month);
            $monthName = $dateObj->format('F');
            //For month last date to be added for commission graph on dashboard
            $monthLastDate = date("Y-m-d", mktime(0, 0, 0, $start_month+1,0,date("Y"))) . " 18:00:00";

            //Below initialization is required for system nodes as they do not have any agent number
            $agentInfo = AgentInfo::model()->findByAttributes(['agent_number'=>Yii::app()->params['NexiMaxAgent']]);
            //Patch as commission schemes are same for both scheme
            $commissionSchemesArr = CbmCommissionScheme::model()->findAllByAttributes(['scheme_id'=>1]);
            $commissionScheme = [];
            foreach ($commissionSchemesArr as $value){
                $commissionScheme[$value->wallet_type_id] = $value->scheme;
            }

            $walletArr = array();
            foreach ($creditRecords as $record){

                //For different reference id based upon agent
                if($record['to_node_id'] != $systemNodeId){
                    $cbmUserAccount = CbmUserAccounts::model()->findByAttributes(['matrix_node_num' => $record['to_node_id']]);
                    $agentInfo = AgentInfo::model()->findByAttributes(['agent_number'=>$cbmUserAccount->agent_num]);
                }

                //Patch related to comment in the wallet for cashback matrix and company profit excess matrix
                if($record['to_node_id'] == 1){
                    $transactionComment = $commissionScheme[$record['wallet_type_id']] . " for " . $monthName . ", " . $start_year . " for " . $matrix->table_name;
                } else {
                    $transactionComment = "Cashback earnings" . " for " . $monthName . ", " . $start_year . " for " . $matrix->table_name;
                }

                $walletArr[] = [
                    'user_id'=>$record['user_id'],
                    'wallet_type_id'=>$record['wallet_type_id'],
                    'transaction_type'=>$record['transaction_type'],
                    'reference_id'=>$agentInfo->wallet_reference_id,
                    'reference_num'=>$record['to_node_id'],
                    'transaction_comment'=>$transactionComment,
                    'denomination_id'=>1,
                    'transaction_status'=>2,
                    'portal_id'=>1,
                    'amount'=>$record['amount'],
                    'created_at'=>$monthLastDate
                ];
            }

            foreach ($debitRecords as $record){

                //For different reference id based upon agent
                if($record['from_node_id'] != $systemNodeId){
                    $cbmUserAccount = CbmUserAccounts::model()->findByAttributes(['matrix_node_num' => $record['from_node_id']]);
                    $agentInfo = AgentInfo::model()->findByAttributes(['agent_number'=>$cbmUserAccount->agent_num]);
                }

                //Patch related to comment in the wallet for cashback matrix and company profit excess matrix
                if($record['from_node_id'] == 1){
                    $transactionComment = $commissionScheme[$record['wallet_type_id']] . " for " . $monthName . ", " . $start_year . " for " . $matrix->table_name;
                } else {
                    $transactionComment = "Cashback earnings" . " for " . $monthName . ", " . $start_year . " for " . $matrix->table_name;
                }
                $walletArr[] = [
                    'user_id'=>$record['user_id'],
                    'wallet_type_id'=>$record['wallet_type_id'],
                    'transaction_type'=>$record['transaction_type'],
                    'reference_id'=>$agentInfo->wallet_reference_id,
                    'reference_num'=>$record['from_node_id'],
                    'transaction_comment'=>$transactionComment,
                    'denomination_id'=>1,
                    'transaction_status'=>2,
                    'portal_id'=>1,
                    'amount'=>$record['amount'],
                    'created_at'=>$monthLastDate
                ];
            }

            WalletHelper::multipleDataInsert('wallet', $walletArr);
            self::integrateReserveWalletSettings($start_month, $monthName, $start_year);
            $summaryMessage .= self::checkPendingOrders();
            return $summaryMessage;
        } catch(Exception $e){
            echo $e->getMessage();
            echo $e->getTraceAsString();
        }
    }

    //Update Commission based upon reserve wallet settings
    public static function integrateReserveWalletSettings($start_month, $monthName, $start_year){
        $creditTransactionType = Yii::app()->params['CreditTransactionType'];
        $approvedTransactionStatus = Yii::app()->params['WalletApprovedTransactionStatus'];
        $userWalletType = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
        $reserveWalletType = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>Yii::app()->params['ReserveWallet']]);

        //Sum of cashback Earnings
        $cashBackEarnings = Yii::app()->db->createCommand()
            ->select('user_id, sum(amount) as amount')
            ->from('wallet')
            ->where('wallet_type_id=:type', [':type' => $userWalletType->wallet_type_id])
            ->andWhere('transaction_type=:tType',[':tType'=>$creditTransactionType])
            ->andWhere(['like', 'transaction_comment', ['%' . $monthName . ', ' . $start_year . '%']])
            ->andWhere('reference_id=:rId',[':rId'=>4])
            ->andWhere('transaction_status=:ts',[':ts'=>$approvedTransactionStatus])
            ->group('user_id')
            ->queryAll();

        //For month last date to be added for commission graph on dashboard
        $monthLastDate = date("Y-m-d", mktime(0, 0, 0, $start_month+1,0,date("Y"))) . " 18:00:00";

        foreach ($cashBackEarnings as $userEarning){

            if(isset($userEarning['amount']) && $userEarning['amount'] > 0){
                $user = UserInfo::model()->findByPk($userEarning['user_id']);
                if($user->reserve_wallet_commission_status == 1){
                    //50% Commission payout / 50% In reserve for pending order
                    $requiredAmount = $userEarning['amount']/2;
                    $transactionComment = "Deduction for ".Yii::app()->params['ReserveWallet'] . " for " . $monthName . ", " . $start_year;

                    //Deduct from UserWallet
                    WalletHelper::addToWallet($user->user_id, $userWalletType->wallet_type_id, Yii::app()->params['DebitTransactionType'],
                        4, $monthName. ', ' .$start_year, $transactionComment, 1, Yii::app()->params['WalletApprovedTransactionStatus'],
                        1, $requiredAmount, $monthLastDate);

                    //Add to reserve Wallet
                    $transactionComment = "Earnings for ".Yii::app()->params['ReserveWallet'] . " for " . $monthName . ", " . $start_year;
                    WalletHelper::addToWallet($user->user_id, $reserveWalletType->wallet_type_id, Yii::app()->params['CreditTransactionType'],
                        6, $monthName. ', ' .$start_year, $transactionComment, 1, Yii::app()->params['WalletApprovedTransactionStatus'],
                        1, $requiredAmount, $monthLastDate);
                } elseif ($user->reserve_wallet_commission_status == 2){
                    //100% In reserve for pending order
                    $requiredAmount = $userEarning['amount'];
                    $transactionComment = "Deduction for ".Yii::app()->params['ReserveWallet'] . " for " . $monthName . ", " . $start_year;

                    //Deduct from UserWallet
                    WalletHelper::addToWallet($user->user_id, $userWalletType->wallet_type_id, Yii::app()->params['DebitTransactionType'],
                        4, 1, $transactionComment, 1, Yii::app()->params['WalletApprovedTransactionStatus'],
                        1, $requiredAmount, $monthLastDate);

                    //Add to reserve Wallet
                    $transactionComment = "Earnings for ".Yii::app()->params['ReserveWallet'] . " for " . $monthName . ", " . $start_year;
                    WalletHelper::addToWallet($user->user_id, $reserveWalletType->wallet_type_id, Yii::app()->params['CreditTransactionType'],
                        6, $monthName. ', ' .$start_year, $transactionComment, 1, Yii::app()->params['WalletApprovedTransactionStatus'],
                        1, $requiredAmount, $monthLastDate);
                }
            }
        }
    }

    //Check for pending orders
    public static function checkPendingOrders(){
        $summaryMessage = '';
        //Users with pending orders
        $users = Yii::app()->db->createCommand()
            ->select('distinct(ui.user_id), full_name, ui.email as email')
            ->from('user_info ui')
            ->join('order_info oi','ui.user_id = oi.user_id')
            ->where('oi.order_status=:os',[':os'=>3])
            ->queryAll();

        foreach ($users as $user){
            $reserve_wallet_balance = WalletHelper::getReserveWalletBalance($user['user_id']);
            $summaryMessage .= "Pending Order update started for ".$user['full_name']." with email ".$user['email']." and balance ". $reserve_wallet_balance ."<br>";
            $pendingOrders = Yii::app()->db->createCommand()
                ->select('*')
                ->from('order_info')
                ->where('user_id=:uId',[':uId'=>$user['user_id']])
                ->andWhere('order_status=:os',[':os'=>3])
                ->order('created_date asc')
                ->queryAll();

            $balance_remaining = $reserve_wallet_balance;
            foreach ($pendingOrders as $order){
                if($order['netTotal'] <= $balance_remaining){
                    OrderHelper::completeOrderSuccess($order['order_id'], 5);
                    $summaryMessage .= "Order Status updated for ".$order['order_id']." with netTotal of ".$order['netTotal']."<br>";
                    $balance_remaining -= $order['netTotal'];
                } else {
                    break;
                }
            }
            $summaryMessage .= "<br>";
        }

        return $summaryMessage;
    }

    /*
     * Commission check for processing withdrawals based upon commissions
     * */
    public static function previousMonthCommissionCheck($close_time){
        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
        $commission_scheme = CbmCommissionScheme::model()->findByAttributes([
            'scheme' => 'Cashback earnings',
            'matrix_id' => 1
        ]);
        $previousMonthDate = date('Y-m-d H:i:s', strtotime($close_time.'-1 month'));
        $month = date('m',strtotime($previousMonthDate));
        $yearNumber = date('Y',strtotime($previousMonthDate));
        $dateObj   = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F');

        $comment = $commission_scheme->scheme." for ".$monthName.'", "'.$yearNumber;
        $walletData = Yii::app()->db->createCommand()
            ->select('count(*) as cnt')
            ->from('wallet')
            ->where('wallet_type_id=:wId', [':wId' => $userWallet->wallet_type_id])
            ->andWhere('transaction_type=:tt', [':tt' => Yii::app()->params['CreditTransactionType']])
            ->andWhere(['like', 'transaction_comment', '%'.$comment.'%'])
            ->queryRow();

        if($walletData['cnt'] > 0){
            $processWithdraw = 1;
        } else {
            $processWithdraw = 0;
        }

        return $processWithdraw;
    }

    /*
     * Add data from commission-data-file
     * */
    public static function addCommissionData($fileName){
        try{
            $fileRelativePath = 'protected/runtime/commission_logs/'.$fileName;
            $filePath = realpath($fileRelativePath);
            $importSQL = "LOAD DATA LOCAL INFILE '".$filePath."' INTO TABLE wallet_commission
                            FIELDS TERMINATED BY ', ' ENCLOSED BY '\"' LINES TERMINATED BY '\n'
                            (`user_id`, `wallet_type_id`, `amount`, `from_level`, `from_user_id`,
                            `from_node_id`, `to_node_id`, `month`, `year`, `transaction_type`, `transaction_comment`, `transaction_status`)
                            SET created_at = CURRENT_TIMESTAMP;";

            //Server Password - 7zfv&bUGv3Tw
            $conn = new PDO("mysql:host=localhost;dbname=micromaxcash", "root","root",
                [PDO::MYSQL_ATTR_LOCAL_INFILE => true]
            );
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // use exec() because no results are returned
            $conn->exec($importSQL);
            /*
             * MYSQL Commands
             * SHOW VARIABLES LIKE 'local_infile';
             * SET GLOBAL local_infile = 1;*/
        } catch(Exception $e){
            echo $e->getMessage()."<br>";
            echo $e->getTraceAsString();
        }
    }
}