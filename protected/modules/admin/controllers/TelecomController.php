<?php

class TelecomController extends CController{
    public function accessRules()
    {
        return [
            [
                'allow',
                'actions' => ['*'],
                'users' => ['*'],
            ]
        ];
    }

    public function actionIndex(){
        $model = new TelecomUserDetails('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TelecomUserDetails']))
            $model->attributes = $_GET['TelecomUserDetails'];
        $alldata = TelecomUserDetails::model()->findAll();
        $this->render('index', [
            'model' => $model,
            'alldata' => $alldata,
        ]);
    }

    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata(){
        $requestData = $_REQUEST;

        $array_cols = Yii::app()->db->schema->getTable('telecom_user_details')->columns;
        $array = array();
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }
        $columns = $array;

        $sql = "SELECT  * from telecom_user_details where 1=1";
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
            if( !empty($requestData['columns'][$key]['search']['value']) ){
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

        $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;

        $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $data = array();
        $i=1;
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
            foreach($array_cols as  $key=>$col){
                $nestedData[] = $row["$col->name"];
            }
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new TelecomUserDetails();

        if (!empty($_POST)) {
            if(isset($_POST['TelecomUserDetails'])){
                $this->saveTelecomUserDetails($_POST['TelecomUserDetails']);

                $userInfo = UserInfo::model()->findByAttributes(['email'=>$_POST['TelecomUserDetails']['email']]);
                if(isset($_FILES)){
                    $this->uploadfiles($userInfo->user_id, $_FILES);
                }

                $model = new TelecomUserDetails('search');
                $model->unsetAttributes();  // clear any default values
                if (isset($_GET['TelecomUserDetails']))
                    $model->attributes = $_GET['TelecomUserDetails'];
                $alldata = TelecomUserDetails::model()->findAll();
                $this->render('index', [
                    'model' => $model,
                    'alldata' => $alldata,
                ]);
            }
        }
        $this->render('create', array(
            'model' => $model
        ));
    }

    public function saveTelecomUserDetails($telecomDetails){
        $telecomUserDetail = TelecomUserDetails::model()->findByAttributes(['email'=>$telecomDetails['email']]);
        if(isset($telecomUserDetail->id)){
            $telecomUserDetail->modified_at = date('Y-m-d H:i:s');
        } else {
            $userInfo = UserInfo::model()->findByAttributes(['email'=>$telecomDetails['email']]);
            $telecomUserDetail = new TelecomUserDetails();
            $telecomUserDetail->user_id = $userInfo->user_id;
        }
        $telecomUserDetail->setAttributes($telecomDetails, false);
        $telecomUserDetail->save(false);
    }

    public function actionCheckEmail(){
        $email = UserInfo::model()->findAllByAttributes(['email' => $_POST['email']]);
        if (count($email) > 0) {
            $result = 'true';
        } else {
            $result = 'false';
        }
        echo $result;
    }

    public function actionUpdate($id){
        $model = TelecomUserDetails::model()->findByPk($id);
        if (!empty($_POST)) {
            if(isset($_POST['TelecomUserDetails'])){
                $this->saveTelecomUserDetails($_POST['TelecomUserDetails']);

                $model = new TelecomUserDetails('search');
                $model->unsetAttributes();  // clear any default values
                if (isset($_GET['TelecomUserDetails']))
                    $model->attributes = $_GET['TelecomUserDetails'];
                $alldata = TelecomUserDetails::model()->findAll();
                $this->render('index', [
                    'model' => $model,
                    'alldata' => $alldata,
                ]);
            }
        }
        $this->render('update', array(
            'model' => $model
        ));
    }

    public function actionView($id)
    {
        $model = TelecomUserDetails::model()->findByPk($id);
        $this->render('view', array(
            'model' => $model
        ));
    }

    public function uploadfiles($user_id, $files){
        $uploadDir = 'uploads/'.$user_id.'/';
        if(!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        if(isset($files['passport']['name'])){
            $uploadFile = $uploadDir . basename($files['passport']['name']);
            $documentId = 1;
            if(move_uploaded_file($files['passport']['tmp_name'], $uploadFile)){
                $documentPath = $uploadDir . $files['passport']['name'];
                $this->addDocumentPathToDB($user_id, $documentId, $documentPath);
            }
        }
        if(isset($files['sepa']['name'])){
            $uploadFile = $uploadDir . basename($files['sepa']['name']);
            $documentId = 2;
            if(move_uploaded_file($files['sepa']['tmp_name'], $uploadFile)){
                $documentPath = $uploadDir . $files['sepa']['name'];
                $this->addDocumentPathToDB($user_id, $documentId, $documentPath);
            }
        }
        if(isset($files['articles_of_association']['name'])){
            $uploadFile = $uploadDir . basename($files['articles_of_association']['name']);
            $documentId = 3;
            if(move_uploaded_file($files['articles_of_association']['tmp_name'], $uploadFile)){
                $documentPath = $uploadDir . $files['articles_of_association']['name'];
                $this->addDocumentPathToDB($user_id, $documentId, $documentPath);
            }
        }
    }

    protected function addDocumentPathToDB($userId, $documentId, $documentPath){
        $document = new TelecomUserDocuments();
        $document->user_id = $userId;
        $document->document_id = $documentId;
        $document->document_path = $documentPath;
        $document->save(false);
    }

    /*
     * Delete telecom user and account along with all its files
     * */
    public function actionDelete()
    {
        $telecom_user = TelecomUserDetails::model()->findByPk($_POST['id']);

        TelecomAccountDetails::model()->deleteAll("user_id ='" . $telecom_user->user_id . "'");
        $path = '/uploads/'.$telecom_user->user_id;
        UserHelper::deleteFiles($path);
        TelecomUserDocuments::model()->deleteAll("user_id ='" . $telecom_user->user_id . "'");


        if($telecom_user->delete()){
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
}
?>