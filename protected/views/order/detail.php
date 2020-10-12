<?php
$this->pageTitle = "Order Detail";
?>
<style>
    #payment-detail-table > tbody > tr > td {
        border: unset;
    }
</style>
<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">All Orders</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="<?= Yii::app()->createUrl('order/index'); ?>" class="text-muted">Orders</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= Yii::app()->createUrl('order/detail/'.$order->order_id); ?>" class="text-muted"><?= $order->order_id ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="d-flex flex-column-fluid" id="vue-div">
    <div class="container">
        <div class="d-flex flex-row">
            <div class="flex-row-fluid ml-lg-12">
                <div class="card card-custom gutter-b">
                    <div class="card-body p-0">
                        <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                            <div class="col-md-10">
                                <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                    <h1 class="display-4 font-weight-boldest mb-10">ORDER DETAILS</h1>
                                    <div class="d-flex flex-column align-items-md-end px-0">
                                        <a href="<?= Yii::app()->createUrl('home/index'); ?>" class="mb-5">
                                            <img src="<?= Yii::app()->baseUrl ?>/images/logos/iriscall-logo.svg" alt="" />
                                        </a>
                                        <span class="d-flex flex-column align-items-md-end opacity-70">
                                            <span>Cecilia Chapman, 711-2880 Nulla St, Mankato</span>
                                            <span>Mississippi 96522</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="border-bottom w-100"></div>
                                <div class="d-flex justify-content-between pt-6">
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">ORDER DATE</span>
                                        <span class="opacity-70"><?php echo date('M d, Y', strtotime($order['created_date'])); ?></span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">ORDER NO.</span>
                                        <span class="opacity-70"><?= $order->order_id; ?></span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">Transaction Status.</span>
                                        <span class="opacity-70"><?= $orderStatus->field_label; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-10">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="pl-0 font-weight-bold text-muted text-uppercase">Ordered Items</th>
                                                <th class="text-right font-weight-bold text-muted text-uppercase">Qty</th>
                                                <th class="text-right font-weight-bold text-muted text-uppercase">Unit Price</th>
                                                <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orderlineitem as $item) {
                                                $product = ProductInfo::model()->findByAttributes(['product_id' => $item->product_id]);
                                                if (isset($product)) {
                                                    ?>
                                                    <tr class="font-weight-boldest">
                                                        <td class="border-0 pl-0 pt-7 d-flex align-items-center">
                                                            <div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">
                                                                <div class="symbol-label" style="background-image: url('<?php echo Yii::app()->baseUrl . $product->image; ?>');"></div>
                                                            </div>
                                                            <?php echo $item->product_name; ?>
                                                        </td>
                                                        <td class="text-right pt-7 align-middle">
                                                            <?php echo $item->item_qty; ?>
                                                        </td>
                                                        <td class="text-right pt-7 align-middle">
                                                            <?php echo $product->price; ?>
                                                        </td>
                                                        <td class="text-primary pr-0 pt-7 text-right align-middle">
                                                            &euro; <?php echo ($item->item_qty * $product->price); ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                } ?>
                                            <?php if ($order->discount > 0) { ?>
                                                <tr>
                                                    <td style="border-top: 0"></td>
                                                    <td style="border-top: 0"></td>
                                                    <td style="border-top: 0" class="text-right">Discount</td>
                                                    <td class="text-primary pr-0 pt-7 text-right align-middle">&euro;<?php echo $order->discount; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if ($order->voucher_discount > 0) { ?>
                                                <tr>
                                                    <td style="border-top: 0"></td>
                                                    <td style="border-top: 0"></td>
                                                    <td style="border-top: 0" class="text-right">Voucher Discount</td>
                                                    <td class="text-primary pr-0 pt-7 text-right align-middle">&euro;<?php echo $order->voucher_discount; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if ($order->vat > 0) { ?>
                                                <tr>
                                                    <td style="border-top: 0"></td>
                                                    <td style="border-top: 0"></td>
                                                    <td style="border-top: 0" class="text-right">Vat@<?= $order->vat_percentage; ?>%</td>
                                                    <td class="text-primary pr-0 pt-7 text-right align-middle">&euro;<?php echo $order->vat; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr class="success">
                                                <td style="border-top: 0"></td>
                                                <td style="border-top: 0"></td>
                                                <td style="border-top: 0" class="text-right">Total</td>
                                                <td class="text-primary pr-0 pt-7 text-right align-middle">&euro;<?php echo round($order->netTotal,2); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0 mx-0">
                            <div class="col-md-10">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="font-weight-bold text-muted text-uppercase">PAYMENT TYPE</th>
                                            <th class="font-weight-bold text-muted text-uppercase">PAYMENT STATUS</th>
                                            <th class="font-weight-bold text-muted text-uppercase">PAYMENT DATE</th>
                                            <th class="font-weight-bold text-muted text-uppercase text-right">TOTAL PAID</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orderpayment as $value) { ?>
                                                <tr class="font-weight-bolder">
                                                    <td><?= $value->transaction_mode; ?></td>
                                                    <?php if($value->payment_status == 0) { ?>
                                                        <td><span class="label font-weight-bold label-lg  label-light-danger label-inline">Failed</span></td>
                                                    <?php } elseif ($value->payment_status == 1) { ?>
                                                        <td><span class="label font-weight-bold label-lg  label-light-success label-inline">Success</span></td>
                                                    <?php } else { ?>
                                                        <td><span class="label font-weight-bold label-lg  label-light-info label-inline">Pending</span></td>
                                                    <?php } ?>
                                                    <td><?php echo date('M d, Y', strtotime($value->payment_date)); ?></td>
                                                    <td class="text-primary font-size-h3 font-weight-boldest text-right">&euro;<?= round($value->total,2); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-10">
                                <div class="d-flex justify-content-between">
                                    <?php if (isset($order->invoice_number)) { ?>
                                        <a class="btn btn-light-primary font-weight-bold" target="_blank" href="<?php echo Yii::app()->createUrl('invoice/Generateinvoice/'.$order->order_info_id); ?>" >Invoice</a>
                                        <a class="btn btn-primary font-weight-bold" target="_blank" href="<?php echo Yii::app()->createUrl('invoice/View/'.$order->order_info_id); ?>" >Print Invoice</a>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>