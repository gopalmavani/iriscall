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
                $payment_reminder = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('order_info_meta')
                            ->where('order_info_id=:order_id', array(':order_id' => $orders['order_info_id']))
                            ->order('id desc')
                            ->limit(1)
                            ->queryAll();
                if(empty($payment_reminder)){
                    $reminder = '1st Reminder';
                    $subject = 'Payment Reminder';
                    $action = '1st Reminder sent';
                    $comment = 'Total amount '.$orders['orderTotal'];
                    $msg = "1st Reminder sent to ".$email.",\n";
                }else{
                    $amount = $orders['orderTotal'] + 12.10;
                    if($payment_reminder[0]['action'] == '1st Reminder sent'){
                        $reminder = '2nd Reminder';
                        $subject = 'Second Reminder';
                        $action = '2nd Reminder sent';
                        $comment = 'Additional amount of Euro 12.10 added in invoice total '.$amount;
                        $msg = "2nd Reminder sent to ".$email.",\n";
                    }elseif($payment_reminder[0]['action'] == '2nd Reminder sent'){
                        $reminder = '3rd Reminder';
                        $subject = 'Third Reminder';
                        $action = '3rd Reminder sent';
                        $comment = 'Additional amount of Euro 12.10 added in invoice total '.$amount;
                        $msg = "3rd Reminder sent to ".$email.",\n";
                    }
                    $query = "update order_info, order_payment set order_info.orderTotal = $amount, order_info.netTotal = $amount, order_payment.total = $amount 
                            where order_info.order_info_id = $orders[order_info_id] and order_payment.order_info_id = $orders[order_info_id]";
                    Yii::app()->db->createCommand($query)->execute();
                }
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
                    $temp['created_at'] = $execution_time;
                }
                array_push($order_info_meta, $temp);
            }
            //echo '<pre>';print_r($order_info_meta);die;
            CronHelper::cronDataInsert('order_info_meta', $order_info_meta);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
