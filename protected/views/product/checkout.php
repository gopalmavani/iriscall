<?php
$this->pageTitle = "Order";
?>
<div class="row">
    <div class="col-md-8">
        <div class="card ribbon-wrapper">
            <div class="ribbon ribbon-success">
                Order Details
            </div>
            <div class="ribbon-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td style="border: 0">Description</td>
                                <td align="right" style="border: 0">Price</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-md-2"><img src="<?= Yii::app()->getbaseUrl().$product['image']; ?>" style="width: inherit"></div>
                                        <div class="col-md-4">
                                            <strong><?= $product['name'].' License'; ?></strong>
                                            <br><?= $product['short_description']; ?>
                                        </div>
                                    </div>
                                </td>
                                <td align="right">
                                    <strong>&euro;<?= $product['price']; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border"></td>
                                <td align="right">
                                    <div class="row">
                                        <div class="col-md-6" style="margin-top: 7px"><strong>Quantity</strong></div>
                                        <div class="col-md-6">
                                            <input type="number" id="quantity-text" min="1" class="form-control" value="1">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border"></td>
                                <td align="right">
                                    <!--<div class="row">
                                        <div class="col-md-6" style="margin-top: 7px"><strong>Total</strong></div>
                                        <div class="col-md-6">
                                            &euro;<span class="total"></span>
                                        </div>
                                    </div>-->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-success">
                Billing Details
            </div>
            <div class="ribbon-content">
                <div class="btn-group bootstrap-select">
                    <button type="button" class="btn dropdown-toggle btn-primary" data-toggle="dropdown" role="button" title="Select Billing Address" style="width: 100%;" aria-expanded="false">
                        <span id="drop-down-btn-span" class="filter-option pull-left">Select Billing Address</span>
                        <span class="bs-caret">
                            <span class="caret" style="margin-right: 115px"></span>
                        </span>
                    </button>
                    <ul id="addr" class="dropdown-menu" style="width: 100%">
                        <li id="personal"><a href="#">Personal Address</a></li>
                        <?php if($isBusinessEnabled == 1) { ?>
                            <li id="business"><a href="#">Business Address</a></li>
                        <?php }?>
                    </ul>
                </div>
                <div id="address" class="portlet-light" style="display: none; margin-top: 20px;">
                </div>
            </div>
        </div>
        <div class="card card-outline-success">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Amount Details</h4>
            </div>
            <div class="card-body">
                <table width="100%" class="table sub-total-table" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="no-top-border">Price</td>
                        <td style="text-align: right" class="no-top-border">€<span class="price total"></span></td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td style="text-align: right">-€<span class="price discount">0</span></td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td style="text-align: right">€<span class="price subtotal">0</span></td>
                    </tr>
                    <tr>
                        <td>VAT@<span class="vat-percentage">0</span>%</td>
                        <td style="text-align: right">€<span class="vatPrice">0</span></td>
                    </tr>
                    <tr style="color: brown">
                        <td> Total Amount </td>
                        <td style="text-align: right">€<strong class="amount-payable">0</strong></td>
                    </tr>
                    <tfoot>
                    <tr>
                        <td class="no-top-border" colspan="2">
                            <p class="muted" style="font-size: small">I agree that the service implementation can start immediately
                                after I have made my payment and therefore I waive the right to ask for a refund.
                                More details in the <a target="_blank" href="<?= Yii::app()->getBaseUrl(true) . '/Legal/terms-conditions.html'; ?>">Terms & Conditions - Refund Policy</a></p>
                            <div class="checkbox checkbox-success">
                                <input id="terms-checkbox" type="checkbox">
                                <label for="terms-checkbox">I agree to Terms and Conditions</label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="refund-checkbox" type="checkbox">
                                <label for="refund-checkbox">I agree to the Refund Policy</label>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                <button onclick="toggleModal()" id="buyNowPop" type="button" data-toggle="modal" class="btn waves-effect waves-light btn-rounded btn-success">Place order and make Payment</button></div>
            </div>
        </div>
    </div>
