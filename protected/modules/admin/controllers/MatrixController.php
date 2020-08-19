<?php
class MatrixController extends CController{
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
     * Add MMC nodes to matrix new logic
     * */
    public function actionAddnewmmcnodes(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $fiboNodes = Yii::app()->db->createCommand()
            ->select('*')
            ->from('fibo')
            ->where('accountGroup is not null')
            ->order('id asc')
            ->queryAll();
        $fiboNodesArray = [];
        foreach ($fiboNodes as $fiboNode){
            if(!array_key_exists($fiboNode['email'], $fiboNodesArray)){
                $fiboNodesArray[$fiboNode['email']] = [];
            }
            if(!array_key_exists($fiboNode['accountGroup'], $fiboNodesArray[$fiboNode['email']])){
                $fiboNodesArray[$fiboNode['email']][$fiboNode['accountGroup']] = [];
            }
            array_push($fiboNodesArray[$fiboNode['email']][$fiboNode['accountGroup']], $fiboNode);
        }

        $mmcAccounts = Yii::app()->db->createCommand()
            ->select('f.id as fiboId, mu.mmcAccountNum as acc_number, mu.agentNum as agent, mu.Type as type, ma.login as login, 
                        mu.Balance as acc_balance, mu.Equity as acc_equity, 
                        mu.maxBalance as acc_max_balance, mu.maxEquity as acc_max_equity, ma.email_address as email,
                        mu.accountGroup as acc_group, mu.created_at as created_at')
            ->from('fibo f')
            ->join('mmc_user_accounts mu','mu.fiboNodeNum = f.id')
            ->join('mmc_mt4_accounts ma', 'mu.mmc_MT4_id = ma.mmc_MT4_id')
            ->join('user_info ui', 'ma.email_address = ui.email')
            ->where('f.id!=:fId', [':fId'=>0])
            //->andWhere(['in', 'mu.emailAddress', ['kristofschoefs@gmail.com', 'ria_coemans@hotmail.com']])
            ->order('f.id')
            ->queryAll();
        $mmcAccountsArray = [];
        foreach ($mmcAccounts as $mmcAccount){
            $mmcAccountsArray[$mmcAccount['acc_number']] = $mmcAccount;
        }

        foreach ($fiboNodesArray as $email=>$userNodesGroup){
            foreach ($userNodesGroup as $accountGroup=>$userNodes){
                $accountNumArray = [];
                $oldAccountNumArray = [];
                foreach ($userNodes as $mmcNode){
                    $accountNum = $mmcNode['accountNum'];
                    if(isset($mmcAccountsArray[$accountNum])){
                        $mmcAccount = $mmcAccountsArray[$accountNum];
                        if($mmcAccount['type'] == 'Self Funded'){
                            $type = 'US';
                        } else {
                            $type = 'UP';
                        }
                        $accountSeq = MMCHelper::getMMCAccountNumberSequence($mmcAccount['login']);
                        if(in_array($mmcAccount['agent'], [8915, 2000])){
                            //1:10 nodes logic
                            $multiplier_unit = 10;
                            $deposit_multiplier = 7000;
                        } else {
                            //1:4 nodes logic
                            $multiplier_unit = 4;
                            $deposit_multiplier = 1000;
                        }
                        $accountBalance = $mmcAccount['acc_balance']/$multiplier_unit;
                        $accountEquity = $mmcAccount['acc_equity']/$multiplier_unit;
                        $accountMaxBalance = $mmcAccount['acc_max_balance']/$multiplier_unit;
                        $accountMaxEquity = $mmcAccount['acc_max_equity']/$multiplier_unit;

                        for($i=1; $i<=$multiplier_unit;$i++){
                            $newAccountNum = 'M'.$mmcAccount['agent'].$type.$mmcAccount['login'].($accountSeq+$i);
                            array_push($accountNumArray, $newAccountNum);
                            $oldAccountNumArray[$newAccountNum] = $accountNum;
                            //Add to CBMUserAccounts table
                            MMCHelper::createMMCUserAccount($newAccountNum, $mmcAccount['login'], $accountBalance,
                                $accountEquity, $accountMaxBalance, $accountMaxEquity, $mmcAccount['type'], $mmcAccount['email'],
                                $mmcAccount['email'], $mmcAccount['agent'], 1, $mmcAccount['acc_group'], $mmcAccount['created_at']);
                        }
                    }
                }
                if(isset($accountNumArray[0])){
                    $parentAccountNum = MatrixHelper::getMatrixSponsor($accountNumArray[0], 1);
                    $firstNodeForParent = $mmcAccountsArray[$oldAccountNumArray[$accountNumArray[0]]];
                    if(!isset($parentAccountNum) || is_null($parentAccountNum) || $parentAccountNum=='0'){
                        echo "<br><br>Fibo parent module called for ".$firstNodeForParent['login']. " with old user account ".$firstNodeForParent['acc_number']. ".<br>";
                        //For MMC, check for the parent in fibo table
                        $fiboParent = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('fibo')
                            ->where('lchild=:lchild', [':lchild'=>$firstNodeForParent['fiboId']])
                            ->orWhere('rchild=:rchild', [':rchild'=>$firstNodeForParent['fiboId']])
                            ->queryRow();
                        if(isset($fiboParent['email'])){
                            $sponsorAccountNum = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('cbm_user_accounts')
                                ->where('email_address=:ea', [':ea' => $fiboParent['email']])
                                ->andWhere('matrix_node_num is not null')
                                ->order('matrix_node_num asc')
                                ->queryRow();
                            if (isset($sponsorAccountNum['user_account_num'])) {
                                $parentAccountNum = $sponsorAccountNum['user_account_num'];
                            }
                        }
                        echo "New Parent Account Number: ".$parentAccountNum."<br>";
                    }
                    if($accountGroup == 1){
                        $resp = MatrixHelper::addClusterToMatrix($accountNumArray, $parentAccountNum, $firstNodeForParent['email'], 1);
                        if($resp != false){
                            echo "Accounts for email ". $firstNodeForParent['email'] . " and account group 1 are placed in cluster format.<br>";
                        } else {
                            echo "Issue with Accounts for email ". $firstNodeForParent['email'] . " and account group 1 while placing them in cluster format.<br>";
                        }
                    } else {
                        foreach ($accountNumArray as $value){
                            $resp = MatrixHelper::addToMatrix($value, $parentAccountNum);
                            if($resp != false){
                                echo "Account for email ".$firstNodeForParent['email']." with old account number ".$oldAccountNumArray[$value]. " is now placed with new account number " . $value . " in LToR format. <br>";
                            } else {
                                echo "Issue with Account for email ".$firstNodeForParent['email']." with old account number ".$oldAccountNumArray[$value]. " and new account number " . $value . " while placing in LToR format. <br>";
                            }
                        }
                    }
                }
            }
        }
    }

    //Add To Matrix
    public function actionAddToMatrix(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $cbmAccounts = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cbm_user_accounts')
            ->where('matrix_node_num=:mn',[':mn'=>'AddIT'])
            ->order('created_at asc')
            ->queryAll();
        foreach ($cbmAccounts as $account){
            $user = UserInfo::model()->findByAttributes(['email'=>$account['email_address']]);
            //Below function is deprecated
            $sponsorId = MatrixHelper::getMatrixSponsor($account['user_account_num'], 1);
            echo "<br>Node Placement is going on for ".$user->email." with parent ID ".$sponsorId."<br>";
            $res = MatrixHelper::addToMatrix($account['user_account_num'], $sponsorId);
            echo $account['user_account_num']. ' ('. $user->email .') vaalo '. $res.". <br>";
        }
    }

    public function actionUpdateSponsorWRTSheet(){
        $records = Yii::app()->db->createCommand()
            ->select('*')
            ->from('fifty_euro_placements')
            ->where('user_id is not null')
            ->queryAll();
        foreach ($records as $record){
            $user = UserInfo::model()->findByPk($record['user_id']);
            if(isset($user->user_id)){
                if(is_null($record['sponsor_id'])){
                    if(is_null($user->sponsor_id)){
                        echo "Issue with ".$user->email."<br>";
                    }
                } else {
                    if($user->sponsor_id != $record['sponsor_id']){
                        echo $user->email. " sponsor changed from ".$user->sponsor_id." to ".$record['sponsor_id']."<br>";
                        $user->sponsor_id = $record['sponsor_id'];
                    }

                }
                $user->save(false);
            }
        }
    }

    public function actionAddToFiftyEuroWRTSheet(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $records = Yii::app()->db->createCommand()
            ->select('*')
            ->from('fifty_euro_placements')
            ->where('user_id is not null')
            ->order('id asc')
            ->queryAll();
        foreach ($records as $record){
            if($record['no_of_accounts'] > 0){
                $accountPresent = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('cbm_user_accounts')
                    ->where('email_address=:em',[':em'=>$record['email']])
                    ->queryAll();
                //if(count($accountPresent) >= $record['no_of_accounts']){
                    echo $record['email'] ." is good to go.<br>";
                    foreach ($accountPresent as $item){
                        //Below function is deprecated
                        $sponsorId = MatrixHelper::getMatrixSponsor($item['user_account_num'], 1);
                        if(is_null($sponsorId) || $sponsorId==''){
                            echo "Sponsor ID is null. Please check for ".$record['email'].'<br>';
                        } else {
                            echo "<br>Node Placement is going on for ".$record['email']." with parent ID ".$sponsorId."<br>";
                            $res = MatrixHelper::addToMatrix($item['user_account_num'], $sponsorId);
                            $cbm_account = CbmAccounts::model()->findByPk($item['login']);
                            $cbm_account->available_licenses -= 1;
                            $cbm_account->save(false);
                        }
                    }
                /*} else {
                    echo "For ".$record['email']." sheet has ".$record['no_of_accounts'].', while system has '.count($accountPresent).'<br>';
                }*/
            }
        }

        $cbm_user_accounts = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cbm_user_accounts')
            ->where('matrix_node_num is null')
            ->order('created_at asc')
            ->queryAll();
        foreach ($cbm_user_accounts as $account){
            $cbm_account = CbmAccounts::model()->findByPk($account['login']);
            $user = UserInfo::model()->findByAttributes(['email'=>$account['email_address']]);
            //Below function is deprecated
            $sponsorId = MatrixHelper::getMatrixSponsor($account['user_account_num'], 1);
            if($cbm_account->available_licenses > 0){
                echo "<br>Node Placement is going on for in remaining section ".$account['email_address']." with parent ID ".$sponsorId."<br>";
                $res = MatrixHelper::addToMatrix($account['user_account_num'], $sponsorId);

                $cbm_account->available_licenses -= 1;
                $cbm_account->save(false);
            }
        }
    }

    public function actionMMCMatrix(){

        $TableID = CylTables::model()->findByAttributes(['table_name' => MMCMatrix::model()->tableSchema->name]);
        $model = new MMCMatrix('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MMCMatrix']))
            $model->attributes = $_GET['MMCMatrix'];
        $alldata = MMCMatrix::model()->findAll();

