<?php
class MatrixHelper extends CApplicationComponent {

    /*
     * Add Cluster to Matrix
     * */
    public static function addClusterToMatrix($accountNumArray, $parentAccountNum, $email, $matrix_id){

        $user = UserInfo::model()->findByAttributes(['email'=>$email]);
        $tmp = array_fill(0, count($accountNumArray), $user->user_id);
        $matrix = MatrixMetaTable::model()->findByPk($matrix_id);

        $isParentPresent = Yii::app()->db->createCommand()
            ->select('*')
            ->from($matrix->table_name)
            ->where('cbm_account_num=:cNum',[':cNum'=>$parentAccountNum])
            ->queryRow();

        $response = json_decode(MatrixHelper::fiboApi(array(
            "action" => "add",
            "parent" => $parentAccountNum,
            "count" => 1,
            "accounts" => $tmp,
            "cluster" => true,
            "email" => $user->email,
            "table_name" => $matrix->table_name
        )),true);

        if($response['result'] == 1){

            foreach ($accountNumArray as $i=>$item){

                //Update parent id in the matrix table
                $res = Yii::app()->db->createCommand()
                    ->update($matrix->table_name,array(
                        'parent'=>$isParentPresent['user_id'],
                        'cbm_account_num'=>$item
                    ),'id=:id',array(':id'=>$response['data'][$i]));

                $cbmAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$item]);
                $cbmAccount->matrix_node_num = $response['data'][$i];
                $cbmAccount->added_to_matrix_at = date('Y-m-d H:i:s');
                $cbmAccount->save(false);
            }
            return "Cluster has been successfully added to Matrix";
        } else {
            return false;
        }
    }

    /*
     * Add node to Matrix
     * */
    public static function addToMatrix($accountNum,$parentAccountNum){

        //To check that the node is not a system node
        $systemUser = UserInfo::model()->findByPk(Yii::app()->params['SystemUserId']);
        $tempAccount = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cbm_user_accounts')
            ->where('user_account_num=:uan',[':uan'=>$accountNum])
            ->andWhere('email_address!=:email',[':email'=>$systemUser->email])
            ->queryRow();
        $account = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$accountNum,'email_address'=>$tempAccount['email_address']]);
        $matrix = MatrixMetaTable::model()->findByPk($account->matrix_id);
        $user = UserInfo::model()->findByAttributes(['email'=>$account->email_address]);

        $isParentPresent = Yii::app()->db->createCommand()
            ->select('*')
            ->from($matrix->table_name)
            ->where('cbm_account_num=:cNum',[':cNum'=>$parentAccountNum])
            ->queryRow();
        if(!isset($isParentPresent['user_id'])) {
            //echo "Parent not present for ".$user->email." for account number ".$accountNum."<br>";
            $logs = new CbmLogs();
            $logs->status = 1;
            $logs->created_date = date('Y-m-d H:i:s');
            $logs->total_accounts = 0;
            $logs->log = "Parent not present for account number ".$accountNum;
            $logs->save(false); // saving logs
            return false;
        } else {
            //$parent = UserInfo::model()->findByPk($parentId);

            $tmp = array();
            array_push($tmp,$user->user_id);

            $response = json_decode(MatrixHelper::fiboApi(array(
                "action" => "add",
                "parent" => $parentAccountNum,
                "count" => 1,
                "accounts" => $tmp,
                "cluster" => false,
                "email" => $user->email,
                "table_name" => $matrix->table_name
            )),true);

            if($response['result'] == 1){

                //Update parent id in the matrix table
                $res = Yii::app()->db->createCommand()
                    ->update($matrix->table_name,array(
                        'parent'=>$isParentPresent['user_id'],
                        'cbm_account_num'=>$accountNum
                    ),'id=:id',array(':id'=>$response['data'][0]));

                //Get ID from matrix table as node number
                $res = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from($matrix->table_name)
                    ->where('user_id=:id',array(':id'=>$user->user_id))
                    ->andWhere('id=:i',[':i'=>$response['data'][0]])
                    ->queryRow();

                $account->matrix_node_num = $res['id'];
                $account->added_to_matrix_at = date('Y-m-d H:i:s');
                $account->update(false);

                return "User has been successfully added to Matrix";
            } else {
                return false;
            }
        }
        //return "Due to some technical reasons, we were not able to add Node to Matrix. Please contact development team";
    }

    public static function fiboApi($request){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => Yii::app()->request->getBaseUrl(true) .'/fibo/api.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 500,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($request),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
            $logs = new CbmLogs();
            $logs->status = 2;
            $logs->created_date = date('Y-m-d H:i:s');
            $logs->total_accounts = 0;
            $logs->log = $err;
            $logs->save(false); // saving logs
        }
        return $response;
    }

    public static function getMatrixSponsor($userAccountNum, $matrixId){
        $systemUser = UserInfo::model()->findByPk(Yii::app()->params['SystemUserId']);
        $userAccount = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cbm_user_accounts')
            ->where('user_account_num=:uan',[':uan'=>$userAccountNum])
            ->andWhere('matrix_id=:mId',[':mId'=>$matrixId])
            ->andwhere('email_address!=:ea',[':ea'=>$systemUser->email])
            ->queryRow();
        $user = UserInfo::model()->findByAttributes(['email'=>$userAccount['email_address']]);
        $parentAccountNum = 0;
        if (isset($user->user_id)) {
            $parentNode = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cbm_user_accounts')
                //->where('login=:lg', [':lg' => $userAccount['login']])
                ->where('email_address=:ea', [':ea' => $userAccount['email_address']])
                ->andWhere('matrix_node_num is not null')
                //->andWhere('cluster_id=:cId',[':cId'=>$clusterId])
                ->order('matrix_node_num asc')
                ->queryRow();
            if (isset($parentNode['user_account_num'])) {
                //$sponsorId = $user->user_id;
                $parentAccountNum = $parentNode['user_account_num'];
            } else {
                if ($user->sponsor_id != 1) {
                    $sponsor = UserInfo::model()->findByPk($user->sponsor_id);
                    $sponsorAccountNum = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('cbm_user_accounts')
                        ->where('email_address=:ea', [':ea' => $sponsor->email])
                        ->andWhere('matrix_node_num is not null')
                        ->order('matrix_node_num asc')
                        ->queryRow();
                    if (isset($sponsorAccountNum['user_account_num'])) {
                        $parentAccountNum = $sponsorAccountNum['user_account_num'];
                    } else {
                        $parentAccountNum = 'C001';
                    }
                } else {
                    $parentAccountNum = 'C001';
                }
                //}
            }
        }
        return $parentAccountNum;
    }

    //Derive a new cluster id
    public static function getNewClusterId($login){
        $cbm_user_account = Yii::app()->db->createCommand()
            ->select('max(cluster_id) as c_id')
            ->from('cbm_user_accounts')
            ->where('login=:lg',[':lg'=>$login])
            ->queryRow();

        if(is_null($cbm_user_account['c_id'])){
            $clusterId = 1;
        } else {
            $clusterId = $cbm_user_account['c_id'] + 1;
        }
        return $clusterId;
    }

    public static function updateParentTrace(){
        $noOfParents = 11;
        $table_name = "mmc_matrix";
        $parents = [];

        $presentNodes = Yii::app()->db->createCommand()
            ->select('node_id')
            ->from('fibo_parent_trace')
            ->queryColumn();
        $notPresentNodes = Yii::app()->db->createCommand()
            ->select('*')
            ->from($table_name)
            ->where(['not in', 'id', $presentNodes])
            ->queryAll();

        foreach ($notPresentNodes as $node) {
            $nodeId = $node['id'];
            echo "Working with nodeId: ".$nodeId."<br>";
            $fibo = Yii::app()->db->createCommand()
                ->from($table_name)
                ->where('id < :node', [':node' => $nodeId])
                ->order('id DESC')
                ->queryAll();
            $childElement = Yii::app()->db->createCommand()
                ->from($table_name)
                ->where('id = :node', [':node' => $nodeId])
                ->queryRow();

            $search = $nodeId;
            $level = 1;
            $parents[] = [
                'node_id' => $nodeId,
                'level' => $level,
                'user_id' => $childElement['user_id'],
                'parent_node_id' => $childElement['id']
            ];
            foreach ($fibo as $f) {
                if ($level <= $noOfParents) {
                    if ($f['lchild'] == $search) {
                        $search = $f['id'];
                        $level++;
                        $parents[] = [
                            'node_id' => $nodeId,
                            'level' => $level,
                            'user_id' => $f['user_id'],
                            'parent_node_id' => $f['id']
                        ];
                    } else if ($f['rchild'] == $search) { // if right child than alternate levels will be empty

                        $search = $f['id'];
                        $level++;
                        $parents[] = [
                            'node_id' => $nodeId,
                            'level' => $level,
                            'user_id' => 1,
                            'parent_node_id' => 1
                        ];
                        if($level <= $noOfParents) {
                            $level++;
                            $parents[] = [
                                'node_id' => $nodeId,
                                'level' => $level,
                                'user_id' => $f['user_id'],
                                'parent_node_id' => $f['id']
                            ];
                        }
                    }
                }
            }
            $level++;
            while($level<=12){
                $parents[] = [
                    'node_id' => $nodeId,
                    'level' => $level,
                    'user_id' => 1,
                    'parent_node_id' => 1
                ];
                $level++;
            }
        }
        WalletHelper::multipleDataInsert('fibo_parent_trace', $parents);
    }

    /*
     * Get Parent Trace directly from DB
     * */
    public static function getParentTraceFromDB($nodeId){
        $parents = Yii::app()->db->createCommand()
            ->select('*')
            ->from('fibo_parent_trace')
            ->where('node_id=:nId', [':nId'=>$nodeId])
            ->queryAll();
        return json_encode($parents);
    }

    /*
     * To get parent Trace as per the CO-OP plan.
     * */
    public static function GetParentTrace($nodeId, $noOfParents, $table_name)
    {
        $fibo = Yii::app()->db->createCommand()
            ->from($table_name)
            ->where('id < :node', [':node' => $nodeId])
            ->order('id DESC')
            ->queryAll();
        $childElement = Yii::app()->db->createCommand()
            ->from($table_name)
            ->where('id = :node', [':node' => $nodeId])
            ->queryRow();

        $search = $nodeId;
        $level = 1;
        $parents = [];
        $parents[] = [
            'level' => $level,
            'user_id' => $childElement['user_id'],
            'node_id' => $childElement['id']
        ];
        foreach ($fibo as $f) {
            if ($level <= $noOfParents) {
                if ($f['lchild'] == $search) {
                    $search = $f['id'];
                    $level++;
                    $parents[] = [
                        'level' => $level,
                        'user_id' => $f['user_id'],
                        'node_id' => $f['id']
                    ];
                } else if ($f['rchild'] == $search) { // if right child than alternate levels will be empty

                    $search = $f['id'];
                    $level++;
                    $parents[] = [
                        'level' => $level,
                        'user_id' => 'No Node',
                        'node_id' => 1
                    ];
                    if($level <= $noOfParents) {
                        $level++;
                        $parents[] = [
                            'level' => $level,
                            'user_id' => $f['user_id'],
                            'node_id' => $f['id']
                        ];
                    }
                }
            }
        }
        $level++;
        while($level<=12){
            $parents[] = [
                'level' => $level,
                'user_id' => 'No Node',
                'node_id' => 1
            ];
            $level++;
        }
        return json_encode($parents);
    }
}