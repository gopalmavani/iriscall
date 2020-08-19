<?php
/**
 * Created by PhpStorm.
 * User: imyuvii
 * Date: 01/03/17
 * Time: 6:00 PM
 */
/* @var $this SiteController */

$this->pageTitle = "Payment Success";
$this->breadcrumbs = array(
    'User',
    'Payment Success',
);
$order = OrderInfo::model()->findByAttributes(['order_id' => $orderID ]);
$orderlineitem = OrderLineItem::model()->findAllByAttributes(['order_info_id' => $order->order_info_id]);
$orderStatus = CylFieldValues::model()->findByAttributes(['field_id' => 101, 'predefined_value' => $order->order_status]);
$orderPayment = OrderPayment::model()->findByAttributes(['order_info_id' => $order->order_info_id]);
?>
<!-- Hero Content -->
<div class="bg-image">
    <div class="bg-primary-dark-op">
        <section class="content content-full content-boxed overflow-hidden">
            <!-- Section Content -->
            <div class="push-30-t push-30 text-center">
                <h1 class="h2 text-success  push-10 visibility-hidden" data-toggle="appear" data-class="animated fadeInDown"><i class="fa fa-check text-success"></i> Payment Successful</h1>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
</div>
<!-- END Hero Content -->
<!-- Products -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Order Details
            </div>
            <div class="card-body">
                <h4 class="card-title">Transaction Details
                    <?php if ($order->order_status == 1){?>
                        <span class="pull-right">
                            <!-- <a style="margin-top:-5%" class="btn btn-default" target="_blank" href="--><?php //echo Yii::app()->createUrl('invoice/Generateinvoice/'.$order->order_info_id); ?><!--" ><i class="fa fa-arrow-circle-down"></i> Invoice</a></button>-->
                            <a style="margin-top:-5%" class="btn btn-default" target="_blank" href="<?php echo Yii::app()->createUrl('invoice/View/'.$order->order_info_id); ?>" ><i class="fa fa-print fa-lg"></i>   Print Invoice</a>
                    </span>
                    <?php } ?>
                </h4>
                <p class="pull-left">
                    Payment of <?php echo "&euro;". $order->netTotal ?> is received by CBM!<br>
                    Your transaction is <b><?php print_r( $orderStatus->field_label);  ?></b>
                </p>
                <p class="pull-right">
                    Order No : <?php echo $order->order_id; ?><br>
                    <!--Date : --><?php /*echo date('d-M-Y',strtotime($order['invoice_date']));*/?>
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
                    <?php foreach ($orderlineitem as $item){
                        $product = ProductInfo::model()->findByAttributes(['product_id' => $item->product_id]);
                        if(isset($product)){
                            ?>
                            <tr>
                                <td style="width: 55px;">
                                    <img src="<?php echo Yii::app()->baseUrl. '/images/CBM-Logo-Option1.png'; ?>" class="img-responsive">
                                </td>
                                <td>
                                    <a class="h5" href="<?php echo Yii::app()->createUrl('product/detail/' . $item->product_id); ?>"><?php echo $item->product_name; ?></a>
                                    <!-- <div class="font-s12 text-muted hidden-xs"><?php //echo $product->short_description; ?></div> -->
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
                            <span class="h4 font-w600">Total</span>
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
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Order Summary
            </div>
            <div class="card-body">
                <table class="table table-borderless table-vcenter">
                    <tbody>
                    <tr>
                        <td>
                            <p>Payment Reference id</p>
                            <p>Total</p>
                            <p>Discount</p>
                            <?php 
                            if ($order->vat != 0) {
                                $vatpercent = $order->vat / ($order->orderTotal - $order->discount) * 100;?>
                                <p>Vat@<?= round($order->vat_percentage);?>%</p>
                            <?php }else{?>
                                <p>Vat</p>
                            <?php } ?>
                        </td>
                        <td style="width: 55px;" class="text-right">
                            <p><?php echo $orderPayment->payment_ref_id; ?></p>
                            <p>&euro;<?php echo $order->orderTotal; ?></p>
                            <p>-&euro;<?php echo $order->discount; ?></p>
                            <p>&euro;<?php echo $order->vat; ?></p>
                        </td>
                    </tr>

                    <tr class="success">
                        <td class="text-right" colspan="1">
                            <span class="h4 font-w600">Total</span>
                        </td>
                        <td class="text-right">
                            <div class="h4 font-w600 text-success">&euro;<?php echo $order->netTotal; ?></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>