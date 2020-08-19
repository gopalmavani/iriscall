<?php

class SysUsersController extends CController
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
		$model=new SysUsers;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SysUsers']))
		{
			$model->attributes=$_POST['SysUsers'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->lastvisit_at = date('Y-m-d H:i:s');
            $model->password = md5($_POST['SysUsers']['password']);
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['SysUsers']))
		{
			$model->attributes=$_POST['SysUsers'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionDelete($id)
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
		$dataProvider=new CActiveDataProvider('SysUsers');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SysUsers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SysUsers']))
			$model->attributes=$_GET['SysUsers'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SysUsers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SysUsers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SysUsers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sys-users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * this action change user password
     * @param $id
     * @return json array
     */
    public function actionChangePassword($id){
        $model = SysUsers::model()->findByPk(['id' => $id]);

        if(isset($_POST['SysUsers'])){
            try {
                $model->password = md5($_POST['SysUsers']['newPassword']);
                $model->lastvisit_at = date('Y-m-d H:i:s');
                if ($model->validate()) {
                    if($model->save())
                        $result = [
                            'result' => true
                        ];
                }
            }catch (Exception $e){
                $result = [
                    'result' => false,
                    'error' => $e
                ];
            }
            echo CJSON::encode($result);
        }else {
            $this->render('changePassword', array(
                'model' => $model,
            ));
        }
    }

	/**
	 * Manages data for server side datatables.
	 */
	public function actionServerdata(){
		/*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
		echo json_encode($alldata);*/

		$requestData = $_REQUEST;

		$model= new SysUsers();
		$array_cols = Yii::app()->db->schema->getTable('sys_users')->columns;
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

		$sql = "SELECT  * from sys_users where 1=1";
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
