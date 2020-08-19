<?php

class CategoriesController extends CController
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
    $model=new Categories;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if(isset($_POST['Categories']))
    {
        $model->attributes=$_POST['Categories'];
        $model->created_at = date('Y-m-d H:i:s');
        $model->modified_at = date('Y-m-d H:i:s');
        if($model->validate()){
            if($model->save())
                $this->redirect(array('view','id'=>$model->category_id));
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

    if(isset($_POST['Categories']))
    {
        $model->attributes=$_POST['Categories'];
        $model->modified_at = date('Y-m-d H:i:s');
        if($model->validate()) {
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->category_id));
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
public function actionDelete()
{
    /* $sponsor = ProductCategory::model()->findByAttributes(array('category_id' => $id));
    if($sponsor){
        Yii::app()->user->setFlash('delete-error', 'Can not delete this category');
        $this->redirect(array('categories/admin'));
    }

    $this->loadModel($id)->delete();

    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    if(!isset($_GET['ajax']))
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/

    $model = Categories::model()->findByAttributes(['category_id' => $_POST['id']]);

    $sponsor = ProductCategory::model()->findByAttributes(array('category_id' => $_POST['id']));
    if($sponsor){
        Yii::app()->user->setFlash('delete-error', 'Can not delete this category');
        $this->redirect(array('categories/admin'));
    }

    if($model->delete()){
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

    /**
     * Lists all models.
     */
    public function actionIndex()
{
    $dataProvider=new CActiveDataProvider('Categories');
    $this->render('index',array(
        'dataProvider'=>$dataProvider,
    ));
}

    /**
     * Manages all models.
     */
    public function actionAdmin()
{
    $model=new Categories('search');
    $model->unsetAttributes();  // clear any default values
    if(isset($_GET['Categories']))
        $model->attributes=$_GET['Categories'];

    $this->render('admin',array(
        'model'=>$model,
    ));
}

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Categories the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
{
    $model=Categories::model()->findByPk($id);
    if($model===null)
        throw new CHttpException(404,'The requested page does not exist.');
    return $model;
}

    /**
     * Performs the AJAX validation.
     * @param Categories $model the model to be validated
     */
    protected function performAjaxValidation($model)
{
    if(isset($_POST['ajax']) && $_POST['ajax']==='categories-form')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }
}

    /**
     * check if category exist.
     */
    public function actionCheckCat()
{
    $model = Categories::model()->findAllByAttributes(['category_name' => $_POST['category']]);
    if ($model) {
        echo json_encode([
            'token' => 1,
            'msg' => 'Category already exist'
        ]);
    } else {
        echo json_encode([
            'token' => 0
        ]);
    }
}

    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata(){
    /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
    echo json_encode($alldata);*/

    $requestData = $_REQUEST;

    $model= new Categories();
    $array_cols = Yii::app()->db->schema->getTable('categories')->columns;
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

    $sql = "SELECT  * from categories where 1=1";
    $data = Yii::app()->db->createCommand($sql)->queryAll();
    $totalFiltered = count($data);

    if (!empty($requestData['search']['value']))
    {
        $sql.=" AND ( category_id LIKE '%" . $requestData['search']['value'] . "%' ";
        foreach($array_cols as  $key=>$col){
            if($col->name != 'category_id')
            {
                $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
            }
        }
        $sql.=")";
//			$sql.=" OR employee_age LIKE '" . $requestData['search']['value'] . "%')";
    }

    /*echo "<pre>";
    print_r($requestData['columns']);die;*/

    $j = 0;
    // getting records as per search parameters
    foreach($columns as $key=>$column){
        if($requestData['columns'][$key]['search']['value'] != '' ){   //name
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
        $nestedData[] = $row['category_id'];
        $row['is_active'] = $row['is_active'] == 0? ('No') : ('Yes');
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