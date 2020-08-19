<?php

class OrderCreditMemoController extends CController
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
    $model = $this->loadModel($id);
    $creditItems = OrderCreditItems::model()->findAllByAttributes(['credit_memo_id'=>$model->credit_memo_id]);
    $this->render('view',array(
        'model'=> $model,
        'creditItems' => $creditItems
    ));
}

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
{
    $model=new OrderCreditMemo;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if(isset($_POST['OrderCreditMemo']))
    {
        $model->attributes=$_POST['OrderCreditMemo'];
        $model->created_at = date('Y-m-d H:i:s');
        $model->modified_at = date('Y-m-d H:i:s');
        if($model->validate()) {
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->credit_memo_id));
            }
        }
    }

    $this->render('create',array(
        'model'=>$model,
    ));
}

    /*
	 * Credit Note Download Functionality.
	 * */
    public function actionCreditDownload($id){
        $note = OrderCreditMemo::model()->findByPk($id);
        $creditItems = OrderCreditItems::model()->findAllByAttributes(['credit_memo_id'=>$id]);
        $id = $note->order_info_id;
        $this->layout = 'invoice';

        $data['orderInfo'] = OrderInfo::model()->findByAttributes(array('order_info_id' => $id));
        $data['orderLineitem'] = OrderLineItem::model()->findAllByAttributes(array('order_info_id' => $id));
        $data['orderPayment'] = OrderPayment::model()->findByAttributes(array('order_info_id' => $id));
        $data['userInfo'] = UserInfo::model()->findByAttributes(array('user_id' => $data['orderInfo']->user_id));
        $data['memo'] = $note;
        $data['creditItems'] = $creditItems;

        $html = $this->render('creditMemo', array('data' => $data), true);

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('utf-8', 'A4', 9, 'dejavusans');

        $mPDF1->SetHTMLFooter('

        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;"><tr>
        
        <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
        
        <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
        
        <td width="33%" style="text-align: right; ">The People\'s Web</td>
        
        </tr></table>
        
        ');
        $mPDF1->WriteHTML($html);

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/style.css');

        $mPDF1->WriteHTML($stylesheet, 1);

        # Outputs ready PDF
        $mPDF1->Output('memo_' . $note->order_info_id.'.pdf', 'D');
        $mPDF1 = null;
        //}
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

    if(isset($_POST['OrderCreditMemo']))
    {
        $model->attributes=$_POST['OrderCreditMemo'];
        $model->modified_at = date('Y-m-d H:i:s');
        if($model->save())
            $this->redirect(array('view','id'=>$model->credit_memo_id));
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
    //Delete credit items
    Yii::app()->db->createCommand()
        ->delete('order_credit_items','credit_memo_id=:id',[':id'=>$id]);
    if ($this->loadModel($id)->delete()){
        echo json_encode([
            'token'=>1
        ]);
    }else{
        echo json_encode([
            'token'=>0
        ]);
    }
    /*// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    if(!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/
}

    /**
     * Lists all models.
     */
    public function actionIndex()
{
    $this->redirect(['admin']);
}

    /**
     * Manages all models.
     */
    public function actionAdmin()
{
    $orderCredits = OrderCreditMemo::model()->findAll();
    $this->render('admin',[
        'orderCredits'=>$orderCredits
    ]);
}

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return OrderCreditMemo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
{
    $model=OrderCreditMemo::model()->findByPk($id);
    if($model===null)
        throw new CHttpException(404,'The requested page does not exist.');
    return $model;
}

    /**
     * Performs the AJAX validation.
     * @param OrderCreditMemo $model the model to be validated
     */
    protected function performAjaxValidation($model)
{
    if(isset($_POST['ajax']) && $_POST['ajax']==='order-credit-memo-form')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }
}


    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata(){

    $requestData = $_REQUEST;


    $array_cols = Yii::app()->db->schema->getTable('order_credit_memo')->columns;
    $array = array();
    $i = 0;
    foreach($array_cols as  $key=>$col){
        $array[$i] = $col->name;
        $i++;
    }

    $columns = $array;

    $sql = "SELECT  * from order_credit_memo where 1=1";


    if (!empty($requestData['search']['value']))
    {
        $sql.=" AND ( credit_memo_id LIKE '%" . $requestData['search']['value'] . "%' ";
        foreach($array_cols as  $key=>$col){
            if($col->name != 'order_info_id')
            {
                $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
            }
        }
        $sql.=")";
    }

    $j = 0;
    // getting records as per search parameters
    foreach($columns as $key=>$column){
        if($requestData['columns'][$key]['search']['value'] != ''){   //name
            if($column == 'user_id'){
                $sql.=" AND  user_id = " . $requestData['columns'][$key]['search']['value'] . " ";
            }
            else{
                $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
            }
//                echo $column;die;
            $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
        }
        $j++;
    }

    $count_sql = str_replace("*","count(*) as columncount",$sql);
    $data = Yii::app()->db->createCommand($count_sql)->queryAll();
    $totalData = $data[0]['columncount'];
    $totalFiltered = $totalData;


    $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
        $requestData['length'] . "   ";

    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $data = array();
    $i=1;

    foreach ($result as $key => $row)
    {
        $nestedData = array();
        $nestedData[] = $row['credit_memo_id'];

        if($row['memo_status'] == 1){
            $row['memo_status'] = 'Success';
        }
        else{
            $row['memo_status'] = 'Failed';
        }


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

}
