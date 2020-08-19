<?php
class Test extends CApplicationComponent
{
    public static function Getpendingwallets()
    {
        $wallet_table = Yii::app()->db->schema->getTable('wallet');
        if(!empty($wallet_table)){
            $pendingwallets = Wallet::model()->findAll(array("condition"=>"transaction_status = 0"));
            $number = count($pendingwallets);
            return $number;
        }
    }

    public static function Gettheme()
    {
        $theme = Yii::app()->db->createCommand()
            ->select('value')
            ->from('settings')
            ->where('user_id = '. Yii::app()->user->getId(). ' and settings_key = "theme"')
            ->order('id DESC')
            ->limit(1)
            ->queryAll();
        if($theme)
        {
            $themename = $theme[0]['value'].".min.css";
            return $themename;
        }
    }


    /**
     * @param $datetime
     * @param bool $full
     * @return string
     * counts how many hours or months or days ago when given datetime value.
     */
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

    /**
     * @param $to
     * @param $subject
     * @param $message
     * @param $from
     * Sends email..
     */
    public static function EmailAttachment($to,$subject,$message,$from,$content){
        $uid = md5(uniqid(time()));

        $filename = "invoice";
        $content = chunk_split(base64_encode($content));

        $headers = "From: ".$from." <".$from.">\r\n";
        $headers .= "Reply-To: ".$from."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        $headers .= "This is a multi-part message in MIME format.\r\n";
        $headers .= "--".$uid."\r\n";
        $headers .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $headers .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $headers .= $message."\r\n\r\n";
        $headers .= "--".$uid."\r\n";
        $headers .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n"; // use different content types here
        $headers .= "Content-Transfer-Encoding: base64\r\n";
        $headers .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
        $headers .= $content."\r\n\r\n";
        $headers .= "--".$uid."--";
        mail($to, $subject, $message, $headers);
    }


    /**
     * @param $to
     * @param $subject
     * @param $message
     * @param $from
     * sends normal email without attachment
     */
    public static function Email($to,$subject,$message,$from){
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:'.$from. "\r\n" .
            'Reply-To:'.$from. "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
    }
}