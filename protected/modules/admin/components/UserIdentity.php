<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $username = $this->username;
        $password = $this->password;

        $user = SysUsers::model()->find(array('condition'=>"username = '$username'"));

        //echo "<pre>"; print_r($user); die;
        if (!empty($user)){
            $hashedPassword = md5($password);
            if($hashedPassword == $user->password){
                $this->setState('role', $user->auth_level);
                $this->setState('username', $user->username);
                $this->errorCode=self::ERROR_NONE;
            }else{
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
        }else{
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
        return !$this->errorCode;
    }

    /**
     * @return array
     */
    static function accessRules() {
        if(!isset(Yii::app()->user->role) or Yii::app()->user->role == 'user') {
            return array(
                array('allow',
                    'actions' => array('login','error'),
                    'users' => array('*')
                ),
                array('deny')
            );
        }
        $action = Yii::app()->controller->uniqueid;
        $accessRules = array(
            array('allow', // allow authenticated user to perform 'create' action
                'actions' => array('error'),
                'users' => array('*'),
            )
        );

        switch ($action) {
            case 'sysUsers':
                array_push($accessRules, array('deny',
                    'expression' => '$user->role!="superAdmin"'
                ));
                array_push($accessRules, array('deny',
                    'expression' => '$user->role!="superAdmin"'
                ));
                break;
            case 'userInfo':
                array_push($accessRules, array('deny',
                    'actions' => array('create', 'update', 'delete', 'changePassword'),
                    'expression' => '$user->role=="viewer"'
                ));
                array_push($accessRules, array('deny',
                    'actions' => array('delete', 'changePassword'),
                    'expression' => '$user->role=="editor"'
                ));
                break;
            case 'productInfo':
            case 'categories':
            case 'orderInfo':
            case 'orderCreditMemo':
            case 'wallet':
            case 'walletTypeEntity':
            case 'walletMetaEntity':
                array_push($accessRules, array('deny',
                    'actions' => array('create', 'update', 'delete'),
                    'expression' => '$user->role=="viewer"'
                ));
                array_push($accessRules, array('deny',
                    'actions' => array('delete'),
                    'expression' => '$user->role=="editor"'
                ));
                break;
        }

        return $accessRules;
    }


    public static function newaccessRules(){
        if(!isset(Yii::app()->user->role)) {
            Yii::app()->request->redirect('../../home/login');
        }
        else{
            $role = Yii::app()->user->role;
            $controllerarray  =explode("/",Yii::app()->controller->uniqueid);
            $controller = $controllerarray[1];

            $check = Yii::app()->db->createCommand("SELECT allowed_actions FROM role_mapping WHERE `controller` = '$controller' AND `role` = '$role'" )->queryAll();
            if(!empty($check)){
                $id = array();
                foreach ($check as $key=>$value){
                    array_push($id,$value['allowed_actions']);
                }
                $Id = implode(',',$id);
                $denyId = Yii::app()->db->createCommand("SELECT * FROM action_list WHERE id NOT IN "."($Id)")->queryAll();
                if(!empty($denyId)){
                    $actions = array();
                    foreach ($denyId as $key=>$value){
                        array_push($actions,strtolower($value['action']));
                    }
                    /*echo "<pre>";
                    print_r($actions);die;*/
                    $action = "'".implode("','",$actions)."'";
//                                echo $action;die;


                    $currentaction = Yii::app()->controller->action->id;
                    $newcuraction = "'$currentaction'";
                    $actions = explode(",",$action);
                    foreach($actions as $key=>$value){
                        if($value == $newcuraction){
                            Yii::app()->request->redirect(Yii::app()->createUrl('/admin/home/expired'));
                        }
                    }

                    $accessRules = array(
                        array('deny', // deny user of actions which are not in allowed actions in database(action_list)
                            'actions' => $actions,
                        )
                    );
                }
                else{
                    $accessRules = array(
                        array('allow', // allow authenticated user to perform 'create' action
                            'actions' => array('error'),
                            'users' => array('*'),
                        )
                    );
                }

            }
            else{
                $accessRules = array(
                    array('allow', // allow authenticated user to perform 'create' action
                        'actions' => array('error'),
                        'users' => array('*'),
                    )
                );
            }
            return $accessRules;

        }
    }
}