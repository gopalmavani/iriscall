<?php

class CompressionController extends CController {

    public function accessRules()
    {
        return [
            [
                'allow',
                'actions' => ['updatemt4'],
                'users' => ['*'],
            ],
            ['deny', // deny all users
                'users' => ['*'],
            ],
        ];
    }

    //Remove system leaf nodes
    public function actionRemoveNullNodes(){
        try{
            $systemNode = UserInfo::model()->findByPk(Yii::app()->params['SystemUserId']);
            $fiboNullNodes = Yii::app()->db->createCommand()
                ->select('*')
                ->from('fifty_euro_matrix')
                ->where('email=:em', [':em'=>$systemNode->email])
                ->andWhere('lchild is null')
                ->andWhere('rchild is null')
                ->order('id desc')
                ->queryAll();

            $removedNodes = [];
            $notRemovedNodes = [];
            $consideredNodes = [];
            $scriptLog = '';

            $fiboNullNodesCount = count($fiboNullNodes);
            while($fiboNullNodesCount > 0){
                foreach ($fiboNullNodes as $nullNode){
                    $cbmUserAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$nullNode['cbm_account_num']]);
                    if(isset($cbmUserAccount->user_account_num)){
                        //Remove from CBM User Accounts tables
                        Yii::app()->db->createCommand()
                            ->delete('cbm_user_accounts',
                                'user_account_num=:uac', [':uac'=>$nullNode['cbm_account_num']]);

                        //Find parent node
                        $leftParent = FiftyEuroMatrix::model()->findByAttributes(['lchild'=>$nullNode['id']]);
                        if(isset($leftParent->id)){
                            //Update parent of node in fifty_euro_matrix to null
                            Yii::app()->db->createCommand()
                                ->update('fifty_euro_matrix',
                                    [
                                        'lchild' => null
                                    ],
                                    'id=:id', [':id'=>$leftParent->id]);
                        } else {
                            $rightParent = FiftyEuroMatrix::model()->findByAttributes(['rchild'=>$nullNode['id']]);
                            if(isset($rightParent->id)){
                                //Update parent of node in fifty_euro_matrix to null
                                Yii::app()->db->createCommand()
                                    ->update('fifty_euro_matrix',
                                        [
                                            'rchild' => null
                                        ],
                                        'id=:id', [':id'=>$rightParent->id]);
                            } else {
                                $scriptLog .= 'Parent Node not found for' . $nullNode['cbm_account_num'].'\n';
                            }
                        }

                        //Remove node from fifty_euro_matrix table
                        Yii::app()->db->createCommand()
                            ->delete('fifty_euro_matrix',
                                'cbm_account_num=:uac', [':uac'=>$nullNode['cbm_account_num']]);

                        array_push($removedNodes, $nullNode['cbm_account_num']);
                        $scriptLog .= $nullNode['cbm_account_num'].' node removed from Fifty Euro Matrix \n';
                    } else {
                        array_push($notRemovedNodes, $nullNode['cbm_account_num']);
                        $scriptLog .= $nullNode['cbm_account_num'].' node is not present in CBM User Accounts \n';
                    }
                    array_push($consideredNodes, $nullNode['cbm_account_num']);
                }

                $fiboNullNodes = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('fifty_euro_matrix')
                    ->where('email=:em', [':em'=>$systemNode->email])
                    ->andWhere('lchild is null')
                    ->andWhere('rchild is null')
                    ->andWhere(['not in', 'cbm_account_num', $consideredNodes])
                    ->order('id desc')
                    ->queryAll();
                $fiboNullNodesCount = count($fiboNullNodes);
            }

