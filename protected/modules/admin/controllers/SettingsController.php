<?php

class SettingsController extends Controller
{
    public $layout = 'main';

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

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $model=new OrganizationInfo;

        if(isset($_POST) && !empty($_POST['start_date'])){
            if(!empty($_POST['start_date'] && $_POST['end_date'] && $_POST['OrganizationInfo']['organisation_id'])){
                $date_range = array();
                $date_from = strtotime($_POST['start_date']); // Convert date to a UNIX timestamp
                $date_to = strtotime($_POST['end_date']); // Convert date to a UNIX timestamp
                // Loop from the start date to end date and output all dates inbetween
                for ($i=$date_from; $i<=$date_to; $i+=86400) {
                    $date_range[] = date("Y-m-d", $i);
                }
//                echo "<pre>";print_r($_SERVER['DOCUMENT_ROOT'].Yii::app()->baseUrl.'/uploads/cdr-csv/company.csv');die;
                $organisation_id = $_POST['OrganizationInfo']['organisation_id'];
                $all_data = [];
                foreach ($date_range as $date){
                    $fileUrl = 'https://files.apollo.compass-stack.com/cdr/'.$organisation_id.'/'.$date.'/company.csv';
                    //The path & filename to save to.
                    //$saveTo = 'company.csv';
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
                                $diff = strtotime($value['end_time']) - strtotime($value['start_time']);
                                $minutes = floor($diff / 60);
                                $seconds = $diff % 60;
                                $total_time = "00:$minutes:$seconds";
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
                $this->redirect('cdrinfo');
            }
        }
        $this->render('index',[
            'model'=>$model
        ]);
    }

    public function actionGetfromnumber(){
        $cdr_data = Yii::app()->db->createCommand()
            ->select('distinct(from_id)')
            ->from('cdr_info')
            ->Where('from_id!=:fi',[':fi'=>''])
            //->andWhere('from_number=:fn',[':fn'=>''])
            ->queryAll();
        //echo "<pre>";print_r($cdr_data);die;
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
                }catch(Exception $e){
                    $error = $e->getMessage();
                    print_r($error);die;
                }
                try{
                    CallDataRecordsInfo::model()->updateAll(array('from_number' => $from_numer), 'from_id=:from_id AND from_number=:from_number',array(':from_id'=>$from_id,'from_number'=>''));
                }catch (Exception $e){
                    $error = $e->getMessage();
                    echo "<pre>";print_r($from_id);
                    print_r($error);die;
                }
            }
        }
        $this->redirect('cdrinfo');
    }

    public function actionCostcalculate(){
        $cdr_data = $model=CallDataRecordsInfo::model()->findAll();
        $ar = [];
        set_time_limit(1000);
        $data =[];
        foreach ($cdr_data as $cdr){
            $model = CallDataRecordsInfo::model()->findByPk($cdr['id']);
            $tonumber = $cdr['to_number'];
            $diff = strtotime($cdr['end_time']) - strtotime($cdr['start_time']);
            $total_time = $diff;
            $fromnumber = $cdr['from_number'];
            $cost_calculate = $this->calculateCost($tonumber,$total_time,$fromnumber);
            //echo "<pre>";print_r($cost_calculate);
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
        $this->redirect('cdrinfo');
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
        $cost_rules = Yii::app()->db->createCommand("SELECT * FROM `cdr_cost_rules` where digit = ".$to_strlen_prefix." or from_number_digit = ".$from_strlen_prefix." or start_with = SUBSTRING($tonumber,0,LENGTH(start_with)) ORDER BY start_with asc");
        $cost_rules = $cost_rules->queryAll();
        $cost = '0.00';
        $comment = '-';
        foreach ($cost_rules as $rule){
            if($to_strlen_prefix == $rule['digit']){
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
}

?>