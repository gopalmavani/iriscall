<?php

class CalldatarecordsController extends Controller
{
    public $layout = 'main';

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            //'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

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

    protected function beforeAction($action)
    {
        if (Yii::app()->user->isGuest) {
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
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }


    public function actionCompanydetails($id)
    {
        $model = OrganizationInfo::model()->findByPk($id);

        $this->render('companydetails',array(
            'model'=>$model,
        ));
    }


    public function actionView($id)
    {
        $data = $model=CallDataRecordsInfo::model()->findByPk($id);
        $organisation = OrganizationInfo::model()->findByAttributes(['organisation_id' => $data->organisation_id]);
        //$data->organisation_id = $organisation->name;
        $this->render('view',array(
            'model'=>$data,
            'organisation'=>$organisation,
        ));
    }

    public function actionInvoice(){
        try {
            $model=new OrganizationInfo;
            if(isset($_POST) && !empty($_POST['month']) && !empty($_POST['OrganizationInfo']['organisation_id'])){
                $org_id = $_POST['OrganizationInfo']['organisation_id'];
                $month = $_POST['month'];
                $start = date("Y-m-01", strtotime($month));
                $end = date("Y-m-t", strtotime($month));
                if($month != ''){
                    $getMonth = date("F, Y", strtotime($month));
                }else{
                    $getMonth = '';
                }
                $organisation = OrganizationInfo::model()->findByAttributes(['organisation_id' => $org_id]);
                $selected = ($getMonth != '') ? $organisation->name.' for '.$getMonth : $organisation->name;

                $data_array = [];

                /* National Call */
                $national_call_cdr_data = Yii::app()->db->createCommand("SELECT count(*) as total_time FROM `cdr_info` where organisation_id = ".$org_id." and (`comment` LIKE '%National Fixed Call%' or `comment` LIKE 'National Mobile Call') and date >= '".$start."' and date <= '$end'");
                $national_call_cdr_data = $national_call_cdr_data->queryRow();
                $national_call_total_time = 0;
                $min = '0';
                if(!empty($national_call_cdr_data['total_time']) && $national_call_cdr_data['total_time'] > 0){
                    $national_call_total_time = $national_call_cdr_data['total_time'];
                    array_push($data_array,['is_min'=>false,'rule'=>'Setup National call','min'=>$national_call_total_time,'total_time'=>$national_call_total_time,'cost'=>'0.025']);
                }

                /* National Fixed Call */
                $cdr_rules = $model=CdrCostRulesInfo::model()->findByAttributes(['comment'=>'National Fixed Call']);
                $national_fixed_call_cdr_data = Yii::app()->db->createCommand()
                    ->select('SEC_TO_TIME( SUM(time_to_sec(total_time))) as total_time')
                    ->from('cdr_info')
                    ->Where('organisation_id=:orgid',[':orgid'=>$org_id])
                    ->andWhere(['like', 'comment', '%'.$cdr_rules->comment.'%'])
                    ->andWhere('date>=:fn',[':fn'=>$start])
                    ->andWhere('date<=:fn1',[':fn1'=>$end])
                    ->queryRow();
                $time = '00:00:00';
                $min = '0';
                if(!empty($national_fixed_call_cdr_data['total_time'])){
                    $time = $national_fixed_call_cdr_data['total_time'];
                    $timesplit=explode(':',$time);
                    $min=($timesplit[0]*60)+($timesplit[1])+(round($timesplit[2]/60,2));
                }
                if($min > 0){
                    array_push($data_array,['is_min'=>true,'rule'=>'National Fixed call','total_time'=>$time,'min'=>$min,'cost'=>$cdr_rules->cost]);
                }

                /* National Mobile Call */
                $cdr_rules_2 = $model=CdrCostRulesInfo::model()->findByAttributes(['comment'=>'National Mobile Call']);
                $national_mobile_call_cdr_data = Yii::app()->db->createCommand()
                    ->select('SEC_TO_TIME( SUM(time_to_sec(total_time))) as total_time')
                    ->from('cdr_info')
                    ->Where('organisation_id=:orgid',[':orgid'=>$org_id])
                    ->andWhere(['like', 'comment', '%'.$cdr_rules_2->comment.'%'])
                    ->andWhere('date>=:fn',[':fn'=>$start])
                    ->andWhere('date<=:fn1',[':fn1'=>$end])
                    ->queryRow();
                $min2 = 0;
                $national_mobile_total_time = '00:00:00';
                if(!empty($national_mobile_call_cdr_data['total_time'])){
                    $time2 = $national_mobile_call_cdr_data['total_time'];
                    $timesplit2=explode(':',$time2);
                    $min2=($timesplit2[0]*60)+($timesplit2[1])+(round($timesplit2[2]/60,2));
                    $national_mobile_total_time = $national_mobile_call_cdr_data['total_time'];
                }
                if($min2 > 0){
                    array_push($data_array,['is_min'=>true,'rule'=>'National Mobile call','total_time'=>$national_mobile_total_time,'min'=>$min2,'cost'=>$cdr_rules_2->cost]);
                }

                /* International Call */
                $international_call_cdr_data = Yii::app()->db->createCommand()
                    ->select('count(*) as total_time')
                    ->from('cdr_info')
                    ->Where('organisation_id=:orgid',[':orgid'=>$org_id])
                    ->andWhere(['like', 'comment', '%International%'])
                    ->andWhere('date>=:fn',[':fn'=>$start])
                    ->andWhere('date<=:fn1',[':fn1'=>$end])
                    ->queryRow();
                $international_call_total_time = 0;
                if(!empty($international_call_cdr_data['total_time']) && $international_call_cdr_data['total_time'] > 0){
                    $international_call_total_time = $international_call_cdr_data['total_time'];
                    array_push($data_array,['is_min'=>false,'rule'=>'Setup International call','min'=>$international_call_total_time,'total_time'=>$international_call_total_time,'cost'=>'0.100']);
                }

                //All international call
                $all_international = Yii::app()->db->createCommand("SELECT DISTINCT comment, cost FROM cdr_cost_rules WHERE comment Like '%international call -%'");
                $all_international_cdr_rules = $all_international->queryAll();
                foreach($all_international_cdr_rules as $international_cdr_rule){
                    $international_cdr_data = Yii::app()->db->createCommand()
                        ->select('SEC_TO_TIME( SUM(time_to_sec(total_time))) as total_time')
                        ->from('cdr_info')
                        ->Where('organisation_id=:orgid',[':orgid'=>$org_id])
                        ->andWhere(['like', 'comment', '%'.$international_cdr_rule['comment'].'%'])
                        ->andWhere('date>=:fn',[':fn'=>$start])
                        ->andWhere('date<=:fn1',[':fn1'=>$end])
                        ->queryRow();
                    $min3 = 0;
                    $international_total_time = '00:00:00';
                    if(!empty($international_cdr_data['total_time'])){
                        $time3 = $international_cdr_data['total_time'];
                        $timesplit3=explode(':',$time3);
                        $min3=($timesplit3[0]*60)+($timesplit3[1])+(round($timesplit3[2]/60,2));
                        $international_total_time = $international_cdr_data['total_time'];
                    }
                    if($min3 > 0){
                        array_push($data_array,['is_min'=>true,'rule'=>$international_cdr_rule['comment'],'total_time'=>$international_total_time,'min'=>$min3,'cost'=>$international_cdr_rule['cost']]);
                    }
                }

                /* Number Of Users */
                $token = base64_encode(Yii::app()->params['com_username'].":".Yii::app()->params['com_password']);
                $url = 'https://rest.pbx.mytelephony.eu/company/'.$org_id.'/users';
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_SSL_VERIFYPEER=>false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Basic ".$token,
                        "content-type: application/json",
                        "Accept: application/vnd.iperity.compass.v3+json"
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $response = json_decode($response);
                $numberOfUsers = 0;
                $list = [];
                if(!empty($response)){
                    $numberOfUsers = (is_array($response) || is_object($response)) ? count($response) : '';
                    foreach($response as $res){
                        $list[] = $res->entityId;
                    }
                }
                $entityId = implode(', ', $list);
                if($numberOfUsers > 0){
                    array_push($data_array,['is_min'=>false,'rule'=>'Number Of Users','min'=>$numberOfUsers,'total_time'=> $numberOfUsers,'cost'=>'8','entityId'=>$entityId]);
                }

                /* External Numbers */
                $exUrl = 'https://rest.pbx.mytelephony.eu/company/'.$org_id.'/externalNumbers';//https://rest.apollo.compass-stack.com/company
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $exUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_SSL_VERIFYPEER=>false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Basic ".$token,
                        "content-type: application/json",
                        "Accept: application/vnd.iperity.compass.v3+json"
                    ),
                ));
                $externalNumber = curl_exec($curl);
                curl_close($curl);
                $externalNumber = json_decode($externalNumber);
                $numberOfExternalNumber = 0;
                $resource = [];
                if(!empty($externalNumber)){
                    $numberOfExternalNumber = (is_array($externalNumber) || is_object($externalNumber)) ? count($externalNumber) : '';
                    foreach($externalNumber as $data){
                        $resource[] = $data->resourceId;
                    }
                }
                $resourceId = implode(', ', $resource);
                if($numberOfExternalNumber > 0){
                    array_push($data_array,['is_min'=>false,'rule'=>'External Numbers','min'=>$numberOfExternalNumber,'total_time'=> $numberOfExternalNumber,'cost'=>'4','resourceId'=>$resourceId]);
                }
                $this->render('invoicedetail',[
                    'details'=>$data_array,
                    'org_id' => $org_id,
                    'selected' => $selected
                ]);
            }
            $this->render('createinvoice',[
                'model'=>$model
            ]);
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionCdrinfo()
    {
        $model=new CallDataRecordsInfo('search');
        //$model=new ProductInfo('search');
        $model->unsetAttributes();
        $this->render('calldata',[
            'model'=>$model,
        ]);
    }

