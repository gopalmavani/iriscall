<?php

class NautilusController extends CController
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
     * Manages all models.
     */
    public function actionRegistration()
    {
        $model = new NuRegistrations('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['NuRegistrations']))
            $model->attributes = $_GET['NuRegistrations'];
        $alldata = NuRegistrations::model()->findAll();
        $this->render('registration', array(
            'model' => $model,
            'alldata' => $alldata,
        ));
    }

    public function actionDeposits()
    {
        $model = new NuClientDepositWithdraw('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['NuClientDepositWithdraw']))
            $model->attributes = $_GET['NuClientDepositWithdraw'];
        $alldata = NuRegistrations::model()->findAll();
        $this->render('deposits', array(
            'model' => $model,
            'alldata' => $alldata,
        ));
    }

    public function actionDepositsupdate($id){
        $model = NuClientDepositWithdraw::model()->findByAttributes(['id'=>$id]);
        if(isset($_POST['NuClientDepositWithdraw'])){
            $model->attributes = $_POST['NuClientDepositWithdraw'];
            $model->modified_at = date('Y-m-d h:i:s');
            if($model->validate()){
                if($model->save()){
                    $this->redirect(array('depositsview','id'=>$model->id));
                }
            }
            else{
                print_r($model->getErrors());
            }
        }
        $this->render('depositsupdate', array(
            'model' => $model,
        ));
    }

    public function actionDepositsview($id){
        $model = NuClientDepositWithdraw::model()->findByAttributes(['id'=>$id]);
        $this->render('depositsview',array(
            'model'=>$model,
        ));
    }
    public function actionRegistrationview($id){
        $model = NuRegistrations::model()->findByAttributes(['id'=>$id]);
        $kyc = NuKyc::model()->findAllByAttributes(['registration_id' => $model->id]);
        $deposit = NuClientDepositWithdraw::model()->findAllByAttributes(['user_id' => $model->user_id]);
        $this->render('registrationview',array(
            'model'=>$model,
            'kyc' => $kyc,
            'deposit' => $deposit
        ));
    }



    public function actionServerdata(){
        /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
        echo json_encode($alldata);*/

        $requestData = $_REQUEST;

//		$model= new ProductInfo();
        $array_cols = Yii::app()->db->schema->getTable('nu_registrations')->columns;
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

        $sql = "SELECT  * from nu_registrations where 1=1";
//		$data = Yii::app()->db->createCommand($sql)->queryAll();
//		$totalFiltered = count($data);

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
//			$sql.=" OR employee_age LIKE '" . $requestData['search']['value'] . "%')";

        }

        $j = 0;
        // getting records as per search parameters
        foreach($columns as $key=>$column){
            if($requestData['columns'][$key]['search']['value'] != ''){   //name
                if($column == 'user_id'){
                    $name = $requestData['columns'][$key]['search']['value'];
                    $sql = "SELECT  t.*,count(*) as columncount FROM nu_registrations t
                            LEFT JOIN user_info u ON u.user_id = t.user_id where u.full_name LIKE '%$name%'";
                }
                elseif($column == 'country'){
                    $Country_code = $requestData['columns'][$key]['search']['value'];
                    $countryid = ServiceHelper::getCountryNameFromCode($Country_code);
                    $sql.=" AND $column = ".$countryid."";
                }elseif($column == 'created_at' && $requestData['min'] != '' && $requestData['max'] != ''){
                    $sql .= " AND cast(created_at as date) between '$requestData[min]' and '$requestData[max]'";
                }else {
                    $sql .= " AND $column LIKE '%" . $requestData['columns'][$key]['search']['value'] . "%' ";
                }
            }
            $j++;
        }
//        echo $sql;die;

        if(strpos($sql,'JOIN')){
            $sql.= " GROUP by t.id";
            $count_sql = $sql;
        }
        else{
            $count_sql = str_replace("*","count(*) as columncount",$sql);
        }

        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = '';
        $totalFiltered = '';
        if(!empty($data)){
            $totalData = $data[0]['columncount'];
            $totalFiltered = $totalData;
        }


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
            $nestedData[] = $row['id'];

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

            if(!empty($row['user_id'])){
                $sql = "SELECT full_name from user_info where user_id = ".$row['user_id'];
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                if(!empty($result)){
                    $row['user_id'] = $result[0]['full_name'];
                }
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
    public function actionServerdatadeposits(){
        /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
        echo json_encode($alldata);*/

        $requestData = $_REQUEST;

//		$model= new ProductInfo();
        $array_cols = Yii::app()->db->schema->getTable('nu_client_DepositWithdraw')->columns;
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

        $sql = "SELECT  * from  nu_client_DepositWithdraw where 1=1";
//		$data = Yii::app()->db->createCommand($sql)->queryAll();
//		$totalFiltered = count($data);

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
//			$sql.=" OR employee_age LIKE '" . $requestData['search']['value'] . "%')";

        }

        $j = 0;
        // getting records as per search parameters
        foreach($columns as $key=>$column){
            if($requestData['columns'][$key]['search']['value'] != ''){   //name
                if($column == 'user_id'){
                    $name = $requestData['columns'][$key]['search']['value'];
                    $sql = "SELECT  t.*,count(*) as columncount FROM nu_client_DepositWithdraw t
                            LEFT JOIN user_info u ON u.user_id = t.user_id where u.full_name LIKE '%$name%'";
                }else{
                    $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }
            }
            $j++;
        }
//        echo $sql;die;


        if(strpos($sql,'JOIN')){
            $sql.= " GROUP by t.id";
            $count_sql = $sql;
        }
        else{
            $count_sql = str_replace("*","count(*) as columncount",$sql);
        }

        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = '';
        $totalFiltered = '';
        if(!empty($data)){
            $totalData = $data[0]['columncount'];
            $totalFiltered = $totalData;
        }


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
            $nestedData[] = $row['id'];

            switch ($row['status']) {
                case 0 :
                    $row['status'] = "<span class='label label-danger'>Pending</span>";
                    break;
                case 1:
                    $row['status'] = "<span class='label label-success'>Approved</span>";
                    break;
                case 2:
                    $row['status'] = "<span class='label label-primary'>Processed</span>";
                    break;
                default:
                    break;
            }

            if(!empty($row['user_id'])){
                $sql = "SELECT full_name from user_info where user_id = ".$row['user_id'];
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                if(!empty($result)){
                    $row['user_id'] = $result[0]['full_name'];
                }
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

}