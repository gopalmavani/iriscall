<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/wizard/steps.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.css');
?>
<?php
$user_country = $user['country'];
if (!empty($user_country)) {
    $personal_vat = Countries::model()->findByPk($user_country)->personal_vat;
} else {
    $personal_vat = 0;
}
?>
<style type="text/css">
    label {
        padding-right: 30px;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body wizard-content">
                <form action="#" class="pending-order-validation-wizard wizard-circle" id="pending-order">
                    <h6 class="section_1">Product details</h6>
                    <section class="section_1">
                        <div class="row">
                            <div class="col-lg-12">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Column -->
                            <div class="col-lg-4 col-xlg-3">
                                <div class="card-body bg-grey text-center">
                                    <img id="step2_prd_img" src="<?= Yii::app()->baseUrl . $product->image; ?>"
                                         class="img-responsive"/>
                                    <div class="product-dt">
                                        <h2 class="bold pink" id="step2_prd_h2"><?= $product->name . ' '; ?></h2>
                                        <p><span class="new-price"
                                                 id="step2_prd_price">&euro;<?= $product->price; ?></span>VAT Excl.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->
                            <div class="col-lg-8 col-xlg-9">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs profile-tab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#pro-info"
                                                            role="tab">Product Information</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#specific"
                                                            role="tab">Specifications</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="pro-info" role="tabpanel">
                                        <div class="card-body">
                                            <h4 class="f20">Consise specifications</h4>
                                            <ul class="list2">
                                                <li>One license is required for each €50 in trading with partners</li>
                                                <li>It activates a cashback node in the CBM cashback algorithm</li>
                                                <li>The license will stay valid regardless of whether your trading capital is active or not</li>
                                            </ul>
                                            <hr/>

                                            <h4 class="f20">Description</h4>
                                            <p>CBM Cashback licenses activate nodes in the CBM cashback matrix.
                                                CBM has developed a proprietary cashback algorithm that optimally
                                                distributes commissions earned from the trading venues where trading
                                                capital is traded.
                                            </p>
                                            <p>Buying a license is not sufficient to receive cashback.
                                                A adjoining trading capital of €50 initial deposit or purchase is required to active the node.
                                            </p>

                                            <hr/>
                                            <h4 class="f20">Price</h4>
                                            <p>
                                                The price for one license is €5 excluding VAT, as a one time payment.
                                            </p>
                                            <p>
                                                CBM offers very nice discounts of up to 40% when buying in bulk. Details
                                                of these discounts can be found on the next page
                                            </p>
                                        </div>
                                    </div>
                                    <!--second tab-->
                                    <div class="tab-pane" id="specific" role="tabpanel">
                                        <div class="card-body">
                                            <h3 class="f20">Currently supported products</h3>
                                            <h4 class="f20">Currency Pairs</h4>
                                            <table class="table table-striped">
                                                <tbody>
                                                <tr>
                                                    <td width="35%"><strong>USD/CHF</strong></td>
                                                    <td width="65%"></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%"><strong>EUR/GBP</strong></td>
                                                    <td width="65%"></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%"><strong>EUR/USD</strong></td>
                                                    <td width="65%"></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%"><strong>USD/CAD</strong></td>
                                                    <td width="65%"></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%"><strong>GBP/CAD</strong></td>
                                                    <td width="65%"></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%"><strong>NZD/USD</strong></td>
                                                    <td width="65%"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <h4 class="f20">Indices</h4>
                                            <table class="table table-striped">
                                                <tbody>
                                                <tr>
                                                    <td width="35%"><strong>XAG/USD</strong></td>
                                                    <td width="65%"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </section>
                    <h6 class="section_2">Buy License</h6>
                    <section class="section_2">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="trading_capital">
                                    <thead>
                                    <tr>
                                        <th>Cluster</th>
                                        <th>License Cost (Excl. VAT)</th>
                                        <th>Price Per License</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($product_pricing as $value) { ?>
                                        <tr data-step="<?= $value['id']; ?>">
                                            <td>
                                                <input name="group1" type="radio"
                                                       id="<?= "grp1_radio_" . $value['id']; ?>"
                                                       class="grp1_radio" value="<?= $value['licenses']; ?>">
                                                <span style="margin: 27px;">
                                                <?= $value['licenses']; ?>
                                            </span>
                                            </td>
                                            <td class="grp2_<?= $value['id']; ?>">
                                                &euro;<?= $value['licenses'] * $value['price_per_license']; ?>
                                            </td>
                                            <td class="grp2_<?= $value['id']; ?>">
                                                &euro;<?= $value['price_per_license']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-scrollable">
                                <table class="table table-striped  my-order max900 its-sticky">
                                    <thead>
                                    <tr>
                                        <th width="40%">Product</th>
                                        <th width="30%">Quantity</th>
                                        <th width="20%" align="right">Unit Price</th>
                                        <th width="10%" align="right">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="order-pro">
                                                <img src="<?= Yii::app()->baseUrl . $product->image; ?>" width="80">
                                                <div class="order-dt">
                                                    <h3 class="pink m-0"><strong><?= $product->name . ' '; ?></strong></h3>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input id="input_qty" type="number" value="0"
                                                               name="input_qty"
                                                               data-bts-button-down-class="btn btn-secondary btn-outline"
                                                               data-bts-button-up-class="btn btn-secondary btn-outline">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6" style="margin-top: 10px;">license</div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </td>
                                        <td id="product_price_step_3_2">&euro;<?= $product['price']; ?></td>
                                        <td id="total_product_price_step_3_2">&euro;5</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    <h6 class="section_3">Verify</h6>
                    <section class="section_3">
                        <div class="row">
                            <div class="col-lg-6">
                                <h2 class="mb-3">Billing details</h2>
                                <div class="form-check" style="margin-top: 20px;">
                                    <label class="custom-control custom-radio">
                                        <input id="radio4" name="address" type="radio" class="custom-control-input"
                                            <?php if (empty($user->vat_number)) { echo "checked";} ?> value="personal">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"
                                              style="font-size: 16px"><h4>Personal</h4></span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="radio4" name="address" type="radio" class="custom-control-input"
                                               <?php if (!empty($user->vat_number)) { echo "checked";} ?> value="business">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"
                                              style="font-size: 16px"><h4>Business</h4></span>
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
                                                        <input type="text" name="building_num"
                                                               value="<?php echo $user->building_num ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">Street</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="street"
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
                                                        <input type="text" name="region"
                                                               value="<?php echo $user->region ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">City</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="city" value="<?php echo $user->city ?>"
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
                                                        <input type="text" name="postcode"
                                                               value="<?php echo $user->postcode ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">Country</label>
                                                    <div class="col-sm-12">
                                                        <select name="country" id="personal-country-select"
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
                                                        <input type="text" name="business_name"
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
                                                        <input type="text" name="vat_number"
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
                                                        <input type="text" name="busAddress_building_num"
                                                               value="<?php echo $user->busAddress_building_num ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">Street</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="busAddress_street"
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
                                                        <input type="text" name="busAddress_region"
                                                               value="<?php echo $user->busAddress_region ?>"
                                                               class="form-control form-control-line">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6">City</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="busAddress_city"
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
                                                        <input type="text" name="busAddress_postcode"
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
                                                                class="form-control form-control-line">
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
                                <table class="table table-striped  my-order" width="100%" border="0" cellspacing="0"
                                       cellpadding="0">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="order-pro">
                                                <img id="step4_prd_img"
                                                     src="<?= Yii::app()->baseUrl . $product->image; ?>" width="80">
                                                <div class="order-dt">
                                                    <h3 class="pink m-0"><strong><span
                                                                id="step4_prd_h3"><?= $product->name . ' '; ?>
                                                                </span></strong></h3>
                                                </div>
                                            </div>
                                        </td>
                                        <td id="checkout-qty">1</td>
                                        <td><strong class="bold" id="checkout-total">€2,5</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="sub-total bill" width="310" border="0" cellspacing="0" cellpadding="0">
                                    <tr class="row-discount">
                                        <td>Discount:</td>
                                        <td><strong id="Discount">€</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Subtotal:</td>
                                        <td><strong id="check-subtotal">€</strong></td>
                                    </tr>
                                    <tr>
                                        <td id="vat_percent_html_step4">VAT :</td>
                                        <td><strong id="vat_amount_html_step4">€</strong></td>
                                    </tr>
                                    <tr class="total">
                                        <td><h3>Total Amount:</h3></td>
                                        <td><h3 class="pink"><strong id="total_amount_html_step4">€6,5</strong></h3>
                                        </td>
                                    </tr>
                                </table>
                                <div class="clearfix"></div>
                                <br>
                                <p class="muted" style="font-size: small">
                                    I agree that the service implementation can start immediately
                                    after I have made my payment and therefore I waive the right to ask for a refund.
                                    More details in the <a target="_blank"
                                                           href="<?= Yii::app()->getBaseUrl(true) . '/Legal/terms-conditions.html'; ?>">Terms
                                        & Conditions - Refund Policy</a></p>
                                <div class="terms-bl">
                                    <div class="checkbox checkbox-success">
                                        <input id="checkbox1" type="checkbox" name="terms">
                                        <label for="checkbox1"> I agree to the Terms and Conditions</label>
                                    </div>
                                    <div class="checkbox checkbox-success">
                                        <input id="checkbox2" type="checkbox" name="service">
                                        <label for="checkbox2"> I Agree To the Refund Policy </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <input type="hidden" class="ignore" name="product_id" id="product_id" value="">
                    <input type="hidden" class="ignore" name="quantity" id="license_num" value="">
                    <input type="hidden" class="ignore" name="base_price" id="base_price" value="">
                    <input type="hidden" class="ignore" name="sale_price" id="sale_price" value="">
                    <input type="hidden" class="ignore" name="vat_amount" id="vat_amount_form" value="">
                    <input type="hidden" class="ignore" name="order_total" id="order_total" value="">
                    <input type="hidden" class="ignore" name="discount" id="total_discount" value="">
                    <input type="hidden" class="ignore" name="net_total" id="net_total" value="">
                    <input type="hidden" class="ignore" name="payable_amount" id="payable_amount" value="">
                    <input type="hidden" class="ignore" name="payment_reference_id" id="payment_reference_id" value="">
                    <input type="hidden" class="ignore" name="order_origin" id="" value="user">
                    <input type="hidden" class="ignore" name="vat_percentage" id="vat_percent_form" value="">
                    <input type="hidden" class="ignore" name="order_comment" id="order_comment" value="">
                    <input type="hidden" class="ignore" name="payment" id="payment" value="Reserved-Pending">
                </form>
            </div>
        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/jquery.steps.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/steps.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/jquery.validate.min.js', CClientScript::POS_END);
?>
<script src="<?= Yii::app()->baseUrl . '/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js' ?>"></script>
<script src="<?= Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.min.js' ?>"></script>
<script type="text/javascript">
    var body = $('body');
    var discount = 0;
    var base_price = "<?= $product->price; ?>";
    var sub_total = vat_amount = net_total = base_total = base_discount = discount = 0;
    var vat_percent = "<?= $personal_vat; ?>";
    var product_id = "<?= $product->product_id; ?>";
    $(document).ready(function () {

        //Default licensenum is 1
        $("#grp1_radio_1").prop("checked", true);
        licenseNum = 1;
        touchSpinLicenseChange(licenseNum);

        $("input[name='input_qty']").TouchSpin({
            min: 1,
            max: 255
        });

        $("input[name='input_qty']").on('touchspin.on.stopspin', function () {
            licenseNum = $(this).val();
            touchSpinLicenseChange(licenseNum);
        });
    });

    body.on('input', '#input_qty', function () {
        licenseNum = $(this).val();
        if(licenseNum > 255){
            licenseNum = 255;
            $('#input_qty').val(licenseNum);
            toastr.warning('Maximum 255 licenses are allowed in a pending order');
        }
        touchSpinLicenseChange(licenseNum);
    });

    body.on('change', 'input[type=radio][name=group1]', function () {
        licenseNum = $(this).val();
        touchSpinLicenseChange(licenseNum);
    });

    function touchSpinLicenseChange(licenseCount) {
        var getLicensePriceUrl = "<?= Yii::app()->createUrl('product/getLicensePrice'); ?>";
        //To get valid license_pricing id as per the input license quantity
        $.ajax({
            type: "POST",
            url: getLicensePriceUrl,
            data: {
                "licenseNum": licenseCount
            },
            success: function (data) {
                dt = JSON.parse(data);
                window.sale_price = dt.product_price;

                $("input[name='input_qty']").val(licenseCount);
                $('#product_price_step_3_2').html('&euro;' + window.sale_price);
                $('#total_product_price_step_3_2').html('&euro;' + (window.sale_price * licenseCount));

                $('#checkout-qty').val(licenseCount);
                updateFinalDetails();
            }
        });
    }

    $('#personalAddDetail').show();
    $('#businessAddDetail').hide();

    body.on('change', 'input[name=address]', function () {
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
                vat_percent = data;
            }
        });
        updateFinalDetails();
    }

    function updateFinalDetails() {
        base_discount = parseFloat(base_price) - parseFloat(window.sale_price);
        discount = parseFloat(base_discount) * parseFloat(licenseNum);
        base_total = parseFloat(licenseNum) * parseFloat(base_price);
        sub_total = parseFloat(base_total) - parseFloat(discount);
        vat_amount = (sub_total * vat_percent / 100).toFixed(2);
        net_total = (parseFloat(sub_total) + parseFloat(vat_amount)).toFixed(2);

        $('#Discount').html('€' + discount);
        $('#checkout-qty').html(licenseNum);
        $('#check-subtotal').html('€' + sub_total);
        $('#vat_amount_html_step4').html('€' + vat_amount);
        $('#vat_percent_html_step4').html('VAT :'+vat_percent+'%');
        $('#checkout-total').html('€' + base_price*licenseNum);
        $('#total_amount_html_step4').html('€' + net_total);

        //Set Values in the form
        //Form details that will be used for adding to database
        $('#vat_amount_form').val(vat_amount);
        $('#product_id').val(product_id);
        $('#order_total').val(base_total);
        $('#total_discount').val(discount);
        $('#net_total').val(net_total);
        $('#payable_amount').val(net_total);
        $('#vat_percent_form').val(vat_percent);
        $('#license_num').val(licenseNum);
        $('#base_price').val(base_price);
        $('#sale_price').val(window.sale_price);
    }
</script>
