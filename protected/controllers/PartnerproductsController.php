<?php

class PartnerproductsController extends CController
{

    protected function beforeAction($action)
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('home/login'));
        }
        return parent::beforeAction($action);

    }
    /**
     * List of all partner products
     */
    public function actionList()
    {
        //trading product data
        $trading_product_data = Yii::app()->db->createCommand()
            ->select('sku, p.product_id, p.agent, p.name, p.description, p.short_description, p.image, a.asset_manager, 
            a.asset_manager_logo, a.asset_manager_link')
            ->from('product_info p')
            ->join('product_category pc', 'p.product_id=pc.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->join('agent_info a', 'p.agent=a.agent_number')
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['TradingProductCategory']])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->queryAll();

        $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->id]);
        foreach ($trading_product_data as $i=>$value){
            $account = CbmAccounts::model()->findByAttributes(['email_address' => $user->email, 'agent' => $value['agent']]);
            if(isset($account->group))
                $trading_product_data[$i]['group'] = $account->group;
            else
                $trading_product_data[$i]['group'] = null;
        }

        $this->render('list', [
            'products' => $trading_product_data
        ]);
    }

    /*
     * List of all activated partner products
     * */
    public function actionActivated(){
        $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->id]);

        //trading product data
        $trading_product_data = Yii::app()->db->createCommand()
            ->select('p.product_id, p.agent, p.name, p.description, p.short_description, p.image')
            ->from('product_info p')
            ->join('product_category pc', 'p.product_id=pc.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->where('c.category_name=:cName', [':cName'=>Yii::app()->params['TradingProductCategory']])
            ->andWhere('p.is_active=:pIa', [':pIa' => 1])
            ->queryAll();

        $products = [];
        foreach ($trading_product_data as $datum){
            $account = Yii::app()->db->createCommand()
                ->select('c.login, minimum_self_node_balance, cd.profit')
                ->from('cbm_deposit_withdraw cd')
                ->join('cbm_accounts c', 'c.login=cd.login')
                ->join('agent_info a', 'a.agent_number=c.agent')
                ->where('c.email_address=:ea', [':ea'=>$user->email])
                ->andWhere('c.agent=:a', [':a'=>$datum['agent']])
                ->order('cd.close_time asc')
                ->queryRow();
            $temp = [];
            $temp['product_id'] = $datum['product_id'];
            $temp['name'] = $datum['name'];
            $temp['description'] = $datum['description'];
            $temp['short_description'] = $datum['short_description'];
            $temp['image'] = $datum['image'];
            if(isset($account['profit']) && $account['profit']>0){
                $temp['deposited_amount'] = $account['profit'];
                $temp['nodes_generated'] = $account['profit']/$account['minimum_self_node_balance'];
            } else {
                $temp['deposited_amount'] = 0;
                $temp['nodes_generated'] = 0;
            }
            array_push($products, $temp);
        }

        $this->render('activated', [
            'products' => $products
        ]);
    }

    /*
     * Partner products detailed view
     * */
    public function actionView($id){
        //trading product data
        $trading_product_data = Yii::app()->db->createCommand()
            ->select('sku, p.product_id, p.agent, p.name, p.description, p.short_description, p.image, a.asset_manager, 
            a.asset_manager_logo, a.asset_manager_link')
            ->from('product_info p')
            ->join('product_category pc', 'p.product_id=pc.product_id')
            ->join('categories c','c.category_id=pc.category_id')
            ->join('agent_info a', 'p.agent=a.agent_number')
            ->where('p.product_id=:cName', [':cName'=>$id])
            ->queryRow();

        $commissionData = [];
        if($trading_product_data['agent'] == Yii::app()->params['NexiMaxAgent']){
            $schemeId = 1;
            $commissionData['node_value'] = 1.56;
            $commissionData['full_payout'] = 60;
        } else {
            $schemeId = 2;
            $commissionData['node_value'] = 6.75;
            $commissionData['full_payout'] = 300;
        }
        $commissionScheme = CbmCommissionScheme::model()->findAllByAttributes(['scheme_id' => $schemeId]);
        foreach ($commissionScheme as $value){
            $commissionData[$value->scheme]['max_amount'] = $value->max_amount;
            $commissionData[$value->scheme]['max_earnings'] = $value->max_earnings;
        }

        /*print('<pre>');
        print_r($commissionData);
        exit;*/
        $this->render('view', [
            'product' => $trading_product_data,
            'commissionData' => $commissionData
        ]);
    }
}