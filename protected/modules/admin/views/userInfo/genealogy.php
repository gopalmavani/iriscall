<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-primary-dark">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Genealogy</h3>
            </div>
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs">
                    <li class="active" id="userChild">
                        <a href="#btabs-alt-static-justified-child"><i class="fa fa-sitemap"></i> Child Structure</a>
                    </li>
                    <li id="userOrder">
                        <a href="#btabs-alt-static-justified-order"><i class="fa fa-file-text-o"></i> Orders </a>
                    </li>
                    <li id="userWallet">
                        <a href="#btabs-alt-static-justified-wallet"><i class="si si-wallet"></i> Wallets </a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <div class="tab-pane active" id="btabs-alt-static-justified-child">
                        <div class="block-content">
                            <div class="col-lg-12">

                                <!-- end child bar -->

                                <div class="table-scrollable noborder">
                                    <table class=" table-condensed" width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td>
                                                <h4 class="no-margin bold green"><a href="<?php echo Yii::app()->createUrl('admin/userInfo/view/'.$model->user_id); ?>"><?php echo $model->full_name; ?></a></h4>
                                            </td>
                                            <td>#<?php echo $model->user_id; ?></td>
                                            <td>
                                                <?php echo $model->email; ?>                                            </td>
                                            <td valign="middle">
                                                Personally referred: <strong class="green">0</strong><br>
                                                Total in team: <strong class="green">0</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="clearfix"></div>

                                <hr/>

                                <h4 class="border-btm">Nested View </h4>
                                <table class="table tree  table-hover">
                                    <?php
                                    $genealogyModel = UserInfo::model()->findAll();
                                    userTree($genealogyModel, $model->user_id, 0);
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-justified-order">
                        <div class="block-content">
                            <?php
                            if(!empty($orders)){
                            ?>
                            <table class="table table-borderless table-striped table-vcenter">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 100px;">ID</th>
                                    <th class="hidden-xs text-center">Date</th>
                                    <th>Status</th>
                                    <th class="visible-lg text-center">Products</th>
                                    <th class="hidden-xs text-center">Discount</th>
                                    <th class="hidden-xs text-center">Net Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($orders as $key => $order)
                                {
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <a class="font-" href="<?php echo Yii::app()->createUrl('admin/orderInfo/view/'.$order->order_id); ?>">
                                            <strong>ORD.<?php echo $order->order_id; ?></strong>
                                        </a>
                                    </td>
                                    <td class="hidden-xs text-center">
                                        <?php echo date('Y-m-d',strtotime($order->created_date)); ?>
                                    </td>
                                    <td>
                                        <?php
                                        $tableId = CylTables::model()->findByAttributes(['table_name' => 'order_info']);
                                        $fieldId = CylFields::model()->findByAttributes(['field_name' => 'order_status', 'table_id' => $tableId->table_id]);
                                        $fieldValue = CylFieldValues::model()->findByAttributes(['field_id' => $fieldId->field_id,'predefined_value' => $order->order_status]);
                                        ?>
                                        <span class="<?php if($order->order_status == 0){ echo 'label label-danger'; }else{ echo 'label label-success'; } ?>">
                                            <?php echo $fieldValue->field_label; ?></span>
                                    </td>
                                    <td class="text-center visible-lg">
                                        <?php
                                            $totalItem = OrderLineItem::model()->countByAttributes(['order_info_id' => $order->order_info_id]);
                                            echo $totalItem ?>
                                    </td>
                                    <td class="text-center  hidden-xs">
                                        <?php echo $order->discount; ?>
                                    </td>
                                    <td class="text-center  hidden-xs">
                                        <strong><?php echo $order->netTotal; ?></strong>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <?php
                            }else{
                                echo '<h5 class="text-danger"> Order not Found </h5>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-justified-wallet">
                        <div class="block-content">
                            <table class="table table-borderless table-striped table-vcenter">
                                <thead>
                                <tr>
                                    <th class="hidden-xs text-center">Wallet Type</th>
                                    <th class="text-center">Reference Key</th>
                                    <th class="visible-lg text-center">Updated Balance</th>
                                    <th class="hidden-xs text-center">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($wallets as $key => $wallet)
                                {
                                    ?>
                                    <tr>
                                        <td class="hidden-xs text-center">
                                            
                                            <?php 
                                            if($wallet->wallet_type_id) {
                                            $walletName = WalletTypeEntity::model()->findByAttributes(['wallet_type_id' => $wallet->wallet_type_id]);
                                                echo $walletName->wallet_type;
                                                }else{
                                                echo "User";
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            if($wallet->reference_id) {
                                            $walletRef = WalletMetaEntity::model()->findByAttributes(['reference_id' => $wallet->reference_id]);
                                            echo $walletRef->reference_key;
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center visible-lg">
                                            <?php
                                             if($wallet->updated_balance) {
                                             echo $wallet->updated_balance; 
                                             }
                                             ?>
                                        </td>
                                        <td class="text-center  hidden-xs">
                                            <?php
                                            if($wallet->amount != '')
                                            echo $wallet->amount;
                                            else {
                                                echo 0;
                                            } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
<!--            <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>-->
        </div>
    </div>
</div>
<?php
function userTree($data, $parent = 0, $level = 0)
{
    foreach ($data as $row) {

        if ($row->sponsor_id == $parent && $level < 5) {
        if($row->user_id != '1') {
            $parentClass = ($level != 0) ? ' treegrid-parent-' . $row->sponsor_id : '';
            $result = '';
            $result .= '<tr class="treegrid-' . $row->user_id . $parentClass . '">';
            $result .= '<td><a href='.Yii::app()->createUrl('admin/userInfo/view/'.$row->user_id) .'><strong>' . $row->full_name . '</strong></a></td>';
            $result .= '<td>#'.$row->user_id.'</td><td>'. $row->email .'</td>';
            echo $result;

//            // Recursive proccess
            userTree($data, $row->user_id, $level + 1);
            }
        }
    }
}

?>
<script>
    jQuery(document).ready(function() {
        $('.tree').treegrid({
            initialState: 'collapsed',
            expanderExpandedClass: 'glyphicon glyphicon-minus',
            expanderCollapsedClass: 'glyphicon glyphicon-plus'
        });

        function expandAll() {
            $('.tree').treegrid('expandAll');
        }

        function collapseAll() {
            $('.tree').treegrid('collapseAll');
        }

        $(".toggle_body").hide();
        $(".collapse").hide();
        $(".toggle_head").click(function () {
            var $this = $(this);
            $this.next(".toggle_body").slideToggle(300, function () {
                $this.children('img').toggle();
            });
        });

        $('#userChild').on('click',function () {
            $('#userOrder').removeClass('active');
            $('#userWallet').removeClass('active');
            $('#btabs-alt-static-justified-order').removeClass('active');
            $('#btabs-alt-static-justified-wallet').removeClass('active');

            $('#userChild').addClass('active');
            $('#btabs-alt-static-justified-child').addClass('active');
        });

        $('#userOrder').on('click',function () {
            $('#userChild').removeClass('active');
            $('#userWallet').removeClass('active');
            $('#btabs-alt-static-justified-child').removeClass('active');
            $('#btabs-alt-static-justified-wallet').removeClass('active');

            $('#userOrder').addClass('active');
            $('#btabs-alt-static-justified-order').addClass('active');
        });

        $('#userWallet').on('click',function () {
            $('#userChild').removeClass('active');
            $('#userOrder').removeClass('active');
            $('#btabs-alt-static-justified-child').removeClass('active');
            $('#btabs-alt-static-justified-order').removeClass('active');

            $('#userWallet').addClass('active');
            $('#btabs-alt-static-justified-wallet').addClass('active');
        });

    });
</script>