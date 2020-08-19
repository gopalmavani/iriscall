<?php
$this->pageTitle = "View Orders";
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/datatables/jquery.dataTables.css');
?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
            <?php if(empty($orders)){ ?>
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="kt-portlet">
                                <div class="kt-portlet__body">
                                    <h3 class="kt-subheader__title" style="text-align: center">No Orders found!! Lets do some shopping </h3>
                                    <a href="<?= Yii::app()->createUrl('marketplace/index'); ?>" style="margin: auto" class="btn btn-sm btn-secondary">Go to Shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <!-- begin:: Subheader -->
                <div class="kt-subheader kt-grid__item" id="kt_subheader">
                    <div class="kt-container kt-container--fluid ">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title"> Order </h3>
                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs"> <a href="<?= Yii::app()->createUrl('order/index'); ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a> <span class="kt-subheader__breadcrumbs-separator"></span> <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Order</span> </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="kt-portlet kt-portlet--skin-solid kt-bg-brand kt-portlet--height-fluid">
                                <div class="kt-portlet__body">
                                    <div class="kt-portlet__content">
                                        <h1><?= count($orders); ?></h1>
                                        <div>Total Orders</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <!--begin::Portlet-->
                            <div class="kt-portlet kt-portlet--skin-solid kt-bg-success kt-portlet--height-fluid">
                                <div class="kt-portlet__body">
                                    <div class="kt-portlet__content">
                                        <h1><?= $licenses; ?></h1>
                                        <div>Licenses Purchased</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Portlet-->
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <!--begin::Portlet-->
                            <div class="kt-portlet kt-portlet--skin-solid kt-bg-warning kt-portlet--height-fluid">
                                <div class="kt-portlet__body">
                                    <div class="kt-portlet__content">
                                        <h1><?= $available_licenses; ?></h1>
                                        <div>Available Licenses</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <!--begin::Portlet-->
                            <div class="kt-portlet kt-portlet--skin-solid kt-bg-danger kt-portlet--height-fluid">
                                <div class="kt-portlet__body">
                                    <div class="kt-portlet__content">
                                        <h1><?= $in_use_licenses; ?></h1>
                                        <div>In Use Licenses</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="kt-portlet">
                                <div class="kt-portlet__body">
                                    <div class="table-responsive" id="orderTable">
                                        <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list footable-loaded table-striped footable my-order max900" data-page-size="10">
                                            <thead>
                                            <tr>
                                                <th class="text-center" style="width: 100px;">Order ID</th>
                                                <th>Order details</th>
                                                <th>Status <select class='drop-box' data-column='2' style='width:100%; margin-bottom: 0'>
                                                        <option value='Success'>Success</option>
                                                        <option value='Cancelled'>Cancelled</option>
                                                        <option value='Pending'>Pending</option>
                                                        <option value='Reserved-Pending'>Reserved-Pending</option>
                                                    </select></th>
                                                <th class="hidden-xs text-center">Date</th>
                                                <th class="hidden-xs text-right">Total</th>
                                                <th class="text-center">Action</th>
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
                                                            <span class='kt-badge kt-badge--inline kt-badge--success'>Success</span>
                                                        <?php } else if($order['order_status'] == 2){ ?>
                                                            <span class='kt-badge kt-badge--inline kt-badge--warning'>Pending</span>
                                                        <?php } else { ?>
                                                            <span class='kt-badge kt-badge--inline kt-badge--danger'>Cancelled</span>
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
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Content -->
            <?php } ?>
        </div>
    </div>
</div>
<script src="<?= Yii::app()->baseUrl . '/plugins/datatables/jquery.dataTables.min.js' ?>"></script>
<script type="text/javascript">
    let table = $('#demo-foo-addrow').DataTable({
        "columnDefs": [
            {
                "orderable": false,
                "targets": [0,1,2,3,4,5]
            }
        ],
        "order": [[ 3, "desc" ]]
    });

    //Default Success orders
    table.columns(2).search("Success").draw();

    $('.drop-box').on('change', function () {
        let i =$(this).attr('data-column');
        let v =$(this).val();
        table.columns(i).search(v).draw();
    } );
</script>