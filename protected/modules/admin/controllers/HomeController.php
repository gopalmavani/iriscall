<?php

class HomeController extends CController
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * @return array action filters
     */

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }


    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */

    public function accessRules()
    {
        return UserIdentity::accessRules();
    }

    /**
     * Allow only the owner to do the action
     * @return boolean whether or not the user is the owner
     */

    public function allowOnlyOwner()
    {
        if (Yii::app()->user->isAdmin) {
            return true;
        } else {
            $example = Example::model()->findByPk($_GET["id"]);
            return $example->uid === Yii::app()->user->id;
        }
    }

    /*
     * To allow admin to go back to their front end
     * */
    public function actionOldLogin()
    {
        if (isset(Yii::app()->session['adminLoginId'])) {
            Yii::app()->session['userid'] = Yii::app()->session['adminLoginId'];
            $id = Yii::app()->session['userid'];
            unset(Yii::app()->session['adminLoginId']);
            $url = Yii::app()->createUrl('user/autologin') . '?id=' . $id;
            /*print $url;
            exit;*/
            $this->redirect($url);

            /*$user = UserInfo::model()->findByPk($id);
            $model = new AutoLoginForm();
            $model->email = $user->email;
            Yii::app()->session['userid'] = $user->password;
            if($model->validate()){
                if($model->login()){
                    print("No Issue");exit;
                } else {
                    print ("error in Login");exit;
                }
            } else {
                print("Error in validation");exit;
            }
            exit;*/
            /*if ($model->validate() && $model->login()) {
                print('<pre>');print_r(Yii::app()->user->getId());exit;
                //$this->redirect(Yii::app()->createUrl('home/index'));
            } else {
                $this->redirect(array('login'));
            }*/
        }
    }

    public function actionNewDeposit(){
        Yii::import('application.commands.*');
        //Random parameter values for CronCommand
        $command = new CronCommand("cron", "updatemt4");
        $command->actionNewdeposit();
    }

    public function actionAddLegitAccounts(){
        Yii::import('application.commands.*');
        //Random parameter values for CronCommand
        $command = new CronCommand("cron", "updatemt4");
        $command->actionAddLegitAccounts();
    }

    public function actionCreateUserAcc(){
        Yii::import('application.commands.*');
        //Random parameter values for CronCommand
        $command = new CronCommand("cron", "updatemt4");
        $command->actionCreateUserAcc();
    }

    public function actionUpdatemt4(){
        Yii::import('application.commands.*');
        //Random parameter values for CronCommand
        $command = new CronCommand("cron", "updatemt4");
        $command->actionUpdatemt4('2020-06-30', '2020-06-30');
    }

    public function actionPerformTestCases(){
        Yii::import('application.commands.*');
        //Random parameter values for CronCommand
        $command = new CronCommand("cron", "updatemt4");
        $command->performTestCases();
        print "Done";
    }

    public function actionAddAPITrades(){
        Yii::import('application.commands.*');
        //Random parameter values for CronCommand
        $command = new CronCommand("cron", "updatemt4");
        $command->actionApiTrades('2019-10-01 00:00:00', '2019-10-01 23:59:59');
        print "Done";
    }

    public function actionCalculateGeneratedCommission(){
        Yii::import('application.commands.*');
        //Random parameter values for CronCommand
        $command = new CronCommand("cron", "updatemt4");
        $command->actionCalculateGeneratedCommission();
        print "Done";
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        if (!isset(Yii::app()->session['adminLoginId'])) {
            Yii::app()->session['adminLoginId'] = Yii::app()->user->getId();
        }
        $year = date('Y');
        $month = date('m');
        $t = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $days = "";
        $daywiseevents = array();
        $result = array();
        $mybookings = array();

        if (Yii::app()->db->schema->getTable('events')) {
            for ($i = 1; $i <= $t; $i++) {
                if ($i == 1) {
                    $days .= $i;
                } else {
                    $days .= "," . $i;
                }

                $sql = "SELECT count(*) as eventcount from events where date(event_start) = " . "'$year-$month-$i'";
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                $daywiseevents[$i] = $result[0]['eventcount'];
            }

            $newsql = "SELECT * FROM booking order by booking_id desc LIMIT 10";
            $result = Yii::app()->db->createCommand($newsql)->queryAll();

            $myresult = Yii::app()->db->createCommand("SELECT * from booking")->queryAll();
            $today = date('Y-m-d');
            $later = date('Y-m-d', strtotime("+10 days"));


            foreach ($myresult as $key => $item) {
                $bookingsql = "SELECT * FROM events where event_id = " . $item['event_id'] . " AND date(event_start) between " . "'$today'" . " and " . "'$later'";
                $bookingresult = Yii::app()->db->createCommand($bookingsql)->queryAll();
                if (!empty($bookingresult)) {
                    array_push($bookingresult[0], $item['username']);
                    array_push($mybookings, $bookingresult[0]);
                }
            }
        }
        $users = UserInfo::model()->findAll();

        $orderTotal = Yii::app()->db->createCommand()
            ->select('sum(orderTotal) as total')
            ->from('order_info')
            ->where('order_status=:st', [':st' => '1'])
            ->queryRow();

        $this->render('index', [
            'users' => count($users),
            'days' => $days,
            'daywiseevents' => $daywiseevents,
            'bookings' => $result,
            'upcomingbookings' => $mybookings
        ]);

    }

    /*
     * To create new fibo placements w.r.t old ones
     * */
    public function actionCreateNewFibo(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $currentId = 2;
        while($currentId <= 18585){
            $currentNode = Yii::app()->db->createCommand()
                ->select('*')
                ->from('new_fifty_euro_matrix')
                ->where('id>=:id',[':id'=>$currentId])
                ->andWhere('user_id!=:uId',[':uId'=>1])
                ->queryRow();

            $currentUserAccount  = Yii::app()->db->createCommand()
                ->select('max(cluster_id) as cluster_id')
                ->from('cbm_user_accounts')
                ->where('email_address=:uan',[':uan'=>$currentNode['email']])
                ->queryRow();

            $isPresentBefore = FiftyEuroMatrix::model()->findByAttributes(['email'=>$currentNode['email']]);

            $nextPatchId = Yii::app()->db->createCommand()
                ->select('*')
                ->from('new_fifty_euro_matrix')
                ->where('id>=:id',[':id'=>$currentNode['id']])
                ->andWhere('email!=:email',[':email'=>$currentNode['email']])
                ->order('id asc')
                ->queryRow();

            //For last patch
            if(!isset($nextPatchId['id'])){
                $lastPatch =  Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('new_fifty_euro_matrix')
                    ->where('id>=:id',[':id'=>$currentNode['id']])
                    ->andWhere('email=:email',[':email'=>$currentNode['email']])
                    ->order('id desc')
                    ->queryRow();
                $lastPatchId = $lastPatch['id'];
            } else {
                $lastPatchId = $nextPatchId['id']-1;
            }

            $currentPatchNodes = Yii::app()->db->createCommand()
                ->select('*')
                ->from('new_fifty_euro_matrix')
                ->where('id>=:sId',[':sId'=>$currentNode['id']])
                ->andWhere('id<=:lId',[':lId'=>$lastPatchId])
                ->andWhere('email=:email',[':email'=>$currentNode['email']])
                ->andWhere('user_id!=:uId',[':uId'=>1])
                ->order('id asc')
                ->queryAll();

            if(isset($isPresentBefore->id)){
                foreach ($currentPatchNodes as $patchNode){
                    $presentClusterId = $currentUserAccount['cluster_id'];
                    $newClusterID = $presentClusterId + 1;
                    $parentAccountNum = MatrixHelper::getMatrixSponsor($patchNode['cbm_account_num'], 1);
                    echo $parentAccountNum."<br>";
                    $response = MatrixHelper::addToMatrix($patchNode['cbm_account_num'], $parentAccountNum);
                    $currentId = $patchNode['id']+1;

                    if($response!=false){
                        $cbmUserAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$patchNode['cbm_account_num']]);
                        $matrixNode = FiftyEuroMatrix::model()->findByAttributes(['cbm_account_num'=>$patchNode['cbm_account_num']]);
                        $cbmUserAccount->matrix_node_num = $matrixNode->id;
                        $cbmUserAccount->cluster_id = $newClusterID;
                        $cbmUserAccount->save(false);
                        echo $patchNode['email']." was added to matrix through L to R format. <br>";
                    } else {
                        echo "Error in adding ".$patchNode['email']." with account num ".$patchNode['cbm_account_num']." <br>"."Error is: ".$response."<br>";
                    }
                }
            } else {
                $accountNumArray = [];
                foreach ($currentPatchNodes as $patchNode){
                    array_push($accountNumArray, $patchNode['cbm_account_num']);
                    $currentId = $patchNode['id']+1;
                }

                $presentClusterId = $currentUserAccount['cluster_id'];
                $newClusterID = $presentClusterId + 1;
                $parentAccountNum = MatrixHelper::getMatrixSponsor($accountNumArray[0], 1);
                $response = MatrixHelper::addClusterToMatrix($accountNumArray, $parentAccountNum, $currentNode['email'], 1);
                if($response!=false){
                    foreach ($accountNumArray as $item){
                        $cbmUserAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$item]);
                        $matrixNode = FiftyEuroMatrix::model()->findByAttributes(['cbm_account_num'=>$item]);
                        $cbmUserAccount->matrix_node_num = $matrixNode->id;
                        $cbmUserAccount->cluster_id = $newClusterID;
                        $cbmUserAccount->save(false);
                        echo $currentNode['email']." was added to matrix through cluster format. <br>";
                    }
                } else {
                    echo "Error in adding ".$currentNode['email']." with a cluster from account num ".$accountNumArray[0]." <br>"."Error is: ".$response."<br>";
                }
            }
        }
        exit;
    }

    public function actionAddRemainingToNewFibo(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $currentId = 2;
        while($currentId <= 7277){
            $currentNode = Yii::app()->db->createCommand()
                ->select('*')
                ->from('new_fifty_euro_matrix')
                ->where('id>=:id',[':id'=>$currentId])
                ->andWhere('user_id!=:uId',[':uId'=>1])
                ->andWhere('temp=:t',[':t'=>0])
                ->queryRow();

            $currentUserAccount  = Yii::app()->db->createCommand()
                ->select('max(cluster_id) as cluster_id')
                ->from('cbm_user_accounts')
                ->where('email_address=:uan',[':uan'=>$currentNode['email']])
                ->queryRow();

            $isPresentBefore = FiftyEuroMatrix::model()->findByAttributes(['email'=>$currentNode['email']]);

            $nextPatchId = Yii::app()->db->createCommand()
                ->select('*')
                ->from('new_fifty_euro_matrix')
                ->where('id>=:id',[':id'=>$currentNode['id']])
                ->andWhere('email!=:email',[':email'=>$currentNode['email']])
                ->andWhere('temp=:t',[':t'=>0])
                ->order('id asc')
                ->queryRow();

            //For last patch
            if(!isset($nextPatchId['id'])){
                $lastPatch =  Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('new_fifty_euro_matrix')
                    ->where('id>=:id',[':id'=>$currentNode['id']])
                    ->andWhere('email=:email',[':email'=>$currentNode['email']])
                    ->order('id desc')
                    ->queryRow();
                $lastPatchId = $lastPatch['id'];
            } else {
                $lastPatchId = $nextPatchId['id']-1;
            }

            $currentPatchNodes = Yii::app()->db->createCommand()
                ->select('*')
                ->from('new_fifty_euro_matrix')
                ->where('id>=:sId',[':sId'=>$currentNode['id']])
                ->andWhere('id<=:lId',[':lId'=>$lastPatchId])
                ->andWhere('email=:email',[':email'=>$currentNode['email']])
                ->andWhere('user_id!=:uId',[':uId'=>1])
                ->andWhere('temp=:t',[':t'=>0])
                ->order('id asc')
                ->queryAll();

            if(isset($isPresentBefore->id)){
                foreach ($currentPatchNodes as $patchNode){
                    $presentClusterId = $currentUserAccount['cluster_id'];
                    $newClusterID = $presentClusterId + 1;
                    $parentAccountNum = MatrixHelper::getMatrixSponsor($patchNode['cbm_account_num'], 1);
                    //print $parentAccountNum;
                    $response = MatrixHelper::addToMatrix($patchNode['cbm_account_num'], $parentAccountNum);
                    $currentId = $patchNode['id']+1;

                    if($response!=false){
                        $cbmUserAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$patchNode['cbm_account_num']]);
                        $matrixNode = FiftyEuroMatrix::model()->findByAttributes(['cbm_account_num'=>$patchNode['cbm_account_num']]);
                        $cbmUserAccount->matrix_node_num = $matrixNode->id;
                        $cbmUserAccount->cluster_id = $newClusterID;
                        $cbmUserAccount->save(false);
                        echo $patchNode['email']." was added to matrix. <br>";
                    } else {
                        echo "Error in adding ".$patchNode['email']." with account num ".$patchNode['cbm_account_num']." <br>"."Error is: ".$response."<br>";
                    }
                }
            } else {
                $accountNumArray = [];
                foreach ($currentPatchNodes as $patchNode){
                    array_push($accountNumArray, $patchNode['cbm_account_num']);
                    $currentId = $patchNode['id']+1;
                }

                $presentClusterId = $currentUserAccount['cluster_id'];
                $newClusterID = $presentClusterId + 1;
                $parentAccountNum = MatrixHelper::getMatrixSponsor($accountNumArray[0], 1);
                $response = MatrixHelper::addClusterToMatrix($accountNumArray, $parentAccountNum, $currentNode['email'], 1);
                if($response!=false){
                    foreach ($accountNumArray as $item){
                        $cbmUserAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$item]);
                        $matrixNode = FiftyEuroMatrix::model()->findByAttributes(['cbm_account_num'=>$item]);
                        $cbmUserAccount->matrix_node_num = $matrixNode->id;
                        $cbmUserAccount->cluster_id = $newClusterID;
                        $cbmUserAccount->save(false);
                        echo $currentNode['email']." was added to matrix. <br>";
                    }
                } else {
                    echo "Error in adding ".$currentNode['email']." with a cluster from account num ".$accountNumArray[0]." <br>"."Error is: ".$response."<br>";
                }
            }
        }
        exit;
    }

    /*
     * Wallet Chart of display.
     */
    public function actionChartWallet(){

        $transaction_type = WalletTypeEntity::model()->findAll();
        $series = array();
        foreach ($transaction_type as $transaction){
            $query = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount, transaction_comment')
                ->from('wallet')
                ->where('wallet_type_id=:typ', [':typ' => $transaction->wallet_type_id])
                ->andwhere('reference_id =:ref', [':ref' => 4])
                ->andWhere('year(created_at)=:y', [':y'=>date('Y')])
                ->group('transaction_comment')
                ->queryAll();

            $values = [
                "name" => $transaction->wallet_type,
            ];
            $monthArray = array();
            foreach ($query as $value){
                $comment_date = explode('for',$value['transaction_comment']);
                $comment_month = date('n',strtotime($comment_date[1]));
                $monthArray[$comment_month] = (float)$value['amount'];
            }
            $values['data'] = $monthArray;
            array_push($series,$values);
        }

    //for the push value in empty month values .
        $finalArray = array();
        foreach ($series as $record){
            $levelOneArray = array();
            $levelOneArray['name'] = $record['name'];
            $data = $record['data'];
            $leveltwo = array();
            for ($i=1;$i<=12;$i++){
                if(!array_key_exists($i,$data)){
                    $leveltwo[$i-1] = 0;
                } else {
                    $leveltwo[$i-1] = $data[$i];
                }
            }
            $levelOneArray['data'] = $leveltwo;

            array_push($finalArray, $levelOneArray);
        }

        $status = true;

        $result = [
          "series" => $finalArray,
          "status" => $status
        ];
        echo json_encode($result);
    }

    /*
     * for the dashboard Cbm User Account refresh ajax response.
     */
    public function actionCbmUserAccounts()
    {
        $response = '';
        $cbmuseraccounts = Yii::app()->db->createCommand()
            ->select('login,email_address,count(login) as no_of_node')
            ->from('cbm_user_accounts')
            ->where('matrix_node_num IS NULL')
            ->group('login,email_address')
            ->order('modified_at DESC')
            ->limit(50)
            ->queryAll();

        $CbmUserAccounts = Yii::app()->db->createCommand()
            ->select('login,email_address,count(login) as no_of_node')
            ->from('cbm_user_accounts')
            ->where('matrix_node_num IS NULL')
            ->group('login,email_address')
            ->order('modified_at DESC')
            ->queryAll();
        $no_unplace_account = count($CbmUserAccounts);

        $response .= "
        	<table class=\"table table-borderless table-striped table-vcenter\">
                <tbody>";
        foreach ($cbmuseraccounts as $key => $value) {
            $response .= "
    			<tr>
	    			<td>" . $value['login'] . "</td>
	    			<td class='text-success'>" . $value['email_address'] . "</td>
	    			<td class='text-muted text-right' >" . $value['no_of_node'] . "</td>
    			</tr>";
        }
        $response .= "</tbody></table>";
        $result = [
           'no_unplace_account' => $no_unplace_account,
           'response_detail' => $response
        ];
        echo json_encode($response);
    }

    /*
     * for the dashboard Cbm User Account refresh ajax response.
     */
    public function actionLatestDeposit()
    {
        $response = '';
        // $latestDeposits = CbmDepositWithdraw::model()->findAllByAttributes(['order' => 'type desc', 'limit' => 10]);
        $latestDeposits = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cbm_deposit_withdraw')
            ->order('close_time DESC')
            ->limit('10')
            ->queryAll();

        $response .= "
        	<table class=\"table table-borderless table-striped table-vcenter\">
                <tbody>";
        foreach ($latestDeposits as $key => $value) {
            $temp = array();
            $user = UserInfo::model()->findByAttributes(['email' => $value['email']]);
            if (isset($user->full_name))
                $temp['name'] = $user->full_name;
            else
                $temp['name'] = '';
            $temp['amount'] = $value['profit'];
            $temp['date'] = NotificationHelper::time_elapsed_string($value['close_time']);

            if($value['type'] == 'Withdraw'){
              $pro = "<td class='text-danger text-center' style='width: 120px;'>- &euro; " .  abs($temp['amount']) . "</td>";
            }else{
              $pro = "<td class='text-success text-center' style='width: 120px;'>&euro; " .  $temp['amount'] . "</td>";
            }

            $response .= "
    			<tr>
	    			<td>" . $temp['name'] . "</td>
            ".$pro."
	    			<td class='text-muted text-right' style='width: 150px;'>" . $temp['date'] . "</td>
    			</tr>";
        }
        $response .= "</tbody></table>";
        echo json_encode($response);
    }

    /*
     * for the dashboard Order Filter Date Wise ajax response.
     */
    public function actionOrderFilter()
    {
        $startdate = $_POST['startdate'].' 00:00:00';
        $enddate = $_POST['enddate'].' 23:59:59';
        // $query = "SELECT order_info_id,user_name,email,order_status,netTotal,orderTotal,invoice_number, created_date FROM order_info WHERE created_date BETWEEN '$startdate' AND '$enddate' order by created_date DESC limit 50 ";
        $orders = Yii::app()->db->createCommand()
            ->select('order_info_id,user_name,email,order_status,netTotal,orderTotal,invoice_number,created_date')
            ->from('order_info')
            ->where('created_date between "'.$startdate.'" AND "'.$enddate.'"')
            ->order('created_date DESC')
            ->limit(50)
            ->queryAll();

        $no_of_order = Yii::app()->db->createCommand()
            ->select('count(*) as Total')
            ->from('order_info')
            ->where('created_date between "'.$startdate.'" AND "'.$enddate.'"')
            ->queryRow();

        // $orders = Yii::app()->db->createCommand($query)->queryAll();
        // $countOrder = "SELECT count(*) as Total FROM order_info WHERE created_date BETWEEN '$startdate' AND '$enddate'";

        $response = '';
        if (!empty($orders)) {
            $no_of_license = Yii::app()->db->createCommand()
                ->select('sum(item_qty) as total')
                ->from('order_line_item ol')
                ->join('order_info oi', 'ol.order_info_id = oi.order_info_id')
                ->where('order_status=:os', [':os'=>1])
                ->andWhere('invoice_date>=:sd', [':sd'=>$startdate])
                ->andWhere('invoice_date<=:ed', [':ed'=>$enddate])
                ->queryRow();

            $total_license = $no_of_license['total'];
            // $total_license = ($no_of_license['total'] / 5);
            // $pendingOrder = "SELECT count(*) as Pending FROM order_info WHERE created_date BETWEEN '$startdate' AND '$enddate' and order_status = 2";
            // $pending_order = Yii::app()->db->createCommand($pendingOrder)->queryRow();

            $pending_order = Yii::app()->db->createCommand()
                ->select('count(*) as Pending')
                ->from('order_info')
                ->where('created_date between "'.$startdate.'" AND "'.$enddate.'"')
                ->andWhere('order_status = 2')
                ->queryRow();
            $no_of_orders = $no_of_order['Total'];
            $pending_orders = $pending_order['Pending'];
            $response .= "
        	<table class='table table-borderless table-striped table-vcenter' >
                 <thead>
                    <th style='width: 205px;'>UserName</th>
                    <th>Licenses</th>
                    <th>Total</th>
                    <th>Invoice Number</th>
                    <th>Status</th>
                    <th>Date</th>
                    </thead>
                 <tbody class='order'>";
            foreach ($orders as $key => $value) {
                $usedLicens = Yii::app()->db->createCommand()
                    ->select('SUM(item_qty) as license')
                    ->from('order_line_item')
                    ->where('order_info_id = "'.$value['order_info_id'].'"')
                    ->queryRow();

                if (empty($value['invoice_number'])) {
                    $invoice = "N/A";
                } else {
                    $invoice = $value['invoice_number'];
                }
                if ($value['order_status'] == 0) {
                    $status = '<span align="center" class="label label-table label-danger">Cancelled</span>';
                } else if ($value['order_status'] == 1) {
                    $status = '<span align="center" class="label label-table label-success">Success</span>';
                } else {
                    $status = '<span align="center" class="label label-table label-warning">Pending</span>';
                }
                $response .= "
    			<tr>
	    			<td style='width: 220px;'>" . $value['user_name'] . "<br><p style='margin-bottom:0px !important;' class='text-muted'>" . $value['email'] . "</td>
	    			<td class=''>" . $usedLicens['license'] . "</td>
	    			<td class=''>&euro;" . $value['netTotal'] . "</td>
	    			<td class=''>" . $invoice . "</td>
	    			<td class=''>" . $status . "</td>
	    			<td class=''>" . $value['created_date'] . "</td>
    			</tr>";
            }
            $response .= "</tbody></table><div class='row'>
               <a style='margin-right: 15px;' class='pull-right m-b-10 text-smooth' href='" . Yii::app()->createUrl('admin/orderInfo/admin') . "'>See more</a></div>";
            $status = true;
        } else {
            $status = false;
            $no_of_orders =0;
            $total_license = 0;
            $pending_orders = 0;
            $response .= "<table class='table color-table muted-table'><tbody>
        		<tr>
	    			<td style='border-top:0px;'></td>
	    			<td style='border-top:0px;'><h4 align='center'>No Orders Found</h4></td>
	    			<td style='border-top:0px;'></td>
    			</tr></tbody></table>";
        }
        $result = [
          'status' => $status,
          'reponse_detail' => $response,
          'no_of_orders'  => $no_of_orders,
          'total_license' => $total_license,
          'pending_orders' => $pending_orders
        ];

        echo json_encode($result);

    }


    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {

        $this->layout = 'login';
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $auth = Yii::app()->db->schema->getTable('address_mapping');
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $data = SysUsers::model()->findByAttributes(array('username' => $model->username));
                $_SESSION['user'] = $data->username;
                $this->redirect(['/admin/']);
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }


    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionEdit()
    {
        $this->pageTitle = 'Edit Profile';

        $data = SysUsers::model()->findByAttributes(array('username' => $_SESSION['user']));
        $this->render('edit', array('data' => $data));
    }

    public function actionUpdateEmail()
    {
        if (isset($_POST['email'])) {
            //echo "UPDATE sys_users SET email='".$_POST['email']."' WHERE username ='".$_SESSION['user']."';"; die;
            //Yii::$app->db->createCommand("UPDATE sys_users SET email='".$_POST['email']."' WHERE username ='".$_SESSION['user']."';")->execute();
            //if (Yii::app()->db->createCommand("UPDATE sys_users SET email='".$_POST['email']."' WHERE username ='".$_SESSION['user']."';")->execute()) {
            $user = SysUsers::model()->findByAttributes(['username' => $_SESSION['user']]);
            $user->email = $_POST['email'];
            $user->activekey = 1;
            $user->auth_level = 1;
            if ($user->save()) {
                echo json_encode([
                    'msg' => 'Success',
                ]);
            } else {
                print_r($user->Errors);
                echo json_encode([
                    'msg' => 'Fail',
                ]);
            }
        }
    }

    public function actionChangePass()
    {
        if (isset($_POST['current_pass']) && isset($_POST['New_Pass'])) {
            //print_r($_POST); die;
            $user = SysUsers::model()->findByAttributes(['username' => $_SESSION['user']]);
            if ($_POST['current_pass'] === $user->password) {
                $user->password = $_POST['New_Pass'];
                if ($user->save()) {
                    echo json_encode([
                        'msg' => 'Success',
                    ]);
                } else {
                    echo json_encode([
                        'msg' => 'Fail',
                    ]);
                }
            } else {
                echo json_encode([
                    'token' => 1
                ]);
            }

        }
    }


    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        unset($_SESSION['user']);
        $this->redirect(Yii::app()->homeUrl . "admin/home/login/");
    }


    /**
     * shows popup for unauthorized actions.
     */
    public function actionExpired()
    {
        $this->layout = 'main';
        $denied = "denied";
        $this->render('expired', array('deny' => $denied));
    }

    /*
     * Generate Affiliate Commission
     * */
    public function actionGenerateAffiliateCommission(){
        $walletAffiliates = Yii::app()->db->createCommand()
            ->select('distinct(reference_num)')
            ->from('wallet')
            ->where('reference_id=:rId',[':rId'=>3])
            ->queryColumn();
        $orders = Yii::app()->db->createCommand()
            ->select('*')
            ->from('order_info')
            ->where('order_status=:os',[':os'=>1])
            ->andWhere('netTotal!=:nt',[':nt'=>0])
            ->andWhere(['not in', 'order_id',$walletAffiliates])
            ->queryAll();
        //Wallet type is User
        $wallet_type = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
        foreach ($orders as $order){
            $user = UserInfo::model()->findByPk($order['user_id']);
            $num_licenses = $order['orderTotal']/5;
            if(isset($user->sponsor_id)){
                $level1_parent = UserInfo::model()->findByPk($user->sponsor_id);
                $level1_comment = "Level 1 Affiliate commission from user_id ".$user->user_id." for order_id ".$order['order_id'];
                $level1_credit = $num_licenses * Yii::app()->params['LevelOneAffiliateCommission'];
                //Distribute Level One Commission
                WalletHelper::addToWallet($level1_parent->user_id, $wallet_type->wallet_type_id, 0, 3,
                    $order['order_id'], $level1_comment, 1, 2, 1, $level1_credit,
                    date('Y-m-d H:i:s'));
                print "<br>Level One Commission Distributed for Order Id:".$order['order_id']."<br>";
                if(isset($level1_parent->sponsor_id)){
                    $level2_parent = UserInfo::model()->findByPk($level1_parent->sponsor_id);
                    $level2_comment = "Level 2 Affiliate commission from user_id ".$user->user_id." for order_id ".$order['order_id'];
                    $level2_credit = $num_licenses * Yii::app()->params['LevelTwoAffiliateCommission'];
                    //Distribute Level One Commission
                    WalletHelper::addToWallet($level2_parent->user_id, $wallet_type->wallet_type_id, 0, 3,
                        $order['order_id'], $level2_comment, 1, 2, 1, $level2_credit,
                        date('Y-m-d H:i:s'));
                    print "Level Two Commission Distributed for Order Id:".$order['order_id']."<br>";
                } else {
                    print "<br>Level 2 parent not found for ".$user->email."<br>";
                }
            } else {
                print "<br>No parent found for ".$user->email."<br>";
            }
        }
    }

    //Give affiliate to specific orders
    public function actionGiveAffiliate(){
        if(isset($_GET['orderId'])){
            $orderId = $_GET['orderId'];
            OrderHelper::generateAffiliateCommission($orderId);
        }
        print "Execution Completed";
    }

    //Remove nodes based on cbm user account number
    public function actionRemoveNodes(){
        if(isset($_GET['nodeUserAccountNumbers'])){
            $accountArray = explode(',', $_GET['nodeUserAccountNumbers']);
            if(count($accountArray) > 0 && !empty($_GET['nodeUserAccountNumbers'])){
                foreach ($accountArray as $value){
                    $fifty_euro_node = FiftyEuroMatrix::model()->findByAttributes(['cbm_account_num'=>$value]);
                    if(isset($fifty_euro_node->id)){
                        if(is_null($fifty_euro_node->lchild) && is_null($fifty_euro_node->rchild)){

                            //Update parent nodes
                            Yii::app()->db->createCommand()->
                                update('fifty_euro_matrix',
                                    [
                                        'lchild' => null
                                    ], 'lchild=:lc', [':lc'=>$fifty_euro_node->id]
                                );
                            Yii::app()->db->createCommand()->
                                update('fifty_euro_matrix',
                                    [
                                        'rchild' => null
                                    ], 'rchild=:rc', [':rc'=>$fifty_euro_node->id]
                                );

                            //Delete node from matrix table
                            Yii::app()->db->createCommand()->
                                delete('fifty_euro_matrix',
                                    'id=:id', [':id'=>$fifty_euro_node->id]
                                );

                            //Delete user account node from cbm_user_accounts table
                            Yii::app()->db->createCommand()->
                                delete('cbm_user_accounts',
                                    'user_account_num=:id', [':id'=>$value]
                                );

                            //Increase License
                            Yii::app()->db->createCommand('update cbm_user_licenses set available_licenses = available_licenses + 1 where email = "'.$fifty_euro_node->email.'"')->execute();

                            echo 'Node '.$value.' deleted successfully <br>';

                        } else {
                            echo 'Cannot delete '.$value.' because of presence of child nodes <br>';
                        }
                    } else {
                        echo 'Node Id '.$value.' not present in matrix <br>';
                    }
                }
            } else {
                echo 'No node value added <br>';
            }
        } else {
            echo 'Add Get Parameter <strong>nodeUserAccountNumbers</strong> with comma separated values';
        }
    }

    //Temporary action to create affiliates in refunded state
    public function actionGenerateAffiliateRefunds(){
        $creditMemo = OrderCreditMemo::model()->findAll();
        foreach ($creditMemo as $item){
            $order = OrderInfo::model()->findByAttributes(['invoice_number'=>$item->invoice_number]);
            OrderHelper::generateAffiliateCommission($order->order_id);
            OrderHelper::generateRefundAffiliates($order->order_id);
            print "Affiliate refunded for ".$order->order_id."<br>";
        }
        print "Execution Completed";
    }

    //Temporary action to add all trades to MT4 for commission computation
    public function actionApiTrades(){

        $start = "2019-09-30";
        $end = "2019-10-04";
        //1. Fetch MT4 Data for 8917.
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
                "StartDate" => $start . " 00:00:00",
                "EndDate" => $end . " 23:59:59",
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

        $decode = json_decode($response, true);
        $total_trades = 0;
        foreach ($decode as $k => $res) {
            // trades calculation
            $allTrades = $res['Trades'];
            $user_trades_values = '';
            foreach ($allTrades as $trades) {
                $login = $trades['Login'];
                $ticket = $trades['Ticket'];
                $symbol = $trades['Symbol'];
                $type = $trades['Type'];
                $lots = $trades['Lots'];
                $openPrice = $trades['OpenPrice'];
                $openTime = $trades['OpenTime'];
                $closePrice = $trades['ClosePrice'];
                $closeTime = $trades['CloseTime'];
                $profit = $trades['Profit'];
                $agentCommission = $trades['AgentCommission'];
                $commission = $trades['Commission'];
                $comment = $trades['Comment'];
                $magicNumber = $trades['MagicNumber'];
                $stopLoss = $trades['StopLoss'];
                $swap = $trades['Swap'];
                $reason = $trades['Reason'];

                //if( $type == 'BUY' || $type == 'SELL' || $type = 'BALANCE' ){
                $total_trades++;
                $user_trades_values .= "('$login','$ticket','$symbol','$type','$lots','$openPrice','$openTime','$closePrice','$closeTime','$profit','$commission','$agentCommission','$comment','$magicNumber','$stopLoss','$profit','$swap','$reason'),";
            }

            if($user_trades_values != ''){
                $sql = "INSERT INTO api_trades (login,ticket,symbol,`type`,lots,open_price,open_time,close_price,close_time,profit,commission,agent_commission,comment,magic_number,stop_loss,take_profit,swap,reason) VALUES " . rtrim($user_trades_values, ",");
                $rs = Yii::app()->db->createCommand($sql)->execute();
            }
            echo "Done for 1 account <br>/n";
        }
    }
}
