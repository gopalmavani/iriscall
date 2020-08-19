<?php

class RankController extends CController
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
        $model = new Rank;
        $rules = new Rules;
        $rulesModel = Rules::model()->findAll();
        $rankRules = new Rankrules;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Rank'])) {
            $model->attributes = $_POST['Rank'];
            $model->created_at = date('Y-m-d H:i:s');
            if (isset($_POST['desc']))
                $des = $_POST['desc'];
            if (isset($_POST['value2']))
                $allValue1 = $_POST['value1'];
            if (isset($_POST['value1']))
                $allValue2 = $_POST['value2'];
            $desCount = $_POST['count'];

            if ($model->validate()) {
                if ($model->save()) {
                    if ($model->save()) {
                        $rankId = $model->rankId;
                        for ($i = 1; $i <= $desCount; $i++) {
                            if (isset($des[$i])) {
                                $rankRules = new Rankrules;
                                $rankRules->rankId = $rankId;
                                $rankRules->isActive = 1;
                                $rankRules->ruleId = $i;
                                $rankRules->created_at = date('Y-m-d H:i:s');
                                if (isset($_POST['value1'][$i]))
                                    $rankRules->value1 = $allValue1[$i];
                                if (isset($_POST['value2'][$i]))
                                    $rankRules->value2 = $allValue2[$i];
                                /*echo "<pre>";
                                print_r($rankRules->attributes);
                                print_r($model->attributes);*/
                                if ($rankRules->validate()) {
                                    $rankRules->save();
                                } else {
                                    print_r($rankRules->getErrors());
                                }
                            }
                        }
                        $this->redirect(array('view', 'id' => $model->rankId));
                    }
                } else {
                    print_r($model->getErrors());
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
            'rules' => $rules,
            'rulesModel' => $rulesModel,
            'rankRules' => $rankRules,

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
        $rankRules = Rankrules::model()->findAllByAttributes(array('rankId' => $id));
        $rankRules1 = Yii::app()->db->createCommand("SELECT * from rankrules where value2!='' ")->queryAll();
        $rulesModel = Rules::model()->findAll();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Rank']))
        {

            if (isset($_POST['Rank'])) {

                $model->attributes = $_POST['Rank'];
                $model->created_at = date('Y-m-d H:i:s');
                if (isset($_POST['desc']))
                    $des = $_POST['desc'];
                if (isset($_POST['value2']))
                    $allValue1 = $_POST['value1'];
                if (isset($_POST['value1']))
                    $allValue2 = $_POST['value2'];
                $desCount = $_POST['count'];
                if ($model->validate()) {
                    if ($model->save()) {
                        $rankRules = Rankrules::model()->findAllByAttributes(array('rankId' => $id));
                        foreach ($rankRules as $data1) {
                            $data1->delete();
                        }
                        $rankId = $model->rankId;
                        for ($i = 1; $i <= $desCount; $i++) {
                            if ($_POST['value1'][$i] || $_POST['value2'][$i]){

                                if (isset($des[$i])) {
                                    $rankRules = new Rankrules;
                                    $rankRules->rankId = $rankId;
                                    $rankRules->isActive = 1;
                                    $rankRules->ruleId = $i;
                                    $rankRules->created_at = date('Y-m-d H:i:s');
                                    if (isset($_POST['value1'][$i]))
                                        $rankRules->value1 = $allValue1[$i];
                                    if (isset($_POST['value2'][$i]))
                                        $rankRules->value2 = $allValue2[$i];
                                    /*echo "<pre>";
                                    print_r($rankRules->attributes);
                                    print_r($model->attributes);*/
                                    if ($rankRules->validate()) {
                                        $rankRules->save();
                                    } else {
                                        print_r($rankRules->getErrors());
                                    }
                                }
                            }
                        }
                        $this->redirect(array('view', 'id' => $model->rankId));
                    } else {
                        print_r($model->getErrors());
                    }
                }
            }
        }

        $this->render('update',array(
            'model'=>$model,
            'rulesModel'=>$rulesModel,
            'rankRules'=>$rankRules,
            'rankRules1'=>$rankRules1
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteRank($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('Rank');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Rank('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Rank']))
            $model->attributes=$_GET['Rank'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Rank the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Rank::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Rank $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='rank-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionComputeRank()
    {
        /*$log = new Logging();

        $log->lfile('/tmp/mylog.txt');

        $log->lclose();*/

        $newRank = $oldRank = $rankUser = $ranks = array();
        //$users = UserInfo::model()->findAllByAttributes(['user_id' => 11293]);
        $users = UserInfo::model()->findAll();

        foreach ($users as $user) {
            /*$log->lwrite('User Loop start'. date('H:i:s'));*/
            for ($i=11; $i > 0 ; $i--) {
                if($this->getCheckRanks($i ,$user->user_id)){
                    $setrank = UserInfo::model()->findByAttributes(['user_id' => $user->user_id]);
                    $setrank->rankId = $i;
                    if ($setrank->validate()){
                        if ($setrank->save(true)){
                            //echo "User ".$user->user_id."'s Rank Changed From ".$user->rankId." To ".$i ."<br>";
                            $rankUser[] = $user->user_id;
                            $newRank[] = $i;
                            $oldRank[] = $user->rankId;
                        }
                    }else{
                        echo $user->user_id." ";
                        print_r($setrank->getErrors());
                        echo "<br>";
                    }
                    break;
                }
            }
        }
        echo json_encode([
            'users' => count($rankUser),
            'newrank' => $newRank,
            'oldrank' => $oldRank,
        ]);
    }

    protected function getCheckRanks($rankId, $userId){
        $totalDeposit = $childCount = 1;
        $amount = '';
        $NoOfChild = UserInfo::model()->findAllByAttributes(['sponsor_id' => $userId]);
        if ($NoOfChild){
            $childCount = count($NoOfChild);
        }

        $ownDeposit = Wallet::model()->findByAttributes(['denomination_id' => 1, 'transaction_type' => 1, 'transaction_status' => 2, 'user_id' => $userId]);
        if ($ownDeposit){
            $totalDeposit = $ownDeposit->amount;
        }

        $rules = Rankrules::model()->findAllByAttributes(['rankId' => $rankId]);


        if ($totalDeposit != 0 && $childCount != 0 ){
            foreach ($rules as $rule){
                if($rule->ruleId == 1){
                    if ($childCount >= $rule->value1){
                        $child = $childCount;
                    }
                }
                if($rule->ruleId == 2){
                    if ($totalDeposit >= $rule->value1){
                        $amount = $totalDeposit;
                    }
                }
            }
        }/*else{
            echo $userId.' have '.$totalDeposit.' and '.$childCount.'child required for level '. $rankId.'<br>';
        }*/

        if (!empty($child) && !empty($amount)){
            return true;
        }else{
            return false;
        }
    }



    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata(){
        /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
        echo json_encode($alldata);*/

        $requestData = $_REQUEST;

//		$model= new SysUsers();
        $array_cols = Yii::app()->db->schema->getTable('rank')->columns;
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

        $sql = "SELECT  * from rank where 1=1";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $totalFiltered = count($data);

        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( rankId LIKE '%" . $requestData['search']['value'] . "%' ";
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
            $nestedData[] = $row['rankId'];
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