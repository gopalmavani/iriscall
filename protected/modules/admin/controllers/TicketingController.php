<?php

class TicketingController extends CController
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
        $model=new Ticketing;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Ticketing']))
        {
            $images = CUploadedFile::getInstancesByName('images');

            if (isset($images) && count($images) > 0) {
                foreach ($images as $image => $pic) {
                    echo $pic->name.'<br />';
                    $imageName = $this->getImageName($pic->name);
                    if ($pic->saveAs(Yii::app()->basePath . '/..'.$imageName)) {
                        $image_Name[] = $imageName; //it might be $img_add->name for you, filename is just what I chose to call it in my model
                    }
                    else{
                        echo "error";  die;
                    }
                }
                $model->attachment = json_encode($image_Name);
            }

            $model->attributes=$_POST['Ticketing'];
            $model->user_id = Yii::app()->user->id;
            $model->created_at = date('Y-m-d H:i:s');
            $model->modified_at = date('Y-m-d H:i:s');

            if($model->validate()){
                if($model->save()){
                    $this->redirect(array('view','id'=>$model->ticket_id));
                }
            }
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

        if(isset($_POST['Ticketing']))
        {
            /*echo "<pre>";
            print_r($_POST);

            print_r($_FILES);die;*/
            $images = CUploadedFile::getInstancesByName('images');

            if (isset($images) && count($images) > 0) {
                foreach ($images as $image => $pic) {
                    echo $pic->name.'<br />';
                    $imageName = $this->getImageName($pic->name);
                    if ($pic->saveAs(Yii::app()->basePath . '/..'.$imageName)) {
                        $image_Name[] = $imageName; //it might be $img_add->name for you, filename is just what I chose to call it in my model
                    }
                    else{
                        echo "error";  die;
                    }
                }
                $model->attachment = json_encode($image_Name);
            }

            $model->attributes = $_POST['Ticketing'];
            if($model->validate()){
                if($model->save()){
                    $this->redirect(array('view','id'=>$model->ticket_id));
                }
            }
            else{
                print_r($model->getErrors());
            }
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
    public function actionRemove($id)
    {
        $sql = "DELETE FROM comment_mapping where ticket_id = "."'$id'";
        Yii::app()->db->createCommand($sql)->execute();

        $this->loadModel($id)->delete();
        $_SESSION['delete'] = "Ticket Deleted Successfully!";
        /*Yii::app()->user->setFlash('delete', "Ticket Deleted Successfully!");*/

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax'])){
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
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
        $TableID = CylTables::model()->findByAttributes(['table_name' => Ticketing::model()->tableSchema->name]);
        $model = new Ticketing('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Ticketing']))
            $model->attributes = $_GET['Ticketing'];
        $alldata = Ticketing::model()->findAll();

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
        $requestData = $_REQUEST;
        $model = new Ticketing;
        $primary_key = $model->tableSchema->primaryKey;
        $array_cols = Yii::app()->db->schema->getTable(Ticketing::model()->tableSchema->name)->columns;
        $array = array();
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }

        $columns = $array;

        $sql = "SELECT  * from ".Ticketing::model()->tableSchema->name." where 1=1";
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
                if($column == 'user_id'){
                    $name = $requestData['columns'][$key]['search']['value'];
                    $sql = "SELECT  t.*,count(*) as columncount FROM ticketing t
                            LEFT JOIN user_info u ON u.user_id = t.user_id where u.full_name LIKE '%$name%'";
                }
                else{
                    $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }
            }
            $j++;
        }

//    echo $sql;die;

        if(strpos($sql,'JOIN')){
            $sql.= " GROUP by t.ticket_id";
            $count_sql = $sql;
        }
        else{
            $count_sql = str_replace("*","count(*) as columncount",$sql);
        }
//        echo $count_sql;die;
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = '';
        $totalFiltered = '';
        if(!empty($data)){
            $totalData = $data[0]['columncount'];
            $totalFiltered = $totalData;
        }

        $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";

