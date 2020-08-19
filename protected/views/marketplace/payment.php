<?php
if(count($cartItem) < 1){
    $this->redirect(Yii::app()->createUrl('marketplace/index'));
}
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.css');
?>
<style>
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

    #label-express-payment {
        display: none;
        margin-bottom: 0;
        text-align: right;
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
                        <div class="kt-subheader__breadcrumbs"> <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a> <span class="kt-subheader__breadcrumbs-separator"></span> <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Payment</span> </div>
                    </div>
                </div>
            </div>
            <!-- end:: Subheader -->
            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <!--Begin::Dashboard-->
                <form name="orderplaced" id="orderplaced" method="post">
                    <div class="row">
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
                                <div class="col-md-9" id="remaining-payable-div">
                                    <h1 style="text-align: right; margin: 0">Additional Payable Amount: <strong
                                                id="remaining_amount_pay" class="bold pink">€ <?= $total_amount; ?></strong></h1>
                                </div>
                            </div>
                        <?php } ?>
                        <p id="label-express-payment">Go With Express Payment</p>
                    </div>
                    <hr>
                    <div class="row">
                        <!--<div class="col-md-12">
                            <div class="text-center">
                                <h1 class="mb-3">Total Amount: <strong id="total_amount_pay" class="bold pink">€ <?/*= $total_amount; */?></strong></h1>
                            </div>
                        </div>-->
                        <div class="col-md-12">

                                <div class="row" id="payment-section">
                                <div class="col-md-12" style="margin-bottom: 10px;">
                                    <h2>Payment Gateways</h2>
                                </div>
                                <div class="col-md-3">
                                    <label class="custom-control custom-radio">
                                        <input  name="payment" type="radio" class="custom-control-input"
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
                                    <div id="stripeDetail" class="card text-center card-outline-success">
                                        <div class="card-header text-white">
                                            <h5>Payment Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-tabs customtab" role="tablist" id="stripe-payment-methods">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#card" data-name="card" role="tab" aria-expanded="false"><img
                                                            src="<?php echo Yii::app()->request->baseUrl ?>/images/card.png" alt="homepage" style="max-width: 144px;"></a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#bancontact" data-name="bancontact" role="tab"
                                                                        aria-expanded="true" style=""><img
                                                            src="<?php echo Yii::app()->request->baseUrl ?>/images/bancontact.png"
                                                            alt="homepage" style="max-width: 75px;"></a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#iDeal"
                                                                        data-name="iDeal" role="tab" aria-expanded="true"><img
                                                            src="<?php echo Yii::app()->request->baseUrl ?>/images/ideal.png"
                                                            alt="homepage" style="max-width: 125px;"></a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#giropay"
                                                                        data-name="giropay" role="tab" aria-expanded="false"><img
                                                            src="<?php echo Yii::app()->request->baseUrl ?>/images/Giropay.svg.png"
                                                            alt="homepage" style="max-width: 100px;"></a></li>
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
                                                <p>Please deposit the license amount of <strong><span id="amountPayable" class="amount-payable">€ <?= $total_amount; ?></span></strong>
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
                                    <br>
                                    <?php if(!empty($post_data)){
                                        foreach($post_data as $key => $post){ ?>
                                            <input type="hidden" name="<?= $key; ?>" value="<?= $post; ?>">
                                        <?php }
                                    } ?>
                                    <input type="hidden" name="net_total" id="net_total" value="<?= $total_amount; ?>">
                                    <input type="hidden" name="order_total" id="order_total" value="<?= $total_amount-$vat_amount; ?>">
                                    <input type="hidden" name="vat_percentage" id="vat_percent_form" value="<?= $vat_amount; ?>">
                                    <input type="hidden" name="discount" id="total_discount" value="<?= $vat_amount; ?>">
                                    <input type="hidden" name="payable_amount" id="payable_amount" value="<?= $total_amount; ?>">
                                    <input type="hidden" name="order_origin" value="user">
                                    <input type="hidden" name="order_id" id="order_id" value="">
                                    <button class="btn btn-primary btn-sm pull-right actions proceed_btn_form" type="submit">Proceed</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--End::Dashboard-->
            </div>
            <!-- end:: Content -->
        </div>
    </div>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.min.js', CClientScript::POS_END); ?>
