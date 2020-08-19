<?php

class SubscriptionController extends CController
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
        return UserIdentity::accessRules();
    }

    /*
     * Manage all subscriptions
     * */
    public function actionAdmin(){

        // subscription count
        $orders = Yii::app()->db->createCommand()
            ->select('COUNT(*) as totalSubs')
            ->from('product_subscription')
            ->queryRow();

        $model = new ProductSubscription('search');
        $model->unsetAttributes();  // clear any default values

        if(isset($_COOKIE['portalId']) && $_COOKIE['portalId'] > 0) {
            $portal = " portal_id = ".$_COOKIE['portalId']." AND ";
        }else{
            $portal = '';
        }

        $pending = Yii::app()->db->createCommand('SELECT COUNT(*) AS pending_subs, SUM(subscription_price) AS total_amount FROM product_subscription WHERE '.$portal.' next_renewal_date < "'.date('Y-m-d').'23:59:59"')->queryRow();
        $end_date = date("Y-m-t", strtotime(date("Y-m-d")));
        $upcoming = Yii::app()->db->createCommand('SELECT COUNT(*) AS upcoming_subs, SUM(subscription_price) AS total_amount FROM product_subscription WHERE '.$portal.' next_renewal_date BETWEEN "'.date('Y-m-d').' 23:59:59" AND "'.$end_date.' 23:59:59" ')->queryRow();
        $new = Yii::app()->db->createCommand('SELECT COUNT(*) AS new_subs, SUM(subscription_price) AS total_amount FROM product_subscription WHERE '.$portal.' created_at > "'.date('Y-m-01').' 00:00:00" AND created_at < "'.$end_date.' 23:59:59"')->queryRow();
        //echo $new; die;

        if(isset($_GET['ProductSubscription']))
            $model->attributes=$_GET['ProductSubscription'];



        $this->render('admin',array(
            'model'=>$model,
            'subsCount'=>$orders['totalSubs'],
            'pending' => $pending,
            'upcoming' => $upcoming,
            'new' => $new
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id){
        $data = ProductSubscription::model()->findByPk($id);
        $this->render('view',[
            'data'=>$data
        ]);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id){
//        echo $id;die;
        $model = ProductSubscription::model()->findByPk($id);
        if(isset($_POST['ProductSubscription'])){
            $model->attributes = $_POST['ProductSubscription'];
            if($model->validate())
            {
                if($model->save()){
                    $this->redirect(['view','id' => $id]);
                }
            }
            else {
                /*print_r($model->getErrors());die;*/
                echo json_encode([
                    'error' => $model->getErrors()
                ]);
            }
        }

        $userName = UserInfo::model()->findByPk($model->user_id)->full_name;
//        $productName = ProductInfo::model()->findByPk($model->product_id)->name;
        $this->render('update',[
            'model'=>$model,
            'userName'=>$userName,
            'productName'=>$model->product_name,
        ]);
    }

    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata(){
        /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
        echo json_encode($alldata);*/

        $requestData = $_REQUEST;

        $model= new ProductSubscription();
        $array_cols = Yii::app()->db->schema->getTable('product_subscription')->columns;
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

        $sql = "SELECT  * from product_subscription where 1=1";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $totalFiltered = count($data);

        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( s_id LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != 's_id')
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
            if( !empty($requestData['columns'][$key]['search']['value']) ){   //name
                if ($column == 'next_renewal_date'){
                    if($requestData['next_renewal_date_min']!= '' && $requestData['next_renewal_date_max'] != ''){
                        $nextRenewFrom = date('Y-m-d',strtotime(str_replace("-","-",$requestData['next_renewal_date_min'])))." 00:00:00";
                        $nextRenewTo = date('Y-m-d',strtotime(str_replace("-","-",$requestData['next_renewal_date_max'])))." 23:59:59";
                        $sql.=" AND cast(next_renewal_date as date) between '$nextRenewFrom'  and '$nextRenewTo' ";
                    }
                }elseif($column == 'starts_at'){
                    if($requestData['starts_at_min']!= '' && $requestData['starts_at_max'] != ''){
                        $startAtFrom = date('Y-m-d',strtotime(str_replace("-","-",$requestData['starts_at_min'])))." 00:00:00";
                        $startAtTo = date('Y-m-d',strtotime(str_replace("-","-",$requestData['starts_at_max'])))." 23:59:59";
                        $sql.=" AND cast(starts_at as date) between '$startAtFrom'  and '$startAtTo' ";
                    }
                }elseif($column == 'subscription_status'){
                    $sql.=" AND $column = ".$requestData['columns'][$key]['search']['value']."";
                }else{
                    $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }
            }

            $j++;
        }

        //echo $sql;die;
        $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;

        /*$data = Yii::app()->db->createCommand($sql)->queryAll();
        $totalData = count($data);
        $totalFiltered = $totalData;*/

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
            $nestedData[] = $row['s_id'];

            //$username_sql = "select full_name from user_info where user_id = "."'$row[user_id]'";
            //$user_names = Yii::app()->db->createCommand($username_sql)->queryAll();


            $class = '';
            if ($row['subscription_status'] == 0 ){
                $class = 'warning';
            }elseif ($row['subscription_status'] == 2){
                $class = 'success';
            }else{
                $class = 'danger';
            }
            $row['subscription_status'] = '<label class="label label-'.$class.'">'.CylFieldValues::model()->findByAttributes(['field_id' => 245, 'predefined_value' => $row['subscription_status']])->field_label.'</label>';
            $row['next_renewal_date'] = date('d-M-Y',strtotime(str_replace("-","/",$row['next_renewal_date'])));
            $row['starts_at'] = date('d-M-Y',strtotime(str_replace("-","/",$row['starts_at'])));
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
    public function actionSubscriptionData($id)
    {

        $requestData = $_REQUEST;

        $model = new OrderInfo();
        $array_cols = Yii::app()->db->schema->getTable('order_info')->columns;
        $array = array();
        $i = 0;
        foreach ($array_cols as $key => $col) {
            $array[$i] = $col->name;
            $i++;
        }
        /*$columns = array(
            0 => 'user_id',
            1 => 'full_name'
        );*/
        $columns = $array;

        if(isset($_COOKIE['portalId']) && $_COOKIE['portalId'] > 0) {
            $sql = "SELECT o.* FROM order_info o LEFT JOIN order_subscription_mapping AS osm ON osm.order_id = o.order_id LEFT JOIN product_subscription AS ps ON ps.s_id = osm.subscription_id WHERE ps.s_id = $id AND o.portal_id= ".$_COOKIE['portalId'];
        }else{
            $sql = "SELECT o.* FROM order_info o LEFT JOIN order_subscription_mapping AS osm ON osm.order_id = o.order_id LEFT JOIN product_subscription AS ps ON ps.s_id = osm.subscription_id WHERE ps.s_id = $id";
        }
//		$data = Yii::app()->db->createCommand($sql)->queryAll();
//		$totalFiltered = count($data);

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( order_info_id LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach ($array_cols as $key => $col) {
                if ($col->name != 'order_info_id') {
                    $sql .= " OR " . $col->name . " LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql .= ")";
//			$sql.=" OR employee_age LIKE '" . $requestData['search']['value'] . "%')";

        }

        $j = 0;
        // getting records as per search parameters
        foreach ($columns as $key => $column) {
            if ($requestData['columns'][$key]['search']['value'] != '') {   //name
                if ($column == 'user_id') {
                    $sql .= " AND  o.user_id = " . $requestData['columns'][$key]['search']['value'] . " ";
                } elseif ($column == 'created_date') {
                    if ($requestData['created_at_min'] != '' && $requestData['created_at_max'] != '') {
                        $sql .= " AND cast(o.created_date as date) between '$requestData[created_at_min] 00:00:00'  and '$requestData[created_at_max] 23:59:59' ";
                    }
                } elseif ($column == 'invoice_date') {
                    if ($requestData['invoice_min'] != '' && $requestData['invoice_max'] != '') {
                        $sql .= " AND cast(o.invoice_date as date) between '$requestData[invoice_min] 00:00:00'  and '$requestData[invoice_max] 23:59:59' ";
                    }
                } elseif ($column == 'country') {
                    $sql .= " AND country IN (SELECT id FROM countries WHERE country_name LIKE '%".$requestData['columns'][$key]['search']['value']."%')";
                } else {
                    $sql .= " AND o.$column LIKE '%" . $requestData['columns'][$key]['search']['value'] . "%' ";
                }
            }
            $j++;
        }
        $count_sql = str_replace("o.*", "count(*) as columncount", $sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;


        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";


        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i = 1;

        foreach ($result as $key => $row) {
            $nestedData = array();
            $nestedData[] = $row['order_info_id'];
            if (ctype_alpha($row['country'])) {
                $countrycode = $row['country'];
                $country_sql = "select country_name from countries where country_code = " . "'$countrycode'";
                $country_name = Yii::app()->db->createCommand($country_sql)->queryAll();
                if (!empty($country_name)) {
                    $row['country'] = $country_name[0]['country_name'];
                }
            } else if (is_numeric($row['country'])) {
                $countryid = $row['country'];
                $country_sql = "select country_name from countries where id = " . "'$countryid'";
                $country_name = Yii::app()->db->createCommand($country_sql)->queryAll();
                if (!empty($country_name)) {
                    $row['country'] = $country_name[0]['country_name'];
                }
            }

            $row['is_subscription_enabled'] = $row['is_subscription_enabled'] == 0 ? ('No') : ('Yes');

            //$row['user_id'] = $row['user_name'];

            switch ($row['order_status']) {
                case 0 :
                    $row['order_status'] = "<span class='label label-danger'>Cancelled</span>";
                    break;
                case 1:
                    $row['order_status'] = "<span class='label label-success'>Success</span>";
                    break;
                default:
                    break;
            }

            $row['created_date'] = date('Y-m-d', strtotime(str_replace('-', '/', $row['created_date'])));
            $row['invoice_date'] = date('Y-m-d', strtotime(str_replace('-', '/', $row['created_date'])));


            foreach ($array_cols as $key => $col) {
                $nestedData[] = $row["$col->name"];
            }

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