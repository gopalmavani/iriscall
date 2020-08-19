<?php

class CronCommand extends CConsoleCommand
{
    public function actionCronExecute()
    {
        $variable_from_file = (int)file_get_contents(Yii::app()->getbaseUrl() . '/count.txt');
        $next = $variable_from_file + 1;
        if (file_put_contents(Yii::app()->getbaseUrl() . '/count.txt', $next) === false) {
            die("Error");
        }
        file_put_contents(Yii::app()->getbaseUrl() . '/count.txt', $next);
        //$variable_from_file = (int)file_get_contents('/count.txt');
    }

    //Get Trades from API to api_trades
    public function actionApiTrades($start = '', $end = ''){

        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $cron_start_time = date('Y-m-d H:i:s');
        try{
            $cron_job = CronInfo::model()->findByAttributes(['name'=>'API Trades - 8915']);

            if ($start == '' && $end == '') {
                /*$last_cron = Yii::app()->db->createCommand()
                    ->select('max(start_time) as start_time')
                    ->from('cron_logs')
                    ->where('cron_id=:cId',[':cId'=>$cron_job->id])
                    ->andWhere('status=:st', [':st'=>1])
                    ->queryRow();
                if(isset($last_cron['start_time'])){
                    $start_time = date("Y-m-d H:i:s", strtotime($last_cron['start_time'].'+3 hours'));
                } else {
                    $start_time = date('Y-m-d H:i:s');
                }*/
                $start = date('Y-m-d', strtotime("-1 day"));
                $start_time = $start." 00:00:00";
                //$end_time = date("Y-m-d H:i:s", strtotime($start_time.'+3 hours'));
                $end_time = $start." 23:59:59";
            } else {
                $start_time = $start;
                $end_time = $end;
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.4xsolutions.com/Mt4manager/Accounts/GetAccountsWithHistory/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => CJSON::encode([
                    "ServerLogin" => "431",
                    "ServerPassword" => "TL@123",
                    "ServerAddress" => "MAM2.infinox.com",
                    "ServerPort" => 443,
                    "StartDate" => $start_time,
                    "EndDate" => $end_time,
                    "AgentID" => Yii::app()->params['CBMAgentNumber'],
                ]),
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $this->handleTradeValues($response, $err, $cron_job, $cron_start_time);

            //2. Handle Infinox Bahamas and Torus Grid API
            $cron_job_bahamas = CronInfo::model()->findByAttributes(['name'=>'API Trades - 1886 and 1887']);
            $curl_bahamas = curl_init();
            curl_setopt_array($curl_bahamas, array(
                CURLOPT_URL => "https://api.4xsolutions.com/Mt4manager/Accounts/GetAccountsWithHistory/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => CJSON::encode([
                    "ServerLogin" => "241",
                    "ServerPassword" => "0eyjAln",
                    "ServerAddress" => "dc1rsln.infinoxbhs1.infinox.tech",
                    "ServerPort" => 443,
                    "StartDate" => $start_time,
                    "EndDate" => $end_time
                ]),
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json"
                ),
            ));

