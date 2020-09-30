<?php

class UserController extends Controller
{
    public $layout = 'main';
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    protected function beforeAction($action)
    {
        if (Yii::app()->user->isGuest  && $action->id != 'forgot' && $action->id != 'resetpassword' && $action->id != 'passwordreset'  && $action->id != 'newUserPage' && $action->id != 'updateNewUserFields'){
            $this->redirect(Yii::app()->createUrl('home/login'));
        }
        return parent::beforeAction($action);

    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionProfile()
    {
        $model = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
        $sponsorId =UserInfo::model()->findAll();
        $count_sponsor_id = UserInfo::model()->countByAttributes(['sponsor_id' => Yii::app()->user->getId()]);

        $available_licenses = CbmUserLicenses::model()->findByAttributes(['email' => $model['email']]);
        $payout = UserPayoutInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
        if(empty($available_licenses)){
            $licenses = 0;
        }else{
             $licenses = $available_licenses->available_licenses;
        }

        if(!empty($_POST)){
            $modified_data = SSOHelper::modifyPostDataWRTSSO($_POST);
            //Update to SSO
            $updateUserInSSO = CurlHelper::executeAction(Yii::app()->params['SSO_URL'].'api/updateUser', $modified_data, 'POST');
            if(isset($updateUserInSSO['success_response']) && ($updateUserInSSO['success_response']['status'] == 1)){
                if(isset($_POST['payout'])){
                    if(!isset($payout)){
                        $payout = new UserPayoutInfo();
                        $payout->created_at = date('Y-m-d H:i:s');
                    }else{
                        $payout->modified_at = date('Y-m-d H:i:s');
                    }
                    if(isset($_POST['reserve_wallet_commission_status'])){
                        $model->reserve_wallet_commission_status = $_POST['reserve_wallet_commission_status'];
                        $model->save(false);
                    }
                    $payout->user_id = $model->user_id;
                    $payout->bank_name = $_POST['payout']['bank_name'];
                    if(isset($_POST['payout']['bank_building_num'])){
                        $payout->bank_building_num = $_POST['payout']['bank_building_num'];
                    }
                    if(isset($_POST['payout']['bank_street'])){
                        $payout->bank_street = $_POST['payout']['bank_street'];
                    }
                    if(isset($_POST['payout']['bank_region'])){
                        $payout->bank_region = $_POST['payout']['bank_region'];
                    }
                    if(isset($_POST['payout']['bank_city'])){
                        $payout->bank_city = $_POST['payout']['bank_city'];
                    }
                    if(isset($_POST['payout']['bank_postcode'])){
                        $payout->bank_postcode = $_POST['payout']['bank_postcode'];
                    }
                    if(isset($_POST['payout']['bank_country'])){
                        $payout->bank_country = $_POST['payout']['bank_country'];
                    }
                    if(isset($_POST['payout']['account_name'])){
                        $payout->account_name = $_POST['payout']['account_name'];
                    }
                    if(isset($_POST['payout']['bank_iban'])){
                        $payout->iban = $_POST['payout']['bank_iban'];
                    }
                    if(isset($_POST['payout']['bank_bic'])){
                        $payout->bic_code = $_POST['payout']['bank_bic'];
                    }
                    if($payout->validate()){
                        if($payout->save(false)){
                            Yii::app()->user->setFlash('success', 'Profile updated successfully');
                        }else{
                            Yii::app()->user->setFlash('error', 'Error on profile updated');
                        }
                    }
                } elseif(isset($_POST['first_name'])) {
                    $model->first_name = $_POST['first_name'];
                    if(isset($_POST['middle_name'])){
                        $model->full_name = $_POST['first_name']." ".$_POST['middle_name']." ".$_POST['last_name'];
                        $model->middle_name = $_POST['middle_name'];
                    }
                    else{
                        $model->full_name = $_POST['first_name']." ".$_POST['last_name'];
                    }
                    $model->last_name = $_POST['last_name'];
                    $model->gender = $_POST['gender'];
                    if(isset($_POST['private_disclosure']) == 1){
                        $model->privacy_disclosure = 1;
                    }else{
                        $model->privacy_disclosure = 0;
                    }
                    $model->date_of_birth = $_POST['date_of_birth'];
                    $model->modified_at = date('Y-m-d H:i:s');
                    if(isset($_POST['building_num'])){
                        $model->building_num = $_POST['building_num'];
                        $model->postcode = $_POST['postcode'];
                        $model->street = $_POST['street'];
                        $model->country = $_POST['country'];
                        $model->region = $_POST['region'];
                        $model->phone = $_POST['phone'];
                        $model->city = $_POST['city'];
                    }
                    if(isset($_POST['business_name'])){
                        $model->business_name = $_POST['business_name'];
                        $model->vat_number = $_POST['vat_number'];
                    }
                    if(isset($_POST['businesstype']) && ($_POST['businesstype'] == 1)){
                        $model->business_name = "";
                        $model->vat_number = "";
                        $model->busAddress_building_num = "";
                        $model->busAddress_street = "";
                        $model->busAddress_region = "";
                        $model->busAddress_city = "";
                        $model->busAddress_postcode = "";
                        $model->busAddress_country = "";
                    }else {
                        if(isset($_POST['is_different_address'])){
                            $model->busAddress_building_num = $_POST['busAddress_building_num'];
                            $model->busAddress_city = $_POST['busAddress_city'];
                            $model->busAddress_street = $_POST['busAddress_street'];
                            $model->busAddress_postcode = $_POST['busAddress_postcode'];
                            $model->busAddress_region = $_POST['busAddress_region'];
                            $model->busAddress_country = $_POST['busAddress_country'];
                        }else{
                            if(isset($_POST['building_num'])){
                                $model->busAddress_building_num = $_POST['building_num'];
                                $model->busAddress_city = $_POST['city'];
                                $model->busAddress_street = $_POST['street'];
                                $model->busAddress_postcode = $_POST['postcode'];
                                $model->busAddress_region = $_POST['region'];
                                $model->busAddress_country = $_POST['country'];
                            }
                        }
                    }
                    if($model->save(false)){
                        Yii::app()->user->setFlash('success', 'Profile updated successfully');
                    }else{
                        Yii::app()->user->setFlash('error', 'Error on profile updated');
                    }
                } elseif(isset($_POST['new_password'])){
                    $model->modified_at = date('Y-m-d H:i:s');
                    if($model->save(false)){
                        Yii::app()->user->setFlash('success', 'Password changed successfully');
                    }else{
                        Yii::app()->user->setFlash('error', 'Password has been not changed');
                    }
                } else {
                    $model->modified_at = date('Y-m-d H:i:s');
                    if(isset($_POST['email']['notification-mail'])){
                        $model->notification_mail = 1;
                    }else{
                        $model->notification_mail = 0;
                    }
                    $address = $model->building_num . ", " . $model->street . ", " .$model->region . ", " .$model->city . ", " . ServiceHelper::getCountryNameFromId($model->country);
                    $url = Yii::app()->params['MailChimpURL'];
                    if($model->language == "Dutch"){
                        $listId = Yii::app()->params['MailChimpDutchListId'];
                    } else {
                        $listId = Yii::app()->params['MailChimpEnglishListId'];
                    }
                    $authorization = Yii::app()->params['MailChimpAuthorizationId'];
                    if(isset($_POST['email']['market-mail'])){
                        $model->marketting_mail = 1;
                        if($model->marketting_mail == 1){
                            $curl = curl_init();

                            curl_setopt_array($curl, array(
                                CURLOPT_URL => $url."lists/".$listId."/members",
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
                                        "BIRTHDAY" => date('m/d',strtotime($model->date_of_birth))]
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
                    } else {
                        $model->marketting_mail = 0;
                        $curl = curl_init();

                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $url."lists/".$listId."/members/".md5($model->email),
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "DELETE",
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
                    if($model->save()){
                        Yii::app()->user->setFlash('success', 'Profile updated successfully');
                    }else{
                        Yii::app()->user->setFlash('error', 'Error on profile updated');
                    }
                }
            } else {
                Yii::app()->user->setFlash('error', 'Error while updating profile!! Please try again after some time or contact Support');
            }
        }
        $this->render('profile', array(
        'model' => $model,
        'sponsorId' => $sponsorId, 
        'count_sponsor' => $count_sponsor_id,
        'licenses' => $licenses,
        'payout' => $payout
        ));
    }

    public function actionPromote(){
        $model = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
        $this->render('promote', array(
        'model' => $model
        ));
    }

    public function actionPendingCustomers(){
        $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);

        $level1UserRegistrations = Yii::app()->db->createCommand()
            ->select('*')
            ->from('registration_status rs')
            ->join('user_info ui','rs.user_id = ui.user_id')
            ->where('sponsor_id=:sId',[':sId'=>$user->user_id])
            ->queryAll();

        $registrationSteps = RegistrationSteps::model()->findAllByAttributes(['product_id'=>1]);

        $this->render('pending-customers',[
            'level1UserRegistrations' => $level1UserRegistrations,
            'registrationSteps' => $registrationSteps
            ]);
    }

    /*
     * Login from admin to any user
     * */
    public function actionAutoLogin($id)
    {
        $originalUserID = Yii::app()->user->id;
        $loggedInUser = UserInfo::model()->findByPk($originalUserID);
        Yii::app()->session['adminLogin'] = 0;
        $user = UserInfo::model()->findByPk($id);
        Yii::app()->session['adminLogin'] = $originalUserID;

        $dataArray = [];
        $dataArray['token'] = $loggedInUser->api_token;
        $dataArray['email'] = $user->email;
        $setAPITokenInSSO = CurlHelper::executeAction(Yii::app()->params['SSO_URL'].'api/addStaticAPIToken', $dataArray, 'POST');

        if(isset($setAPITokenInSSO['success_response']) && ($setAPITokenInSSO['success_response']['status'] == 1)){
            if(isset($setAPITokenInSSO['success_response']['data']['token'])){
                $user->api_token = $setAPITokenInSSO['success_response']['data']['token'];
                $user->save(false);
            }
        }
        $this->redirect(['home/autologin', 'token'=>$user->api_token, 'email'=>$user->email]);
    }

    /**
     * This is the update user action
     */
    public function actionUpdate()
    {
        $model = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
        $model->full_name = $_POST['profile']['first_name'].' '.$_POST['profile']['last_name'];
        $model->attributes = $_POST['profile'];
        if($model->validate()){
            if($model->save()) {
                echo json_encode([
                    'token' => 1
                ]);
            }else{
                echo json_encode([
                    'token' => 0
                ]);
            }
        }else{
            print_r($model->getErrors()); die;
        }
    }

    /*
     * Update billing information
     * */
    public function actionBillinginformation(){
        $model = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
        if(!empty($_POST)){
            $modified_data = SSOHelper::modifyPostDataWRTSSO($_POST);
            //Update to SSO
            $updateUserInSSO = CurlHelper::executeAction(Yii::app()->params['SSO_URL'].'api/updateUser', $modified_data, 'POST');
            if(isset($updateUserInSSO['success_response']) && ($updateUserInSSO['success_response']['status'] == 1)){
                if(isset($_POST['building_num'])) {
                    if(isset($_POST['private_disclosure']) == 1){
                        $model->privacy_disclosure = 1;
                    }else{
                        $model->privacy_disclosure = 0;
                    }
                    $model->modified_at = date('Y-m-d H:i:s');
                    $model->building_num = $_POST['building_num'];
                    $model->postcode = $_POST['postcode'];
                    $model->street = $_POST['street'];
                    $model->country = $_POST['country'];
                    $model->region = $_POST['region'];
                    $model->phone = $_POST['phone'];
                    $model->city = $_POST['city'];

                    if(isset($_POST['business_name'])){
                        $model->business_name = $_POST['business_name'];
                        $model->vat_number = $_POST['vat_number'];
                    }
                    if(isset($_POST['is_different_address'])){
                        $model->busAddress_building_num = $_POST['busAddress_building_num'];
                        $model->busAddress_city = $_POST['busAddress_city'];
                        $model->busAddress_street = $_POST['busAddress_street'];
                        $model->busAddress_postcode = $_POST['busAddress_postcode'];
                        $model->busAddress_region = $_POST['busAddress_region'];
                        $model->busAddress_country = $_POST['busAddress_country'];
                        $model->business_phone = $_POST['business_phone'];
                    }else{
                        $model->busAddress_building_num = $_POST['building_num'];
                        $model->busAddress_city = $_POST['city'];
                        $model->busAddress_street = $_POST['street'];
                        $model->busAddress_postcode = $_POST['postcode'];
                        $model->busAddress_region = $_POST['region'];
                        $model->busAddress_country = $_POST['country'];
                        $model->business_phone = $_POST['phone'];
                    }

                    if($model->save(false)){
                        Yii::app()->user->setFlash('success', 'Profile updated successfully');
                    }else{
                        Yii::app()->user->setFlash('error', 'Error on profile updated');
                    }
                }
            } else {
                Yii::app()->user->setFlash('error', 'Error while updating profile!! Please try again after some time or contact Support');
            }
        }
        $this->render('billing-information', array(
            'model' => $model
        ));
    }

    /**
     * Update password page
     */
    public function actionChangePassword()
    {
       $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
        if(!empty($_POST) && (isset($_POST['new_password']))) {
            $modified_data = SSOHelper::modifyPostDataWRTSSO($_POST);
            //Update to SSO
            $updateUserInSSO = CurlHelper::executeAction(Yii::app()->params['SSO_URL'] . 'api/updateUser', $modified_data, 'POST');
            if (isset($updateUserInSSO['success_response']) && ($updateUserInSSO['success_response']['status'] == 1)) {
                $model = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
                $model->modified_at = date('Y-m-d H:i:s');
                $model->save(false);
                Yii::app()->user->setFlash('success', 'Password changed successfully');
            } else {
                Yii::app()->user->setFlash('error', $updateUserInSSO['success_response']['message']);
            }
        }
       $this->render('changepassword', array(
            'model' => $user
       ));
    }

    /*
     * To update the password from profile page
     * */
    public function actionUpdatePassword()
    {
        $response = [];
        $response['status'] = 0;
        if(!empty($_POST) && (isset($_POST['new_password']))) {
            $modified_data = SSOHelper::modifyPostDataWRTSSO($_POST);
            //Update to SSO
            $updateUserInSSO = CurlHelper::executeAction(Yii::app()->params['SSO_URL'] . 'api/updateUser', $modified_data, 'POST');
            if (isset($updateUserInSSO['success_response']) && ($updateUserInSSO['success_response']['status'] == 1)) {
                $model = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
                $model->modified_at = date('Y-m-d H:i:s');
                $model->save(false);
                Yii::app()->user->setFlash('success', 'Password changed successfully');
                $response['status'] = 1;
            } else {
                $response['message'] = $updateUserInSSO['success_response']['message'];
            }
        } else {
            $response['message'] = 'Issue with post';
        }
        if($response['status'] == 0){
            Yii::app()->user->setFlash('error', 'Password has been not changed');
        }
        echo json_encode($response);
    }

    /**
     * Forgot password
     */
    public function actionForgot()
    {
        $this->layout = 'newlogin';
        if (isset($_POST['email'])) {
            if (!empty($_POST['email'])) {
                $res = $this->forget($_POST['email']);
                if($res == 'Success'){
                    $this->render('forgot-password',[
                        'success' => 'Email sent successfully.'
                    ]);
                } else if($res == 'Error') {
                    $this->render('forgot-password',[
                        'error' => 'Not able to send email due to some technical issue..'
                    ]);
                } else if($res == 'Empty') {
                    $this->render('forgot-password',[
                        'empty' => 'Email not found. Please check again.'
                    ]);
                } else {
                    $this->render('forgot-password',[
                        'wrong' => 'Some unknown issue in sending email. Try again later'
                    ]);
                }
            }else{
                $this->render('forgot-password',[
                    'empty' => 'Please enter email address.'
                ]);
            }

        }else {
            $this->render('forgot-password');
        }
    }

    /**
     * Logs in a user using the provided username
     * @return boolean whether the user is logged in successfully
     */
    public function forget($email)
    {
        $model = UserInfo::model()->findByAttributes(['email' => $email]);
        if(isset($model->email)){
            $token = $model->user_id . mt_rand(10000, 999999);
            $model->token = $token;
            $model->save(false);
            $resetUrl = Yii::app()->getBaseUrl(true) . '/user/resetpassword/?token=' . $token;
            $mail = new YiiMailer('forgot-password', array('resetUrl'=>$resetUrl));
            $mail->setFrom('info@cbmglobal.io', 'CBM Global');
            $mail->setSubject("Password Change");
            $mail->setTo($model->email);
            if($mail->send())
                return 'Success';
            else
                return 'Error';
        } else {
            return 'Empty';
        }
    }

    /*
     * Ajax logout for affiliate program
     * */
    public function actionAjaxLogout(){
        Yii::app()->user->logout();
    }

    /*
     * Reset Password
     */
    public function actionResetPassword(){
        $this->layout = 'newlogin';
        if (isset($_GET)){
            $user = UserInfo::model()->findByAttributes(['token' => $_GET['token']]);
            if ($user){
                $user->token = '';
                $user->save();
                $this->render('resetpassword',[
                    'user' => $user
                ]);
            }else{
                $this->render('linkbroken',[
                    'invalid' => 'Link that you are trying to reach is may be broken or expired.'
                ]);
            }
        }
    }

    public function actionPasswordReset(){
        if (isset($_POST['user-id']) && isset($_POST['new-password']) && isset($_POST['confirm-password'])){
            if ($_POST['new-password'] == $_POST['confirm-password']){
                $user = UserInfo::model()->findByAttributes(['user_id' => $_POST['user-id']]);
                $user->password = md5($_POST['new-password']);
                $user->save(false);
                $this->redirect(Yii::app()->getBaseUrl(true).'/home/login');
            }
        }
    }

    //Verify old password with SSO
    public function actionVerifyOldPassword(){
        if(isset($_POST['email']) && isset($_POST['current_password'])){
            $email = $_POST['email'];
            $oldPassword = $_POST['current_password'];
            $user = UserInfo::model()->findByAttributes(['email'=>$email]);

            $password_data['token'] = $user->api_token;
            $password_data['email'] = $email;
            $password_data['old_password'] = $oldPassword;

            $verifyInSSO = CurlHelper::executeAction(Yii::app()->params['SSO_URL'].'api/verifyPassword', $password_data, 'POST');
            if(isset($verifyInSSO['success_response']) && ($verifyInSSO['success_response']['status'] == 1)){
                echo "true";
            } else {
                echo "false";
            }
        } else {
            echo json_encode("Invalid details provided");
        }
    }

    //Update Affiliate Disclosure policy
    public function actionUpdateAffiliate(){
        $user = UserInfo::model()->findByPk(Yii::app()->user->id);
        $user->affiliate_disclosure = 1;
        $user->save(false);
    }

    //welcome all users for the first time
    public function actionWelcomeUser(){
        $user = UserInfo::model()->findByAttributes(['email'=>'tom.geypens@gmail.com']);
        $token = $user->user_id . mt_rand(10000, 999999);
        $user->token = $token;
        $user->save(false);
        $resetUrl = Yii::app()->getBaseUrl(true) . '/user/newUserPage/?token=' . $token;
        $mail = new YiiMailer('welcome',['resetUrl'=>$resetUrl]);
        $mail->setFrom('info@cbmglobal.io', 'CBM Global');
        $mail->setSubject("Welcome mail");
        $mail->setTo($user->email);
        if($mail->send())
            echo "Mail Sent";
        else
            echo "Unable to send mail";

    }

    //Welcome all Users
    public function actionWelcomeAllUsers(){
        $users = UserInfo::model()->findAllByAttributes(['password'=>'b24331b1a138cde62aa1f679164fc62f','is_active'=>0]);
        foreach ($users as $user){
            $token = $user->user_id . mt_rand(10000, 999999);
            $user->token = $token;
            $user->save(false);
            $resetUrl = Yii::app()->createAbsoluteUrl('user/newUserPage/?token=' . $token.'/');
            $mail = new YiiMailer('welcome',['resetUrl'=>$resetUrl]);
            $mail->setFrom('info@cbmglobal.io', 'CBM Global');
            $mail->setSubject("Welcome mail");
            $mail->setTo($user->email);
            if($mail->send())
                echo "Mail Sent to ".$user->email."<br>";
            else
                echo "Unable to send mail to ".$user->email."<br>";
        }
    }

    //Display landing page for new User first time
    public function actionNewUserPage(){
        $this->layout = 'newlogin';
        if (isset($_GET['token'])) {
            $user = UserInfo::model()->findByAttributes(['token' => $_GET['token']]);
            if(isset($user->user_id)){
                $this->render('welcome-user',[
                    'user'=>$user
                ]);
            } else {
                $this->render('linkbroken',[
                    'invalid' => 'Link that you are trying to reach is may be broken or expired.'
                ]);
            }
        } else {
                $this->render('linkbroken',[
                    'invalid' => 'Link that you are trying to reach is may be broken or expired.'
                ]);
            }
    }

    //Update password and terms for the users
    public function actionUpdateNewUserFields(){
        if (isset($_POST['user-id']) && isset($_POST['new-password'])){
            $user = UserInfo::model()->findByAttributes(['user_id' => $_POST['user-id']]);
            $user->password = md5($_POST['new-password']);
            $user->terms_conditions = 1;
            $user->privacy_disclosure = 1;
            $user->is_active = 1;
            $user->save(false);
            $this->redirect(Yii::app()->createUrl('home/login'));
        }
    }

}