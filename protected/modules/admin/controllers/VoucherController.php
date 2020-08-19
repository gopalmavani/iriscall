<?php

class VoucherController extends CController
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

        $voucher = VoucherInfo::model()->findAll();
        $voucherData = [];

        $cyclone_field = CylFields::model()->findByAttributes(['field_name' => 'voucher_status']);


        foreach ($voucher as $value){
            $temp = $value;
            $temp['reference_id'] = VoucherReference::model()->findByPk($value['reference_id'])->reference;
            $temp['voucher_status'] = CylFieldValues::model()->findByAttributes([
                'field_id'=>$cyclone_field->field_id,
                'predefined_value'=>$value['voucher_status']
                ])->field_label;
            array_push($voucherData, $temp);
        }
        $this->render('index', [
            'voucher_info' => $voucherData
        ]);
    }

    public function actionCreate(){
        $model = new VoucherInfo();
        if(isset($_POST['VoucherInfo'])){
            $postData = $_POST['VoucherInfo'];
            $model->voucher_name = $postData['voucher_name'];
            $model->voucher_code = $postData['voucher_code'];
            $model->reference_id = $postData['reference_id'];
            $model->start_time = date('Y-m-d', strtotime($postData['start_time']))." 00:00:00";
            $model->end_time = date('Y-m-d', strtotime($postData['end_time']))." 00:00:00";
            $model->voucher_status = $postData['voucher_status'];
            $model->user_id = $postData['user_id'];
            $model->voucher_origin = 'Admin';
            $model->order_info_id = $postData['order_info_id'];

            $voucherRef = VoucherReference::model()->findByPk($model->reference_id);
            $model->type = $voucherRef->type;
            $model->value = $voucherRef->value;

            $user = UserInfo::model()->findByPk($model->user_id);
            $model->user_name = $user->full_name;
            $model->email = $user->email;

            $model->created_at = date('Y-m-d H:i:s');
            $model->save(false);

            VoucherHelper::voucherMail($model->voucher_code);

            $this->redirect(Yii::app()->createUrl('admin/voucher/index'));
        }
        $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id){
        $model = VoucherInfo::model()->findByPk($id);
        if(isset($_POST['VoucherInfo'])){
            $model->attributes = $_POST['VoucherInfo'];
            $model->start_time = date('Y-m-d', strtotime($_POST['VoucherInfo']['start_time']))." 00:00:00";
            $model->end_time = date('Y-m-d', strtotime($_POST['VoucherInfo']['end_time']))." 00:00:00";
            $model->modified_at = date('Y-m-d H:i:s');
            $model->save(false);
            $this->redirect(Yii::app()->createUrl('admin/voucher/index'));
        }
        $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionView($id){
        $model = VoucherInfo::model()->findByPk($id);
        $voucherRef = VoucherReference::model()->findByPk($model->reference_id);
        $this->render('view', [
            'voucher_model' => $model,
            'voucher_reference' => $voucherRef
        ]);
    }

    public function actionDelete(){
        if(isset($_POST['id'])){
            $voucher = VoucherInfo::model()->findByPk($_POST['id']);
            if($voucher->delete()){
                echo json_encode([
                    'token' => 1,
                ]);
            } else {
                echo json_encode([
                    'token' => 0,
                ]);
            }
        } else {
            echo json_encode([
                'token' => 0,
            ]);
        }
    }
}