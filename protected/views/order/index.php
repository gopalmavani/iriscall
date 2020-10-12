<?php
$this->pageTitle = "View Orders";
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/datatables/jquery.dataTables.css');
?>
<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Wallet</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="<?= Yii::app()->createUrl('order/index'); ?>" class="text-muted">All Orders</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="d-flex flex-column-fluid" id="vue-div">
    <div class="container">
        <div class="row mt-0 mt-lg-3">
            <div class="col-xl-3">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-body">
                        <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block"><?= count($orders); ?></span>
                        <div class="text-inverse-white font-weight-bolder font-size-h5 mb-2 mt-5">Total Orders</div>
                        <div class="font-weight-bold text-inverse-white font-size-sm">Includes pending and cancelled orders</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card card-custom bg-info bg-hover-state-info card-stretch gutter-b">
                    <div class="card-body">
                        <span class="card-title font-weight-bolder text-inverse-info font-size-h2 mb-0 mt-6 d-block"><?= $licenses; ?></span>
                        <div class="text-inverse-info font-weight-bolder font-size-h5 mb-2 mt-5">Licenses Purchased</div>
                        <div class="font-weight-bold text-inverse-info font-size-sm"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
                    <div class="card-body">
                        <span class="card-title font-weight-bolder text-inverse-info font-size-h2 mb-0 mt-6 d-block"><?= $available_licenses; ?></span>
                        <div class="text-inverse-danger font-weight-bolder font-size-h5 mb-2 mt-5">Available Licenses</div>
                        <div class="font-weight-bold text-inverse-danger font-size-sm"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-body">
                        <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block"><?= $in_use_licenses; ?></span>
                        <div class="text-inverse-white font-weight-bolder font-size-h5 mb-2 mt-5">In Use Licenses</div>
                        <div class="font-weight-bold text-inverse-white font-size-sm"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <div class="example">
                            <div class="example-preview">
                                <div class="table-responsive table-responsive3 mb-4">
                                    <table class="table table-wallet" id="demo-foo-addrow">
                                        <thead role="rowgroup" class="thead-light">
                                        <tr>
                                            <th role="columnheader" class="text-center">Order ID</th>
                                            <th role="columnheader">Order details</th>
                                            <th>Status <select class='drop-box' data-column='2' style='width:100%; margin-bottom: 0'>
                                                    <option value='Success'>Success</option>
                                                    <option value='Cancelled'>Cancelled</option>
                                                    <option value='Pending'>Pending</option>
                                                    <option value='Reserved-Pending'>Reserved-Pending</option>
                                                </select></th>
                                            <th class="hidden-xs text-center" role="columnheader">Date</th>
                                            <th class="hidden-xs text-right" role="columnheader">Total</th>
                                            <th class="text-center" role="columnheader">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list">
                                            <?php foreach ($orders as $order) { ?>
                                            <?php
                                            $orderItems = OrderLineItem::model()->findAllByAttributes(['order_info_id' => $order['order_info_id']]);
                                            ?>
                                            <tr class="gradeX">
                                                <td class="text-center orderId">
                                                    <a class="font-"
                                                       href="<?php echo Yii::app()->createUrl('order/detail/' . $order['order_id']); ?>">
                                                        <strong><?php echo $order['order_id']; ?></strong>
                                                    </a>
                                                </td>
                                                <td width="38%" class="orderDetails">
                                                    <div class="order-pro">
                                                        <div class="order-dt">
                                                            <?php foreach ($orderItems as $orderItem) { ?>
                                                                <h4 class="pink"><?= $orderItem->product_name; ?></h4>
                                                            <?php } ?>
                                                            <a href="<?php echo Yii::app()->createUrl('order/detail/' . $order['order_id']); ?>">View order</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="orderStatus" width="15%">
                                                    <?php
                                                    if ($order['order_status'] == 1) { ?>
                                                        <span class='label font-weight-bold label-lg  label-light-success label-inline'>Success</span>
                                                    <?php } else if($order['order_status'] == 2){ ?>
                                                        <span class='label font-weight-bold label-lg  label-light-info label-inline'>Pending</span>
                                                    <?php } else { ?>
                                                        <span class='label font-weight-bold label-lg  label-light-danger label-inline'>Cancelled</span>
                                                    <?php } ?>

                                                </td>
                                                <td class="hidden-xs text-center orderDate"><?php echo date('d-M-Y',strtotime($order['created_date'])); ?></td>
                                                <td class="text-right hidden-xs orderAmount">
                                                    <strong class="pink semi-bold"><?php echo money_format('%(#1n',$order['netTotal']); ?></strong>
                                                </td>
                                                <td class="text-center orderAction">
                                                    <div class="btn-group btn-group-xs">
                                                        <a href="<?php echo Yii::app()->createUrl('order/detail/' . $order['order_id']); ?>"
                                                           data-toggle="tooltip" title="View" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                                        <?php if (isset($order['invoice_number'])) { ?>
                                                            <a href="<?php echo Yii::app()->createUrl('invoice/Generateinvoice/' . $order['order_info_id']);?>"
                                                               data-toggle="tooltip" title="Download Invoice" target="_blank" class="btn btn-default"><i
                                                                        class="fa fa-download"></i></a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="pages" align="right">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= Yii::app()->baseUrl . '/plugins/datatables/jquery.dataTables.min.js' ?>"></script>
<script type="text/javascript">
    var table = $('#demo-foo-addrow').DataTable({
        "columnDefs": [
            {
                "orderable": false,
                "targets": [0,1,2,3,4,5]
            }
        ],
        /*"order": [[ 3, "desc" ]]*/
    });

    //Default Success orders
    table.columns(2).search("Success").draw();

    $('.drop-box').on('change', function () {
        var i =$(this).attr('data-column');
        var v =$(this).val();
        table.columns(i).search(v).draw();
    } );
</script>