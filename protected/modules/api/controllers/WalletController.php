<?php

class WalletController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
			'class'=>'path.to.AnotherActionClass',
			'propertyName'=>'propertyValue',
			),
		);
	}*/

	/*
	 * Get Up-cycle wallet details
	 * */
    public function actionGetupcylewalletdetails(){
        try {
            if(Yii::app()->request->getRequestType() == 'GET'){
                $up_cycle_wallet_entity = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'Upcycling']);
                $up_cycle_wallet = Yii::app()->db->createCommand()
                    ->select('w.user_id, email, sum(case when transaction_type = 0 then amount else 0 end) as credit_amt, sum(case when transaction_type = 1 then amount else 0 end) as debit_amt')
                    ->from('wallet w')
                    ->join('user_info u', 'w.user_id = u.user_id')
                    ->andWhere('wallet_type_id=:wId',[':wId'=>$up_cycle_wallet_entity->wallet_type_id])
                    ->andWhere('transaction_status!=:tStatus',[':tStatus'=>Yii::app()->params['WalletRejectedTransactionStatus']])
                    ->andWhere('w.user_id!=:uId', [':uId'=>Yii::app()->params['SystemUserId']])
                    ->group('w.user_id, email')
                    ->queryAll();

                $up_cycle_wallet_details = [];
                foreach ($up_cycle_wallet as $value){
                    $amount = $value['credit_amt'] - $value['debit_amt'];
                    if($amount >= 5){
                        $temp = [];
                        $temp['user_id'] = $value['user_id'];
                        $temp['amount'] = $amount;
                        $temp['email'] = $value['email'];
                        $up_cycle_wallet_details[] = $temp;
                    }
                }

                ApiResponse::json(true, 200, $up_cycle_wallet_details, "Upcycle Wallet details");
            } else {
                ApiResponse::json(false, 405, '', "Method not allowed");
            }
        } catch(Exception $e) {
            ApiResponse::json(false, 500, [], $e->getMessage());
        }
    }

    /*
     * Set wallet up-cycle debit transaction
     * */
    public function actionSetupcyclewallettransaction(){
        try {
            if(Yii::app()->request->getRequestType() == 'POST'){
                $request = Yii::app()->request->getRawBody();
                $result = CJSON::decode($request);

                if(isset($result['email']) && isset($result['transaction_type']) && isset($result['reference_id'])
                    && isset($result['transaction_status']) && isset($result['portal_id']) && isset($result['amount']) ){
                    $up_cycle_wallet_entity = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'Upcycling']);
                    $user = UserInfo::model()->findByAttributes(['email'=>$result['email']]);
                    $wallet = new Wallet();
                    $wallet->user_id = $user->user_id;
                    $wallet->attributes = $result;
                    $wallet->wallet_type_id = $up_cycle_wallet_entity->wallet_type_id;
                    $wallet->denomination_id = 1;
                    if($wallet->save()){
                        $walletModel = Wallet::model()->findByPk($wallet->wallet_id);
                        $walletData = $walletModel->attributes;
                        ApiResponse::json(1, 201, $walletData, "Wallet tuple created");
                    } else {
                        ApiResponse::json(0, 500, [], "Add wallet error: ".json_encode($wallet->getErrors()));
                    }
                } else {
                    ApiResponse::json(0, 400, '', "Bad request. Missing parameters");
                }
            } else {
                ApiResponse::json(0, 405, '', "Method not allowed");
            }
        } catch(Exception $e) {
            ApiResponse::json(0, 500, [], $e->getMessage());
        }
    }

	/*
	* Get portals name
	* returns json for portals name
	*/
	public function actionGetPortals()
		{
			$portals = Portals::model()->findAll();

			foreach ($portals as $portal) {
				$data[$portal->portal_id] = $portal->portal_name;
			}

			if ($data) {
				ApiResponse::json(true, 200, $data, "Portal name fetched");
			} else {
				ApiResponse::json(true, 200, [], "No portals found");
		}
	}

	/*
	* Get Wallet Type Name
	* return json for wallet type name
	*/
	public function actionGetWalletType()
	{
		$wallets = WalletTypeEntity::model()->findAll();

		foreach ($wallets as $wallet) {
			$data[$wallet->wallet_type_id] = $wallet->wallet_type;
		}

		if ($data) {
			ApiResponse::json(true, 200, $data, "Wallet type fetched");
		} else {
			ApiResponse::json(true, 200, [], "No wallet type found");
		}
	}

	/*
	* Get Denomination Name
	* return json for Denomination name
	*/
	public function actionGetDenominationType()
	{
		//$denominations = Denomination::model()->findAll(array('group' => 'denomination_type'));
		$denominations = Denomination::model()->findAll();
		foreach ($denominations as $denomination) {
			$data[$denomination->denomination_id] = $denomination->denomination_type;
		}

		if ($data) {
			ApiResponse::json(true, 200, $data, "Denomiantion type fetched");
		} else {
			ApiResponse::json(true, 200, [], "No Denomiantion type found");
		}
	}

	/*
	* Get Currency Name
	* return json for Currency name
	*/
	public function actionGetCurrencyName()
	{
		//$denominations = Denomination::model()->findAll(array('group' => 'denomination_type'));
		$denominations = Denomination::model()->findAll();
		foreach ($denominations as $denomination) {
			if ($denomination->currency) {
				$data[$denomination->denomination_id] = $denomination->currency;
			}
		}

		if ($data) {
			ApiResponse::json(true, 200, $data, "Currency type fetched");
		} else {
			ApiResponse::json(true, 200, [], "No Currency type found");
		}
	}

	/**
	* This method is used to add wallet data
	* @return json array
	*/
	public function actionAddWallet()
	{

		if (isset($_POST)) {
			$request = Yii::app()->request->getRawBody();
			$wallet = new Wallet;


			$result = CJSON::decode($request);
			$wallet->attributes = $result;

			$denomiantion_type = Denomination::model()->findByAttributes(array('denomination_id' => $result['denomination_id']));

			if ($denomiantion_type->denomination_type != "cash") {
			$wallet->updated_balance = 0.0;
		}

		$exist_denomiantion = Wallet::model()->findByAttributes(array('denomination_id' => $result['denomination_id'], 'user_id' => $result['user_id']), array('order' => 'wallet_id DESC', 'limit' => 1));
		if ($denomiantion_type->denomination_type === "cash") {

			if ($exist_denomiantion) {
				if ($result['transaction_type'] === "credit") {
					$wallet->updated_balance = $result['amount'] + $exist_denomiantion->updated_balance;
				}

				if ($result['transaction_type'] === "debit") {
					$wallet->updated_balance = $exist_denomiantion->updated_balance - $result['amount'];
				}
			} else {
				$wallet->updated_balance = $result['amount'];
			}
		}

		$wallet->created_at = date('Y-m-d');
			if ($wallet->validate()) {
				if ($wallet->save()) {
					$data = [
					'wallet_id' => $wallet->wallet_id,
					];
					ApiResponse::json(true, 200, $data, "Wallet model saved successfully");
				} else {
					ApiResponse::json(false, 501, [], "Could not save wallet model");
				}
			}else{
				print_r($wallet->Errors);
			}
		}
	}

	/**
	* This method is used to View wallet data
	* @return json array
	*/
	public function actionViewWallet()
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
				$criteria->addBetweenCondition('created_at', ($from), ($to), 'AND');
				$models = Wallet::model()->findAllByAttributes($arr, $criteria);
			}elseif (!$arr && $from != '1970-01-01' && $to != '1970-01-01') {
				$criteria = new CDbCriteria();
				$criteria->addBetweenCondition('created_at', ($from), ($to), 'AND');
				$models = Wallet::model()->findAllByAttributes($arr, $criteria);
			} else {
				$models = Wallet::model()->findAll();
			}
			if ($models) {
				foreach ($models as $model) {
					$wallets[] = $model->attributes;
				}
				if ($wallets) {
					ApiResponse::json(true, 200, $wallets, "Total " . count($wallets) . " Transactin fetched");
				} else {
					ApiResponse::json(false, 500, $wallets);
				}
			} else {
				ApiResponse::json(false, 500, [], "No records found for given parameter");
			}
		}
	}
}