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
    }

    //send reminder to pending payment user
    public function actionSendReminder() {
        try {
            $order_info_meta = [];
            $order_info_id = Yii::app()->db->createCommand()->select('order_info_id')
                            ->from('order_payment')
                            ->where('payment_status=:status', array(':status' => 2))
                            ->queryAll();
            if(!empty($order_info_id)){
                foreach($order_info_id as $orderID){
                    $temp = [];
                    $execution_time = date('Y-m-d H:i:s');
                    $orders = OrderInfo::model()->findByPk($orderID);
                    if(empty($orders['email'])){
                        $user = UserInfo::model()->findByPk($orders['user_id']);
                        $email = $user['email'];
                    }else{
                        $email = $orders['email'];
                    }
                    $reminders = Yii::app()->db->createCommand()->select('*')->from('reminder_settings')->queryAll();
                    foreach($reminders as $rem){
                        if($rem['reminder'] == 1){
                            $amount = $orders['orderTotal'] + $rem['cost'];
                            $reminder_1_date = date('Y-m-d', strtotime($orders['invoice_date'].' + '.$rem['days'].' days'));
                        }elseif($rem['reminder'] == 2){
                            $amount = $orders['orderTotal'] + $rem['cost'];
                            $reminder_2_date = date('Y-m-d', strtotime($orders['invoice_date'].' + '.$rem['days'].' days'));
                        }
                        elseif($rem['reminder'] == 3){
                            $amount = $orders['orderTotal'] + $rem['cost'];
                            $reminder_3_date = date('Y-m-d', strtotime($orders['invoice_date'].' + '.$rem['days'].' days'));
                        }
                    }
                    $current_date = date('Y-m-d');
                    $email = 'vaghelamayursinh999@gmail.com';
                    /*$reminder_1_date = date('Y-m-d', strtotime($orders['invoice_date'].' + 7 days'));
                    $reminder_2_date = date('Y-m-d', strtotime($reminder_1_date.' + 7 days'));
                    $reminder_3_date = date('Y-m-d', strtotime($reminder_2_date.' + 5 days'));*/
                    if($reminder_1_date == $current_date){
                        $reminder = '1st Reminder';
                        $subject = 'Payment Reminder';
                        $action = '1st Reminder sent';
                        $comment = 'Total amount '.$amount;
                        $msg = "1st Reminder sent to ".$email.",\n";
                        if($amount != $orders['orderTotal']){
                            $query = "update order_info, order_payment set order_info.orderTotal = $amount, order_info.netTotal = $amount, order_payment.total = $amount 
                                where order_info.order_info_id = $orders[order_info_id] and order_payment.order_info_id = $orders[order_info_id]";
                            Yii::app()->db->createCommand($query)->execute();
                        }
                    }elseif($reminder_2_date == $current_date){
                        $reminder = '2nd Reminder';
                        $subject = 'Second Reminder';
                        $action = '2nd Reminder sent';
                        $comment = 'Additional amount of Euro 12.10 added in invoice total '.$amount;
                        $msg = "2nd Reminder sent to ".$email.",\n";
                        if($amount != $orders['orderTotal']){
                            $query = "update order_info, order_payment set order_info.orderTotal = $amount, order_info.netTotal = $amount, order_payment.total = $amount 
                                where order_info.order_info_id = $orders[order_info_id] and order_payment.order_info_id = $orders[order_info_id]";
                            Yii::app()->db->createCommand($query)->execute();
                        }
                    }elseif($reminder_3_date == $current_date){
                        $reminder = '3rd Reminder';
                        $subject = 'Third Reminder';
                        $action = '3rd Reminder sent';
                        $comment = 'Additional amount of Euro 12.10 added in invoice total '.$amount;
                        $msg = "3rd Reminder sent to ".$email.",\n";
                        if($amount != $orders['orderTotal']){
                            $query = "update order_info, order_payment set order_info.orderTotal = $amount, order_info.netTotal = $amount, order_payment.total = $amount 
                                where order_info.order_info_id = $orders[order_info_id] and order_payment.order_info_id = $orders[order_info_id]";
                            Yii::app()->db->createCommand($query)->execute();
                        }
                    }
                    if(!empty($reminder) && !empty($subject)){
                        $mail = new YiiMailer('reminder', [
                            'reminder' => $reminder,
                            'orders' => $orders,
                        ]);
                        $mail->setFrom('info@iriscall.be', 'IrisCall');
                        $mail->setSubject($subject);
                        $mail->setTo($email);
                        $sent = $mail->send();
                        echo $msg;
                        if($sent == 1){
                            $temp['order_info_id'] = $orders['order_info_id'];
                            $temp['action'] = $action;
                            $temp['comment'] = $comment;
                            $temp['sent_by'] = 'Cron Job';
                            $temp['created_at'] = $execution_time;
                        }
                        array_push($order_info_meta, $temp);
                    }
                }
                CronHelper::cronDataInsert('order_info_meta', $order_info_meta);
                CronHelper::addCronLogs(1, 'Total '.count($order_info_meta).' reminder sent.', '', 1, null, null);
            }else{
                CronHelper::addCronLogs(1, 'Could not find any pending payment invoice.', '', 0, null, null);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * update from_number in cdr_info
    */
    public function actionGetFromNumber(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        try {
            $cdr_data = Yii::app()->db->createCommand()
                ->select('distinct(from_id)')
                ->from('cdr_info')
                ->Where('from_id!=:fi',[':fi'=>''])
                //->andWhere('from_number=:fn',[':fn'=>''])
                ->queryAll();
            //echo "<pre>";print_r($cdr_data);die;
            $res_data = [];
            if(!empty($cdr_data)){
                foreach ($cdr_data as $data){
                    $from_id = $data['from_id'];
                    $from_numer = '';
                    $token = base64_encode(Yii::app()->params['cdr_username'].":".Yii::app()->params['cdr_password']);
                    try{
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://rest.pbx.mytelephony.eu/identity/".$from_id,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 90000,
                            CURLOPT_SSL_VERIFYPEER=>false,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => array(
                                "Authorization: Basic ".$token
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        $response = json_decode($response);
                        if(!empty($response)){
                            $resource_number = '';
                            if(isset($response->cli)){
                                $identity_number = explode("/",$response->cli);
                                $resource_number = end($identity_number);
                            }
                        }else{
                            $resource_number = '';
                        }
                        if(!empty($resource_number)){
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => "https://rest.pbx.mytelephony.eu/resource/".$resource_number,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 999990,
                                CURLOPT_SSL_VERIFYPEER=>false,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "GET",
                                CURLOPT_HTTPHEADER => array(
                                    "Authorization: Basic ".$token
                                ),
                            ));
                            $response = curl_exec($curl);
                            curl_close($curl);
                            $response = json_decode($response);
                            if(!empty($response)){
                                $from_numer = $response->number;
                            }
                        }
                        $res = [
                            'status' => 1,
                            'message' => 'Fetch from number completed.'
                        ];
                    }catch(Exception $e){
                        $error = $e->getMessage();
                        print_r($error);die;
                        $res = [
                            'status' => 0,
                            'message' => $error
                        ];
                    }
                    try{
                        CallDataRecordsInfo::model()->updateAll(array('from_number' => $from_numer), 'from_id=:from_id AND from_number=:from_number',array(':from_id'=>$from_id,'from_number'=>''));
                        $res = [
                            'status' => 1,
                            'message' => "<div align='center'><h3 style='color: green; margin-bottom: 0'>Call Data Records added successfully!!</h3></div>"
                        ];
                    }catch (Exception $e){
                        $error = $e->getMessage();
                        echo "<pre>";print_r($from_id);
                        print_r($error);die;
                        $res = [
                            'status' => 0,
                            'message' => $error
                        ];
                    }
                }
            }
            $res_data = $res;
            echo '<pre>';print_r($res_data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function actionCostCalculate(){
        $cdr_data = $model=CallDataRecordsInfo::model()->findAll();
        $ar = [];
        set_time_limit(1000);
        $data =[];
        foreach ($cdr_data as $cdr){
            $model = CallDataRecordsInfo::model()->findByPk($cdr['id']);
            $tonumber = $cdr['to_number'];
            $diff = strtotime($cdr['end_time']) - strtotime($cdr['start_time']);
            $total_time = $diff;
            $fromnumber = $cdr['from_number'];
            $cost_calculate = $this->calculateCost($tonumber,$total_time,$fromnumber);
            //echo "<pre>";print_r($cost_calculate);die;
            if($total_time <= 0){
                $comment = '-';
            }else{
                $comment = $cost_calculate['comment'];
            }
            $model['unit_cost'] = $cost_calculate['cost'];
            $model['comment'] = $comment;
            $model->save(false);
        }
        $res = [
            'status' => 1,
            'message' => "<div align='center'><h3 style='color: green; margin-bottom: 0'>Cost calculation completed.</h3></div>"
        ];

        echo '<pre>';print_r($res);
        //echo json_encode($res);
    }

    /**
     * @param $tonumber
     * @param $totaltime
     */
    function calculateCost($tonumber,$totaltime,$fromnumber){
        $prefix_start_char = substr($tonumber, 0, 2);
        $to_strlen_prefix = strlen($tonumber);
        $from_strlen_prefix = strlen($fromnumber);

        $cost_rules = Yii::app()->db->createCommand("SELECT * FROM `cdr_cost_rules` where digit = ".$to_strlen_prefix." or from_number_digit = ".$from_strlen_prefix." or start_with = SUBSTRING($tonumber,0,LENGTH(start_with)) and from_number_start_with = SUBSTRING($tonumber,0,LENGTH(from_number_start_with)) ORDER BY start_with asc");
        $cost_rules = $cost_rules->queryAll();

        $cost = '0.00';
        $comment = '-';
        foreach ($cost_rules as $rule){
            if($to_strlen_prefix == $rule['digit'] && $from_strlen_prefix == $rule['from_number_digit'] && $rule['from_number_start_with'] == substr($fromnumber, 0, strlen($rule['from_number_start_with']))){
                if(!empty($rule['from_number_digit']) && !empty($rule['from_number_start_with']) && !empty($rule['digit'])) {
                    if($rule['from_number_digit'] == $from_strlen_prefix && $rule['from_number_start_with'] == substr($fromnumber, 0, strlen($rule['from_number_start_with'])) && $rule['digit'] == $to_strlen_prefix){
                        $cost = $rule['cost'];
                        $comment = $rule['comment'];
                    }
                }
            } else if($to_strlen_prefix == $rule['digit']){
                if(empty($rule['from_number_digit']) && empty($rule['start_with'])){
                    $cost = $rule['cost'];
                    $comment = $rule['comment'];
                }if(empty($rule['from_number_digit']) && !empty($rule['start_with'])){
                    if($rule['start_with'] == substr($tonumber, 0, strlen($rule['start_with']))){
                        $cost = $rule['cost'];
                        $comment = $rule['comment'];
                    }
                }if(!empty($rule['from_number_digit']) && empty($rule['start_with'])) {
                    if($rule['from_number_digit'] == $from_strlen_prefix){
                        $cost = $rule['cost'];
                        $comment = $rule['comment'];
                    }
                }
            }
        }
        $result = array('cost'=>round($cost,3),'comment'=>$comment);
        return $result;
    }
}
