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
            $this->redirect($url);
        }
    }

    public function actionPerformTestCases(){
        Yii::import('application.commands.*');
        //Random parameter values for CronCommand
        $command = new CronCommand("cron", "updatemt4");
        $command->performTestCases();
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
    public function actionLogout()
    {
        Yii::app()->user->logout();
        unset($_SESSION['user']);
        $this->redirect(Yii::app()->homeUrl . "admin/home/login/");
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
}
