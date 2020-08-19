<?php

class GenealogyController extends Controller
{
	public $layout = 'main';

	public function actionIndex(){
        $userId = Yii::app()->user->getId();
        $user = UserInfo::model()->findByPk($userId);
        $levelOneChilds = UserInfo::model()->findAllByAttributes(['sponsor_id'=>$userId]);

        $finalArr = array();

        $firstTierClients = 0;
        $firstTierLicenses = 0;
        $secondTierClients = 0;
        $secondTierLicenses = 0;
        foreach ($levelOneChilds as $levelOneChild){
            $firstTierClients++;
            $temp = [];
            if($levelOneChild->privacy_disclosure == 0){
                $temp['name'] = $levelOneChild->full_name;
                $temp['email'] = $levelOneChild->email;
            } else {
                $temp['name'] = ServiceHelper::hideStringGenealogy($levelOneChild->user_id);
                $temp['email'] = ServiceHelper::hideEmailGenealogy($levelOneChild->user_id);
            }
            $levelOneUserLicenses = CbmUserLicenses::model()->findByAttributes(['email'=>$levelOneChild->email]);
            if(isset($levelOneUserLicenses->email)){
                $temp['license_count'] = $levelOneUserLicenses->total_licenses;
                $temp['active_license_count'] = $levelOneUserLicenses->total_licenses - $levelOneUserLicenses->available_licenses;
            }
            else {
                $temp['license_count'] = 0;
                $temp['active_license_count'] = 0;
            }
            $firstTierLicenses += $temp['license_count'];

            $levelTwoChilds = UserInfo::model()->findAllByAttributes(['sponsor_id'=>$levelOneChild->user_id]);
            $levelOneClientCount = 0;
            $levelTwo = array();
            foreach ($levelTwoChilds as $levelTwoChild){
                $secondTierClients++;
                $temp2 = [];
                $levelOneClientCount++;
                $temp2['name'] = ServiceHelper::hideStringGenealogy($levelTwoChild->user_id);
                $levelTwoUserLicenses = CbmUserLicenses::model()->findByAttributes(['email'=>$levelTwoChild->email]);
                if(isset($levelTwoUserLicenses->email))
                    $temp2['license_count'] = $levelTwoUserLicenses->total_licenses;
                else
                    $temp2['license_count'] = 0;
                $secondTierLicenses += $temp2['license_count'];
                $countQuery = Yii::app()->db->createCommand()
                    ->select('count(*) as cnt')
                    ->from('user_info')
                    ->where('sponsor_id=:sId',[':sId'=>$levelTwoChild->user_id])
                    ->queryRow();
                $temp2['client_count'] = $countQuery['cnt'];
                array_push($levelTwo, $temp2);
            }
            $temp['inner_level'] = $levelTwo;
            $temp['client_count'] = $levelOneClientCount;
            array_push($finalArr, $temp);
        }

        //Radial Tree development
        if(isset($_GET['accountNum'])){
            $radialTreeAccountNum = $_GET['accountNum'];
            $checkValidity = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cbm_user_accounts')
                ->where('email_address=:ea', [':ea'=>$user->email])
                ->andWhere('user_account_num=:ua', [':ua'=>$radialTreeAccountNum])
                ->queryRow();
            if(!isset($checkValidity['user_account_num'])){
                $radialTreeAccountNum = null;
            }
        } else {
            $accountNum = Yii::app()->db->createCommand()
                ->select('user_account_num')
                ->from('cbm_user_accounts')
                ->where('email_address=:ea', [':ea'=>$user->email])
                ->andWhere('matrix_node_num is not null')
                ->order('added_to_matrix_at, matrix_node_num asc')
                ->queryRow();
            if(isset($accountNum['user_account_num']) && !is_null($accountNum['user_account_num'])){
                $radialTreeAccountNum = $accountNum['user_account_num'];
            } else {
                $radialTreeAccountNum = null;
            }
        }
        $allNodes = Yii::app()->db->createCommand()
            ->select('user_account_num')
            ->from('cbm_user_accounts')
            ->where('email_address=:ea', [':ea'=>$user->email])
            ->andWhere('matrix_node_num is not null')
            ->order('added_to_matrix_at, matrix_node_num asc')
            ->queryColumn();
        $nodeLevelCounter = [];
        $levels = 12;
        for($i=1; $i<=$levels; $i++){
            $nodeLevelCounter[$i] = 0;
        }
        //By default, for level 1, counter is 1
        $nodeLevelCounter[1] = 1;
        $matrixSchemeArray = $this->getMatrixNodesArray();
        $matrixPercentageArray = $this->getMatrixPercentageArray();

        if(!is_null($radialTreeAccountNum)){
            $matrixNode = FiftyEuroMatrix::model()->findByAttributes(['cbm_account_num'=>$radialTreeAccountNum]);
            $matrixData = Yii::app()->db->createCommand()
                ->select('*')
                ->from('fifty_euro_matrix')
                ->where('id>=:i', [':i'=>$matrixNode->id])
                ->order('id, created_at asc')
                ->queryAll();

            $presentNode = FiftyEuroMatrix::model()->findByAttributes(['cbm_account_num'=>$radialTreeAccountNum]);
            $nodeLevelCounter = $this->nodeCalc($presentNode->id, 1, $nodeLevelCounter);
        } else {
            $matrixData = [];
            $nodeLevelCounter[1] = 0;
        }

        $this->render('index',[
            'finalDataArr' => $finalArr,
            'firstTierClients' => $firstTierClients,
            'firstTierLicenses' => $firstTierLicenses,
            'secondTierClients' => $secondTierClients,
            'secondTierLicenses' => $secondTierLicenses,
            'matrixData' => $matrixData,
            'nodeLevelCounter' => $nodeLevelCounter,
            'matrixSchemeArray' => $matrixSchemeArray,
            'matrixPercentageArray' => $matrixPercentageArray,
            'allNodes' => $allNodes,
            'radialTreeAccountNum' => $radialTreeAccountNum
        ]);

    }

