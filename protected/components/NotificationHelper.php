<?php

require __DIR__ .'/../../vendor/autoload.php';

class NotificationHelper
{
    public static function AddNotitication($title, $body, $notiticationType, $sender, $isAdmin,$url,$date='') {
        $notitication =  new NotificationManager();
        $notitication->title_html = $title;
        $notitication->body_html = $body;
        $notitication->type_of_notification = $notiticationType;
        $notitication->sender_Id = $sender;
        $notitication->isAdmin = $isAdmin;
        $notitication->url = $url;
        $notitication->is_unread = 1;
        $notitication->is_delete = 0;
        if($date == ''){
            $notitication->created_at = date('Y-m-d H:i:s');
        } else {
            $notitication->created_at = $date;
        }
        if ($notitication->save()){
            return $notitication->id;
        } else{
            return $notitication->getErrors();
        }

    }

    public static function ShowNotitication() {
        $notitication =  NotificationManager::model()->findAll(array('order' => 'created_at desc','condition' => 'is_delete = 0'));
        return $notitication;
    }

    public static function ShowNotiticationLimit() {
        $notitication =  NotificationManager::model()->findAll(array('order' => 'created_at desc','condition' => 'is_delete = 0 AND type_of_notification = "general"','limit' => 20));
        return $notitication;
    }

    public static function ShowNotiticationVpamm() {
        $notitication =  NotificationManager::model()->findAll(array('order' => 'created_at desc','condition' => 'is_delete = 0 AND type_of_notification = "deposit"','limit' => 20));
        return $notitication;
    }


    public static function ShowNotiticationUserName($id) {
        $userName = UserInfo::model()->findByAttributes(['user_id' => $id]);
        return $userName->full_name;
    }

    public static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function getNewNotification(){
        $notiticationCount =  NotificationManager::model()->findAll(array('condition' => 'is_unread = 1 AND is_delete = 0'));
        return count($notiticationCount);
    }

    //Pusher functionality
    public static function pusherNotification($message,$date,$url,$order_info_id,$username,$userid,$amount,$nid){
        $options = array(
            'cluster' => 'ap2',
            'encrypted' => true
        );
        $pusher = new Pusher\Pusher(
            Yii::app()->params['NotificationAuthKey'],
            Yii::app()->params['NotificationSecretKey'],
            Yii::app()->params['NotificationAppId'],
            $options
        );
        $data['type'] = 'order';
        $data['message'] = $message;
        $data['url'] = $url;
        $data['userInfoUrl'] = Yii::app()->createUrl('admin/userInfo/view/'.$userid);
        $data['order_info_id'] = $order_info_id;
        $data['username'] = $username;
        $data['userid'] = $userid;
        $data['amount'] = $amount;
        $data['date'] = NotificationHelper::time_elapsed_string($date);
        $data['nid'] = $nid;
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    //Pusher functionality
    public static function pusherNotificationVpamm($message,$date,$url,$userid,$username,$amount,$nid){
        $options = array(
            'cluster' => 'ap2',
            'encrypted' => true
        );
        $pusher = new Pusher\Pusher(
            Yii::app()->params['NotificationAuthKey'],
            Yii::app()->params['NotificationSecretKey'],
            Yii::app()->params['NotificationAppId'],
            $options
        );

        $data['type'] = 'vpamm';
        $data['message'] = $message;
        $data['url'] = $url;
        $data['accountInfoUrl'] = Yii::app()->createUrl('admin/mt4/view/'.$userid);
        $data['emails'] = $username;
        $data['login'] = $userid;
        $data['amount'] = $amount;
        $data['nid'] = $nid;
        $data['date'] = NotificationHelper::time_elapsed_string($date);
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}