    /**
     * This is the cdr details action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionCdrdetails()
    {
        $model = new CallDataRecordsInfo;
        $model->unsetAttributes();
        $this->render('cdrdetails',[
            'model' => $model,
        ]);
    }

    public function actionSettings()
    {
        $organizationInfo = OrganizationInfo::model()->findAll();
        $this->render('settings',[
            'organizationInfo' => $organizationInfo
        ]);
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new OrganizationInfo('search');
        //$model=new ProductInfo('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ProductInfo']))
            $model->attributes=$_GET['ProductInfo'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Create organization.
     */
    public function actionCreate()
    {
        try{
            $model = new OrganizationInfo;
            if (isset($_POST['OrganizationInfo'])) {
                $user = Yii::app()->user->getId();
                $model->attributes = $_POST['OrganizationInfo'];
                $model->user_id = $user;
                $model->created_at = date('Y-m-d H:i:s');
                if($model->save())
                    $this->redirect(array('companydetails', 'id' => $model->id));
            }
            $this->render('create', array(
                'model' => $model
            ));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        try{
            $model = OrganizationInfo::model()->findByPk($id);
            if (isset($_POST['OrganizationInfo'])) {
                $user = Yii::app()->user->getId();
                $model->attributes = $_POST['OrganizationInfo'];
                $model->user_id = $user;
                $model->modified_at = date('Y-m-d H:i:s');
                if($model->save())
                        $this->redirect(array('companydetails', 'id' => $model->id));
            }
            $this->render('update', array(
                'model' => $model
            ));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        $model = OrganizationInfo::model()->findByAttributes(['id' => $_POST['id']]);

        if(!empty($model)){
            if (OrganizationInfo::model()->deleteAll("id ='" .$model->id. "'")){
                echo json_encode([
                    'token' => 1,
                ]);
            }else{
                echo json_encode([
                    'token' => 0,
                ]);
            }
        }
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        try {
            ini_set('memory_limit', '-1');
            set_time_limit(0);
            if(isset($_POST) && !empty($_POST['month_year'] && $_POST['organization'])){
                $date_range = array();
                $myDateTime = DateTime::createFromFormat('F, Y', $_POST['month_year']);
                $start = strtotime($myDateTime->format('Y-m-01'));
                $end = strtotime($myDateTime->format('Y-m-t'));
                for ($i=$start; $i<=$end; $i+=86400) {
                    $date_range[] = date("Y-m-d", $i);
                }
                if($_POST['organization'] == 'All Organizations'){
                    $organizationInfo = OrganizationInfo::model()->findAll();
                    foreach ($organizationInfo as $org){
                        $organisation_id = $org['organisation_id'];
                        $fetchCDR = $this->fetchCDR($date_range, $organisation_id);
                    }
                }else{
                    $organisationInfo = OrganizationInfo::model()->findByAttributes(['name' => $_POST['organization']]);
                    $organisation_id = $organisationInfo->organisation_id;
                    $fetchCDR = $this->fetchCDR($date_range, $organisation_id);
                }
                echo $fetchCDR;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "<div align='center'><h3 style='color: red; margin-bottom: 0'>Failed to add CDR!!</h3></div>";
        }
    }
    public function fetchCDR($date_range, $organisation_id){
        $all_data = [];
        foreach ($date_range as $date){
            //old url for get cdr data
            //$fileUrl = 'https://files.apollo.compass-stack.com/cdr/'.$organisation_id.'/'.$date.'/company.csv';
            //New url for get cdr data
            $fileUrl = 'https://files.pbx.mytelephony.eu/cdr/'.$organisation_id.'/'.$date.'/company.csv';
            //The path & filename to save to.
            $saveTo = 'company.csv';
            $saveTo = $_SERVER['DOCUMENT_ROOT'].Yii::app()->baseUrl.'/uploads/cdr-csv/company.csv';
            //Open file handler.
            $fp = fopen($saveTo, 'w+');

            //If $fp is FALSE, something went wrong.
            if($fp === false){
                throw new Exception('Could not open: ' . $saveTo);
            }

            $token = base64_encode(Yii::app()->params['cdr_username'].":".Yii::app()->params['cdr_password']);
            //Create a cURL handle.
            $ch = curl_init($fileUrl);
            //Pass our file handle to cURL.
            curl_setopt($ch, CURLOPT_FILE, $fp);

            //Timeout if the file doesn't download after 20 seconds.
            curl_setopt($ch, CURLOPT_TIMEOUT, 9000);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER , array(
                "Authorization: Basic ".$token
            ));
            //Execute the request.
            curl_exec($ch);
            //If there was an error, throw an Exception
            if(curl_errno($ch)){
                throw new Exception(curl_error($ch));
            }
            //Get the HTTP status code.
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            //Close the cURL handler.
            curl_close($ch);
            //Close the file handler.
            fclose($fp);

            if($statusCode == 200) {
                $data = $this->csvToArray($saveTo, ',');
                $cdr_data = [];
                foreach ($data as $key => $value) {
                    if($value['from_type'] != 'external'){
                        if(empty($value['answer_time'])){
                            $value['answer_time'] = '0000-00-00 00:00:00';
                        }
                        $value['organisation_id'] = $organisation_id;
                        $value['unit_cost'] = '';
                        $value['date'] = $date;
                        $value['created_at'] = date('Y-m-d H:i:s');
                        $start_time = new DateTime($value['start_time']);
                        $end_time = new DateTime($value['end_time']);
                        $interval = date_diff($end_time,$start_time);
                        $total_time = $interval->format('%h:%i:%s');
                        // $diff = strtotime($value['end_time']) - strtotime($value['start_time']);
                        // $minutes = floor($diff / 60) ;
                        // $seconds = $diff % 60;
                        // $total_time = "00:$minutes:$seconds";
                        $value['total_time'] = $total_time;
                        $value['comment'] = '';
                        $value['created_at'] = date('Y-m-d H:i:s');
                        array_push($cdr_data, $value);
                    }
                }
                //echo "<pre>";print_r($cdr_data);
                if(!empty($cdr_data)){
                    $deleted = CallDataRecordsInfo::model()->deleteAll("organisation_id='" .$organisation_id."' and date = '".$date."'");
                    $connection = Yii::app()->db->getSchema()->getCommandBuilder();
                    $chunked_array = array_chunk($cdr_data, 5000);
                    $table_name = 'cdr_info';
                    foreach ($chunked_array as $chunk_array){
                        $command = $connection->createMultipleInsertCommand($table_name, $chunk_array);
                        $command->execute();
                        $logMessage = count($chunk_array)." records were inserted in ".$table_name.PHP_EOL;
                        file_put_contents('protected/runtime/insert.log', $logMessage, FILE_APPEND);
                    }
                }
            }
        }
        return "<div align='center'><h3 style='color: green; margin-bottom: 0'>Call Data Records added successfully!!</h3></div>";
    }


    public function actionGetfromnumber(){
        try{
            ini_set('memory_limit', '-1');
            set_time_limit(0);
            $response = [];
            if(isset($_POST) && !empty($_POST['month_year'] && $_POST['organization'])){
                $myDateTime = DateTime::createFromFormat('F, Y', $_POST['month_year']);
                $start = $myDateTime->format('Y-m-01');
                $end = $myDateTime->format('Y-m-t');
                $start_date = $start.' 00:00:00';
                $end_date = $end.' 23:59:59';
                if($_POST['organization'] == 'All Organizations'){
                    $organizationInfo = OrganizationInfo::model()->findAll();
                    foreach ($organizationInfo as $org){
                        $organisation_id = $org['organisation_id'];
                        $response = $this->updateFromNumber($start_date, $end_date, $organisation_id);
                    }
                }else{
                    $organisationInfo = OrganizationInfo::model()->findByAttributes(['name' => $_POST['organization']]);
                    $organisation_id = $organisationInfo->organisation_id;
                    $response = $this->updateFromNumber($start_date, $end_date, $organisation_id);
                }
            }
            echo json_encode($response);
        }catch (Exception $e) {
            echo $e->getMessage();
            echo "<div align='center'><h3 style='color: red; margin-bottom: 0'>Execution failed!!</h3></div>";
        }
    }

    public function updateFromNumber($start_date, $end_date, $organisation_id){
        // $cdr_data = Yii::app()->db->createCommand()
        //     ->select('distinct(from_id)')
        //     ->from('cdr_info')
        //     ->Where('from_id!=:fi',[':fi'=>''])
        //     //->andWhere('from_number=:fn',[':fn'=>''])
        //     ->queryAll();
        $query = Yii::app()->db->createCommand("SELECT DISTINCT(from_id) FROM `cdr_info` WHERE (start_time BETWEEN '$start_date' AND '$end_date') AND from_id != '' AND organisation_id = $organisation_id");
        $cdr_data = $query->queryAll();
        //echo "<pre>";print_r($cdr_data);die;
        $res_data = [];
        $res = [];
        if(!empty($cdr_data)){
            foreach ($cdr_data as $data){
                $from_id = $data['from_id'];
                $from_numer = '';
                $token = base64_encode(Yii::app()->params['cdr_username'].":".Yii::app()->params['cdr_password']);
                try{
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://rest.pbx.mytelephony.eu/identity/".$from_id,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 90000,
                        CURLOPT_SSL_VERIFYPEER=>false,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Basic ".$token
                        ),
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($response);
                    if(!empty($response)){
                        $resource_number = '';
                        if(isset($response->cli)){
                            $identity_number = explode("/",$response->cli);
                            $resource_number = end($identity_number);
                        }
                    }else{
                        $resource_number = '';
                    }
                    if(!empty($resource_number)){
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://rest.pbx.mytelephony.eu/resource/".$resource_number,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 999990,
                            CURLOPT_SSL_VERIFYPEER=>false,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => array(
                                "Authorization: Basic ".$token
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        $response = json_decode($response);
                        if(!empty($response)){
                            $from_numer = $response->number;
                        }
                    }
                    $res = [
                        'status' => 1,
                        'message' => 'Fetch from number completed.'
                    ];
                }catch(Exception $e){
                    $error = $e->getMessage();
                    print_r($error);die;
                    $res = [
                        'status' => 0,
                        'message' => $error
                    ];
                }
                try{
                    CallDataRecordsInfo::model()->updateAll(array('from_number' => $from_numer), 'from_id=:from_id AND from_number=:from_number',array(':from_id'=>$from_id,'from_number'=>''));
                    $res = [
                        'status' => 1,
                        'message' => "<div align='center'><h3 style='color: green; margin-bottom: 0'>Call data record updated!!</h3></div>"
                    ];
                }catch (Exception $e){
                    $error = $e->getMessage();
                    echo "<pre>";print_r($from_id);
                    print_r($error);die;
                    $res = [
                        'status' => 0,
                        'message' => $error
                    ];
                }
            }
        }
        $res_data = $res;
        //$this->redirect('cdrdetails');
        return $res_data;
    }

    public function actionCostcalculate(){
        try{
            $response = [];
            if(isset($_POST) && !empty($_POST['month_year'] && $_POST['organization'])){
                $myDateTime = DateTime::createFromFormat('F, Y', $_POST['month_year']);
                $start = $myDateTime->format('Y-m-01');
                $end = $myDateTime->format('Y-m-t');
                $start_date = $start.' 00:00:00';
                $end_date = $end.' 23:59:59';
                if($_POST['organization'] == 'All Organizations'){
                    $organizationInfo = OrganizationInfo::model()->findAll();
                    foreach ($organizationInfo as $org){
                        $organisation_id = $org['organisation_id'];
                        $response = $this->cdrCostCalculate($start_date, $end_date, $organisation_id);
                    }
                }else{
                    $organisationInfo = OrganizationInfo::model()->findByAttributes(['name' => $_POST['organization']]);
                    $organisation_id = $organisationInfo->organisation_id;
                    $response = $this->cdrCostCalculate($start_date, $end_date, $organisation_id);
                }
            }
            echo json_encode($response);
        }catch (Exception $e) {
            echo $e->getMessage();
            echo "<div align='center'><h3 style='color: red; margin-bottom: 0'>Execution failed!!</h3></div>";
        }
    }

    public function cdrCostCalculate($start_date, $end_date, $organisation_id){
        set_time_limit(0);
        $query = Yii::app()->db->createCommand("SELECT * FROM `cdr_info` WHERE (start_time BETWEEN '$start_date' AND '$end_date') AND organisation_id = $organisation_id");
        $cdr_data = $query->queryAll();
        $ar = [];
        $res = [];
        $data =[];
        $message = '<div class=row>';
        foreach ($cdr_data as $cdr){
            $model = CallDataRecordsInfo::model()->findByPk($cdr['id']);
            $tonumber = $cdr['to_number'];
            $diff = strtotime($cdr['end_time']) - strtotime($cdr['start_time']);
            $total_time = $diff;
            $fromnumber = $cdr['from_number'];
            /*$tonumber = '3214314051';
            $fromnumber = '3214813909';*/
            $cost_calculate = $this->calculateCost($tonumber,$total_time,$fromnumber);
            if($cost_calculate['cost'] == '0.00' && $cost_calculate['comment'] == '-'){
                $message .= "<div class=col-md-6><div class=col-md-12><span style='color: red;>".$tonumber."</span> number not match to CDR cost rules.</div></div>";
            }
            if($total_time <= 0){
                $comment = '-';
            }else{
                $comment = $cost_calculate['comment'];
            }
            /*array_push($data,[
                'id'=>$cdr['id'],
                'from_number'=>$cdr['from_number'],
                'from_no_count'=>strlen($cdr['from_number']),
                'to_number'=>$cdr['to_number'],
                'to_no_count'=>strlen($cdr['to_number']),
                'cost'=>$cost_calculate['cost'],
                'comment'=>$comment,
                'total_time'=>$total_time,
            ]);*/
            $model['unit_cost'] = $cost_calculate['cost'];
            $model['comment'] = $comment;
            $model->save(false);
        }
        //echo "<pre>";print_r($data);die;
        //$this->redirect('cdrdetails');
        $res = [
            'status' => 1,
            'message' => $message."</div><div align='center'><h3 style='color: green; margin-bottom: 0'>Cost calculation completed.</h3></div>"
        ];
        return $res;
    }

    /**
     * @param $tonumber
     * @param $totaltime
     */
    function calculateCost($tonumber,$totaltime,$fromnumber){
        $prefix_start_char = substr($tonumber, 0, 2);
        $to_strlen_prefix = strlen($tonumber);
        $from_strlen_prefix = strlen($fromnumber);
        /*$cost_rules = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cdr_cost_rules')
            ->where('digit=:digit',[':digit'=>$to_strlen_prefix])
            ->orWhere('date=:fndigit',[':fndigit'=>$from_strlen_prefix])
            ->orWhere('start_with=:str_with',[':str_with'=>$prefix_start_char])
            ->order('start_with asc')
            ->queryAll();*/
        $cost_rules = Yii::app()->db->createCommand("SELECT * FROM `cdr_cost_rules` where digit = ".$to_strlen_prefix." or from_number_digit = ".$from_strlen_prefix." or start_with = SUBSTRING($tonumber,0,LENGTH(start_with)) and from_number_start_with = SUBSTRING($tonumber,0,LENGTH(from_number_start_with)) ORDER BY start_with asc");
        $cost_rules = $cost_rules->queryAll();
        // $cost_rules = $cost_rules->text;
        $cost = '0.00';
        $comment = '-';
        foreach ($cost_rules as $rule){
            if($to_strlen_prefix == $rule['digit'] && $from_strlen_prefix == $rule['from_number_digit'] && $rule['from_number_start_with'] == substr($fromnumber, 0, strlen($rule['from_number_start_with']))){
                if(!empty($rule['from_number_digit']) && !empty($rule['from_number_start_with']) && !empty($rule['digit'])) {
                    if($rule['from_number_digit'] == $from_strlen_prefix && $rule['from_number_start_with'] == substr($fromnumber, 0, strlen($rule['from_number_start_with'])) && $rule['digit'] == $to_strlen_prefix){
                        $cost = $rule['cost'];
                        $comment = $rule['comment'];
                    }
                }
            } else if($to_strlen_prefix == $rule['digit']){
                if(empty($rule['from_number_digit']) && empty($rule['start_with'])){
                    $cost = $rule['cost'];
                    $comment = $rule['comment'];
                }if(empty($rule['from_number_digit']) && !empty($rule['start_with'])){
                    if($rule['start_with'] == substr($tonumber, 0, strlen($rule['start_with']))){
                        $cost = $rule['cost'];
                        $comment = $rule['comment'];
                    }
                }if(!empty($rule['from_number_digit']) && empty($rule['start_with'])) {
                    if($rule['from_number_digit'] == $from_strlen_prefix){
                        $cost = $rule['cost'];
                        $comment = $rule['comment'];
                    }
                }
            }
        }
        $result = array('cost'=>round($cost,3),'comment'=>$comment);
        return $result;
    }

    function csvtoarray($filename='', $delimiter){

        if(!file_exists($filename) || !is_readable($filename)) return FALSE;
        $header = NULL;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== FALSE ) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header){
                    $header = $row;
                }else{
                    $data_convert_int = [];
                    foreach ($row as $key => $val){
                        if($key == 9){
                            $val = (int)$val;
                        }
                        array_push($data_convert_int,$val);
                    }
                    //$data[] = array_combine($header, $row);
                    $data[] = array_combine($header, $data_convert_int);
                }
            }
            fclose($handle);
        }
        //if(file_exists($filename)) @unlink($filename);

        return $data;
    }

    public function actionServerdata(){
        /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
        echo json_encode($alldata);*/

        $requestData = $_REQUEST;

//		$model= new ProductInfo();
        $array_cols = Yii::app()->db->schema->getTable('company_info')->columns;
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

        $sql = "SELECT  * from company_info where 1=1";
//		$data = Yii::app()->db->createCommand($sql)->queryAll();
//		$totalFiltered = count($data);

        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( product_id LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != 'product_id')
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
                $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
            }
            $j++;
        }
