<?php
class CbmuseraccountController extends CController {
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

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

    /*
     * Index action
     * */
    public function actionIndex(){
        $userAccounts = CbmUserAccounts::model()->findAll();
        $tableName = CbmUserAccounts::model()->tableSchema->name;
        $this->render('index',[
            'userAccounts' => $userAccounts,
            'tableName' => $tableName
        ]);
    }

    /**
     * Manages data for server side data tables.
     */
    public function actionServerdata(){

        $requestData = $_REQUEST;
        $array_cols = Yii::app()->db->schema->getTable('cbm_user_accounts')->columns;
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

        $sql = "SELECT  * from cbm_user_accounts where 1=1";

        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( order_info_id LIKE '%" . $requestData['search']['value'] . "%' ";
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
                $sql.=" AND $column LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
            }
            $j++;
        }//die;

//		echo $sql;die;

        $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($count_sql)->queryAll();
        $totalData = $data[0]['columncount'];
        $totalFiltered = $totalData;


        $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";

//        echo $sql;die;
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i=1;

        foreach ($result as $key => $row)
        {
            $nestedData = array();
            //$nestedData[] = $row['user_account_id'];
            $row['balance'] = round($row['balance'],2);
            $row['equity'] = round($row['equity'],2);
            $row['email_address'] = $row['email_address'] . '<br> <p class="text-muted">Beneficiary: ' .$row['beneficiary'].'</p>';

            $row['matrix_id'] = ucfirst(str_replace('_',' ',MatrixMetaTable::model()->findByPk($row['matrix_id'])->table_name));

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

    /*
     * Email Settings action
     * */
    public function actionSettings(){
        $unPlacedNodesData = Yii::app()->db->createCommand()
            ->select('count(*) as totalAccounts, beneficiary')
            ->from('cbm_user_accounts')
            ->where('isNull(matrix_node_num)')
            ->group('beneficiary')
            ->queryAll();

        $result = array();
        foreach ($unPlacedNodesData as $datum){
            $temp = array();
            $lastSent = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cbm_logs')
                ->where(['like','log',['%License reminder email sent to%','%'.$datum['beneficiary'].'%']])
                ->order('created_date desc')
                ->queryRow();
            $temp['pendingAccounts'] = $datum['totalAccounts'];
            $temp['email'] = $datum['beneficiary'];
            if(isset($lastSent['id'])){
                $temp['lastSent'] = 'Last Email was sent on '.date('jS F Y',strtotime($lastSent['created_date'])).'.';
            } else {
                $temp['lastSent'] = "No email sent till today.";
            }
            $user = UserInfo::model()->findByAttributes(['email'=>$datum['beneficiary']]);
            if(isset($user->user_id)){
                $temp['userId'] = $user->user_id;
                $temp['mailUrl'] = Yii::app()->createUrl('admin/Cbmuseraccount/sendMail').'/'.$user->user_id;
            }
            else {
                $temp['mailUrl'] = "No User Found";
                $temp['userId'] = 0;
            }
            array_push($result, $temp);
        }

        $this->render('settings',[
            'result' => $result
        ]);
    }

    /*
     * Mail Sending Function
     * to specific email
     * */
    public function actionSendMail(){
        $userId = $_GET['id'];
        if(isset($userId)){
            $user = UserInfo::model()->findByPk($userId);
            $unPlacedNodesData = Yii::app()->db->createCommand()
                ->select('count(*) as totalAccounts')
                ->from('cbm_user_accounts')
                ->where('isNull(matrix_node_num)')
                ->andWhere('beneficiary=:email',[':email'=>$user->email])
                ->queryRow();
            if($unPlacedNodesData['totalAccounts'] > 0){
                OrderHelper::buyExtraLicense($user->email, $user->full_name, $unPlacedNodesData['totalAccounts']);

                //Add Logs
                $cbmLogs = new CbmLogs();
                $cbmLogs->date = date('Y-m-d H:i:s');
                $cbmLogs->log = 'License reminder email sent to '.$user->email;
                $cbmLogs->total_accounts = $unPlacedNodesData['totalAccounts'];
                $cbmLogs->created_date = date('Y-m-d H:i:s');
                $cbmLogs->save(false);
                echo 'Last Email was sent on '.date('jS F Y',strtotime(date('Y-m-d H:i:s')));
            }
        } else {
            echo "Inavlid Email ID";
        }
    }

    /*
     * Send Mail to all Emails
     * */
    public function sendMailToAll(){
        $unPlacedNodesData = Yii::app()->db->createCommand()
            ->select('count(*) as totalAccounts, beneficiary')
            ->from('cbm_user_accounts')
            ->where('isNull(matrix_node_num)')
            ->group('beneficiary')
            ->queryAll();
        foreach ($unPlacedNodesData as $datum){
            $user = UserInfo::model()->findByAttributes(['email'=>$datum['beneficiary']]);
            OrderHelper::buyExtraLicense($user->email, $user->full_name, $unPlacedNodesData['totalAccounts']);
        }
    }
}