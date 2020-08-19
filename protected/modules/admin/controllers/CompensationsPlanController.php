<?php

class CompensationsPlanController extends CController
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
		return UserIdentity::accessRules();
	}

	public function actionView()
	{
		$this->render('view');
	}

	public function actionStatusChange()
    {
        $model = CompensationsPlan::model()->findByAttributes(['id' => $_POST['id']]);
        if($model){
            if ($_POST['status'] == 'active'){
                $model->status = 'active';
            }else{
                $model->status = 'inactive';
            }
            if ($model->save()){
                echo json_encode([
                    'token' => 1,
                    'id' => $model->id,
                ]);
            }else{
                echo json_encode([
                    'token' => 0,
                    'id' => $model->id,
                ]);
            }
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {

        $model=new CompensationsPlan;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['CompensationsPlan']))
        {
            $model->attributes=$_POST['CompensationsPlan'];
            $model->created_at = date('Y-m-d H:i:s');
            if($model->save())
                $this->redirect(array('view'));
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

        if(isset($_POST['CompensationsPlan']))
        {
            $model->attributes=$_POST['CompensationsPlan'];
            $model->modified_at = date('Y-m-d H:i:s');
            if($model->save())
                $this->redirect(array('view'));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Compensations the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=CompensationsPlan::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeletePlan($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
    }
}
