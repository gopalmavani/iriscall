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
            'registrationStepOneInitial', 'verifyEmail', 'completeDemo', 'activation', 'createUserSignup', 'checkEmail', 'jiraWebhook', 'autologin', 'index', 'landing'];
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
        if(Yii::app()->user->isGuest){
            $sso_url = Yii::app()->params['SSO_URL'];
            $this->redirect($sso_url.'login?application='.Yii::app()->params['applicationName']);
        } else {
            $this->redirect(Yii::app()->createUrl('home/index'));
        }
    }

    /*
     * Auto login process for SSO
     * */
    public function actionAutoLogin(){
        if(isset($_GET['token'])){
            $plan = isset($_GET['plan']) ? $_GET['plan'] : null;
            //echo $plan;die;
            $userEmail = $_GET['email'];
            $user = UserInfo::model()->findByAttributes(['email'=>$userEmail]);
            if(isset($user->user_id)){
                $user->api_token = $_GET['token'];
                $user->update('false');

                $model = new AutoLoginForm;
                $model->email = $user->email;
                if ($model->validate() && $model->login()) {
                    $this->redirect(array('account/create/', 'plan'=>$plan));
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
     * when the user gets in through Wordpress Site
     * **/
    public function actionLanding()
    {
        if(!Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->createUrl('account/create'));
        } else {
            $this->layout = 'iriscallwordpress';
            $this->render('wordpressIriscallEmailVerification');
            //$this->redirect(Yii::app()->createUrl('account/createguestaccount'));
        }
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
                    } else {
                        $model->business_name = "";
                        $model->vat_number = "";
                        $model->busAddress_building_num = "";
                        $model->busAddress_street = "";
                        $model->busAddress_region = "";
                        $model->busAddress_city = "";
                        $model->busAddress_postcode = "";
                        $model->busAddress_country = "";
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

                    $model->save(false);

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
                    if(Yii::app()->params['env'] != 'local'){
                        $mail = new YiiMailer('welcome', array('activationUrl' => $activationUrl));
                        //$mail->setFrom('info@micromaxcash.com', 'Micromaxcash');
                        $mail->setFrom('info@cbmglobal.io', 'CBM Global');
                        $mail->setSubject("Email Verification");
                        $mail->setTo($model->email);
                        $mail->send();
                    }

                    //Add to mailchimp list
                    if ($model->marketting_mail == 1) {
                        $address = $model->building_num . ", " . $model->street . ", " . $model->region . ", " . $model->city . ", " . ServiceHelper::getCountryNameFromId($model->country);
                        $curl = curl_init();
                        $url = Yii::app()->params['MailChimpURL'];
                        $listId = Yii::app()->params['MailChimpDutchListId'];
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
                    if(is_null($user_response['success_response'])){
                        $notification_msg = "Some issue while registration at SIO. Kindly contact support";
                    } else {
                        $notification_msg = $user_response['success_response']['message'];
                    }
                    $loginForm = new LoginForm();
                    $this->layout = 'newlogin';
                    $this->render('login', [
                        'model' => $loginForm,
                        'success' => $notification_msg
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
        $apiToken = null;
        $this->render('registration/stepEmailVerification');
    }

    public function actionRegistrationStepOneInitial(){
        $this->layout = false;
        $status = 0;
        $sioData = 0;
        $model = new UserInfo;
        if(isset($_GET['token'])){
            //Verify portal token with SSO
            $sso_url = Yii::app()->params['SSO_URL'];
            $portalToken = $_GET['token'];
            $sso_response = CurlHelper::executeAction($sso_url.'api/verifyPortalToken',['portal_token'=>$portalToken], "POST");
            if(!is_null($sso_response['success_response'])) {
                $sso_success_response = $sso_response['success_response'];
                if($sso_success_response['status'] == 1){
                    $model->attributes = SSOHelper::modifyPostDataWRTCBM($sso_success_response['data']['user_info']);
                    $status = 1;
                    $_SESSION['user_present_in_sso'] = $_GET['token'];
                    $sioData = 1;
                    //$response['message'] = "Thank you for permitting us to use SIO details";
                } else {
                    $status = -1;
                }
            }
        } else {
            if(isset($_SESSION['user_email'])){
                $model->email = $_SESSION['user_email'];
            }
        }
        $this->render('registration/stepOne', [
            'status' => $status,
            'model' => $model,
            'sioData' => $sioData
        ]);
    }

    public function actionRegistrationStepOneDemo(){
        $this->layout = false;
        $this->render('registration/stepOneDemo');
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
                echo json_encode(array(
                    'valid' => false,
                ));
                //$result = 'Email Already Exist in System. Please login';
            } else {
                echo json_encode(array(
                    'valid' => true,
                ));
            }
        } else {
            echo json_encode(array(
                'valid' => false,
            ));
        }
        //echo json_encode($result);
    }

    protected function verifyEmailWithPortalAndSIO($email){
        $portalUser = UserInfo::model()->findByAttributes(['email'=>$email]);
        if(isset($portalUser->user_id)){
            //Email exists in CBM itself. Kindly login
            $response['status'] = 2;
            $response['message'] = "Email exists in Iriscall itself. Kindly login";
        } else {
            //Verify with SSO
            $sso_url = Yii::app()->params['SSO_URL'];
            $data = [
                'email' => $email,
                'application' => Yii::app()->params['applicationName']
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
                    $afterVerificationUrl = Yii::app()->createAbsoluteUrl('/home/registrationStepOneInitial') . '?token='.$portalToken;
                    $response['verification_url'] = $afterVerificationUrl;
                    $mail = new YiiMailer('sso-email-verification', ['activationUrl' => $afterVerificationUrl]);
                    $mail->setFrom('info@cbmglobal.io', 'CBM Global');
                    $mail->setSubject("Email Verification");
                    $mail->setTo($sso_success_response['data']['email']);
                    $mail->send();
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
            $_SESSION['user_email'] = $email;
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
