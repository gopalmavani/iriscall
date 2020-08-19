<?php
$this->pageTitle = "Payment Success";
?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

            <!-- begin:: Subheader -->
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-container kt-container--fluid ">
                    <div class="kt-subheader__main">
                        <h3 class="kt-subheader__title"> Market Place </h3>
                        <span class="kt-subheader__separator kt-hidden"></span>
                        <div class="kt-subheader__breadcrumbs"> <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a> <span class="kt-subheader__breadcrumbs-separator"></span> <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Order Details</span> </div>
                    </div>
                </div>
            </div>
            <!-- end:: Subheader -->


            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <!--Begin::Dashboard 4-->

                <!--Begin::Row-->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card-body">
                            <h4 class="card-title">Transaction Details
                                <?php if ($order->order_status == 1){?>
                                    <span class="pull-right">
                                        <a style="margin-top:-5%" class="btn btn-default" target="_blank" href="<?php echo Yii::app()->createUrl('invoice/View/'.$order->order_info_id); ?>" ><i class="fa fa-print fa-lg"></i>   Print Invoice</a>
                                    </span>
                                <?php } ?>
                            </h4>
                            <p class="pull-left">
                                Payment of <?php echo "&euro;". $order->netTotal ?> is received by MMC!<br>
                                Your transaction is <b><?php print_r( $orderStatus->field_label);  ?></b>
                            </p>
                            <p class="pull-right">
                                Order No : <?php echo $order->order_id; ?><br>
                                Date : <?php echo date('d-m-Y',strtotime($order['created_date']));?>
                            </p>
                            <table class="table table-borderless table-vcenter">
                                <thead>
                                <tr>
                                    <td></td>
                                    <td><b>Product Details</b></td>
                                    <td class="text-right"><b>Quantity</b></td>
                                    <td class="text-right"><b>Price</b></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php //echo "<pre>";print_r($orderlineitem);die; ?>
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
                <!--End::Row-->

                <!--End::Dashboard 4-->
            </div>
            <!-- end:: Content -->
        </div>
    </div>
</div>