<script src="<?= 'https://www.paypal.com/sdk/js?client-id=' . Yii::app()->params['PayPalClientId'] . '&currency=EUR'; ?>"></script>
<script>

    let payPalOrderId = '';

    let stripe = '';
    let cardElement = '';
    let idealBank = '';

    //Below URLs and variables are required in steps.js...Kindly, don't delete them
    let stripeSuccessURL = "<?= Yii::app()->createUrl('order/success') . '?orderID='; ?>";
    let stripeCancelURL = "<?= Yii::app()->createUrl('order/cancel') . '?orderID='; ?>";
    let orderResponseURL = "<?= Yii::app()->createUrl('order/addResponse'); ?>";
    let updateStripeUrl = "<?= Yii::app()->createUrl('order/updateStripeDetails'); ?>";
    let authorizeAsyncURL = "<?= Yii::app()->createAbsoluteUrl('order/authorizeStripeAsyncPayment'); ?>";
    let orderPaymentDetailsURL = "<?= Yii::app()->createAbsoluteUrl('order/updateStripeOrderPayment'); ?>";
    let reserveWalletSuccessURL = "<?= Yii::app()->createUrl('order/success') . '?orderID='; ?>";
    let addOrderUrl = "<?= Yii::app()->createUrl('order/addorder'); ?>";

    let full_name = "<?= $user->full_name; ?>";
    let email = "<?= $user->email; ?>";
    let payment_type = $('input[name=payment]:checked').val();
    let selected_option = $('ul#stripe-payment-methods a.active').attr('data-name');
    let payable_amount = "<?= $total_amount ?>";
    let net_total = "<?= $total_amount ?>";
    let user_wallet_amount = "<?= $user_wallet_balance ?>";
    let total_available_balance = "<?= $total_available_balance ?>";

    $('#orderplaced').submit(function () {
        //Re-initialization is necessary on submit
        selected_option = $('ul#stripe-payment-methods a.active').attr('data-name');
        payment_type = $('input[name=payment]:checked').val();
        let order_form_data = $(this).serializeArray();
        if((payment_type == 'stripe') && (selected_option == 'card')) {
            stripe.createPaymentMethod(
                'card',
                cardElement
            ).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    let errorElement = document.getElementById('card-errors');
                    $(".se-pre-con").css('display','none');
                    errorElement.textContent = result.error.message;
                } else {
                    $.ajax({
                        type: "POST",
                        url: addOrderUrl,
                        data: order_form_data,
                        beforeSend: function () {
                            $(".se-pre-con").css('display', 'block');
                            $('.wizard-content').addClass('disabledDiv');
                        },
                        success: function (data) {
                            let response = JSON.parse(data);
                            //Setting the orderID is necessary for all payment gateways
                            $('#order_id').val(response['orderId']);
                            // Send paymentMethod.id to server
                            stripeSourceHandler(result.paymentMethod);
                        }
                    });
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: addOrderUrl,
                data: order_form_data,
                beforeSend: function () {
                    $(".se-pre-con").css('display', 'block');
                    $('.wizard-content').addClass('disabledDiv');
                },
                success: function (data) {
                    let response = JSON.parse(data);
                    //Setting the orderID is necessary for all payment gateways
                    $('#order_id').val(response['orderId']);
                    if(selected_option == 'iDeal'){
                        let errorMessage = document.getElementById('error-message');
                        let sourceData = {
                            type: 'ideal',
                            amount: Math.round(payable_amount*100),
                            currency: 'eur',
                            owner: {
                                name: full_name
                            },
                            redirect: {
                                return_url: authorizeAsyncURL+'?order_id='+response['orderId']+'&netTotal='+payable_amount
                            },
                            statement_descriptor: 'Order Id: '+response['orderId']
                        };

                        stripe.createSource(idealBank, sourceData).then(function(result) {
                            if (result.error) {
                                // Inform the customer that there was an error.
                                errorMessage.textContent = result.error.message;
                                $(".se-pre-con").css('display','none');
                                errorMessage.classList.add('visible');
                            } else {
                                // Redirect the customer to the authorization URL.
                                errorMessage.classList.remove('visible');
                                stripeSourceHandler(result.source);
                            }
                        });
                    } else if((selected_option == 'bancontact') || (selected_option == 'giropay')){
                        stripe.createSource({
                            type: selected_option,
                            amount: Math.round(payable_amount*100),
                            currency: 'eur',
                            statement_descriptor: 'Order Id: '+response['orderId'],
                            owner: {
                                name: full_name
                            },
                            redirect: {
                                return_url: authorizeAsyncURL+'?order_id='+response['orderId']+'&netTotal='+payable_amount
                            }
                        }).then(function(result) {
                            // handle result.error or result.source
                            if (result.error) {
                                // Inform the customer that there was an error.
                                $('.errorMessage').css('display','block');
                                $(".se-pre-con").css('display','none');
                            } else {
                                // Redirect the customer to the authorization URL.
                                $('.errorMessage').css('display','none');
                                stripeSourceHandler(result.source);
                            }
                        });
                    } else {
                        $(".se-pre-con").css('display', 'none');
                        swal({
                                title: "Order Placed",
                                text: "Your order has been placed in pending state.",
                                closeOnConfirm: false
                            },
                            function () {
                                window.location = "../order/detail/" + response.orderId;
                            });
                    }
                }
            });
        }
        return false;
    });

    $(document).ready(function () {
        $('#stripeDetail').show();
        updateStripeDetails();
        $('#ingenicoDetail').hide();
        $('#bankDetail').hide();
        $('#payPalDetail').hide();
    });

    $('body').on('change', '#user_wallet_cbox', function () {
        updateUserWalletRelatedDetails();
    });

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

    //On change event of payment gateway
    $('input[name=payment]').on('change', function (e) {
        //Re-initialization is necessary on change
        payment_type = $('input[name=payment]:checked').val();
        $('.actions').css('display', 'block');
        $('#bankDetail').hide();
        $('#stripeDetail').hide();
        $('#payPalDetail').hide();

        var payment_type = $('input[name=payment]:checked').val();
        if (payment_type == 'bank') {
            $('#bankDetail').show();
        } else if (payment_type == 'stripe') {
            $('#stripeDetail').show();
            updateStripeDetails();
        } else if (payment_type == 'paypal') {
            $('.actions').css('display', 'none');
            $('#payPalDetail').show();
            updatePayPalDetails();
        }
    });

    function updateStripeDetails() {
        let sourceId = '';

        let publishableKey = "<?= Yii::app()->params['StripePublishableKey'] ?>";
        stripe = Stripe(publishableKey);

        let elements = stripe.elements();

        //Mount stripe card
        cardElement = elements.create('card');
        cardElement.mount('#card-element');

        /*let cardNumberElement = elements.create('cardNumber', {
            placeholder: 'Please enter card number here'
        });
        cardNumberElement.mount('#card-number-element');*/

        //iDeal Bank style
        let style = {
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
        let given_name = "<?= $user->first_name; ?>";
        let surname = "<?= $user->last_name; ?>";
        let successUrl = "<?= Yii::app()->createUrl('order/success') . '?orderID='; ?>";
        let cancelURL = "<?= Yii::app()->createUrl('order/cancel') . '?orderID='; ?>";

        paypal.Buttons({
            // onClick is called when the button is clicked
            onClick: function(data, actions) {

                let formData = $('#orderplaced').serializeArray();
                $.ajax({
                    type: "POST",
                    url: addOrderUrl,
                    data: formData,
                    success: function (datum) {
                        let response = JSON.parse(datum);
                        payPalOrderId = response['orderId'];
                    }
                });
            },
            createOrder: function (data, actions) {
                let customData = "Order Id:" + payPalOrderId;
                return actions.order.create({
                    application_context: {
                        brand_name: "Micromaxcash",
                        user_action: "PAY_NOW"
                    },
                    purchase_units: [{
                        amount: {
                            currency_code: 'EUR',
                            value: payable_amount
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
                        email_address: email
                    }
                });
            },
            onApprove: function (data, actions) {
                // Capture the funds from the transaction
                return actions.order.capture().then(function (details) {
                    let paymentId = data.orderID;
                    window.location = successUrl + payPalOrderId + '&PAYID=' + paymentId;
                    //$('#payment_reference_id').val(paymentId);
                    /*let order_comment = 'PayPal Order Id '+data.orderID;
                    $('#order_comment').val(order_comment);
                    let formData = $('.validation-wizard').serializeArray();*/

                });
            },
            onCancel: function (data, actions) {
                // Show a cancel page or return to cart
                let paymentId = data.orderID;
                window.location = cancelURL + payPalOrderId + '&PAYID=' + paymentId;
            }
        }).render('#paypal-button-container');
    }

    function stripeSourceHandler(source){
        let sourceId = source.id;
        let orderId = $('#order_id').val();

        //Update Stripe sub payment method in order_payment transaction_mode
        let payment_data = {
            'order_id': orderId,
            'selected_option': selected_option
        };
        $.ajax({
            type: "POST",
            url: orderPaymentDetailsURL,
            data: payment_data
        });
        if((selected_option == 'iDeal') || (selected_option == 'bancontact') || (selected_option == 'sofort') || (selected_option == 'giropay')) {
            //Redirect to authorization page
            $(".se-pre-con").css('display', 'none');
            window.location = source.redirect['url'];
        } else if(selected_option == 'card') {
            let stripeData = {
                'netTotal': payable_amount,
                'order_id': orderId,
                'full_name': full_name,
                'email': email,
                'source_id': sourceId,
                'selected_option': selected_option
            };
            $.ajax({
                type: "POST",
                url: updateStripeUrl,
                data: stripeData,
                success: function (data) {
                    let resp = JSON.parse(data);
                    $(".se-pre-con").css('display', 'none');
                    let redirectUrl = stripeSuccessURL;
                    if(resp.status == true){
                        redirectUrl = stripeSuccessURL + orderId + "&PAYID=" + resp.secret;
                    } else {
                        redirectUrl = stripeCancelURL + orderId + "&PAYID=" + resp.secret;
                    }
                    window.location = redirectUrl;
                }
            });
        }

    }
</script>