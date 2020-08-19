<?php

class NautilusController extends Controller
{
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'add'),
                'users' => array('*'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }


    public function actionFundRegistrationStep1(){;
        $header = getallheaders();
        if(isset($header['Token']) && $header['Token'] == '2ff9cddb-634c-ab4a-f11d-b795e25b579b'){
            $request = Yii::app()->request->getRawBody();
            $result = CJSON::decode($request);
            if(isset($result['user_id']) && isset($result['firstname_user1']) && isset($result['lastname_user1']) && isset($result['firstname_user2']) && isset($result['lastname_user2']) && isset($result['house_num']) && isset($result['street']) && isset($result['city']) && isset($result['postcode']) && isset($result['country']) && isset($result['agree_terms_conditions']) && isset($result['agree_risks']) && isset($result['agree_fund_source'])){
                $model = new NuRegistrations();
                $user = UserInfo::model()->findByAttributes(['email' => $result['user_id']]);
                $model->attributes = $result;
                $model->fullname_user1 = $model->firstname_user1." " .$model->middlename_user1 . " " .$model->lastname_user1;
                $model->fullname_user2 = $model->firstname_user2." " .$model->middlename_user2 . " " .$model->lastname_user2;
                $model->user_id = $user->user_id;
                $model->created_at = date('Y-m-d h:i:s');
                if ($model->validate()) {
                    if ($model->save()) {
                        if(empty($model->firstname_user2) && empty($model->middlename_user2) && empty($model->lastname_user2)){
                            $data = ["registration_id" => $model->id,"user_id" => $model->user_id,"user1" => $model->fullname_user1];
                        }else{
                            $data = ["registration_id" => $model->id,"user_id" => $model->user_id,"user1" => $model->fullname_user1,"user2" => $model->fullname_user2];
                        }
                        ApiResponse::json(true, 200, $data, "Saved successfully");
                    } else {
                        ApiResponse::json(false, 501, [], "Could not save this user");
                    }
                } else {
                    print_r($model->Errors);
                }
            }
            else{
                ApiResponse::json(false, 403, [], "Could not give proper data in body");
            }
        } else{
            ApiResponse::json(false, 401, [], "You are not authenticated,Please give proper token");

        }
    }

    public function actionFundRegistrationStep2(){;
        $header = getallheaders();
        if(isset($header['Token']) && $header['Token'] == '2ff9cddb-634c-ab4a-f11d-b795e25b579b'){
            $request = Yii::app()->request->getRawBody();
            $result = CJSON::decode($request);
            if(isset($result['registration_id']) && isset($result['user_id']) && isset($result['username']) && isset($result['path']) && isset($result['type'])){
                $model = new NuKyc();
                $user = UserInfo::model()->findByAttributes(['email' => $result['user_id']]);
                $model->attributes = $result;
                $model->user_id = $user->user_id;
                $model->created_at = date('Y-m-d h:i:s');
                if ($model->validate()) {
                    if ($model->save()) {
                        $data = ["registration_id" => $model->registration_id,"kyc_id" => $model->id];
                        ApiResponse::json(true, 200, $data, "Saved successfully");
                    } else {
                        ApiResponse::json(false, 501, [], "Could not save this user data");
                    }
                } else {
                    print_r($model->Errors);
                }
            }
            else{
                ApiResponse::json(false, 403, [], "Could not give proper data in body");
            }
        }else{
            ApiResponse::json(false, 401, [], "You are not authenticated,Please give proper token");

        }
    }


    public function actionFundRegistrationStep3(){;
        $header = getallheaders();
        if(isset($header['Token']) && $header['Token'] == '2ff9cddb-634c-ab4a-f11d-b795e25b579b'){
            $request = Yii::app()->request->getRawBody();
            $result = CJSON::decode($request);
            if(isset($result['user_id']) && isset($result['amount']) && isset($result['type'])){
                $model = new NuClientDepositWithdraw();
                $model->status = 0 ;//0 is for pending
                $user = UserInfo::model()->findByAttributes(['email' => $result['user_id']]);
                $model->attributes = $result;
                $model->user_id = $user->user_id;
                $model->created_at = date('Y-m-d h:i:s');
                if ($model->validate()) {
                    if ($model->save()) {
                        $data = ["amount" => $model->amount,"status" => $model->status];
                        ApiResponse::json(true, 200, $data, "Saved successfully");
                    } else {
                        ApiResponse::json(false, 501, [], "Could not save this user data");
                    }
                } else {
                    ApiResponse::json(false, 401, [], "Error in modal");
                }
            }
            else{
                ApiResponse::json(false, 403, [], "Could not give proper data in body");
            }
        }else{
            ApiResponse::json(false, 401, [], "You are not authenticated,Please give proper token");

        }
    }
}