//    echo $sql;die;
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i=1;


        foreach ($result as $key => $row)
        {
            $nestedData = array();
            $nestedData[] = $row[$primary_key];
            $sql = "SELECT full_name from user_info where user_id = "."'$row[user_id]'";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            if(isset($result)){
                $row['user_id'] = $result[0]['full_name'];
            }
            $url = $row['jira_url'];
            if(!empty($url)){
                $row['jira_url'] = "<a target='_blank' href=".$url.">$url</a>";
            }
            foreach($array_cols as  $key=>$col){
                $nestedData[] = $row["$col->name"];
            }

            $data[] = $nestedData;
            $i++;
        }

        if(empty($data)){
            $data = array();
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
     * @return Ticketing the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Ticketing::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Ticketing $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='ticketing-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Make image name using this function
     * @param $imageData
     * @return string
     */
    protected  function getImageName($imageData){
        $imagePath = '/uploads/tickets/';
        $date = date('Ymd');
        $time = time();
        $random = rand(99,99999);
        return $imagePath . $date . $time . $random . '.' . pathinfo($imageData, PATHINFO_EXTENSION);
    }

    /**
     * @param $id
     * This is action opens forum page for specific ticket.
     * saves main comments in database.
     */
    /*public function actionForum($id){
        $model = $this->loadModel($id);

        if(isset($_POST['comment'])){
            $user_id = Yii::app()->user->id;
            $ticket_id = $model->ticket_id;
            $created_at = date('Y-m-d H:i:s');
            $modified_at = date('Y-m-d H:i:s');
            $comment = $_POST['comment'];
            $sql = "INSERT into comment_mapping (`user_id`,`ticket_id`,`parent_id`,`comment`,`created_at`,`modified_at`) values ('$user_id','$ticket_id','0','$comment','$created_at','$modified_at')";
            Yii::app()->db->createCommand($sql)->execute();
        }

        $this->render('forum',array(
            'model'=>$model,
        ));
    }*/

    public function actionForum($id){
        /*echo "<pre>";
        print_r($_POST['comment_description']);die;*/
        $model = $this->loadModel($id);
        if(isset($_POST['comment_description'])){
            $images = CUploadedFile::getInstancesByName('images');

            if (isset($images) && count($images) > 0) {
                foreach ($images as $image => $pic) {
                    $imageName = $this->getImageName($pic->name);
                    if ($pic->saveAs(Yii::app()->basePath . '/..'.$imageName)) {
                        $image_Name[] = $imageName; //it might be $img_add->name for you, filename is just what I chose to call it in my model
                    }
                    else{
                        echo "error";  die;
                    }
                }
                $attachment = json_encode($image_Name);
            }

            $user_id = Yii::app()->user->id;
            $ticket_id = $model->ticket_id;
            $created_at = date('Y-m-d H:i:s');
            $modified_at = date('Y-m-d H:i:s');
            $comment = $_POST['comment_description'];
            $sql = "INSERT into comment_mapping (`user_id`,`ticket_id`,`parent_id`,`comment`,`attachment`,`created_at`,`modified_at`) values ('$user_id','$ticket_id','0','$comment','$attachment','$created_at','$modified_at')";
            Yii::app()->db->createCommand($sql)->execute();
        }

        $this->render('forum',array(
            'model'=>$model,
        ));
    }

    /**
     * @param $id
     * saves reply given in sub-comments.
     */
    public function actionReplysave($id){
        $user_id = Yii::app()->user->id;
        if(isset($_POST['comment'])){
            $ticket_id = $_POST['ticket'];
            $parent_id =  $id;
            $created_at = date('Y-m-d H:i:s');
            $modified_at = date('Y-m-d H:i:s');
            $comment = $_POST['comment'];

            $sql = "INSERT into comment_mapping (`user_id`,`ticket_id`,`parent_id`,`comment`,`created_at`,`modified_at`) values ('$user_id','$ticket_id','$parent_id','$comment','$created_at','$modified_at')";
            Yii::app()->db->createCommand($sql)->execute();

            $this->redirect(Yii::app()->createUrl('/admin/ticketing/forum/')."/".$ticket_id);
        }

    }

    /**
     * opens modal for creating issue in jira
     */
    public function actionCreateIssue($id){
        $model  = $this->loadModel($id);

        $this->renderPartial('createissue',array(
            'model'=>$model,
        ));
    }

    public function actionCreateJiraIssue(){
        if(isset($_POST)){
            $ticket_id = $_POST['ticketid'];
            $request = [
                "fields" =>  [
                    "project" => [ "key" => "MP" ],
                    "summary" => "$_POST[summary]",
                    "description" => "$_POST[description]",
                    "issuetype" =>  [ "name" => "Task"],
                ]
            ];

            $sql = "SELECT * from settings where module_name = 'jira'";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($result as $key=>$value)
            {
                if($value['settings_key'] == 'url'){
                    $url = $value['value'];
                }
                if($value['settings_key'] == 'username'){
                    $username = $value['value'];
                }
                if($value['settings_key'] == 'password'){
                    $password = $value['value'];
                }
            }

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "$url"."/rest/api/latest/issue/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($request),
                CURLOPT_USERPWD => "$username".":"."$password",
                CURLOPT_HTTPHEADER => array(
                    "Cache-Control: no-cache",
                    "Content-Type: application/json",
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                $_SESSION['delete'] = $err. " <br /><b>Please enter correct url in jira create issue url..</b>";
                /*echo "cURL Error #:" . $err;*/
            } else {
                $arr = json_decode($response);
                if(!empty($arr)){
                    $url = "https://kushalpatel.atlassian.net/browse/".$arr->key;
                    $sql = "UPDATE ticketing set jira_url = '$url' where ticket_id = $ticket_id";
                    Yii::app()->db->createCommand($sql)->execute();
                    $_SESSION['delete'] = "Your jira issue is created..";
                }
                else{
                    $_SESSION['delete'] = "Something went wrong!! <br /><b>Try correct username/password in jira credentials..</b>";
                }
            }
            $this->redirect(Yii::app()->createUrl('/admin/ticketing/admin'));
        }
    }


    public function actionSaveCredentials(){
        if(isset($_POST)){

            $url = $_POST['createissueurl'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user_id = Yii::app()->user->id;
            if($_POST['update'] == 'update'){
                $sql1 = "UPDATE settings set value = "."'$url'"." where module_name = 'jira' and settings_key = 'url'";
                $sql2 = "UPDATE settings set value = "."'$username'"." where module_name = 'jira' and settings_key = 'username'";
                $sql3 = "UPDATE settings set value = "."'$password'"." where module_name = 'jira' and settings_key = 'password'";
            }
            else{
                $sql1 = "INSERT INTO settings (`user_id`,`module_name`,`settings_key`,`value`) values ('$user_id','jira','url','$url') ";
                $sql2 = "INSERT INTO settings (`user_id`,`module_name`,`settings_key`,`value`) values ('$user_id','jira','username','$username') ";
                $sql3 = "INSERT INTO settings (`user_id`,`module_name`,`settings_key`,`value`) values ('$user_id','jira','password','$password') ";
            }

            Yii::app()->db->createCommand($sql1)->execute();
            Yii::app()->db->createCommand($sql2)->execute();
            Yii::app()->db->createCommand($sql3)->execute();

            $_SESSION['delete'] = "Credentials saved successfully...";

            $this->redirect(Yii::app()->createUrl('/admin/ticketing/admin'));
        }
    }

    /**
     * Opens settings page for ticketing module.
     */
    public function actionSettings(){
        $this->render('settings');
    }
}
