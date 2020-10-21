<?php

class UserInfoController extends CController
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */

    public function accessRules()
    {
        return UserIdentity::newaccessRules();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = UserInfo::model()->findByPk(['user_id' => $id]);
        $payout = UserPayoutInfo::model()->findByAttributes(['user_id' => $id]);

        if(empty($payout)){
            $payout = [];
        }
        if(isset($_POST['UserInfo'])){
            try {
                $model->password = md5($_POST['UserInfo']['newPassword']);
                $model->modified_at = date('Y-m-d H:i:s');
                if ($model->validate()) {
                    if($model->save())
                        $result = [
                            'result' => true
                        ];
                }
            }catch (Exception $e){
                $result = [
                    'result' => false,
                    'error' => $e
                ];
            }
            echo CJSON::encode($result);
        }else {
            /*$this->render('changePassword', array(
                'model' => $model,
            ));*/


            $this->render('view', array(
                'model' => $this->loadModel($id),
                'payout' => $payout
            ));
        }
    }


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new UserInfo;
        $payout = new UserPayoutInfo();
        $registrationStatus = new RegistrationStatus();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['UserInfo'])) {
            $userResult = $this->saveUserInfo($_POST['UserInfo'],$_POST['Business']);
            return $userResult;
        }

        if(isset($_POST['UserPayoutInfo'])){
            $payoutResult = $this->saveUserPayout($_POST['UserPayoutInfo'],$_POST['Payout']['uid']);
            return $payoutResult;
        }

        if(isset($_POST['RegistrationStatus'])){
            $registrationStatus->user_id = $_POST['Status']['uid'];
            $user = UserInfo::model()->findByPk($registrationStatus->user_id);
            $registrationStatus->email = $user->email;
            $registrationStatus->product_id = $_POST['RegistrationStatus']['product_id'];
            $registrationStatus->step_number = $_POST['RegistrationStatus']['step_number'];
            $registrationStatus->created_at = date('Y-m-d H:i:s');
            $registrationStatus->save(false);
            $result = [
                'result' => true,
                'id' => $registrationStatus->user_id,
            ];
            return json_encode($result);
        }

        if(isset($_POST['email'])){
            $emailResult = $this->saveUserEmail($_POST['email'],$_POST['Email']['uid']);
            return $emailResult;
        }

        $this->render('create', array(
            'model' => $model,
            'payout' => $payout,
            'registrationStatus' => $registrationStatus
        ));
    }

    public function actionCheckEmail(){
        $result = 'true';
        $email = UserInfo::model()->findAllByAttributes(['email' => $_POST['UserInfo']['email']]);
        if (count($email) > 0) {
            $result = 'false';
        }
        echo $result;
    }

    public function actionCheckUpdateEmail(){
        $result = 'true';
        $email = UserInfo::model()->findAllByAttributes(['email' => $_POST['UserInfo']['email']]);
        $currentEmail = UserInfo::model()->findByAttributes(['user_id' => $_POST['UserId']]);
        if (count($email) > 0 && (strtolower($_POST['UserInfo']['email']) != $currentEmail->email)) {
            $result = 'false';
        }
        echo $result;
    }

    protected function saveUserInfo($res,$address)
    {
        $result = [];

        $model = new UserInfo();
        $_POST['UserInfo'] = $res;
        $_POST['Business'] = $address;

        if (isset($_POST['UserInfo'])) {
            if (isset($_POST['UserInfo']['checkbox'])) {
                if ($_POST['UserInfo']['checkbox']) {
                    foreach ($_POST['UserInfo']['checkbox'] as $key => $val) {
                        if ($val){
                            $model->$key = implode(",", $val);
                        }
                    }
                }
            }

            $model->attributes = $_POST['UserInfo'];
            // $model->auth_level = 'user';
            $model->created_at = date('Y-m-d H:i:s');
            $model->modified_at = date('Y-m-d H:i:s');
            $model->password = md5($_POST['UserInfo']['password']);

            if($_POST['Business'] == 1){
                $model->business_name = "";
                $model->vat_number = "";
                $model->busAddress_building_num = "";
                $model->busAddress_street = "";
                $model->busAddress_region = "";
                $model->busAddress_city = "";
                $model->busAddress_postcode = "";
                $model->busAddress_country = "";
            }else {
                if (isset($_POST['Diffrent_Address'])) {
                    $model->busAddress_building_num = $_POST['UserInfo']['busAddress_building_num'];
                    $model->busAddress_street = $_POST['UserInfo']['busAddress_street'];
                    $model->busAddress_region = $_POST['UserInfo']['busAddress_region'];
                    $model->busAddress_city = $_POST['UserInfo']['busAddress_city'];
                    $model->busAddress_postcode = $_POST['UserInfo']['busAddress_postcode'];
                    $model->busAddress_country = $_POST['UserInfo']['busAddress_country'];
                }
                else {
                    $model->busAddress_building_num = $_POST['UserInfo']['building_num'];
                    $model->busAddress_street = $_POST['UserInfo']['street'];
                    $model->busAddress_region = $_POST['UserInfo']['region'];
                    $model->busAddress_city = $_POST['UserInfo']['city'];
                    $model->busAddress_postcode = $_POST['UserInfo']['postcode'];
                    $model->busAddress_country = $_POST['UserInfo']['country'];
                }
            }
            $model->terms_conditions = 1;

            if ($model->validate()) {
                if ($model->save()) {
                    $result = [
                        'result' => true,
                        'userId' => $model->user_id,
                        'token' => 1
                    ];
                }
            }else{
                $result = [
                    'token' => 0,
                    'result' => false,
                ];
            }
        }
        echo json_encode($result);
    }

    protected function saveUserPayout($res,$userId){
        $payout = UserPayoutInfo::model()->findByAttributes(['user_id'=>$userId]);
        if(empty($payout)){
            $payout = new UserPayoutInfo();
            $payout->created_at = date('Y-m-d H:i:s');
        }else{
            $payout->modified_at = date('Y-m-d H:i:s');
        }
        $payout->user_id = $userId;
        $payout->attributes = $res;
        if($payout->validate()){
            if($payout->save(false)){
                $result = [
                    'result' => true,
                    'Id' => $payout->id,
                ];
            }
        }else{
            $result = [
                'result' => false,
                'Msg' => $payout->getErrors(),
            ];
        }
        echo json_encode($result);
    }

    protected function saveUserEmail($res,$userId){
        $model = UserInfo::model()->findByAttributes(['user_id' => $userId]);
        $_POST['email'] = $res;
        if ($_POST['email'] == 0){
            $model->notification_mail = 0;
            $model->marketting_mail = 0;
        }else{
            $address = $model->building_num . ", " . $model->street . ", " .$model->region . ", " .$model->city . ", " . ServiceHelper::getCountryNameFromId($model->country);
            if($_SERVER['HTTP_HOST'] == 'localhost'){
                $url = "https://us20.api.mailchimp.com/3.0/";
                $listid = "c51cfe0bc1";
                $authorization = "Basic aGl0ZWtzaGFzaGV0aDoyY2YzNGY1OWI5YjdlYWZjYTk2NGQwNDY5YzJjNWZmNC11czIw";
            }else{
                $url = "https://us12.api.mailchimp.com/3.0/";
                $listid = "46382ca627";
                $authorization = "Basic Y2JtZ2xvYmFsOjE2OWNlMzZkMDkxNjg4NTc5ZTI0YzZmMDI1NzlkMzI2LXVzMTI=";
            }
            if(isset($_POST['email']['notification-mail'])){
                $model->notification_mail = 1;
            }else{
                $model->notification_mail = 0;
            }
            if(isset($_POST['email']['market-mail'])){
                $model->marketting_mail = 1;
                if($model->marketting_mail == 1){
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url."lists/".$listid."/members",
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
            }else{
                $model->marketting_mail = 0;
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url."lists/".$listid."/members/".md5($model->email),
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
        }

        if($model->save(false)){
            $result = [
                'result' => true,
                'userId' => $model->user_id,
            ];
        }else{
            print_r($model->getErrors());die;
        }
        echo json_encode($result);
    }

    protected function validateUser($model, $address, $addressMap)
    {
        $user = UserInfo::model()->findAllByAttributes(['email' => $model->email]);
        if (count($user) > 0):
            $model->addError('email', 'Email Already Exist in System');
            $flag = 0;
            return $flag;
        endif;

        if ($model->validate() && $address->validate()) {
            $model->save(false);
            $address->save(false);
            $addressMap->address_id = $address->address_id;
            $addressMap->user_id = $model->user_id;
            $addressMap->created_at = date('Y-m-d H:i:s');
            $addressMap->modified_at = date('Y-m-d H:i:s');
            $model->created_at = date('Y-m-d H:i:s');
            $addressMap->save();
            $flag = 1;
        } else {
            $flag = 0;
        }
        return $flag;
    }

    protected function validateBusiness($model, $address, $addressMap, $business)
    {
        $user = UserInfo::model()->findAllByAttributes(['email' => $model->email]);
        if (count($user) > 0):
            $model->addError('email', 'Email Already Exist in System');
            $flag = 0;
            return $flag;
        endif;

        $business->user_id = rand(9, 9999);
        if ($model->validate() && $address->validate() && $business->validate()) {
            if ($model->save()) {
                $business->user_id = $model->user_id;
                $business->save();
                $address->save(false);
                $addressMap->user_id = $business->business_id;
                $addressMap->address_id = $address->address_id;
                $addressMap->user_id = $model->user_id;
                $addressMap->created_at = date('Y-m-d H:i:s');
                $addressMap->modified_at = date('Y-m-d H:i:s');
                $model->created_at = date('Y-m-d H:i:s');
                $addressMap->save();
                $flag = 1;
            }
        } else {
            $flag = 0;
        }
        return $flag;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {

        $model = $this->loadModel($id);
        $payout = UserPayoutInfo::model()->findByAttributes(['user_id'=> $id]);
        $registrationStatus = RegistrationStatus::model()->findByAttributes(['user_id'=> $id]);
        //If in case registration status is not present
        if(!isset($registrationStatus->email)){
            $registrationStatus = new RegistrationStatus();
            $registrationStatus->email = $model->email;
            $registrationStatus->user_id = $id;
            $registrationStatus->product_id = 1;
            $registrationStatus->step_number = 1;
            $registrationStatus->save(false);
        }
        if(empty($payout)){
            $payout = new UserPayoutInfo();
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['UserInfo'])) {
            if (isset($_POST['UserInfo']['checkbox'])) {
                if ($_POST['UserInfo']['checkbox']) {
                    foreach ($_POST['UserInfo']['checkbox'] as $key => $val) {
                        if ($val) {
                            $model->$key = implode(",", $val);
                        } else {
                            $model->$key = "";
                        }
                    }
                }
            }

            $model->attributes = $_POST['UserInfo'];
            $model->date_of_birth = date('Y-m-d',strtotime($_POST['UserInfo']['date_of_birth']));
            $model->modified_at = date('Y-m-d H:i:s');
            if($_POST['Business'] == 1){
                $model->business_name = "";
                $model->vat_number = "";
                $model->busAddress_building_num = "";
                $model->busAddress_street = "";
                $model->busAddress_region = "";
                $model->busAddress_city = "";
                $model->busAddress_postcode = "";
                $model->busAddress_country = "";
            }else {
                if (isset($_POST['Diffrent_Address'])) {
                    $model->busAddress_building_num = $_POST['UserInfo']['busAddress_building_num'];
                    $model->busAddress_street = $_POST['UserInfo']['busAddress_street'];
                    $model->busAddress_region = $_POST['UserInfo']['busAddress_region'];
                    $model->busAddress_city = $_POST['UserInfo']['busAddress_city'];
                    $model->busAddress_postcode = $_POST['UserInfo']['busAddress_postcode'];
                    $model->busAddress_country = $_POST['UserInfo']['busAddress_country'];
                }
                else {
                    $model->busAddress_building_num = $_POST['UserInfo']['building_num'];
                    $model->busAddress_street = $_POST['UserInfo']['street'];
                    $model->busAddress_region = $_POST['UserInfo']['region'];
                    $model->busAddress_city = $_POST['UserInfo']['city'];
                    $model->busAddress_postcode = $_POST['UserInfo']['postcode'];
                    $model->busAddress_country = $_POST['UserInfo']['country'];
                }
            }

            // if($model->business_name){
            //     if(!($model->busAddress_building_num)){
            //         $model->busAddress_building_num = $model->building_num;
            //     }
            //     if(!($model->busAddress_street)){
            //         $model->busAddress_street = $model->street;
            //     }
            //     if(!($model->busAddress_region)){
            //         $model->busAddress_region = $model->region;
            //     }
            //     if(!($model->busAddress_city)){
            //         $model->busAddress_city = $model->city;
            //     }
            //     if(!($model->busAddress_postcode)){
            //         $model->busAddress_postcode = $model->postcode;
            //     }
            //     if(!($model->busAddress_country)){
            //         $model->busAddress_country = $model->country;
            //     }
            //     if(!($model->business_phone)){
            //         $model->business_phone = $model->phone;
            //     }
            // }
            $model->terms_conditions = 1;

            if ($model->save(false)){
                echo json_encode($result = [
                    'result' => true,
                    'productId' => $model->user_id,
                ]); die;
            }else{
                print_r($model->getErrors());die;
            }
        }

        if(isset($_POST['UserPayoutInfo'])){
            $payoutResult = $this->saveUserPayout($_POST['UserPayoutInfo'],$_POST['Payout']['uid']);
            return $payoutResult;
        }

        if(isset($_POST['RegistrationStatus'])){
            $registrationStatus->step_number = $_POST['RegistrationStatus']['step_number'];
            $registrationStatus->modified_at = date('Y-m-d H:i:s');
            $registrationStatus->save(false);
            $result = [
                'result' => true,
                'id' => $registrationStatus->user_id,
            ];
            return json_encode($result);
        }

        if(isset($_POST['Email']['uid'])){
            //echo "<pre>";print_r($_POST);die;
            if(!isset($_POST['email'])){
                $_POST['email'] = 0;
            }
            $emailResult = $this->saveUserEmail($_POST['email'],$_POST['Email']['uid']);
            return $emailResult;
        }

        if(isset($_POST['password'])){
            $model->password = md5($_POST['password']);
            $model->save(false);
            echo json_encode($result = [
                'result' => true,
                'productId' => $model->user_id,
            ]);
            die;
        }

        /*foreach ($model->getMetadata()->columns as $temp) {
            $arr = json_decode($temp->comment);
            $fieldType[$arr->name] = $arr->field_input_type;
        }
        foreach ($fieldType as $key => $val) {
            if ($val == 'check') {
                $model->$key = explode(',', $model->$key);
            }
        }*/
        $this->render('update', array(
            'model' => $model,
            'payout' => $payout,
            'registrationStatus' => $registrationStatus
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        $user = UserInfo::model()->findByAttributes(['user_id' => $_POST['id']]);
        $ordertable = Yii::app()->db->schema->getTable('order_info');
        $wallettable = Yii::app()->db->schema->getTable('wallet');

        if($ordertable != ''){
            $orderinfo = OrderInfo::model()->findByAttributes(['user_id' => $_POST['id']]);
            if($orderinfo != ''){
                $orderLineItem = OrderLineItem::model()->findByAttributes(['order_info_id' => $orderinfo->order_info_id]);
                $orderPayment = OrderPayment::model()->findByAttributes(['order_info_id' => $orderinfo->order_info_id]);
                $creditMemo = OrderCreditMemo::model()->findByAttributes(['order_info_id' => $orderinfo->order_info_id]);

                if($orderLineItem != ''){
                    OrderLineItem::model()->deleteAll("order_info_id ='" . $orderinfo->order_info_id . "'");
                }

                if($orderPayment != ''){
                    OrderPayment::model()->deleteAll("order_info_id ='" . $orderinfo->order_info_id . "'");
                }

                if($creditMemo != ''){
                    OrderCreditMemo::model()->deleteAll("order_info_id ='" . $orderinfo->order_info_id . "'");
                }
            }
            if($orderinfo != ''){
                OrderInfo::model()->deleteAll("user_id ='" . $_POST['id'] . "'");
            }
        }
        if($wallettable != ''){
            $wallet = Wallet::model()->findByAttributes(['user_id' => $_POST['id']]);
            $userlicencecount = UserLicenseCount::model()->findByAttributes(['user_id' => $_POST['id']]);

            if($wallet != ''){
                Wallet::model()->deleteAll("user_id ='" . $_POST['id'] . "'");
            }

            if($userlicencecount != ''){
                UserLicenseCount::model()->deleteAll("user_id ='" . $_POST['id'] . "'");
            }
        }

        /*$this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/

        if($user->delete()){
            echo json_encode([
                'token' => 1,
            ]);
        }
        else{
            echo json_encode([
                'token' => 0,
            ]);
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('UserInfo');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $TableID = CylTables::model()->findByAttributes(['table_name' => UserInfo::model()->tableSchema->name]);
        $model = new UserInfo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserInfo']))
            $model->attributes = $_GET['UserInfo'];
        $alldata = UserInfo::model()->findAll();
        $this->render('admin', array(
            'TableID' => $TableID,
            'model' => $model,
            'alldata' => $alldata,
        ));
    }

    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata(){
        /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
        echo json_encode($alldata);*/

        $requestData = $_REQUEST;

//		$model= new UserInfo();
        $array_cols = Yii::app()->db->schema->getTable('user_info')->columns;
        $array = array();
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }
        /*$columns = array(
            0 => 'user_id',
            1 => 'full_name'
        );*/
        $columns = $array;

        $sql = "SELECT  * from user_info where 1=1";
//		$data = Yii::app()->db->createCommand($sql)->queryAll();
//		$totalFiltered = count($data);


        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( user_id LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != 'user_id')
                {
                    $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql.=")";
        }

        $j = 0;
        // getting records as per search parameters
        foreach($columns as $key=>$column){
            /*if($column == 'country')
            {

                if(!empty($requestData['columns'][28]['search']['value'])){
                    $countryname = $requestData['columns'][28]['search']['value'];
                    $codesql = "select country_code from countries where country_name LIKE "."'%$countryname%'";
                    $country_code = Yii::app()->db->createCommand($codesql)->queryAll();
                    if(!empty($country_code)){
                        $requestData['columns'][28]['search']['value'] = $country_code[0]['country_code'];
                    }
                }
            }*/

            if( !empty($requestData['columns'][$key]['search']['value']) ){
                if($column == 'sponsor_id'){
                    $sql.=" AND $column = ".$requestData['columns'][10]['search']['value']."";
                }if($column == 'country'){
                    $Country_code = $requestData['columns'][$key]['search']['value'];
                    $countryid = ServiceHelper::getCountryNameFromCode($Country_code);
                    $sql.=" AND $column = ".$countryid."";
                }else{
                    $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }
            }
            //if( !empty($requestData['columns'][$key]['search']['value']) ){   //name
            //$sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
            // }
            $j++;
        }

        $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;

        $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";


        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i=1;

        // echo "<pre>";
        // print_r($result);die;
        foreach ($result as $key => $row)
        {
            $nestedData = array();
            // $nestedData[] = $row['user_id'];
            if(ctype_alpha($row['country'])){
                $countrycode = $row['country'];
                $country_sql = "select country_name from countries where country_code = "."'$countrycode'";
                $country_name = Yii::app()->db->createCommand($country_sql)->queryAll();
                if(!empty($country_name)){
                    $row['country'] = $country_name[0]['country_name'];
                }
            }
            else if(is_numeric($row['country'])){
                $countryid = $row['country'];
                $country_sql = "select country_name from countries where id = "."'$countryid'";
                $country_name = Yii::app()->db->createCommand($country_sql)->queryAll();
                $row['country'] = $country_name[0]['country_name'];
            }
            if(!is_null($row['sponsor_id']) && $row['sponsor_id']!=''){
                if(isset(UserInfo::model()->findByPk($row['sponsor_id'])->full_name)){
                    $row['sponsor_id'] = UserInfo::model()->findByPk($row['sponsor_id'])->full_name;
                }
                else{
                    $row['sponsor_id'] = "";
                }
            }
            switch ($row['gender']){
                case 1:
                    $row['gender'] = 'Male';
                    break;
                case 2:
                    $row['gender'] = 'Female';
                    break;
            }

            foreach($array_cols as  $key=>$col){
                $nestedData[] = $row["$col->name"];
            }
//			$nestedData[] = $row["employee_age"];
//			$nestedData[] = '<a href="'.$url.'"><span class="glyphicon glyphicon-pencil"></span></a>';
            $data[] = $nestedData;
            $i++;
        }


        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data   // total data array
        );

        echo json_encode($json_data);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return UserInfo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = UserInfo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UserInfo $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-info-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * this action change user password
     * @param $id
     * @return json array
     */
    public function actionChangePassword($id){
        $model = UserInfo::model()->findByPk(['user_id' => $id]);

        if(isset($_POST['UserInfo'])){
            try {
                $model->password = md5($_POST['UserInfo']['newPassword']);
                $model->modified_at = date('Y-m-d H:i:s');
                if ($model->validate()) {
                    if($model->save())
                        $result = [
                            'result' => true
                        ];
                }
            }catch (Exception $e){
                $result = [
                    'result' => false,
                    'error' => $e
                ];
            }
            echo CJSON::encode($result);
        }else {
            $this->render('changePassword', array(
                'model' => $model,
            ));
        }
    }

    /**
     * this action active or inactive
     * @param $id
     */
    public function actionUserActive($id){
        $model = UserInfo::model()->findByPk(['user_id' => $id]);

        if(isset($_GET['is_active'])){
            if($_GET['is_active'] == 0){
                $model->is_active = 1;
            }else{
                $model->is_active = 0;
            }
            $model->modified_at = date('Y-m-d H:i:s');
            if($model->save()) {
                $this->redirect(['view','id' => $model->user_id ]);
            }
        }
    }

    /**
     * this action render genealogy view
     * @param $id
     */
    public function actionGenealogy($id){
        $model = UserInfo::model()->findByAttributes(['user_id'=>$id]);
        $orders = OrderInfo::model()->findAllByAttributes(['user_id' => $id]);
        $wallets = Wallet::model()->findAll([
            'select' => 'SUM(amount) as amount,wallet_id,wallet_type_id,reference_id,updated_balance',
            'condition' => "user_id = $id"
        ]);

        $this->renderPartial('genealogy',[
            'model' => $model,
            'orders' => $orders,
            'wallets' => $wallets
        ]);
    }


    public function actionUserorders($id){


        /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
        echo json_encode($alldata);*/

        $requestData = $_REQUEST;

//        $model= new OrderInfo();
        $array_cols = Yii::app()->db->schema->getTable('order_info')->columns;
        $array = array();
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }
        /*$columns = array(
            0 => 'user_id',
            1 => 'full_name'
        );*/
        $columns = $array;

        $sql = "SELECT  * from order_info where user_id=".$id;
//		$data = Yii::app()->db->createCommand($sql)->queryAll();
//		$totalFiltered = count($data);

        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( order_info_id LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != 'order_info_id')
                {
                    $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql.=")";
//			$sql.=" OR employee_age LIKE '" . $requestData['search']['value'] . "%')";

        }

        $j = 0;
        // getting records as per search parameters
        foreach($columns as $key=>$column){
            if($requestData['columns'][$key]['search']['value'] != ''){   //name
                if($column == 'user_id'){
                    $sql.=" AND  user_id = " . $requestData['columns'][$key]['search']['value'] . " ";
                }elseif($column == 'country'){
                    $Country_code = $requestData['columns'][$key]['search']['value'];
                    $countryid = ServiceHelper::getCountryNameFromCode($Country_code);
                    $sql.=" AND $column = ".$countryid."";
                }elseif($column == 'invoice_date' && $requestData['min'] != '' && $requestData['max'] != ''){
                    $sql .= " AND cast(invoice_date as date) between '$requestData[min]' and '$requestData[max]'";
                }else{
                    $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }
            }
            $j++;
        }

//		echo $sql;die;

        $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;

        $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";
        // echo $sql;die;
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i=1;

    /*echo "<pre>";
    print_r($result);die;*/
    foreach ($result as $key => $row)
    {
        $nestedData = array();
        // $nestedData[] = $row['order_info_id'];
        if(ctype_alpha($row['country'])){
            $countrycode = $row['country'];
            $country_sql = "select country_name from countries where country_code = "."'$countrycode'";
            $country_name = Yii::app()->db->createCommand($country_sql)->queryAll();
            $row['country'] = $country_name[0]['country_name'];
        }
        else if(is_numeric($row['country'])){
            $countryid = $row['country'];
            $country_sql = "select country_name from countries where id = "."'$countryid'";
            $country_name = Yii::app()->db->createCommand($country_sql)->queryAll();
            $row['country'] = $country_name[0]['country_name'];
        }
        $row['is_subscription_enabled'] = $row['is_subscription_enabled'] == 0? ('No') : ('Yes');

        //$row['sponsor_id_check'] = UserInfo::model()->findByPk($row['sponsor_id'])->full_name;
        switch($row['order_status']){
            case 0 :
                $row['order_status'] = "<span align='center' class='label label-table label-danger'>Cancelled</span>";
                break;
            case 1:
                $row['order_status'] = "<span align='center' class='label label-table label-success'>Success</span> ";
                break;
            default:
                break;
        }
        $row['user_id'] = $row['user_name']."<br><p class='text-muted'>".$row['email']."</p>";;
        foreach($array_cols as  $key=>$col){
            $nestedData[] = $row["$col->name"];
        }

//			$nestedData[] = $row["employee_age"];
//			$nestedData[] = '<a href="'.$url.'"><span class="glyphicon glyphicon-pencil"></span></a>';
            $data[] = $nestedData;
            $i++;
        }
        /*echo "<pre>";
        print_r($data);die;*/

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data   // total data array
        );

        echo json_encode($json_data);
    }



    /**
     * Manages data for server side datatables.
     */
    public function actionUserwallet($id){
//        echo $id;die;
        /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
        echo json_encode($alldata);*/

        $requestData = $_REQUEST;

//		$model= new wallet();
        $array_cols = Yii::app()->db->schema->getTable('wallet')->columns;
        $array = array();
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }
        /*$columns = array(
            0 => 'user_id',
            1 => 'full_name'
        );*/
        $columns = $array;

        $sql = "SELECT  * from wallet where user_id=".$id;
//		$data = Yii::app()->db->createCommand($sql)->queryAll();
//		$totalFiltered = count($data);

        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( wallet_id LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != 'id')
                {
                    $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql.=")";
//			$sql.=" OR employee_age LIKE '" . $requestData['search']['value'] . "%')";

        }

        $j = 0;
        // getting records as per search parameters
        foreach($columns as $key=>$column){
            if($requestData['columns'][$key]['search']['value'] != '' ){   //name
                if($column == 'user_id'){
                    $sql.=" AND  user_id = " . $requestData['columns'][$key]['search']['value'] . " ";
                }elseif($column == 'created_at' && $requestData['min'] != '' && $requestData['max'] != ''){
                    $sql .= " AND cast(created_at as date) between '$requestData[min]' and '$requestData[max]'";
                }else {
                    $sql .= " AND $column LIKE '%" . $requestData['columns'][$key]['search']['value'] . "%' ";
                }
            }
            $j++;
        }

//		echo $sql;die;

        $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;

        $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";

        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i=1;

        /*echo "<pre>";
        print_r($result);die;*/
        foreach ($result as $key => $row)
        {
            $nestedData = array();
            // $nestedData[] = $row['wallet_id'];

            $wallettypesql = "select wallet_type from wallet_type_entity where wallet_type_id ="."'$row[wallet_type_id]'";
            $wallettypenames = Yii::app()->db->createCommand($wallettypesql)->queryAll();

            $denominationsql = "select denomination_type from denomination where denomination_id="."'$row[denomination_id]'";
            $denominations = Yii::app()->db->createCommand($denominationsql)->queryAll();

            $row['wallet_type_id'] = $wallettypenames[0]['wallet_type'];
            $row['denomination_id'] = $denominations[0]['denomination_type'];

            switch($row['transaction_status']){
                case 0 :
                    $row['transaction_status'] = "<span class='label label-table label-warning'>Pending</span>";
                    break;
                case 1:
                    $row['transaction_status'] = "<span class='label label-table label-primary'>On Hold</span>";
                    break;
                case 2:
                    $row['transaction_status'] = "<span class='label label-table label-success'>Approved</span>";
                    break;
                case 3:
                    $row['transaction_status'] = "<span class='label label-table label-danger'>Rejected</span>";
                    break;
                default:
                    break;
            }

            switch($row['transaction_type']){
                case 0:
                    $row['transaction_type'] = 'Credit';
                    break;
                case 1:
                    $row['transaction_type'] = 'Debit';
                    break;
                default:break;
            }

            foreach($array_cols as  $key=>$col){
                $nestedData[] = $row["$col->name"];
            }
//			$nestedData[] = $row["employee_age"];
//			$nestedData[] = '<a href="'.$url.'"><span class="glyphicon glyphicon-pencil"></span></a>';
            $data[] = $nestedData;
            $i++;
        }
        /*echo "<pre>";
        print_r($data);die;*/

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data   // total data array
        );

        echo json_encode($json_data);
    }

    public function actionAddpermission(){
        $created_at = date('Y-m-d H:i:s');
        $modified_at = date('Y-m-d H:i:s');
        $controllerarray  =explode("/",$this->uniqueId);
        $controller = $controllerarray[1];

        if(isset($_POST['data'])){
            Yii::app()->db->createCommand("DELETE  FROM role_mapping WHERE `controller` = '$controller'")->execute();
            $data = explode("&",$_POST['data']);
            foreach($data as $key=>$value){
                $role = explode('=', $value);
                //print_r($role);die;
                $sql = "INSERT into role_mapping (`controller`,`role`,`allowed_actions`,`created_at`,`modified_at`) VALUES('$controller','$role[0]','$role[1]','$created_at','$modified_at')";
                Yii::app()->db->createCommand($sql)->execute();

            }

        }
    }
}
