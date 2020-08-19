<?php

class BookingController extends CController
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
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
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Booking;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Booking']))
        {
            $model->attributes=$_POST['Booking'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->booking_id));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Booking']))
        {
            $model->attributes=$_POST['Booking'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->booking_id));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        $id = $_POST['id'];

        if($this->loadModel($id)->delete()){
            $_SESSION['delete'] = "Booking deleted successfully";
            echo json_encode([
                'token' => 1,
            ]);
        }
        else{
            echo json_encode([
                'token' => 0,
            ]);
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        /*if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->redirect('admin');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $TableID = CylTables::model()->findByAttributes(['table_name' => Booking::model()->tableSchema->name]);
        $model = new Booking('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Booking']))
            $model->attributes = $_GET['Booking'];
        $alldata = Booking::model()->findAll();

        $sql = "SELECT DISTINCT u.full_name,e.event_host FROM events e LEFT JOIN user_info u on e.event_host = u.user_id where 1=1";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $this->render('admin', array(
            'TableID' => $TableID,
            'model' => $model,
            'alldata' => $alldata,
            'hosts' => $result,
        ));
    }

    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata(){
        $currentrole = Yii::app()->user->role;

        $requestData = $_REQUEST;

        $model = new Booking;
        $primary_key = $model->tableSchema->primaryKey;
        $array_cols = Yii::app()->db->schema->getTable(Booking::model()->tableSchema->name)->columns;
        $array = array();
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }

        $columns = $array;

        if($currentrole != "admin"){
            $userid = Yii::app()->user->id;
            $sql = "SELECT  b.*,e.event_title FROM booking b LEFT JOIN events e ON b.event_id = e.event_id where e.event_host = ".$userid;
        }
        else{
            if($_REQUEST['host'] != ""){
                $sql = "SELECT  b.*,e.event_title FROM booking b LEFT JOIN events e ON b.event_id = e.event_id where e.event_host = ".$_REQUEST['host'];
            }
            else{
                $sql = "SELECT  b.*,e.event_title FROM booking b LEFT JOIN events e ON b.event_id = e.event_id where 1=1";
            }
        }

        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( $primary_key LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != $primary_key)
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
                if($column == "event_id"){
                    $sql .= " AND e.event_title LIKE '%".$requestData['columns'][$key]['search']['value']."%'";
                }
                else if($column != "booking_id"){
                    $sql.=" AND b.$column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }
            }
            $j++;
        }

        $count_sql = str_replace("b.*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;


        $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";

        $result = Yii::app()->db->createCommand($sql)->queryAll();
//    echo "<pre>";
//    print_r($result);die;

        $data = array();
        $i=1;


        foreach ($result as $key => $row)
        {
            $nestedData = array();
            $nestedData[] = $row[$primary_key];
            $row['event_id'] = $row['event_title'];
            foreach($array_cols as  $key=>$col){
                $nestedData[] = $row["$col->name"];
            }

            $data[] = $nestedData;
            $i++;
        }

        /*if(empty($data[0][0])){
            $data = array();
        }*/


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
     * @return Booking the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Booking::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Booking $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='booking-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    /**
     * Opens a page for calendar view for Bookings.
     */
    public function actionCalendarview(){
        $items = array();
        $currentrole = Yii::app()->user->role;
        if($currentrole != "admin") {
            $userid = Yii::app()->user->id;
            $sql = "SELECT event_id from events where event_host = ".$userid;
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            $eventids = array();

            foreach ($result as $key=>$value){
                array_push($eventids,$value['event_id']);
            }

            $model= Booking::model()->findAllByAttributes(['event_id'=>$eventids]);
        }
        else{
            $model= Booking::model()->findAll();
        }
        foreach ($model as $value) {
            $items[]=array(
                'id' => $value->booking_id,
                'title' =>$value->username,
                'start' =>$value->created_at,
                'end' =>$value->created_at,
                'data' => ['user_id' => $value->event_id],
                //'color'=>'#CC0000',
                //'allDay'=>true,
                //'url'=>'http://anyurl.com'
            );
        }

        $sql = "SELECT distinct u.full_name,e.event_host from events e LEFT JOIN user_info u on e.event_host = u.user_id where 1=1";
        $result = Yii::app()->db->createCommand($sql)->queryAll();


        $this->render('calendarview', array('events' => $items,'hosts'=>$result));
    }


    /**
     * shows specific events for particular event hosts.
     */
    public function actionBookinghosts($id){
        $currentrole = Yii::app()->user->role;
        if($currentrole == "admin"){
            $eventhost = $id;
            $sql1 = "SELECT event_id from events where event_host = ".$eventhost;
            $result1 = Yii::app()->db->createCommand($sql1)->queryAll();
            $eventids = array();
            if(!empty($result1)){
                foreach ($result1 as $key=>$value){
                    array_push($eventids,$value['event_id']);
                }
            }

            $model= Booking::model()->findAllByAttributes(['event_id'=>$eventids]);
        }


        foreach ($model as $value) {
            $items[]=array(
                'id' => $value->booking_id,
                'title' =>$value->username,
                'start' =>$value->created_at,
                'end' =>$value->created_at,
                'data' => ['user_id' => $value->event_id],
                //'color'=>'#CC0000',
                //'allDay'=>true,
                //'url'=>'http://anyurl.com'
            );
        }


        $sql = "SELECT DISTINCT u.full_name,e.event_host from events e LEFT JOIN user_info u on e.event_host = u.user_id where 1=1";
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $sql1 = "SELECT u.full_name,e.event_id from events e LEFT JOIN user_info u on e.event_host = u.user_id where e.event_id =".$id;
        $result1 = Yii::app()->db->createCommand($sql1)->queryAll();
        if(!empty($result1)){
            $selectedhost = $result1[0]['full_name'];
        }


        $this->render('calendarview', array(
            'events' => $items,
            'hosts'=>$result,
            'selectedhost'=>$selectedhost,
        ));
    }
}