//        echo $sql;die;


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
            $nestedData[] = $row['organisation_id'];
            //$row['is_subscription_enabled'] = $row['is_subscription_enabled'] == 0? ('No') : ('Yes');
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

    public function actionServercalldata(){

        $requestData = $_REQUEST;

        $array_cols = Yii::app()->db->schema->getTable('cdr_info')->columns;
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

        $sql = "SELECT  * from cdr_info where 1=1";
//		$data = Yii::app()->db->createCommand($sql)->queryAll();
//		$totalFiltered = count($data);

        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( callid LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != 'callid')
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
            //echo "<pre>";print_r($col->name);die;
            if($requestData['columns'][$key]['search']['value'] != ''){   //name
                $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
            }
            $j++;
        }
//        echo $sql;die;


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
            $nestedData[] = $row['organisation_id'];
            //$row['is_subscription_enabled'] = $row['is_subscription_enabled'] == 0? ('No') : ('Yes');
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

    public function actionCdrData(){

        $sql = "select id, organisation_id, from_number, from_name, to_number, unit_cost, date, total_time, comment  from cdr_info a where 1=1 ";
        $inputParams = $_GET;
        foreach ($inputParams as $key=>$value){
            if($value){
                $sql .= "and ". $key ." like '%". $value ."%' ";
            }
        }
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        echo json_encode($data);
    }

    public function actionUpdateCdrData(){
        $requestParams = Yii::app()->request->getRestParams();
        $cdr = CallDataRecordsInfo::model()->findByPk($requestParams['id']);
        $cdr->setAttributes($requestParams, false);

        $cdr->unit_cost = $requestParams['unit_cost'];
        $cdr->comment = $requestParams['comment'];
        $cdr->save(false);
    }

     /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateCdrCostRules()
    {
        $model = new CdrCostRulesInfo();
        // echo '<pre>';
        // print_r($model);die;
        if(isset($_POST['CdrCostRulesInfo']))
        {
            $model->attributes = $_POST['CdrCostRulesInfo'];
            $model->created_at = date('Y-m-d H:i:s');
    
            if($model->save())
                    $this->redirect(array('viewcdrcostrules', 'id' => $model->id));    
        }

        $this->render('createcdrcostrules', array(
            'model' => $model
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateCdrCostRules($id)
    {
        $model = $this->loadModel($id);

        if(isset($_POST['CdrCostRulesInfo']))
        {
            $model->attributes = $_POST['CdrCostRulesInfo'];
            $model->modified_at = date('Y-m-d H:i:s');

            if($model->save())
                    $this->redirect(array('viewcdrcostrules', 'id' => $model->id));
        }
        $this->render('updatecdrcostrules', array(
            'model' => $model
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewCdrCostRules($id)
    {
        $this->render('viewcdrcostrules',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteCdrCostRules()
    {
        $model = CdrCostRulesInfo::model()->findByAttributes(['id' => $_POST['id']]);

        if(!empty($model)){
            if (CdrCostRulesInfo::model()->deleteAll("id ='" .$model->id. "'")){
                echo json_encode([
                    'token' => 1,
                ]);
            }else{
                echo json_encode([
                    'token' => 0,
                ]);
            }
        }
    }

    /**
     * Manages all models.
     */
    public function actionCdrCostRules()
    {
        $model = new CdrCostRulesInfo('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['CdrCostRulesInfo']))
            $model->attributes = $_GET['CdrCostRulesInfo'];

        $this->render('cdrcostrules',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CdrCostRulesInfo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = CdrCostRulesInfo::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Manages data for server side datatables.
     */
    public function actionCdrcostrulesdata()
    {
        $requestData = $_REQUEST;

        $array_cols = Yii::app()->db->schema->getTable('cdr_cost_rules')->columns;
        $array = array();
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }
        /*$columns = array(
            0 => 'id',
            1 => 'name'
        );*/
        $columns = $array;

        $sql = "SELECT  * from cdr_cost_rules where 1=1";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $totalFiltered = count($data);

        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( id LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != 'id')
                {
                    $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql.=")";
        }

        $j = 0;
        // getting records as per search parameters
        foreach($columns as $key=>$column){
            if( !empty($requestData['columns'][$key]['search']['value']) ){   //name
                if($column == 'country'){
                    $Country_code = $requestData['columns'][$key]['search']['value'];
                    $countryid = ServiceHelper::getCountryNameFromCode($Country_code);
                    $sql.=" AND $column = ".$countryid."";
                }else{
                    $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }
            }
            $j++;
        }

        $data = Yii::app()->db->createCommand($sql)->queryAll();

        $totalData = count($data);
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
            $nestedData[] = $row['id'];
            foreach($array_cols as  $key=>$col){
                $nestedData[] = $row["$col->name"];
            }
			// $nestedData[] = $row["employee_age"];
			// $nestedData[] = '<a href="'.$url.'"><span class="glyphicon glyphicon-pencil"></span></a>';
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

    public function actionGenerateOrder()
    {
        $model = new OrderInfo;
        if(Yii::app()->request->isPostRequest){
            if(isset($_POST['details']) && $_POST['details'] != '' && isset($_POST['org_id']) && $_POST['org_id'] != ''){
                $details = json_decode($_POST['details']);
                $org_id = $_POST['org_id'];
                $orgInfo = OrganizationInfo::model()->findByAttributes(['organisation_id' => $org_id]);
                //$total = [];
                $orderTotal = 0;
                foreach($details as $value){
                    if(!empty($value->min) && $value->min > 0){
                        //$total[] = $value->min * $value->cost;
                        $orderTotal += $value->min * $value->cost;
                    }else{
                        $res = [
                            'status' => 0,
                            'message' => 'Zero quantity order can not be created.'
                        ];
                    }
                }
                if($orderTotal != 0){
                    //$orderTotal = $total[0] + $total[1] + $total[2] + $total[3];

                    //Get Latest order ID
                    $Order = OrderInfo::model()->find(array('order' => 'order_id DESC'));
                    if ($Order == '') {
                        $model->order_id = 1;
                    } else {
                        $model->order_id = $Order['order_id'] + 1;
                    }
                    $invoice_no = OrderHelper::getInvoiceNumber();
                    $model->invoice_number = $invoice_no;
                    $convert = strtotime($model->invoice_date);
                    $day = date("d", $convert);
                    $month = date("m", $convert);
                    $random = rand(1,9);
                    $reverse = strrev($model->invoice_number);
                    $fourDigit = substr($reverse,0,4);
                    $orderComment = '+++'.$random.$day.'/'.$random.$month.$random.'/'.$random.$fourDigit.'+++';
                    $model->order_comment = $orderComment;
                    $model->user_id = $orgInfo['user_id'];
                    $model->invoice_date = date('Y-m-d H:i:s');
                    $model->order_status = 1;
                    $model->company = $orgInfo['name'];
                    $model->user_name = $orgInfo['name'];
                    $model->created_date = date('Y-m-d H:i:s');
                    $model->vat = 0;
                    $model->discount = 0;
                    $model->orderTotal = $orderTotal;
                    $netTotal = $orderTotal - $model->discount + $model->vat;
                    $model->netTotal = $netTotal;
                    // echo '<pre>';
                    // print_r($model->netTotal);die;
                    if($model->save(false)){
                        //add direct sales bonus to wallet
                        OrderHelper::AddDirectSalesBonus($model->user_id, $model->order_id);
                        foreach($details as $detail){
                            $productInfo = ProductInfo::model()->findByAttributes(['name' => $detail->rule]);
                            if(!empty($productInfo)){
                                $orderItem = new OrderLineItem();
                                if($detail->is_min == 1){
                                    $convert = strtotime($detail->total_time);
                                    $hour = date('h', $convert);
                                    $minute = date('i', $convert);
                                    $time = $hour.' hours and '.$minute.' minutes'; 
                                    $orderItem->product_name = $detail->rule.' '.$time;
                                }else{
                                    $orderItem->product_name = $detail->rule;
                                }
                                if(!empty($detail->min) && $detail->min > 0){
                                    $orderItem->order_info_id = $model->order_info_id;
                                    $orderItem->item_qty = $detail->min;
                                    $orderItem->item_price = $detail->cost;
                                    $orderItem->product_id = $productInfo['product_id'];
                                    $orderItem->product_sku = $productInfo['sku'];
                                    $orderItem->created_at = date('Y-m-d H:i:s');
                                    if(!empty($detail->resourceId)){
                                        $orderItem->comment = $detail->resourceId;
                                    }
                                    if(!empty($detail->entityId)){
                                        $orderItem->comment = $detail->entityId;
                                    }
                                    $orderItem->save(false);
                                }
                            }
                        }
                    }
                    $orderPayment = new OrderPayment();
                    $orderPayment->order_info_id = $model->order_info_id;
                    $orderPayment->total = $model->netTotal;
                    $orderPayment->payment_mode = 2;
                    $orderPayment->payment_status = 2;
                    $orderPayment->payment_date = date('Y-m-d H:i:s');
                    $orderPayment->created_at = date('Y-m-d H:i:s');
                    $orderPayment->transaction_mode = 'Bank Transfer';
                    $orderPayment->denomination_id = 1;
                    if($orderPayment->save(false)){
                        $res = [
                            'status' => 1,
                            'message' => 'Order created successfully.',
                            'order_info_id' => $model->order_info_id
                        ];
                    }
                }
            }
        }
        echo json_encode($res);
    }
}

?>