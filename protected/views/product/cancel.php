<?php
/**
 * Created by PhpStorm.
 * User: imyuvii
 * Date: 01/03/17
 * Time: 6:00 PM
 */
/* @var $this SiteController */

$this->pageTitle = "Payment Cancel";
$this->breadcrumbs = array(
    'User',
    'Payment Cancel',
);
$model = OrderInfo::model()->findByAttributes(['order_id' => $_GET['orderID'] ]);
$orderItem = OrderLineItem::model()->findByAttributes(['order_info_id' => $model->order_info_id]);
$product = ProductInfo::model()->findByAttributes(['product_id' => $orderItem->product_id]);

?>
<!-- Hero Content -->
<div class="bg-image" style="background-image: url('assets/img/photos/photo3@2x.jpg');">
    <div class="bg-primary-dark-op">
        <section class="content content-full content-boxed overflow-hidden">
            <!-- Section Content -->
            <div class="push-30-t push-30 text-center">
                <h1 class="h2 text-white push-10 visibility-hidden" data-toggle="appear" data-class="animated fadeInDown"><i class="fa fa-close text-danger"></i> Payment falied!</h1>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
</div>
<!-- END Hero Content -->
<!-- Products -->
<div class="block" style="height: 438px; margin-bottom: 0px;">
    <div class="block-header bg-gray-lighter">
        <h3 class="block-title">Transacation Details</h3>
    </div>
    <div class="block-content">
        <div class="table-responsive">

            <div class="col-md-12" style="color: #6d6767;">
                <div class="payment-header col-md-6">
                    Payment of <?php echo $_GET['currency'] . ' ' . $_GET['amount']; ?> failed! <br>
                    Unfortunately your payment request could not be completed. Please try again .
                </div>

                <div class="payment-right-header col-md-6">
                    Your Order No is <?php echo $_GET['orderID']; ?><br>
                    <?php echo date('Y-m-d', strtotime(str_replace('-', '/', $_GET['TRXDATE']))) . " " . date('H:i a'); ?>
                </div>
            </div>

            <div class="portlet-body">
                <div class="plan-detail col-md-8">
                    <div class="plan-header">
                        <h1>Transacation Details</h1>
                    </div>
                    <div class="plan-description">
                        <div class="pro-img"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/index.php/uploads/products/<?php if ($product->product_id == 2) { echo "promotor.png"; }elseif($product->product_id == 3 || $product->product_id == 5){ echo "incentive.png"; }elseif($product->product_id == 4 || $product->product_id == 6 || $product->product_id == 7){echo "business.png";}else{ echo "free.png"; }?>" class="img-responsive inline" ></div>
                        <div class="pro-name">
                            <h4><?php echo $product->name; ?></h4>
                            <p><?php echo $product->description; ?></p>
                            <p>Qty - 1</p>
                        </div>
                    </div>
                    <div class="plan-price">
                        <h5><?php echo $_GET['currency']." ".$_GET['amount']; ?></h5>
                        <p style="color: red; border-color: black; font-weight: 600">Payment failed!</p>
                    </div>
                </div>
                <div class="payment-summary col-md-4">
                    <div class="plan-header">
                        <h1>Payment Summary</h1>
                    </div>
                    <div class="subtotal">
                        <div class="payment-details">
                            <p>Payment Reference id <br><b><?php echo $_GET['PAYID']; ?></b> (Paid amount)</p>
                            <p>Product Price</p>
                            <p>Subtotal</p>
                        </div>
                        <div class="payment-total">
                            <p><?php echo $_GET['amount']; ?></p>
                            <p style="padding-top: 17px;"><?php echo $product->price; ?></p>
                            <p><?php echo $_GET['amount']; ?></p>
                        </div>
                    </div>
                    <div class="grandTotal">
                        <div class="grand-details">
                            <p>Order Total</p>
                        </div>
                        <div class="grand-total">
                            <?php echo $_GET['amount'];?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Products -->