</div>
<div id="checkout-pop" class="modal fade show" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Time To Pay</h4>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table width="100%" class="table pack-shipping max400" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="pack-dt no-top-border" width="50%"><span style="font-weight: 500; color: black"><?= $product['name']; ?></span></td>
                                <td width="20%" align="right" class="no-top-border">€<span style="font-weight: 500; color: black" class="total"></span></td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td style="text-align: right">-€<span class="price discount"></span></td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>
                                <td style="text-align: right">€<span class="price subtotal"></span></td>
                            </tr>
                            <tr>
                                <td>VAT@<span class="vat-percentage">0</span>%</td>
                                <td style="text-align: right">€<span class="vatPrice">0</span></td>
                            </tr>
                            <tr style="color: brown">
                                <td>Total Amount</td>
                                <td style="text-align: right">€<span class="amount-payable">0</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Payment Method</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check">
                                <?php
                                $i = 0;
                                foreach ($payments as $payment) {
                                    $i++; ?>
                                        <label class="custom-control custom-radio">
                                            <input id="radio<?php echo $i; ?>" name="paymentOptions" value="<?php echo $payment->gateway; ?>" type="radio" class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description"><?php echo $payment->gateway; ?></span>
                                        </label>
                                <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="proceed" class="btn btn-primary" style="display: none;">Proceed</button>
                <button type="button" class="btn btn-info waves-effect modal-close" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="bank-pop" class="modal fade show" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Bank Details</h4>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p>Please deposit the license amount of <strong>€<span class="amount-payable">0</span></strong> to</p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p>
                                        <strong>Account No. EURO:</strong> 0689 0467 8308<br/>
                                        <strong>IBAN EURO:</strong> BE63 0689 0467 8308<br/>
                                        <strong>Swift/BIC Code:</strong> GKCCBEBB<br/>
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <p>
                                        <strong>Beneficiary Bank:</strong> <br/>
                                        Belfius Bank SA/NV<br/>
                                        Boulevard Pachecho 44<br/>
                                        1000 Brussels<br/>
                                        BELGIUM<br/>
                                    </p>        
                                </div>
                            </div>
                        <p>Please make sure to put the following information in your payment    reference:<br/>
                            <strong>Reference:</strong> Full name - product license - registered email address<br/>
                            <strong>Example:</strong> John Doe - CBM Global - johndoe@mail.com
                        </p>
                     
                        <p>
                            <strong>Attention:</strong><br/>
                        <ol class="bank-terms text-muted">
                            <li>We only accept bank transfers in EURO.<br/></li>
                            <li>The principal pays the costs (OUR), meaning you pay all the charges applying to the transaction.<br/></li>
                            <li>Bank transfers take approximately 3 to 5 business days to process.</li>
                            <li>Once we receive the money and the order is approved, notifications and fulfilment actions get triggered.</li>
                        </ol>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="bank-proceed" class="btn btn-primary">Proceed</button>
                <button type="button" class="btn btn-info waves-effect modal-close" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<form method="post" action="<?php echo Yii::app()->params['ingenicoUrl']; ?>" id='form1' name='form1'>
    <!-- general parameters: see Form parameters -->
    <input type="hidden" name="PSPID" value="<?= Yii::app()->params['PSPID'];?>">
    <input type="hidden" name="ORDERID" value="<?php echo $orderId; ?>">
    <input type="hidden" name="AMOUNT" value="" id="injenico_amount">
    <input type="hidden" name="CURRENCY" value="EUR">
    <input type="hidden" name="LANGUAGE" value="EN">
    <input type="hidden" name="CN" value="<?php echo $userDetail['full_name']; ?>">
    <input type="hidden" name="EMAIL" value="<?php echo $userDetail['email']; ?>">
    <input type="hidden" name="OWNERZIP" value="">
    <input type="hidden" name="OWNERADDRESS" value="">
    <input type="hidden" name="OWNERCTY" value="">
    <input type="hidden" name="OWNERTOWN" value="">
    <input type="hidden" name="OWNERTELNO" value="">
    <input type="hidden" name="ITEMNAME1"value="<?= $product['name']; ?>">
    <input type="hidden" name="TITLE" value="CBM Global Payment Confirmation">
    <!-- post payment redirection: see Transaction feedback to the customer -->
    <input type="hidden" name="ACCEPTURL"
           value="<?php echo Yii::app()->createUrl('order/success'); ?>">
    <input type="hidden" name="DECLINEURL"
           value="<?php echo Yii::app()->createUrl('order/decline'); ?>">
    <input type="hidden" name="EXCEPTIONURL"
           value="<?php echo Yii::app()->createUrl('order/exception'); ?>">
    <input type="hidden" name="CANCELURL"
           value="<?php echo Yii::app()->createUrl('order/cancel'); ?>">
    <input type="submit" value="" id="submitInjenico" name=submit2 style="display: none">
</form>
<script>
    var user = JSON.parse('<?php echo json_encode($userDetail); ?>');
    var product = JSON.parse('<?php echo json_encode($product); ?>');
    var addOrder = '<?php echo Yii::app()->createUrl('order/AddOrder')?>';
    var orderId = '<?= $orderId; ?>';
    var salePrice = product.sale_price;
    var remainingPrice = product.price - salePrice;
    var qty = parseInt($('#quantity-text').val());
    var total = qty*product.price;
    var discount = qty*remainingPrice;
    var addressId = '';
    $('.total').html(total);
    $('.discount').html(discount);
    $('.subtotal').html(total-discount);
    $('.amount-payable').html(total-discount);

    $('#quantity-text').on('input',function (data) {
        qty = parseInt($('#quantity-text').val());
        var total = qty*product.price;
        var discount = qty*remainingPrice;
        $('.total').html(total);
        $('.discount').html(discount);
        $('.subtotal').html(total-discount);
        updatePrice();
    });

    $('.subtotal').on('DOMSubtreeModified',function () {
        updatePrice();
    });

    function toggleModal() {
        if(($('#terms-checkbox').prop('checked')) && ($('#refund-checkbox').prop('checked')) &&
            (($('#drop-down-btn-span').html() == 'Personal Address') || ($('#drop-down-btn-span').html() == 'Business Address'))){
            $('#checkout-pop').modal('toggle');
        }else{
            var address = $('#address').html();
            if(!address)
            {
                toastr.error('Please Select Address type.', 'Error!');  
            }
            if($('#refund-checkbox').prop('checked') == false)
            {
                toastr.error('Please Select Refund Policy.', 'Error!');
            }
            if($('#terms-checkbox').prop('checked') == false)
            {
                toastr.error('Please Select terms-conditions.', 'Error!');
            }
        }
    }
    
    //for the if only one address available to select default direct.

    $('#addr li > a').ready(function() {
       <?php if($isBusinessEnabled == 0) { ?>
            var id = 'personal';
       <?php }else{?>
        var id = $(this).parent().attr('id');
        <?php } ?>
        var subtotal = parseFloat($('.subtotal').html());
        var add = '';
        if(id == 'personal'){
            add += '<span style="font-weight: 700">' + user.full_name + '</span></br>';
            add += user.street  + ' ' + user.region + ',</br>';
            add += user.city  + '-' + user.postcode + ',</br>';
            add += '<?= ServiceHelper::getCountryNameFromId($userDetail['country']) ; ?>';
            vat = parseFloat('<?= Countries::model()->findByPk($userDetail['country'])->personal_vat; ?>');
            addressId = 1;
            $('.vat-percentage').html(vat);
            /*if(($('#terms-checkbox').prop('checked')) && ($('#refund-checkbox').prop('checked'))){
                $('#buyNowPop').removeClass('disabled');
            }*/
            $('#drop-down-btn-span').html("Personal Address");
            updatePrice();
        }
        $('#address').html(add);
        $('#address').css('display','block'); 
    });


    $('#addr li > a').click(function() {
        var id = $(this).parent().attr('id');
        var subtotal = parseFloat($('.subtotal').html());
        var add = '';
        if(id == 'personal'){
            add += '<span style="font-weight: 700">' + user.full_name + '</span></br>';
            add += user.street  + ' ' + user.region + ',</br>';
            add += user.city  + '-' + user.postcode + ',</br>';
            add += '<?= ServiceHelper::getCountryNameFromId($userDetail['country']) ; ?>';
            vat = parseFloat('<?= Countries::model()->findByPk($userDetail['country'])->personal_vat; ?>');
            addressId = 1;
            $('.vat-percentage').html(vat);
            /*if(($('#terms-checkbox').prop('checked')) && ($('#refund-checkbox').prop('checked'))){
                $('#buyNowPop').removeClass('disabled');
            }*/
            $('#drop-down-btn-span').html("Personal Address");
            updatePrice();
        } else {
            if(user.business_name != ''){
                add = '';
                add += '<span style="font-weight: 700">'+ user.business_name +'</span></br>';
                add += user.busAddress_street +' '+ user.busAddress_region + ',</br>';
                add += user.busAddress_city +'-'+ user.busAddress_postcode + ',</br>';
                add += '<?= ServiceHelper::getCountryNameFromId($userDetail['busAddress_country']); ?>';
                vat = parseFloat('<?= Countries::model()->findByPk($userDetail['country'])->business_vat; ?>');
                addressId = 2;
                $('.vat-percentage').html(vat);
                /*if(($('#terms-checkbox').prop('checked')) && ($('#refund-checkbox').prop('checked'))){
                    $('#buyNowPop').removeClass('disabled');
                }*/
                updatePrice();
            }
            $('#drop-down-btn-span').html("Business Address");
        }
        $('#address').html(add);
        $('#address').css('display','block');
    });

    $('input[type="radio"]').on('click', function(e) {
        $('#proceed').css('display','block');
    });

    $("#proceed").click(function () {
        if ($("input[name=paymentOptions]").is(':checked')) {
            var payment = $("input[name='paymentOptions']:checked").val();
            var total = parseFloat($('.total').html());
            var subtotal = parseFloat($('.subtotal').html());
            var vatPrice = parseFloat($('.vatPrice').html());
            var vat = parseFloat($('.vat-percentage').html());
            var netTotal = vatPrice+subtotal;
            var formdata = {
                'netTotal': netTotal,
                'vat-Amount': vatPrice,
                'amount': total,
                'subTotal':subtotal,
                'vat': vat,
                'order_id': orderId,
                'product_id': product.product_id,
                'quantity':qty,
                'price': product.price,
                'sale_price': product.sale_price,
                'address_id': addressId
            };
            if(payment == 'Ingenico'){
                formdata['type'] = payment;
                $.ajax({
                    type: "POST",
                    url: addOrder,
                    data: formdata,
                    beforeSend: function () {
                        $(".overlay").removeClass("hide");
                    },
                    success: function (data) {
                        //need to multiply netamount by 100 as per the requirement of Ogone
                        $('#injenico_amount').val((netTotal*100));
                        $('#submitInjenico').click();
                    }
                });
            } else if(payment == 'Bank Transfer'){
                $('#checkout-pop').modal('toggle');
                $('#bank-pop').modal('toggle');
            }
        }
    });

    $('#bank-proceed').click(function () {
        var total = parseFloat($('.total').html());
        var subtotal = parseFloat($('.subtotal').html());
        var vatPrice = parseFloat($('.vatPrice').html());
        var vat = parseFloat($('.vat-percentage').html());
        var netTotal = vatPrice+subtotal;
        var formdata = {
            'netTotal': netTotal,
            'vat-Amount': vatPrice,
            'amount': total,
            'subTotal':subtotal,
            'vat': vat,
            'order_id': orderId,
            'product_id': product.product_id,
            'quantity':qty,
            'price': product.price,
            'sale_price': product.sale_price,
            'address_id': addressId,
            'type': "Bank Transfer"
        };
        $.ajax({
            type: "POST",
            url: addOrder,
            data: formdata,
            beforeSend: function () {
                $(".overlay").removeClass("hide");
            },
            success: function (data) {
                $pendingUrl = '<?= Yii::app()->createUrl('order/detail').'/' ?>'+orderId;
                window.location = $pendingUrl;
                $('#bank-pop').modal('toggle');
            }
        });
    });

    function updatePrice(){
        var vat = parseFloat($('.vat-percentage').html());
        var subtotal = parseFloat($('.subtotal').html());
        var discount = parseFloat($('.discount').html());
        var vatAmt = subtotal * vat / 100;
        var netAmount = subtotal + vatAmt;
        $('.vat-percentage').html(vat);
        $('.vatPrice').html(vatAmt.toFixed(2));
        $('.amount-payable').html(netAmount.toFixed(2));
    }
</script>
