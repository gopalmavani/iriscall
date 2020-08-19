<?php
class UserHelper extends CApplicationComponent{
    public static function performLogout(){
        $userId = Yii::app()->user->id;
        $user = UserInfo::model()->findByPk($userId);
        $user->api_token = null;
        $user->update('false');

        Yii::app()->user->logout();
    }
}
?>