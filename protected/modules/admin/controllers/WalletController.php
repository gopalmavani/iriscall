<?php

class WalletController extends CController
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Wallet;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Wallet'])) {
            $user = UserInfo::model()->findByAttributes(['user_id' => $_POST['Wallet']['user_id']]);
            $model->attributes = $_POST['Wallet'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->modified_at = date('Y-m-d H:i:s');
            $users = ($user->user_id) ? ' of user <a href="' . Yii::app()->createUrl('admin/userInfo/view') . '/' . $user->user_id . '"> ' . $user->full_name . '</a>' : '';
            $amount = ($_POST['Wallet']['amount']) ? ' for &euro;' . $_POST['Wallet']['amount'] : '';
            $body = 'Wallet request ' . $amount . $users . ' received.';
            if ($model->validate()) {
                if ($model->save())
                    $url = Yii::app()->createUrl('admin/wallet/view/') . '/' . $model->wallet_id;
                if ($model->transaction_type == 1) {
                    NotificationHelper::AddNotitication('Withdrawal Request', $body, 'info', $user->user_id, 1, $url);
                }
                $this->redirect(array('view', 'id' => $model->wallet_id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Wallet'])) {
            $model->attributes = $_POST['Wallet'];
            $model->modified_at = date('Y-m-d H:i:s');
            if ($model->validate()) {
                if ($model->save())
                    $this->redirect(array('view', 'id' => $model->wallet_id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        /*$this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/

        $model = Wallet::model()->findByAttributes(['wallet_id' => $_POST['id']]);
        if (!empty($model)) {
            if (Wallet::model()->deleteAll("wallet_id ='" . $model->wallet_id . "'")) {
                echo json_encode([
                    'token' => 1,
                ]);
            } else {
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
        $this->redirect(array('admin'));
        $dataProvider = new CActiveDataProvider('Wallet');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Wallet('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Wallet']))
            $model->attributes = $_GET['Wallet'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*
    * Display All type of Wallet and sum of amount by Users.
    */
    public function actionUser()
    {
        $model = new Wallet('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Wallet']))
            $model->attributes = $_GET['Wallet'];

        $this->render('user', array(
            'model' => $model,
        ));
    }

    /**
     * Manages data for server side dataTables.
     */
    public function actionUsersdata()
    {
        /*$alldata = Yii::app()->db->createCommand("SELECT * FROM user_info")->queryAll();
        echo json_encode($alldata);*/

        $requestData = $_REQUEST;

//      $model= new wallet();
        $array_cols = Yii::app()->db->schema->getTable('wallet')->columns;
        $array = array();
        $array_colms['userWallet'] = 'userWallet';
        $array_colms['fanWallet'] = 'fanWallet';
        $array_colms['backupWallet'] = 'backupWallet';
        $array_colms['FloatingWallet'] = 'FloatingWallet';
        $array_colms['UpcyclingWallet'] = 'UpcyclingWallet';
        $array_colms['CompanyWallet'] = 'CompanyWallet';
        $array_colms['SwimlaneWallet'] = 'SwimlaneWallet';
        $i = 0;
        foreach ($array_cols as $key => $col) {
            $array[$i] = $col->name;
            $i++;
        }
        $array[$i] = $array_colms['userWallet'];
        $i++;
        $array[$i] = $array_colms['fanWallet'];
        $i++;
        $array[$i] = $array_colms['backupWallet'];
        $i++;
        $array[$i] = $array_colms['FloatingWallet'];
        $i++;
        $array[$i] = $array_colms['UpcyclingWallet'];
        $i++;
        $array[$i] = $array_colms['CompanyWallet'];
        $i++;
        $array[$i] = $array_colms['SwimlaneWallet'];
        $columns = $array;

        $sql = "SELECT  a.*,b.full_name as fullname,b.email as email from wallet a INNER JOIN user_info b ON a.user_id = b.user_id where 1=1";


        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( b.full_name LIKE '%" . $requestData['search']['value'] . "%' ";
            /*foreach($array_cols as  $key=>$col){
                if($col->name != 'id')
                {
                    $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }*/
            $sql .= ")";
        }
        $j = 0;

        $sql .= " group by user_id ";
        // $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $totalData = count($data);
        $totalFiltered = $totalData;


        if ($columns[$requestData['order'][0]['column']] == 'user_id') {
            $sql .= " ORDER BY b.full_name   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
                $requestData['length'] . "   ";
        } else {
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
                $requestData['length'] . "   ";
        }

        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i = 1;

        foreach ($result as $key => $row) {
            $nestedData = array();

            $walletData = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount, wallet_type_id')
                ->from('wallet')
                ->where('user_id=:user', [':user' => $row['user_id']])
                ->group('wallet_type_id')
                ->order('wallet_type_id asc')
                ->queryAll();
            $row['user_id'] = $row['fullname'] . "<br><p class='text-muted'>" . $row['email'] . "</p>";

            if (isset($walletData[0]['amount']))
                $row["userWallet"] = round($walletData[0]['amount'], 3);
            else
                $row["userWallet"] = 0;

            if (isset($walletData[1]['amount']))
                $row["fanWallet"] = round($walletData[1]['amount'], 3);
            else
                $row["fanWallet"] = 0;

            if (isset($walletData[2]['amount']))
                $row["backupWallet"] = round($walletData[2]['amount'], 3);
            else
                $row["backupWallet"] = 0;

            if (isset($walletData[3]['amount']))
                $row['FloatingWallet'] = round($walletData[3]['amount'], 3);
            else
                $row["FloatingWallet"] = 0;

            if (isset($walletData[4]['amount']))
                $row['UpcyclingWallet'] = round($walletData[4]['amount'], 3);
            else
                $row["UpcyclingWallet"] = 0;

            if (isset($walletData[5]['amount']))
                $row['CompanyWallet'] = round($walletData[5]['amount'], 3);
            else
                $row["CompanyWallet"] = 0;

            if (isset($walletData[6]['amount']))
                $row['SwimlaneWallet'] = round($walletData[6]['amount'], 3);
            else
                $row["SwimlaneWallet"] = 0;


            foreach ($array_cols as $key => $col) {
                $nestedData[] = $row["$col->name"];
            }
            $nestedData[] = $row["userWallet"];
            $nestedData[] = $row["fanWallet"];
            $nestedData[] = $row["backupWallet"];
            $nestedData[] = $row["FloatingWallet"];
            $nestedData[] = $row["UpcyclingWallet"];
            $nestedData[] = $row["CompanyWallet"];
            $nestedData[] = $row["SwimlaneWallet"];

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


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Wallet the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Wallet::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Wallet $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'wallet-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * created crud for pending record of wallet.
     */

    public function actionPending()
    {

        $model = new WalletSearch('search');

        $model->unsetAttributes();
        if (isset($_GET['Wallet']))
            $model->attributes = $_GET['Wallet'];

        $this->render('pending', array(
            'model' => $model,
        ));
    }

    /*
     * Displays an overview of all the wallets
     * */
    public function actionOverview()
    {
        setlocale(LC_MONETARY, 'nl_NL.UTF-8');
        $walletTypes = WalletTypeEntity::model()->findAll();
        $result = array();
        //For ajax requests
        if (isset($_POST['start_date'])) {
            $myDateTime = DateTime::createFromFormat('F, Y', $_POST['start_date']);
            $start_month = $myDateTime->format('m');
            $start_year = $myDateTime->format('Y');
            $calculation_date = $_POST['start_date'];
        } else {
            $start_month = date('m');
            $start_year = date('Y');
            $calculation_date = date('F, Y');
        }
        $total = 0;
        foreach ($walletTypes as $type) {
            $temp = array();
            $credit = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount')
                ->from('wallet')
                ->where('transaction_type=:typ', [':typ' => Yii::app()->params['CreditTransactionType']])
                ->andWhere('wallet_type_id=:rnum', [':rnum' => $type->wallet_type_id])
                ->andWhere(['like', 'transaction_comment', ['%' . $calculation_date . '%']])
                ->queryRow();
            $debit = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount')
                ->from('wallet')
                ->where('transaction_type=:typ', [':typ' => Yii::app()->params['DebitTransactionType']])
                ->andWhere('wallet_type_id=:rnum', [':rnum' => $type->wallet_type_id])
                ->andWhere(['like', 'transaction_comment', ['%' . $calculation_date . '%']])
                ->queryRow();
            if (isset($credit['amount'])) {
                if (isset($debit['amount'])) {
                    $effectiveBalance = $credit['amount'] - $debit['amount'];
                } else {
                    $effectiveBalance = $credit['amount'];
                }
            } else {
                $effectiveBalance = 0;
            }
            $temp['name'] = $type->wallet_type;
            $temp['amount'] = money_format('%(.5n', $effectiveBalance);
            $total += $effectiveBalance;
            $temp['href'] = Yii::app()->createUrl('admin/wallet/details') . '?type=' . $type->wallet_type_id . '&month=' . $start_month . '&year=' . $start_year;
            $result[$type->wallet_type_id] = $temp;
            $temp = null;
        }
        if (isset($_POST['start_date'])) {
            $report_total = Yii::app()->db->createCommand()
                ->select('sum(commission) as amount')
                ->from('cbm_commission')
                ->where('month=:mt', [':mt' => $start_month])
                ->andWhere('year=:yr', [':yr' => $start_year])
                ->queryRow();
            $data = array();
            $data['result'] = $result;
            $data['month'] = $start_month;
            $data['year'] = $start_year;
            $data['total'] = money_format('%(.5n', $total);
            $data['reportTotal'] = money_format('%(.5n', $report_total['amount']);
            echo json_encode($data);
        } else {
            $this->render('overview', [
                'wallets' => $result,
                'totalCommission' => money_format('%(.5n', $total)
            ]);
        }
    }

    /*
     * For User and Transaction specific details
     * */
    public function actionDetails()
    {
        setlocale(LC_MONETARY, 'nl_NL.UTF-8');
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            if (isset($_GET['month']))
                $start_month = $_GET['month'];
            else
                $start_month = date('m');
            if (isset($_GET['year']))
                $start_year = $_GET['year'];
            else
                $start_year = date('y');
            $dateObj = DateTime::createFromFormat('!m', $start_month);
            $monthName = $dateObj->format('F');
            $walletSummary = Yii::app()->db->createCommand()
                ->select('wallet_type_id, transaction_type, sum(amount) as amount')
                ->from('wallet')
                ->where('wallet_type_id=:type', [':type' => $type])
                ->andWhere(['like', 'transaction_comment', ['%' . $monthName . ', ' . $start_year . '%']])
                ->group('wallet_type_id, transaction_type')
                ->queryAll();
            $userSummary = Yii::app()->db->createCommand()
                ->select('user_id, wallet_type_id, transaction_type, sum(amount) as amount')
                ->from('wallet')
                ->where('wallet_type_id=:type', [':type' => $type])
                ->andWhere(['like', 'transaction_comment', ['%' . $monthName . ', ' . $start_year . '%']])
                ->group('user_id, wallet_type_id, transaction_type')
                ->queryAll();

            $userSummaryDetails = array();
            $temp = array();
            foreach ($userSummary as $record) {
                $user = UserInfo::model()->findByPk($record['user_id']);
                $temp['user_name'] = $user->full_name;
                $temp['email'] = $user->email;
                $temp['transaction_type'] = ($record['transaction_type'] == Yii::app()->params['CreditTransactionType'] ? 'Credit' : 'Debit');
                $temp['amount'] = money_format('%(.5n', $record['amount']);
                array_push($userSummaryDetails, $temp);
            }
            $wallet = WalletTypeEntity::model()->findByPk($type);
            $this->render('details', [
                'walletSummary' => $walletSummary,
                'userSummary' => $userSummaryDetails,
                'wallet_name' => $wallet->wallet_type,
                'monthYear' => $monthName . ', ' . $start_year,
                'month' => $start_month,
                'year' => $start_year,
                'wallet_type' => WalletTypeEntity::model()->findByPk($type)->wallet_type
            ]);
        }
    }

    /*
     * For node specific details
     * */
    public function actionNodespecificdetails()
    {
        setlocale(LC_MONETARY, 'nl_NL.UTF-8');
        $month = $_GET['month'];
        $year = $_GET['year'];
        $type = $_GET['type'];
        $email = $_GET['email'];
        if (!empty($month)) {
            $dateObj = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('F');
        } else {
            $monthName = "";
        }
        $user = UserInfo::model()->findByAttributes(['email' => $email]);
        $cbmUserAccounts = CbmUserAccounts::model()->findAllByAttributes(['email_address' => $email]);
        $nodeNum = Yii::app()->db->createCommand()
            ->select('user_account_num, matrix_node_num')
            ->from('cbm_user_accounts')
            ->where('email_address=:email', [':email' => $email])
            ->andWhere('agent_num=:agt', [':agt' => Yii::app()->params['CBMAgentNumber']])
            ->queryAll();
        $finalRes = array();
        foreach ($nodeNum as $item) {
            $temp = array();
            $nodeCredit = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount')
                ->from('wallet')
                ->where('wallet_type_id=:id', [':id' => $type])
                ->andWhere('user_id=:uId', [':uId' => $user->user_id])
                ->andWhere('transaction_type=:typ', [':typ' => Yii::app()->params['CreditTransactionType']])
                ->andWhere('reference_num=:nodeId', [':nodeId' => $item['matrix_node_num']])
                ->andWhere(['like', 'transaction_comment', ['%' . $monthName . ', ' . $year . '%']])
                ->queryRow();
            $nodeDebit = Yii::app()->db->createCommand()
                ->select('sum(amount) as amount')
                ->from('wallet')
                ->where('wallet_type_id=:id', [':id' => $type])
                ->andWhere('user_id=:uId', [':uId' => $user->user_id])
                ->andWhere('transaction_type=:typ', [':typ' => Yii::app()->params['DebitTransactionType']])
                ->andWhere('reference_num=:nodeId', [':nodeId' => $item['matrix_node_num']])
                ->andWhere(['like', 'transaction_comment', ['%' . $monthName . ', ' . $year . '%']])
                ->queryRow();
            if (is_null($nodeCredit['amount']))
                $credit = 0;
            else
                $credit = $nodeCredit['amount'];
            if (is_null($nodeDebit['amount']))
                $debit = 0;
            else
                $debit = $nodeDebit['amount'];
            $effective_balance = $credit - $debit;
            $temp['account_num'] = $item['user_account_num'];
            $temp['node_num'] = $item['matrix_node_num'];
            $temp['credit'] = money_format('%(.5n', $credit);
            $temp['debit'] = money_format('%(.5n', $debit);
            $temp['effective_balance'] = money_format('%(.5n', $effective_balance);
            array_push($finalRes, $temp);
        }
        $this->render('nodedetails', [
            'result' => $finalRes,
            'user' => $user,
            'monthYear' => $monthName . ', ' . $year,
            'wallet_type' => WalletTypeEntity::model()->findByPk($type)->wallet_type
        ]);
    }

    /**
     * Manages data for server side dataTables.
     */
    public function actionServerdata()
    {

        $requestData = $_REQUEST;

//		$model= new wallet();
        $array_cols = Yii::app()->db->schema->getTable('wallet')->columns;
        $array = array();
        $i = 0;
        foreach ($array_cols as $key => $col) {
            $array[$i] = $col->name;
            $i++;
        }
        /*$columns = array(
            0 => 'user_id',
            1 => 'full_name'
        );*/
        $columns = $array;

        $sql = "SELECT * from wallet where 1=1";
//		$data = Yii::app()->db->createCommand($sql)->queryAll();
//		$totalFiltered = count($data);

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( wallet_id LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach ($array_cols as $key => $col) {
                if ($col->name != 'id') {
                    $sql .= " OR " . $col->name . " LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql .= ")";
//			$sql.=" OR employee_age LIKE '" . $requestData['search']['value'] . "%')";

        }

        $j = 0;
        // getting records as per search parameters
        foreach ($columns as $key => $column) {
            if ($requestData['columns'][$key]['search']['value'] != '') {   //name
                if ($column == 'user_id') {
                    $sql .= " AND  user_id = " . $requestData['columns'][$key]['search']['value'] . " ";
                } else if ($column == 'denomination_id') {
                    $sql .= " AND $column  =" . $requestData['columns'][$key]['search']['value'] . "";
                } else {
                    $sql .= " AND $column LIKE '%" . $requestData['columns'][$key]['search']['value'] . "%' ";
                }
            }
            $j++;
        }

        $count_sql = str_replace("*", "count(*) as columncount", $sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;

        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";
        // echo $sql;die;
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i = 1;

        foreach ($result as $key => $row) {
            $nestedData = array();

            $username_sql = "select full_name from user_info where user_id = " . "'$row[user_id]'";
            $user_names = Yii::app()->db->createCommand($username_sql)->queryAll();

            $wallettypesql = "select wallet_type from wallet_type_entity where wallet_type_id =" . "'$row[wallet_type_id]'";
            $wallettypenames = Yii::app()->db->createCommand($wallettypesql)->queryAll();

            $denominationsql = "select denomination_type from denomination where denomination_id=" . "'$row[denomination_id]'";
            $denominations = Yii::app()->db->createCommand($denominationsql)->queryAll();

            $row['user_id'] = $user_names[0]['full_name'];
            $row['wallet_type_id'] = $wallettypenames[0]['wallet_type'];
            $row['denomination_id'] = $denominations[0]['denomination_type'];

            switch ($row['transaction_status']) {
                case 0 :
                    $row['transaction_status'] = "<span align='center' class='label label-table label-warning'>Pending</span>";
                    break;
                case 1:
                    $row['transaction_status'] = "<span align='center' class='label label-table label-primary'>On Hold</span>";
                    break;
                case 2:
                    $row['transaction_status'] = "<span align='center' class='label label-table label-success'>Approved</span>";
                    break;
                case 3:
                    $row['transaction_status'] = "<span align='center' class='label label-table label-danger'>Rejected</span>";
                    break;
                default:
                    break;
            }

            switch ($row['transaction_type']) {
                case 0:
                    $row['transaction_type'] = 'Credit';
                    break;
                case 1:
                    $row['transaction_type'] = 'Debit';
                    break;
                default:
                    break;
            }

            foreach ($array_cols as $key => $col) {
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


    /**
     * Manages data for server side datatables.
     */
    public function actionPendingdata()
    {

        $requestData = $_REQUEST;

        $array_cols = Yii::app()->db->schema->getTable('wallet')->columns;
        $array = array();
        $i = 0;
        foreach ($array_cols as $key => $col) {
            $array[$i] = $col->name;
            $i++;
        }
        $columns = $array;

        $sql = "SELECT  * from wallet where transaction_status=0";

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( wallet_id LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach ($array_cols as $key => $col) {
                if ($col->name != 'id') {
                    $sql .= " OR " . $col->name . " LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql .= ")";
//			$sql.=" OR employee_age LIKE '" . $requestData['search']['value'] . "%')";

        }

        $j = 0;
        // getting records as per search parameters
        foreach ($columns as $key => $column) {
            if ($requestData['columns'][$key]['search']['value'] != '') {   //name
                if ($column == 'user_id') {
                    $sql .= " AND  user_id = " . $requestData['columns'][$key]['search']['value'] . " ";
                } else {
                    $sql .= " AND $column LIKE '%" . $requestData['columns'][$key]['search']['value'] . "%' ";
                }
            }
            $j++;
        }

        $count_sql = str_replace("*", "count(*) as columncount", $sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;

        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";

        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i = 1;

        foreach ($result as $key => $row) {
            $nestedData = array();
            $nestedData[] = $row['wallet_id'];

            $username_sql = "select full_name from user_info where user_id = " . "'$row[user_id]'";
            $user_names = Yii::app()->db->createCommand($username_sql)->queryAll();

            $wallettypesql = "select wallet_type from wallet_type_entity where wallet_type_id =" . "'$row[wallet_type_id]'";
            $wallettypenames = Yii::app()->db->createCommand($wallettypesql)->queryAll();

            $denominationsql = "select denomination_type from denomination where denomination_id=" . "'$row[denomination_id]'";
            $denominations = Yii::app()->db->createCommand($denominationsql)->queryAll();

            $row['user_id'] = $user_names[0]['full_name'];
            $row['wallet_type_id'] = $wallettypenames[0]['wallet_type'];
            $row['denomination_id'] = $denominations[0]['denomination_type'];

            switch ($row['transaction_status']) {
                case 0 :
                    $row['transaction_status'] = "Pending";
                    break;
                case 1:
                    $row['transaction_status'] = "On Hold";
                    break;
                case 2:
                    $row['transaction_status'] = "Approved";
                    break;
                case 3:
                    $row['transaction_status'] = "Rejected";
                    break;
                default:
                    break;
            }

            switch ($row['transaction_type']) {
                case 0:
                    $row['transaction_type'] = 'Credit';
                    break;
                case 1:
                    $row['transaction_type'] = 'Debit';
                    break;
                default:
                    break;
            }


            foreach ($array_cols as $key => $col) {
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

    /*
     * Payout Index action
     * */
    public function actionPayoutIndex(){
        $systemId = Yii::app()->params['SystemUserId'];
        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type' => 'User']);
        $creditTransactionType = Yii::app()->params['CreditTransactionType'];
        $debitTransactionType = Yii::app()->params['DebitTransactionType'];
        $payOutReference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Payout']);
        //For Affiliate earnings commission scheme
        $affiliate_reference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Affiliate Commission']);
        //For Cashback earnings commission scheme
        $agents = AgentInfo::model()->findAll();
        $required_references = [];
        foreach ($agents as $agent){
            array_push($required_references, $agent->wallet_reference_id);
        }
        array_push($required_references, $affiliate_reference->reference_id);
        $minimumPayoutValue = Yii::app()->params['MinimumPayoutValue'];

        $earningsArr = Yii::app()->db->createCommand()
            //->select('sum(amount) as amt, Month(created_at) as mnt, Year(created_at) as yr')
            ->select('sum(case when transaction_type = 0 then amount else 0 end) as credit_amt, sum(case when transaction_type = 1 then amount else 0 end) as debit_amt, Month(created_at) as mnt, Year(created_at) as yr')
            ->from('wallet w')
            ->where('wallet_type_id=:wTId', [':wTId' => $userWallet->wallet_type_id])
            ->andWhere('w.user_id!=:uId', [':uId' => $systemId])
            ->andWhere(['in','reference_id',$required_references])
            ->group('Month(created_at), Year(created_at)')
            ->order('Year(created_at) asc, Month(created_at) asc')
            ->queryAll();

        $currentTotalBalance = Yii::app()->db->createCommand()
            ->select('sum(case when transaction_type = 0 then amount else 0 end) as credit_amt, sum(case when transaction_type = 1 then amount else 0 end) as debit_amt')
            ->from('wallet w')
            ->where('wallet_type_id=:wTId', [':wTId' => $userWallet->wallet_type_id])
            ->andWhere('w.user_id!=:uId', [':uId' => $systemId])
            ->queryRow();
        $currentBalanceTotal = $currentTotalBalance['credit_amt'] - $currentTotalBalance['debit_amt'];

        $payoutEligibleQuery = "select sum(credit_amt) as final_credit_amt, sum(debit_amt) as final_debit_amt, sum(credit_amt) - sum(debit_amt) as diff,
                                  mnt, yr from (select user_id, Month(created_at) as mnt, Year(created_at) as yr, 
                                  sum(case when transaction_type = 0 then amount else 0 end) as credit_amt, 
                                  sum(case when transaction_type = 1 then amount else 0 end) as debit_amt from wallet 
                                  where `wallet_type_id` = 1 and user_id != 1 group by user_id, Month(created_at), Year(created_at) 
                                  having credit_amt-debit_amt >= 50) as tmpTable group by mnt, yr order by yr, mnt asc;";
        $payoutEligibleArr = Yii::app()->db->createCommand($payoutEligibleQuery)->queryAll();
        $payoutEligibleMonthYearFormat = [];
        foreach ($payoutEligibleArr as $value){
            $payoutEligibleMonthYearFormat[$value['yr']][$value['mnt']] = $value['diff'];
        }

        $payoutEligibleBalanceQuery = "select sum(credit_amt) as final_credit_amt, sum(debit_amt) as final_debit_amt, sum(credit_amt) - sum(debit_amt) as diff
                                          from (select user_id, sum(case when transaction_type = 0 then amount else 0 end) as credit_amt, 
                                          sum(case when transaction_type = 1 then amount else 0 end) as debit_amt from wallet 
                                          where `wallet_type_id` = 1 and user_id != 1 group by user_id
                                          having credit_amt-debit_amt >= 50) as tmpTable;";
        $payoutEligibleBalanceRow = Yii::app()->db->createCommand($payoutEligibleBalanceQuery)->queryRow();
        $payoutEligibleBalanceTotal = $payoutEligibleBalanceRow['diff'];

        $finalEarningsArr = [];
        $cumulative_commissions = 0;
        foreach ($earningsArr as $value){
            $temp = [];
            $commission_value = $value['credit_amt'] - $value['debit_amt'];
            $temp['commissions'] = $commission_value;
            $cumulative_commissions += $commission_value;
            $temp['cumulative_commissions'] = $cumulative_commissions;
            $temp['balance'] = $payoutEligibleBalanceTotal;
            if(isset($payoutEligibleMonthYearFormat[$value['yr']][$value['mnt']])){
                $mayBePayoutValue = $payoutEligibleMonthYearFormat[$value['yr']][$value['mnt']];
            } else {
                $mayBePayoutValue = 0;
            }
            if($mayBePayoutValue >= $minimumPayoutValue && $payoutEligibleBalanceTotal >= $mayBePayoutValue){
                $payoutValue = $mayBePayoutValue;
            } elseif($mayBePayoutValue >= $minimumPayoutValue && $payoutEligibleBalanceTotal < $mayBePayoutValue){
                if($currentBalanceTotal >= $minimumPayoutValue){
                    $payoutValue = $payoutEligibleBalanceTotal;
                } else {
                    $payoutValue = 0;
                }
            } else {
                $payoutValue = 0;
            }
            $temp['payout_value'] = $payoutValue;
            $temp['mnt'] = $value['mnt'];
            $temp['yr'] = $value['yr'];
            $finalEarningsArr[$value['yr']][$value['mnt']] = $temp;
        }

        /*//Reserve wallet earnings group by month and year
        $reserve_wallet_entity = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>Yii::app()->params['ReserveWallet']]);
        $reserveEarningsQueryArr = Yii::app()->db->createCommand()
            ->select('sum(amount) as amt, reference_num')
            ->from('wallet w')
            ->where('wallet_type_id=:wTId', [':wTId' => $reserve_wallet_entity->wallet_type_id])
            ->andWhere('w.user_id!=:uId', [':uId' => $systemId])
            ->andWhere('w.transaction_type=:tt',[':tt'=>$creditTransactionType])
            ->group('reference_num')
            ->queryAll();
        $reserveEarningArr = [];
        foreach ($reserveEarningsQueryArr as $value){
            $dateString = $value['reference_num'];
            $mnt = date('n',strtotime($dateString));
            $yr = date('Y',strtotime($dateString));
            $reserveEarningArr[$yr][$mnt] = $value['amt'];
        }

        //Query to find sum of amount of users who are
        //eligible for payout
        $eligibleQuery = "select sum(amt) as am, mnt, yr from 
                          (select user_id, Month(created_at) as mnt, Year(created_at) as yr, sum(amount) as amt from wallet 
                          where wallet_type_id = 1 and transaction_type = 0 and user_id != 1 group by user_id, Month(created_at),
                           Year(created_at) having sum(amount) >= 50) as tmpTable 
                           group by mnt, yr";
        $eligibleArr = Yii::app()->db->createCommand($eligibleQuery)->queryAll();

        //Converting the array to year-month format
        $requiredEligibleArr = [];
        foreach ($eligibleArr as $item){
            if(!isset($requiredEligibleArr[$item['yr']]))
                $requiredEligibleArr[$item['yr']] = [];
            $requiredEligibleArr[$item['yr']][$item['mnt']] = $item['am'];
        }

        //Calculate payout details
        $payOutArr =  Yii::app()->db->createCommand()
            ->select('sum(amount) as amt, Month(reference_num) as mnt, Year(reference_num) as yr')
            ->from('wallet w')
            ->where('wallet_type_id=:wTId', [':wTId' => $userWallet->wallet_type_id])
            ->andWhere('w.user_id!=:uId', [':uId' => $systemId])
            ->andWhere('w.transaction_type=:tt',[':tt'=>$debitTransactionType])
            ->andWhere('w.reference_id=:rId',[':rId'=>$payOutReference->reference_id])
            ->group('Month(reference_num), Year(reference_num)')
            ->queryAll();

        $requiredPayoutArr = [];
        foreach ($payOutArr as $item){
            if(!isset($requiredPayoutArr[$item['yr']]))
                $requiredPayoutArr[$item['yr']] = [];
            $requiredPayoutArr[$item['yr']][$item['mnt']] = $item['amt'];
        }*/

        $this->render('payout_index',[
            'earningsArr' => $finalEarningsArr,
            //'eligibleAmtArr' => $requiredEligibleArr,
            //'requiredPayoutArr' => $requiredPayoutArr,
            //'reserveEarningArr' => $reserveEarningArr
        ]);
    }

    public function actionPayoutByMonth(){
        $systemId = Yii::app()->params['SystemUserId'];
        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type' => 'User']);
        $creditTransactionType = Yii::app()->params['CreditTransactionType'];
        $debitTransactionType = Yii::app()->params['DebitTransactionType'];
        $walletRejectedTransactionStatus = Yii::app()->params['WalletRejectedTransactionStatus'];
        $payoutReference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Payout']);

        if(isset($_GET['month']) && isset($_GET['year'])){
            $month = $_GET['month'];
            $year = $_GET['year'];
        } else {
            $month = date('m');
            $year = date('Y');
        }
        $month_end_date = $year.'-'.$month.'-31';

        $userBalanceArr = Yii::app()->db->createCommand()
            ->select('w.user_id, sum(case when transaction_type=0 then amount else 0 end) as credit_amt,
            sum(case when transaction_type=1 then amount else 0 end) as debit_amt')
            ->from('wallet w')
            ->where('wallet_type_id=:wTId', [':wTId' => $userWallet->wallet_type_id])
            ->andWhere('w.user_id!=:uId', [':uId' => $systemId])
            ->andWhere('w.transaction_status!=:ts', [':ts' => $walletRejectedTransactionStatus])
            ->group('user_id')
            ->queryAll();

        $requiredUserBalanceArr = [];
        foreach ($userBalanceArr as $item){
            $cbal = round($item['credit_amt'], 5) - round($item['debit_amt'], 5);
            $requiredUserBalanceArr[$item['user_id']] = $cbal;
        }


        //Monthly user earnings
        $currentMonthEar = Yii::app()->db->createCommand()
            ->select('w.user_id, full_name, email, sum(case when transaction_type=0 then amount else 0 end) as credit_amt,
            sum(case when transaction_type=1 then amount else 0 end) as debit_amt, vat_number')
            ->from('wallet w')
            ->where('wallet_type_id=:wTId', [':wTId' => $userWallet->wallet_type_id])
            ->andWhere('w.user_id!=:uId', [':uId' => $systemId])
            ->andWhere('w.transaction_status!=:ts', [':ts' => $walletRejectedTransactionStatus])
            //->andWhere('w.transaction_type=:tt',[':tt'=>$creditTransactionType])
            ->andWhere('Month(w.created_at)=:mcat',[':mcat'=>$month])
            ->andWhere('Year(w.created_at)=:ycat',[':ycat'=>$year])
            ->join('user_info ui', 'w.user_id = ui.user_id')
            ->group('user_id')
            ->queryAll();

        //Cumulative month earnings
        $cumulativeMonthEar = Yii::app()->db->createCommand()
            ->select('w.user_id, sum(case when transaction_type=0 then amount else 0 end) as credit_amt,
            sum(case when transaction_type=1 then amount else 0 end) as debit_amt, vat_number')
            ->from('wallet w')
            ->where('wallet_type_id=:wTId', [':wTId' => $userWallet->wallet_type_id])
            ->andWhere('w.user_id!=:uId', [':uId' => $systemId])
            ->andWhere('w.transaction_status!=:ts', [':ts' => $walletRejectedTransactionStatus])
            //->andWhere('w.transaction_type=:tt',[':tt'=>$creditTransactionType])
            ->andWhere('date(w.created_at)<=:mcat',[':mcat'=>$month_end_date])
            //->andWhere('Year(w.created_at)<=:ycat',[':ycat'=>$year])
            ->join('user_info ui', 'w.user_id = ui.user_id')
            ->group('user_id')
            ->queryAll();
        $cumulativeEarningsArr = [];
        foreach ($cumulativeMonthEar as $item){
            $cbal = round($item['credit_amt'], 5) - round($item['debit_amt'] ,5);
            //$cbal = $item['credit_amt'];
            $cumulativeEarningsArr[$item['user_id']] = $cbal;
        }

        $payoutEligibleQuery = "select sum(credit_amt) as final_credit_amt, sum(debit_amt) as final_debit_amt, sum(credit_amt) - sum(debit_amt) as diff,
                                  mnt, yr from (select user_id, Month(created_at) as mnt, Year(created_at) as yr, 
                                  sum(case when transaction_type = 0 then amount else 0 end) as credit_amt, 
                                  sum(case when transaction_type = 1 then amount else 0 end) as debit_amt from wallet 
                                  where `wallet_type_id` = 1 and user_id != 1 group by user_id, Month(created_at), Year(created_at) 
                                  having credit_amt-debit_amt >= 50) as tmpTable group by mnt, yr order by yr, mnt asc;";
        $payoutEligibleArr = Yii::app()->db->createCommand($payoutEligibleQuery)->queryAll();

        /*
         * Total Paid Out w.r.t user
         * */
        $paidOutWRTUser = Yii::app()->db->createCommand()
            ->select('w.user_id, sum(amount) as debit_amt, max(date(reference_num))')
            ->from('wallet w')
            ->where('wallet_type_id=:wTId', [':wTId' => $userWallet->wallet_type_id])
            ->andWhere('w.user_id!=:uId', [':uId' => $systemId])
            ->andWhere('w.transaction_status!=:ts', [':ts' => $walletRejectedTransactionStatus])
            ->andWhere('w.transaction_type=:tt',[':tt'=>$debitTransactionType])
            ->andWhere('w.reference_id=:rId',[':rId'=>$payoutReference->reference_id])
            ->group('user_id')
            ->queryAll();
        $paidOutWRTUserArr = [];
        foreach ($paidOutWRTUser as $item){
            $paidOutWRTUserArr[$item['user_id']] = $item['debit_amt'];
        }

        /*
        * Paid out Amount w.r.t month
         * Here, month and year in criteria is wrong...kindly update when used.
        * */
        /*$paidOutWRTMonth = Yii::app()->db->createCommand()
            ->select('w.user_id, sum(amount) as debit_amt')
            ->from('wallet w')
            ->where('wallet_type_id=:wTId', [':wTId' => $userWallet->wallet_type_id])
            ->andWhere('w.user_id!=:uId', [':uId' => $systemId])
            ->andWhere('w.transaction_status!=:ts', [':ts' => $walletRejectedTransactionStatus])
            ->andWhere('w.transaction_type=:tt',[':tt'=>$debitTransactionType])
            ->andWhere('w.reference_id=:rId',[':rId'=>$payoutReference->reference_id])
            ->andWhere('Month(w.reference_num)<=:mcat',[':mcat'=>$month])
            ->andWhere('Year(w.reference_num)<=:ycat',[':ycat'=>$year])
            ->group('user_id')
            ->queryAll();
        $paidOutWRTMonthArr = [];
        foreach ($paidOutWRTMonth as $item){
            $paidOutWRTMonthArr[$item['user_id']] = $item['debit_amt'];
        }*/

        $earningWRTTimeArr = [];
        foreach ($cumulativeEarningsArr as $id=>$val){
            if(isset($paidOutWRTUserArr[$id])){
                $earningWRTTimeArr[$id] = $val - $paidOutWRTUserArr[$id];
                if($earningWRTTimeArr[$id] < 0){
                    $earningWRTTimeArr[$id] = 0;
                }
            }
            else
                $earningWRTTimeArr[$id] = $val;
        }

        $this->render('payout_details_by_month',[
            'userBalance' => $requiredUserBalanceArr,
            'currentMonthEar' => $currentMonthEar,
            'cumulativeEarnings' => $cumulativeEarningsArr,
            //'paidOutWRTMonth' => $paidOutWRTMonthArr,
            'earningWRTTimeArr' => $earningWRTTimeArr,
            'month'=>$month,
            'year'=>$year
        ]);
    }

    /*
     * Payout Action
     * */
    public function actionPayout()
    {
        setlocale(LC_MONETARY, 'nl_NL.UTF-8');
        $systemId = Yii::app()->params['SystemUserId'];
        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type' => 'User']);

        //Transaction status 3 is for rejected transactions
        $userBalanceArr = Yii::app()->db->createCommand()
            ->select('w.user_id, full_name, email, sum(case when transaction_type=0 then amount else 0 end) as credit_amt,
         sum(case when transaction_type=1 then amount else 0 end) as debit_amt, vat_number')
            ->from('wallet w')
            ->where('wallet_type_id=:wTId', [':wTId' => $userWallet->wallet_type_id])
            ->andWhere('w.user_id!=:uId', [':uId' => $systemId])
            ->andWhere('w.transaction_status!=:ts', [':ts' => 3])
            ->join('user_info ui', 'w.user_id = ui.user_id')
            ->group('user_id')
            ->queryAll();
        $userBalance = [];
        foreach ($userBalanceArr as $item) {
            $temp = [];
            $temp['user_id'] = $item['user_id'];
            $temp['full_name'] = $item['full_name'];
            $temp['email'] = $item['email'];
            $temp['amt'] = $item['credit_amt'] - $item['debit_amt'];
            $temp['vat_number'] = $item['vat_number'];
            array_push($userBalance, $temp);
        }

        $this->render('payout', [
            'userBalance' => $userBalance
        ]);
    }

    /*
     * User specific payout details
     * */
    public function actionUserPayout()
    {
        setlocale(LC_MONETARY, 'nl_NL.UTF-8');
        $userWallet = WalletTypeEntity::model()->findByAttributes(['wallet_type' => 'User']);
        $payOutReference = WalletMetaEntity::model()->findByAttributes(['reference_key' => 'Payout']);
        $creditTransactionType = Yii::app()->params['CreditTransactionType'];
        $debitTransactionType = Yii::app()->params['DebitTransactionType'];

        if(isset($_GET['month']) && isset($_GET['year'])){
            $month = $_GET['month'];
            $year = $_GET['year'];
        } else {
            $month = date('m');
            $year = date('Y');
        }

        $userId = $_GET['user_id'];
        $user = UserInfo::model()->findByPk($userId);
        $earningsArr = [];
        $paidOutArr = [];
        $currentBalance = 0;
        if (isset($user->user_id)) {

            //Earnings
            /*$earningsArr = Yii::app()->db->createCommand()
                ->select('user_id, sum(amount) as amt, Month(created_at) as mnt, Year(created_at) as yr')
                ->from('wallet w')
                ->where('wallet_type_id=:wTId', [':wTId' => $userWallet->wallet_type_id])
                ->andWhere('w.user_id=:uId', [':uId' => $userId])
                ->andWhere('w.transaction_type=:tt',[':tt'=>$creditTransactionType])
                ->group('user_id, Month(created_at), Year(created_at)')
                ->order('Year(created_at) asc, Month(created_at) asc')
                ->queryAll();*/

            //Payout Details
            $paidOutArr = Yii::app()->db->createCommand()
                ->select('*')
                ->from('wallet w')
                ->where('wallet_type_id=:wTId', [':wTId' => $userWallet->wallet_type_id])
                ->andWhere('w.user_id=:uId', [':uId' => $userId])
                ->andWhere('w.transaction_type=:tt',[':tt'=>$debitTransactionType])
                ->andWhere('w.reference_id=:wrk',[':wrk'=>$payOutReference->reference_id])
                ->queryAll();

            //Current Balance
            $currentBalance = WalletHelper::getUserWalletEarnings($userId);
        }
        $this->render('payout_details',[
            'user' => $user,
            'earningsArr' => $earningsArr,
            'paidOurArr' => $paidOutArr,
            'currentBalance' => $currentBalance,
            'month' => $month,
            'year' => $year
        ]);
    }

    //Post a payout transaction
    public function actionPostPayoutTransaction(){
        $trans_comment = $_POST['trans_comment'];
        $trans_status = $_POST['trans_status'];
        $trans_amount = $_POST['trans_amount'];
        $user_id = $_POST['user_id'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $user_wallet = WalletTypeEntity::model()->findByAttributes(['wallet_type'=>'User']);
        $debitTransactionType = Yii::app()->params['DebitTransactionType'];
        $payOutReference = WalletMetaEntity::model()->findByAttributes(['reference_key' => 'Payout']);

        $payoutReference = $year."-".$month."-28 00:00:01";
        if(!empty($trans_comment) && ($trans_status != '') && !empty($trans_amount) && !empty($user_id)){
            //WalletHelper::addToWallet($user->user_id, $backupScheme->wallet_type_id, 1, 4, $account->matrix_id, $deduction_comment, 1, 2, 1, $withdrawAmount, date('Y-m-d H:i:s'));
            WalletHelper::addToWallet($user_id, $user_wallet->wallet_type_id, $debitTransactionType, $payOutReference->reference_id,
                $payoutReference, $trans_comment, 1, $trans_status, 1, $trans_amount, date('Y-m-d H:i:s'));

            //Transfer Charge
            //Transfer charge will be deducted by company itself by paying them lesser amount...This will not be reflected in the system.
            /*$payOutTransferCharge = Yii::app()->params['PayoutTransferCharges'];
            WalletHelper::addToWallet($user_id, $user_wallet->wallet_type_id, $debitTransactionType, $payOutReference->reference_id,
                $payoutReference, "Payout Transfer Charges", 1, 2, 1, $payOutTransferCharge, date('Y-m-d H:i:s'));*/
            print true;
        } else {
            print false;
        }
    }
}
