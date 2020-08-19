<?php

class FbFeedController extends CController
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


    public function actionIndex()
    {
        $model = new FbFeed('search');
        if(isset($_GET['FbFeed']))
            $model->attributes =$_GET['FbFeed'];

        $params =array(
            'model'=>$model,
        );

        $this->render('index',$params);
    }

    public function actionCreate()
    {
        $model = new FbFeed();
        if(isset($_POST['FbFeed']))
        {
            $model->attributes = $_POST['FbFeed'];
            $model->source = 'Admin';
            $model->created_at = date('Y-m-d H:i:s');
            $model->image_url=CUploadedFile::getInstance($model,'image_url');
            if($model->validate())
            {
                $imageName = $this->getImageName($model->image_url);
                if (CUploadedFile::getInstance($model,'image_url') != ''){
                    $model->image_url = $imageName;
                }
                if($model->save())
                {
                    if(CUploadedFile::getInstance($model,'image_url') != '') {
                        $model->image_url = CUploadedFile::getInstance($model, 'image_url');
                        $model->image_url->saveAs(Yii::app()->basePath . '/..' . $imageName);
                    }
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
            else print_r($model->getErrors()); die;
        }

        $this->render('create',[
            'model'=>$model
        ]);
    }

    public function actionView($id)
    {
        $model=FbFeed::model()->findByPk($id);
        $this->render('view',array(
            'model'=>$model,
        ));
    }

    public function actionUpdate($id)
    {
        $model=FbFeed::model()->findByPk($id);

        if(isset($_POST['FbFeed']))
        {
            $model->attributes=$_POST['FbFeed'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    public function actionDelete()
    {
        /*$model=FbFeed::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));*/
        $model = FbFeed::model()->findByAttributes(['id' => $_POST['id']]);

        if(!empty($model)){
            if (FbFeed::model()->deleteAll("id ='" .$model->id. "'")){
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

    public function actionGetFBData()
    {
        /*$model = SyncFb::model()->findByPk(1);*/
        $serviceCall = $this->module->servicehelper->syncDataWithFB();
        $serviceCall = json_decode($serviceCall,true);
        $accessToken = $serviceCall['access_token'];

        $maxDate = Yii::app()->db->createCommand()
            ->select("max(created_at) as created_at")
            ->from("fb_feed")
            ->queryRow();
        //Converts local time to UTC format
        $maxDate = strtotime($maxDate['created_at']);

        $responseData = $this->module->servicehelper->getDataFromFB($accessToken,$maxDate);
        $responseData = json_decode($responseData,true);
        $postData = $responseData['data'];

        foreach($postData as $posts)
        {
            $model = new FbFeed();
            $model->title = (isset($posts['from']['name'])?$posts['from']['name']:"");
            $model->description = (isset($posts['message'])?$posts['message']:"");
            $model->created_at = (isset($posts['created_time'])?$this->getDate($posts['created_time']):"");
            $model->image_url = (isset($posts['picture'])?$posts['picture']:"");
            $model->source = "Facebook";
            $model->is_enabled = 0;
            $model->save(false);
        }
    }

    public function actionSaveCredentials()
    {
        /*echo "<pre>";
        print_r($_POST['pageId']);die;*/
        $model = new Settings();
        if(isset($_POST['clientId']))
        {
            $model = Settings::model()->findByAttributes(['module_name' => "Facebook Feed", 'settings_key' => "clientId"]);
            /*echo "<pre>";print_r($model);die;*/
            if ($model == null){
                $model = new Settings();
                $model1 = new Settings();
                $model2 = new Settings();
                $model->module_name = "Facebook Feed";
                $model1->module_name = "Facebook Feed";
                $model2->module_name = "Facebook Feed";
                $model->settings_key = "clientId";
                $model1->settings_key = "clientSecretId";
                $model2->settings_key = "pageId";
                $model->value = $_POST['clientId'];
                $model1->value = $_POST['clientSecretId'];
                $model2->value = $_POST['pageId'];
            }
            else{
                $model1 = Settings::model()->findByAttributes(['module_name' => "Facebook Feed", 'settings_key' => "clientSecretId"]);
                $model2 = Settings::model()->findByAttributes(['module_name' => "Facebook Feed", 'settings_key' => "pageId"]);
                $model->value = $_POST['clientId'];
                $model1->value = $_POST['clientSecretId'];
                $model2->value = $_POST['pageId'];
                $model->modified_date = date('Y-m-d H:i:s');
                $model1->modified_date = date('Y-m-d H:i:s');
                $model2->modified_date = date('Y-m-d H:i:s');
            }
            $model->user_id = Yii::app()->user->id;
            $model1->user_id = Yii::app()->user->id;
            $model2->user_id = Yii::app()->user->id;
            if($model->validate() && $model1->validate() && $model2->validate())
            {
                if($model->save() && $model1->save() && $model2->save())
                {
                    $this->redirect(array('index'));
                }
            }
            else {
                echo "<pre>";
                print_r($model->getErrors());
                die;
            }
        }
        $this->render('saveCredentials' ,[
            'model'=>$model
        ]);
    }

    //Converts UTC date to local time format
    public function getDate($nmDate)
    {
        $nmDate = strtotime($nmDate);
        $Date = date("Y-m-d H:i:s", $nmDate);
        return $Date;
    }

    protected  function getImageName($imageData){
        $imagePath = '/uploads/fbFeed/';
        $date = date('Ymd');
        $time = time();
        return $imagePath . $date . $time . '.' . pathinfo($imageData, PATHINFO_EXTENSION);
    }
    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata(){
        /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
        echo json_encode($alldata);*/

        $requestData = $_REQUEST;

//		$model= new SysUsers();
        $array_cols = Yii::app()->db->schema->getTable('fb_feed')->columns;
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

        $sql = "SELECT  * from fb_feed where 1=1";
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
//			$sql.=" OR employee_age LIKE '" . $requestData['search']['value'] . "%')";

        }

        $j = 0;
        // getting records as per search parameters
        foreach($columns as $key=>$column){
            if( !empty($requestData['columns'][$key]['search']['value']) ){   //name
                $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
            }
            $j++;
        }

//		echo $sql;die;
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
            $nestedData[] = $row['id'];
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