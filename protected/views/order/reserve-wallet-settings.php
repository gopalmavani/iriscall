<div class="row">
    <div class="col-lg-7 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-12">
                        <h2 style="color: teal"><?= ServiceHelper::getPayoutSettings($reserve_wallet_commission_status); ?></h2>
                        <span>Payout Settings</span><a href="<?= Yii::app()->createUrl('user/profile')."#payout-info" ?>" class="card-link" style="margin-left: 10px"><i class="ti-pencil"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body text-info">
                <!-- Row -->
                <div class="row">
                    <div class="col-12">
                        <h2 style="color: blue" id="reserve_wallet_balance"><?= money_format('%(#1n',$reserve_wallet_balance); ?></h2>
                        <h6>Reserve Wallet Balance</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="card">
            <div class="card-body text-info">
                <!-- Row -->
                <div class="row">
                    <div class="col-12" style="text-align: center">
                        <a href="<?= Yii::app()->createUrl('order/pendingOrder') ?>" id="new_pending_order"><i class="fa fa-2x fa-plus"></i></a>
                        <h6 style="margin-top: 2px; margin-bottom: 0">New Pending Order</h6></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if(count($pending_orders) > 0) { ?>
                    <h4 class="card-title">Order List</h4>
                    <h6 class="card-subtitle">List of all pending orders</h6>
                    <div class="table-responsive" id="orderTable">
                        <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list footable-loaded table-striped footable my-order max900" data-page-size="10">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">Order ID</th>
                                <th>Order details</th>
                                <th>Status</th>
                                <th class="hidden-xs text-center">Date</th>
                                <th class="hidden-xs text-right">Total</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            <?php foreach ($pending_orders as $order) { ?>
                                <?php
                                $orderItem = OrderLineItem::model()->findByAttributes(['order_info_id' => $order['order_info_id']]);
                                $orderImage = ProductInfo::model()->findByAttributes(['product_id' => $orderItem['product_id']]);
                                ?>
                                <tr class="gradeX" id="order_id_<?= $order['order_id']; ?>">
                                    <td class="text-center orderId">
                                        <a class="font-"
                                           href="<?php echo Yii::app()->createUrl('order/detail/' . $order['order_id']); ?>">
                                            <strong><?php echo $order['order_id']; ?></strong>
                                        </a>
                                    </td>
                                    <td width="38%" class="orderDetails">
                                        <div class="order-pro">

                                            <img src="<?php echo Yii::app()->baseUrl.$orderImage['image'] ?>" style="width:70px"; alt="image" />
                                            <div class="order-dt">
                                                <?php if(empty($orderItem->product_name)){$product_name = '';}else{$product_name = $orderItem->product_name;} ?>
                                                <h4 class="pink"><?php echo $product_name   ; ?></h4>
                                                <a href="<?php echo Yii::app()->createUrl('order/detail/' . $order['order_id']); ?>">View order</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="orderStatus" width="15%">
                                        <?php
                                        if ($order['order_status'] == 1) { ?>
                                            <span class="label label-success">Success</span>
                                        <?php } else if($order['order_status'] == 2){ ?>
                                            <span class="label label-warning">Pending</span>
                                        <?php } else if($order['order_status'] == 3){ ?>
                                            <span class="label label-warning">Reserved-Pending</span>
                                        <?php } else { ?>
                                            <span class="label label-danger">Cancelled</span>
                                        <?php } ?>

                                    </td>
                                    <td class="hidden-xs text-center orderDate"><?php echo date('d-M-Y',strtotime($order['created_date'])); ?></td>
                                    <td class="text-right hidden-xs orderAmount">
                                        <strong class="pink semi-bold"><?php echo money_format('%(#1n',$order['netTotal']); ?></strong>
                                    </td>
                                    <td class="text-center orderAction">
                                        <!--<a href="<?php /*echo Yii::app()->createUrl('order/detail/' . $order['order_id']); */?>"
                                               data-toggle="tooltip" title="View" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                        <a href="#" data-toggle="tooltip" title="Confirm" class="btn btn-default"><i class="fa fa-check"></i></a>
                                        <a href="#" data-toggle="tooltip" title="Cancel" class="btn btn-default"><i class="fa fa-times"></i></a>-->
                                        <button type="button" data-toggle="tooltip" title="View Order" onclick='openOrderDetails(<?= $order['order_id']; ?>)' class="btn btn-warning btn-circle"><i class="fa fa-eye"></i> </button>
                                        <button type="button" data-toggle="tooltip" title="Cancel Order" onclick='cancelOrder(<?= $order['order_id']; ?>)' class="btn btn-danger btn-circle"><i class="fa fa-times"></i> </button>
                                        <button type="button" data-toggle="tooltip" title="Confirm Order" onclick='confirmOrder(<?= $order['order_id']; ?>)' class="btn btn-success btn-circle"><i class="fa fa-check"></i> </button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                <?php } else { ?>
                    <h3 class="text-center">No Pending Orders Found</h3>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   $('#demo-foo-addrow').DataTable({
        "columnDefs": [
            { "orderable": false,
                "targets": [0,1,2,3,4,5] }
        ]
   });

   function openOrderDetails(orderId) {
       var orderDetailUrl = "<?= Yii::app()->createUrl('order/detail'); ?>"+ "/" +orderId;
       window.location = orderDetailUrl;
   }

   function cancelOrder(orderId) {
       const orderCancelUrl = "<?= Yii::app()->createUrl('order/cancel'); ?>";
       var orderData = {
           'order_id': orderId
       };
       $.ajax({
           type: "POST",
           url: orderCancelUrl,
           data: orderData,
           success: function (data) {
               toastr.error("Order has been cancelled");
               $('#order_id_'+orderId).fadeOut();
           }
       });
   }

   function confirmOrder(orderId) {
       const reserve_wallet_balance = "<?= $reserve_wallet_balance; ?>";
       const orderTotalUrl = "<?= Yii::app()->createUrl('order/getOrderAmount'); ?>";
       const orderAmountData = {
           'order_id': orderId
       };
       $.ajax({
           type: "POST",
           url: orderTotalUrl,
           data: orderAmountData,
           success: function (data) {
               if(data){
                   if(parseFloat(data) <= reserve_wallet_balance) {
                       const orderConfirmUrl = "<?= Yii::app()->createUrl('order/confirmPendingOrder') ?>";
                       const orderData = {
                           'order_id': orderId,
                           'payment_mode': 5
                       };
                       $.ajax({
                           type: "POST",
                           url: orderConfirmUrl,
                           data: orderData,
                           success: function (datum) {
                               toastr.success("Order has been confirmed");
                               $('#order_id_'+orderId).fadeOut();
                               let available_reserve_wallet_balance = parseFloat(reserve_wallet_balance) - parseFloat(data);
                               $('#reserve_wallet_balance').html('Eu '+available_reserve_wallet_balance);
                           }
                       });
                   } else {
                       toastr.error("Insufficient Reserve Wallet Balance");
                   }
               } else {
                   toastr.error("Inavlid Order");
               }
           }
       });
   }

</script>