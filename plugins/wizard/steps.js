$(".tab-wizard").steps({
    headerTag: "h6",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: "Submit"
    },
    onFinished: function (event, currentIndex) {
        var form = $(this);
        // Submit form input
        form.submit();
    }
});

var form2 = $(".pending-order-validation-wizard").show();
//Pending order validation wizard
$(".pending-order-validation-wizard").steps({
    headerTag: "h6",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: "Submit"
    },
    onFinishing: function (event, currentIndex) {
        return form2.validate().settings.ignore = ":disabled", form2.valid()
    },
    onFinished: function (event, currentIndex) {
        $.ajax({
            type: "POST",
            url: "../order/addorder",
            data: $(this).serializeArray(),
            success: function (data) {
                var response = JSON.parse(data);
                swal({
                        title: "Order Placed",
                        text: "Your order has been placed in reserved-pending state.",
                        closeOnConfirm: false
                    },
                    function () {
                        window.location = "../order/detail/" + response.orderId;
                    });
            }
        });
    }
});

var form = $(".validation-wizard").show();


$(".validation-wizard").steps({
    headerTag: "h6"
    , bodyTag: "section"
    , transitionEffect: "fade"
    , titleTemplate: '<span class="step">#index#</span> #title#'
    , labels: {
        finish: "Submit"
    }
    , onStepChanging: function (event, currentIndex, newIndex) {
        return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
    }
    /*, onFinishing: function (event, currentIndex) {
        return form.validate().settings.ignore = ":disabled", form.valid()
    }*/
    , onStepChanged: function (event, currentIndex, priorIndex) {
        if(currentIndex == 3){
            if(net_total == 0){
                $('#user_wallet_cbox').prop('checked', true);
            }
        }
        if(currentIndex == 2){
            var myarray = [];
            $('.step2_qty').each(function( index ) {
                var product_id = $(this).attr('data-id');
                var qty = $(this).val();
                myarray.push({'product_id':product_id,'qty':qty});
            });
            $.ajax({
                type: "POST",
                url: "../viewcart/updatecart",
                data: {cartdata:myarray},
                success: function (data) {
                    var response = JSON.parse(data);
                    let cart_div = '';
                    $.each(response.cartData, function(key,value) {
                        let div = '<tr>' +
                            '<td><div class="order-pro" style="display: inline-flex;"><div style="padding: 5px;width:80px !important;"><img id="step4_prd_img" src="'+value.image+'" width="75" style="height: 80px !important;max-width: 75px !important;"></div>' +
                            '<div class="order-dt"><h3 class="pink m-0"><strong><span id="step4_prd_h3">'+value.name+'</span></strong></h3></div>' +
                            '</div></td>' +
                            '<td>'+value.qty+'</td>' +
                            '<td style="text-align:right;">€ '+(value.qty*value.price)+'</td>' +
                            '</tr>';
                        cart_div += div;
                    });
                    appendDataItemsToCart(response.cartData);
                    $('.cart-details-tb tbody').html(cart_div);
                    $('#check-subtotal').html(response.subtotal);
                    $('#total_amount_html_step4').html('€ '+parseFloat(response.subtotal));
                    sub_total = parseFloat(response.subtotal);
                    discount = parseFloat(response.discount);
                    if (discount > 0) {
                        $('.row-discount').show();
                        $('#Discount').html('€' + discount);
                    } else {
                        $('.row-discount').hide();
                    }
                    updateCheckoutSectionDetails();
                    return false;
                }
            });
        }
    },
    onFinished: function (event, currentIndex) {
        $(".se-pre-con").css('display','block');
        var selected_option = $('ul#stripe-payment-methods a.active').attr('data-name');
        var payment_method = $('input[name=payment]:checked').val();
        var payment_method_selected = false;
        var payment_system_section_display_property = $('#payment-section').css('display');
        var order_form_data = $(this).serializeArray();
        if($('#user_wallet_cbox').is(':checked') || $('#reserve_wallet_cbox').is(':checked')){
            /*  To check if there are multiple payment methods available
                Only if there is no payment gateway enabled, payment
                method can be made to 'wallet'
             */
            if((payment_system_section_display_property == 'none'))
                payment_method = 'wallet';
            payment_method_selected = true;
        }

        //No payment method selected
        if((payment_system_section_display_property == 'none') && !payment_method_selected){
            swal("OOPS!", "You need to select payment method first!", "error");
            $(".se-pre-con").css('display','none');
            return false;
        } else {
            if((payment_method == 'stripe') && (selected_option == 'card') ){
                stripe.createPaymentMethod(
                    'card',
                    cardElement
                ).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        $(".se-pre-con").css('display','none');
                        errorElement.textContent = result.error.message;
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "../order/addorder",
                            data: order_form_data,
                            beforeSend: function () {
                                $(".se-pre-con").css('display', 'block');
                                $('.wizard-content').addClass('disabledDiv');
                            },
                            success: function (data) {
                                var response = JSON.parse(data);
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
                    url: "../order/addorder",
                    data: order_form_data,
                    beforeSend: function () {
                        $(".se-pre-con").css('display','block');
                        $('.wizard-content').addClass('disabledDiv');
                    },
                    success: function (data) {
                        var response = JSON.parse(data);

                        //Setting the orderID is necessary for all payment gateways
                        $('#order_id').val(response['orderId']);
                        var redirectUrl = stripeSuccessURL;
                        if (response['payment'] == 'Ingenico') {
                            $('#submitInjenico').click();
                        } else if(response['payment'] == 'Wallet'){
                            //For Orders paid through only wallets
                            $(".se-pre-con").css('display','none');
                            var successRedirectUrl = reserveWalletSuccessURL + response['orderId'] + "&PAYID=";
                            window.location = successRedirectUrl;
                        } else {
                            var selected_option = $('ul#stripe-payment-methods a.active').attr('data-name');
                            if (response['payment'] == 'Stripe') {
                                var cardButton = document.getElementById('card-button');

                                if(selected_option == 'card'){
                                    //Card related procedures are completed above

                                    /*stripe.createPaymentMethod(
                                        'card',
                                        cardElement
                                    ).then(function(result) {
                                        if (result.error) {
                                            // Inform the user if there was an error
                                            var errorElement = document.getElementById('card-errors');
                                            $(".se-pre-con").css('display','none');
                                            errorElement.textContent = result.error.message;
                                        } else {
                                            // Send paymentMethod.id to server
                                            stripeSourceHandler(result.paymentMethod);
                                        }
                                    });*/
                                    /*stripe.createSource(cardElement).then(function(result) {
                                        if (result.error) {
                                            // Inform the user if there was an error
                                            var errorElement = document.getElementById('card-errors');
                                            $(".se-pre-con").css('display','none');
                                            errorElement.textContent = result.error.message;
                                        } else {
                                            // Send the source to your server
                                            stripeSourceHandler(result.source);
                                        }
                                    });*/
                                } else if(selected_option == 'iDeal'){
                                    var errorMessage = document.getElementById('error-message');
                                    var sourceData = {
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
                                } else if(selected_option == 'sofort'){
                                    stripe.createSource({
                                        type: selected_option,
                                        amount: Math.round(payable_amount*100),
                                        currency: 'eur',
                                        statement_descriptor: 'Order Id: '+response['orderId'],
                                        owner: {
                                            name: 'succeeding_charge'
                                        },
                                        redirect: {
                                            return_url: authorizeAsyncURL+'?order_id='+response['orderId']+'&netTotal='+payable_amount
                                        },
                                        sofort: {
                                            country: 'BE',
                                            preferred_language: 'nl'
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
                                }
                            } else {
                                $(".se-pre-con").css('display','none');
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
                    }
                });
            }
        }

    }
});

function stripeSourceHandler(source){
    var sourceId = source.id;
    var selected_option = $('ul#stripe-payment-methods a.active').attr('data-name');
    var orderId = $('#order_id').val();

    //Update Stripe sub payment method in order_payment transaction_mode
    var payment_data = {
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
        $(".se-pre-con").css('display','none');
        window.location = source.redirect['url'];
    } else if(selected_option == 'card') {
        var stripeData = {
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
                var resp = JSON.parse(data);
                $(".se-pre-con").css('display','none');
                if(resp.status == true){
                    var redirectUrl = stripeSuccessURL + orderId + "&PAYID=" + resp.secret;
                } else {
                    var redirectUrl = stripeCancelURL + orderId + "&PAYID=" + resp.secret;
                }
                window.location = redirectUrl;
            }
        });
    }

}

$(".pending-order-validation-wizard").validate({
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

$(".validation-wizard").validate({
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
        address: {
            required: true
        },
        terms: {
            required: true
        },
        service: {
            required: true
        },
        building_num: {
            required: true
        },
        street: {
            required: true
        },
        city: {
            required: true
        },
        postcode: {
            required: true
        },
        country: {
            required: true
        },
        business_name: {
            required: true
        },
        vat_number: {
            required: true
        },
        busAddress_building_num: {
            required: true
        },
        busAddress_street: {
            required: true
        },
        busAddress_region: {
            required: true
        },
        busAddress_city: {
            required: true
        },
        busAddress_postcode: {
            required: true
        },
        busAddress_country: {
            required: true
        },
        payment: {
            required: true
        }
    },
    messages: {
        terms: 'Please agree to Terms and Conditions',
        service: 'Please agree to Refund policy',
        address: 'Please Complete your profile',
        payment: 'Please Select Payment Method',
        building_num: 'Please enter Building number',
        street: 'Please enter Street',
        city: 'Please enter City',
        postcode: 'Please enter Postcode',
        country: 'Please select Country',
        business_name: 'Please enter Company Name',
        vat_number: 'Please enter Vat number',
        busAddress_building_num: 'Please enter Building number',
        busAddress_street: 'Please enter Street',
        busAddress_region: 'Please enter Region',
        busAddress_city: 'Please enter City',
        busAddress_postcode: 'Please enter Postcode',
        busAddress_country: 'Please select Country'
    }
});

function updateCheckoutSectionDetails() {
    let adds_type = $('input[name=address]:checked').val();
    let country_id = 0;
    let vat_type = '';
    if (adds_type == 'personal') {
        country_id = $('#personal-country-select').val();
        vat_type = "personal";
    } else {
        country_id = $('#business-country-select').val();
        vat_type = "business";
    }
    calculateVat(country_id, vat_type);
    updateCheckoutDetails();
}
