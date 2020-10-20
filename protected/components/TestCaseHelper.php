<?php

class TestCaseHelper extends CApplicationComponent {

    //Test cases
    public static function performTestCases(){

        //Test case array
        $test_cases = array();

        //Order-License check
        $user_orders = Yii::app()->db->createCommand()
            ->select('ui.user_id, ui.email, sum(orderTotal), sum(orderTotal)/5 as required_licenses, cl.total_licenses, 
            (sum(orderTotal)/5) - cl.total_licenses as difference')
            ->from('user_info ui')
            ->join('order_info oi', 'ui.user_id = oi.user_id')
            ->join('cbm_user_licenses cl', 'ui.email = cl.email')
            ->where('oi.order_status = :os',[':os'=>1])
            ->group('ui.user_id, ui.email')
            ->queryAll();

        $user_order_test_case = array();
        $user_order_test_case['name'] = "User Order License check";
        $user_order_test_case['description'] = "Comparison of user's orders with their total licenses";
        $user_order_test_case['status'] = 1;

        $detailString = '<div class="row">';
        foreach ($user_orders as $user_order){
            if($user_order['difference'] != 0){
                $user_order_test_case['status'] = 0;
                $detailString .= '<div class="col-md-4">
                                      <div class="block block-themed block-rounded">
                                        <div class="block-header bg-smooth">
                                            <h3 class="block-title" style="text-transform: none">Email Address: <br>' . $user_order['email'] . '</h3>  
                                        </div>
                                        <div class="block-content">
                                            <p>The user should have <strong class="h4">' . $user_order['required_licenses'] . '</strong> licenses but has <strong class="h4">' . $user_order['total_licenses'] . '</strong>.</p>
                                        </div>
                                      </div>
                                  </div>';
            }
        }
        $detailString .= '</div>';
        $user_order_test_case['details'] = $detailString;
        array_push($test_cases, $user_order_test_case);

        //Order-Affiliate Check
        $affiliate_reference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Affiliate Commission']);
        $wallet_reference_num = Yii::app()->db->createCommand()
            ->select('distinct(reference_num)')
            ->from('wallet')
            ->where('reference_id=:rId', [':rId'=>$affiliate_reference->reference_id])
            ->queryColumn();

        $order_affiliates = Yii::app()->db->createCommand()
            ->select('order_id, netTotal, order_status, email')
            ->from('order_info')
            ->where(['not in', 'order_id', $wallet_reference_num])
            ->andWhere('order_status=:os', [':os'=>1])
            ->andWhere('netTotal>:nt', [':nt'=>0])
            ->queryAll();

        $order_affiliate_test_case = array();
        $order_affiliate_test_case['name'] = "Orders to Affiliate check";
        $order_affiliate_test_case['description'] = "Comparison of user's orders with their affiliates";
        $order_affiliate_test_case['status'] = 1;

        $detailString = '<div class="row">';
        foreach ($order_affiliates as $detail){
            $order_affiliate_test_case['status'] = 0;
            $detailString .= '<div class="col-md-4">
                                  <div class="block block-themed block-rounded">
                                    <div class="block-header bg-flat">
                                        <h3 class="block-title" style="text-transform: none">Email Address: <br>' . $detail['email'] . '</h3>  
                                    </div>
                                    <div class="block-content">
                                        <p>Affiliates are not distributed for orderId: <strong class="h4">' . $detail['order_id'] . '</strong>.</p>
                                    </div>
                                  </div>
                              </div>';

        }
        $detailString .= '</div>';
        $order_affiliate_test_case['details'] = $detailString;
        array_push($test_cases, $order_affiliate_test_case);

        //Orphan node test
        $sql = "SELECT * FROM `fifty_euro_matrix` where id not in 
                  (SELECT lchild from fifty_euro_matrix where lchild is not null)  and id not in 
                  (SELECT rchild from fifty_euro_matrix where rchild is not null) and id!=1;";
        $orphan_nodes = Yii::app()->db->createCommand($sql)->queryAll();

        $orphan_nodes_test_case = array();
        $orphan_nodes_test_case['name'] = "Orphan Nodes check in Matrix";
        $orphan_nodes_test_case['description'] = "CBM Matrix orphan nodes/empty links test case";
        $orphan_nodes_test_case['status'] = 1;

        $detailString = '<div class="row">';
        foreach ($orphan_nodes as $detail){
            $orphan_nodes_test_case['status'] = 0;
            $detailString .= '<div class="col-md-4">
                                  <div class="block block-themed block-rounded">
                                    <div class="block-header bg-flat">
                                        <h3 class="block-title" style="text-transform: none">Email Address: <br>' . $detail['email'] . '</h3>  
                                    </div>
                                    <div class="block-content">
                                        <p>Node Id <strong class="h4">' . $detail['id'] . '</strong> with CBM account number
                                         <strong class="h4">' . $detail['cbm_account_num'] . '</strong> is orphan.</p>
                                    </div>
                                  </div>
                              </div>';

        }
        $detailString .= '</div>';
        $orphan_nodes_test_case['details'] = $detailString;
        array_push($test_cases, $orphan_nodes_test_case);

        //API trades job test case
        $cronLogs = Yii::app()->db->createCommand()
            ->select('ci.name, cl.log, cl.stack_trace, cl.status, cl.created_at')
            ->from('cron_logs cl')
            ->join('cron_info ci', 'cl.cron_id=ci.id')
            ->where(['in', 'cl.cron_id', [1,2]])
            ->andWhere('date(cl.created_at)=:dc', [':dc'=>date('Y-m-d', strtotime("yesterday"))])
            ->queryAll();
        $api_trades_cron_log_test_case= [];
        $api_trades_cron_log_test_case['name'] = "CBM API trades daily job";
        $api_trades_cron_log_test_case['description'] = "Daily cron job for filling up api_trades";
        $api_trades_cron_log_test_case['status'] = 1;

        $detailString = '<div class="row">';
        if(count($cronLogs) > 0){
            foreach ($cronLogs as $cronLog){
                if($cronLog['status'] == 0){
                    $api_trades_cron_log_test_case['status'] = 0;
                    $detailString .= '<div class="col-md-4">
                                  <div class="block block-themed block-rounded">
                                    <div class="block-header bg-flat">
                                        <h3 class="block-title" style="text-transform: none">Job: <br>' . $cronLog['name'] . '</h3>  
                                    </div>
                                    <div class="block-content">
                                        <p>Log: <strong class="h4">' . $cronLog['log'] . '</strong> and Stack Trace:
                                         <strong class="h4">' . $cronLog['stack_trace'] . '</strong>.</p>
                                    </div>
                                  </div>
                              </div>';
                }
            }
        } else {
            $api_trades_cron_log_test_case['status'] = 0;
            $detailString .= '<div class="col-md-4">
                                  <div class="block block-themed block-rounded">
                                    <div class="block-header bg-flat">
                                        <h3 class="block-title" style="text-transform: none">None of the job were executed on <br>'.date('Y-m-d', strtotime("yesterday")).'</h3>  
                                    </div>
                                  </div>
                              </div>';
        }
        $detailString .= '</div>';
        $api_trades_cron_log_test_case['details'] = $detailString;
        array_push($test_cases, $api_trades_cron_log_test_case);

        //CBM commission table

        return $test_cases;
    }
}