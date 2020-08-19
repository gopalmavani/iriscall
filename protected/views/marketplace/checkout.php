<?php
if(count($cartItem) < 1){
    $this->redirect(Yii::app()->createUrl('marketplace/index'));
}
$total = 0;
$cartAmountTotal = 0;
?>
<style>
    .my-order{
        margin-top: 10px;
        border: 1px solid #e9ecef;
    }
    .custom-control{
        padding-right: 1.5rem;
    }
    /*.kt-header-mobile--fixed img {
        width: auto !important;
        height: 80px !important;
    }*/
    .sub-total tr.total td {
        border-top: 1px solid #e9ecef !Important;
        padding-top: 8px !Important;
    }
</style>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

            <!-- begin:: Subheader -->
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-container kt-container--fluid ">
                    <div class="kt-subheader__main">
                        <h3 class="kt-subheader__title"> Market Place </h3>
                        <span class="kt-subheader__separator kt-hidden"></span>
                        <div class="kt-subheader__breadcrumbs"> <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a> <span class="kt-subheader__breadcrumbs-separator"></span> <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Checkout</span> </div>
                    </div>
                </div>
            </div>
            <!-- end:: Subheader -->
            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <!--Begin::Row-->
                <div class="row">
                    <div class="col-lg-12">
                        <form method="post" name="checkout_payment" id="checkout_payment" action="<?php echo Yii::app()->createUrl('marketplace/payment');?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <h2 class="mb-3">Billing details</h2>
                                <div class="form-check raadio-list" style="margin-top: 10px;margin-bottom: 10px;display: flex;">
                                    <label class="custom-control custom-radio">
                                        <input name="address" type="radio" class="custom-control-input"
                                            <?php if (empty($user->vat_number)) { echo "checked";} ?> value="personal">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"
                                              style="font-size: 16px">Personal</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="address" type="radio" class="custom-control-input"
                                            <?php if (!empty($user->vat_number)) { echo "checked";} ?> value="business">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"
                                              style="font-size: 16px">Business</span>
                                    </label>
                                </div>
                                <div id="personalAddDetail">
                                    <h3 class="bold blue m-0"><?php echo $user->full_name; ?></h3>
                                    <div class="personalAddressForm" style="margin-top: 15px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6" style="max-width: inherit">Building
                                                        Number</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="building_num" readonly
                                                               value="<?php echo $user->building_num ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">Street</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="street" readonly
                                                               value="<?php echo $user->street ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">Region</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="region" readonly
                                                               value="<?php echo $user->region ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">City</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="city" readonly value="<?php echo $user->city ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">Postcode</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="postcode" readonly
                                                               value="<?php echo $user->postcode ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">Country</label>
                                                    <div class="col-sm-12">
                                                        <select name="country" id="personal-country-select" readonly
                                                                class="form-control form-control-line">
                                                            <?php
                                                            $country = Yii::app()->ServiceHelper->getCountry(); ?>
                                                            <option value="">Select Country</option>
                                                            <?php foreach ($country as $key => $value) { ?>
                                                                <option value="<?php echo $key; ?>" <?php if ($user->country == $key) {
                                                                    echo "selected";
                                                                } ?>><?php echo $value ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="businessAddDetail">
                                    <h3 class="bold blue m-0"><?php echo $user->full_name; ?></h3>
                                    <div class="businessAddressForm" style="margin-top: 15px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6" style="max-width: inherit">Company
                                                        Name</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="business_name" readonly
                                                               value="<?php echo $user->business_name ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6" style="max-width: inherit">Vat
                                                        Number</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="vat_number" readonly
                                                               value="<?php echo $user->vat_number ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6" style="max-width: inherit">Building
                                                        Number</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="busAddress_building_num" readonly
                                                               value="<?php echo $user->busAddress_building_num ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">Street</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="busAddress_street" readonly
                                                               value="<?php echo $user->busAddress_street ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">Region</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="busAddress_region" readonly
                                                               value="<?php echo $user->busAddress_region ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">City</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="busAddress_city" readonly
                                                               value="<?php echo $user->busAddress_city ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">Post code</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="busAddress_postcode" readonly
                                                               value="<?php echo $user->busAddress_postcode ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">Country</label>
                                                    <div class="col-sm-12">
                                                        <select name="busAddress_country" id="business-country-select"
                                                                class="form-control form-control-line" readonly>
                                                            <?php
                                                            $country = Yii::app()->ServiceHelper->getCountry(); ?>
                                                            <option value="">Select Country</option>
                                                            <?php foreach ($country as $key => $value) { ?>
                                                                <option value="<?php echo $key; ?>" <?php if ($user->busAddress_country == $key) {
                                                                    echo "selected";
                                                                } ?>><?php echo $value ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div>
                                    <h2 class="mb-2">Delivery details</h2>
                                    <p> The Nautilus EA license is an automatic trading software licence for the forex
                                        market, in other words software, which means digital content on a non-material
                                        carrier. The service implementation will start immediately after payment.</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <table class="table table-striped cart-details-tb  my-order" width="100%" border="0" cellspacing="0"
                                       cellpadding="0" style="margin-top: 10px;border: 1px solid #e9ecef;">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th style="text-align: right;">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody id="checkout-body">
                                    <?php if(!empty($cartItem)){
                                        foreach ($cartItem as $cart) { ?>
                                            <?php $total += $cart['price']*$cart['qty']; ?>
                                            <?php $cartAmountTotal += $cart['amount']; ?>
                                            <tr>
                                                <td>
                                                    <div class="order-pro" style="display: inline-flex;">
                                                        <div style="padding: 5px;width: 80px;">
                                                            <img id="step4_prd_img" src="<?php echo Yii::app()->baseUrl . $cart['image']; ?>" style="width: auto !important; height: 80px !important;max-width: 75px !important;">
                                                        </div>
                                                        <div class="order-dt" style="padding: 25px 0px;">
                                                            <h3 class="pink m-0" style="font-size: 1.3rem;"><strong>
                                                                    <span id="step4_prd_h3"><?php echo $cart['name'] . ' '; ?></span></strong></h3>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="checkout-qty"><?= $cart['qty']; ?></td>
                                                <td style="text-align: right;"><strong class="bold" id="checkout-total">€ <?= $cart['qty']*$cart['price']; ?></strong></td>
                                            </tr>
                                    <?php }
                                    } ?>
                                    </tbody>
                                </table>
                                <table class="sub-total bill" style="width: 100%;text-align: right;"  border="0" cellspacing="0" cellpadding="0">
                                    <tr class="row-discount">
                                        <td>Discount:</td>
                                        <td><strong id="Discount">€ <?= round($total - $cartAmountTotal,2); ?></strong></td>
                                        <input type="hidden" name="discount" value="<?= $total - $cartAmountTotal; ?>">
                                    </tr>
                                    <!--<tr class="voucher-discount-row">
                                        <td>Voucher Discount:</td>
                                        <td><strong id="voucher_discount">€</strong></td>
                                    </tr>-->
                                    <tr>
                                        <td>Subtotal:</td>
                                        <td><strong>€ </strong><strong id="check-subtotal"><?= round($cartAmountTotal,2); ?></strong></td>
                                        <input type="hidden" name="subtotal" value="<?= $cartAmountTotal; ?>">
                                    </tr>
                                    <tr>
                                        <td id="vat_percent_html_step4">VAT :</td>
                                        <td><strong id="vat_amount_html_step4">€</strong></td>
                                        <input type="hidden" name="vat_amount" id="vat_amount" value="">
                                    </tr>
                                    <tr class="total">
                                        <td><h3>Total Amount:</h3></td>
                                        <td><h3 class="pink"><strong id="total_amount_html_step4">€6,5</strong></h3>
                                        </td>
                                        <input type="hidden" name="total" id="total_amount" value="">
                                    </tr>
                                </table>
                                <div class="clearfix"></div>
                                <br>

                                <p class="muted" style="font-size: small">
                                    I agree that the service implementation can start immediately
                                    after I have made my payment and therefore I waive the right to ask for a refund.
                                    More details in the <a target="_blank" href="<?= Yii::app()->getBaseUrl(true) . '/Legal/terms-conditions.html'; ?>">Terms
                                        & Conditions - Refund Policy</a></p>
                                <div class="terms-bl">
                                    <div class="checkbox checkbox-success">
                                        <!-- <label><input type="checkbox" name="checkbox_1" id="checkbox1"> I agree to the Terms and Conditions</label> -->
                                        <input id="checkbox1" type="checkbox" name="terms">
                                        <label for="checkbox1"> I agree to the Terms and Conditions</label>
                                    </div>
                                    <div class="checkbox checkbox-success">
                                        <!-- <label><input type="checkbox" name="checkbox_2" id="checkbox2"> I agree to the Second Terms and Conditions</label> -->
                                        <input id="checkbox2" type="checkbox" name="service">
                                        <label for="checkbox2"> I Agree To the Refund Policy </label>
                                    </div>
                                </div>
                                <br>
                                <div class="row pull-right" style="margin-bottom: -10px;">
                                    <button class="btn btn-primary btn-sm pull-right proceed_btn_form" type="submit">Proceed</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <!--End::Row-->

                <!--End::Dashboard 4-->
            </div>
            <!-- end:: Content -->
        </div>
    </div>
</div>

<script>
    var payable_amount = '';
    $(document).ready(function () {

        country_id = $('#business-country-select').val();
        vat_type = "business";
        calculateVat(country_id, vat_type);

        //For Personal country change
        $('#personal-country-select').on('change', function (e) {
            var country_id = this.value;
            var vat_type = "personal";
            calculateVat(country_id, vat_type);
        });

        //For Business country change
        $('#business-country-select').on('change', function (e) {
            var country_id = this.value;
            var vat_type = "business";
            calculateVat(country_id, vat_type);
        });

        //For Address related Changes
        var adds = $('input[name=address]:checked').val();
        //Show-Hide address details
        if (adds == 'personal') {
            $('#personalAddDetail').show();
            $('#businessAddDetail').hide();
        } else {
            $('#personalAddDetail').hide();
            $('#businessAddDetail').show();
        }

        $('input[name=address]').on('change', function (e) {
            var adds_type = $(this).val();
            if (adds_type == 'personal') {

                $('#personalAddDetail').show();
                $('#businessAddDetail').hide();
                $('.businessAddressForm input').addClass('ignore');
                $('.personalAddressForm input').removeClass('ignore');

                country_id = $('#personal-country-select').val();
                vat_type = "personal";

            } else if (adds_type == 'business') {

                $('#businessAddDetail').show();
                $('#personalAddDetail').hide();
                $('.personalAddressForm input').addClass('ignore');
                $('.businessAddressForm input').removeClass('ignore');

                country_id = $('#business-country-select').val();
                vat_type = "business";

            }
            calculateVat(country_id, vat_type);
        });

        $('#checkout_payment').on('submit', function() {

        });

        $("#checkout_payment").validate({
            ignore: ".ignore",
            errorClass: "text-danger",
            successClass: "text-success",
            highlight: function (element, errorClass) {
                $(element).addClass(errorClass);
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass)
            },
            errorPlacement: function (error, element) {
                error.insertBefore(element)
            },
            rules: {
                terms: {
                    required: true
                },
                service: {
                    required: true
                }
            },
            messages: {
                terms: 'Please agree to Terms and Conditions',
                service: 'Please agree to Refund policy'
            }
        });


    });


    //Ajax call to get vat details
    function calculateVat(country_id, vat_type) {
        var getVatUrl = "<?= Yii::app()->createUrl('product/getVatPercentage'); ?>";
        var vatdata = {
            'country_id': country_id,
            'vat_type': vat_type
        };
        $.ajax({
            type: "POST",
            url: getVatUrl,
            data: vatdata,
            success: function (data) {
                vat = data;
                vatUpdate(vat);
            }
        });
    }

    //Update all price related details
    function vatUpdate(vat_percent) {
        var sub_total = $('#check-subtotal').html();
        $('#vat_percent_html_step4').html('Vat@' + vat_percent + '%');
        vat_amt = (sub_total * vat_percent / 100).toFixed(2);

        if(vat_amt > 0){
            net_total = (parseFloat(sub_total) + parseFloat(vat_amt)).toFixed(2);
            //Update HTML and database values
            $('#vat_amount_html_step4').html('€ ' + vat_amt);
            $('#total_amount_html_step4').html('€' + net_total);
            $('#total_amount_pay').html('€' + net_total);
            $('#vat_amount_form').val(vat_amt);
            $('#vat_percent_form').val(vat_percent);
            $('#net_total').val(net_total);
            $('#vat_amount').val(vat_amt);
            $('#total_amount').val(net_total);

            //updateUserWalletRelatedDetails();
//            $('#injenico_amount').val(parseFloat((payable_amount * 100).toFixed(2)));
//            $('#amountPayable').html('€' + payable_amount);
        }else{
            net_total = (parseFloat(sub_total)).toFixed(2);
            $('#vat_amount_html_step4').html('€ ' + vat_amt);
            $('#total_amount_html_step4').html('€' + net_total);
            $('#total_amount_pay').html('€' + net_total);
            $('#vat_amount_form').val(vat_amt);
            $('#vat_percent_form').val(vat_percent);
            $('#net_total').val(net_total);
            $('#vat_amount').val(vat_amt);
            $('#total_amount').val(net_total);
        }
    }


</script>