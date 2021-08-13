<?php

class CommissionPlanController extends CController
{
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
        return UserIdentity::accessRules();
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
        $model = new CommissionPlan;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $path = Yii::getPathOfAlias('webroot').'/uploads/icons';
        if (isset($_POST['CommissionPlan'])) {
            $model->attributes = $_POST['CommissionPlan'];
            $image = CUploadedFile::getInstance($model, 'icon');
            if(!empty($image)){
                $image->saveAs($path.'/'.$image->name);
                $model->icon =  '/uploads/icons/'.$image->name;
            }
            $model->created_at = date('Y-m-d H:i:s');

            if($model->save())
                    $this->redirect(array('view', 'id' => $model->id));
        }
        $this->render('create', array(
            'model' => $model
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $path = Yii::getPathOfAlias('webroot').'/uploads/icons';
        if (isset($_POST['CommissionPlan'])) {
            $model->attributes = $_POST['CommissionPlan'];
            if(!empty($_POST['CommissionPlan']['icon'])){
                $image = CUploadedFile::getInstance($model, 'icon');
                if(!empty($image)){
                    $image->saveAs($path.'/'.$image->name);
                    $model->icon =  '/uploads/icons/'.$image->name;
                }
            }
            $model->modified_at = date('Y-m-d H:i:s');
            if($model->save())
                    $this->redirect(array('view', 'id' => $model->id));
        }
        $this->render('update', array(
            'model' => $model
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        $model = CommissionPlan::model()->findByAttributes(['id' => $_POST['id']]);

        if(!empty($model)){
            if (CommissionPlan::model()->deleteAll("id ='" .$model->id. "'")){
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
    public function actionAdmin()
    {
        $model = new CommissionPlan('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['CommissionPlan']))
            $model->attributes=$_GET['CommissionPlan'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CommissionPlan the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = CommissionPlan::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata(){

        $requestData = $_REQUEST;

        $array_cols = Yii::app()->db->schema->getTable('commission_plans')->columns;
        $array = array();
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }
        $columns = $array;

        $sql = "SELECT  * from commission_plans where 1=1";
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
            if($requestData['columns'][$key]['search']['value'] != '' ){   //name
                $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
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

        foreach ($result as $key => $row)
        {
            $nestedData = array();
            //$nestedData[] = $row['id'];
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
     * Performs the AJAX validation.
     * @param CommissionPlan $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='commissionPlan-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}