<?php

class AccountController extends CController
{

    protected function beforeAction($action)
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('home/login'));
        }
        return parent::beforeAction($action);

    }
    /**
     * Type one nodes = 1000 euro
     * Type two nodes = 250 euro
     */
    public function actionIndex()
    {
        setlocale(LC_MONETARY, 'nl_NL.UTF-8');
        $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->id]);

        $typeOneAgents = Yii::app()->db->createCommand()
            ->select('agent_number')
            ->from('agent_info')
            ->where('minimum_deposit=:md', [':md'=>1000])
            ->queryColumn();

        $typeOneNodes = 0;
        $typeTwoNodes = 0;
        $cbmUserAccounts = CbmUserAccounts::model()->findAllByAttributes(['email_address' => $user->email]);
        $node_specific_response = [];
        foreach ($cbmUserAccounts as $cbmAccount) {
            $result = [];

            //To calculate total nodes present in 12 levels
            $nodeLevelCounter = [];
            $levels = 12;
            for($i=1; $i<=$levels; $i++){
                $nodeLevelCounter[$i] = 0;
            }
            //By default, for level 1, counter is 1
            $nodeLevelCounter[1] = 1;
            $presentNode = MMCMatrix::model()->findByAttributes(['cbm_account_num'=>$cbmAccount->user_account_num]);
            if(isset($presentNode->id)){
                $nodeLevelCounter = $this->nodeCalc($presentNode->id, 1, $nodeLevelCounter);
                $result['activated'] = 1;
                $result['nodeNumber'] = $presentNode->id;
            } else {
                $result['activated'] = 0;
            }
            if(in_array($cbmAccount->agent_num, $typeOneAgents)){
                $result['associatedProduct'] = 'NexiMax';
                $result['type'] = 1;
                $typeOneNodes++;
            } else {
                $result['associatedProduct'] = 'UnityMax';
                $result['type'] = 2;
                $typeTwoNodes++;
            }
            $result['totalNodes'] = array_sum($nodeLevelCounter);
            $result['accountNumber'] = $cbmAccount->user_account_num;

            $node_specific_response[$cbmAccount->user_account_num] = $result;
        }
        $this->render('index', [
            'node_specific_response' => $node_specific_response,
            'typeOneNodes' => $typeOneNodes,
            'typeTwoNodes' => $typeTwoNodes,
        ]);
    }

    /*
     * To calculate node level count
     * */
    protected function nodeCalc($nodeId, $level, $nodeLevelCounter){
        if($level < 13){
            $node = MMCMatrix::model()->findByPk($nodeId);
            if(!is_null($node->lchild)){
                if($level < 12){
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
     * Radial tree generator
     * */
    public function actionGenerateradialtree(){
        $matrixData = [];
        if(isset($_POST['accountNum'])){
            $radialTreeAccountNum = $_POST['accountNum'];
            $matrixNode = MMCMatrix::model()->findByAttributes(['cbm_account_num'=>$radialTreeAccountNum]);
            if(isset($matrixNode->id)){
                $matrixData = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('mmc_matrix')
                    ->where('id>=:i', [':i'=>$matrixNode->id])
                    ->order('id, created_at asc')
                    ->queryAll();
            }
        }
        echo  json_encode($matrixData);
    }

    /*
     * Matrix viewer
     * */
    public function actionMatrixviewer(){
        $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->id]);
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
            $matrixNode = MMCMatrix::model()->findByAttributes(['cbm_account_num'=>$radialTreeAccountNum]);
            $matrixData = Yii::app()->db->createCommand()
                ->select('*')
                ->from('mmc_matrix')
                ->where('id>=:i', [':i'=>$matrixNode->id])
                ->order('id, created_at asc')
                ->queryAll();

            $presentNode = MMCMatrix::model()->findByAttributes(['cbm_account_num'=>$radialTreeAccountNum]);
            $nodeLevelCounter = $this->nodeCalc($presentNode->id, 1, $nodeLevelCounter);
        } else {
            $matrixData = [];
            $nodeLevelCounter[1] = 0;
        }
        $this->render('matrix-viewer',[
            'matrixData' => $matrixData,
            'nodeLevelCounter' => $nodeLevelCounter,
            'matrixSchemeArray' => $matrixSchemeArray,
            'matrixPercentageArray' => $matrixPercentageArray,
            'allNodes' => $allNodes,
            'radialTreeAccountNum' => $radialTreeAccountNum
        ]);
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
}