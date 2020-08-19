<?php

class WalletMetaEntityController extends CController
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
		$model=new WalletMetaEntity;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WalletMetaEntity']))
		{
			$model->attributes=$_POST['WalletMetaEntity'];
			$model->modified_at =  date('Y-m-d H:i:s');
			$model->created_at =  date('Y-m-d H:i:s');

			if($model->validate()) {
				if ($model->save())
					$this->redirect(array('view', 'id' => $model->reference_id));
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

		if(isset($_POST['WalletMetaEntity']))
		{
			$model->attributes=$_POST['WalletMetaEntity'];
			$model->modified_at =  date('Y-m-d H:i:s');

			if($model->validate()) {
				if ($model->save())
					$this->redirect(array('view', 'id' => $model->reference_id));
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
public function actionDelete(/*$id*/)
{
    /*$this->loadModel($id)->delete();

    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    if(!isset($_GET['ajax']))
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/

        $model = WalletMetaEntity::model()->findByAttributes(['reference_id' => $_POST['id']]);
        if(!empty($model)){
            if (WalletMetaEntity::model()->deleteAll("reference_id ='" .$model->reference_id. "'")){
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
	* Lists all models.
	*/
	public function actionIndex()
	{
		$this->redirect(['admin']);
		$dataProvider=new CActiveDataProvider('WalletMetaEntity');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new WalletMetaEntity('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['WalletMetaEntity']))
			$model->attributes=$_GET['WalletMetaEntity'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer $id the ID of the model to be loaded
	* @return WalletMetaEntity the loaded model
	* @throws CHttpException
	*/
	public function loadModel($id)
	{
		$model=WalletMetaEntity::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	* Performs the AJAX validation.
	* @param WalletMetaEntity $model the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='wallet-meta-entity-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
