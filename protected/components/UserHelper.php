<?php
class UserHelper extends CApplicationComponent{

    public static function performLogout(){
        $userId = Yii::app()->user->id;
        $user = UserInfo::model()->findByPk($userId);
        $user->api_token = null;
        $user->update('false');

        Yii::app()->user->logout();
    }

    public static function deleteFiles($target){
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                UserHelper::deleteFiles($file);
            }

            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }
}
?>