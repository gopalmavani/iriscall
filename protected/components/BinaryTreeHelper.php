<?php
/**
 * Created by PhpStorm.
 * User: Sagar
 * Date: 1/12/2017
 * Time: 6:59 PM
 */

class BinaryTreeHelper extends CApplicationComponent{

    static function GetParentTrace($userId, $noOfParents)
    {
        $search = $userId;
        $level = 1;
        $parents = [];
        for($level;$level <= $noOfParents;$level++) {
            $sponsor = UserInfo::model()->findByPk(['sponsor_id' => $search]);
            if(!empty($sponsor)) {
                $parents[] = [
                    'level' => $level,
                    'userId' => $sponsor->sponsor_id
                ];
                $search = $sponsor->sponsor_id;
            }
        }
        return CJSON::encode($parents);
    }
}