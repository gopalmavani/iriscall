<?php

class UserController extends Controller
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

	/**
	* Displays a particular model.
	* retuern json data for given parameter.
	*/
	public function actionView()
	{
		$request = Yii::app()->request->getRawBody();
		$result = CJSON::decode($request);

		$arr = array();
		foreach ($result as $key => $res) {
			if ($res && $key != "start_date" && $key != "end_date") {
				$arr[$key] = $res;
			}
		}

		$from = $result['start_date']." 00:00:00";
		$to = $result['end_date']." 23:59:59";

		if ($from === '1970-01-01' && $to != '1970-01-01' || $from != '1970-01-01' && $to === '1970-01-01'){
			ApiResponse::json(true, 501, [], "Please Enter Date Range Correctly");
		} else {

			if ($arr && $from === '1970-01-01' && $to === '1970-01-01') {
			$models = UserInfo::model()->findAllByAttributes($arr);
			} elseif ($from != '1970-01-01' && $to != '1970-01-01' & $arr) {
			$criteria = new CDbCriteria();
			$criteria->addBetweenCondition('created_at', ($from), ($to), 'AND');
			$models = UserInfo::model()->findAllByAttributes($arr, $criteria);
			}elseif (!$arr && $from != '1970-01-01' && $to != '1970-01-01') {
			$criteria = new CDbCriteria();
			$criteria->addBetweenCondition('created_at', ($from), ($to), 'AND');
			$models = UserInfo::model()->findAllByAttributes($arr, $criteria);
			} else {
			$models = UserInfo::model()->findAll();
			}
			if ($models) {
			foreach ($models as $model) {
			$users[] = $model->attributes;
			}
			if ($users) {
			ApiResponse::json(true, 200, $users, "Total " . count($users) . " users fetched");
			} else {
			ApiResponse::json(false, 500, $users);
			}
			} else {
			ApiResponse::json(false, 500, [], "No records found for given parameter");
			}
		}
	}

	/**
	* This method is used by create new user,address,business
	* @return json array
	*/
	public function actionAdd()
	{
		$request = Yii::app()->request->getRawBody();
		$model = new UserInfo;
		$result = CJSON::decode($request);
		// call save users method
		$this->saveUsers($model, $result);
	}

	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id, 'UserInfo');
		$request = Yii::app()->request->getRawBody();

		// decode of json request data
		$result = CJSON::decode($request);

		// Call SaveUsers data for update
		$this->saveUsers($model, $result);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDelete($id)
	{
		if ($this->loadModel($id, 'UserInfo')->delete()) {
		$data = [
		"user_id" => $id
		];
			ApiResponse::json(true, 200, $data, "Successfully deleted");
		} else {
			ApiResponse::json(true, 404, [], "The requested page does not exist.");
		}
	}

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		try {
			$users = UserInfo::model()->findAll();
			ApiResponse::json(true, 200, $users, count($users) . " users fetched");
		} catch (Exception $e) {
			ApiResponse::json(false, 500, $users);
		}
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model = new UserInfo('search');
		$model->unsetAttributes();  // clear any default values
			if (isset($_GET['UserInfo']))
				$model->attributes = $_GET['UserInfo'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer $id the ID of the model to be loaded
	* @param string $modelName the Name of the model to be loaded
	* @return UserInfo the loaded model
	* @throws CHttpException
	*/
	public function loadModel($id, $modelName)
	{
		$model = $modelName::model()->findByPk($id);
			if ($model === null) {
				ApiResponse::json(false, 404, [], "The requested page does not exist.");
				exit;
			}
		return $model;
	}

	/**
	* This method is using $userId to get all user data with user personal addresses and business addressess
	* @param $userId
	* @return array
	*/
	protected function getUserData($userId)
	{
		$userModel = $this->loadModel($userId, 'UserInfo');
		$usersArray = $userModel->attributes;
		// get all rows match to userId in 'addresses_mapping' table
		return $usersArray;
	}

	/**
	* This function update and create user,
	* json decode data pass in $request
	* @param $model
	* @param $request
	* @return json array
	*/
	protected function saveUsers($model, $request)
	{
		try {
			$model->attributes = $request;
			$model->created_at = date('Y-m-d h:i:s');
			$model->modified_at = date('Y-m-d h:i:s');
			// Save user-data using UserInfo object
			$timestamp = date("d-m-Y", strtotime($request['date_of_birth']));
			$model->date_of_birth = $timestamp;
			$fullName = $request['first_name'] . " " . $request['last_name'];
			$model->full_name = $fullName;
			$errors['email'] = ValidationHelper::ValidateEmail($model->email);
			$errors['dob'] = ValidationHelper::ValidateDOB($model->date_of_birth);
			$errors['phone'] = ValidationHelper::ValidatePhoneNumber($model->phone);
			$errors['business_phone'] = ValidationHelper::ValidatePhoneNumber($model->business_phone);

			$error = array();
			foreach ($errors as $err) {
				if ($err) {
					$error[] = $err;
				}
			}

			if ($error) {
				print_r($error);
			} else {
				$model->date_of_birth = date('Y-m-d',strtotime(str_replace('-','/', $model->date_of_birth)));
				if ($model->validate()) {
					if ($model->save()) {
						$data = ["user_id" => $model['user_id']];
						ApiResponse::json(true, 200, $data, "Saved successfully");
					} else {
						ApiResponse::json(false, 501, [], "Could not save model");
					}
				} else {
					print_r($model->Errors);
				}
			}

		} catch (Exception $e) {
			ApiResponse::json(false, 500, [], $e->getMessage());
		}
	}

    /**
     * This method is used to login
     */
    public function actionLogin()
    {
        $header = getallheaders();
        if($header['Token'] == '2ff9cddb-634c-ab4a-f11d-b795e25b579b') {
            $model = new LoginForm;
            $request = Yii::app()->request->getRawBody();
            $result = CJSON::decode($request);
            if (isset($result)) {
                $model->username = $result['username'];
                $model->password = $result['password'];

                Yii::app()->session['userid'] = md5($model->password);
                // validate user input and redirect to the previous page if valid
                if ($model->login()) {
                    $user = UserInfo::model()->findByAttributes(['email' => $model->username, 'password' => md5($model->password)]);
                    $token = rand(pow(10, 13), pow(10, 14) - 1);
                    $user->token = $token;
                    //$user->token_expired_at = date( "Y-m-d H:i:s", strtotime( "+4 hours" ));
                    $user->save(false);
                    ApiResponse::json(true, 200, ["token" => $token, 'user_details' => $user], "User logged in successfully");
                } else {
                    ApiResponse::json(false, 404, [], "Incorrect username or password");
                }
            }
            else{
                ApiResponse::json(false, 403, [], "Could not give proper data in body");
            }
        }
        else{
            ApiResponse::json(false, 401, [], "You are not authenticated");

        }
    }

    /*
     * Auto logout from SSO
     * */
    public function actionAutoLogout(){
        try {
            $rawBody = Yii::app()->request->rawBody;
            $requestArray = json_decode($rawBody, true);
            if(isset($requestArray['token'])){
                $userObject = UserInfo::model()->findByAttributes(['api_token'=> $requestArray['token']]);
                if(isset($userObject->user_id)) {
                    $userObject->api_token = null;
                    $userObject->save(false);
                }
                $response['status'] = 1;
                $response['message'] = 'Token invalidated successfully.';
            } else {
                $response['status'] = 0;
                $response['message'] = 'Token not provided.';
            }
        } catch (Exception $e){
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }
        echo json_encode($response);
    }

    /*
     * Provide user details to SIO
     * */
    public function actionGetUser(){
        try {
            $rawBody = Yii::app()->request->rawBody;
            $requestArray = json_decode($rawBody, true);
            if(isset($requestArray['email'])){
                $userObject = UserInfo::model()->findByAttributes(['email'=> $requestArray['email']]);
                $userPayoutObject = UserPayoutInfo::model()->findByAttributes(['user_id'=>$userObject->user_id]);
                $data['userInfo'] = $userObject->attributes;
                unset($data['userInfo']['user_id']);
                if(isset($userPayoutObject->id))
                    $data['payoutInfo'] = $userPayoutObject->attributes;
                $response['data'] = SSOHelper::modifyDataWRTSSOForLogin($data);
                $response['status'] = 1;
                $response['message'] = 'User data';
            } else {
                $response['status'] = 0;
                $response['message'] = 'User data not found.';
            }
        } catch (Exception $e){
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }
        echo json_encode($response);
    }

    /*
     * Auto Update from SSO
     * */
    public function actionUpdateUser(){
        try {
            $rawBody = Yii::app()->request->rawBody;
            $requestArray = json_decode($rawBody, true);
            $userRequestArray = SSOHelper::modifyPostDataWRTCBM($requestArray['user_info']);
            $userPayoutRequestArray = SSOHelper::modifyPostDataWRTCBM($requestArray['payout_info']);
            if(isset($requestArray['token'])){
                $userObject = UserInfo::model()->findByAttributes(['api_token'=> $requestArray['token']]);
                if(isset($userObject->user_id)) {
                    $userObject->attributes = $userRequestArray;
                    $userObject->modified_at = date('Y-m-d H:i:s');
                    $userObject->save(false);

                    $userPayout = UserPayoutInfo::model()->findByAttributes(['user_id'=>$userObject->user_id]);
                    if(isset($userPayout->id)){
                        //unset user id from array
                        unset($userPayoutRequestArray['user_id']);
                        $userPayout->attributes = $userPayoutRequestArray;
                        $userPayout->modified_at = date('Y-m-d H:i:s');
                        $userPayout->save(false);
                    } else {
                        $userPayout = new UserPayoutInfo();
                        $userPayout->attributes = $userPayoutRequestArray;
                        $userPayout->created_at = date('Y-m-d H:i:s');
                        $userPayout->save(false);
                    }
                    $response['status'] = 1;
                    $response['message'] = 'User was updated successfully.';
                } else {
                    $response['status'] = 0;
                    $response['message'] = 'Kindly re-login.';
                }
            } else {
                $response['status'] = 0;
                $response['message'] = 'Token not provided.';
            }
        } catch (Exception $e){
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }
        echo json_encode($response);
    }

    /*
     * Auto Update Password from SSO
     * */
    public function actionUpdateUserPassword(){
        try {
            $rawBody = Yii::app()->request->rawBody;
            $requestArray = json_decode($rawBody, true);
            if(isset($requestArray['token'])){
                $userObject = UserInfo::model()->findByAttributes(['api_token'=> $requestArray['token']]);
                if(isset($userObject->user_id)) {
                    $userObject->password = md5($requestArray['password']);
                    $userObject->modified_at = date('Y-m-d H:i:s');
                    $userObject->save(false);
                }
                $response['status'] = 1;
                $response['message'] = 'User password was updated successfully.';
            } else {
                $response['status'] = 0;
                $response['message'] = 'Token not provided.';
            }
        } catch (Exception $e){
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }
        echo json_encode($response);
    }
}