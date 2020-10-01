<?php

class HomeController extends Controller
{
    public $layout = 'main';
    public $defaultAction = 'index';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),

            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions' => array('login', 'signup'),
                'users' => array('@'),
                'redirect' => array('home/login'),
            ),
        );
    }

    protected function beforeAction($action)
    {
        //Action that needs to be allowed before signing up
        $allowedActionArr = ['login', 'signup', 'registrationStepOne', 'registrationStepEmailVerification', 'registrationStepOneDemo',
            'registrationStepOneInitial', 'verifyEmail', 'completeDemo', 'activation', 'createUserSignup', 'checkEmail', 'jiraWebhook', 'autologin', 'index'];
        if (Yii::app()->user->isGuest && !in_array($action->id, $allowedActionArr)) {
            $this->redirect(Yii::app()->createUrl('home/login'));
        }
        return parent::beforeAction($action);
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $this->layout = 'newlogin';
        $model = new LoginForm;

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            Yii::app()->session['userid'] = md5($model->password);
            // validate user input and redirect to the previous page if valid
            if ($model->validate()) {
                $user = UserInfo::model()->findByAttributes(['email' => $model->username]);
                if ($user->is_active == 1) {
                    if ($model->login()) {

                        //Set session for current Login
                        /*$account_login = CbmAccounts::model()->findByAttributes(['email_address'=>$user->email], ['order' => 'registration_date']);
                        if(isset($account_login->login))
                            $_SESSION['loginId'] = $account_login->login;*/

                        $registration_status = RegistrationStatus::model()->findAllByAttributes(['user_id' => $user->user_id]);
                        $arr_size = sizeof($registration_status);
                        if ($arr_size == 0) {
                            $this->redirect('landing');
                        } elseif ($arr_size == 1) {
                            $status_record = $registration_status[0];
                            $max_step = Yii::app()->db->createCommand()
                                ->select('max(step_number) as step_number')
                                ->from('registration_steps')
                                ->where('product_id=:pId', [':pId' => $status_record->product_id])
                                ->queryRow();
                            if ($status_record->step_number >= $max_step['step_number']) {
                                $this->redirect('index');
                            } else {
                                $this->redirect('productIndex');
                            }
                        } elseif ($arr_size == 2) {
                            $this->redirect('producIndex');
                        } else {
                            $this->redirect('index');
                        }
                        $this->redirect('index');
                    }
                } else {
                    $this->render('login', array('model' => $model, 'error' => 'Your account is not active yet. Please activate it before logging it to the system.'));
                }
            } else {
                $this->render('login', array('model' => $model));
            }
        } else {
            // display the login form
            //$this->render('login', array('model' => $model));
            $sso_url = Yii::app()->params['SSO_URL'];
            $this->redirect($sso_url.'login?application='.Yii::app()->params['applicationName']);
        }
    }

    /*
     * Auto login process for SSO
     * */
    public function actionAutoLogin(){
        if(isset($_GET['token'])){
            $userEmail = $_GET['email'];
            $user = UserInfo::model()->findByAttributes(['email'=>$userEmail]);
            if(isset($user->user_id)){
                $user->api_token = $_GET['token'];
                $user->update('false');

                $model = new AutoLoginForm;
                $model->email = $user->email;
                if ($model->validate() && $model->login()) {
                    $this->redirect(array('home/index/'));
                } else {
                    $this->redirect(array('login'));
                }
            }
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        UserHelper::performLogout();
        //$this->redirect(Yii::app()->createUrl('home/login'));
        $sso_url = Yii::app()->params['SSO_URL'].'logout?application='.Yii::app()->params['applicationName'];
        $this->redirect($sso_url);
    }

    /*
     * Landing action to be called
     * when the user has just registered into the
     * system
     * **/
    public function actionLanding()
    {
        $this->render('landing');
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        //For generating graph in UTC format
        Yii::app()->db->createCommand("SET time_zone = '+1:00'")->execute();
        if(Yii::app()->user->isGuest){
            $this->layout = 'sioMain';
            $this->render('sioIndex');
        } else {
            if(isset($_GET['token'])){
                $userEmail = $_GET['email'];
                $user = UserInfo::model()->findByAttributes(['email'=>$userEmail]);
            } else {
                $userId = Yii::app()->user->id;
                $user = UserInfo::model()->findByPk($userId);
            }
            $notificationArr = [];

            //Voucher notification module
            $available_vouchers = VoucherHelper::getAvailableVouchers($user->email);
            foreach ($available_vouchers as $voucher){
                $temp = array();
                $temp['type'] = 'success';
                $temp['notification'] = "Congratulations! You have a voucher <strong>". $voucher['voucher_code'] ."</strong> of ".$voucher['value']." ".$voucher['type'].".";
                array_push($notificationArr, $temp);
            }

            //License notification module
            $userLicense = CbmUserLicenses::model()->findByAttributes(['email'=> $user->email]);
            if(isset($userLicense->available_licenses)){
                $available_licenses = $userLicense->available_licenses;
                $total_licenses = $userLicense->total_licenses;
            } else {
                $available_licenses = 0;
                $total_licenses = 0;
            }
            if(isset($userLicense->available_licenses) && ($userLicense->available_licenses == 0)){
                $cbmUserAccounts = Yii::app()->db->createCommand()
                    ->select('count(*) as cnt')
                    ->from('cbm_user_accounts')
                    ->where('email_address=:ea',[':ea'=>$user->email])
                    ->andWhere('matrix_node_num is null')
                    ->queryRow();
                if($cbmUserAccounts['cnt'] > 0){
                    $temp = array();
                    $temp['type'] = 'warning';
                    $temp['notification'] = "Warning! Not enough licenses to place all nodes!";
                    $temp['href'] = Yii::app()->createUrl('product/index');
                    $temp['a_text'] = "Buy Licenses!";
                    array_push($notificationArr, $temp);
                }
            }

            //Level One and two child count
            $levelOneChild = Yii::app()->db->createCommand()
                ->select('user_id')
                ->from('user_info')
                ->where('sponsor_id=:sId', [':sId'=>$user->user_id])
                ->queryColumn();
            $levelOneChildCount = count($levelOneChild);
            $levelTwoChild = Yii::app()->db->createCommand()
                ->select('user_id')
                ->from('user_info')
                ->where(['in', 'sponsor_id', $levelOneChild])
                ->queryColumn();
            $levelTwoChildCount = count($levelTwoChild);

            //All trading product data
            //Total Earnings
            $total_earnings = WalletHelper::getUserWalletEarnings($user->user_id);

            $isWalletNormalizationOngoing = Yii::app()->params['IsWalletNormalizationOngoing'];
            $this->render('index', [
                'user_id' => $user->user_id,
                'country' => $user->country,
                'custom_notifications' => $notificationArr,
                'isWalletNormalizationOngoing' => $isWalletNormalizationOngoing,
                'levelOneChildCount' => $levelOneChildCount,
                'levelTwoChildCount' => $levelTwoChildCount,
                'totalEarnings' => $total_earnings,
                'availableLicenses' =>$available_licenses,
                'totalLicenses' =>$total_licenses
            ]);
        }
    }

    public function actionCreateUserSignup(){
        $this->layout = false;
        $model = new UserInfo;
        $sioData = 0;
        $apiToken = null;

        if(isset($_SESSION['verified_email'])){
            $model->email = $_SESSION['verified_email'];
            unset($_SESSION['verified_email']);
        }

        if(isset($_SESSION['user_present_in_sso'])){
            $sso_url = Yii::app()->params['SSO_URL'];
            $sso_response = CurlHelper::executeAction($sso_url.'api/verifyPortalToken',['portal_token'=>$_SESSION['user_present_in_sso']], "POST");
            if(!is_null($sso_response['success_response'])){
                $sso_success_response = $sso_response['success_response'];
                $model->attributes = SSOHelper::modifyPostDataWRTCBM($sso_success_response['data']['user_info']);
                $sioData = 1;
                $apiToken = $sso_success_response['data']['user_info']['api_token'];
            }
        }
        if (!empty($_POST)) {
            $modified_data = SSOHelper::modifyPostDataWRTSSOForNewUser($_POST);
            if (isset($_SESSION['sponsor_id'])) {
                $id = $_SESSION['sponsor_id'];
                $modified_data['sponsor_id'] = $id;
                //Update to SSO
                $sso_url = Yii::app()->params['SSO_URL'];
                if($sioData == 0){
                    //create user
                    $user_response = CurlHelper::executeAction($sso_url."api/createUser", $modified_data, "POST");
                } else {
                    //update user
                    $modified_data['token'] = $apiToken;
                    $user_response = CurlHelper::executeAction($sso_url."api/updateUser", $modified_data, "POST");
                }
                if(!is_null($user_response['success_response']) && ($user_response['success_response']['status'] == 1)){
                    $model->attributes = $_POST['UserInfo'];
                    //$model->date_of_birth = date('Y-m-d', strtotime($_POST['UserInfo']['date_of_birth']));
                    //$model->date_of_birth = date('Y-m-d');
                    //$model->language = 'English';
                    if ($_POST['accountType'] == 'personal') {
                        $model->business_name = "";
                        $model->vat_number = "";
                        $model->busAddress_building_num = "";
                        $model->busAddress_street = "";
                        $model->busAddress_region = "";
                        $model->busAddress_city = "";
                        $model->busAddress_postcode = "";
                        $model->busAddress_country = "";
                    } else {
                        if (!empty($model->business_name)) {
                            if (isset($_POST['sameAddress'])) {
                                $model->busAddress_building_num = $_POST['UserInfo']['building_num'];
                                $model->busAddress_street = $_POST['UserInfo']['street'];
                                $model->busAddress_region = $_POST['UserInfo']['region'];
                                $model->busAddress_city = $_POST['UserInfo']['city'];
                                $model->busAddress_postcode = $_POST['UserInfo']['postcode'];
                                $model->busAddress_country = $_POST['UserInfo']['country'];
                            } else {
                                $model->busAddress_building_num = $_POST['UserInfo']['busAddress_building_num'];
                                $model->busAddress_street = $_POST['UserInfo']['busAddress_street'];
                                $model->busAddress_region = $_POST['UserInfo']['busAddress_region'];
                                $model->busAddress_city = $_POST['UserInfo']['busAddress_city'];
                                $model->busAddress_postcode = $_POST['UserInfo']['busAddress_postcode'];
                                $model->busAddress_country = $_POST['UserInfo']['busAddress_country'];
                            }
                        }
                    }
                    $model->setScenario('signUp');
                    $model->sponsor_id = $id;
                    $model->full_name = $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name;
                    $model->email = strtolower($_POST['UserInfo']['email']);
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->auth = $this->randomString(20);
                    $model->gender = $_POST['gender'];
                    $activationUrl = Yii::app()->createAbsoluteUrl('/home/activation?key=' . $model->auth);
                    if (isset($_POST['privacy'])) {
                        $model->terms_conditions = 1;
                    }
                    if (isset($_POST['notification-mail'])) {
                        $model->notification_mail = 1;
                    }
                    if (isset($_POST['market-mail'])) {
                        $model->marketting_mail = 1;
                    }
                    if ($model->save(false)) {

                        //$notification_channel = Yii::app()->params['SlackNotificationChannel'];

                        if (!empty($_POST['payout_bank'])) {
                            $payout = new UserPayoutInfo();
                            $payout->user_id = $model->user_id;
                            $payout->bank_name = $_POST['payout_bank'];
                            if (isset($_POST['payout_house'])) {
                                $payout->bank_building_num = $_POST['payout_house'];
                            }
                            if (isset($_POST['payout_street'])) {
                                $payout->bank_street = $_POST['payout_street'];
                            }
                            if (isset($_POST['payout_region'])) {
                                $payout->bank_region = $_POST['payout_region'];
                            }
                            if (isset($_POST['payout_city'])) {
                                $payout->bank_city = $_POST['payout_city'];
                            }
                            if (isset($_POST['payout_post'])) {
                                $payout->bank_postcode = $_POST['payout_post'];
                            }
                            if (isset($_POST['payout_country'])) {
                                $payout->bank_country = $_POST['payout_country'];
                            }
                            if (isset($_POST['payout_accountname'])) {
                                $payout->account_name = $_POST['payout_accountname'];
                            }
                            if (isset($_POST['payout_iban'])) {
                                $payout->iban = $_POST['payout_iban'];
                            }
                            if (isset($_POST['payout_biccode'])) {
                                $payout->bic_code = $_POST['payout_biccode'];
                            }
                            $payout->created_at = date('Y-m-d H:i:s');
                            if ($payout->validate()) {
                                $payout->save();
                            }
                        }
                        /*$mail = new YiiMailer('welcome', array('activationUrl' => $activationUrl));
                        //$mail->setFrom('info@micromaxcash.com', 'Micromaxcash');
                        $mail->setFrom('info@cbmglobal.io', 'CBM Global');
                        $mail->setSubject("Email Verification");
                        $mail->setTo($model->email);
                        $mail->send();*/

                        //Add to mailchimp list
                        if ($model->marketting_mail == 1) {
                            $address = $model->building_num . ", " . $model->street . ", " . $model->region . ", " . $model->city . ", " . ServiceHelper::getCountryNameFromId($model->country);
                            $curl = curl_init();
                            $url = Yii::app()->params['MailChimpURL'];
                            if ($model->language == "Dutch") {
                                $listId = Yii::app()->params['MailChimpDutchListId'];
                            } else {
                                $listId = Yii::app()->params['MailChimpEnglishListId'];
                            }
                            $authorization = Yii::app()->params['MailChimpAuthorizationId'];
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => $url . "lists/" . $listId . "/members",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => CJSON::encode([
                                    "email_address" => $model->email,
                                    "status" => "subscribed",
                                    "merge_fields" => ["FNAME" => $model->first_name,
                                        "LNAME" => $model->last_name,
                                        "ADDRESS" => $address,
                                        "PHONE" => $model->phone,
                                        "BIRTHDAY" => date('m/d', strtotime($model->date_of_birth))]
                                ]),
                                CURLOPT_HTTPHEADER => array(
                                    "authorization: " . $authorization,
                                    "cache-control: no-cache",
                                    "content-type: application/json"
                                ),
                            ));
                            $response = curl_exec($curl);
                            $err = curl_error($curl);
                            curl_close($curl);
                        }
                        //Add to CBM User License
                        ServiceHelper::modifyCBMUserLicenses($model->user_id, $model->email, 0, 0);

                        $loginForm = new LoginForm();
                        $this->layout = 'newlogin';
                        $this->render('login', [
                            'model' => $loginForm,
                            'id' => $model->sponsor_id,
                            'success' => 'We have sent a email verification link to your email address.'
                        ]);
                    } else {
                        $error = $model->getErrors();
                        $errorString = json_encode($error);

                        $logs = new CbmLogs();
                        $logs->status = 2;
                        $logs->created_date = date('Y-m-d H:i:s');
                        $logs->log = "Error while creating user: " . $errorString;
                        $logs->save(false); // saving logs

                        $this->render('signup', [
                            'model' => $model,
                            'id' => $id
                        ]);
                    }

                } else {
                    $loginForm = new LoginForm();
                    $this->layout = 'newlogin';
                    $this->render('login', [
                        'model' => $loginForm,
                        'success' => $user_response['success_response']['message']
                    ]);
                }
            }  else {
                $logs = new CbmLogs();
                $logs->status = 2;
                $logs->created_date = date('Y-m-d H:i:s');
                $logs->log = "Error while creating user: Sponsor Id not found";
                $logs->save(false); // saving logs
                $this->layout = 'newlogin';
                $loginForm = new LoginForm();
                $this->render('login', [
                    'model' => $loginForm,
                    'success' => 'Issue while creating the user. Kindly try after some time'
                ]);
            }
            unset($_SESSION['user_present_in_sso']);
        }else {
            $this->render('registration/stepOne', [
                'model' => $model,
                'sioData' => $sioData
            ]);
        }
    }

    public function actionSignup($id){
        $this->layout = false;
        $_SESSION['sponsor_id'] = $id;
        $model = new UserInfo;
        $sioData = 0;
        $apiToken = null;
        $model->phone = '';
        $this->render('registration/stepOne', [
            'model' => $model,
            'sioData' => $sioData,
            'accountType'=>'personal'
        ]);
    }

    public function actionRegistrationStepOneInitial(){
        $this->layout = false;
        $status = 0;
        if(isset($_GET['token'])){
            //Verify portal token with SSO
            $sso_url = Yii::app()->params['SSO_URL'];
            $portalToken = $_GET['token'];
            $sso_response = CurlHelper::executeAction($sso_url.'api/verifyPortalToken',['portal_token'=>$portalToken], "POST");
            if(!is_null($sso_response['success_response'])) {
                $sso_success_response = $sso_response['success_response'];
                if($sso_success_response['status'] == 1){
                    $status = 1;
                    $_SESSION['user_present_in_sso'] = $_GET['token'];
                    //$response['message'] = "Thank you for permitting us to use SIO details";
                } else {
                    $status = -1;
                }
            }
        }
        $this->render('registration/stepOneInitial', [
            'status' => $status,
        ]);
    }

    public function actionRegistrationStepOneDemo(){
        $this->layout = false;
        $this->render('registration/stepOneDemo');
    }

    public function actionRegistrationStepOne(){
        $this->layout = false;
        $model = new UserInfo;
        $sioData = 0;
        $apiToken = null;
        $model->phone = '';

        if(isset($_SESSION['verified_email'])){
            $model->email = $_SESSION['verified_email'];
            unset($_SESSION['verified_email']);
        }

        if(isset($_SESSION['user_present_in_sso'])){
            $sso_url = Yii::app()->params['SSO_URL'];
            $sso_response = CurlHelper::executeAction($sso_url.'api/verifyPortalToken',['portal_token'=>$_SESSION['user_present_in_sso']], "POST");
            if(!is_null($sso_response['success_response'])){
                $sso_success_response = $sso_response['success_response'];
                $model->attributes = SSOHelper::modifyPostDataWRTCBM($sso_success_response['data']['user_info']);
                $sioData = 1;
                $apiToken = $sso_success_response['data']['user_info']['api_token'];
            }
        }
        if (!empty($_POST)) {
            $modified_data = SSOHelper::modifyPostDataWRTSSOForNewUser($_POST);

            if (isset($_SESSION['sponsor_id'])) {
                $id = $_SESSION['sponsor_id'];
                $modified_data['sponsor_id'] = $id;
                //Update to SSO
                $sso_url = Yii::app()->params['SSO_URL'];
                if($sioData == 0){
                    //create user
                    $user_response = CurlHelper::executeAction($sso_url."api/createUser", $modified_data, "POST");
                } else {
                    //update user
                    $modified_data['token'] = $apiToken;
                    $user_response = CurlHelper::executeAction($sso_url."api/updateUser", $modified_data, "POST");
                }

                if(!is_null($user_response['success_response']) && ($user_response['success_response']['status'] == 1)){
                    $model->attributes = $_POST['UserInfo'];
                    $model->date_of_birth = date('Y-m-d', strtotime($_POST['UserInfo']['date_of_birth']));
                    if ($_POST['accountType'] == 'personal') {
                        $model->business_name = "";
                        $model->vat_number = "";
                        $model->busAddress_building_num = "";
                        $model->busAddress_street = "";
                        $model->busAddress_region = "";
                        $model->busAddress_city = "";
                        $model->busAddress_postcode = "";
                        $model->busAddress_country = "";
                    } else {
                        if (!empty($model->business_name)) {
                            if (isset($_POST['sameAddress'])) {
                                $model->busAddress_building_num = $_POST['UserInfo']['building_num'];
                                $model->busAddress_street = $_POST['UserInfo']['street'];
                                $model->busAddress_region = $_POST['UserInfo']['region'];
                                $model->busAddress_city = $_POST['UserInfo']['city'];
                                $model->busAddress_postcode = $_POST['UserInfo']['postcode'];
                                $model->busAddress_country = $_POST['UserInfo']['country'];
                            } else {
                                $model->busAddress_building_num = $_POST['UserInfo']['busAddress_building_num'];
                                $model->busAddress_street = $_POST['UserInfo']['busAddress_street'];
                                $model->busAddress_region = $_POST['UserInfo']['busAddress_region'];
                                $model->busAddress_city = $_POST['UserInfo']['busAddress_city'];
                                $model->busAddress_postcode = $_POST['UserInfo']['busAddress_postcode'];
                                $model->busAddress_country = $_POST['UserInfo']['busAddress_country'];
                            }
                        }
                    }
                    $model->setScenario('signUp');
                    $model->sponsor_id = $id;
                    $model->full_name = $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name;
                    //$model->password = md5($_POST['UserInfo']['password']);
                    $model->email = strtolower($_POST['UserInfo']['email']);
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->auth = $this->randomString(20);
                    $model->gender = $_POST['gender'];
                    $activationUrl = Yii::app()->createAbsoluteUrl('/home/activation?key=' . $model->auth);
                    if (isset($_POST['privacy'])) {
                        $model->terms_conditions = 1;
                    }
                    if (isset($_POST['notification-mail'])) {
                        $model->notification_mail = 1;
                    }
                    if (isset($_POST['market-mail'])) {
                        $model->marketting_mail = 1;
                    }
                    if ($model->save()) {

                        $notification_channel = Yii::app()->params['SlackNotificationChannel'];
                        if (!empty($_POST['payout_bank'])) {
                            $payout = new UserPayoutInfo();
                            $payout->user_id = $model->user_id;
                            $payout->bank_name = $_POST['payout_bank'];
                            if (isset($_POST['payout_house'])) {
                                $payout->bank_building_num = $_POST['payout_house'];
                            }
                            if (isset($_POST['payout_street'])) {
                                $payout->bank_street = $_POST['payout_street'];
                            }
                            if (isset($_POST['payout_region'])) {
                                $payout->bank_region = $_POST['payout_region'];
                            }
                            if (isset($_POST['payout_city'])) {
                                $payout->bank_city = $_POST['payout_city'];
                            }
                            if (isset($_POST['payout_post'])) {
                                $payout->bank_postcode = $_POST['payout_post'];
                            }
                            if (isset($_POST['payout_country'])) {
                                $payout->bank_country = $_POST['payout_country'];
                            }
                            if (isset($_POST['payout_accountname'])) {
                                $payout->account_name = $_POST['payout_accountname'];
                            }
                            if (isset($_POST['payout_iban'])) {
                                $payout->iban = $_POST['payout_iban'];
                            }
                            if (isset($_POST['payout_biccode'])) {
                                $payout->bic_code = $_POST['payout_biccode'];
                            }
                            $payout->created_at = date('Y-m-d H:i:s');
                            if ($payout->validate()) {
                                $payout->save();
                            }
                        }
                        $mail = new YiiMailer('welcome', array('activationUrl' => $activationUrl));
                        $mail->setFrom('info@cbmglobal.io', 'CBM Global');
                        $mail->setSubject("Email Verification");
                        $mail->setTo($model->email);
                        $mail->send();

                        //Add to mailchimp list
                        if ($model->marketting_mail == 1) {
                            $address = $model->building_num . ", " . $model->street . ", " . $model->region . ", " . $model->city . ", " . ServiceHelper::getCountryNameFromId($model->country);
                            $curl = curl_init();
                            $url = Yii::app()->params['MailChimpURL'];
                            if ($model->language == "Dutch") {
                                $listId = Yii::app()->params['MailChimpDutchListId'];
                            } else {
                                $listId = Yii::app()->params['MailChimpEnglishListId'];
                            }
                            $authorization = Yii::app()->params['MailChimpAuthorizationId'];
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => $url . "lists/" . $listId . "/members",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => CJSON::encode([
                                    "email_address" => $model->email,
                                    "status" => "subscribed",
                                    "merge_fields" => ["FNAME" => $model->first_name,
                                        "LNAME" => $model->last_name,
                                        "ADDRESS" => $address,
                                        "PHONE" => $model->phone,
                                        "BIRTHDAY" => date('m/d', strtotime($model->date_of_birth))]
                                ]),
                                CURLOPT_HTTPHEADER => array(
                                    "authorization: " . $authorization,
                                    "cache-control: no-cache",
                                    "content-type: application/json"
                                ),
                            ));
                            $response = curl_exec($curl);
                            $err = curl_error($curl);
                            curl_close($curl);
                        }
                        //Add to CBM User License
                        ServiceHelper::modifyCBMUserLicenses($model->user_id, $model->email,0, 0);

                        $loginForm = new LoginForm();
                        $this->layout = 'newlogin';
                        $this->render('login', [
                            'model' => $loginForm,
                            'id' => $model->sponsor_id,
                            'success' => 'We have sent a email verification link to your email address.'
                        ]);
                    } else {
                        $error = $model->getErrors();
                        $errorString = json_encode($error);

                        $logs = new CbmLogs();
                        $logs->status = 2;
                        $logs->created_date = date('Y-m-d H:i:s');
                        $logs->log = "Error while creating user: " . $errorString;
                        $logs->save(false); // saving logs

                        $this->render('signup', [
                            'model' => $model,
                            'id' => $id
                        ]);
                    }

                } else {
                    $loginForm = new LoginForm();
                    $this->render('login', [
                        'model' => $loginForm,
                        'success' => $user_response['success_response']['message']
                    ]);
                }
            }  else {
                $logs = new CbmLogs();
                $logs->status = 2;
                $logs->created_date = date('Y-m-d H:i:s');
                $logs->log = "Error while creating user: Sponsor Id not found";
                $logs->save(false); // saving logs

                $loginForm = new LoginForm();
                $this->render('login', [
                    'model' => $loginForm,
                    'success' => 'Issue while creating the user. Kindly try after some time'
                ]);
            }
            unset($_SESSION['user_present_in_sso']);
        }else {
            $this->render('registration/stepOne', [
                'model' => $model,
                'sioData' => $sioData
            ]);
        }
    }

    public function actionCompleteDemo(){
        $this->layout = false;
        $this->render('full-demo');
    }

    public function actionCheckEmail()
    {
        $result = 'true';
        if(isset($_POST['UserInfo']['email'])){
            $email = $_POST['UserInfo']['email'];
            $response = $this->verifyEmailWithPortalAndSIO($email);
            if($response['status'] != 1){
                $result = 'Email Already Exist in System. Please login';
            }
        }
        echo json_encode($result);
    }

    protected function verifyEmailWithPortalAndSIO($email){
        $portalUser = UserInfo::model()->findByAttributes(['email'=>$email]);
        if(isset($portalUser->user_id)){
            //Email exists in CBM itself. Kindly login
            $response['status'] = 2;
            $response['message'] = "Email exists in MMC itself. Kindly login";
        } else {
            //Verify with SSO
            $sso_url = Yii::app()->params['SSO_URL'];
            $data = [
                'email' => $email,
                'application' => 'Micromaxcash'
            ];

            $sso_response = CurlHelper::executeAction($sso_url.'api/verifyEmail',$data, "POST");
            if(!is_null($sso_response['success_response'])){
                $sso_success_response = $sso_response['success_response'];
                if($sso_success_response['status'] == 0){
                    //Error
                    $response['status'] = 0;
                    $response['message'] = $sso_success_response['message'];
                } elseif ($sso_success_response['status'] == 2){
                    //User is already registered at SIO. Please proceed registration with some necessary data.
                    $response['status'] = 3;
                    $response['message'] = $sso_success_response['message'];
                    //$_SESSION['user_present_in_sso'] = $sso_success_response['data']['email'];
                    $portalToken = $sso_success_response['data']['portal_token'];

                    //Email verification with SIO email
                    /*$afterVerificationUrl = Yii::app()->createAbsoluteUrl('/home/registrationStepOneInitial') . '?token='.$portalToken;
                    $response['verification_url'] = $afterVerificationUrl;
                    $mail = new YiiMailer('sso-email-verification', ['activationUrl' => $afterVerificationUrl]);
                    $mail->setFrom('info@cbmglobal.io', 'CBM Global');
                    $mail->setSubject("Email Verification");
                    $mail->setTo($sso_success_response['data']['email']);
                    $mail->send();*/
                } else {
                    //Registration can begin
                    $response['status'] = 1;
                    $response['message'] = $sso_success_response['message'];
                    $_SESSION['verified_email'] = $email;
                }
            } else {
                //Error
                $response['status'] = 0;
                $response['message'] = $sso_response['error_response']['message'];
            }
        }
        return $response;
    }

    /*
     * Verify email with SSO and CBM while registration
     * */
    public function actionVerifyEmail(){
        $response = [];
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $response = $this->verifyEmailWithPortalAndSIO($email);
        }
        echo json_encode($response);
    }

    public function actionEventSearch()
    {
        $date_start = date('Y-m-d H:i:s', strtotime($_POST['start']));
        $date_end = date('Y-m-d H:i:s', strtotime($_POST['end']));
        $events = array();
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition("event_start", $date_start, $date_end, 'AND');
        $model = Events::model()->findAll($criteria);
        foreach ($model as $data) {
            $events[] = [
                'event_name' => $data->event_title,
                'event_start' => date('d/m/Y', strtotime($data->event_start)),
                'event_end' => date('d/m/Y', strtotime($data->event_end)),
                'event_location' => $data->event_location,
                'event_desc' => $data->event_description,
                'event_time' => date('h:i a', strtotime($data->event_start)),
                'event_url' => $data->event_url,
            ];
        }
        if ($events) {
            echo json_encode([
                'token' => 1,
                'data' => $events
            ]);
        } else {
            echo json_encode([
                'token' => 0,
            ]);
        }

    }

    public function time_elapsed_string($datetime, $full = false)
    {
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

    public function randomString($length = 6)
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    public function actionActivation($key)
    {
        $user = UserInfo::model()->findByAttributes(['auth' => $key]);
        $this->layout = 'newlogin';
        $model = new LoginForm;
        if (isset($user->user_id)) {
            $user->is_active = 1;
            $user->save(false);

            //Update to SSO
            $sso_url = Yii::app()->params['SSO_URL'];

            $data['application'] = 'Micromaxcash';
            $data['email'] = $user->email;
            $data['is_active'] = 1;
            $sso_response = CurlHelper::executeAction($sso_url.'api/activateUser',$data, "POST");

            if(!is_null($sso_response['success_response'])){
                if($sso_response['success_response']['status'] == 1){
                    $this->render('login', [
                        'model' => $model,
                        'success' => 'Your account is active now. You can proceed with login.',
                        'login'=>true,
                    ]);
                } else {
                    $this->render('login', [
                        'model' => $model,
                        'error' => $sso_response['success_response']['message']
                    ]);
                }
            } else {
                $this->render('login', [
                    'model' => $model,
                    'error' => $sso_response['error_response']['message']
                ]);
            }
        } else {
            $this->render('login', [
                'model' => $model,
                'error' => 'Your activation key is invalid. Please try again.'
            ]);
        }
    }

//Resend activation mail
    public function actionResendActivationMail()
    {
        $mail = $_GET['mail'];
        $model = UserInfo::model()->findByAttributes(['email' => $mail]);
        if (isset($model->user_id)) {
            $model->auth = $this->randomString(20);
            $activationUrl = Yii::app()->createAbsoluteUrl('/home/activation?key=' . $model->auth);
            if ($model->save(false)) {
                $mail = new YiiMailer('welcome', array('activationUrl' => $activationUrl));
                $mail->setFrom('info@cbmglobal.io', 'CBM Global');
                $mail->setSubject("Email Verification");
                $mail->setTo($model->email);
                if ($mail->send()) {
                    echo "Mail sent";
                }
            }
        } else {
            echo "User not present..\n";
        }
    }

    /* Set loginId session */
    public function actionSetSessionLoginId()
    {
        if (isset($_POST['loginID'])) {
            $_SESSION['loginId'] = $_POST['loginID'];
        }
    }
}
