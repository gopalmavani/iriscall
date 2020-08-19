<?php

class VoucherReferenceController extends CController
{
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return UserIdentity::accessRules();
    }

    public function actionIndex(){

        $voucherRef = VoucherReference::model()->findAll();
        $voucherData = [];

        foreach ($voucherRef as $value){
            $temp = $value;
            array_push($voucherData, $temp);
        }
        $this->render('index', [
            'voucher_info' => $voucherData
        ]);
    }

    public function actionCreate(){
        $model = new VoucherReference();
        if(isset($_POST['VoucherReference'])){
            $postData = $_POST['VoucherReference'];
            $model->reference = $postData['reference'];
            $model->reference_value = $postData['reference_value'];
            $model->type = $postData['type'];
            $model->value = $postData['value'];

            $model->created_at = date('Y-m-d H:i:s');
            $model->save(false);
            $this->redirect(Yii::app()->createUrl('admin/voucherReference/index'));
        }
        $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id){
        $model = VoucherReference::model()->findByPk($id);
        if(isset($_POST['VoucherReference'])){
            $model->attributes = $_POST['VoucherReference'];
            $model->modified_at = date('Y-m-d H:i:s');
            $model->save(false);
            $this->redirect(Yii::app()->createUrl('admin/voucherReference/index'));
        }
        $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionView($id){
        $model = VoucherReference::model()->findByPk($id);
        $this->render('view', [
            'voucher_reference' => $model
        ]);
    }
}