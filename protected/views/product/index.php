<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/wizard/steps.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/icheck/skins/all.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.css');
?>
<style type="text/css">
    [type=radio]:not(:checked) + label {
        position: unset !important;
    }

    label {
        padding-right: 30px;
    }
    .customImg {
        top: -60px;
        height: 200px !important;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
    .card-outline-success .card-header {
        background: #056aaf;
        border-color: #056aaf;
    }
    .kt-container{
        font-size: 14px;
    }
    .customtab li a.nav-link.active {
        border-bottom: 2px solid #056aaf;
    }
    .order-dt{
        padding: 30px 0px !important;
    }
    .order-dt h3{
        font-size: 1.3rem !important;
    }
    .table thead th{
        font-size: 13px !important;
    }

</style>
<?php
$user_country = $user->country;
if (!empty($user_country)) {
    $personal_vat = Countries::model()->findByPk($user_country);
    if(empty($personal_vat)){
        $personal_vat = Countries::model()->findByPk($user_country);
    }else{
        $personal_vat = 0;
    }
} else {
    $personal_vat = 0;
}
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
                        <div class="kt-subheader__breadcrumbs"> <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a> <span class="kt-subheader__breadcrumbs-separator"></span> <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Products</span> </div>
                    </div>
                </div>
            </div>
            <!-- end:: Subheader -->
            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <div class="row wizard-content">
                    <form action="#" class="validation-wizard wizard-circle" id="order">
                        <!-- Step 2 -->
                        <h6 class="section_2">Product details</h6>
                        <section class="section_2">
                            <div class="products mb-5 mt-5">
                                <div class="selectproduct linkproduct" data-toggle="buttons" style="padding: 0 30px 30px 30px;">
                                    <?php if(!empty($product)){
                                        foreach ($product as $prod){ ?>
                                            <div class="btn">
                                                <div class="ribbon ribbon-top-right"><span>Default</span></div>
                                                <img src="<?php echo Yii::app()->baseurl.''.$prod['image']; ?>" class="img customImg" style="top: -60px !important; height: 200px !important;">
                                                <h6><?= $prod['name'] ?></h6>
                                                <p class="mb1"><?= $prod['description'] ?></p>
                                                <h3><?= $prod['price'] ?><sup class="font-size-h3 font-weight-normal pl-1">&euro;</sup></h3>
                                                <input type="checkbox" name="product" checked="checked">
                                                <button type="button" class="btn btn-primary" id="licenseBtn" onclick="addToCart(<?= $prod['product_id']; ?>,<?= $prod['price']; ?>)">Select Product</button>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="col-md-12 col-xxl-3 border-x-0 border-x-md border-y border-y-md-0">
                                            <div class="pt-30 pt-md-25 pb-15 px-5 text-center">
                                                <p class="mb-15 d-flex flex-column">
                                                    No products available
                                                </p>
                                            </div>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                        </section>
                        <!-- Step 3 -->
                        <h6 class="section_3.2">Buy license</h6>
                        <section class="section_3.2">
                            <div class="row" style="margin-bottom: 25px">
                                <div class="col-md-12">
                                    <img class="img-responsive discount_img"
                                         src="<?= Yii::app()->baseUrl . '/images/MMC-grid-license-pricing.png'; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-scrollable" style="width: 100%">
                                    <table class="table table-striped  my-order max900 cart-table">
                                        <thead>
                                        <tr>
                                            <th width="40%">Product</th>
                                            <th width="30%">Quantity</th>
                                            <th width="20%" align="right"> Unit Price</th>
                                            <!--<th width="20%" align="right"> Discount</th>-->
                                            <th width="10%" align="right">Sub Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                        <!-- Step 4 -->
                        <h6 class="section_4">Checkout</h6>
                        <section class="section_4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h2 class="mb-3">Billing details</h2>
                                    <div class="form-check raadio-list" style="margin-top: 10px;margin-bottom: 10px;display: flex;">
                                        <label class="custom-control custom-radio">
                                            <input name="address" type="radio" class="custom-control-input"
                                                <?php if (empty($user->vat_number)) { echo "checked";} ?> value="personal">
                                            <span></span>
                                            Personal
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
                                    <table class="table table-striped cart-details-tb  my-order" width="100%" border="0" cellspacing="0"
                                           cellpadding="0">
                                        <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th style="text-align: right;">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody id="checkout-body">
                                        <tr>
                                            <td>
                                                <div class="order-pro" style="display: inline-flex;">
                                                    <img id="step4_prd_img"
                                                         src="<?php //echo Yii::app()->baseUrl . $product->image; ?>" width="80" style="height: 80px !important;">
                                                    <div class="order-dt">
                                                        <h3 class="pink m-0"><strong><span
                                                                        id="step4_prd_h3"><?php //echo $product->name . ' '; ?>
                                                                </span></strong></h3>
                                                    </div>
                                                </div>
                                            </td>
                                            <td id="checkout-qty">1</td>
                                            <td style="text-align: right;"><strong class="bold" id="checkout-total">€2,5</strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="sub-total bill" style="width: 100%;text-align: right;"  border="0" cellspacing="0" cellpadding="0">
                                        <tr class="row-discount">
                                            <td>Discount:</td>
                                            <td><strong id="Discount">€</strong></td>
                                        </tr>
                                        <!--<tr class="voucher-discount-row">
                                            <td>Voucher Discount:</td>
                                            <td><strong id="voucher_discount">€</strong></td>
                                        </tr>-->
                                        <tr>
                                            <td>Subtotal:</td>
                                            <td><strong>€ </strong><strong id="check-subtotal"></strong></td>
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
                                    <!-- <button type="button" class="btn waves-effect waves-light btn-lg btn-block btn-success m-b-15">Place order and make payment</button>     -->
                                    <!-- <p>Clicking this button will make the order final.</p> -->
                                </div>
                            </div>
                        </section>
                        <!-- Step 5 -->
                        <h6 class="section_5">Payment</h6>
                        <section class="section_5">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h1 class="mb-3">Total Amount: <strong id="total_amount_pay"
                                                                           class="bold pink">€6,5</strong></h1>
                                </div>
                            </div>
                            <br>
                            <?php if ($total_available_balance > 0) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>Pay using your wallet</h2>
                                    </div>
                                    <?php if ($user_wallet_balance > 0) { ?>
                                        <div class="col-md-3">
                                            <div class="checkbox checkbox-success ">
                                                <input id="user_wallet_cbox" type="checkbox" name="user_wallet_cbox"
                                                       class="filled-in chk-col-indigo">
                                                <label for="user_wallet_cbox"> User Wallet (€<?= round($user_wallet_balance,2); ?>
                                                    )</label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!--<?php /*if ($reserve_wallet_balance > 0) { */?>
                                        <div class="col-md-3">
                                            <div class="checkbox checkbox-success ">
                                                <input id="reserve_wallet_cbox" type="checkbox" name="reserve_wallet_cbox"
                                                       class="filled-in chk-col-indigo">
                                                <label for="reserve_wallet_cbox"> Reserve Wallet
                                                    (€<?/*= round($reserve_wallet_balance, 2); */?>)</label>
                                            </div>
                                        </div>
                                    <?php /*} */?>-->
                                    <div class="col-md-6" id="remaining-payable-div">
                                        <h3 style="text-align: right; margin: 0">Additional Payable Amount: <strong
                                                    id="remaining_amount_pay" class="bold pink">€6,5</strong></h3>
                                    </div>
                                </div>
                            <?php } ?>
                            <hr>
                            <p id="label-express-payment">Go With Express Payment</p>
                            <div class="row" id="payment-section">
                                <div class="col-md-12" style="margin-bottom: 10px;">
                                    <h2>Payment Gateways</h2>
                                </div>
                                <div class="col-md-3">
                                    <!--<label class="custom-control custom-radio">
                                        <input  name="payment" type="radio" class="custom-control-input"
                                               checked="" value="ingenico">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"
                                              style="font-size: 16px"><h4>Online Payment</h4></span>
                                    </label>-->
                                    <label class="custom-control custom-radio">
                                        <input name="payment" type="radio" class="custom-control-input"
                                                checked="" value="stripe">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"
                                              style="font-size: 16px">Stripe Payment</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input  name="payment" type="radio" class="custom-control-input"
                                                value="paypal">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"
                                              style="font-size: 16px">Paypal</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input  name="payment" type="radio" class="custom-control-input"
                                                value="bank">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"
                                              style="font-size: 16px">Bank Transfer</span>
                                    </label>
                                </div>
                                <div class="col-lg-9">
                                    <!--<div id="ingenicoDetail">
                                    <table class="table table-striped  my-order max900">
                                        <tbody>
                                        <tr>
                                            <td colspan="2" style="text-align: center"><img src="<? /*= Yii::app()->baseUrl . '/images/paypal-logo.png'; */ ?>" class="img-responsive" style="max-width: 50% !important;"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>-->
                                    <div id="stripeDetail" class="card text-center card-outline-success">
                                        <div class="card-header text-white">
                                            Payment Information
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-tabs customtab" role="tablist" id="stripe-payment-methods">
                                                <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                        href="#card" data-name="card" role="tab"
                                                                        aria-expanded="false"><img
                                                                src="<?php echo Yii::app()->request->baseUrl ?>/images/card.png"
                                                                alt="homepage" style="max-width: 144px;"></a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                                                        href="#bancontact" data-name="bancontact" role="tab" aria-expanded="true">
                                                        <img src="<?php echo Yii::app()->request->baseUrl ?>/images/bancontact.png"
                                                                alt="homepage" style="max-width: 75px;"></a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#iDeal"
                                                                        data-name="iDeal" role="tab" aria-expanded="true">
                                                        <img src="<?php echo Yii::app()->request->baseUrl ?>/images/ideal.png"
                                                                alt="homepage" style="max-width: 125px;"></a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#giropay"
                                                                        data-name="giropay" role="tab" aria-expanded="false">
                                                        <img src="<?php echo Yii::app()->request->baseUrl ?>/images/Giropay.svg.png"
                                                                alt="homepage" style="max-width: 100px;"></a></li>
                                                <!--<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sofort" data-name = "sofort" role="tab" aria-expanded="true" style="padding: 0"><img src="<?php /*echo Yii::app()->request->baseUrl */ ?>/images/sofort.png" alt="homepage" style="max-width: 160px;"></a> </li>-->
                                            </ul>
                                            <div class="tab-content" style="height: 230px">
                                                <div class="tab-pane active stripe-gateway-tab" id="card" role="tabpanel"
                                                     aria-expanded="false">
                                                    <div class="element-card-payment p-20" style="background: #e8e8e8">
                                                        <div id="card-element" style="padding: 20px !important;"></div>
                                                        <div id="card-errors" role="alert"></div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-20 stripe-gateway-tab" id="giropay" role="tabpanel"
                                                     aria-expanded="false">
                                                    <p class="notice">You’ll be redirected to the banking site to complete
                                                        your payment.</p>
                                                    <p class="errorMessage" style="display: none; color: red">Some issue
                                                        with the payments, please try after some time</p>
                                                </div>
                                                <?php /*if($user->role == "Admin") { */ ?>
                                                <!--<div class="tab-pane p-20" id="sofort" role="tabpanel" aria-expanded="true">
                                                    <p class="notice">You’ll be redirected to the banking site to complete your payment.</p>
                                                    <p class="errorMessage" style="display: none; color: red">Some issue with the payments, please try after some time</p>
                                                </div>-->
                                                <?php /*} */ ?>
                                                <div class="tab-pane p-20 stripe-gateway-tab" id="iDeal" role="tabpanel" aria-expanded="true">
                                                    <div id="ideal-bank-element" class="field"></div>
                                                    <div id="error-message" role="alert"></div>
                                                </div>
                                                <div class="tab-pane p-20 stripe-gateway-tab" id="bancontact" role="tabpanel"
                                                     aria-expanded="true">
                                                    <p class="notice">You’ll be redirected to the banking site to complete
                                                        your payment.</p>
                                                    <p class="errorMessage" style="display: none; color: red">Some issue
                                                        with the payments, please try after some time</p>
                                                </div>
                                            </div>

                                            <button id="card-button" style="display: none">Submit Payment</button>
                                        </div>
                                    </div>
                                    <div id="payPalDetail" class="card text-center card-outline-success"
                                         style="margin-top: 25px">
                                        <div id="paypal-button-container"></div>
                                    </div>
                                    <div id="bankDetail">
                                        <div>
                                            <h4 align="center" class="" id="myModalLabel">Bank Details</h4>
                                        </div>
                                        <hr>
                                        <div class="row" style="margin-left: 20px;">
                                            <div class="col-sm-12">
                                                <p>Please deposit the license amount of <strong><span id="amountPayable"
                                                                                                      class="amount-payable">0</span></strong>
                                                    to</p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p>
                                                            <strong>Account Name:</strong><br/> Force International<br/>
                                                            <strong>Account No. EURO:</strong><br/> 0689 0467 8308<br/>
                                                            <strong>IBAN EURO:</strong><br/> BE63 0689 0467 8308<br/>
                                                            <strong>Swift/BIC Code:</strong><br/> GKCCBEBB<br/>
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <p>
                                                            <strong>Beneficiary Bank:</strong>
                                                            Belfius Bank SA/NV<br/>
                                                            Boulevard Pachecho 44<br/>
                                                            1000 Brussels<br/>
                                                            BELGIUM<br/>
                                                        </p>
                                                    </div>
                                                </div>
                                                <br>
                                                <p>Please make sure to put the following information in your payment
                                                    reference:<br/>
                                                    <strong>Reference:</strong> Full name - product license - registered
                                                    email address<br/>
                                                    <strong>Example:</strong> John Doe - CBM Global - johndoe@mail.com
                                                </p>
                                                <br>
                                                <p>
                                                    <strong>Attention:</strong><br/>
                                                    <ol class="bank-terms text-muted">
                                                        <li>We only accept bank transfers in EURO.<br/></li>
                                                        <li>The principal pays the costs (OUR), meaning you pay all the charges
                                                            applying to the transaction.<br/></li>
                                                        <li>Bank transfers take approximately 3 to 5 business days to process.
                                                        </li>
                                                        <li>Once we receive the money and the order is approved, notifications
                                                            and fulfilment actions get triggered.
                                                        </li>
                                                    </ol>
                                                </p>
                                            </div>
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
                        <input type="hidden" class="ignore" name="voucher_discount" id="voucher_discount" value="">
                        <input type="hidden" class="ignore" name="net_total" id="net_total" value="">
                        <input type="hidden" class="ignore" name="payable_amount" id="payable_amount" value="">
                        <input type="hidden" class="ignore" name="payment_reference_id" id="payment_reference_id" value="">
                        <input type="hidden" class="ignore" name="order_origin" id="" value="user">
                        <input type="hidden" class="ignore" name="vat_percentage" id="vat_percent_form" value="">
                        <input type="hidden" class="ignore" name="order_comment" id="order_comment" value="">
                        <input type="hidden" class="ignore" name="voucher_code" id="voucher_code_form" value="">
                        <input type="hidden" class="ignore" name="voucher_code_discount" id="voucher_code_discount_form" value="">
                    </form>
                    <form method="post" action="<?php echo Yii::app()->params['ingenicoUrl']; ?>" id='form1' name='form1'>
                        <!-- general parameters: see Form parameters -->
                        <input type="hidden" class="ignore" name="PSPID" value="<?= Yii::app()->params['PSPID']; ?>">
                        <input type="hidden" class="ignore" name="ORDERID" id="order_id" value="">
                        <input type="hidden" class="ignore" name="AMOUNT" value="" id="injenico_amount">
                        <input type="hidden" class="ignore" name="CURRENCY" value="EUR">
                        <input type="hidden" class="ignore" name="LANGUAGE" value="EN">
                        <input type="hidden" class="ignore" name="CN" value="<?php echo $user->full_name; ?>">
                        <input type="hidden" class="ignore" name="EMAIL" value="<?php echo $user->email; ?>">
                        <input type="hidden" class="ignore" name="OWNERZIP" value="">
                        <input type="hidden" class="ignore" name="OWNERADDRESS" value="">
                        <input type="hidden" class="ignore" name="OWNERCTY" value="">
                        <input type="hidden" class="ignore" name="OWNERTOWN" value="">
                        <input type="hidden" class="ignore" name="OWNERTELNO" value="">
                        <input type="hidden" class="ignore" name="ITEMNAME1" value="<?php //$product->name; ?>">
                        <input type="hidden" class="ignore" name="TITLE" value="CBM Global Payment Confirmation">
                        <!-- post payment redirection: see Transaction feedback to the customer -->
                        <input type="hidden" class="ignore" name="ACCEPTURL"
                               value="<?php echo Yii::app()->createAbsoluteUrl('order/success'); ?>">
                        <input type="hidden" class="ignore" name="DECLINEURL"
                               value="<?php echo Yii::app()->createAbsoluteUrl('order/decline'); ?>">
                        <input type="hidden" class="ignore" name="EXCEPTIONURL"
                               value="<?php echo Yii::app()->createAbsoluteUrl('order/exception'); ?>">
                        <input type="hidden" class="ignore" name="CANCELURL"
                               value="<?php echo Yii::app()->createAbsoluteUrl('order/cancel'); ?>">
                        <input type="submit" value="" id="submitInjenico" name=submit2 style="display: none">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/jquery.steps.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/steps.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/waves.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/icheck/icheck.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/icheck/icheck.init.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js', CClientScript::POS_END);
?>
<script src="<?= 'https://www.paypal.com/sdk/js?client-id=' . Yii::app()->params['PayPalClientId'] . '&currency=EUR'; ?>"></script>
<script type="text/javascript">

    var payPalOrderId = '';

    var stripe = '';
    var cardElement = '';
    var idealBank = '';

    //Below URLs and variables are required in steps.js...Kindly, don't delete them
    var stripeSuccessURL = "<?= Yii::app()->createUrl('order/success') . '?orderID='; ?>";
    var stripeCancelURL = "<?= Yii::app()->createUrl('order/cancel') . '?orderID='; ?>";
    var orderResponseURL = "<?= Yii::app()->createUrl('order/addResponse'); ?>";
    var updateStripeUrl = "<?= Yii::app()->createUrl('order/updateStripeDetails'); ?>";
    var authorizeAsyncURL = "<?= Yii::app()->createAbsoluteUrl('order/authorizeStripeAsyncPayment'); ?>";
    var orderPaymentDetailsURL = "<?= Yii::app()->createAbsoluteUrl('order/updateStripeOrderPayment'); ?>";
    var reserveWalletSuccessURL = "<?= Yii::app()->createUrl('order/success') . '?orderID='; ?>";
    var addOrderUrl = "<?= Yii::app()->createUrl('order/addorder'); ?>";
    let tradingProductIds = JSON.parse("<?= addslashes($trading_product_data_ids); ?>");

    var full_name = "<?= $user->full_name; ?>";
    var email = "<?= $user->email; ?>";

    var base_discount = base_total = vat_amt = vat_percent = discount = sub_total =
        net_total = isFundSelected = licenseNum = deposit = cluster = trip_completed =
            payable_amount = allowed_user_wallet = allowed_reserve_wallet =
                voucher_discount = 0;
    var previous_group_id = is_cluster_selected = 0;
    var reserve_wallet_amount = "<?= $reserve_wallet_balance; ?>";
    var user_wallet_amount = "<?= $user_wallet_balance ?>";
    var total_available_balance = "<?= $total_available_balance ?>";

    //Checkout eligibility test
    $(document).ready(function () {

        $('.actions').css('display', 'none');

        //For Personal country change
        $('#personal-country-select').on('change', function (e) {
            let country_id = this.value;
            let vat_type = "personal";
            calculateVat(country_id, vat_type);
        });

        //For Business country change
        $('#business-country-select').on('change', function (e) {
            let country_id = this.value;
            let vat_type = "business";
            calculateVat(country_id, vat_type);
        });

        //For Default values
        vat_percent = "<?= $personal_vat; ?>";
        vatUpdate(vat_percent);
    });

    $(document).on('input', '.step2_qty', function () {
        product_id = $(this).attr('data-id');
        licenseNum = $(this).val();
        if(licenseNum == 0){
            swal("OOPS!", "Quantity is always greater than 0!", "error");
            licenseNum = 1;
            $(this).val(licenseNum);
        }
        touchSpinLicenseChange(licenseNum,product_id);
    });

    function touchSpinLicenseChange(licenseCount,product_id) {
        var getLicensePriceUrl = "<?= Yii::app()->createUrl('product/getLicensePrice'); ?>";
        //To get valid license_pricing id as per the input license quantity
        $.ajax({
            type: "POST",
            url: getLicensePriceUrl,
            data: {
                "licenseNum": licenseCount,
                "product_id": product_id,
            },
            success: function (data) {
                dt = JSON.parse(data);
                discount += dt.discount;
                $('#total_product_price_step_3_' + product_id).html('&euro;' + dt.subTotal);
                $('#step3_price_' + product_id).html(dt.itemPrice);
                $('.kt-mycart__price_'+product_id).html('&euro;' + dt.subTotal+' ');
                $('.kt-mycart__quantity_'+product_id).html(' '+licenseNum);
            }
        });
    }
    //Reserve Wallet Checkbox change event
    $('body').on('change', '#reserve_wallet_cbox', function () {
        updateUserWalletRelatedDetails();
    });

    $('body').on('change', '#user_wallet_cbox', function () {
        updateUserWalletRelatedDetails();
    });

    //Step-4 Details
    function updateCheckoutDetails() {
        net_total = (parseFloat(sub_total) + parseFloat(vat_amt)).toFixed(2);
        sub_total = parseFloat(sub_total).toFixed(2);
        console.log("sub_total"+sub_total);

        $('#checkout-qty').html(licenseNum);
        $('#checkout-total').html('€' + base_total);
        if (discount > 0) {
            $('.row-discount').show();
            $('#Discount').html('€' + discount);
        } else {
            $('.row-discount').hide();
        }
        $('#check-subtotal').html('€' + sub_total);
        $('#total_amount_html_step4').html('€' + net_total);

        //Form details that will be used for adding to database
        $('#vat_amount_form').val(vat_amt);
        $('#product_id').val(product_id);
        $('#order_total').val(sub_total);
        $('#total_discount').val(discount);
        $('#voucher_discount').val(voucher_discount);
        $('#net_total').val(net_total);
        $('#vat_percent_form').val(vat_percent);
        $('#license_num').val(licenseNum);
        $('#base_price').val(base_price);
        $('#sale_price').val(window.sale_price);
        $('#total_amount_pay').html('€' + net_total);
        updateUserWalletRelatedDetails();
        $('#injenico_amount').val(parseFloat((payable_amount * 100).toFixed(2)));
    }

    //Show-Hide Payment method details
    $('#steps-uid-0-p-3').ready(function () {

        var payment = $('input[name=payment]:checked').val();
        $('#stripeDetail').show();
        updateStripeDetails();
        $('#ingenicoDetail').hide();
        $('#bankDetail').hide();
        $('#payPalDetail').hide();

        $('input[name=payment]').on('change', function (e) {
            $('.actions').css('display', 'block');

            $('#ingenicoDetail').hide();
            $('#bankDetail').hide();
            $('#stripeDetail').hide();
            $('#payPalDetail').hide();

            var payment_type = $(this).val();
            if (payment_type == 'bank') {
                $('#bankDetail').show();
            } else if (payment_type == 'ingenico') {
                $('#ingenicoDetail').show();
            } else if (payment_type == 'stripe') {
                $('#stripeDetail').show();
                updateStripeDetails();
            } else if (payment_type == 'paypal') {
                $('.actions').css('display', 'none');
                $('#payPalDetail').show();
                updatePayPalDetails();
            }
        });
    });

    //For Address related Changes
    $('#steps-uid-0-p-2').ready(function () {
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
        $('#vat_percent_html_step4').html('Vat@' + vat_percent + '%');
        vat_percent = parseFloat(vat_percent);
        vat_amt = (sub_total * vat_percent / 100).toFixed(2);
        net_total = (parseFloat(sub_total) + parseFloat(vat_amt)).toFixed(2);

        //Update HTML and database values
        $('#vat_amount_html_step4').html('€' + vat_amt);
        $('#total_amount_html_step4').html('€' + net_total);
        $('#total_amount_pay').html('€' + net_total);
        $('#vat_amount_form').val(vat_amt);
        $('#vat_percent_form').val(vat_percent);
        $('#net_total').val(net_total);
        updateUserWalletRelatedDetails();
        $('#injenico_amount').val(parseFloat((payable_amount * 100).toFixed(2)));
        $('#amountPayable').html('€' + payable_amount);
    }

    /*
    * Changes payable amount
    * along with updates payment section
    * */
    function updateUserWalletRelatedDetails() {
        total_available_balance = parseFloat(total_available_balance);
        net_total = parseFloat(net_total);
        var allowed_usable_balance = 0;

        if ($('#reserve_wallet_cbox').is(':checked')) {
            allowed_usable_balance += parseFloat(reserve_wallet_amount);
        } else {
            $('#reserve_wallet_amount').val('0');
        }

        if ($('#user_wallet_cbox').is(':checked')) {
            allowed_usable_balance += parseFloat(user_wallet_amount);
        } else {
            $('#user_wallet_amount').val('0');
        }

        //Display condition for payment section
        if (allowed_usable_balance >= net_total) {
            payable_amount = 0;
            $('#label-express-payment').css('display', 'block');
            $('#payment-section').css('display', 'none');
        } else {
            payable_amount = net_total - allowed_usable_balance;
            $('#label-express-payment').css('display', 'none');
            $('#payment-section').css('display', 'flex');
        }

        payable_amount = parseFloat(payable_amount).toFixed(2);
        $('#remaining_amount_pay').html('€' + parseFloat(payable_amount));
        $('#payable_amount').val(parseFloat(payable_amount));
    }

    function updateStripeDetails() {
        var sourceId = '';

        var publishableKey = "<?= Yii::app()->params['StripePublishableKey'] ?>";
        stripe = Stripe(publishableKey);

        var elements = stripe.elements();

        //Mount stripe card
        cardElement = elements.create('card');
        cardElement.mount('#card-element');

        /*var cardNumberElement = elements.create('cardNumber', {
            placeholder: 'Please enter card number here'
        });
        cardNumberElement.mount('#card-number-element');*/

        //iDeal Bank style
        var style = {
            base: {
                padding: '10px 12px',
                color: '#32325d',
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a'
            }
        };
        //Mount iDeal Bank details
        idealBank = elements.create('idealBank', {style: style});
        idealBank.mount('#ideal-bank-element');
    }

    function updatePayPalDetails() {
        $('#paypal-button-container').empty();
        renderPayPal();
    }

    function renderPayPal() {
        var given_name = "<?= $user->first_name; ?>";
        var surname = "<?= $user->last_name; ?>";
        var email_address = "<?= $user->email; ?>";
        var customData = "Order Id:" + payPalOrderId;
        var successUrl = "<?= Yii::app()->createUrl('order/success') . '?orderID='; ?>";
        var cancelURL = "<?= Yii::app()->createUrl('order/cancel') . '?orderID='; ?>";

        paypal.Buttons({
            // onClick is called when the button is clicked
            onClick: function (data, actions) {

                var formData = $('.validation-wizard').serializeArray();
                $.ajax({
                    type: "POST",
                    url: addOrderUrl,
                    data: formData,
                    success: function (datum) {
                        var response = JSON.parse(datum);
                        payPalOrderId = response['orderId'];
                    }
                });
                // You must return a promise from onClick to do async validation
                /*return fetch(addOrderUrl, {
                    method: 'post',
                    body: formData,
                    headers: {
                        'content-type': 'application/json'
                    }
                }).then(function(res) {
                    return res.json();
                }).then(function(data) {

                    // If there is a validation error, reject, otherwise resolve
                    if (data.validationError) {
                        document.querySelector('#error').classList.remove('hidden');
                        return actions.reject();
                    } else {
                        return actions.resolve();
                    }
                });*/
            },
            createOrder: function (data, actions) {
                var customData = "Order Id:" + payPalOrderId;
                return actions.order.create({
                    application_context: {
                        brand_name: "CBM Global",
                        user_action: "PAY_NOW"
                        //cancelURL: cancelURL
                    },
                    purchase_units: [{
                        amount: {
                            currency_code: 'EUR',
                            value: payable_amount
                            /*breakdown: {
                                item_total: {
                                    currency_code: 'EUR',
                                    value : sub_total
                                },
                                tax_total: {
                                    currency_code: 'EUR',
                                    value: vat_amt
                                }
                            }*/
                        },
                        description: 'CBM Licenses',
                        soft_descriptor: customData,
                        custom_id: customData,
                        reference_id: customData
                    }],
                    payer: {
                        name: {
                            given_name: given_name,
                            surname: surname
                        },
                        email_address: email_address
                    }
                });
            },
            onApprove: function (data, actions) {
                // Capture the funds from the transaction
                return actions.order.capture().then(function (details) {
                    var paymentId = data.orderID;
                    window.location = successUrl + payPalOrderId + '&PAYID=' + paymentId;
                    //$('#payment_reference_id').val(paymentId);
                    /*var order_comment = 'PayPal Order Id '+data.orderID;
                    $('#order_comment').val(order_comment);
                    var formData = $('.validation-wizard').serializeArray();*/

                });
            },
            onCancel: function (data, actions) {
                // Show a cancel page or return to cart
                var paymentId = data.orderID;
                window.location = cancelURL + payPalOrderId + '&PAYID=' + paymentId;
            }
        }).render('#paypal-button-container');
    }

    function addToCart(product_id, price) {
        let addToCartUrl = "<?= Yii::app()->createUrl('viewcart/addtocart'); ?>";
        let cartData = {
            'user_id': "<?php echo $user->user_id; ?>",
            'product_id': product_id,
            'qty': 1,
            'price': price
        };
        $.ajax({
            type: "POST",
            url: addToCartUrl,
            data: cartData,
            success: function (data) {
                let response = JSON.parse(data);
                if (response.status == 1) {
                    $(".validation-wizard").steps("next");
                    $('.actions').css('display', 'block');
                    toastr.success("Item added to cart!");
                    appendDataToCart(response['cartData']);
                } else {
                    toastr.success("Issues while adding item to the cart. Please try again later or contact support");
                }
            }
        });
    }

    //Update cart page UI
    function appendDataToCart(cartDataArr) {
        let tableData = '';
        let spinnerIds = [];
        $.each(cartDataArr, function (key, value) {
            let tr = '<tr id="cart_row_' + value.product_id + '" role="row">';
            tr += '<td role="cell"><div class="d-flex"><div class="mr-3"><img src="' + value.image + '" style="width: auto !important; height: 40px !important;"></div><div><h5 class="pink m-0">' + value.name + '</h5><div>' + value.description + '</div></div></div></td>';
            if($.inArray(value.product_id, tradingProductIds) !== -1){
                tr += '<td class="w2" data-label="Quantity" role="cell">' +
                    '<div class="d-flex">' +
                    '<input id="step_qty_' + value.product_id + '" type="number" class="form-control form-control-xs text-center qty_product step2_qty qty-' + value.product_id + '" ' +
                    'value="' + value.qty + '" data-id="' + value.product_id + '" name="step2_qty[]" disabled="disabled" style="max-width: 100px;">' +
                    '</div></td>';
            } else {
                tr += '<td class="w2" data-label="Quantity" role="cell">' +
                    '<div class="d-flex">' +
                    '<input id="step_qty_' + value.product_id + '" type="number" class="form-control form-control-xs text-center qty_product step2_qty qty-' + value.product_id + '" ' +
                    'value="' + value.qty + '" data-id="' + value.product_id + '" name="step2_qty[]" style="max-width: 100px;">' +
                    '</div></td>';
                spinnerIds.push("step_qty_" + value.product_id);
            }
            tr += '<td class="w1" role="cell">€ <span class="step3_base_price" id="step3_price_' + value.product_id + '">' + value.amount / value.qty + '</span></td>';
            tr += '<td class="w2" role="cell"><span class="step3_sub_total" id="total_product_price_step_3_' + value.product_id + '">€ ' + value.amount + '</span></td>';
            tr += '<td class="w1" role="cell"><a type="button" onclick="removeFromCart(' + value.product_id + ')"><i class="fas fa-times-circle"></i></a></td>';
            tr += '</tr>';
            tableData += tr;
        });
        appendDataItemsToCart(cartDataArr);

        $('.cart-table tbody').html(tableData);

        $.each(spinnerIds, function (key, vale) {
            $('#' + vale).TouchSpin({
                min: 1,
                max: 100000
            });
            $('#' + vale).on('touchspin.on.stopspin', function () {
                licenseNum = $(this).val();
                product_id = $(this).attr('data-id');
                touchSpinLicenseChange(licenseNum, product_id);
            });
        });
    }

    //Remove product from cart
    function removeFromCart(cartProductId) {
        let removeFromCartUrl = "<?= Yii::app()->createUrl('viewcart/removefromcart'); ?>";
        let cartData = {
            'user_id': "<?= $user->user_id; ?>",
            'product_id': cartProductId
        };
        $.ajax({
            type: "POST",
            url: removeFromCartUrl,
            data: cartData,
            success: function (data) {
                let response = JSON.parse(data);
                if (response['status'] == 1) {
                    $('#cart_row_' + cartProductId).remove();
                    $('.cart_item_' + cartProductId).remove();
                    swal("Cart Updated!", "Requested product is removed from your cart", "success");
                }
            }
        });
    }

</script>