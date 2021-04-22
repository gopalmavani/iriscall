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
            $order_info_id = Yii::app()->db->createCommand()
                            ->select('order_info_id')
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
                    $amount = $orders['orderTotal'] + 12.10;
                    $current_date = date('Y-m-d');
                    $reminder_1_date = date('Y-m-d', strtotime($orders['invoice_date'].' + 7 days'));
                    $reminder_2_date = date('Y-m-d', strtotime($reminder_1_date.' + 7 days'));
                    $reminder_3_date = date('Y-m-d', strtotime($reminder_2_date.' + 5 days'));
                    if($reminder_1_date == $current_date){
                        $reminder = '1st Reminder';
                        $subject = 'Payment Reminder';
                        $action = '1st Reminder sent';
                        $comment = 'Total amount '.$orders['orderTotal'];
                        $msg = "1st Reminder sent to ".$email.",\n";
                    }elseif($reminder_2_date == $current_date){
                        $reminder = '2nd Reminder';
                        $subject = 'Second Reminder';
                        $action = '2nd Reminder sent';
                        $comment = 'Additional amount of Euro 12.10 added in invoice total '.$amount;
                        $msg = "2nd Reminder sent to ".$email.",\n";
                        $query = "update order_info, order_payment set order_info.orderTotal = $amount, order_info.netTotal = $amount, order_payment.total = $amount 
                                where order_info.order_info_id = $orders[order_info_id] and order_payment.order_info_id = $orders[order_info_id]";
                        Yii::app()->db->createCommand($query)->execute();
                    }elseif($reminder_3_date == $current_date){
                        $reminder = '3rd Reminder';
                        $subject = 'Third Reminder';
                        $action = '3rd Reminder sent';
                        $comment = 'Additional amount of Euro 12.10 added in invoice total '.$amount;
                        $msg = "3rd Reminder sent to ".$email.",\n";
                        $query = "update order_info, order_payment set order_info.orderTotal = $amount, order_info.netTotal = $amount, order_payment.total = $amount 
                                where order_info.order_info_id = $orders[order_info_id] and order_payment.order_info_id = $orders[order_info_id]";
                        Yii::app()->db->createCommand($query)->execute();
                    }
                    if(!empty($reminder) && !empty($subject)){
                        $mail = new YiiMailer('reminder', [
                            'reminder' => $reminder,
                            'orders' => $orders,
                        ]);
                        $mail->setFrom('info@cbmglobal.io', 'Iriscall');
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
}
