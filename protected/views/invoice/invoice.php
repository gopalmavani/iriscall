<div class="bg-image">
    <div class="bg-primary-dark-op">
        <section class="content content-full content-boxed overflow-hidden">
            <!-- Section Content -->
            <div class="push-30-t push-30 text-center">
                <h1 class="h2 text-white push-10 visibility-hidden" data-toggle="appear" data-class="animated fadeInDown"><i class="fa fa-check text-success"></i> Payment Successful</h1>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
</div>
<div style=" padding-top: 35px;" class="row">
    <div class="col-md-8 col-md-offset-2">

        <?php
        if ($data == 0) { ?>
            <div class="block">
                <div class="block-content block-content-narrow">
                    <div class="h1 text-center push-30-t push-30 hidden-print">NO INVOICE FOUND</div>
                    <hr class="hidden-print">

                </div>
            </div>
            <?php
        } else {
            $id = $data['orderInfo']->order_info_id;
            ?>
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <a type="button" href="<?php echo Yii::app()->createUrl('invoice/Generateinvoice/' . $id); ?>"><i
                                        class="fa fa-download"></i> Download
                                Invoice
                            </a>
                        </li>
                        <li>
                            <button type="button" onclick="App.initHelper('print-page');"><i class="si si-printer"></i> Print
                                Invoice
                            </button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Invoice Number : #<?php echo $data['orderInfo']->invoice_number; ?></h3>
                </div>
                <div class="block-content block-content-narrow">
                    <div class="h1 text-center push-30-t push-30 hidden-print">INVOICE</div>

                    <table class="table">
                        <!-- Company Info -->
                        <tr class="table-row">
                            <td class="table-data1">
                                <p class="h2 font-w400 push-5">Company</p>
                                <address>
                                    Address<br>
                                    Town/City<br>
                                    Region, Zip/Postal Code<br>
                                    <i class="si si-call-end"></i> (000) 000-0000
                                </address>
                            </td>
                            <td class="table-data2" align="right">
                                <p class="h2 font-w400 push-5"><?php echo $data['userInfo']->full_name; ?></p>
                                <address>
                                    Address<br>

                                    <?php echo $data['orderInfo']->city; ?><br>
                                    <?php echo $data['orderInfo']->region; ?>, <?php echo $data['orderInfo']->postcode; ?><br>
                                    <i class="si si-call-end"></i> <?php echo $data['userInfo']->phone; ?>
                                </address>
                            </td>
                        </tr>
                    </table>

                    <table class="table">
                        <!-- Company Info -->
                        <tr class="table-row">
                            <td class="table-data1">
                                <h4 class="font-w600 push-5">Order Details</h4>
                                <address>
                                    <b>OrderID</b> : <?php echo $data['orderInfo']->order_id; ?><br>
                                    <b>Order Date</b> : <?php echo $data['orderInfo']->created_date; ?><br>
                                    <b>Invoice number</b> : <?php echo $data['orderInfo']->invoice_number; ?><br>
                                    <b>Invoice Date</b> : <?php echo $data['orderInfo']->invoice_date; ?><br>
                                </address>
                            </td>
                            <td class="table-data2" align="right">
                                <h4 class="font-w600 push-5">Payment Details</h4>
                                <address>
                                    <b>Payment mode</b> : <?php print_r($data['orderPayment']->transaction_mode); ?><br>
                                    <b>Payment Reference ID</b> : <?php echo $data['orderPayment']->payment_ref_id; ?><br>
                                </address>
                            </td>
                        </tr>
                    </table>

                    <!-- Table -->
                    <div class="table-responsive push-50">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;"></th>
                                <th>Product</th>
                                <th class="text-center" style="width: 100px;">Quantity</th>
                                <th class="text-right" style="width: 120px;">Unit</th>
                                <th class="text-right" style="width: 120px;">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            foreach ($data['orderLineitem'] as $item) {
                                $i++;
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i;?></td>
                                    <td>
                                        <p class="font-w600 push-10"><?php
                                            //                                    $product = ProductInfo::model()->findByAttributes(['product_id' => $item->product_id ]);
                                            echo $item->product_name;
                                            ?> </p>
                                        <!--<div class="text-muted">Design/Development of iOS and Android application</div>-->
                                    </td>
                                    <td class="text-center"><?php echo $item->item_qty ?></td>
                                    <td class="text-right">$<?php echo $item->item_price ?></td>
                                    <?php $total_amount = $item->item_qty * $item->item_price ?>
                                    <td class="text-right">$ <?php echo $total_amount; ?> </td>
                                </tr>
                                <?php
                                $subtotal[] = $total_amount;
                            }
                            ?>
                            <tr>
                                <td colspan="4" class="font-w600 text-right">Subtotal</td>
                                <td class="text-right">$ <?php print_r(array_sum($subtotal)); ?> </td>
                            </tr>
                            <?php
                            $vat_due = array_sum($subtotal) * $data['orderInfo']->vat / 100;
                            ?>
                            <tr>
                                <td colspan="4" class="font-w600 text-right">Vat Rate</td>
                                <td class="text-right"><?php echo $data['orderInfo']->vat; ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="font-w600 text-right">Vat Due</td>
                                <td class="text-right">$ <?php echo $vat_due; ?> </td>
                            </tr>
                            <?php $total = array_sum($subtotal) + $vat_due; ?>
                            <tr class="active">
                                <td colspan="4" class="font-w700 text-uppercase text-right">Total</td>
                                <td class="font-w700 text-right">$ <?php echo $total; ?> </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="hidden-print">
                    <p class="text-muted text-center">
                        <small>Thank you very much for doing business with us.</small>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
