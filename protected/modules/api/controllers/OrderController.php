<?php

class OrderController extends Controller {

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules(){
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
	* This method is used by create new user,address,business
	* @return json array
	*/
	public function actionAdd(){

		if (isset($_POST)) {
			$request = Yii::app()->request->getRawBody();
			$order = new OrderInfo;
			$order_item = new OrderLineItem;
			$order_payment = new OrderPayment;

			$result = CJSON::decode($request);
			foreach ($result as $res) {

				$order->attributes = $res['order_arr'];
				$order->invoice_date = date('Y-m-d');
				$order->created_date = date('Y-m-d');
				$order->modified_date = date('Y-m-d');
					if ($order->validate()) {
						if ($order->save()) {
							foreach ($res['order_line_item'] as $itemKey => $orders) {
							$order_item = new OrderLineItem;
							$order_item->attributes = $orders;
							$order_item->order_info_id = $order->order_info_id;
							$order_item->created_at = date('Y-m-d');
							$order_item->modified_at = date('Y-m-d');
							$order_item->save();
						}
							if ($order_item->validate()) {
								if ($order_item->save()) {
									$order_payment->attributes = $res['order_payment'];
									$order_payment->order_info_id = $order->order_info_id;
									$order_payment->payment_date = date('Y-m-d');
									$order_payment->created_at = date('Y-m-d');
									$order_payment->modified_at = date('Y-m-d');
										if ($order_payment->payment_status == 1 || $order_payment->payment_status == 2) {
											if ($order_payment->validate()) {
												if ($order_payment->save()) {
												$data = ["order_id" => $order['order_id']];
												ApiResponse::json(true, 200, $data, "Saved successfully");
												}
											} else {
												$error = $order_payment->Errors;
												ApiResponse::json(false, 501, $error, "Could not save order payment model");
											}
										} else {
										ApiResponse::json(false, 501, [], "Payment status not allowed. 1 or 2 is valid value");
										}
									}
								} else {
								$error = $order_item->Errors;
								ApiResponse::json(false, 501, $error, "Could not save order line item model");
							}
						}
					} else {
					$error = $order->Errors;
					ApiResponse::json(false, 501, $error, "Could not save order info model");
				}
			}

		}
	}

	/*
	* Updates order infon order payment & order line item records
	* @param integer $id the ID of the model to be update
	*/

	public function actionUpdate($id){
		if (isset($_POST)) {
			$order = $this->loadModel($id, 'OrderInfo');
			$request = Yii::app()->request->getRawBody();
			$result = CJSON::decode($request);
			foreach ($result as $res) {
			$order->attributes = $res['order_arr'];
			$order->invoice_date = date('Y-m-d');
			$order->created_date = date('Y-m-d');
			$order->modified_date = date('Y-m-d');
				if ($order->validate()) {
					if ($order->save()) {
						if (isset($res['order_line_item'])) {
							foreach ($res['order_line_item'] as $ItemKey => $order) {
								if (!empty($order)) {
									$order_item = OrderLineItem::model()->findByAttributes(array('order_info_id' => $id));
									$order_item->attributes = $order;
									$order_item->created_at = date('Y-m-d');
									$order_item->modified_at = date('Y-m-d');
										if ($order_item->validate()) {
											$order_item->save();
										} else {
											print_r($order_item->getErrors());
										}
								}else{
									$msg = ["error" => "Empty order_info_id id"];
									ApiResponse::json(false, 405, [], $msg);
								}
							}
						}
						if (isset($res['order_payment'])) {
							$order_payment = OrderPayment::model()->findByAttributes(array('order_info_id' => $id));
							//$order_payment = $this->loadModel($orderPaymentId->order_info_id, 'OrderPayment');
							//$order_payment = $this->loadModel(10, 'OrderPayment');
							$order_payment->attributes = $res['order_payment'];
							$order_payment->payment_date = date('Y-m-d');
							$order_payment->created_at = date('Y-m-d');
							$order_payment->modified_at = date('Y-m-d');
								if ($order_payment->validate()) {
									if ($order_payment->save()) {
										$data = ["order_id" => $order_payment->order_info_id];
										ApiResponse::json(true, 200, $data, "Updated successfully");
									}else{
										ApiResponse::json(false, 501, [], "Could not save order payment model");
									}
								}else{
									print_r($order_payment->getErrors());
								}
						} else {
							ApiResponse::json(false, 501, [], "Could not save order line item model");
					}
				} else {
					ApiResponse::json(false, 501, [], "Could not save order info model");
				}
			}else{
			print_r($order->getErrors());
		}
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
	* Lists all records of orderinfo table
	*/
	public function actionIndex(){
		try {
			$orders = OrderInfo::model()->findAll();
			foreach ($orders as $orderKey => $order) {
			$model = $this->loadModel($order->order_info_id, 'OrderInfo');
			$orderArr[$orderKey] = $model->attributes;// $user->attributes;
		}
			ApiResponse::json(true, 200, $orderArr, "orders fetched");
		}catch(Exception $e) {
			ApiResponse::json(false, 500, $orderArr);
		}
	}

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionView(){
        {
            $request = Yii::app()->request->getRawBody();
            $result = CJSON::decode($request);
            
            $arr = array();
                foreach ($result as $key => $res) {
                    if ($res && $key != "start_date" && $key != "end_date") {
                        $arr[$key] = $res;
                    }
                }

			$from = $result['start_date']." 00:00:00";
			$to = $result['end_date']." 23:59:59";
            
            if ($from === '1970-01-01' && $to != '1970-01-01' || $from != '1970-01-01' && $to === '1970-01-01'){
                ApiResponse::json(true, 501, [], "Please Enter Date Range Correctly");
            } else {
                if ($arr && $from === '1970-01-01' && $to === '1970-01-01') {
                    $models = Wallet::model()->findAllByAttributes($arr);
                } elseif ($from != '1970-01-01' && $to != '1970-01-01' & $arr) {
                    $criteria = new CDbCriteria();
                    $criteria->addBetweenCondition('created_date', ($from), ($to), 'AND');
                    $models = OrderInfo::model()->findAllByAttributes($arr, $criteria);
                }elseif (!$arr && $from != '1970-01-01' && $to != '1970-01-01') {
                    $criteria = new CDbCriteria();
                    $criteria->addBetweenCondition('created_date', ($from), ($to), 'AND');
                    $models = OrderInfo::model()->findAllByAttributes($arr, $criteria);
                }else{
                    $models = OrderInfo::model()->findAll();
                }
    
                if ($models) {
                    foreach ($models as $model) {
                    $orders[] = $model->attributes;
                    }
                    if ($orders) {
                        ApiResponse::json(true, 200, $orders, "Total " . count($orders) . " records fetched");
                    } else {
                        ApiResponse::json(false, 500, $orders);
                    }
                } else {
                    ApiResponse::json(false, 500, [], "No records found for given parameter");
                }
            }
        }
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDelete($id){

		if (OrderLineItem::model()->deleteAllByAttributes(array('order_info_id' => $id)) && OrderPayment::model()->deleteAllByAttributes(array('order_info_id' => $id)) && $this->loadModel($id, 'OrderInfo')->delete()) {
			$data = ["order_info_id" => $id];
			ApiResponse::json(true, 200, $data, "Successfully deleted");
		}else{
			$data = ["order_info_id" => $id];
			ApiResponse::json(false, 501, $data, "Record not found");
		}
	}

	/**
	* Add cart records for new cart and update the if same item already exist in table.
	*/

	public function actionAddCart(){
		$cart = new OrderCart;
		$request = Yii::app()->request->getRawBody();
		$result = CJSON::decode($request);
		$cart->attributes = $result;
		$cart->created_at = date('Y-m-d');
		$cart->modified_at = date('Y-m-d');

		$exist_cart = OrderCart::model()->findByAttributes(array("product_id" => $result['product_id'], "user_id" => $result['user_id']));

		if ($exist_cart) {
			$exist_cart->item_qty = $result['item_qty'] + $exist_cart->item_qty;
			$exist_cart->created_at = date('Y-m-d');
			$exist_cart->modified_at = date('Y-m-d');
				if ($exist_cart->validate()) {
					if ($exist_cart->save()) {
						$data = ["cart_id" => $exist_cart['cart_id']];
						ApiResponse::json(true, 200, $data, "Cart updated successfully");
					}else{
						ApiResponse::json(false, 501, [], "Could not update cart model");
					}
				}else{
					print_r($exist_cart->getErrors());
				}
		}else{
			if ($cart->validate()) {
				if ($cart->save()) {
					$data = ["cart_id" => $cart['cart_id']];
					ApiResponse::json(true, 200, $data, "Saved successfully");
				}else{
					ApiResponse::json(false, 501, [], "Could not save cart model");
				}
			} else {
				print_r($cart->getErrors());
			}
		}

	}

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionViewCart($id)
	{
		$model = $this->loadModel($id, 'OrderCart');
		$cart = $model->attributes;
		if ($cart) {
			ApiResponse::json(true, 200, $cart, "users id number " . $id . " data fetched");
		}else{
			ApiResponse::json(false, 500, $cart);
		}
	}

	/**
	* Displays all records from model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionViewAllCart()
	{
		try {
			$carts = OrderCart::model()->findAll();
			foreach ($carts as $cartKey => $cart) {
				$model = $this->loadModel($cart->cart_id, 'OrderCart');
				$cartArr[$cartKey] = $model->attributes;// $user->attributes;
			}
			ApiResponse::json(true, 200, $cartArr, "cart item fetched");
		} catch (Exception $e) {
			ApiResponse::json(false, 500, $cartArr);
		}
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionCartDelete($id)
	{
		if ($this->loadModel($id, 'OrderCart')->delete()) {
			$data = ["cart_id" => $id];
			ApiResponse::json(true, 200, $data, "Successfully deleted");
		}else{
			$data = ["cart_id" => $id];
			ApiResponse::json(false, 501, $data, "Record not found");
		}
	}

	/**
	* This method is used to add record in order_credit_memo
	*/
	public function actionAddMemo()
	{
		if (isset($_POST)) {
			$request = Yii::app()->request->getRawBody();
			$order = new OrderCreditMemo();
			$result = CJSON::decode($request);
			$order->attributes = $result;
			$order->created_at = date('Y-m-d');
			$order->modified_at = date('Y-m-d');
			if ($order->validate()) {
				if ($order->save()) {
					$data = ["credit_memo_id" => $order['credit_memo_id']];
					ApiResponse::json(true, 200, $data, "Memo saved successfully");
				}else{
					ApiResponse::json(false, 501, [], "Could not save order credit memo model");
				}
			}else{
				print_r($order->getErrors());
			}
		}
	}

	/*
	* update memo records
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdateMemo($id)
	{
		if (isset($_POST)) {
			$order = $this->loadModel($id, 'OrderCreditMemo');
			$request = Yii::app()->request->getRawBody();
			$result = CJSON::decode($request);
			$order->attributes = $result;
			$order->created_at = date('Y-m-d');
			$order->modified_at = date('Y-m-d');
			if ($order->validate()) {
				if ($order->save()) {
					$data = ["credit_memo_id" => $order->credit_memo_id];
					ApiResponse::json(true, 200, $data, "Memo update successfully");
				} else {
					ApiResponse::json(false, 501, [], "Could not update model");
				}
			}else{
				print_r($order->getErrors());
			}
		}
	}

	/*
	* Deletes records for order_credit_memo table
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDeleteMemo($id)
	{
		if ($this->loadModel($id, 'OrderCreditMemo')->delete()) {
			$data = ["credit_memo_id" => $id];
			ApiResponse::json(true, 200, $data, "Successfully deleted");
		}else{
			$data = ["order_info_id" => $id];
			ApiResponse::json(false, 501, $data, "Record not found");
		}
	}

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionViewMemo($id)
	{
		$model = $this->loadModel($id, 'OrderCreditMemo');
		$cart = $model->attributes;
		if ($cart) {
			ApiResponse::json(true, 200, $cart, "users id number " . $id . " data fetched");
		}else{
			ApiResponse::json(false, 500, $cart);
		}
	}

	/**
	* Displays all records from model
	*/
	public function actionViewAllMemo()
	{
		try {
			$order_memo = OrderCreditMemo::model()->findAll();
			foreach ($order_memo as $memoKey => $memo) {
				$model = $this->loadModel($memo->credit_memo_id, 'OrderCreditMemo');
				$memoArr[$memoKey] = $model->attributes;// $user->attributes;
			}
			ApiResponse::json(true, 200, $memoArr, "credit memo fetched");
		} catch (Exception $e) {
			ApiResponse::json(false, 500, $memoArr);
		}
	}
}