    public function actionCalculateNodeChild(){
	    $response = [];
	    try {
	        if(isset($_POST['nodeId'])){
	            $node = FiftyEuroMatrix::model()->findByPk($_POST['nodeId']);
                $nodeLevelCounter = [];
                $levels = 12;
                for($i=1; $i<=$levels; $i++){
                    $nodeLevelCounter[$i] = 0;
                }
                //By default, for level 1, counter is 1
                $nodeLevelCounter[1] = 1;
                $nodeLevelCounter = $this->nodeCalc($node->id, 1, $nodeLevelCounter);
                $response['status'] = 1;
                $response['data'] = $nodeLevelCounter;
            } else {
                $response['status'] = 0;
                $response['message'] = "NodeId is required";
            }
        } catch (Exception $e){
	        $response['status'] = 0;
	        $response['message'] = $e->getMessage();
        }
        echo json_encode($response);
    }

    protected function nodeCalc($nodeId, $level, $nodeLevelCounter){
	    if($level < 13){
            $node = FiftyEuroMatrix::model()->findByPk($nodeId);
            if(!is_null($node->lchild)){
                if($level < 12){
                    //print_r($node);
                    //$level = $level + 1;
                    $nodeLevelCounter[$level + 1]++;
                    //echo "Level: ".$level." Counter value:". $nodeLevelCounter[$level]." <br>";
                    $nodeLevelCounter = $this->nodeCalc($node->lchild, $level+1, $nodeLevelCounter);
                }
            }
            if(!is_null($node->rchild)){
                if($level < 11){
                    //$level = $level + 2;
                    $nodeLevelCounter[$level+2]++;
                    $nodeLevelCounter = $this->nodeCalc($node->rchild, $level+2, $nodeLevelCounter);
                }
            }
        }
        return $nodeLevelCounter;
    }

    /*
     * Get Max nodes that can be filled at fibo
     * */
    protected function getMatrixNodesArray(){
        $arr = [];
        $arr[1] = 1;
        $arr[2] = 1;
        $arr[3] = 2;
        $arr[4] = 3;
        $arr[5] = 5;
        $arr[6] = 8;
        $arr[7] = 13;
        $arr[8] = 21;
        $arr[9] = 34;
        $arr[10] = 55;
        $arr[11] = 89;
        $arr[12] = 144;
        return $arr;
    }

    /*
     * Get Matrix percentage
     * */
    protected function getMatrixPercentageArray(){
        $matrixScheme = MatrixCommissionScheme::model()->findAll();
        $arr = [];
        foreach ($matrixScheme as $value){
            $arr[$value->level] = $value->percentage;
        }
        return $arr;
    }

    public function actionChildDetails()
    {
    	$level = $_POST['level'];

		$userInfo = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
    	// $parentId = $userInfo->sponsor_id;
    	$userId = $userInfo->user_id;
    	
    	$level1Childs = $this->actionGenealogy($userId, $level);
    	$sqlResponseDetails =  Yii::app()->db->createCommand()
            ->select('user_id,full_name,email')
            ->from('user_info')
            ->where(array('in', 'user_id', $level1Childs))
            ->queryAll();
         $no_of_child = count($sqlResponseDetails);
         
         $personallypreferd = 0;
        if(!empty($sqlResponseDetails)){
            $response = '';
        	$response .= "
        	<table class='table color-table muted-table'>
    			<thead>
                    <th >User Id</th>
               		<th>Name</th>
              		<th>Email</th>
	            </thead>
	            <tbody>";
	       	$personallypreferd = count($sqlResponseDetails);
        	foreach ($sqlResponseDetails as $key => $value) {
        		$id = $value['user_id'];
        		$tempUser = UserInfo::model()->findByPk($id);
        		if($level == 1 && $tempUser->privacy_disclosure == 0){
                    $name = $value['full_name'];
                    $email = $value['email'];
                } else {
                    $name = ServiceHelper::hideStringGenealogy($id);
                    $email = ServiceHelper::hideEmailGenealogy($id);
                }
        		
    			$response .= "
    			<tr>
	    			<td>".$id."</td>
	    			<td>".$name."</td>
	    			<td>".$email."</td>
    			</tr>";
    		}
    	$response.="</tbody></table>";	
        }else{
        	$response = "<table class='table color-table muted-table'><tbody>
        		<tr>
	    			<td style='border-top:0px;'></td>
	    			<td style='border-top:0px;'><h4 align='center'>No Child Found</h4></td>
	    			<td style='border-top:0px;'></td>
    			</tr></tbody></table>";
        }

        $result = [
        	'personallypreferd'=> $personallypreferd,
       		'response'=> $response,
        ];
        
        echo json_encode($result);
    }

    public function actionGenealogy($userId,$level){
    	$sponsor = array($userId);
    	$temp = 1;
    	while ($temp <= $level) {
    		$sqlResponse =  Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('user_info')
            ->where(array('in', 'sponsor_id', $sponsor))
            ->queryColumn();

            if(!empty($sqlResponse)){
            	$sponsor = $sqlResponse;
            } else {
            	$sponsor= '';
            	break;
            }	
    		$temp++ ;
    	}
    	return $sponsor;
    }

}


