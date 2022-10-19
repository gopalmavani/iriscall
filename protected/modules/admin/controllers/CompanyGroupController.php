<?php

class CompanyGroupController extends Controller
{
    public $layout = 'main';

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
            //'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

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

    public function actionIndex()
    {
        $model = new CompanyGroupInfo('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['CompanyGroupInfo']))
            $model->attributes = $_GET['CompanyGroupInfo'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

     /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new CompanyGroupInfo();
        // echo '<pre>';
        // print_r($model);die;
        if(isset($_POST['CompanyGroupInfo']))
        {
            $model->attributes = $_POST['CompanyGroupInfo'];
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

        if(isset($_POST['CompanyGroupInfo']))
        {
            $model->attributes = $_POST['CompanyGroupInfo'];
            $model->updated_at = date('Y-m-d H:i:s');

            if($model->save())
                    $this->redirect(array('view', 'id' => $model->id));
        }
        $this->render('update', array(
            'model' => $model
        ));
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        $model = CompanyGroupInfo::model()->findByAttributes(['id' => $_POST['id']]);

        if(!empty($model)){
            if (CompanyGroupInfo::model()->deleteAll("id ='" .$model->id. "'")){
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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CdrCostRulesInfo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = CompanyGroupInfo::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Manages data for server side datatables.
     */
    public function actionDatatable()
    {
        $requestData = $_REQUEST;

        $array_cols = Yii::app()->db->schema->getTable('company_group_info')->columns;
        $array = array();
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }
        $columns = $array;

        $sql = "SELECT  * from company_group_info where 1=1";
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
            if( !empty($requestData['columns'][$key]['search']['value']) ){   //name
                if($column == 'company_id'){
                    $sql.=" AND $column = ".$requestData['columns'][$key]['search']['value']."";
                }else{
                    $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }
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

            if(!is_null($row['company_id']) && $row['company_id'] != ''){
                if(isset(OrganizationInfo::model()->findByPk($row['company_id'])->name)){
                    $row['company_id'] = OrganizationInfo::model()->findByPk($row['company_id'])->name;
                }
                else{
                    $row['company_id'] = "";
                }
            }
            $nestedData[] = $row['id'];
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
     * @param CommissionPlanSettings $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='company-group-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetGroups(){
        $response = [];
        if(isset($_POST) && !empty($_POST['organisation_id'])){
            $organization = OrganizationInfo::model()->findByPk($_POST['organisation_id']);
            $groups = CompanyGroupInfo::model()->findAllByAttributes(['company_id' => $organization->id]);

            if(!empty($groups)){
                $data = CHtml::listData($groups, 'external_number', 'group_name');
                $html = "<div class='row'><div class='form-group'><label class='control-lable group-list'>Select Group</label>
                        <select class='form-control' id='group' name='group'><option value=''>Select Group</option>";
                foreach ($data as $key => $value) {
                    $html .= CHtml::tag('option', array('value' => $key), CHtml::encode($value), true);
                }
                $html .= "</select></div></div>";
    
                $response['status'] = true;
                $response['data'] = $html;
            }else{
                $response['status'] = false;
                $response['message'] = "Group not found";
            }
        }
        echo json_encode($response);
    }
}

?>