            //Logs
            $cbmActivityRef = CbmActivityReference::model()->findByAttributes(['reference'=>'Remove Null Nodes']);
            $removedNodeString = implode(',', $removedNodes);
            $notRemovedNodesString = implode(',', $notRemovedNodes);
            $cbmActivity = new CbmActivity();
            $cbmActivity->reference_id = $cbmActivityRef->id;
            $cbmActivity->reference_data_1 = $removedNodeString;
            $cbmActivity->reference_data_2 = $notRemovedNodesString;
            $cbmActivity->comment = $scriptLog;
            $cbmActivity->save(false);
        } catch(Exception $e){

            //Logs
            $cbmActivityRef = CbmActivityReference::model()->findByAttributes(['reference'=>'Remove Null Nodes']);
            $cbmActivity = new CbmActivity();
            $cbmActivity->reference_id = $cbmActivityRef->id;
            $cbmActivity->reference_data_1 = $e->getMessage();
            $cbmActivity->comment = $e->getTraceAsString();
            $cbmActivity->save(false);
        }
        
    }

    //Remove system nodes having child tree only on left side
    //and move the child tree one step ahead
    public function actionRemoveOnlyLeftChildNodes(){
        $systemNode = UserInfo::model()->findByPk(Yii::app()->params['SystemUserId']);

        //Only Left child system nodes
        $fiboOnlyLeftChildSystemNode = Yii::app()->db->createCommand()
            ->select('*')
            ->from('fifty_euro_matrix')
            ->where('email=:em', [':em'=>$systemNode->email])
            ->andWhere('lchild is not null')
            ->andWhere('rchild is null')
            ->order('id desc')
            ->queryRow();

        $removedNodes = [];
        $notRemovedNodes = [];
        $consideredNodes = [];
        $scriptLog = '';

        while(isset($fiboOnlyLeftChildSystemNode['lchild'])){
            $cbmUserAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$fiboOnlyLeftChildSystemNode['cbm_account_num']]);
            if(isset($cbmUserAccount->user_account_num)){
                $childNode = FiftyEuroMatrix::model()->findByPk($fiboOnlyLeftChildSystemNode['lchild']);
                if(isset($childNode->id)){
                    //find parent node. check for left first
                    $parentNode = FiftyEuroMatrix::model()->findByAttributes(['lchild'=>$fiboOnlyLeftChildSystemNode['id']]);
                    if(!isset($parentNode->id)){
                        //Checking for right parent
                        $parentNode = FiftyEuroMatrix::model()->findByAttributes(['rchild'=>$fiboOnlyLeftChildSystemNode['id']]);
                        $selfChildType = 'rchild';
                    } else {
                        $selfChildType = 'lchild';
                    }

                    if(isset($parentNode->id)){
                        $this->removeOneSideNodes($fiboOnlyLeftChildSystemNode['cbm_account_num'], $childNode->id, $parentNode->id, $selfChildType);
                        array_push($removedNodes, $fiboOnlyLeftChildSystemNode['cbm_account_num']);
                        $scriptLog .= $fiboOnlyLeftChildSystemNode['cbm_account_num'].' node removed from Fifty Euro Matrix \n';
                    } else {
                        array_push($notRemovedNodes, $fiboOnlyLeftChildSystemNode['cbm_account_num']);
                        $scriptLog .= 'Parent for '.$fiboOnlyLeftChildSystemNode['cbm_account_num'].' node not found in Fifty Euro Matrix \n';
                    }
                } else {
                    print('<pre>');
                    print("It's a bug bro");
                    print_r($fiboOnlyLeftChildSystemNode);
                    print_r($cbmUserAccount);
                    exit;
                }
            } else {
                array_push($notRemovedNodes, $fiboOnlyLeftChildSystemNode['cbm_account_num']);
                $scriptLog .= $fiboOnlyLeftChildSystemNode['cbm_account_num'].' node not present in CBM User Accounts \n';
            }
            array_push($consideredNodes, $fiboOnlyLeftChildSystemNode['cbm_account_num']);

            /*print('<pre>');
            print_r($removedNodes);
            print $scriptLog;
            exit;*/

            $fiboOnlyLeftChildSystemNode = Yii::app()->db->createCommand()
                ->select('*')
                ->from('fifty_euro_matrix')
                ->where('email=:em', [':em'=>$systemNode->email])
                ->andWhere('lchild is not null')
                ->andWhere('rchild is null')
                ->andWhere(['not in', 'cbm_account_num', $consideredNodes])
                ->order('id desc')
                ->queryRow();
        }

        //Logs
        $cbmActivityRef = CbmActivityReference::model()->findByAttributes(['reference'=>'Shift up left tree']);
        $removedNodeString = implode(',', $removedNodes);
        $notRemovedNodesString = implode(',', $notRemovedNodes);
        $cbmActivity = new CbmActivity();
        $cbmActivity->reference_id = $cbmActivityRef->id;
        $cbmActivity->reference_data_1 = $removedNodeString;
        $cbmActivity->reference_data_2 = $notRemovedNodesString;
        $cbmActivity->comment = $scriptLog;
        $cbmActivity->save(false);
    }

    //Remove system nodes having child tree only on right side
    //and move the child tree one step ahead
    public function actionRemoveOnlyRightChildNodes(){
        $systemNode = UserInfo::model()->findByPk(Yii::app()->params['SystemUserId']);

        //Only Left child system nodes
        $fiboOnlyRightChildSystemNode = Yii::app()->db->createCommand()
            ->select('*')
            ->from('fifty_euro_matrix')
            ->where('email=:em', [':em'=>$systemNode->email])
            ->andWhere('rchild is not null')
            ->andWhere('lchild is null')
            ->order('id desc')
            ->queryRow();

        $removedNodes = [];
        $notRemovedNodes = [];
        $consideredNodes = [];
        $scriptLog = '';

        while(isset($fiboOnlyRightChildSystemNode['rchild'])){
            $cbmUserAccount = CbmUserAccounts::model()->findByAttributes(['user_account_num'=>$fiboOnlyRightChildSystemNode['cbm_account_num']]);
            if(isset($cbmUserAccount->user_account_num)){
                $childNode = FiftyEuroMatrix::model()->findByPk($fiboOnlyRightChildSystemNode['rchild']);
                if(isset($childNode->id)){
                    //find parent node. check for left first
                    $parentNode = FiftyEuroMatrix::model()->findByAttributes(['lchild'=>$fiboOnlyRightChildSystemNode['id']]);
                    if(!isset($parentNode->id)){
                        //Checking for right parent
                        $parentNode = FiftyEuroMatrix::model()->findByAttributes(['rchild'=>$fiboOnlyRightChildSystemNode['id']]);
                        $selfChildType = 'rchild';
                    } else {
                        $selfChildType = 'lchild';
                    }

                    if(isset($parentNode->id)){
                        $this->removeOneSideNodes($fiboOnlyRightChildSystemNode['cbm_account_num'], $childNode->id, $parentNode->id, $selfChildType);
                        array_push($removedNodes, $fiboOnlyRightChildSystemNode['cbm_account_num']);
                        $scriptLog .= $fiboOnlyRightChildSystemNode['cbm_account_num'].' node removed from Fifty Euro Matrix \n';
                    } else {
                        array_push($notRemovedNodes, $fiboOnlyRightChildSystemNode['cbm_account_num']);
                        $scriptLog .= 'Parent for '.$fiboOnlyRightChildSystemNode['cbm_account_num'].' node not found in Fifty Euro Matrix \n';
                    }
                } else {
                    print('<pre>');
                    print("It's a bug bro");
                    print_r($fiboOnlyRightChildSystemNode);
                    print_r($cbmUserAccount);
                    exit;
                }
            } else {
                array_push($notRemovedNodes, $fiboOnlyRightChildSystemNode['cbm_account_num']);
                $scriptLog .= $fiboOnlyRightChildSystemNode['cbm_account_num'].' node not present in CBM User Accounts \n';
            }
            array_push($consideredNodes, $fiboOnlyRightChildSystemNode['cbm_account_num']);


            $fiboOnlyRightChildSystemNode = Yii::app()->db->createCommand()
                ->select('*')
                ->from('fifty_euro_matrix')
                ->where('email=:em', [':em'=>$systemNode->email])
                ->andWhere('rchild is not null')
                ->andWhere('lchild is null')
                ->andWhere(['not in', 'cbm_account_num', $consideredNodes])
                ->order('id desc')
                ->queryRow();
        }

        //Logs
        $cbmActivityRef = CbmActivityReference::model()->findByAttributes(['reference'=>'Shift up right tree']);
        $removedNodeString = implode(',', $removedNodes);
        $notRemovedNodesString = implode(',', $notRemovedNodes);
        $cbmActivity = new CbmActivity();
        $cbmActivity->reference_id = $cbmActivityRef->id;
        $cbmActivity->reference_data_1 = $removedNodeString;
        $cbmActivity->reference_data_2 = $notRemovedNodesString;
        $cbmActivity->comment = $scriptLog;
        $cbmActivity->save(false);
    }

    public function removeOneSideNodes($cbmAccountNum, $childNodeId, $parentNodeId, $childType){
        //Remove from CBM User Accounts tables
        Yii::app()->db->createCommand()
            ->delete('cbm_user_accounts',
                'user_account_num=:uac', [':uac'=>$cbmAccountNum]);

        //Update child of parent node
        Yii::app()->db->createCommand()
            ->update('fifty_euro_matrix',
                [
                    $childType => $childNodeId
                ],
                'id=:id', [':id'=>$parentNodeId]);

        //Remove node from fifty_euro_matrix table
        Yii::app()->db->createCommand()
            ->delete('fifty_euro_matrix',
                'cbm_account_num=:uac', [':uac'=>$cbmAccountNum]);
    }
}