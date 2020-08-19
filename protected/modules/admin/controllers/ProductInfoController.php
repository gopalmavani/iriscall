<?php

class ProductInfoController extends CController
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
    $data = $this->loadModel($id);
    $productAff = ProductAffiliate::model()->findAllByAttributes(['product_id' => $id]);
    $productLic = ProductLicenses::model()->findAllByAttributes(['purchase_product_id' => $id]);
    $this->render('view',array(
        'model'=>$data,
        'pro_affiliate'=>$productAff,
        'pro_license'=>$productLic
    ));
}

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
{
    $model=new ProductInfo;
    $categories = new Categories();
    $productCategory = new ProductCategory();
    $productAffiliate = new ProductAffiliate();
    $productLicense = new ProductLicenses();

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if(isset($_POST['ProductInfo'])) {
        $productResult = $this->saveProductInfo($_POST['ProductInfo']);
        return $productResult;
    }

    if(isset($_POST['ProductAffiliate'])){
        // save product affiliate data
        $affiliateResult = $this->saveProductAffiliate($_POST['ProductAffiliate'],$_POST['ProductAffiliate']['pid']);
        return $affiliateResult;
    }

    if(isset($_POST['ProductLicenses'])){
        // save product licenses data
        $licenseResult = $this->saveProductLicense($_POST['ProductLicenses'],$_POST['ProductLicenses']['pid']);
        return $licenseResult;
    }

    $this->render('create',array(
        'model'=>$model,
        'categories' => $categories,
        'productCategory' => $productCategory,
        'productAffiliate' => $productAffiliate,
        'productLicense' => $productLicense,
    ));
}

    /**
     * @param $res
     * @return json
     */
    protected function saveProductInfo($res){
    header("Content-Type: application/json; charset=UTF-8");
    $result = [];
    $model=new ProductInfo;
    $categories = new Categories();
    $productCategory = new ProductCategory();
    //set ProductInfo attribute
    $model->attributes=$res;
    $model->created_at = date('Y-m-d H:i:s');
    $model->modified_at = date('Y-m-d H:i:s');
    $model->image=CUploadedFile::getInstance($model,'image');
    // set ProductCategory attributes
    if (isset($_POST['ProductCategory']) && $_POST['ProductCategory']['category_id'] > 1){
        $productCategory->attributes = $_POST['ProductCategory'];
    }else{
        $productCategory->category_id = 1;
    }
    $productCategory->created_at = date('Y-m-d H:i:s');

    // validate product-category and product-info
    if($model->validate()) {
        // validate product-sku
        $product = ProductInfo::model()->findAllByAttributes(['sku' => $model->sku]);
        if (!count($product) > 0) {
            $imageName = $this->getImageName($model->image);
            if (CUploadedFile::getInstance($model,'image') != ''){
                $model->image = $imageName;
            }
            if ($model->save()) {
                $productCategory->product_id = $model->product_id;
                $productCategory->save();

                if(CUploadedFile::getInstance($model,'image') != '') {
                    $model->image = CUploadedFile::getInstance($model, 'image');
                    $model->image->saveAs(Yii::app()->basePath . '/..' . $imageName);
                }
                $result = [
                    'result' => true,
                    'productId' => $model->product_id,
                ];
                //$this->redirect(array('view', 'id' => $model->product_id));
            }
        }else{
            $result = [
                'token' => 0,
                'result' => false,
            ];
            $model->addError('sku', 'Sku Already Exist in System');
        }
    }
    echo json_encode($result);
}

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
{
    $model=$this->loadModel($id);
    $categories = new Categories();
    $productCategory = ProductCategory::model()->findByAttributes(array("product_id" => $model->product_id ));
    $productAffiliate = ProductAffiliate::model()->findAllByAttributes(array("product_id" => $model->product_id),array('order'=>'aff_level ASC'));
    $productLicense = ProductLicenses::model()->findAllByAttributes(array("purchase_product_id" => $model->product_id));

    if(isset($_POST['ProductInfo'])) {
        $model->attributes=$_POST['ProductInfo'];
        $model->modified_at = date('Y-m-d H:i:s');
        $imageFile = CUploadedFile::getInstance($model,'image');
        $model->image = $imageFile;
        // set ProductCategory attributes
        if (isset($_POST['ProductCategory']) && $_POST['ProductCategory']['category_id'] > 1){
            $productCategory->attributes = $_POST['ProductCategory'];
        }else{
            $productCategory->category_id = 1;
        }
        $currentModel = $this->loadModel($id);
        if(empty($model->image)){
            $imageFile = CUploadedFile::getInstance($currentModel,'image');
            $model->image = $imageFile;
        }
        // validate product-category and product-info
        if($model->validate() && $productCategory->validate()) {
            $imageName = '';
            if($model->image != ''){
                $imageName = $this->getImageName($model->image);
                $model->image = $imageName;
                $fileExists = is_file(Yii::app()->basePath . '/..' . $currentModel->image)?'yes':'no';
                if($fileExists == 'yes'){
                    unlink(Yii::app()->basePath . '/..' . $currentModel->image);
                }
            }else{
                $model->image = $currentModel->image;
            }
            if ($model->save()) {
                $productCategory->product_id = $model->product_id;
                $productCategory->save();
                if($model->image != $currentModel->image) {
                    $model->image = CUploadedFile::getInstance($model, 'image');
                    $model->image->saveAs(Yii::app()->basePath . '/..' . $imageName);
                }
                echo json_encode($result = [
                    'result' => true,
                    'productId' => $model->product_id,
                ]); die;
            }
        }
    }

    if(isset($_POST['ProductAffiliate'])){
        $lastIndex = ProductAffiliate::model()->findAllByAttributes(array("product_id" => $_POST['ProductAffiliate']['pid']));
        $totalAffLevel = count($_POST['ProductAffiliate']['aff_level']);
        if (count($lastIndex > count($totalAffLevel))) {
            foreach ($_POST['ProductAffiliate']['aff_level'] as $key => $new_aff) {
                $new_affliate[] = $new_aff;
            }
            foreach ($lastIndex as $itemAff) {
                if (!in_array($itemAff->aff_level, $new_affliate)) {
                    ProductAffiliate::model()->deleteAllByAttributes(array("affiliate_id" => $itemAff->affiliate_id, "aff_level" => $itemAff['aff_level']));
                }
            }
        }
        // Save or update Product affiliate data
        $affiliateResult = $this->saveProductAffiliate($_POST['ProductAffiliate'],$_POST['ProductAffiliate']['pid']);
        return $affiliateResult;
    }

    if(isset($_POST['ProductLicenses'])){
        //Delete Product Licenses
        $lastIndex = ProductLicenses::model()->findAllByAttributes(array("purchase_product_id" => $_POST['ProductLicenses']['pid']));
        $totalLicense = count($_POST['ProductLicenses']['product_id']);
        if (count($lastIndex > count($totalLicense))) {
            foreach ($_POST['ProductLicenses']['product_id'] as $key => $new_aff) {
                $new_affliate[] = $new_aff;
            }
            foreach ($lastIndex as $itemAff) {
                if (!in_array($itemAff->product_id, $new_affliate)) {
                    ProductLicenses::model()->deleteAllByAttributes(array("id" => $itemAff->id, "product_id" => $itemAff['product_id']));
                }
            }
        }
        // save product licenses data
        $licenseResult = $this->saveProductLicense($_POST['ProductLicenses'],$_POST['ProductLicenses']['pid']);
        return $licenseResult;
    }

    $this->render('update',array(
        'model'=>$model,
        'categories' => $categories,
        'productCategory' => $productCategory,
        'productAffiliate' => $productAffiliate,
        'productLicense' => $productLicense,
    ));
}

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
public function actionDelete()
{
    $product = ProductInfo::model()->findByAttributes(['product_id' => $_POST['id']]);
    /*$product = $this->loadModel($id);*/
    if($product->product_id){
        ProductCategory::model()->deleteAll("product_id='" .$product->product_id."'");
        ProductAffiliate::model()->deleteAll("product_id='".$product->product_id."'");
    }
    $productLicense = ProductLicenses::model()->findAllByAttributes(['product_id' => $product->product_id]);
    if(!empty($productLicense)){
        ProductLicenses::model()->deleteAll("product_id='".$product->product_id."'");
    }
    if(!empty($product->image)){
        $fileExists = is_file(Yii::app()->basePath . '/..' . $product->image)?'yes':'no';
        if($fileExists == 'yes') {
            unlink(Yii::app()->basePath . '/..' . $product->image);
        }
    }
    if($product->delete()){
        echo json_encode([
            'token' => 1,
        ]);
    }
    else{
        echo json_encode([
            'token' => 0,
        ]);
    }

    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    /*if(!isset($_GET['ajax']))
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/
}

    /**
     * Lists all models.
     */
    public function actionIndex()
{
    $dataProvider=new CActiveDataProvider('ProductInfo');
    $this->render('index',array(
        'dataProvider'=>$dataProvider,
    ));
}

    /**
     * Manages all models.
     */
    public function actionAdmin()
{
    $model=new ProductInfo('search');
    $model->unsetAttributes();  // clear any default values
    if(isset($_GET['ProductInfo']))
        $model->attributes=$_GET['ProductInfo'];

    $this->render('admin',array(
        'model'=>$model,
    ));
}

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductInfo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
{
    $model=ProductInfo::model()->findByPk($id);
    if($model===null)
        throw new CHttpException(404,'The requested page does not exist.');
    return $model;
}

    /**
     * Performs the AJAX validation.
     * @param ProductInfo $model the model to be validated
     */
    protected function performAjaxValidation($model)
{
    if(isset($_POST['ajax']) && $_POST['ajax']==='product-info-form')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }
}

    /**
     * save and update product affiliate
     * @param $affiliateData
     * @param $productId
     * @return array
     */
    protected function saveProductAffiliate($affiliateData,$productId){

    foreach ($affiliateData['amount'] as $key => $affAmount){
        if($affAmount != '' && $affiliateData['aff_level'][$key] != ''){
            $productAffiliate = ProductAffiliate::model()->findByAttributes(array("product_id" => $productId,"aff_level" => $affiliateData['aff_level'][$key]));

            if(!empty($productAffiliate)) {
                $productAffiliate->created_at = date('Y-m-d H:i:s');
                $productAffiliate->modified_at = date('Y-m-d H:i:s');

                $productAffiliate->product_id = $productId;
                $productAffiliate->amount = $affAmount;
                $productAffiliate->aff_level = $affiliateData['aff_level'][$key];
                $productAffiliate->save();
            }else{
                $productAffiliate = new ProductAffiliate();
                $productAffiliate->created_at = date('Y-m-d H:i:s');
                $productAffiliate->modified_at = date('Y-m-d H:i:s');

                $productAffiliate->product_id = $productId;
                $productAffiliate->amount = $affAmount;
                $productAffiliate->aff_level = $affiliateData['aff_level'][$key];
                $productAffiliate->save();
            }
        }
    }
    $result = [
        'result' => true,
    ];
    echo json_encode($result);
}

    /**
     * save and update product license
     * @param $licenseData
     * @param $productId
     */
    protected function saveProductLicense($licenseData,$productId){
    foreach ($licenseData['product_id'] as $key => $licenseProId){
        if($licenseProId != '' && $licenseData['license_no'][$key] != ''){
            $productLicenses = ProductLicenses::model()->findByAttributes(array("product_id" => $licenseProId,"purchase_product_id" => $productId));

            if(!empty($productLicenses)) {
                $productLicenses->modified_at = date('Y-m-d H:i:s');
                $productLicenses->product_id = $licenseProId;
                $productLicenses->purchase_product_id = $productId;
                $productLicenses->license_no = $licenseData['license_no'][$key];
                $productLicenses->save();
            }else{
                $productLicenses = new ProductLicenses();
                $productLicenses->created_at = date('Y-m-d H:i:s');
                $productLicenses->modified_at = date('Y-m-d H:i:s');
                $productLicenses->product_id = $licenseProId;
                $productLicenses->purchase_product_id = $productId;
                $productLicenses->license_no = $licenseData['license_no'][$key];
                $productLicenses->save();
            }
        }
    }
    $result = [
        'result' => true,
    ];
    echo json_encode($result);
}
    /**
     * Make image name using this function
     * @param $imageData
     * @return string
     */
    protected  function getImageName($imageData){
    $imagePath = '/uploads/products/';
    $date = date('Ymd');
    $time = time();
    return $imagePath . $date . $time . '.' . pathinfo($imageData, PATHINFO_EXTENSION);
}

    /**
     * Check Sku exists
     * @return boolean
     */
    public function actionCheckSku(){
    $result = 'true';
    $product = ProductInfo::model()->findAllByAttributes(['sku' => $_POST['ProductInfo']['sku']]);
    if (count($product) > 0) {
        $result = 'false';
    }
    echo $result;
}

    /**
     * check sku if same sku in update product then update product
     * @return boolean
     */
    public function actionCheckSku1(){
    $result = 'true';
    $productId = ProductInfo::model()->findByAttributes((['product_id' => $_POST['ProductInfo']['id']]));
    if($productId->sku != $_POST['ProductInfo']['sku']) {
        $product = ProductInfo::model()->findAllByAttributes(['sku' => $_POST['ProductInfo']['sku']]);
        if (count($product) > 0) {
            $result = 'false';
        }
    }
    echo $result;
}

    /**
     * get all product list in select option
     * @return option tag with value
     */
    public function actionProductList(){
    $productList = CHtml::listData(ProductInfo::model()->findAll(['order' => 'name']), 'product_id', 'name');
    echo "<option value=''>Select Product</option>";
    foreach($productList as $value => $product) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($product), true);
    }
}


    /**
     * Manages data for server side datatables.
     */
    public function actionServerdata(){
    /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
    echo json_encode($alldata);*/

    $requestData = $_REQUEST;

//		$model= new ProductInfo();
    $array_cols = Yii::app()->db->schema->getTable('product_info')->columns;
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

    $sql = "SELECT  * from product_info where 1=1";
//		$data = Yii::app()->db->createCommand($sql)->queryAll();
//		$totalFiltered = count($data);

    if (!empty($requestData['search']['value']))
    {
        $sql.=" AND ( product_id LIKE '%" . $requestData['search']['value'] . "%' ";
        foreach($array_cols as  $key=>$col){
            if($col->name != 'product_id')
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
        if($requestData['columns'][$key]['search']['value'] != ''){   //name
            $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
        }
        $j++;
    }
//        echo $sql;die;


    $count_sql = str_replace("*","count(*) as columncount",$sql);
    $data = Yii::app()->db->createCommand($count_sql)->queryAll();
    $totalData = $data[0]['columncount'];
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
        $nestedData[] = $row['product_id'];
        $row['is_subscription_enabled'] = $row['is_subscription_enabled'] == 0? ('No') : ('Yes');
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