            $response_bahamas = curl_exec($curl_bahamas);
            $err_bahamas = curl_error($curl_bahamas);
            curl_close($curl_bahamas);
            $this->handleTradeValues($response_bahamas, $err_bahamas, $cron_job_bahamas, $cron_start_time);

        } catch (Exception $e){
            $cron_end_time = date('Y-m-d H:i:s');
            CronHelper::addCronLogs(1, $e->getMessage(), $e->getTraceAsString(), 0, $cron_start_time, $cron_end_time);
        }
    }

    //Add response to API trades
    public function handleTradeValues($response, $err, $cron_job, $cron_start_time){
        try{
            $cronField = CylFields::model()->findByAttributes(['field_name'=>'cron_status']);
            $cronFieldSuccess = CylFieldValues::model()->findByAttributes(['field_id'=>$cronField->field_id,'field_label'=>'Success']);
            $cronFieldFailure = CylFieldValues::model()->findByAttributes(['field_id'=>$cronField->field_id,'field_label'=>'Failed']);
            $logMessage = "";

            if($err){
                $errLogMessage = "cURL Error: ".$err;
                $cron_end_time = date('Y-m-d H:i:s');
                CronHelper::addCronLogs($cron_job->id, $errLogMessage, '', $cronFieldFailure->predefined_value, $cron_start_time, $cron_end_time);
            } else {
                $decode = json_decode($response, true);
                $total_trades = 0;
                $execution_time = date('Y-m-d H:i:s');
                $user_trades_values = [];

                foreach ($decode as $k => $res) {
                    // trades calculation
                    $allTrades = $res['Trades'];
                    foreach ($allTrades as $trades) {
                        $temp = [];
                        $temp['login'] = $trades['Login'];
                        $temp['agent_number'] = $res['Agent'];
                        $temp['ticket'] = $trades['Ticket'];
                        $temp['symbol'] = $trades['Symbol'];
                        $temp['type'] = $trades['Type'];
                        if(strtolower($trades['Type']) == 'balance'){
                            $temp['is_accounted_for'] = 1;
                        } else {
                            $temp['is_accounted_for'] = 0;
                        }
                        $temp['lots'] = $trades['Lots'];
                        $temp['open_price'] = $trades['OpenPrice'];
                        $temp['open_time'] = $trades['OpenTime'];
                        $temp['close_price'] = $trades['ClosePrice'];
                        if(is_null($trades['CloseTime']) || $trades['CloseTime'] == ''){
                            $temp['close_time'] = $trades['OpenTime'];
                        } else {
                            $temp['close_time'] = $trades['CloseTime'];
                        }
                        $temp['profit'] = $trades['Profit'];
                        $temp['agent_commission'] = $trades['AgentCommission'];
                        $temp['commission'] = $trades['Commission'];
                        $temp['comment'] = $trades['Comment'];
                        $temp['magic_number'] = $trades['MagicNumber'];
                        $temp['stop_loss'] = $trades['StopLoss'];
                        $temp['swap'] = $trades['Swap'];
                        $temp['reason'] = $trades['Reason'];
                        $temp['created_at'] = $execution_time;
                        array_push($user_trades_values, $temp);
                        $total_trades++;
                    }
                }
                if(!empty($user_trades_values)){
                    CronHelper::cronDataInsert('api_trades', $user_trades_values);
                    $logMessage .= $total_trades. " trades were added.";
                } else {
                    $logMessage .= "No trades were added.";
                }
                $cron_end_time = date('Y-m-d H:i:s');
                CronHelper::addCronLogs($cron_job->id, $logMessage, '', $cronFieldSuccess->predefined_value, $cron_start_time, $cron_end_time);
            }
        } catch(Exception $e){
            $cron_end_time = date('Y-m-d H:i:s');
            CronHelper::addCronLogs(1, $e->getMessage(), $e->getTraceAsString(), 0, $cron_start_time, $cron_end_time);
        }
    }

    /*
     * Compute daily generated commission
     * */
    public function actionCalculateGeneratedCommission(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $accounted_tickets = [];
        //For 8917 and 1886
        $masterLogin = Yii::app()->db->createCommand()
            ->select('master_login')
            ->from('agent_details')
            ->where('master_login is not null')
            ->queryColumn();

        $masterTrades = Yii::app()->db->createCommand()
            ->select('ticket, (profit+commission+swap) as profit, agent_commission, close_time')
            ->from('api_trades')
            ->where(['in', 'login', $masterLogin])
            ->andWhere(['in', 'type', ['BUY', 'SELL']])
            ->andWhere('is_accounted_for=:iaf', [':iaf'=>0])
            ->queryAll();

        $commission_trades = [];
        foreach ($masterTrades as $masterTrade){
            if($masterTrade['profit'] != 0){
                $childTrades = Yii::app()->db->createCommand()
                    ->select('login, ticket, profit, agent_commission, close_time')
                    ->from('api_trades')
                    ->where('magic_number=:mn', [':mn'=>$masterTrade['ticket']])
                    ->queryAll();

                foreach ($childTrades as $trade){
                    $commission = $trade['profit'] * $masterTrade['agent_commission'] / $masterTrade['profit'];
                    $temp = [];
                    $temp['login'] = $trade['login'];
                    $temp['trade_ticket'] = $masterTrade['ticket'];
                    $temp['month'] = date('m', strtotime($masterTrade['close_time']));
                    $temp['year'] = date('Y', strtotime($masterTrade['close_time']));
                    $temp['close_time'] = $masterTrade['close_time'];
                    $temp['commission'] = $commission;
                    array_push($commission_trades, $temp);
                    array_push($accounted_tickets, $trade['ticket']);
                }
                array_push($accounted_tickets, $masterTrade['ticket']);
                echo 'Added for master trade: '.$masterTrade['ticket'].'<br>';
            } else {
                //For zero profit, directly mark the trades as accounted
                $zeroCommissionChildTrades = Yii::app()->db->createCommand()
                    ->select('ticket')
                    ->from('api_trades')
                    ->where('magic_number=:mn', [':mn'=>$masterTrade['ticket']])
                    ->queryAll();
                foreach ($zeroCommissionChildTrades as $zeroCommissionChildTrade){
                    array_push($accounted_tickets, $zeroCommissionChildTrade['ticket']);
                }
                array_push($accounted_tickets, $masterTrade['ticket']);
            }
        }

        //For 1887
        $direct_trades = Yii::app()->db->createCommand()
            ->select('c.login, ticket, profit, agent_commission, close_time')
            ->from('api_trades a')
            ->join('cbm_accounts c','c.login=a.login')
            ->where('c.agent=:ag',[':ag'=>Yii::app()->params['UTITAgentNumber']])
            ->andWhere('is_accounted_for=:iaf', [':iaf'=>0])
            ->queryAll();
        foreach ($direct_trades as $direct_trade){
            $temp = [];
            $temp['login'] = $direct_trade['login'];
            $temp['trade_ticket'] = $direct_trade['ticket'];
            $temp['month'] = date('m', strtotime($direct_trade['close_time']));
            $temp['year'] = date('Y', strtotime($direct_trade['close_time']));
            $temp['commission'] = $direct_trade['agent_commission'];
            $temp['close_time'] = $direct_trade['close_time'];
            array_push($commission_trades, $temp);
            array_push($accounted_tickets, $direct_trade['ticket']);
        }

        //Update the trades in api_trades table
        if(count($accounted_tickets) > 0){
            $update_query = 'update api_trades set is_accounted_for=1, modified_at="'.date('Y-m-d H:i:s').'" where is_accounted_for=0 and ticket in ('.implode(',', $accounted_tickets) . ');';
            $res = Yii::app()->db->createCommand($update_query)->query();
        }
        CronHelper::cronDataInsert('cbm_commission', $commission_trades);
    }

    /*
     * This will do following process:
     * 1. Fetch MT4 Data.
     * 2. Add Deposit rows.
     * 3. Add/Update Api-Accounts.
     * 4. Add Daily Balance.
     * */
    public function actionUpdatemt4($start = '', $end = '')
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $cron_start_time = date('F d, Y h:i A');
        $notification_channel = Yii::app()->params['SlackNotificationChannel'];

        if ($start == '' && $end == '') {
            $sql = "SELECT `date` FROM `cbm_logs` ORDER BY `id` DESC LIMIT 1";
            $startdate = Yii::app()->db->createCommand($sql)->queryAll();
            if ($startdate == null || ($startdate[0]['date'] == null)) {
                $start = date("Y-m-d");
            } else {
                $start = date("Y-m-d", strtotime($startdate[0]['date']));
            }
            $end = date("Y-m-d");
        }

        //1. Fetch MT4 Data for 8917.
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.4xsolutions.com/Mt4manager/Accounts/GetAccountsWithHistory/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => CJSON::encode([
                "ServerLogin" => "431",
                "ServerPassword" => "TL@123",
                "ServerAddress" => "MAM2.infinox.com",
                "ServerPort" => 443,
                "StartDate" => $start . " 00:00:00",
                "EndDate" => $end . " 23:59:59"
            ]),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $rs1 = $this->handleServerResponse($cron_start_time, $start, $end, $response, $err);

        //For any additional responses, code needs to added below and in view page (admin/mt4/settings)
        echo json_encode(['CBMResponse'=>$rs1/*, 'BahamasResponse'=>$rs2*/]);
        $cron_end_time = date('F d, Y h:i A');
        SlackHelper::sendData($notification_channel, "-----Job ended at: ".$cron_end_time."-----");
    }

    public function handleServerResponse($cron_start_time, $start, $end, $response, $err){

        try{
            $agents = AgentDetails::model()->findAll();
            $masterAgents = [];
            $allowedAgents = [];
            foreach ($agents as $agent){
                if(!is_null($agent->master_login) && ($agent->master_login != '')){
                    array_push($masterAgents, $agent->master_login);
                    array_push($allowedAgents, $agent->agent_number);
                }
            }

            $notification_channel = Yii::app()->params['SlackNotificationChannel'];

            $depositFund = 0;
            $withdrawFund = 0;
            $depositWithdrawSummary = '';
            $mt4AccountSummary = '';

            $summary = '';
            $messageLog = '';
            $statalyseSummary = '';
            if ($err) {
                $messageLog .= "<p style='color: red; margin-bottom: 0'>cURL Error #:" . $err . '</p><br>';
                $logs = new CbmLogs();
                $logs->status = 2;
                $logs->created_date = date('Y-m-d H:i:s');
                $logs->log = "Curl error: ".$err." with start time: ".$start." and end time: ".$end;
                $logs->save(false); // saving logs
            } else {
                $messageLog .= "<p style='color: green; margin-bottom: 0'>Account details were fetched successfully from MT4. </p><br>";
                $decode = json_decode($response, true);

                if ($decode == true) {
                    ini_set('max_execution_time', 300);
                    $new_accounts = 0; // initializing trade counts
                    $updated_accounts = 0;
                    $count = 0;
                    $deposits = 0;
                    $withdrawals = 0;
                    $erroneousDeposits = array();
                    foreach ($decode as $k => $res) {
                        //To consider only MMC related agents
                        if(in_array($res['Agent'], $allowedAgents)){
                            $accountTrades = $res['Trades'];
                            foreach ($accountTrades as $i => $trade) {
                                $checkDeposit = CbmDepositWithdraw::model()->findByAttributes(['ticket' => $trade['Ticket']]);
                                if (isset($trade['Comment']) && !isset($checkDeposit->id)) {
                                    $comment = $trade['Comment'];
                                    //2. Add Deposit rows.
                                    if (stripos($comment, 'Deposit') !== false || stripos($comment, 'Transfer In') !== false ||
                                        stripos($comment, 'Withdraw') !== false || stripos($comment, 'Transfer Out') !== false ||
                                        stripos($comment, 'Reversal') !== false || stripos($comment, 'Reverse') !== false) {
                                        $apiDW = new CbmDepositWithdraw();
                                        $apiDW->login = $trade['Login'];
                                        $apiDW->ticket = $trade['Ticket'];
                                        $apiDW->api_type = $trade['Type'];
                                        $apiDW->symbol = $trade['Symbol'];
                                        $apiDW->lots = $trade['Lots'];
                                        $apiDW->open_price = $trade['OpenPrice'];
                                        $apiDW->open_time = $trade['OpenTime'];
                                        $apiDW->close_price = $trade['ClosePrice'];
                                        $apiDW->close_time = $trade['CloseTime'];
                                        $apiDW->profit = $trade['Profit'];
                                        if (($trade['Profit'] % 50 != 0) || ($trade['Profit'] < 0)) array_push($erroneousDeposits, $res['EmailAddress']);
                                        $apiDW->commission = $trade['Commission'];
                                        $apiDW->agent_commission = $trade['AgentCommission'];
                                        $apiDW->comment = $trade['Comment'];
                                        $apiDW->magic_number = $trade['MagicNumber'];
                                        $apiDW->stop_loss = $trade['StopLoss'];
                                        $apiDW->take_profit = $trade['TakeProfit'];
                                        $apiDW->swap = $trade['Swap'];
                                        $apiDW->created_at = date('Y-m-d H:i:s');
                                        $apiDW->email = $res['EmailAddress'];
                                        if ($trade['Profit'] > 0) {
                                            $apiDW->type = "Deposit";
                                            $depositFund += $apiDW->profit;
                                            $depositWithdrawSummary .= '*Deposit:* User '.$res['EmailAddress']. " made a deposit of ".$apiDW->profit." euro \n";
                                        } else {
                                            $apiDW->type = "Withdraw";
                                            $withdrawFund += abs($apiDW->profit);
                                            $depositWithdrawSummary .= '*Withdraw:* User '.$res['EmailAddress']. " did a withdrawal of ".$apiDW->profit." euro \n";
                                        }
                                        $apiDW->save(false);

                                        if ($trade['Profit'] > 0) {
                                            //Only for production
                                            if(isset(Yii::app()->params['env']) && (Yii::app()->params['env'] != 'local')){
                                                /*
                                                * for the notification add the database.
                                                */
                                                $body = 'A deposit of' . $apiDW->profit . ' was done by ' . $apiDW->email . '';
                                                $url = Yii::app()->createUrl('admin/mt4/depositWithdrawView') . "/" . $apiDW->id;
                                                $date = $apiDW->close_time;
                                                $nid = NotificationHelper::AddNotitication('New Deposit', $body, 'deposit', $apiDW->login, 0, $url, $date);

                                                /*
                                                * for the notification add to the admin side using pusher.
                                                */
                                                $message = "A new deposit was added with amount ";
                                                $date = $apiDW->close_time;
                                                //$url is the define for redirect order details link page.
                                                NotificationHelper::pusherNotificationVpamm($message, $date, $url, $apiDW->login, $apiDW->email, $apiDW->profit, $nid);
                                            }

                                            //New Deposit Email
                                            OrderHelper::DepositMail($trade['Ticket']);
                                            $deposits++;
                                            $messageLog .= "<p style='color: green; margin-bottom: 0'>New Deposit found for " . $res['EmailAddress'] . " of " . $trade['Profit'] . " amount</p>";
                                            $apiDW = null;

                                            $logs = new CbmLogs();
                                            $logs->status = 1;
                                            $logs->created_date = date('Y-m-d H:i:s');
                                            $logs->log = "New Deposit found for " . $res['EmailAddress'] . " of " . $trade['Profit'] . " amount";
                                            $logs->save(false); // saving logs
                                        } else {
                                            //Only for production
                                            if(isset(Yii::app()->params['env']) && (Yii::app()->params['env'] != 'local')){
                                                $body = 'A withdrawal of' . $apiDW->profit . ' was done by ' . $apiDW->email . '';
                                                $url = Yii::app()->createUrl('admin/mt4/depositWithdrawView') . "/" . $apiDW->id;
                                                $date = $apiDW->close_time;
                                                $nid = NotificationHelper::AddNotitication('New Withdrawal', $body, 'deposit', $apiDW->login, 0, $url, $date);

                                                $message = "A new withdrawal was added with amount ";
                                                $date = $apiDW->close_time;
                                                //$url is the define for redirect order details link page.
                                                NotificationHelper::pusherNotificationVpamm($message, $date, $url, $apiDW->login, $apiDW->email, $apiDW->profit, $nid);
                                            }

                                            $messageLog .= "<p style='color: red; margin-bottom: 0'>New Withdrawal found for " . $res['EmailAddress'] . " of " . $trade['Profit'] . " amount</p>";
                                            $withdrawals++;

                                            $logs = new CbmLogs();
                                            $logs->status = 1;
                                            $logs->created_date = date('Y-m-d H:i:s');
                                            $logs->log = "New Withdrawal found for " . $res['EmailAddress'] . " of " . $trade['Profit'] . " amount";
                                            $logs->save(false); // saving logs
                                        }
                                    }
                                }
                            }

                            $accountLogin = $res['Login'];
                            $accountCount = CbmAccounts::model()->find('login=:login', [':login' => $accountLogin]);

                            //3. Add/Update Api-Accounts.
                            if (isset($accountCount->login)) { // checking if account exists? if not than it will insert records
                                $accountModel = CbmAccounts::model()->find('login=:login', [':login' => $accountLogin]);
                                $accountModel->modified_at = date('Y-m-d h:i:s');
                                $messageLog .= "<p style='color: cornflowerblue; margin-bottom: 0'>User account with email '" . $res['EmailAddress'] . "' got updated </p>";
                                $messageLog .= "Old Balance: " . $accountModel->balance . " New Balance: " . $res['Balance'] . "<br><br>";
                                $updated_accounts++;
                            } else {
                                //Incomplete account error notification
                                if((is_null($res['EmailAddress']) || $res['EmailAddress']=='') || (is_null($res['Group']) || $res['Group']=='') || (is_null($res['Agent']) || $res['Agent']=='')  || (is_null($res['Login']) || $res['Login']=='')){
                                    $incompleteAccountMessage = '------------------:warning: :warning: An MT4 account with incomplete details was created :warning: :warning:------------------'.'\n\n';
                                    $incompleteAccountMessage .= 'Details: \n Login: '.$res['Login'].
                                        '\n email: '.$res['EmailAddress'].'\n agent: '.$res['Agent'].' \n group: '.$res['Group'];
                                    SlackHelper::sendData($notification_channel, $incompleteAccountMessage );
                                }
                                $accountModel = new CbmAccounts();
                                $accountModel->prev_balance = 0;
                                $accountModel->prev_equity = 0;
                                $accountModel->max_balance = 0;
                                $accountModel->max_equity = 0;
                                $accountModel->created_date = date('Y-m-d h:i:s');

                                $messageLog .= "<p style='color: green; margin-bottom: 0'>New Api Account created for " . $res['EmailAddress'] . "</p>";

                                //Only for production
                                if(isset(Yii::app()->params['env']) && (Yii::app()->params['env'] != 'local')){
                                    //for the notification add the database.
                                    $body = 'New CBM-MT4 account added for ' . $res['EmailAddress'] . ' with balance ' . $res['Balance'] . '';
                                    $url = Yii::app()->createUrl('admin/mt4/view') . "/" . $accountLogin;
                                    $nid = NotificationHelper::AddNotitication('Add CBM-MT4 Account', $body, 'deposit', $accountLogin, 0, $url);

                                    //for the notification add to the admin side using pusher.
                                    $message = 'A new account was added with balance ';
                                    $date = date('Y-m-d H:i:s');
                                    //$url is the define for redirect order details link page.
                                    NotificationHelper::pusherNotificationVpamm($message, $date, $url, $accountLogin, $res['EmailAddress'], $res['Balance'], $nid);
                                }

                                $new_accounts++;
                                $mt4AccountSummary .= 'New MT4 account was created with email: '.$res['EmailAddress']." and balance: " . $res['Balance'] . " \n";
                            }

                            //Add-Update to CBM User License
                            $userInfo = UserInfo::model()->findByAttributes(['email'=>$res['EmailAddress']]);
                            if(isset($userInfo->user_id))
                                $userId = $userInfo->user_id;
                            else
                                $userId = 0;
                            ServiceHelper::modifyCBMUserLicenses($userId, $res['EmailAddress'], 0, 0);

                            $accountModel->login = $res['Login'];
                            if (!in_array($accountModel->login, $masterAgents))
                                $equity = $this->getEquity($res['Agent'], $res['Balance'], $res['Equity'], $res['Group']);
                            else
                                $equity = $res['Equity'];
                            $accountModel->name = $res['Name'];
                            $accountModel->prev_balance = $accountModel->balance;
                            $accountModel->prev_equity = $accountModel->equity;
                            $accountModel->currency = $res['Currency'];
                            $accountModel->balance = $res['Balance'];
                            $accountModel->equity = $equity;
                            $accountModel->email_address = $res['EmailAddress'];
                            $accountModel->group = $res['Group'];
                            $accountModel->agent = isset($res['Agent'])?$res['Agent']:'';
                            $accountModel->registration_date = $res['RegistrationDate'];
                            $accountModel->leverage = $res['Leverage'];
                            $accountModel->address = $res['Address'];
                            $accountModel->city = $res['City'];
                            $accountModel->state = $res['State'];
                            $accountModel->postcode = $res['PostCode'];
                            $accountModel->country = $res['Country'];
                            $accountModel->phone_number = $res['PhoneNumber'];
                            if($accountModel->max_balance < $accountModel->balance){
                                $accountModel->max_balance = $accountModel->balance;
                            }
                            if($accountModel->max_equity < $accountModel->equity){
                                $accountModel->max_equity = $accountModel->equity;
                            }
                            $accountModel->save();

                            //Calculate total deposit
                            $accountDepositSum = Yii::app()->db->createCommand()
                                ->select('sum(profit) as deposit')
                                ->from('cbm_deposit_withdraw')
                                ->where('login=:lg', [':lg' => $res['Login']])
                                ->andWhere('reason IS NULL')
                                ->queryRow();
                            //Get previous balance from user daily balance
                            $previousBalance = Yii::app()->db->createCommand()
                                ->select('balance, deposit')
                                ->from('user_daily_balance')
                                ->where('email_address=:ea', [':ea' => $res['EmailAddress']])
                                ->andWhere('login=:lg', [':lg' => $res['Login']])
                                ->order('created_at desc')
                                ->queryRow();
                            if (!empty($previousBalance['balance']) && !empty($previousBalance['deposit'])) {
                                $balancediff = $res['Balance'] - $previousBalance['balance'];
                                $depositdiff = $accountDepositSum['deposit'] - $previousBalance['deposit'];
                                $balancepercentage = round(($balancediff - $depositdiff) * 100 / $previousBalance['balance'] ,2);

                                if($balancepercentage >= 10 || $balancepercentage <= -10){
                                    if($balancepercentage >= 10){
                                        $growthmsg = "Profit Percentage  " . $balancepercentage . "% \n";
                                    }else{
                                        $growthmsg = "Loss Percentage  " . $balancepercentage . "% \n";
                                    }
                                    $statalyseSummary .= "\n *User - ". $res['EmailAddress']. "*\n ".
                                        "Login - ".$res['Login']." \n".
                                        "Agent - ".$res['Agent']." \n".
                                        $growthmsg.
                                        "Current/Previous Balance " . $res['Balance'] ."/".$previousBalance['balance'].  " \n".
                                        "Current/Previous Deposit " . $accountDepositSum['deposit'] ."/".$previousBalance['deposit']." \n";
                                }
                            }
                            if($res['Balance'] != 0 && !is_null($accountDepositSum['deposit'])  && $equity != 0){
                                $day_number = date('w');
                                //Statalyse should not be executed on Saturday and Sunday
                                if($day_number!= 0 && $day_number!=6)
                                    $this->addUpdateDailyBalance($res['EmailAddress'], $res['Login'], $res['Balance'], $res['Agent'], $equity, $accountDepositSum['deposit']);
                                $count++;
                            }
                        }
                    }

                    $temp = '';
                    if (count($erroneousDeposits) != 0) {
                        $temp = '- Deposits of ';
                        foreach ($erroneousDeposits as $email) {
                            $temp .= $email . ", ";
                        }
                        $temp .= "were imprecise";
                    }
                    $summary .= "<p style='color: green;'> Summary of execution: <br>" .
                        "- New " . $deposits . " deposits were found. <br>" .
                        "- New " . $new_accounts . " accounts were created. <br>" .
                        "- Old " . $updated_accounts . " accounts were updated. <br>" .
                        "</p>";
                    $summary .= "<p style='color: red;'>" . $temp . "</p>";

                    if($mt4AccountSummary == '')
                        $mt4AccountSummary = "No new MT4 accounts were created";
                    if($depositWithdrawSummary == '')
                        $depositWithdrawSummary = "No new deposit/withdraw found in the system";
                    SlackHelper::sendData($notification_channel, "`Deposit/Withdraws`-  ".$cron_start_time." \n".$depositWithdrawSummary.
                        "\n\n"."`MT4 Accounts`-  ".$cron_start_time."\n".$mt4AccountSummary."\n\n"."Old " . $updated_accounts . " accounts were updated. \n\n"
                        ."`Statalyse Job`-  ".$cron_start_time."\n"."New ".$count." entries were created/updated \n" .$statalyseSummary );
                    $logs = new CbmLogs();
                    $logs->status = 1;
                    $logs->created_date = date('Y-m-d H:i:s');
                    $logs->date = $end;
                    $logs->total_accounts = $new_accounts + $updated_accounts;
                    $logs->log = 'No of new accounts: ' . $new_accounts . ', No of updated accounts: ' . $updated_accounts . ', No of inserted/updated rows in user_daily_balance: ' . $count;
                    $logs->save(false); // saving logs
                } else {
                    echo '<div class="error"> Could not fetch accounts from API , <i>' . $decode['error']['error'] . '</i></div>';
                    $logs = new CbmLogs();
                    $logs->status = 0;
                    $logs->created_date = date('Y-m-d H:i:s');
                    $logs->date = $end;
                    $logs->log = 'API Error #: Could not fetch accounts from API , ' . $decode['error']['error'];
                    $logs->save(false); // saving logs
                }
            }
            //Update NULL records
            Yii::app()->db->createCommand()
                ->update('cbm_accounts', [
                    'prev_balance' => 0
                ], 'isNULL(prev_balance)=:st', [':st' => 1]);
            Yii::app()->db->createCommand()
                ->update('cbm_accounts', [
                    'prev_equity' => 0
                ], 'isNULL(prev_equity)=:st', [':st' => 1]);

            $result = ['messageLog' => $messageLog, 'summary' => $summary];
            return $result;

        } catch (Exception $e){
            $logs = new CbmLogs();
            $logs->status = 2;
            $logs->created_date = date('Y-m-d H:i:s');
            $logs->log = $e->getMessage();
            $logs->save(false); // saving logs

            return $e->getMessage();
        }
    }

    /*
     * This will do following process:
     * 1. Fetch MT4 Data.
     * 2. Add Daily Balance.
     * Per 3 hour run this cron for update daily balance
     * */
    public function actionStatalyseJob()
    {
        $cron_start_time = date('F d, Y h:i A');
        $notification_channel = Yii::app()->params['StatalyseSlackNotificationChannel'];

        $start = date("Y-m-d");
        $end = date("Y-m-d");

        $summary = '';
        $messageLog = '';

        $curl = curl_init();

        //1. Fetch MT4 Data.
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.4xsolutions.com/Mt4manager/Accounts/GetAccountsWithHistory/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => CJSON::encode([
                "ServerLogin" => "431",
                "ServerPassword" => "TL@123",
                "ServerAddress" => "MAM2.infinox.com",
                "ServerPort" => 443,
                "StartDate" => $start . " 00:00:00",
                "EndDate" => $end . " 23:59:59"
            ]),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $messageLog .= "<p style='color: red; margin-bottom: 0'>cURL Error #:" . $err . '</p><br>';
            $logs = new CbmLogs();
            $logs->status = 2;
            $logs->created_date = date('Y-m-d H:i:s');
            $logs->log = "Curl error: ".$err." with start time: ".$start." and end time: ".$end;
            $logs->save(false); // saving logs
        } else {
            $messageLog .= "<p style='color: green; margin-bottom: 0'>Account details were fetched successfully from MT4. </p><br>";
            $decode = json_decode($response, true);

            $agents = AgentDetails::model()->findAll();
            $masterAgents = [];
            foreach ($agents as $agent){
                if(!is_null($agent->master_login) && ($agent->master_login != ''))
                    array_push($masterAgents, $agent->master_login);
            }
            //For the sake of ignoring '200096'
            array_push($masterAgents, 200096);

            if ($decode == true) {
                ini_set('max_execution_time', 300);
                $count = 0;
                foreach ($decode as $k => $res) {
                    $login = $res['Login'];
                    if (!in_array($login, $masterAgents))
                        $equity = $this->getEquity($res['Agent'], $res['Balance'], $res['Equity'], $res['Group']);
                    else
                        $equity = $res['Equity'];

                    //Calculate total deposit
                    $accountDepositSum = Yii::app()->db->createCommand()
                        ->select('sum(profit) as deposit')
                        ->from('cbm_deposit_withdraw')
                        ->where('login=:lg', [':lg' => $res['Login']])
                        ->andWhere('reason IS NULL')
                        ->queryRow();
                    //Get previous balance from user daily balance
                    $previousBalance = Yii::app()->db->createCommand()
                        ->select('balance, deposit')
                        ->from('user_daily_balance')
                        ->where('email_address=:ea', [':ea' => $res['EmailAddress']])
                        ->order('created_at desc')
                        ->queryRow();
                    if (!empty($previousBalance['balance']) && !empty($previousBalance['deposit'])) {
                        $balancediff = $res['Balance'] - $previousBalance['balance'];
                        $depositdiff = $accountDepositSum['deposit'] - $previousBalance['deposit'];
                        $balancepercentage = round(($balancediff - $depositdiff) * 100 / $previousBalance['balance'] ,2);

                        if($balancepercentage >= 10){
                            $summary = $res['EmailAddress']. "  at " . $cron_start_time . "\n ".
                                "has growth Percentage  " . $balancepercentage . "% growth. \n" .
                                "Current Balance " . $res['Balance'] .  " \n".
                                "Previous Balance " . $previousBalance['balance'] . " \n".
                                "Current Deposit " . $accountDepositSum['deposit'] ." \n".
                                "Previous Deposit " . $previousBalance['deposit'] . " \n" ;
                            SlackHelper::sendData($notification_channel, "`For email `  ".$summary."\n");
                        }
                    }
                    if($res['Balance'] != 0 && !is_null($accountDepositSum['deposit'])  && $equity != 0){
                        // Add Daily Balance
                        $this->addUpdateDailyBalance($res['EmailAddress'], $res['Login'], $res['Balance'], $res['Agent'], $equity, $accountDepositSum['deposit']);
                        $count++;
                    }
                }
                $cron_end_time = date('F d, Y h:i A');
                $endSummary = "Job ended at: ".$cron_end_time;
                SlackHelper::sendData($notification_channel, "`CBM User Growth` -  " .$cron_start_time."\n New ".$count." entries were created"."\n".$endSummary);

            } else {
                echo '<div class="error"> Could not fetch accounts from API , <i>' . $decode['error']['error'] . '</i></div>';
                $logs = new CbmLogs();
                $logs->status = 0;
                $logs->created_date = date('Y-m-d H:i:s');
                $logs->date = $end;
                $logs->log = 'API Error #: Could not fetch accounts from API , ' . $decode['error']['error'];
                $logs->save(false); // saving logs
            }
        }

        echo json_encode(['messageLog' => $messageLog, 'summary' => $summary]);
    }

    //Create User accounts
    public function actionCreateUserAcc()
    {
        //header("Access-Control-Allow-Origin: *");
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $notification_channel = Yii::app()->params['SlackNotificationChannel'];
        $cron_start_time = date('F d, Y h:i A');
        $startSummary = "-----CBM User Accounts creation Job started at: ".$cron_start_time."------\n\n";
        $message = $this->actionMasterFunded();
        $message .= $this->actionProfitFunded();
        $message .= $this->actionAddLegitAccounts();
        $cron_end_time = date('F d, Y h:i A');
        $endSummary = "-----CBM User Accounts creation Job ended at: ".$cron_end_time."-----";
        SlackHelper::sendData($notification_channel, $startSummary."*Summary of the Job:* \n"."`CBM User Accounts` \n".$message."\n".$endSummary);
    }

    public function isWithdrawalRequestPresent($email){
        $transaction = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cbm_deposit_withdraw')
            ->where('email=:ea', [':ea'=>$email])
            ->andWhere('profit<=:pf', [':pf'=>0])
            ->andWhere('is_accounted_for=:iaf', [':iaf'=>0])
            ->queryAll();
        if(count($transaction) > 0){
            return true;
        } else {
            return false;
        }
    }

    public function actionMasterFunded()
    {
        try {
            $depositWithdrawSummary = '';
            $agents = AgentInfo::model()->findAll();
            $agentDetails = AgentDetails::model()->findAll();
            $masterLogin = [];
            $mmc_matrix = MatrixMetaTable::model()->findByAttributes(['table_name'=>Yii::app()->params['MMC_Matrix']]);
            $fakeDepositArray = CronHelper::fakeDepositArray();
            foreach ($agentDetails as $agentDatum){
                array_push($masterLogin, $agentDatum->master_login);
            }
            foreach ($agents as $agent) {
                $CbmAccounts = CbmAccounts::model()->findAllByAttributes(['agent' => $agent->agent_number]);
                foreach ($CbmAccounts as $account) {
                    $selfFundedCount = 0;
                    $nodePlaced = 0;
                    //Account is not master and has an email address
                    if (isset($account->email_address) && !in_array($account->login, $masterLogin)) {
                        //To check if the email is not in fake deposits array
                        if(!in_array($account->email_address, $fakeDepositArray)){
                            //To check if there is an unprocessed withdrawal request present
                            if(!$this->isWithdrawalRequestPresent($account->email_address)){
                                echo "<p style='color: green; margin-bottom: 0'>Calculating deposits for " . $account->email_address . '</p>';
                                //All Unaccounted deposits
                                $deposits = CbmDepositWithdraw::model()->findAllByAttributes(['login' => $account->login, 'is_accounted_for' => 0]);
                                if (count($deposits) == 0) {
                                    echo "<p style='color: cadetblue; margin-bottom: 0'>No new deposits found for " . $account->email_address . '</p><br>';
                                }
                                // for latest code of total licenses and available licenses get
                                $cbm_user_licenses = CbmUserLicenses::model()->findByAttributes(['email' => $account->email_address]);

                                $totalDeposit = 0;
                                $totalWithdrawal = 0;
                                foreach ($deposits as $deposit) {
                                    if ($deposit->profit > 0) {
                                        $totalDeposit += $deposit->profit;
                                    } elseif ($deposit->profit < 0) {
                                        $totalWithdrawal += $deposit->profit;
                                    }
                                }
                                if ($totalDeposit >= $agent->minimum_deposit) {
                                    echo "A total deposit of " . $totalDeposit . " is eligible for account creation. <br>";
                                    $required_node_count = floor($totalDeposit / $agent->minimum_self_node_balance);
                                    $available_license_count = $cbm_user_licenses->available_licenses;
                                    $required_license_count =  $required_node_count * $agent->self_node_license_count;

                                    if (($available_license_count <= 0) || ($required_license_count > $available_license_count)) {
                                        echo "<p style='color: red; margin-bottom: 0'>User do not have enough license for placing nodes to FIBO. User had only " . $available_license_count . ', while ' . $required_license_count . ' were required. </p><br>';
                                        $allowed_node_count = floor($available_license_count/$agent->self_node_license_count);
                                    } else {
                                        $allowed_node_count = $required_node_count;
                                    }

                                    $firstDepositCheck = CbmDepositWithdraw::model()->findByAttributes(['email'=>$account->email_address,'is_accounted_for'=>1]);
                                    /*
                                     * get new cluster Id
                                     * */
                                    $clusterId = MatrixHelper::getNewClusterId($account->login);

                                    /*
                                     * Create CBM accounts without checking for licenses.
                                     * Licenses will be checked at the time of FIBO placements.
                                     * */
                                    $equalAmount = $totalDeposit / $required_node_count;
                                    $created_at = date('Y-m-d H:i:s');

                                    /*
                                     * For the first deposit, nodes needs to be placed in cluster format.
                                     * From second deposit onwards, nodes needs to be placed in L to R format with first node of the user as parent
                                     * */
                                    if(!isset($firstDepositCheck->ticket)){
                                        //For the first deposit
                                        $accountNumArray = [];
                                        for ($i = 0; $i < $required_node_count; $i++) {
                                            $new_account_num = CBMAccountHelper::createCBMUserAccount($account->login, $equalAmount, $equalAmount, 'Self Funded', $account->email_address, $account->email_address, $account->agent, $mmc_matrix->id, $clusterId, $created_at);
                                            if(count($accountNumArray) < $allowed_node_count)
                                                array_push($accountNumArray, $new_account_num);
                                            $selfFundedCount++;
                                            $account->prev_balance += $equalAmount;
                                            $account->prev_equity += $equalAmount;
                                            $account->save(false);
                                        }

                                        if (!empty($accountNumArray)) {
                                            $parentAccountNum = MatrixHelper::getMatrixSponsor($accountNumArray[0], $mmc_matrix->id);
                                            $resp = MatrixHelper::addClusterToMatrix($accountNumArray, $parentAccountNum, $account->email_address, $mmc_matrix->id);
                                            //updated code for licenses in CbmUserLicenses table
                                            if($resp != false){
                                                $nodePlaced = count($accountNumArray);
                                                $used_license_count = $nodePlaced * $agent->self_node_license_count;
                                                $used_license_count = 0 - $used_license_count;
                                                ServiceHelper::modifyCBMUserLicenses('', $account->email_address,  0, $used_license_count);

                                            }
                                        }
                                    } else {
                                        //For remaining deposits
                                        $available_licenses = $cbm_user_licenses->available_licenses;
                                        for ($i = 0; $i < $required_node_count; $i++) {
                                            //Create Account
                                            $new_account_num = CBMAccountHelper::createCBMUserAccount($account->login, $equalAmount, $equalAmount, 'Self Funded', $account->email_address, $account->email_address, $account->agent, $mmc_matrix->id, $clusterId, date('Y-m-d H:i:s'));
                                            $selfFundedCount++;
                                            $account->prev_balance += $equalAmount;
                                            $account->prev_equity += $equalAmount;
                                            $account->save(false);

                                            if($available_licenses >= $agent->self_node_license_count){
                                                $parentAccountNum = MatrixHelper::getMatrixSponsor($new_account_num, $mmc_matrix->id);
                                                $response = MatrixHelper::addToMatrix($new_account_num, $parentAccountNum);
                                                if ($response != false) {
                                                    //updated code for licenses in CbmUserLicenses table
                                                    $used_license_count = 0 - $agent->self_node_license_count;
                                                    ServiceHelper::modifyCBMUserLicenses('', $account->email_address,0, $used_license_count);
                                                    $nodePlaced++;
                                                    $available_licenses -= $agent->self_node_license_count;
                                                }
                                            }
                                        }
                                    }

                                    $depositWithdrawSummary .= "User-Email: ".$account->email_address.", ".$selfFundedCount." new Self funded accounts were created and ".$nodePlaced." were placed from login: " .$account->login. ".\n";
                                    $user = UserInfo::model()->findByAttributes(['email' => $account->email_address]);
                                    if (isset($user->user_id)) {
                                        //Only for production
                                        if(isset(Yii::app()->params['env']) && (Yii::app()->params['env'] != 'local')){
                                            //for the notification add the database.
                                            $body = $required_node_count . ' New CBM Self Funded User accounts were created for ' . $account->email_address . ' from login '.$account->login;
                                            $url = Yii::app()->createUrl('admin/cbmuseraccount/index');
                                            $nid = NotificationHelper::AddNotitication('Add CBM Self funded user accounts', $body, 'Self-funded user accounts', $user->user_id, 0, $url);

                                            //for the notification add to the admin side using pusher.
                                            $message = $required_node_count . ' New CBM Self Funded User accounts from login ' . $account->login .  'were created with balance ';
                                            $date = date('Y-m-d H:i:s');
                                            //$url is the define for redirect order details link page.
                                            NotificationHelper::pusherNotificationVpamm($message, $date, $url, $account->login, $account->email_address, $equalAmount, $nid);
                                        }
                                    }

                                    //Modify each ticket used in totalDeposit
                                    foreach ($deposits as $deposit) {
                                        if ($deposit->profit > 0) {
                                            $deposit->is_accounted_for = 1;
                                            $deposit->modified_at = date('Y-m-d H:i:s');
                                            $deposit->save(false);
                                        }
                                    }
                                }

                                //Withdrawal actions
                                if ($totalWithdrawal < 0) {
                                    echo $account->email_address . " has made a withdrawal of " . abs($totalWithdrawal) . " euros. <br>";
                                    foreach ($deposits as $deposit) {
                                        if ($deposit->profit < 0) {
                                            //$depositWithdrawSummary .= $this->invokeWithdrawalActions($deposit->ticket);
                                            //$depositWithdrawSummary .= $account->email_address . " has made a withdrawal of " . abs($totalWithdrawal) . " euros from login: " .$account->login. ".\n";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if($depositWithdrawSummary == ''){
                $depositWithdrawSummary = "No New Deposit/Withdrawals were invoked \n";
            }
            return $depositWithdrawSummary;
        } catch (Exception $e) {
            $err = $e->getMessage()." Trace-Log: ".$e->getTraceAsString();
            $notification_channel = Yii::app()->params['SlackNotificationChannel'];
            SlackHelper::sendData($notification_channel, $err);
            return $err;
        }
    }

    public function actionProfitFunded()
    {
        try {
            $agents = AgentInfo::model()->findAll();
            $agentDetails = AgentDetails::model()->findAll();
            $masterLogin = [];
            foreach ($agentDetails as $agentDatum){
                array_push($masterLogin, $agentDatum->master_login);
            }
            $mmc_matrix = MatrixMetaTable::model()->findByAttributes(['table_name'=>Yii::app()->params['MMC_Matrix']]);
            $profitAccountSummary = '';
            foreach ($agents as $agent) {
                $CbmAccounts = CbmAccounts::model()->findAllByAttributes(['agent' => $agent->agent_number]);
                foreach ($CbmAccounts as $account) {
                    $profitFundedCount = 0;
                    $nodePlaced = 0;
                    //Account is not master and has an email address
                    if (isset($account->email_address) && !in_array($account->login, $masterLogin)) {
                        //To check if there is an unprocessed withdrawal request present, system can't go ahead with balance for profit funded accounts
                        if(!$this->isWithdrawalRequestPresent($account->email_address)){
                            echo "<p style='color: green; margin-bottom: 0'>Profit Calculation is going on for " . $account->email_address . "</p>";
                            //Check Account Equity/node amount is equal to number of accounts

                            //Minimum required balance as per self funded used licenses and profit funded used licenses
                            $selfFundedCbmUserAccounts = CbmUserAccounts::model()->findAllByAttributes(['login' => $account->login, 'type' => 'Self Funded']);
                            $selfFundedUsedLicenses = count($selfFundedCbmUserAccounts);
                            $profitFundedCbmUserAccounts = CbmUserAccounts::model()->findAllByAttributes(['login' => $account->login, 'type' => 'Profit Funded']);
                            $profitFundedUsedLicenses = count($profitFundedCbmUserAccounts);
                            $minimumBalance = ($selfFundedUsedLicenses * $agent->minimum_self_node_balance)+($profitFundedUsedLicenses * $agent->minimum_profit_node_balance);

                            $cbm_user_licenses = CbmUserLicenses::model()->findByAttributes(['email' => $account->email_address]);

                            /*
                            * get new cluster Id
                            * */
                            $clusterId = MatrixHelper::getNewClusterId($account->login);

                            if ($account->equity >= ($minimumBalance + $agent->minimum_profit_node_balance)) {
                                //Create new accounts for the profit generated
                                $newAccounts = floor(($account->equity - $minimumBalance) / $agent->minimum_profit_node_balance);

                                $available_licenses = $cbm_user_licenses->available_licenses;
                                for ($i = 0; $i < $newAccounts; $i++) {
                                    //$profitAccount = CbmAccounts::model()->findByAttributes(['email_address' => $account->email_address, 'agent' => $account->agent]);
                                    //Create Account
                                    $new_account_num = CBMAccountHelper::createCBMUserAccount($account->login, $agent->minimum_profit_node_balance, $agent->minimum_profit_node_balance, 'Profit Funded', $account->email_address, $account->email_address, $account->agent, $mmc_matrix->id, $clusterId, date('Y-m-d H:i:s'));
                                    $profitFundedCount++;
                                    if($available_licenses >= $agent->profit_node_license_count){
                                        $parentAccountNum = MatrixHelper::getMatrixSponsor($new_account_num, $mmc_matrix->id);
                                        $response = MatrixHelper::addToMatrix($new_account_num, $parentAccountNum);

                                        if ($response != false) {
                                            $used_license_count = 0 - $agent->profit_node_license_count;
                                            //updated code for licenses in CbmUserLicenses table
                                            ServiceHelper::modifyCBMUserLicenses('', $account->email_address,0, $used_license_count);
                                            $nodePlaced++;
                                            $available_licenses -= $agent->profit_node_license_count;
                                        }
                                    }
                                }
                                $user = UserInfo::model()->findByAttributes(['email' => $account->email_address]);
                                if (isset($user->user_id)) {
                                    //Only for production
                                    if(isset(Yii::app()->params['env']) && (Yii::app()->params['env'] != 'local')){
                                        //for the notification add the database.
                                        $body = $newAccounts . ' New CBM Profit Funded User accounts were created for ' . $account->email_address . ' from login '.$account->login;;
                                        $url = Yii::app()->createUrl('admin/cbmuseraccount/index');
                                        $nid = NotificationHelper::AddNotitication('Add CBM Profit funded user accounts', $body, 'Profit-funded user accounts', $user->user_id, 0, $url);

                                        //for the notification add to the admin side using pusher.
                                        $message = $newAccounts . ' New CBM Profit Funded User accounts from login ' . $account->login .  ' were created with balance ';
                                        $date = date('Y-m-d H:i:s');
                                        //$url is the define for redirect order details link page.
                                        NotificationHelper::pusherNotificationVpamm($message, $date, $url, $account->login, $account->email_address, $agent->minimum_deposit, $nid);
                                    }
                                }
                                $profitAccountSummary .= "User-Email: ".$account->email_address.", new ".$profitFundedCount." profit funded accounts were created and ".$nodePlaced." were placed from login: " .$account->login. ".\n";
                            }
                            $this->distributeAmount($account->login);
                        }
                    }
                }
            }
            if($profitAccountSummary == ''){
                $profitAccountSummary = "No new profit funded accounts were created. \n";
            }
            return $profitAccountSummary;
        } catch (Exception $e) {
            $err = $e->getMessage()." Trace-Log: ".$e->getTraceAsString();
            $notification_channel = Yii::app()->params['SlackNotificationChannel'];
            SlackHelper::sendData($notification_channel, $err);
            return $err;
        }
    }

    //Add legit user accounts to the matrix that were not placed due to some unknown reasons
    public function actionAddLegitAccounts()
    {
        $response = "\n";
        $response .= "`Extra Validation`"." \n";
        $licensed_users = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cbm_user_licenses')
            ->where('available_licenses>=:al', [':al' => 1])
            ->queryAll();
        $mmc_matrix = MatrixMetaTable::model()->findByAttributes(['table_name'=>Yii::app()->params['MMC_Matrix']]);

        foreach ($licensed_users as $licensed_user) {
            $cbmAccounts = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cbm_accounts')
                ->where('email_address=:ea', [':ea' => $licensed_user['email']])
                ->andWhere('balance!=:b', [':b' => 0])
                ->queryAll();
            foreach ($cbmAccounts as $cbmAccount){
                if (isset($cbmAccount['login'])) {
                    $cbmUserAccounts = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('cbm_user_accounts')
                        ->where('login=:lg', [':lg' => $cbmAccount['login']])
                        ->andWhere('matrix_node_num is null')
                        ->order('created_at ASC')
                        ->queryAll();
                    $agent = AgentInfo::model()->findByAttributes(['agent_number'=>$cbmAccount['agent']]);
                    $count = count($cbmUserAccounts);
                    //Licensed user model
                    $licensed_user_model = CbmUserLicenses::model()->findByPk($licensed_user['id']);
                    if ($count > 0) {
                        $available_licenses = $licensed_user_model->available_licenses;
                        print "Checking for " . $cbmAccount['email_address'] . " with login " .$cbmAccount['login']. " is having count " . $count . " and we have " . $available_licenses . " licenses available";
                        $i = 0;
                        while (($available_licenses > 0) && ($i < count($cbmUserAccounts)) ) {
                            print "<br>Going for user Account: " . $cbmUserAccounts[$i]['user_account_num'] . "<br>";
                            if($cbmUserAccounts[$i]['type'] == 'Self Funded'){
                                if($available_licenses >= $agent->self_node_license_count){
                                    $parentAccountNum = MatrixHelper::getMatrixSponsor($cbmUserAccounts[$i]['user_account_num'], $mmc_matrix->id);
                                    $resp = MatrixHelper::addToMatrix($cbmUserAccounts[$i]['user_account_num'], $parentAccountNum);
                                    $available_licenses -= $agent->self_node_license_count;

                                    if ($resp != false) {
                                        $used_license_count = 0 - $agent->self_node_license_count;
                                        //updated code for licenses in CbmUserLicenses table
                                        ServiceHelper::modifyCBMUserLicenses('', $cbmAccount['email_address'],0, $used_license_count);
                                    }
                                }
                            } else {
                                if($cbmUserAccounts[$i]['type'] == 'Profit Funded'){
                                    if($available_licenses >= $agent->profit_node_license_count){
                                        $parentAccountNum = MatrixHelper::getMatrixSponsor($cbmUserAccounts[$i]['user_account_num'], $mmc_matrix->id);
                                        $resp = MatrixHelper::addToMatrix($cbmUserAccounts[$i]['user_account_num'], $parentAccountNum);
                                        $available_licenses -= $agent->profit_node_license_count;

                                        if ($resp != false) {
                                            $used_license_count = 0 - $agent->profit_node_license_count;
                                            //updated code for licenses in CbmUserLicenses table
                                            ServiceHelper::modifyCBMUserLicenses('', $cbmAccount['email_address'],0, $used_license_count);
                                        }
                                    }
                                }
                            }
                            $i++;
                        }
                        print ("Only " . $i . " count were completed <br>");
                        $response .= "For user " . $licensed_user_model->email . " with login " .$cbmAccount['login'].", " . $i . " nodes were placed.\n";
                    }
                }
            }
        }
        $unplacedAccounts = Yii::app()->db->createCommand()
            ->select('count(*) as cnt')
            ->from('cbm_user_accounts')
            ->where('matrix_node_num is null')
            ->queryRow();
        if($unplacedAccounts['cnt'] > 0){
            $response .= "\nTotal unplaced CBM User Accounts: ".$unplacedAccounts['cnt']."\n";
            $unplacedEmails = Yii::app()->db->createCommand()
                ->select('distinct(email_address) as email_address')
                ->from('cbm_user_accounts')
                ->where('matrix_node_num is null')
                ->queryAll();
            $response .= "Users who require licenses: \n";
            foreach ($unplacedEmails as $unplacedEmail){
                $response .= $unplacedEmail['email_address'].", ";
            }
        }
        $response .= "\n";
        return $response;
    }

    //Distribute Profit and Equity equally to all the accounts
    protected function distributeAmount($login)
    {
        $cbmAccount = CbmAccounts::model()->findByAttributes(['login' => $login]);
        $agent = AgentInfo::model()->findByAttributes(['agent_number'=>$cbmAccount->agent]);
        $selfFundedUserAccounts = CbmUserAccounts::model()->findAllByAttributes(['login' => $login, 'type' => 'Self Funded']);
        $profitFundedUserAccounts = CbmUserAccounts::model()->findAllByAttributes(['login' => $login, 'type' => 'Profit Funded']);
        $totalAccounts = count($selfFundedUserAccounts) + count($profitFundedUserAccounts);
        $ratioBase = (count($selfFundedUserAccounts)*$agent->self_node_license_count) + (count($profitFundedUserAccounts)*$agent->profit_node_license_count);
        //To handle division by zero error
        if ($ratioBase > 0) {
            $selfFundedEqualBalance = $cbmAccount->balance * $agent->self_node_license_count / $ratioBase;
            $selfFundedEqualEquity = $cbmAccount->equity * $agent->self_node_license_count / $ratioBase;
            foreach ($selfFundedUserAccounts as $userAccount) {
                $userAccount->balance = $selfFundedEqualBalance;
                if ($userAccount->max_balance < $selfFundedEqualBalance)
                    $userAccount->max_balance = $selfFundedEqualBalance;
                $userAccount->equity = $selfFundedEqualEquity;
                if ($userAccount->max_equity < $selfFundedEqualEquity)
                    $userAccount->max_equity = $selfFundedEqualEquity;
                $userAccount->modified_at = date('Y-m-d H:i:s');
                $userAccount->save(false);
            }

            //For Profit funded
            $profitFundedEqualBalance = $cbmAccount->balance * $agent->profit_node_license_count / $ratioBase;
            $profitFundedEqualEquity = $cbmAccount->equity * $agent->profit_node_license_count / $ratioBase;
            foreach ($profitFundedUserAccounts as $userAccount) {
                $userAccount->balance = $profitFundedEqualBalance;
                if ($userAccount->max_balance < $profitFundedEqualBalance)
                    $userAccount->max_balance = $profitFundedEqualBalance;
                $userAccount->equity = $profitFundedEqualEquity;
                if ($userAccount->max_equity < $profitFundedEqualEquity)
                    $userAccount->max_equity = $profitFundedEqualEquity;
                $userAccount->modified_at = date('Y-m-d H:i:s');
                $userAccount->save(false);
            }
        }
    }

    //Distribute profit generated in Balance
    public function distributeProfitBalance($login, $profit)
    {
        $userAccounts = CbmUserAccounts::model()->findAllByAttributes(['login' => $login]);
        $totalAccounts = count($userAccounts);
        $total = Yii::app()->db->createCommand()
            ->select('sum(balance) as total')
            ->from('cbm_user_accounts')
            ->where('login=:login', [':login' => $login])
            ->queryRow();
        $profitDistributed = 0;
        if ($totalAccounts > 0) {
            for ($i = 0; $i < $totalAccounts; $i++) {
                if ($i == ($totalAccounts - 1) && ($totalAccounts != 1)) {
                    $balance = $userAccounts[$i]->balance + $profit - $profitDistributed;
                    echo "Account Number: " . $userAccounts[$i]->user_account_num . ": Old Balance: " . $userAccounts[$i]->balance . " and New Balance: " . $balance . "<br>";
                    $userAccounts[$i]->balance = $balance;
                } else {
                    $distribution = round(($userAccounts[$i]->balance / $total['total']) * $profit, 2);
                    $balance = $userAccounts[$i]->balance + $distribution;
                    echo "Account Number: " . $userAccounts[$i]->user_account_num . ": Old Balance: " . $userAccounts[$i]->balance . " and New Balance: " . $balance . "<br>";
                    $userAccounts[$i]->balance = $balance;
                    $profitDistributed += $distribution;
                }
                if ($userAccounts[$i]->max_balance < $balance)
                    $userAccounts[$i]->max_balance = $balance;
                $userAccounts[$i]->modified_at = date('Y-m-d H:i:s');
                $userAccounts[$i]->save(false);
            }
        } else {
            echo "No User account found";
        }
    }

    //Distribute equity generated in Balance
    public function distributeProfitEquity($login, $profit)
    {
        $userAccounts = CbmUserAccounts::model()->findAllByAttributes(['login' => $login]);
        $totalAccounts = count($userAccounts);
        $total = Yii::app()->db->createCommand()
            ->select('sum(equity) as total')
            ->from('cbm_user_accounts')
            ->where('login=:login', [':login' => $login])
            ->queryRow();
        $profitDistributed = 0;
        if ($totalAccounts > 0) {
            for ($i = 0; $i < $totalAccounts; $i++) {
                if ($i == ($totalAccounts - 1) && ($totalAccounts != 1)) {
                    $balance = $userAccounts[$i]->equity + $profit - $profitDistributed;
                    echo "Account Number: " . $userAccounts[$i]->user_account_num . ": Old Equity: " . $userAccounts[$i]->equity . " and New Equity: " . $balance . "<br>";
                    $userAccounts[$i]->equity = $balance;
                } else {
                    $distribution = round(($userAccounts[$i]->equity / $total['total']) * $profit, 2);
                    $balance = $userAccounts[$i]->equity + $distribution;
                    echo "Account Number: " . $userAccounts[$i]->user_account_num . ": Old Equity: " . $userAccounts[$i]->equity . " and New Equity: " . $balance . "<br>";
                    $userAccounts[$i]->equity = $balance;
                    $profitDistributed += $distribution;
                }
                if ($userAccounts[$i]->max_equity < $balance)
                    $userAccounts[$i]->max_equity = $balance;
                $userAccounts[$i]->modified_at = date('Y-m-d H:i:s');
                $userAccounts[$i]->save(false);
            }
        } else {
            echo "No User account found";
        }
    }

    //Keep only one daily-balance-record except for today
    public function deleteBalanceRecords()
    {
        $accounts = CbmAccounts::model()->findAll();
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        foreach ($accounts as $account) {
            try {
                if (isset($account->email_address) && $account->login != 685) {
                    $deleteQuery = "delete from user_daily_balance where email_address = '" . $account->email_address . "'
                             and date(created_at) = '" . $yesterday . "' and id not in (select id from (select max(id) from user_daily_balance
                            where date(created_at) = '" . $yesterday . "' and email_address = '" . $account->email_address . "') as tmptable)";
                    Yii::app()->db->createCommand($deleteQuery)->execute();
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                $logs = new CbmLogs();
                $logs->status = 0;
                $logs->created_date = date('Y-m-d H:i:s');
                $logs->log = 'Delete Logs: ' . $e->getMessage();
                $logs->save(false); // saving logs
            }
        }
    }

    //Calculates equity w.r.t. master's account balance-equity ratio
    public function getEquity($agentNumber, $balance, $equity, $group)
    {
        $agent_detail = AgentDetails::model()->findByAttributes(['agent_number'=>$agentNumber, 'group'=>$group]);
        if($agentNumber == Yii::app()->params['UTITAgentNumber']){
            return $equity;
        } else {
            if (isset($agent_detail->master_login)) {
                $masterAccount = CbmAccounts::model()->findByPk($agent_detail->master_login);
                $equity = $balance * $masterAccount->equity / $masterAccount->balance;
                return $equity;
            } else {
                return 0;
            }
        }
    }

    //Trigger an Invalid Difference Mail
    public function triggerInvalidDifferenceMail($email, $login, $previousDeposit, $previousBalance, $newDeposit, $newBalance)
    {
        $summary = '';
        try {
            //Trigger an invalid value mail
            $mail = new YiiMailer('invalid-deposit', [
                'email' => $email,
                'login' => $login,
                'previousDep' => $previousDeposit,
                'previousBal' => $previousBalance,
                'newDep' => $newDeposit,
                'newBal' => $newBalance
            ]);
            $mail->setFrom('info@cbmglobal.io', 'CBM Global');
            $mail->setSubject("Invalid Difference between Balance and Deposit");
            $mail->setTo(['priyeshdoshi61@gmail.com', 'sagar22.shah@gmail.com']);
            $mail->send();
        } catch (Exception $e) {
            $summary .= $e->getMessage();
        }
    }

    //Withdrawal actions
    public function invokeWithdrawalActions($ticket)
    {
        $withdrawalSummary = '';
        $trade = CbmDepositWithdraw::model()->findByAttributes(['ticket' => $ticket]);
        $systemId = Yii::app()->params['SystemUserId'];
        $system = UserInfo::model()->findByPk($systemId);

        $cbmAccount = CbmAccounts::model()->findByAttributes(['login' => $trade->login]);
        $agent = AgentInfo::model()->findByAttributes(['agent_number' => $cbmAccount->agent]);

        if (abs($trade->profit) > $agent->minimum_deposit) {
            $amt = abs($trade->profit);
            print("Withdrawal is invoked by " . $trade->email." for ".$amt." euros");

            //Number of accounts to be revoked
            $accounts = floor($amt / $agent->minimum_deposit);
            print("Accounts to be revoked: ".$accounts."<br>");
            $availableAccountsQuery = Yii::app()->db->createCommand()
                ->select('count(*) as cnt')
                ->from('cbm_user_accounts')
                ->where('email_address=:ea', [':ea' => $trade->email])
                ->andWhere('login=:lg', [':lg'=>$trade->login])
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

            print("Available Accounts: ".$availableAccounts."<br>");
            while($accountsRevoked < $accounts){
                //Delete accounts that are not placed at all
                $unPlacedAccounts = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('cbm_user_accounts')
                    ->where('email_address=:ea', [':ea' => $trade->email])
                    ->andWhere('login=:lg', [':lg'=>$trade->login])
                    ->andWhere('matrix_node_num is null')
                    ->queryAll();
                $unplaced_count = count($unPlacedAccounts);
                if ($unplaced_count > 0) {
                    if ($accounts >= $unplaced_count) {
                        //Delete all unplaced accounts
                        $delete_res = Yii::app()->db->createCommand()
                            ->delete('cbm_user_accounts', 'email_address=:ea and login=:lg and isnull(matrix_node_num)', [':ea' => $trade->email, ':lg' => $trade->login]);
                        $accountsRevoked += $unplaced_count;
                        print("<br>All Unplaced accounts were deleted<br>");
                    } else {
                        $accountsNum = $accounts;
                        //for the array index
                        $delete_id = $unplaced_count - 1;
                        while ($accountsNum > 0) {
                            //Delete single unplaced account
                            $delete_res = Yii::app()->db->createCommand()
                                ->delete('cbm_user_accounts', 'email_address=:ea and login=:lg and user_account_id=:uaId and isnull(matrix_node_num)',
                                    [':ea' => $trade->email, ':lg' => $trade->login, ':uaId' => $unPlacedAccounts[$delete_id]['user_account_id']]);
                            $accountsNum--;
                            $delete_id--;
                            $accountsRevoked++;
                        }
                        print("<br> A total of ".$accountsRevoked." accounts were deleted one after the other manner. <br>");
                    }
                } else {
                    $accountsToBeRevoked = $accounts - $accountsRevoked;
                    //Accounts that needs to be revoked
                    $cbmUserAccounts = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('cbm_user_accounts')
                        ->where('email_address=:ea', [':ea' => $trade->email])
                        ->andWhere('matrix_node_num is not null')
                        ->andWhere('login=:lg', [':lg'=>$trade->login])
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
                        ServiceHelper::modifyCBMUserLicenses('', $cbmAccount->email_address,0, 1);
                    }
                    print("<br> A total of ".$accountsRevoked." accounts were revoked one after the other manner. <br>");
                }
            }

            //Update all CBM user accounts balance and equity
            $cbmUserAccounts = CbmUserAccounts::model()->findAllByAttributes(['login' => $trade->login]);
            $usedAccounts = count($cbmUserAccounts);
            if ($usedAccounts > 0) {
                $newBalance = $cbmAccount->balance / $usedAccounts;
                $newEquity = $cbmAccount->equity / $usedAccounts;
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
                ), 'login=:lg', array(':lg' => $trade->login));

            $trade->is_accounted_for = 1;
            $trade->modified_at = date('Y-m-d H:i:s');
            $trade->save(false);
            $withdrawalSummary .= "User-Email: ".$cbmAccount->email_address." (".$trade->login."), ".$accountsRevoked." accounts were deleted and ".$accountsToBeRevoked." were revoked from the user. \n";
        }
        return $withdrawalSummary;
    }

    //Add/Update User Daily Balance
    public function addUpdateDailyBalance($email, $login, $balance, $agent, $equity, $deposit)
    {
        $modelCheck = Yii::app()->db->createCommand()
            ->select('*')
            ->from('user_daily_balance')
            ->where('email_address=:ea', [':ea' => $email])
            ->andWhere('login=:lg', [':lg' => $login])
            ->andWhere('date(created_at)=:dca', [':dca' => date('Y-m-d')])
            ->queryRow();
        if (!isset($modelCheck['id'])) {
            $model = new UserDailyBalance();
            $model->email_address = $email;
            $model->login = $login;
            $model->created_at = date('Y-m-d h:i:s');
        } else {
            $model = UserDailyBalance::model()->findByPk($modelCheck['id']);
            $model->modified_at = date('Y-m-d h:i:s');
        }
        $model->balance = $balance;
        $model->agent = $agent;
        $model->equity = $equity;
        $model->deposit = $deposit;
        $model->save(false);
    }

    //Derive a new cluster id for a new deposit
    public function getNewClusterId($login){
        $cbm_user_account = Yii::app()->db->createCommand()
            ->select('max(cluster_id) as c_id')
            ->from('cbm_user_accounts')
            ->where('login=:lg',[':lg'=>$login])
            ->queryRow();

        if(is_null($cbm_user_account['c_id'])){
            $clusterId = 1;
        } else {
            $clusterId = $cbm_user_account['c_id'] + 1;
        }
        return $clusterId;
    }

    public function actionPerformTestCases(){
        $notification_channel = Yii::app()->params['SlackNotificationChannel'];
        $testCases = TestCaseHelper::performTestCases();

        $status = 1;
        foreach ($testCases as $case){
            if($case['status'] == 0){
                $status = 0;
                break;
            }
        }

        if($status == 1){
            $message = "------------------:man_in_lotus_position:" . "  :man_in_lotus_position:  " . "Time to Relax" . "  :man_in_lotus_position:  " . ":man_in_lotus_position:------------------" . "\n\n";
            $message .= ">All `Test cases` have passed " . "  :white_check_mark:" . "  :white_check_mark:". "\n\n";
            $message .= "------------------:man_in_lotus_position:" . "  :man_in_lotus_position:  " . "Time to Relax" . "  :man_in_lotus_position:  " . ":man_in_lotus_position:------------------" . "\n\n";
        } else {
            $message = "------------------:warning: :warning: Error Detected in System :warning: :warning:------------------"."\n\n";
            foreach ($testCases as $case){
                if($case['status'] == 0)
                    $message .= "`".$case['name']."`\n> :x: ".$case['description']." has *_Failed_* :x: \n\n\n";
                else
                    $message .= "`".$case['name']."`\n> :v: ".$case['description']." has *_Passed_* :v: \n\n\n";
            }
        }
        SlackHelper::sendData($notification_channel, $message );
    }

    /*
     * Command to distribute Commission
     * */
    public function actionDistributeCommission(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $argv = $_SERVER['argv'];

        if(isset($argv)){
            parse_str($argv[3], $output);
            $tempArr = explode(', ', $output['start_date']);
            $start_month = date('m', strtotime($tempArr[0].'-'.$tempArr[1]));
            $start_year = $tempArr[1];
        } else {
            $start_month = date('m');
            $start_year = date('Y');
        }

        $summaryMessage = CommissionHelper::distributeCommission($start_month, $start_year);
        print $summaryMessage;
    }

    public function actionNormalizeCommission(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $argv = $_SERVER['argv'];

        if(isset($argv)){
            parse_str($argv[3], $output);
            $tempArr = explode(', ', $output['start_date']);
            $start_month = date('m', strtotime($tempArr[0].'-'.$tempArr[1]));
            $start_year = $tempArr[1];
        } else {
            $start_month = date('m');
            $start_year = date('Y');
        }

        $summaryMessage = CommissionHelper::normalizeCommission($start_month, $start_year);
        print  $summaryMessage;
    }
}
