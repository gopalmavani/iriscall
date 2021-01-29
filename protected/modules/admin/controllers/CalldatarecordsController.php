<?php

class CalldatarecordsController extends Controller
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


    public function actionCompanydetails($id)
    {
        $data = $model=OrganizationInfo::model()->findByPk($id);

        $this->render('companydetails',array(
            'model'=>$data,
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
        $model=new OrganizationInfo;
        if(isset($_POST) && !empty($_POST['month']) && !empty($_POST['OrganizationInfo']['organisation_id'])){
            $org_id = $_POST['OrganizationInfo']['organisation_id'];
            $month = $_POST['month'];
            $start = date("Y-m-01", strtotime($month));
            //$end = date(date('Y-'. $month .'-' . 't', strtotime($start)) );
            $end = $month;
            /*$start = '2020-12-01';
            $end = '2020-12-31';*/
            $data_array = [];
            /* first row */
            $national_call_cdr_data = Yii::app()->db->createCommand("SELECT count(*) as total_time FROM `cdr_info` where organisation_id = ".$org_id." and (`comment` LIKE '%National Fixed Call%' or `comment` LIKE 'National Mobile Call') and date >= '".$start."' and date <= '$end'");
            $national_call_cdr_data = $national_call_cdr_data->queryRow();
                /*->select('count(*) as total_time')
                ->from('cdr_info')
                ->Where('organisation_id=:orgid',[':orgid'=>$org_id])
                ->andWhere(['like', 'comment', '%National%'])
                ->andWhere(['Not like', 'comment', '%International Call%'])
                //->orWhere(['like', 'comment', '%National Mobile Call%'])
                ->andWhere('date>=:fn',[':fn'=>$start])
                ->andWhere('date<=:fn1',[':fn1'=>$end])
                ->queryRow();*/
            $national_call_total_time = 0;
            $min = '0';
            if(!empty($national_call_cdr_data['total_time'])){
                $national_call_total_time = $national_call_cdr_data['total_time'];
                /*if(!empty($national_call_total_time)){
                    $time = $national_call_total_time;
                    $timesplit=explode(':',$time);
                    $min=($timesplit[0]*60)+($timesplit[1])+(round($timesplit[2]/60,2));
                }*/
            }
            array_push($data_array,['is_min'=>false,'rule'=>'Setup National call','min'=>$national_call_total_time,'total_time'=>$national_call_total_time,'cost'=>'0.025']);
            /* second row */
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
            array_push($data_array,['is_min'=>true,'rule'=>'National Fixed call','total_time'=>$time,'min'=>$min,'cost'=>$cdr_rules->cost]);

            /* third row */
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
            array_push($data_array,['is_min'=>true,'rule'=>'National Mobile call','total_time'=>$national_mobile_total_time,'min'=>$min2,'cost'=>$cdr_rules_2->cost]);

            /* fourth row */
            $international_call_cdr_data = Yii::app()->db->createCommand()
                ->select('count(*) as total_time')
                ->from('cdr_info')
                ->Where('organisation_id=:orgid',[':orgid'=>$org_id])
                ->andWhere(['like', 'comment', '%International%'])
                ->andWhere('date>=:fn',[':fn'=>$start])
                ->andWhere('date<=:fn1',[':fn1'=>$end])
                ->queryRow();
            $intenational_total_time = 0;
            if(!empty($international_call_cdr_data['total_time'])){
                $intenational_total_time = $international_call_cdr_data['total_time'];
            }
            array_push($data_array,['is_min'=>false,'rule'=>'Setup International call','min'=>$intenational_total_time,'total_time'=>$intenational_total_time,'cost'=>'0.100']);
            $this->render('invoicedetail',[
                'details'=>$data_array
            ]);
        }
        $this->render('createinvoice',[
            'model'=>$model
        ]);
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

        $getDate = $requestParams['date'];
        $newDate = date("Y-m-d", strtotime($getDate));

        $cdr->from_number = $requestParams['from_number'];
        $cdr->from_name = $requestParams['from_name'];
        $cdr->to_number = $requestParams['to_number'];
        $cdr->unit_cost = $requestParams['unit_cost'];
        $cdr->date = $newDate;
        $cdr->total_time = $requestParams['total_time'];
        $cdr->comment = $requestParams['comment'];
        $cdr->save(false);
    }
}

?>