<?php

class ProductController extends Controller {

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
			'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'add'),
			'users' => array('*'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	* This method is used by create new product info
	* @return json array
	*/
	public function actionAdd()
	{
		if (isset($_POST)) {
			$request = Yii::app()->request->getRawBody();
			$product = new ProductInfo;
			$result = CJSON::decode($request);
			$product->attributes = $result;
			$product->created_at = date('Y-m-d h:i:s');
			$product->modified_at = date('Y-m-d h:i:s');

			if ($product->save()) {
				$data = ["user_id" => $product['product_id']];
				ApiResponse::json(true, 200, $data, "Saved successfully");
			} else {
				ApiResponse::json(false, 501, [], "Could not save model");
			}
		}
	}

	/*
	* updates productinfo table
	* @return json array
	*/
	public function actionUpdate($id)
	{
		if (isset($_POST)) {
			$model = $this->loadModel($id, 'ProductInfo');
			$request = Yii::app()->request->getRawBody();
			$result = CJSON::decode($request);
			$model->attributes = $result;
			$model->modified_at = date('Y-m-d h:i:s');
			if ($model->save()) {
				$data = ["user_id" => $model['product_id']];
				ApiResponse::json(true, 200, $data, "Update successfully");
			}else{
				ApiResponse::json(false, 501, [], "Could not save model");
			}
		}
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer $id the ID of the model to be loaded
	* @param string $modelName the Name of the model to be loaded
	* @return UserInfo the loaded model
	* @throws CHttpException
	*/
	public function loadModel($id, $modelName)
	{
		$model = $modelName::model()->findByPk($id);
		if ($model === null) {
			ApiResponse::json(false, 404, [], "The requested page does not exist.");
			exit;
		}
		return $model;
	}

	/**
	* Lists all models.
	*/
	public function actionIndex(){
		try {
			$products = ProductInfo::model()->findAll();
			foreach ($products as $productKey => $product) {
				$model = $this->loadModel($product->product_id, 'ProductInfo');
				$productArr[$productKey] = $model->attributes;// $product->attributes;
			}
			ApiResponse::json(true, 200, $productArr, "products fetched");
		} catch (Exception $e) {
			ApiResponse::json(false, 500, $productArr);
		}
	}

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionView($id){
		$model = $this->loadModel($id, 'ProductInfo');
		$products = $model->attributes;
		if ($products) {
			ApiResponse::json(true, 200, $products, "products id number " . $id . " data fetched");
		}else{
			ApiResponse::json(false, 500, $products);
		}
	}

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionViewData($id){
		$category = $this->loadModel($id, 'Categories');
		$categories = $category->attributes;

		$categories['product'] = Yii::app()->db->createCommand()
			->select('*')
			->from('product_category c')
			->join('product_info p', 'c.prod_cat_id = p.product_id')
			->where('category_id=:id', array(':id' => $id))
			->queryAll();

		if ($categories) {
			ApiResponse::json(true, 200, $categories, "products id number " . $id . " data fetched");
		}else{
			ApiResponse::json(false, 500, $categories);
		}
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDelete($id){
		if ($this->loadModel($id, 'ProductInfo')->delete()) {
			$data = ["product_id" => $id];
			ApiResponse::json(true, 200, $data, "Successfully deleted");
		}else{
			ApiResponse::json(true, 200, "Record already deleted");
		}
	}


	/*
	* Add Product License Details
	*/
	public function actionProductLicenseAdd(){
		try {
			if (isset($_POST)) {
				$request = Yii::app()->request->getRawBody();
				$model = new ProductLicenses;
				$result = CJSON::decode($request);
				$model->attributes = $result;
				$model->created_at = date('Y-m-d h:i:s');
				$model->modified_at = date('Y-m-d h:i:s');
				if ($model->validate()) {
					if ($model->save()) {
						$data = ["product_id" => $model['id']];
						ApiResponse::json(true, 200, $data, "Saved successfully");
					} else {
						ApiResponse::json(false, 501, [], "Could not save model");
					}
				} else {
					print_r($model->Errors);
				}
			}
		} catch (Exception $e) {
			ApiResponse::json(false, 500, [], $e->getMessage());
		}
	}

	/**
	* This method is used by update Product license
	* @return json array
	*/
	public function actionProductLicenseUpdate($id){
		try {
			if (isset($_POST)) {
				$model = $this->loadModel($id, 'ProductLicenses');
				$request = Yii::app()->request->getRawBody();
				$result = CJSON::decode($request);
				$model->attributes = $result;
				$model->modified_at = date('Y-m-d h:i:s');
				//print_r($model->attributes); die;
				if ($model->validate()) {
					if ($model->save()) {
						$data = [
						"license_id" => $model['id']
						];
						ApiResponse::json(true, 200, $data, "Update successfully");
					} else {
						ApiResponse::json(false, 501, [], "Could not save model");
					}
				} else {
				print_r($model->Errors);
				}
			}
		} catch (Exception $e) {
		ApiResponse::json(false, 500, [], $e->getMessage());
		}
	}

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionViewProductLicense($id){
		$category = $this->loadModel($id, 'ProductLicenses');
		$categories = $category->attributes;

		if ($categories) {
			ApiResponse::json(true, 200, $categories, "License id number " . $id . " data fetched");
		}else{
			ApiResponse::json(false, 500, $categories);
		}
	}

	/**
	* Displays all Product Licenses.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionViewProductLicenses(){
		try {
			$model = ProductLicenses::model()->findAll();
			ApiResponse::json(true, 200, $model, "All licenses fetched");
		}catch(Exception $e){
			ApiResponse::json(false, 500, $model);
		}
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionProductLicenseDelete($id){
	if ($this->loadModel($id, 'ProductLicenses')->delete()) {
		$data = ["license_id" => $id];
		ApiResponse::json(true, 200, $data, "Successfully deleted");
	}else{
		ApiResponse::json(true, 200, "Record already deleted");
		}
	}


	/* User Licenses add, update, view, delete api*/

	/*
	* Add Product License Details
	*/
	public function actionUserLicenseAdd()
	{
		$app = Yii::app()->params['applicationName'];
		$table = Yii::app()->db->createCommand()
			->select('table_for_userlicense')
			->from('sys_settings')
			->where("app_name = '$app'")
			->queryRow();

		$chk = $table['table_for_userlicense'];
		if ($chk == 1) {
			if (isset($_POST)) {
				$request = Yii::app()->request->getRawBody();
				$model = new UserLicenseCount;
				$result = CJSON::decode($request);
				$current_id = $result['user_id'];
				$current_prod_id = $result['product_id'];
				$current_total_licenses = $result['total_licenses'];

				$exist_users = Yii::app()->db->createCommand()
					->select('*')
					->from('user_license_count')
					->group("user_id")
					->queryall();

				foreach ($exist_users as $users) {
					$user[] = $users['user_id'];
				}

				$model1 = UserLicenseCount::model()->find();

			if ($model1 !== null) {
				if (in_array($current_id, $user)) {
					$available_user_license = Yii::app()->db->createCommand()
					->select('*')
					->from('user_license_count')
					->where("user_id = $current_id AND product_id = '$current_prod_id'")
					->queryall();

					foreach ($available_user_license as $user_license) {
						$exist_license = $user_license['total_licenses'];
						$exist_avail_license = $user_license['available_licenses'];
					}

					$exist_user_license = Yii::app()->db->createCommand()
					->select('*')
					->from('user_license_count')
					->where("user_id = $current_id")
					->queryall();

					foreach ($exist_user_license as $user_license) {
						$produ_id[] = $user_license['product_id'];
					}
					if (in_array($current_prod_id, $produ_id)) {
						$total_license = $exist_license + $current_total_licenses;
						$total_avail_license = $exist_avail_license + $current_total_licenses;
						if (Yii::app()->db->createCommand("UPDATE `user_license_count` SET `total_licenses` = '$total_license',`available_licenses`= '$total_avail_license' WHERE `product_id`= '$current_prod_id' AND `user_id` = $current_id;")->execute()) {
							$data = ["user_id" => $current_id];
							ApiResponse::json(true, 200, $data, "Updated successfully");
						}else{
							ApiResponse::json(false, 501, [], "Could not update model");
						}
					}else{
						if (isset($_POST)) {
							$request = Yii::app()->request->getRawBody();
							$model = new UserLicenseCount;
							$result = CJSON::decode($request);
							$model->attributes = $result;
							$model->available_licenses = $result['total_licenses'];
							$model->created_at = date('Y-m-d h:i:s');
							$model->modified_at = date('Y-m-d h:i:s');
							if ($model->validate()){
								if ($model->save()) {
									$data = ["user_id" => $model['user_id']];
									ApiResponse::json(true, 200, $data, "New license added to user successfully");
								} else {
									ApiResponse::json(false, 501, [], "Could not save model while adding license to extisting record");
								}
							} else {
								print_r($model->Errors);
							}
						}
					}
				}else {
					if (isset($_POST)) {
						$request = Yii::app()->request->getRawBody();
						$model = new UserLicenseCount;
						$result = CJSON::decode($request);
						$model->attributes = $result;
						$model->available_licenses = $result['total_licenses'];
						$model->created_at = date('Y-m-d h:i:s');
						$model->modified_at = date('Y-m-d h:i:s');
						if ($model->validate()){
							if ($model->save()) {
								$data = ["user_id" => $model['user_id']];
								ApiResponse::json(true, 200, $data, "Saved successfully");
							} else {
								ApiResponse::json(false, 501, [], "Could not save model");
							}
						} else {
							print_r($model->Errors);
							}
						}
					}
				}else{
					if (isset($_POST)) {
						$request = Yii::app()->request->getRawBody();
						$model = new UserLicenseCount;
						$result = CJSON::decode($request);
						$model->attributes = $result;
						$model->available_licenses = $result['total_licenses'];
						$model->created_at = date('Y-m-d h:i:s');
						$model->modified_at = date('Y-m-d h:i:s');
						if ($model->validate()){
							if ($model->save()) {
								$data = ["user_id" => $model['user_id']];
								ApiResponse::json(true, 200, $data, "Record saved successfully");
							} else {
								ApiResponse::json(false, 501, [], "Could not save model");
							}
						} else {
							print_r($model->Errors);
						}
					}
				}
			}
		} else {
			if (isset($_POST)) {
				$request = Yii::app()->request->getRawBody();
				$model = new UserLicenses;
				$result = CJSON::decode($request);
				$model->attributes = $result;
				$model->funded_on = date('Y-m-d h:i:s');
				$model->created_at = date('Y-m-d h:i:s');
				if ($model->validate()){
					if ($model->save()) {
						$data = ["user_id" => $model['license_id']];
						ApiResponse::json(true, 200, $data, "Saved successfully");
					} else {
						ApiResponse::json(false, 501, [], "Could not save model");
					}
				} else {
					print_r($model->Errors);
				}
			}
		}
	}

	/**
	* This method is used by update Product license
	* @return json array
	*/
	public function actionUserLicenseUpdate($id){

		$app = Yii::app()->params['applicationName'];
		$table = Yii::app()->db->createCommand()
			->select('table_for_userlicense')
			->from('sys_settings')
			->where("app_name = '$app'")
			->queryRow();

		$chk = $table['table_for_userlicense'];

		if ($chk == 1) {
			if (isset($_POST)) {
				$model = $this->loadModel($id, 'UserLicenseCount');
				$request = Yii::app()->request->getRawBody();

				$result = CJSON::decode($request);
				$model->attributes = $result;
				$model->modified_at = date('Y-m-d h:i:s');
				if ($model->validate()){
					if ($model->save()) {
						$data = ["user_id" => $model['license_id']];
						ApiResponse::json(true, 200, $data, "Update successfully");
					} else {
						ApiResponse::json(false, 501, [], "Could not save model");
					}
				} else {
					print_r($model->Errors);
				}
			}
		}else{
			if (isset($_POST)) {
				$model = $this->loadModel($id, 'UserLicenses');
				$request = Yii::app()->request->getRawBody();
				$result = CJSON::decode($request);
				$model->attributes = $result;
				$model->funded_on = date('Y-m-d h:i:s');
				if ($model->validate()){
					if ($model->save()) {
						$data = ["user_id" => $model['license_id']];
						ApiResponse::json(true, 200, $data, "Update successfully");
					} else {
						ApiResponse::json(false, 501, [], "Could not save model");
					}
				} else {
					print_r($model->Errors);
				}
			}
		}
	}

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionViewUserLicense($id){
	$app = Yii::app()->params['applicationName'];
	$table = Yii::app()->db->createCommand()
		->select('table_for_userlicense')
		->from('sys_settings')
		->where("app_name = '$app'")
		->queryRow();

	$chk = $table['table_for_userlicense'];
		if ($chk == 1) {
			$category = $this->loadModel($id, 'UserLicenseCount');
			$categories = $category->attributes;
			$categories['product'] = Yii::app()->db->createCommand()
			->select('*')
			->from('product_category c')
			->join('product_info p', 'c.prod_cat_id = p.product_id')
			->where('category_id=:id', array(':id' => $id))
			->queryAll();
			if ($categories) {
				ApiResponse::json(true, 200, $categories, "users id number " . $id . " data fetched");
			} else {
				ApiResponse::json(false, 500, $categories);
			}
		}else{
			$category = $this->loadModel($id, 'UserLicenses');
			$categories = $category->attributes;
			if ($categories) {
				ApiResponse::json(true, 200, $categories, "License id number " . $id . " data fetched");
			}else{
				ApiResponse::json(false, 500, $categories);
			}
		}
	}

	/**
	* Displays all Product Licenses.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionViewUserLicenses(){
		$app = Yii::app()->params['applicationName'];
		$table = Yii::app()->db->createCommand()
		->select('table_for_userlicense')
		->from('sys_settings')
		->where("app_name = '$app'")
		->queryRow();
		$chk = $table['table_for_userlicense'];
		//print_r($chk); die;
		if ($chk == 1) {
			try {
				$products = UserLicenseCount::model()->findAll();
				ApiResponse::json(true, 200, $products, "license fetched");
			}catch(Exception $e) {
				ApiResponse::json(false, 500, $products);
			}
		}else{
			try {
				$model = UserLicenses::model()->findAll();
				ApiResponse::json(true, 200, $model, "All licenses fetched");
			}catch(Exception $e){
				ApiResponse::json(false, 500, $model);
			}
		}
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionUserLicenseDelete($id){

		$app = Yii::app()->params['applicationName'];
		$table = Yii::app()->db->createCommand()
			->select('table_for_userlicense')
			->from('sys_settings')
			->where("app_name = '$app'")
			->queryRow();
		$chk = $table['table_for_userlicense'];

		if ($chk == 1) {
			if ($this->loadModel($id, 'UserLicenseCount')->delete()) {
				$data = ["license_id" => $id];
				ApiResponse::json(true, 200, $data, "Successfully deleted");
			}else{
				ApiResponse::json(true, 200, "Record already deleted");
			}
		}else{
			if ($this->loadModel($id, 'UserLicenses')->delete()) {
				$data = ["license_id" => $id];
				ApiResponse::json(true, 200, $data, "Successfully deleted");
			}else{
				ApiResponse::json(true, 200, "Record already deleted");
			}
		}
	}
}
