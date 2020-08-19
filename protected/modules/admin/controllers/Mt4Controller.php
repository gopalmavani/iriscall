<?php

class Mt4Controller extends CController
{
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
    public function actionAccounts(){

        $TableID = CylTables::model()->findByAttributes(['table_name' => CbmAccounts::model()->tableSchema->name]);
        $model = new CbmAccounts('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CbmAccounts']))
            $model->attributes = $_GET['CbmAccounts'];
        $alldata = CbmAccounts::model()->findAll();

        $this->render('accounts', array(
            'TableID' => $TableID,
            'model' => $model,
            'alldata' => $alldata,
        ));
    }
    public function actionSettings(){

        $this->render('settings');
    }

    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata(){
        $requestData = $_REQUEST;
        $model = new CbmAccounts();
        $primary_key = $model->tableSchema->primaryKey;

        $array_cols = Yii::app()->db->schema->getTable(CbmAccounts::model()->tableSchema->name)->columns;
        $array = array();
        $array[0] = 'action';
        $i = 1;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }



        $columns = $array;
        /*echo "<pre>";
        print_r($columns);die;*/

        $sql = "SELECT  * from ".CbmAccounts::model()->tableSchema->name." where 1=1";
        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( $primary_key LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != $primary_key)
                {
                    $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql.=")";
        }

        $j = 0;

        // getting records as per search parameters
        foreach($columns as $key=>$column){

            if( !empty($requestData['columns'][$key]['search']['value']) ){   //name
                if($column == 'registration_date' && $requestData['min'] != '' && $requestData['max'] != ''){
                    $sql .= " AND cast(registration_date as date) between '$requestData[min]' and '$requestData[max]'";
                }
                else{
                    $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }
            }
            $j++;
        }


        // // getting records as per search parameters
        // foreach($columns as $key=>$column){

        //     if( !empty($requestData['columns'][$key]['search']['value']) ){   //name
        //         $sql.=" AND `$column` LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
        //     }
        //     $j++;
        // }

        $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;

        if($columns[$requestData['order'][0]['column']] != 'action'){
        $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] ;
            }

        $sql.= "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";

        // echo $sql;die;
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i=1;

        foreach ($result as $key => $row)
        {
            $nestedData = array();
            $newdata[] = $row[$primary_key];
            $nestedData[] = $row[$primary_key];
            // $row['modified_at'] = $row[$primary_key];
            foreach($array_cols as  $key=>$col){
                $nestedData[] = $row["$col->name"];
            }

            $data[] = $nestedData;
            $i++;
        }


        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data ,  // total data array
        );

        echo json_encode($json_data);
    }

    // for the customer base graph display

    public function actionStatalysegraph()
    {
      $model = UserInfo::model()->findAll();
      $this->render('statalysegraph', array(
        "model" => $model
      ));
    }

    public function actionUsergraphdetails()
    {
        $userId = $_POST['user_id'];
        $table = $_POST['table'];
        $user = UserInfo::model()->findByPk($userId);
        $connection = Yii::app()->db;
        $command = $connection->createCommand('show tables like "' . $table . '"');
        $tablecheck = $command->queryRow();
        if (!empty($tablecheck) && !empty($user)) {
            $account_login = CbmAccounts::model()->findAllByAttributes(['email_address'=>$user->email]);
            if(count($account_login) > 1){
              $account = CbmAccounts::model()->findByAttributes(['email_address'=>$user->email,'group'=>Yii::app()->params['Group']]);
            }else{
              $account = CbmAccounts::model()->findByAttributes(['email_address'=>$user->email]);
            }
            // print_r($account);die;
            if (isset($account->login)) {

              $records = Yii::app()->db->createCommand()
                  ->select('*')
                  ->from($table)
                  // ->where('email_address=:email', [':email' => $user->email])
                  ->where('login=:login',[':login'=>$account->login])
                  ->order('created_at ASC')
                  ->queryAll();
                  $deposit = CbmDepositWithdraw::model()->findByAttributes(['login' => $account->login], ['order' => 'created_at']);
              }else{
                $records = [];
                $deposit = "";
              }


            $balance = array();
            $growth = array();
            $result = array();
            if (isset($deposit->profit)) {
                $balanceData = array();
                $equityData = array();
                $growthBalanceData = array();
                $growthEquityData = array();
                //$growthStartData = array();
                foreach ($records as $record) {
                    $dateTime = strtotime($record['created_at']);
                    $dateTime *= 1000;

                    $growthBalanceValue = $record['balance'] - $record['deposit'];
                    $growthBalanceData[] = [$dateTime, round($growthBalanceValue,2)];
                    $balanceData[] = [$dateTime, round($record['balance'],2)];

                    $growthEquityValue = $record['equity'] - $record['deposit'];
                    $growthEquityData[] = [$dateTime, round($growthEquityValue,2)];
                    $equityData[] = [$dateTime, round($record['equity'],2)];
                }
                $balance['balance'] = $balanceData;
                $balance['equity'] = $equityData;

                $growth['balance'] = $growthBalanceData;
                $growth['equity'] = $growthEquityData;

                $result['balance'] = $balance;
                $result['growth'] = $growth;
            }

            // $account = CbmAccounts::model()->findByAttributes(['email_address' => $user->email]);
            if(isset($account->login)){
              $account = CbmAccounts::model()->findByAttributes(['login' => $account->login]);
            }else{
              $account = "";
            }
            if (isset($account->email_address)) {
                $isPresent = 1;
            } else {
                $isPresent = 0;
            }
            if(isset($account->login)){
              $CbmUserAccounts = Yii::app()->db->createCommand()
              ->select('*')
              ->from($table)
              // ->where('email_address=:email', [':email' => $user->email])
              ->where('login=:login',[':login'=>$account->login])
              ->queryAll();
              $login = $account->login;
            }else{
              $CbmUserAccounts = "";
              $login = "";
            }

            $data = "
        <br><h3>User Balance Details<span class='pull-right' style='margin-right:20px;'> - ".$login."<span></h3><br>
        <table class='table table-bordered table-striped userdetails'><thead>
          <th>Balance</th>
          <th>Equity</th>
          <th>Date</th>
        </thead><tbody>";
          if(!empty($CbmUserAccounts)){
            foreach ($CbmUserAccounts as $key => $CbmUserAccount) {
              $data .= "<tr>
              <td>" . round($CbmUserAccount['balance'], 2) . "</td>
              <td>" . round($CbmUserAccount['equity'], 2) . "</td>
              <td>" . $CbmUserAccount['created_at'] . "</td>
              </tr>";
            }
          }
            $data .= "</tbody></table>";
            if ($isPresent == 1) {
                $response = [
                    'isPresent' => $isPresent,
                    'result' => $result,
                    'data' => $data
                ];
                echo json_encode($response);
            } else {
                $response = [
                    'isPresent' => $isPresent,
                    'result' => $result,
                    'data' => $data
                ];
                echo json_encode($response);
            }
        } else {
            $isPresent = 0;
            $result = array();
            $data = "";
            $response = [
                'isPresent' => $isPresent,
                'result' => $result,
                'data' => $data
            ];
            echo json_encode($response);
        }

    }

    /*
     * This will do following process:
     * 1. Fetch MT4 Data.
     * 2. Add Deposit rows.
     * 3. Add/Update Api-Accounts.
     * 4. Add Daily Balance.
     * */
    public function actionUpdatemt4()
    {
        if(isset($_POST['start_date'])){
            $start = $_POST['start_date'];
            $end = $_POST['end_date'];
        }
        else{

            $sql = "SELECT date FROM `cbm_logs` ORDER BY `id` DESC LIMIT 1";
            $startdate = Yii::app()->db->createCommand($sql)->queryAll();
            if($startdate == null){
                $start = Date("Y-m-d");
            }
            else{
                $start = $startdate[0]['date'];
            }
            $end = Date("Y-m-d");
        }

        Yii::import('application.commands.*');
        //Random parameter values for CronCommand
        $command = new CronCommand("cron", "updatemt4");
        $command->actionUpdatemt4($start, $end);
    }

    //Add legit user accounts to the matrix that were not placed due to some unknown reasons
    public function actionAddLegitAccounts(){
        Yii::import('application.commands.*');
        //Random parameter values for CronCommand
        $command = new CronCommand("cron", "updatemt4");
        $command->actionAddLegitAccounts();
    }

    //Creates order depending upon the deposit
    protected function createOrder($ticket){
        $checkOrder = OrderInfo::model()->findByAttributes(['order_id'=>$ticket]);
        if(!isset($checkOrder->order_id)){
            $deposit = CbmDepositWithdraw::model()->findByAttributes(['ticket'=>$ticket]);
            $user = UserInfo::model()->findByAttributes(['email'=>$deposit->email]);
            $account = CbmAccounts::model()->findByAttributes(['email_address'=>$deposit->email]);
            if(!isset($user->email)){
                //Add User to User Info
                $user = new UserInfo();
                $user->full_name = $account->name;
                $user->email = $account->email_address;
                $user->password = 'b24331b1a138cde62aa1f679164fc62f';
                $user->street = $account->address;
                $user->city = $account->city;
                $user->postcode = $account->postcode;
                $user->date_of_birth = '2018-03-20';
                $user->save(false);
            }
            //50 euro is required for a node to be in Fibo and cost of each node in Fibo is 5 euro.
            $fiboNodes = floor($deposit->profit/Yii::app()->params['MinimumNodeAmount']);
            $orderTotal = $fiboNodes * Yii::app()->params['NodeCost'];

            //Create Order
            $order = new OrderInfo();
            $order->order_id = $ticket;
            $order->vat = 0;
            $order->order_status = 1;
            $order->attributes = $user->attributes;
            $order->orderTotal = $orderTotal;
            $order->discount = $orderTotal;
            $order->netTotal = 0;
            $order->invoice_date = $deposit->close_time;
            $order->user_name = $user->full_name;

            if($order->save()){
                $product = ProductInfo::model()->findByPk(1);
                $orderLineItem = new OrderLineItem();
                $orderLineItem->product_id = $product->product_id;
                $orderLineItem->product_name = $product->name;
                $orderLineItem->order_info_id = $order->order_info_id;
                $orderLineItem->item_price = $product->price;
                $orderLineItem->item_qty = $fiboNodes;
                $orderLineItem->item_disc = 0;
                $orderLineItem->created_at = $order->invoice_date;
                $orderLineItem->product_sku = $product->sku;
                $orderLineItem->save(false);

                $orderLicense = new CbmOrderLicenses();
                $orderLicense->user_id = $user->user_id;
                $orderLicense->order_info_id = $order->order_info_id;
                $orderLicense->product_id = $product->product_id;
                $orderLicense->product_name = $product->name;
                $orderLicense->licenses = $fiboNodes;
                $orderLicense->save(false);

                $orderPayment = new OrderPayment();
                $orderPayment->order_info_id = $order->order_info_id;
                $orderPayment->total = $order->netTotal;
                $orderPayment->payment_mode = 'System';
                $orderPayment->payment_ref_id = $order->order_id;
                $orderPayment->payment_status = 1;
                $orderPayment->payment_date = $order->invoice_date;
                $orderPayment->transaction_mode = 'Refund';
                $orderPayment->save();

                //Increase license count
                $account->total_licenses += $fiboNodes;
                $account->available_licenses += $fiboNodes;
                $account->modified_at = date('Y-m-d H:i:s');
                $account->save(false);
                $notification_status = NotificationSettings::model()->findByAttributes(['event' => 'Order Create']);
                if ($notification_status->enabled == 1) {
                    $users = ($user->user_id) ? ' of user <a href="' . Yii::app()->createUrl('admin/userInfo/view') .'/'. $user->user_id . '"> ' . $user->full_name. '</a>' : '';
                    $amount = ($order->netTotal) ? ' &euro;' . $order->netTotal : '';
                    $body = 'Order placed for ' . $amount . $users . ' received.';
                    $url = Yii::app()->createUrl('admin/orderInfo/view') . "/" . $order->order_info_id;
                    $title = '<a href="'.$url.'">'. $user->full_name . ' placed an order of ' . $order->netTotal . '</a>';
                    NotificationHelper::AddNotitication($title, $body, 'information', $user->user_id, 0, $url);
                }
            } else {
                print('<pre>');
                print($user->email."<br>");
                print_r($user->attributes);
                print_r($order->getErrors());
                exit;
            }
        }
    }

    //Displays Deposit page as an index
    public function actionDepositWithdraw()
    {
        $TableID = CylTables::model()->findByAttributes(['table_name' => CbmDepositWithdraw::model()->tableSchema->name]);
        $model = new CbmDepositWithdraw('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CbmDepositWithdraw']))
            $model->attributes = $_GET['CbmDepositWithdraw'];
        $alldata = CbmDepositWithdraw::model()->findAll();

        $this->render('depositWithdraw', array(
            'TableID' => $TableID,
            'model' => $model,
            'alldata' => $alldata,
        ));
    }

    //Create User accounts
    public function actionCreateUserAcc()
    {
        //header("Access-Control-Allow-Origin: *");
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        /*if ($startDate == '0' && $endDate == '0') {
            $endDate = date('Y-m-d', strtotime("-1 days"));
        }*/
        Yii::import('application.commands.*');
        //Random parameter values for CronCommand
        $command = new CronCommand("cron", "createUserAcc");
        $command->actionCreateUserAcc();
    }

    /*
     * 10 euro matrix vpamm
     * This action will do following process
     * 1. Create node on deposits
     * */
    public function actionTenEuroVPAMM(){
        //What needs to be done here
        /*
         * Deposits received will be converted to nodes here.
         * Profit nodes for UPCycling are not to be created.
         * For Profit corporate, profit nodes can be created.
         * Commission will be distributed monthly and money will added to the wallet.
         * Notice: Here the money is just virtually added. Actually, it is present in the master CBM Commission account.
         * If the commission in UPCycling increases by 5 euro, a transfer request from CBMCommission to CBMUPCycling will be made
         * and a node with user as beneficiary will be created. If the user buys the license for more 5 euro, only commission
         * from the UPCycle node will be doubled. Owner of the node will be CBM only...mostly..
         * */
    }

    /**
     * Manages data for server side data tables for deposit-withdraw.
     */
    public function actiondatatable(){
        $requestData = $_REQUEST;
        $model = new CbmDepositWithdraw;
        $primary_key = $model->tableSchema->primaryKey;
         // print_r($primary_key);die;
        $array_cols = Yii::app()->db->schema->getTable(CbmDepositWithdraw::model()->tableSchema->name)->columns;
        $array = array();
        $i = 0;
        foreach($array_cols as $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }

        $columns = $array;

        $sql = "SELECT * from ".CbmDepositWithdraw::model()->tableSchema->name." where 1=1";
        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( $primary_key LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as $key=>$col){
                if($col->name != $primary_key)
                {
                    $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql.=")";
        }
        $j = 0;
        // // getting records as per search parameters
        // foreach($columns as $key=>$column){

        //     if( !empty($requestData['columns'][$key]['search']['value']) ){ //name
        //         $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
        //     }
        //     $j++;
        // }

        foreach($columns as $key=>$column){
            if(($requestData['columns'][$key]['search']['value']) != "" ){   //name
                if($column == 'close_time' && $requestData['min'] != '' && $requestData['max'] != ''){
                    $sql .= " AND cast(close_time as date) between '$requestData[min]' and '$requestData[max]'";
                }else{
                    $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }
            }
            $j++;
        }


        $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;
        // echo "<pre>";print_r($columns[$requestData['order'][0]['column']]);die;

        $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . " ";

        // echo $sql;die;
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i=1;

        foreach ($result as $key => $row)
        {
            $nestedData = array();
            switch($row['is_accounted_for']){
                case 0 :
                    $row['is_accounted_for'] = "<span class='label label-table label-warning'>Unprocessed</span>";
                    break;
                case 1:
                     $row['is_accounted_for'] = "<span class='label label-table label-success'>Processed</span>";
                    break;
                default:
                    break;
            }
            foreach($array_cols as $key=>$col){
                $nestedData[] = $row["$col->name"];
            }

            $data[] = $nestedData;
            $i++;
        }


        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data // total data array
        );

        echo json_encode($json_data);
    }

    //Deposit Withdraw View
    public function actionDepositWithdrawView($id)
    {
        $model=CbmDepositWithdraw::model()->findByPk($id);
        $this->render('depositWithdrawView',array(
            'model'=>$model,
        ));
    }

    //Accounts view
    public function actionView($id)
    {
        $model=CbmAccounts::model()->findByPk($id);
        $this->render('view',array(
            'model'=>$model,
        ));
    }

    //Temporary action
    public function actionCreateOrderFromDeposits(){
        $deposits = CbmDepositWithdraw::model()->findAllByAttributes(['is_accounted_for'=>0]);
        foreach ($deposits as $deposit){
            $this->createOrder($deposit->ticket);
        }
    }

    public function actionCreateUserFromAccount(){
        $accounts = Yii::app()->db->createCommand('select * from cbm_accounts where email_address not in (select email from user_info) and email_address is not NULL')
            ->queryAll();
        foreach ($accounts as $account){
            $userInfo = new UserInfo();
            $userInfo->full_name = $account['name'];
            $name = explode(' ', $account['name']);
            $userInfo->first_name = $name[0];
            if(isset($name[1]))
                $userInfo->last_name = $name[1];
            $userInfo->email = $account['email_address'];
            $userInfo->password = 'b24331b1a138cde62aa1f679164fc62f';
            $userInfo->date_of_birth = '2018-03-20';
            $userInfo->sponsor_id = 1;
            $userInfo->street = $account['address'];
            $userInfo->city = $account['city'];
            $userInfo->postcode = $account['postcode'];
            $userInfo->save(false);
        }
    }

    public function actionCreateOneTimeAccounts(){
        $deposits = CbmDepositWithdraw::model()->findAllByAttributes(['type'=>'Deposit']);
        foreach ($deposits as $deposit){
            $account = CbmAccounts::model()->findByAttributes(['email_address'=>$deposit->email]);
            $newLicenses = $deposit->profit/50;
            for ($i=0;$i<$newLicenses;$i++){
                $count = CbmUserAccounts::model()->findAllByAttributes(['login'=>$account->login]);
                $accountNum = 'C' . $account->login . (count($count)+1);
                $userAccount = new CbmUserAccounts();
                $userAccount->user_account_num = $accountNum;
                $userAccount->login = $account->login;
                $userAccount->type = 'Self Funded';
                $userAccount->email_address = $deposit->email;
                $userAccount->beneficiary = $deposit->email;
                $userAccount->agent_num = $account->agent;
                $userAccount->max_balance = 50;
                $userAccount->max_equity = 50;
                $userAccount->balance = 50;
                $userAccount->equity = 50;
                $userAccount->save(false);
            }
            $account->available_licenses -= $newLicenses;
            $account->save(false);
        }
    }
}
