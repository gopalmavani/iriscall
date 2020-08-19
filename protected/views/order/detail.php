<?php
$this->pageTitle = "Order Detail";
?>
<style>
    #payment-detail-table > tbody > tr > td {
        border: unset;
    }
</style>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
            <!-- begin:: Subheader -->
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-container kt-container--fluid ">
                    <div class="kt-subheader__main">
                        <h3 class="kt-subheader__title"> Order Details </h3>
                        <span class="kt-subheader__separator kt-hidden"></span>
                        <div class="kt-subheader__breadcrumbs"> <a href="<?= Yii::app()->createUrl('order/index'); ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a> <span class="kt-subheader__breadcrumbs-separator"></span> <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Order</span> </div>
                    </div>
                </div>
            </div>
            <!-- end:: Subheader -->
            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <div class="row">
                    <div class="col-md-6 col-xl-8">
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title"> Transaction Details</h3>
                                </div>
                                <div class="kt-portlet__head-toolbar">
                                    <?php if (isset($order->invoice_number)) { ?>
                                        <span class="pull-right">
                                            <a style="margin-top:-5%" class="btn btn-default" target="_blank" href="<?php echo Yii::app()->createUrl('invoice/Generateinvoice/'.$order->order_info_id); ?>" ><i class="fa fa-arrow-circle-down"></i> Invoice</a></button>
                                            <a style="margin-top:-5%" class="btn btn-default" target="_blank" href="<?php echo Yii::app()->createUrl('invoice/View/'.$order->order_info_id); ?>" ><i class="fa fa-print fa-lg"></i>   Print Invoice</a>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="kt-portlet__content">
                                    <p class="pull-left">
                                        <?php if ($order->order_status == 1) { ?>
                                            Payment of <?php echo "&euro;" . round($order->netTotal,2) ?> is received by CBM!<br>
                                        <?php } ?>
                                        Your transaction is
                                        <?php if ($orderStatus->field_label == 'Pending') { ?>
                                            <b class="label label-warning"
                                               style="font-size: 100%;"><?php print_r($orderStatus->field_label); ?></b>
                                        <?php } elseif ($orderStatus->field_label == 'Success') { ?>
                                            <b class="label label-success"
                                               style="font-size: 100%;"><?php print_r($orderStatus->field_label); ?></b>
                                        <?php } elseif ($orderStatus->field_label == 'Reserved-Pending') { ?>
                                            <b class="label label-warning"
                                               style="font-size: 100%;"><?php print_r($orderStatus->field_label); ?></b>
                                        <?php } else { ?>
                                            <b class="label label-danger"
                                               style="font-size: 100%;"><?php print_r($orderStatus->field_label); ?></b>
                                        <?php } ?>

                                    </p>
                                    <p class="pull-right">
                                        Order No : <?php echo $order->order_id; ?><br>
                                        Date : <?php echo date('d-M-Y', strtotime($order['created_date'])); ?>
                                    </p>
                                    <table class="table table-borderless table-vcenter">
                                        <thead>
                                        <tr>
                                            <td>
                                            </td>
                                            <td>
                                                <b>Product Details</b>
                                            </td>
                                            <td class="text-right">
                                                <b>Quantity</b>
                                            </td>
                                            <td class="text-right">
                                                <b>Price</b>
                                            </td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($orderlineitem as $item) {
                                            $product = ProductInfo::model()->findByAttributes(['product_id' => $item->product_id]);
                                            if (isset($product)) {
                                                ?>
                                                <tr>
                                                    <td style="width: 55px;">
                                                        <img src="<?php echo Yii::app()->baseUrl . $product->image; ?>"
                                                             class="img-responsive">
                                                    </td>
                                                    <td>
                                                        <a class="h5"
                                                           href="<?php echo Yii::app()->createUrl('product/detail/' . $item->product_id); ?>"><?php echo $item->product_name; ?></a>
                                                        <!-- <div class="font-s12 text-muted hidden-xs"><?php //echo $product->short_description;
                                                        ?></div> -->
                                                    </td>
                                                    <td class="text-right">
                                                        <div class="font-w600 text-success"><?php echo $item->item_qty; ?></div>
                                                    </td>
                                                    <td class="text-right">
                                                        <div class="font-w600 text-success">&euro; <?php echo $product->price; ?></div>
                                                    </td>
                                                </tr>
                                            <?php }
                                        }
                                        ?>
                                        <tr class="success">
                                            <td class="text-right" colspan="3">
                                                <span class="h4 font-w600">Sub Total</span>
                                            </td>
                                            <td class="text-right">
                                                <div class="h4 font-w600 text-success">&euro; <?php echo $order->orderTotal; ?></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">Order Summary</h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="kt-portlet__content">
                                    <table class="table table-borderless table-vcenter" id="payment-detail-table">
                                        <tbody>
                                        <tr>
                                            <td>Order Total</td>
                                            <td class="text-right">&euro;<?= $order->orderTotal; ?></td>
                                        </tr>
                                        <?php if ($order->discount > 0) { ?>
                                            <tr>
                                                <td>Discount</td>
                                                <td class="text-right">&euro;<?php echo $order->discount; ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($order->voucher_discount > 0) { ?>
                                            <tr>
                                                <td>Voucher Discount</td>
                                                <td class="text-right">&euro;<?php echo $order->voucher_discount; ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($order->vat > 0) { ?>
                                            <tr>
                                                <td>Vat@<?= $order->vat_percentage; ?>%</td>
                                                <td class="text-right">&euro;<?php echo $order->vat; ?></td>
                                            </tr>
                                        <?php } ?>

                                        <tr class="success">
                                            <td class="text-right" colspan="1">
                                                <span class="h4 font-w600">Total</span>
                                            </td>
                                            <td class="text-right">
                                                <div class="h4 font-w600 text-success">&euro;<?php echo round($order->netTotal,2); ?></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xl-8">
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">Payment Summary</h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="kt-portlet__content">
                                    <table class="table table-borderless table-vcenter" id="payment-detail-table">
                                        <tr>
                                            <td style="border-bottom: 1px solid #e9ecef">Payment Option</td>
                                            <td style="border-bottom: 1px solid #e9ecef" class="text-right">Amount</td>
                                        </tr>
                                        <tbody>
                                        <?php foreach ($orderpayment as $value) { ?>
                                            <tr>
                                                <td><?= $value->transaction_mode; ?></td>
                                                <td class="text-right">&euro;<?= round($value->total,2); ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end:: Content -->
        </div>
    </div>
</div>