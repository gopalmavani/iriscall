<?php

class ModulesController extends CController
{

    public function actionIndex()
    {
        $sql = "SELECT * FROM product_info";
        $model=Yii::app()->sitedb->createCommand($sql)->queryAll();
        $cou = count($model);
        $appname =  Yii::app()->params['applicationName'];
        $sql3= "Select `id` from `app_management` WHERE `app_name` = '$appname'";
        $app_id = Yii::app()->sitedb->createCommand($sql3)->queryAll();
        $appid = $app_id[0]['id'];
        $this->render('index',array(
            'model'=>$model,
            'cou'=>$cou,
            'appid'=>$appid
        ));

    }

    /**
     * @param $id
     * Places an order of the module from this action.
     */
    public function actionPay($id){
        $sql = "SELECT * FROM `product_info` WHERE `product_id` = ". $id;
        $model1=Yii::app()->sitedb->createCommand($sql)->queryAll();
        $appname =  Yii::app()->params['applicationName'];
        $sql3= "Select `id` from `app_management` WHERE `app_name` = '$appname'";
        $app_id = Yii::app()->sitedb->createCommand($sql3)->queryAll();
        $appid = $app_id[0]['id'];
        $date = Date("Y-m-d H:i:s");

        //echo "<pre>";print_r($_POST);die;
        if(isset($_POST['company'])) {
            switch ($model1[0]['name']){
                case 'E-commerce Module':
                    $widgetsql1  = "INSERT INTO `widget_mapping`(`id`, `app_id`, `product_id`, `widget_name`, `is_active`, `created_at`, `modified_at`) VALUES ('','$appid','$id','Total Products','0','$date','$date')";
                    $widgetsql2  = "INSERT INTO `widget_mapping`(`id`, `app_id`, `product_id`, `widget_name`, `is_active`, `created_at`, `modified_at`) VALUES ('','$appid','$id','Total Orders','0','$date','$date')";
                    $widgetsql3  = "INSERT INTO `widget_mapping`(`id`, `app_id`, `product_id`, `widget_name`, `is_active`, `created_at`, `modified_at`) VALUES ('','$appid','$id','Latest Orders','0','$date','$date')";
                    Yii::app()->db->createCommand($widgetsql1)->execute();
                    Yii::app()->db->createCommand($widgetsql2)->execute();
                    Yii::app()->db->createCommand($widgetsql3)->execute();
                    break;
                case 'Wallet System':
                    $widgetsql1  = "INSERT INTO `widget_mapping`(`id`, `app_id`, `product_id`, `widget_name`, `is_active`, `created_at`, `modified_at`) VALUES ('','$appid','$id','Total Wallets','0','$date','$date')";
                    $widgetsql2  = "INSERT INTO `widget_mapping`(`id`, `app_id`, `product_id`, `widget_name`, `is_active`, `created_at`, `modified_at`) VALUES ('','$appid','$id','Wallet Summary','0','$date','$date')";
                    Yii::app()->db->createCommand($widgetsql1)->execute();
                    Yii::app()->db->createCommand($widgetsql2)->execute();
                    break;
                case 'Reservation Module':
                    $widgetsql1  = "INSERT INTO `widget_mapping`(`id`, `app_id`, `product_id`, `widget_name`, `is_active`, `created_at`, `modified_at`) VALUES ('','$appid','$id','Events Chart','0','$date','$date')";
                    $widgetsql2  = "INSERT INTO `widget_mapping`(`id`, `app_id`, `product_id`, `widget_name`, `is_active`, `created_at`, `modified_at`) VALUES ('','$appid','$id','Latest Bookings','0','$date','$date')";
                    Yii::app()->db->createCommand($widgetsql1)->execute();
                    Yii::app()->db->createCommand($widgetsql2)->execute();
                    break;
                case 'Content Management':
                    break;
                case 'Facebook Feed':
                    break;
                case 'Ticket Management':
                    break;
            }

            $userId = Yii::app()->user->id;
            $username = Yii::app()->user->name;
            $emailsql = "SELECT email from user_info WHERE user_id = " . "'$userId'";
            $email = Yii::app()->db->createCommand($emailsql)->queryScalar();
            $sql = "SELECT `name`,`price` FROM `product_info` WHERE `product_id` = '$id'";
            $model1 = Yii::app()->sitedb->createCommand($sql)->queryAll();
            $product_name = $model1[0]['name'];
            $price = $model1[0]['price'];
            $vat = ($model1[0]['price']) * 14 / 100;
            $total = $model1[0]['price'] + $vat;
            //echo "<pre>";print_r($price);exit;
            $company = $_POST['company'];
            $street = $_POST['street'];
            $region = $_POST['region'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $postcode = $_POST['postcode'];
            $vat_number = $_POST['vat_number'];
            $created_at = date('Y-m-d H:i:s');
            $modified_at = date('Y-m-d H:i:s');
            $invoiceNo = 1;
            $sql3 = "SELECT `order_id` from `order_info`  ORDER BY `order_id` DESC LIMIT 1";
            $lastInvoice = Yii::app()->sitedb->createCommand($sql3)->queryAll();
            if ($lastInvoice == null) {
                $invoice_number = $invoiceNo;
                $order_id = $invoiceNo;
            } else {
                $lastInvoiceNo =$lastInvoice[0]['order_id'];
                $invoice_number = $lastInvoiceNo + 1;
                $order_id = $lastInvoiceNo + 1;
            }//echo $order_id;die;
            $sql2 = "INSERT INTO `order_info`(`order_info_id`, `order_id`, `user_id`, `vat`, `vat_number`, `company`, `order_status`, `building`, `street`, `city`, `region`, `country`, `postcode`, `orderTotal`, `discount`, `netTotal`, `invoice_number`, `invoice_date`, `created_date`, `modified_date`, `is_subscription_enabled`, `user_name`, `email`) VALUES ('','$order_id','$userId','$vat','$vat_number','$company','1','','$street','$city','$region','$country','$postcode','$total','0','$total','$invoice_number','$created_at','$created_at','$modified_at','0','$username','$email')";
            Yii::app()->sitedb->createCommand($sql2)->execute();
            $sql4 = "SELECT `order_id` from `order_info`  ORDER BY `order_id` DESC LIMIT 1";
            $order_id_item = Yii::app()->sitedb->createCommand($sql4)->queryAll();
            $order_info_id = $order_id_item[0]['order_id'];
            //echo $order_id_line;die;
            $sql1 = "INSERT INTO `order_line_item`(`order_line_item_id`, `order_info_id`, `product_name`, `item_qty`, `item_disc`, `item_price`, `created_at`, `modified_at`, `product_id`, `product_sku`) VALUES ('','$order_info_id','$product_name','1','','$price','$created_at','$modified_at','$id','sku')";
            Yii::app()->sitedb->createCommand($sql1)->execute();

            $sql5 = "INSERT INTO `order_payment`(`payment_id`, `order_info_id`, `total`, `payment_mode`, `payment_ref_id`, `payment_status`, `payment_date`, `created_at`, `modified_at`, `transaction_mode`) VALUES ('','$order_info_id','$total','1','1234567','1','$created_at','$created_at','$modified_at','Bank Transfer')";
            Yii::app()->sitedb->createCommand($sql5)->execute();
            $order_status = 1;
            $sql6 = "INSERT INTO `order_mapping`(`id`, `order_id`, `app_id`, `product_id`,`order_status`, `buy_date`, `created_at`, `modified_at`) VALUES ('','$order_id','$appid','$id','$order_status','$created_at','$created_at','$modified_at')";
            Yii::app()->sitedb->createCommand($sql6)->execute();


            $this->redirect( Yii::app()->createUrl('/admin/Modules/index'));
        }

        $this->render('pay', array(
            'model'=>$model1[0],
        ));

    }

    public function actionBuilder(){

        $src = Yii::app()->params['basePath'].'/plugins/builderlayout/';
        $dest = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/modules/admin/views/layouts/';

        $src1 = Yii::app()->params['basePath'].'/plugins/builder/';
        $dest1 = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/plugins/builder/';
        $this->recurse_copy($src,$dest);
        $this->recurse_copy($src1,$dest1);
        $builder = CylTables::model()->findByAttributes(['table_name' => 'html_builder']);
        $builder->display_status = 1;
        $builder->save();
    }


    public function actionUninstallBuilder(){
        $file = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/modules/admin/views/layouts/builder.php';
        unlink($file);
        $builderplugin = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/plugins/builder/';
        DeleteFolder::deleteDir($builderplugin);

        $builder = CylTables::model()->findByAttributes(['table_name' => 'html_builder']);
        $builder->display_status = 0;
        $builder->save();
    }

    public function actionEvents(){
        $sql = "CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(50) DEFAULT NULL,
  `event_key` varchar(255) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `event_description` longtext NOT NULL,
  `event_host` varchar(255) NOT NULL,
  `event_location` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `event_start` timestamp NULL DEFAULT NULL,
  `event_end` timestamp NULL DEFAULT NULL,
  `event_url` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `recurring_span` varchar(255) NOT NULL,
  `booking_start_date` timestamp NULL DEFAULT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `coupon_start_date` timestamp NULL DEFAULT NULL,
  `coupon_end_date` timestamp NULL DEFAULT NULL,
  `total_tickets` varchar(255) NOT NULL,
  `max_num_bookings` varchar(255) NOT NULL,
  `is_notification` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";

        $sql1 = "CREATE TABLE IF NOT EXISTS `booking` (
  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` varchar(255) NOT NULL,
  `service_id` varchar(255) NOT NULL,
  `timeslot` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `address` varchar(355) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";

        $sql3 = "CREATE TABLE IF NOT EXISTS `recurring` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `recurring_span` varchar(255) NOT NULL,
                  `created_at` datetime NOT NULL,
                  `modified_at` datetime NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";

        $sql4 = "INSERT INTO `recurring` (`id`, `recurring_span`, `created_at`, `modified_at`) VALUES
                (1, 'Every day', '2018-02-20 00:00:00', '2018-02-20 00:00:00'),
                (2, 'Weekdays only', '2018-02-20 00:00:00', '2018-02-20 00:00:00'),
                (3, 'Weekends only', '2018-02-20 00:00:00', '2018-02-20 00:00:00'),
                (4, 'Once a week', '2018-02-20 00:00:00', '2018-02-20 00:00:00'),
                (5, 'Once a fortnight', '2018-02-20 00:00:00', '2018-02-20 00:00:00'),
                (6, 'Monthly(repeat by day)', '2018-02-20 00:00:00', '2018-02-20 00:00:00'),
                (7, 'Monthly(repeat by week day)', '2018-02-20 00:00:00', '2018-02-20 00:00:00'),
                (8, 'Every six weeks', '2018-02-20 00:00:00', '2018-02-20 00:00:00'),
                (9, 'Every two months(repeat by day)', '2018-02-20 00:00:00', '2018-02-20 00:00:00'),
                (10, 'Every Quarter (repeat by day)', '2018-02-20 00:00:00', '2018-02-20 00:00:00'),
                (11, 'Twice a Year (repeat by day)', '2018-02-20 00:00:00', '2018-02-20 00:00:00'),
                (12, 'Yearly (repeat by day)', '2018-02-20 00:00:00', '2018-02-20 00:00:00');";

        $model1 = new Roles();
        $model2 = new Roles();
        $model1->role_title = "Employee";
        $model2->role_title = "Viewer";
        $model1->created_at = date('Y-m-d H:i:s');
        $model1->modified_at = date('Y-m-d H:i:s');
        $model2->created_at = date('Y-m-d H:i:s');
        $model2->modified_at = date('Y-m-d H:i:s');
        $model1->save();
        $model2->save();

        $sql5 = "CREATE TABLE IF NOT EXISTS  `service_provider` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(100) NOT NULL,
                    `description` varchar(20000),
                    `email` varchar(100),
                    `phone_no` int(11),
                    `image` varchar(500),
                    `no_of_clients_sametime` int(11),
                    `created_at` datetime DEFAULT NULL,
                    `modified_at` datetime DEFAULT NULL ,
                    PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;";

        $user_id = Yii::app()->user->id;

        $sql6 = "INSERT INTO settings (`user_id`,`module_name`,`settings_key`,`value`) values ('$user_id','events','event_host_role','Employee')";

        $sql7 = "CREATE TABLE IF NOT EXISTS `services` (
                  `service_id` int(11) NOT NULL AUTO_INCREMENT,
                  `service_name` varchar(255) NOT NULL,
                  `service_description` longtext NOT NULL,
                  `service_image` varchar(255) NOT NULL,
                  `is_display` tinyint(11) NOT NULL,
                  `service_price` varchar(255) NOT NULL,
                  `service_duration` varchar(300) NOT NULL,
                  `category` varchar(255) NOT NULL,
                  `user_id` varchar(255) NOT NULL,
                  `resource_id` varchar(255) NOT NULL,
                  `created_at` datetime NOT NULL,
                  `modified_at` datetime NOT NULL,
                  PRIMARY KEY (`service_id`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";


        $sql8 = "CREATE TABLE IF NOT EXISTS `business_openings_hours` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `serviceprovider_id` varchar(11) NOT NULL,
                  `day` varchar(300) NOT NULL,
                  `timing` varchar(400) NOT NULL,
                  `created_at` datetime NOT NULL,
                  `modified_at` varchar(255) NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";

        $sql9 = "CREATE TABLE IF NOT EXISTS `resources` (
                  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
                  `resource_name` varchar(200) NOT NULL,
                  `resource_description` longtext NOT NULL,
                  `resource_address` varchar(400) NOT NULL,
                  `is_available` int(11) NOT NULL,
                  `created_at` datetime NOT NULL,
                  `modified_at` datetime NOT NULL,
                  PRIMARY KEY (`resource_id`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";

        Yii::app()->db->createCommand($sql)->execute();
        Yii::app()->db->createCommand($sql1)->execute();
        Yii::app()->db->createCommand($sql3)->execute();
        Yii::app()->db->createCommand($sql4)->execute();
        Yii::app()->db->createCommand($sql5)->execute();
        Yii::app()->db->createCommand($sql6)->execute();
        Yii::app()->db->createCommand($sql7)->execute();
        Yii::app()->db->createCommand($sql8)->execute();
        Yii::app()->db->createCommand($sql9)->execute();

        $app_name = Yii::app()->params['applicationName'];
        $sql = "SELECT * from app_management where app_name = "."'$app_name'";
        $result = Yii::app()->sitedb->createCommand($sql)->queryAll();
        $appid = $result[0]['id'];

        $productsql = "SELECT * from product_info where name = 'Reservation Module'";
        $prodresult = Yii::app()->sitedb->createCommand($productsql)->queryAll();
        $productid = $prodresult[0]['product_id'];


        $widgetsql = "UPDATE widget_mapping SET is_active = 1 WHERE app_id = ".$appid." AND product_id = ".$productid;
        Yii::app()->db->createCommand($widgetsql)->execute();

        $eventtable = Yii::app()->db->schema->getTable('events');
        if(!empty($eventtable)){
            $events = CylTables::model()->findAllByAttributes(['table_name' => 'events']);
            foreach ($events as $key=>$event){
                $event->display_status = 1;
                $event->save();
            }
            echo "Table successfully created";
        }
        else{
            echo json_encode(array(
                'result' => false,
                'error' => "An error occurred"
            ));
        }
    }

    public function actionMt4(){
        $sql = "CREATE TABLE IF NOT EXISTS `api_accounts` (
                    `Login` int(11) NOT NULL,
                    `Name` varchar(200) DEFAULT NULL,
                    `Currency` varchar(10) DEFAULT NULL,
                    `Balance` varchar(100) DEFAULT NULL,
                    `Equity` varchar(100) NOT NULL,
                    `EmailAddress` varchar(300) DEFAULT NULL,
                    `Group` varchar(50) DEFAULT NULL,
                    `Agent` varchar(50) DEFAULT NULL,
                    `RegistrationDate` datetime DEFAULT NULL,
                    `Leverage` varchar(50) DEFAULT NULL,
                    `Address` varchar(300) DEFAULT NULL,
                    `City` varchar(50) DEFAULT NULL,
                    `State` varchar(50) DEFAULT NULL,
                    `PostCode` varchar(50) DEFAULT NULL,
                    `Country` varchar(50) DEFAULT NULL,
                    `PhoneNumber` varchar(20) DEFAULT NULL,
                    `created_date` datetime DEFAULT NULL,
                    `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                    PRIMARY KEY (`Login`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        $sql1 = "CREATE TABLE IF NOT EXISTS `user_daily_balance` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `email_address` varchar(50) NOT NULL,
                      `login` int(11) NOT NULL,
                      `balance` float NOT NULL,
                      `agent` int(11) NOT NULL,
                      `equity` float NOT NULL,
                      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                      PRIMARY KEY (`id`)
                      ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";

        $sql2 = "CREATE TABLE IF NOT EXISTS `api_logs` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `date` timestamp NULL DEFAULT NULL,
                      `log` varchar(300) DEFAULT NULL,
                      `status` tinyint(1) DEFAULT '0',
                      `timetaken` varchar(100) DEFAULT NULL,
                      `total_accounts` int(11) DEFAULT NULL,
                      `created_date` datetime DEFAULT NULL,
                      PRIMARY KEY (`id`)
                      ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

        $sql3 = "CREATE TABLE IF NOT EXISTS `api_deposit_withdraw` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `login` int(11) NOT NULL,
                    `ticket` int(11) NOT NULL,
                    `symbol` varchar(100) DEFAULT NULL,
                    `email` varchar(100) DEFAULT NULL,
                    `api_type` varchar(50) NOT NULL,
                    `lots` varchar(50) DEFAULT NULL,
                    `type` varchar(50) NOT NULL,
                    `open_price` varchar(50) DEFAULT NULL,
                    `open_time` datetime DEFAULT NULL,
                    `close_price` varchar(50) DEFAULT NULL,
                    `close_time` datetime DEFAULT NULL,
                    `profit` varchar(50) DEFAULT NULL,
                    `commission` varchar(50) DEFAULT NULL,
                    `agent_commission` varchar(50) DEFAULT NULL,
                    `comment` varchar(200) NOT NULL,
                    `magic_number` int(11) DEFAULT NULL,
                    `stop_loss` varchar(100) DEFAULT NULL,
                    `take_profit` varchar(100) DEFAULT NULL,
                    `swap` varchar(100) DEFAULT NULL,
                    `reason` varchar(500) DEFAULT NULL,
                    `created_at` datetime NOT NULL,
                    `modified_at` datetime DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;";

        Yii::app()->db->createCommand($sql)->execute();
        Yii::app()->db->createCommand($sql1)->execute();
        Yii::app()->db->createCommand($sql2)->execute();
        Yii::app()->db->createCommand($sql3)->execute();

        $mttable = Yii::app()->db->schema->getTable('api_accounts');
        if(!empty($mttable)){
            $mt = CylTables::model()->findByAttributes(['table_name' => 'api_accounts']);
            if(empty($mt)){
                $mt1 = new CylTables();
                $mt2 = new CylTables();
                $mt3 = new CylTables();
                $mt4 = new CylTables();

                $mt1->table_name = 'api_accounts';
                $mt2->table_name = 'api_accounts';
                $mt3->table_name = 'api_accounts';
                $mt4->table_name = 'api_accounts';

                $mt1->module_name = 'mt4';
                $mt2->module_name = 'mt4';
                $mt3->module_name = 'mt4';
                $mt4->module_name = 'mt4';

                $result1 = Yii::app()->db->createCommand("SELECT max(menu_order) from cyl_tables")->queryAll();
                $mt1->menu_order = 1+$result1[0]['max(menu_order)'];
                $mt2->menu_order = 2+$result1[0]['max(menu_order)'];
                $mt3->menu_order = 3+$result1[0]['max(menu_order)'];
                $mt4->menu_order = 4+$result1[0]['max(menu_order)'];


                $mt1->isParent = 1;
                $mt2->isParent = 0;
                $mt3->isParent = 0;
                $mt4->isParent = 0;

                $mt1->menu_name = 'Mt4 Generator';
                $mt2->menu_name = 'Accounts';
                $mt3->menu_name = 'Settings';
                $mt4->menu_name = 'Deposit-Withdraw';

                $mt1->isMenu = 1;
                $mt2->isMenu = 0;
                $mt3->isMenu = 0;
                $mt4->isMenu = 0;

                $mt1->menu_icon = "fa fa-ticket";
                $mt2->menu_icon = "fa fa-ticket";
                $mt3->menu_icon = "fa fa-cogs";
                $mt4->menu_icon = "fa fa-cogs";

                $mt1->action = "";
                $mt2->action = "mt4/accounts";
                $mt3->action = "mt4/settings";
                $mt4->action = "mt4/depositWithdraw";

                $mt1->display_status = 1;
                $mt2->display_status = 1;
                $mt3->display_status = 1;
                $mt4->display_status = 1;

                if($mt1->save()){
                    $mt2->parent_item = $mt1->table_id;
                    $mt3->parent_item = $mt1->table_id;
                    $mt4->parent_item = $mt1->table_id;
                    $mt2->save();
                    $mt3->save();
                    $mt4->save();
                }
            }
            else{
                $mt->display_status = 1;
            }
            if(!empty($mt)){
                if($mt->validate()){
                    $mt->save();
                    echo "Table successfully created";
                }
                else{
                    echo "<pre>";
                    print_r($mt->getErrors());
                }
            }
        }
        else{
            echo json_encode(array(
                'result' => false,
                'error' => "An error occurred"
            ));
        }

    }

    public function actionTicket(){
        $sql = "CREATE TABLE IF NOT EXISTS `ticketing` (
          `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` varchar(50) DEFAULT NULL,
          `title` varchar(80) NOT NULL,
          `ticket_detail` varchar(10000) NOT NULL,
          `description` varchar(255) NOT NULL,
          `status` varchar(255) NOT NULL,
          `attachment` varchar(255) NOT NULL,
          `jira_url` varchar(255) NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `modified_at` datetime,
          PRIMARY KEY (`ticket_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

        $sql2 = "CREATE TABLE IF NOT EXISTS `comment_mapping` (
          `comment_id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) DEFAULT NULL,
          `ticket_id` int(11) DEFAULT NULL,
          `parent_id` int(11) DEFAULT NULL,
          `comment` varchar(10000) NOT NULL,
          `attachment` varchar(255) NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `modified_at` datetime,
          PRIMARY KEY (`comment_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

        Yii::app()->db->createCommand($sql)->execute();
        Yii::app()->db->createCommand($sql2)->execute();


        $tickettable = Yii::app()->db->schema->getTable('ticketing');
        if(!empty($tickettable)){
            $ticket = CylTables::model()->findByAttributes(['table_name' => 'ticketing']);
            if(empty($ticket)){
                $ticket1 = new CylTables();
                $ticket2 = new CylTables();
                $ticket3 = new CylTables();

                $ticket1->table_name = 'ticketing';
                $ticket2->table_name = 'ticketing';
                $ticket3->table_name = 'ticketing';

                $ticket1->module_name = 'ticketing';
                $ticket2->module_name = 'ticketing';
                $ticket3->module_name = 'ticketing';

                $result1 = Yii::app()->db->createCommand("SELECT max(menu_order) from cyl_tables")->queryAll();
                $ticket1->menu_order = 1+$result1[0]['max(menu_order)'];
                $ticket2->menu_order = 2+$result1[0]['max(menu_order)'];
                $ticket3->menu_order = 3+$result1[0]['max(menu_order)'];

                $ticket1->isParent = 1;
                $ticket2->isParent = 0;
                $ticket3->isParent = 0;

                $ticket1->menu_name = 'Support Tickets';
                $ticket2->menu_name = 'Tickets';
                $ticket3->menu_name = 'Settings';

                $ticket1->isMenu = 1;
                $ticket2->isMenu = 0;
                $ticket3->isMenu = 0;

                $ticket1->menu_icon = "fa fa-ticket";
                $ticket2->menu_icon = "fa fa-ticket";
                $ticket3->menu_icon = "fa fa-cogs";

                $ticket1->action = "";
                $ticket2->action = "ticketing/admin";
                $ticket3->action = "ticketing/settings";

                $ticket1->display_status = 1;
                $ticket2->display_status = 1;
                $ticket3->display_status = 1;

                if($ticket1->save()){
                    $ticket2->parent_item = $ticket1->table_id;
                    $ticket3->parent_item = $ticket1->table_id;
                    $ticket2->save();
                    $ticket3->save();
                }
            }
            else{
                $ticket->display_status = 1;
            }
            if(!empty($ticket)){
                if($ticket->validate()){
                    $ticket->save();
                    echo "Table successfully created";
                }
                else{
                    echo "<pre>";
                    print_r($ticket->getErrors());
                }
            }
        }
        else{
            echo json_encode(array(
                'result' => false,
                'error' => "An error occurred"
            ));
        }

    }

    public function actionUninstallTicket(){
        $sql1 = "DROP TABLE comment_mapping";
        Yii::app()->db->createCommand($sql1)->execute();
        $sql  = "DROP TABLE ticketing";
        Yii::app()->db->createCommand($sql)->execute();

        $tickettable = Yii::app()->db->schema->getTable('ticketing');
        if(empty($tickettable)){
            $ticket = CylTables::model()->findByAttributes(['table_name' => 'ticketing']);
            $ticket->display_status = 0;
            $ticket->save();
            echo "Table successfully deleted";
        }
        else{
            echo json_encode(array(
                'result' => false,
                'error' => "An error occurred"
            ));
        }
    }

    public function actionUninstallMt4(){
        $sql1 = "DROP TABLE api_accounts";
        Yii::app()->db->createCommand($sql1)->execute();
        $sql  = "DROP TABLE user_daily_balance";
        Yii::app()->db->createCommand($sql)->execute();
        $sql2  = "DROP TABLE api_deposit_withdraw";
        Yii::app()->db->createCommand($sql2)->execute();

        $mttable = Yii::app()->db->schema->getTable('api_accounts');
        if(empty($mttable)){
            $mt = CylTables::model()->findByAttributes(['table_name' => 'api_accounts']);
            $mt->display_status = 0;
            $mt->save();
            echo "Table successfully deleted";
        }
        else{
            echo json_encode(array(
                'result' => false,
                'error' => "An error occurred"
            ));
        }
    }

    public function actionUninstallevents(){
        $app_name = Yii::app()->params['applicationName'];
        $sql = "SELECT * from app_management where app_name = "."'$app_name'";
        $result = Yii::app()->sitedb->createCommand($sql)->queryAll();
        $appid = $result[0]['id'];

        $productsql = "SELECT * from product_info where name = 'Reservation Module'";
        $prodresult = Yii::app()->sitedb->createCommand($productsql)->queryAll();
        $productid = $prodresult[0]['product_id'];

        $widgetsql = "UPDATE widget_mapping SET is_active = 0 WHERE app_id = ".$appid." AND product_id = ".$productid;
        Yii::app()->db->createCommand($widgetsql)->execute();

        $sql  = "DROP TABLE events";
        $sql1  = "DROP TABLE booking";
        $sql2 = "DROP TABLE recurring";
        Yii::app()->db->createCommand($sql)->execute();
        Yii::app()->db->createCommand($sql1)->execute();
        Yii::app()->db->createCommand($sql2)->execute();

        $eventtable = Yii::app()->db->schema->getTable('events');
        if(empty($eventtable)){
            $events = CylTables::model()->findByAttributes(['table_name' => 'events']);
            $events->display_status = 0;
            $events->save();
            echo "Table successfully deleted";
        }
        else{
            echo json_encode(array(
                'result' => false,
                'error' => "An error occurred"
            ));
        }

    }

    public function actionFb_feed(){
        $sql = "CREATE TABLE IF NOT EXISTS `fb_feed` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `description` varchar(1024) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `is_enabled` tinyint(1) NOT NULL,
        `source` varchar(255) NOT NULL,
        `image_url` varchar(1024) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;";

        $sql1 = "INSERT INTO `fb_feed` (`id`, `title`, `description`, `created_at`, `is_enabled`, `source`, `image_url`) VALUES
        (1, 'admin', 'admin post description', '2017-05-31 06:21:44', 1, 'Admin', 'https://scontent.xx.fbcdn.net/v/t1.0-0/s130x130/18700327_368482080220653_7073475425382234122_n.jpg?oh=cc09002300771782f515f76d41e59fc4&oe=59AF523A');";

        /*$sql2 = "CREATE TABLE IF NOT EXISTS `sync_fb` ( `id` INT NOT NULL AUTO_INCREMENT ,
                  `clientId` VARCHAR(50) NOT NULL ,
                   `clientSecretId` VARCHAR(50) NOT NULL ,
                    `pageId` VARCHAR(50) NOT NULL ,
                     PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1;";
        $sql3 = "INSERT INTO `sync_fb`(`id`, `clientId`, `clientSecretId`, `pageId`) VALUES (1,'','','')";*/
        $result = Yii::app()->db->createCommand($sql)->execute();
        $result1 = Yii::app()->db->createCommand($sql1)->execute();
        /*$result2 = Yii::app()->db->createCommand($sql2)->execute();
        $result3 = Yii::app()->db->createCommand($sql3)->execute();*/

        $fb_feeddtable = Yii::app()->db->schema->getTable('fb_feed');
        if(!empty($fb_feeddtable)){
            $fb = CylTables::model()->findByAttributes(['table_name' => 'fb_feed_parent']);
            $fb->display_status = 1;
            ($fb->validate()) ? $fb->save() : print_r($fb->getErrors());
            echo "Table successfully created";
        }
        else{
            echo json_encode(array(
                'result' => false,
                'error' => "An error occurred"
            ));
        }
    }

    public function actionUninstallfb(){
        $sql  = "DROP TABLE fb_feed";
        //$sql1 = "DROP TABLE sync_fb";
        $sql1 = "DELETE FROM `settings` WHERE `module_name` = 'Facebook Feed'";
        $result = Yii::app()->db->createCommand($sql)->execute();
        $result1 = Yii::app()->db->createCommand($sql1)->execute();

        $fb_feedtable = Yii::app()->db->schema->getTable('fb_feed');
        if(empty($fb_feedtable)){
            $fb = CylTables::model()->findByAttributes(['table_name' => 'fb_feed_parent']);
            $fb->display_status = 0;
            ($fb->validate()) ? $fb->save() : print_r($fb->getErrors());
            echo "Table successfully deleted";
        }
        else{
            echo json_encode(array(
                'result' => false,
                'error' => "An error occurred"
            ));
        }
    }

    public function actionUninstallecom(){
        $tables = ['categories','denomination','order_cart','order_credit_memo','order_info','order_line_item','order_payment','portals','product_affiliate','product_category','product_info','product_licenses','user_licenses','user_license_count','wallet_meta_entity','wallet_type_entity'];
        $foreignsql = "SET foreign_key_checks = 0";
        $result = Yii::app()->db->createCommand($foreignsql)->execute();
        foreach($tables as $key=>$table){

            $sql[$key] = "DROP TABLE IF EXISTS ".$table;

            $result = Yii::app()->db->createCommand($sql[$key])->execute();
        }

        $sql1 = "SET foreign_key_checks = 1;";
        $result1 = Yii::app()->db->createCommand($sql1)->execute();

        $app_name = Yii::app()->params['applicationName'];
        $sql = "SELECT * from app_management where app_name = "."'$app_name'";
        $result = Yii::app()->sitedb->createCommand($sql)->queryAll();
        $appid = $result[0]['id'];

        $productsql = "SELECT * from product_info where name = 'E-commerce Module'";
        $prodresult = Yii::app()->sitedb->createCommand($productsql)->queryAll();
        $productid = $prodresult[0]['product_id'];

        $widgetsql = "UPDATE widget_mapping SET is_active = 0 WHERE app_id = ".$appid." AND product_id = ".$productid;
        Yii::app()->db->createCommand($widgetsql)->execute();


        $ordermodelfiles[0] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/OrderInfo.php';
        $ordermodelfiles[1] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/OrderLineItem.php';
        $ordermodelfiles[2] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/OrderPayment.php';
        $ordermodelfiles[3] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/OrderCreditMemo.php';

        foreach ($ordermodelfiles as $modelfile){
            if(is_file($modelfile)){
                $product = CylTables::model()->findByAttributes(['table_name' => 'product_managment']);
                $product->display_status = 0;
                $product->save();

                $order = CylTables::model()->findByAttributes(['table_name' => 'order_managment']);
                $order->display_status = 0;
                $order->save();
                unlink($modelfile); // delete file
            }
        }

        $productmodelfiles[0] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/ProductInfo.php';
        $productmodelfiles[1] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/ProductLicenses.php';
        $productmodelfiles[2] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/ProductAffiliate.php';
        $productmodelfiles[3] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/ProductCategory.php';
        $productmodelfiles[4] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/Portals.php';

        foreach ($productmodelfiles as $productmodelfile){
            if(is_file($productmodelfile)){
                unlink($productmodelfile); // delete file
            }
        }

        $orderviewfiles = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/modules/admin/views/orderInfo/';
        $productviewfiles = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/modules/admin/views/productInfo/';
        $files = glob($orderviewfiles.'*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
        rmdir($orderviewfiles);

        $newfiles = glob($productviewfiles.'*'); // get all file names
        foreach($newfiles as $file){   // iterate files
            if(is_file($file)){
                unlink($file); // delete file
            }
        }
        rmdir($productviewfiles);

    }

    protected function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function actionUninstallwallet(){
        $tables = ['denomination','portals','user_balance','wallet','wallet_meta_entity','wallet_type_entity','payment'];
        $foreignsql = "SET foreign_key_checks = 0";
        $result = Yii::app()->db->createCommand($foreignsql)->execute();
        foreach($tables as $key=>$table){

            $sql[$key] = "DROP TABLE IF EXISTS ".$table;

            $result = Yii::app()->db->createCommand($sql[$key])->execute();
        }

        $sql1 = "SET foreign_key_checks = 1;";
        $result1 = Yii::app()->db->createCommand($sql1)->execute();

        $app_name = Yii::app()->params['applicationName'];
        $sql = "SELECT * from app_management where app_name = "."'$app_name'";
        $result = Yii::app()->sitedb->createCommand($sql)->queryAll();
        $appid = $result[0]['id'];

        $productsql = "SELECT * from product_info where name = 'Wallet System'";
        $prodresult = Yii::app()->sitedb->createCommand($productsql)->queryAll();
        $productid = $prodresult[0]['product_id'];

        $widgetsql = "UPDATE widget_mapping SET is_active = 0 WHERE app_id = ".$appid." AND product_id = ".$productid;
        Yii::app()->db->createCommand($widgetsql)->execute();

        $walletmodelfiles[0] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/Wallet.php';
        $walletmodelfiles[1] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/WalletMetaEntity.php';
        $walletmodelfiles[2] = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/models/WalletTypeEntity.php';

        foreach ($walletmodelfiles as $modelfile){
            if(is_file($modelfile)){
                $wallet = CylTables::model()->findByAttributes(['table_name' => 'wallet_managment']);
                $wallet->display_status = 0;
                $wallet->save();
                unlink($modelfile); // delete file
            }
        }

        $walletviewfiles = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/modules/admin/views/wallet/';
        $walletmetaviewfiles = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'].'/protected/modules/admin/views/walletMetaEntity/';

        $walletfiles = glob($walletviewfiles.'*'); // get all file names
        foreach($walletfiles as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
        rmdir($walletviewfiles);

        $walletmetafiles = glob($walletmetaviewfiles.'*'); // get all file names
        foreach($walletmetafiles as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
        rmdir($walletmetaviewfiles);
    }

    public function actionUninstallpayment(){
        $tables = ['payment'];
        $foreignsql = "SET foreign_key_checks = 0";
        $result = Yii::app()->db->createCommand($foreignsql)->execute();
        foreach($tables as $key=>$table){

            $sql[$key] = "DROP TABLE IF EXISTS ".$table;

            $result = Yii::app()->db->createCommand($sql[$key])->execute();
        }

        $sql1 = "SET foreign_key_checks = 1;";
        Yii::app()->db->createCommand($sql1)->execute();

    }
}