        $this->render('mmc_matrix', array(
            'TableID' => $TableID,
            'model' => $model,
            'alldata' => $alldata,
        ));
    }

    public function actionServerdata(){
        $requestData = $_REQUEST;
        $model = new MMCMatrix();
        $primary_key = $model->tableSchema->primaryKey;
        $array_cols = Yii::app()->db->schema->getTable(MMCMatrix::model()->tableSchema->name)->columns;
        $array_cols1 =  Yii::app()->db->schema->getTable(UserInfo::model()->tableSchema->name)->columns;
        $array_colms['uname'] = $array_cols1['full_name'];
        $array_colms['parent'] = $array_cols1['full_name'];
        $array_colms['lname'] = 'lname';
        $array_colms['rname'] = 'rname';

        $array = array();
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }
       

        $array[$i] = $array_colms['uname']->name;
        $i++;
        $array[$i] = $array_colms['parent']->name;
        $i++;
        $array[$i] = $array_colms['lname'];
        $i++;
        $array[$i] = $array_colms['rname'];
        $i++;
        $array[$i] = '8_level_tree';
        $i++;
        $array[$i] = '12_level_tree';

        $columns = $array;

        $sql = "SELECT a.*,b.full_name as `uname`, c.full_name as `parent`,d.cbm_account_num as `lname` ,e.cbm_account_num as `rname` FROM mmc_matrix a INNER JOIN user_info b ON a.user_id = b.user_id INNER JOIN user_info c ON a.parent = c.user_id LEFT JOIN mmc_matrix d ON a.lchild = d.id LEFT JOIN mmc_matrix e ON a.rchild = e.id where 1=1 ";

        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( $primary_key LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != $primary_key)
                {
                    $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql.=")";
        }

        $j = 0;
        
        // getting records as per search parameters
        foreach($columns as $key=>$column){
           // print_r($key.' - '.$column);
            if( !empty($requestData['columns'][$key]['search']['value']) ){
                if($key == 8){
                     $sql.=" AND c.full_name LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }elseif($key == 9){
                    $sql.=" AND d.cbm_account_num LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }elseif($key == 10){
                    // echo "hi";die;
                    $sql.=" AND e.cbm_account_num LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }else{
                    if($column == 'full_name'){
                         $sql.=" AND b.".$column." LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                    }else{
                    $sql.=" AND a.".$column." LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                    }
                }
            }
            $j++;
        }
       
        // $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        // $totalData = $data[0]['columncount'];
        $totalData = count($data);
        $totalFiltered = $totalData;

        $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";

        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i=1;

        foreach ($result as $key => $row)
        {
            $nestedData = array();
            $nestedData[] = $row['id'];
            foreach($array_cols as  $key=>$col){
                $nestedData[] = $row["$col->name"];
            }
            $nestedData[] = $row['uname'];
            $nestedData[] = $row['parent'];
            // $nestedData[8] = date('Y-m-d',strtotime($row['created_at']));
            $nestedData[] = $row['lname'];
            $nestedData[] = $row['rname'];
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


    public function actionFiftyEuroMatrix(){

        $TableID = CylTables::model()->findByAttributes(['table_name' => FiftyEuroMatrix::model()->tableSchema->name]);
        $model = new FiftyEuroMatrix('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['FiftyEuroMatrix']))
            $model->attributes = $_GET['FiftyEuroMatrix'];
        $alldata = FiftyEuroMatrix::model()->findAll();

        
        $this->render('fifty_euro_matrix', array(
            'TableID' => $TableID,
            'model' => $model,
            'alldata' => $alldata,
        ));
    }

    public function actionServerdata_fifty(){
        $requestData = $_REQUEST;
        $model = new FiftyEuroMatrix();
        $primary_key = $model->tableSchema->primaryKey;
        $array_cols = Yii::app()->db->schema->getTable(FiftyEuroMatrix::model()->tableSchema->name)->columns;
        $array_cols1 =  Yii::app()->db->schema->getTable(UserInfo::model()->tableSchema->name)->columns;
        $array = array();
        $array_colms['uname'] = $array_cols1['full_name'];
        $array_colms['parent'] = $array_cols1['full_name'];
        $array_colms['lname'] = 'lname';
        $array_colms['rname'] = 'rname';
        $array_colms['created_date'] = 'created_date';
        // print_r($array_colms);die;
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }
        $array[$i] = $array_colms['uname']->name;
        $i++;
        $array[$i] = $array_colms['parent']->name;
        $i++;
        $array[$i] = $array_colms['lname'];
        $i++;
        $array[$i] = $array_colms['rname'];
        $i++;
        $array[$i] = $array_colms['created_date'];
        $i++;
        $array[$i] = '8_level_tree';
        $i++;
        $array[$i] = '12_level_tree';
        $columns = $array;

        $sql = "SELECT a.*,b.full_name as `uname`, c.full_name as `parent`,d.cbm_account_num as `lname`, d.email as `leftEmail`, e.cbm_account_num as `rname`, e.email as `rightEmail` FROM fifty_euro_matrix a INNER JOIN user_info b ON a.user_id = b.user_id INNER JOIN user_info c ON a.parent = c.user_id LEFT JOIN fifty_euro_matrix d ON a.lchild = d.id LEFT JOIN fifty_euro_matrix e ON a.rchild = e.id where 1=1 ";


        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( $primary_key LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != $primary_key)
                {
                    $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql.=")";
        }

        $j = 0;
        // getting records as per search parameters
        foreach($columns as $key=>$column){
//           echo $key;
            if( !empty($requestData['columns'][$key]['search']['value']) ){   //name
                if($key == 9){
                    $sql.=" AND c.".$column." LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }elseif($key == 10){
                    $sql.=" AND d.cbm_account_num LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }elseif($key == 11){
                    $sql.=" AND e.cbm_account_num LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }elseif($key == 12){
                    $sql .= " AND cast(a.created_at as date) between '$requestData[min]' and '$requestData[max]'";
                }
                else{
                    if($column == 'created_at' && $requestData['min'] != '' && $requestData['max'] != ''){
                        $sql .= " AND cast(a.created_at as date) between '$requestData[min]' and '$requestData[max]'";
                    }elseif($column == 'full_name'){
                         $sql.=" AND b.".$column." LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                    }else{
                        $sql.=" AND a.".$column." LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                    }
                }
            }
            $j++;
        }
        
        // $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        // $totalData = $data[0]['columncount'];
        $totalData = count($data);
        $totalFiltered = $totalData;

        //for sorting related code.
        if($requestData['order'][0]['column'] == 9){
            $sql.=" ORDER BY c.full_name   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
            $requestData['length'] . "   ";
        }else{
            if($columns[$requestData['order'][0]['column']] == 'full_name'){
                $sql.=" ORDER BY  b.full_name   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
                $requestData['length'] . "   ";
            }elseif($columns[$requestData['order'][0]['column']] == 'created_date'){
                 $sql.=" ORDER BY a.created_at  " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
                $requestData['length'] . "   ";
            }else{
                $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
                $requestData['length'] . "   ";
            }
        }
        
       
        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i=1;
        
        foreach ($result as $key => $row)
        {   
           
            $nestedData = array();
//             $nestedData[] = $row[$primary_key];
            $userAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$row['cbm_account_num']]);
            $userAccountNum = $row['cbm_account_num'];
            $row['created_date'] = $row['created_at'];
           
            if(isset($userAccount->type))
                $row['cbm_account_num'] = $row['cbm_account_num'].'<p class="text-muted" style="margin-bottom: 0">'.$userAccount->type.'</p>';
            foreach($array_cols as  $key=>$col){
                $nestedData[] = $row["$col->name"];

            }
            $nestedData[] = $row['uname'].'<br><p class="text-muted">'.$row['email'].'</p>';
            $nestedData[] = $row['parent'];
            
            $row['created_date'] = date('Y-m-d',strtotime($row['created_at']));
            $leftEmail = UserInfo::model()->findByAttributes(['email'=>$row['leftEmail']]);
            if(!empty($leftEmail)){
                $lemail = $leftEmail->full_name;
            }else{
                $lemail = '';
            }
            $nestedData[] = $row['lname'].'<p class="text-muted" style="margin-bottom: 0">'.$row['leftEmail'].'</p>'.'<p class="text-muted" style="margin-bottom: 0">'.$lemail.'</p>';

            $rightEmail = UserInfo::model()->findByAttributes(['email'=>$row['rightEmail']]);
            if(!empty($rightEmail)){
                $remail = $rightEmail->full_name;
            }else{
                $remail = '';
            }
            $nestedData[] = $row['rname'].'<p class="text-muted" style="margin-bottom: 0">'.$row['rightEmail'].'</p>'.'<p class="text-muted" style="margin-bottom: 0">'.$remail.'</p>';
            $nestedData[] = $row['created_date'];
            if(!empty($userAccountNum)){
                $nestedData[] = "<a href='".Yii::app()->createurl('admin/matrix/tree')."?account_num=".$userAccountNum."&table_name=fifty_euro_matrix&level=8' target='_blank' <i class='fa fa-eye'></i></a>";
                $nestedData[] = "<a href='".Yii::app()->createurl('admin/matrix/tree')."?account_num=".$userAccountNum."&table_name=fifty_euro_matrix&level=12' target='_blank' <i class='fa fa-eye'></i></a>";
                $nestedData[] = "<a href='".Yii::app()->createurl('admin/matrix/radialFibo')."?account_num=".$userAccountNum."&table_name=fifty_euro_matrix&level=12' target='_blank' <i class='fa fa-eye'></i></a>";
                $nestedData[] = "<a href='".Yii::app()->createurl('admin/matrix/hierarchicalFibo')."?account_num=".$userAccountNum."&table_name=fifty_euro_matrix&level=12' target='_blank' <i class='fa fa-eye'></i></a>";
            } else {
                $nestedData[] = '-';
                $nestedData[] = '-';
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

    public function actionServerdata_mmc(){
        $requestData = $_REQUEST;
        $model = new MMCMatrix();
        $primary_key = $model->tableSchema->primaryKey;
        $array_cols = Yii::app()->db->schema->getTable(MMCMatrix::model()->tableSchema->name)->columns;
        $array_cols1 =  Yii::app()->db->schema->getTable(UserInfo::model()->tableSchema->name)->columns;
        $array = array();
        $array_colms['uname'] = $array_cols1['full_name'];
        $array_colms['parent'] = $array_cols1['full_name'];
        $array_colms['lname'] = 'lname';
        $array_colms['rname'] = 'rname';
        $array_colms['created_date'] = 'created_date';
        // print_r($array_colms);die;
        $i = 0;
        foreach($array_cols as  $key=>$col){
            $array[$i] = $col->name;
            $i++;
        }
        $array[$i] = $array_colms['uname']->name;
        $i++;
        $array[$i] = $array_colms['parent']->name;
        $i++;
        $array[$i] = $array_colms['lname'];
        $i++;
        $array[$i] = $array_colms['rname'];
        $i++;
        $array[$i] = $array_colms['created_date'];
        $i++;
        $array[$i] = '8_level_tree';
        $i++;
        $array[$i] = '12_level_tree';
        $columns = $array;

        $sql = "SELECT a.*,b.full_name as `uname`, c.full_name as `parent`,d.cbm_account_num as `lname`, d.email as `leftEmail`, e.cbm_account_num as `rname`, e.email as `rightEmail` FROM mmc_matrix a INNER JOIN user_info b ON a.user_id = b.user_id INNER JOIN user_info c ON a.parent = c.user_id LEFT JOIN mmc_matrix d ON a.lchild = d.id LEFT JOIN mmc_matrix e ON a.rchild = e.id where 1=1 ";


        if (!empty($requestData['search']['value']))
        {
            $sql.=" AND ( $primary_key LIKE '%" . $requestData['search']['value'] . "%' ";
            foreach($array_cols as  $key=>$col){
                if($col->name != $primary_key)
                {
                    $sql.=" OR ".$col->name." LIKE '%" . $requestData['search']['value'] . "%'";
                }
            }
            $sql.=")";
        }

        $j = 0;
        // getting records as per search parameters
        foreach($columns as $key=>$column){
//           echo $key;
            if( !empty($requestData['columns'][$key]['search']['value']) ){   //name
                if($key == 9){
                    $sql.=" AND c.".$column." LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }elseif($key == 10){
                    $sql.=" AND d.cbm_account_num LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }elseif($key == 11){
                    $sql.=" AND e.cbm_account_num LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                }elseif($key == 12){
                    $sql .= " AND cast(a.created_at as date) between '$requestData[min]' and '$requestData[max]'";
                }
                else{
                    if($column == 'created_at' && $requestData['min'] != '' && $requestData['max'] != ''){
                        $sql .= " AND cast(a.created_at as date) between '$requestData[min]' and '$requestData[max]'";
                    }elseif($column == 'full_name'){
                        $sql.=" AND b.".$column." LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                    }else{
                        $sql.=" AND a.".$column." LIKE '%".$requestData['columns'][$key]['search']['value']."%' ";
                    }
                }
            }
            $j++;
        }

        // $count_sql = str_replace("*","count(*) as columncount",$sql);
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        // $totalData = $data[0]['columncount'];
        $totalData = count($data);
        $totalFiltered = $totalData;

        //for sorting related code.
        if($requestData['order'][0]['column'] == 9){
            $sql.=" ORDER BY c.full_name   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
                $requestData['length'] . "   ";
        }else{
            if($columns[$requestData['order'][0]['column']] == 'full_name'){
                $sql.=" ORDER BY  b.full_name   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
                    $requestData['length'] . "   ";
            }elseif($columns[$requestData['order'][0]['column']] == 'created_date'){
                $sql.=" ORDER BY a.created_at  " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
                    $requestData['length'] . "   ";
            }else{
                $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," .
                    $requestData['length'] . "   ";
            }
        }


        $result = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        $i=1;

        foreach ($result as $key => $row)
        {

            $nestedData = array();
//             $nestedData[] = $row[$primary_key];
            $userAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$row['cbm_account_num']]);
            $userAccountNum = $row['cbm_account_num'];
            $row['created_date'] = $row['created_at'];

            if(isset($userAccount->type))
                $row['cbm_account_num'] = $row['cbm_account_num'].'<p class="text-muted" style="margin-bottom: 0">'.$userAccount->type.'</p>';
            foreach($array_cols as  $key=>$col){
                $nestedData[] = $row["$col->name"];

            }
            $nestedData[] = $row['uname'].'<br><p class="text-muted">'.$row['email'].'</p>';
            $nestedData[] = $row['parent'];

            $row['created_date'] = date('Y-m-d',strtotime($row['created_at']));
            $leftEmail = UserInfo::model()->findByAttributes(['email'=>$row['leftEmail']]);
            if(!empty($leftEmail)){
                $lemail = $leftEmail->full_name;
            }else{
                $lemail = '';
            }
            $nestedData[] = $row['lname'].'<p class="text-muted" style="margin-bottom: 0">'.$row['leftEmail'].'</p>'.'<p class="text-muted" style="margin-bottom: 0">'.$lemail.'</p>';

            $rightEmail = UserInfo::model()->findByAttributes(['email'=>$row['rightEmail']]);
            if(!empty($rightEmail)){
                $remail = $rightEmail->full_name;
            }else{
                $remail = '';
            }
            $nestedData[] = $row['rname'].'<p class="text-muted" style="margin-bottom: 0">'.$row['rightEmail'].'</p>'.'<p class="text-muted" style="margin-bottom: 0">'.$remail.'</p>';
            $nestedData[] = $row['created_date'];
            if(!empty($userAccountNum)){
                $nestedData[] = "<a href='".Yii::app()->createurl('admin/matrix/tree')."?account_num=".$userAccountNum."&table_name=mmc_matrix&level=8' target='_blank' <i class='fa fa-eye'></i></a>";
                $nestedData[] = "<a href='".Yii::app()->createurl('admin/matrix/tree')."?account_num=".$userAccountNum."&table_name=mmc_matrix&level=12' target='_blank' <i class='fa fa-eye'></i></a>";
                $nestedData[] = "<a href='".Yii::app()->createurl('admin/matrix/radialFibo')."?account_num=".$userAccountNum."&table_name=mmc_matrix&level=12' target='_blank' <i class='fa fa-eye'></i></a>";
                $nestedData[] = "<a href='".Yii::app()->createurl('admin/matrix/hierarchicalFibo')."?account_num=".$userAccountNum."&table_name=mmc_matrix&level=12' target='_blank' <i class='fa fa-eye'></i></a>";
            } else {
                $nestedData[] = '-';
                $nestedData[] = '-';
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

    public function actionHierarchicalFibo(){
        $level = (isset($_GET['level']) && $_GET['level']!="")?$_GET['level']:8;
        $accountNum = $_GET['account_num'];
        $matrixNode = MMCMatrix::model()->findByAttributes(['cbm_account_num'=>$accountNum]);
        $matrixData = Yii::app()->db->createCommand()
            ->select('*')
            ->from('mmc_matrix')
            //->where('email=:i', [':i'=>'kristofschoefs@gmail.com'])
            ->where('id>=:i', [':i'=>$matrixNode->id])
            ->queryAll();
        $this->render('hierarchicalFibonacci',[
            'matrix_data' => json_encode($matrixData)
        ]);
    }

    public function actionRadialFibo(){
        $level = (isset($_GET['level']) && $_GET['level']!="")?$_GET['level']:8;
        $accountNum = $_GET['account_num'];
        $matrixNode = MMCMatrix::model()->findByAttributes(['cbm_account_num'=>$accountNum]);
        $matrixData = Yii::app()->db->createCommand()
            ->select('*')
            ->from('mmc_matrix')
            //->where('email=:i', [':i'=>'kristofschoefs@gmail.com'])
            ->where('id>=:i', [':i'=>$matrixNode->id])
            ->queryAll();
        $this->render('radialFibonacci',[
            'matrix_data' => json_encode($matrixData)
        ]);
    }

    /*
     * To view the the fibo for a particular account
     * */
    public function actionTree(){
        $this->layout = false;

        $level = (isset($_GET['level']) && $_GET['level']!="")?$_GET['level']:8;
        $table_name = $_GET['table_name'];
        if(isset($_GET['account_num'])){
            $matrix_id_row = Yii::app()->db->createCommand()
                ->select('*')
                ->from($table_name)
                ->where('cbm_account_num=:can',[':can'=>$_GET['account_num']])
                ->queryRow();
            $matrix_id = $matrix_id_row['id'];

            $matrixNodes = Yii::app()->db->createCommand()
                ->select('id, user_id, lchild, rchild')
                ->from($table_name)
                ->where('id >= :id',array(':id'=>$matrix_id))
                ->queryAll();

            $fiboNames = array();
            foreach($matrixNodes as $node){
                if(isset($node['lchild'])){
                    $lUserId = Yii::app()->db->createCommand()
                        ->select('user_id')
                        ->from($table_name)
                        ->where('id=:id',array(':id'=>$node['lchild']))
                        ->queryRow();
                    $lname = UserInfo::model()->findByPk($lUserId['user_id']);
                    $fiboNames[$node['lchild']] = $lname->full_name;
                }

                if(isset($node['rchild'])){
                    $rUserId = Yii::app()->db->createCommand()
                        ->select('user_id')
                        ->from($table_name)
                        ->where('id=:id',array(':id'=>$node['rchild']))
                        ->queryRow();
                    $rname = UserInfo::model()->findByPk($rUserId['user_id']);
                    $fiboNames[$node['rchild']] = $rname->full_name;
                }
            }

            $cbmAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$_GET['account_num']]);
            $firstName = UserInfo::model()->findByAttributes(['email'=>$cbmAccount->email_address])->full_name;
            return $this->render('matrixTree',[
                'fiboData' => CJSON::encode($matrixNodes),
                'table_name' => $table_name,
                'level' => $level,
                'fiboNames' => json_encode($fiboNames),
                'firstName' => $firstName
            ]);
        }
    }

    /**
     * Get fibo data by it's account num
     */
    public function actionNodedata($nodeId,$table_name) {
        $node = Yii::app()->db->createCommand()
            ->select('*')
            ->from($table_name)
            ->where('id=:id',array(':id'=>$nodeId))
            ->queryRow();
        $cbmAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$node['cbm_account_num']]);
        $data = array();
        $data['account_num'] = $cbmAccount->user_account_num;
        $data['balance'] = round($cbmAccount->balance, 2);
        $data['equity'] = round($cbmAccount->equity, 2);
        return $this->renderPartial('nodeData', [
            'data' => $data
        ]);
    }

    public function actionUpdateFiboSystemNodes(){
        $userNodes = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cbm_user_accounts')
            ->where('email_address=:ea',[':ea'=>'system@system.com'])
            ->andWhere('matrix_node_num is not null')
            ->queryAll();

        foreach ($userNodes as $node){
            $fiboNode = FiftyEuroMatrix::model()->findByAttributes(['cbm_account_num'=>$node['user_account_num']]);
            $cbmNode = CbmUserAccounts::model()->findByPk($node['user_account_id']);

            $newNode = CBMAccountHelper::getCBMWithdrawalAccountNumber($cbmNode->user_account_num);
            $fiboNode->cbm_account_num = $newNode;
            $fiboNode->save(false);

            $cbmNode->user_account_num = $newNode;
            $cbmNode->save(false);

            print ($cbmNode->user_account_num." ".$newNode."\n"."<br>");
        }
    }
}