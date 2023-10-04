// add multiple product affiliates


$(function() {
    $('.js-select2').select2();
    $(document).on('click', '.btn-add', function(e) {
        e.preventDefault();

        var controlForm = $('.affiliate-control:first');
        var currentEntry = $(this).parents('.add-more-fields:first');
        var newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.btn-add:not(:last)')
            .removeClass('btn-default').addClass('btn-danger')
            .removeClass('btn-add').addClass('btn-remove')
            .html('<span>-</span>');
    }).on('click', '.btn-remove', function(e) {

        $(this).parents('.add-more-fields:first').remove();
        return false;
    });

    // validate product affiliate level form
    $("input[name='yt1']").click(function() {
        var result = true;
        $('#affiliateError').text('');

        var level = $('input[name="ProductAffiliate[amount][]"]').map(function() {
            return this.value
        }).get();
        var tAmount = $.trim(level);

        var values = $('input[name="ProductAffiliate[aff_level][]"]').map(function() {
            return this.value
        }).get();
        //var values = $.trim(value);

        var newVal = (values.slice(0, -1));
        var duplicate = (new Set(values)).size !== values.length;
        var duplicateCount = values.length;
        var getResult = true;
        $.each(level, function(indexl, valuel) {
            if (valuel == '0') {
                getResult = false;
            } else {
                $('#affiliateError').css('display', 'none');
            }
        });

        if (duplicateCount >= 1) {
            if (duplicate === true) {
                $('#affiliateError').text('Please Check, Duplicate Affiliate Level not allowed');
                $('#affiliateError').css('display', 'block');
                var duplicate = " ";
                result = false;
            } else {
                $('#affiliateError').css('display', 'none');
                var duplicate = " ";

            }
        }
        if (getResult == false) {
            $('#affiliateError').text('Please Check, 0 Affiliate amount not allowed');
            $('#affiliateError').css('display', 'block');
            result = false;
        }

        var affiliateCount = 0;
        $('.add-more-fields').each(function(index, element) {
            var affiliate_amount = $('#ProductAffiliate_amount').val();
            var affiliate_level = $('#ProductAffiliate_aff_level').val();
            var validNum = /[^\d].+/;

            if (affiliate_amount != '' || affiliate_level != '') {
                if (affiliate_amount == "") {
                    $('#affiliateError').text('Please Fill the Affiliate Level Amount');
                    $('#affiliateError').css('display', 'block');
                    result = false;
                } else if (validNum.test(affiliate_amount)) {
                    $('#affiliateError').text('Please Fill Only Number');
                    $('#affiliateError').css('display', 'block');
                    result = false;
                } else {}

                if (affiliate_level == "") {
                    $('#affiliateError').text('Please Fill the Affiliate Level ');
                    $('#affiliateError').css('display', 'block');
                    result = false;
                } else if (validNum.test(affiliate_level)) {
                    $('#affiliateError').text('Please Fill Only Number in affiliate level');
                    $('#affiliateError').css('display', 'block');
                    result = false;
                } else {}
                affiliateCount++;
            }
        });

        if (affiliateCount == '0') {
            result = false;
        }
        return result;
    });

    // add more product license fields
    $(document).on('click', '.btn-add-license', function(e) {
        e.preventDefault();

        var controlForm = $('.license-control:first');
        var currentEntry = $(this).parents('.add-more-license:first');
        var newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.btn-add-license:not(:last)')
            .removeClass('btn-default').addClass('btn-danger')
            .removeClass('btn-add-license').addClass('btn-remove-license')
            .html('<span>-</span>');
    }).on('click', '.btn-remove-license', function(e) {

        $(this).parents('.add-more-license:first').remove();
        return false;
    });


    $("input[name='yt2']").click(function() {
        var result = true;

        //valid product license text-field
        $('.Product-License-No').each(function(index, element) {
            var productLicense = $(this).val();
            var validNum = /[^\d].+/;
            if (productLicense == "") {
                $('#licenseError').text('Please Fill the Product License');
                $('#licenseError').css('display', 'block');
                result = false;
            } else if (validNum.test(productLicense)) {
                $('#licenseError').text('Please Fill Only Number');
                $('#licenseError').css('display', 'block');
                result = false;
            } else {}
        });

        //valid Product-List drop-down
        $('.Product-List').each(function(index, element) {
            var product = $(this).val();
            if (product == "") {
                $('#licenseError').text('Please Select Product');
                $('#licenseError').css('display', 'block');
                result = false;
            }
        });
        return result;
    });

    $('#UserInfo_last_name, #UserInfo_first_name, #UserInfo_middle_name').change(function() {
        var first = document.getElementById("UserInfo_first_name").value.replace(/\s+/g, '');
        $("#UserInfo_first_name").val(first);
        var middle = document.getElementById("UserInfo_middle_name").value.replace(/\s+/g, '');
        $("#UserInfo_middle_name").val(middle);
        var last = document.getElementById("UserInfo_last_name").value.replace(/\s+/g, '');
        $("#UserInfo_last_name").val(last);
        $("#UserInfo_full_name").val(first + " " + middle + " " + last);
    });


    $('#ProductInfo_image').on('change', function() {
        var fup = document.getElementById('ProductInfo_image');
        var fileName = fup.value;
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);

        if (ext == "PNG" || ext == "png" || ext == "jpg" || ext == "JPG" || ext == "jpeg" || ext == "JPEG" || ext == "gif" || ext == "GIF" || ext == "bmp" || ext == "BMP") {
            $("#imageTypeError").css("display", "none");
            return true;
        } else {
            $("#imageTypeError").html("only allows file types of GIF, PNG, JPG, JPEG and BMP");
            $("#imageTypeError").css("color", "red");
            $("#imageTypeError").css("display", "block");
            $("#ProductInfo_image").val("");
            return false;
        }
    });
    // add Multiple Product in Order
    $(document).on('click', '.btn-add-product', function(e) {
        var controlForm = $('#productControl:first');
        var currentEntry = $(this).parents('.addMoreProduct:first');
        var newEntry = $(currentEntry.clone()).appendTo(controlForm).insertBefore('#beforePrice');

        // Remove Selected option in new Field
        newEntry.find('#OrderLineItem_product_id option:selected').removeAttr('selected');
        newEntry.find('#OrderLineItem_item_qty').val('');
        newEntry.find('#itemPrice').val('');
        newEntry.find('#OrderLineItem_item_disc').val('');

        controlForm.find('.btn-add-product:not(:last)')
            .removeClass('btn-default').addClass('btn-danger')
            .removeClass('btn-add-product').addClass('btn-remove-product')
            .html('<span>-</span>');
    }).on('click', '.btn-remove-product', function(e) {
        $(this).parents('.addMoreProduct:first').remove();
        setPriceTotal();
        return false;
    });

    // Update amount on the change of quantity
    $(document).on('keyup', '#OrderLineItem_item_qty', function(e) {
        var productRow = $(this).parents('tr');
        ProductPrice(productRow);
    }).on('change', '#OrderLineItem_product_id', function(e) {
        var productRow = $(this).parents('tr');
        ProductPrice(productRow);
    });

    //Update amount on the change in discount
    $(document).on('keyup', '#OrderLineItem_item_disc', function(e) {
        var productRow = $(this).parents('tr');
        ProductPrice(productRow);
    }).on('change', '#OrderLineItem_item_disc', function(e) {
        var productRow = $(this).parents('tr');
        ProductPrice(productRow);
    });

    //validate multiple product detail in order form
    /*$("form[id='order-info-form']").submit(function () {
     var result = true;

     var user = $('#OrderInfo_user_id').val();
     var address = $('#orderAddress').val();

     $('#productError').text('');
     $('.addMoreProduct').each(function (index, element) {
     var productName = $(this).find('#OrderLineItem_product_id').val();
     var productQty = $(this).find('#OrderLineItem_item_qty').val();

     if (productQty != '') {
     var regex = /[0-9]/;
     if (regex.test(productQty)) {
     if (productQty <= 0) {
     $('#productError').text('Please Enter valid quantity');
     $('#productError').css('display', 'block');
     result = false;
     } else {
     //result = checkQty(productName,productQty);
     }
     } else {
     $('#productError').text('Please Enter only Number');
     $('#productError').css('display', 'block');
     result = false;
     }
     } else {
     $('#productError').text('Please enter product quantity');
     $('#productError').css('display', 'block');
     result = false;
     }
     if (productName == '') {
     $('#productError').text('Please choose product Name');
     $('#productError').css('display', 'block');
     result = false;
     }

     });

     // valid user
     if (user == '') {
     $('#productError').text('Please Select User');
     $('#productError').css('display', 'block');
     result = false;
     }

     // valid Product Item
     var itemId = $('select[name="OrderLineItem[product_id][]"]').map(function () {
     return this.value;
     }).toArray();
     var hasDups = !itemId.every(function (v, i) {
     return itemId.indexOf(v) == i;
     });
     if (hasDups) {
     $('#productError').text('Please Check, Duplicate Product not allowed');
     $('#productError').css('display', 'block');
     result = false;
     }

     return result;
     });*/

    $("#submit_button").on("click", function() {
        var result = true;
        var duration = $('#ProductSubscription_duration').val();
        var duration_denomination = $('#ProductSubscription_duration_denomination').val();
        var billing_cycle = $('#ProductSubscription_billing_cycles').val();
        var starting_date = $('#ProductSubscription_starts_at').val();
        var subscription = $('#OrderInfo_is_subscription_enabled').val();
        if (subscription == '1') {
            if (duration == '') {
                $('#sub_duration').addClass('has-error');
                $('#duration_sub').text('Please enter duration!');
                // console.info('hi');
                result = false;
            } else if (isNaN(duration)) {
                $('#sub_duration').addClass('has-error');
                $('#duration_sub').text('Please enter digits!');
                result = false;
            } else if (duration_denomination == '') {
                $('#sub_duration').removeClass('has-error');
                $('#duration_sub').css('display', 'none');

                result = false;
            } else if (billing_cycle == '') {
                $('#sub_duration').removeClass('has-error');
                $('#duration_sub').css('display', 'none');

                $('#sub_billing_cycles').addClass('has-error');
                $('#billing_cycles_sub').text('Enter the number of billing cycles..');
                // console.info('hi3');
                result = false;
            } else if (isNaN(billing_cycle)) {
                $('#sub_duration').removeClass('has-error');
                $('#duration_sub').css('display', 'none');

                $('#sub_billing_cycles').addClass('has-error');
                $('#billing_cycles_sub').text('Enter the only digits..');
            } else if (starting_date == '') {
                $('#sub_billing_cycles').removeClass('has-error');
                $('#billing_cycles_sub').css('display', 'none');

                $('#sub_starting_date').addClass('has-error');
                $('#starting_date_sub').text('Choose the starting date of your subscription..');
                // console.info('hi4');
                result = false;
            } else {
                $('#sub_starting_date').removeClass('has-error');
                $('#starting_date_sub').css('display', 'none');
            }

        }

        var user = $('#OrderInfo_user_id').val();

        // valid user
        if (user == '') {
            $('#user').addClass('has-error');
            $('#user_msg').text('Please Select User');
            result = false;
        }

        //valid product
        var productName = $('#OrderLineItem_product_name').val();
        if (productName == '') {
            $('#product_msg').text('Please choose product Name');
            $('#product').addClass('has-error');
            result = false;
        }

        //Payment Errors
        var payment_mode = $('#OrderPayment_payment_mode').val();
        if (payment_mode == '') {
            $('#payment_mode').addClass('has-error');
            $('#payment_mode_msg').text('Please select Payment mode');
            result = false;
        }
        if ($('#OrderPayment_payment_ref_id').val() == '') {
            $('#payment_ref').addClass('has-error');
            $('#payment_ref_msg').text('Please enter payment reference');
            result = false;
        }
        if ($('#OrderPayment_payment_date').val() == '') {
            $('#payment_date').addClass('has-error');
            $('#payment_date_msg').text('Please select payment date');
            result = false;
        }

        var address = $('#orderAddress').val();

        // $('#productError').text('');
        $('.addMoreProduct').each(function(index, element) {
            var productQty = $(this).find('#OrderLineItem_item_qty').val();
            var qty = ($('#OrderLineItem_item_qty').val()) ? $('#OrderLineItem_item_qty').val() : 0;
            if (qty == 0) {
                // console.info(qty);
                $('#qty').addClass('has-error');
                $('#qty_msg').text('Please enter quantity');
            }
            if (productQty != '') {
                var regex = /[0-9]/;
                if (regex.test(productQty)) {
                    if (productQty <= 0) {
                        $('#productError').text('Please Enter valid quantity');
                        $('#productError').css('display', 'block');
                        result = false;
                    } else {
                        //result = checkQty(productName,productQty);
                    }
                } else {
                    $('#productError').text('Please Enter only Number');
                    $('#productError').css('display', 'block');
                    result = false;
                }
            } else {
                $('#productError').text('Please enter product quantity');
                $('#productError').css('display', 'block');
                result = false;
            }
        });

        // valid Product Item
        var itemId = $('select[name="OrderLineItem[product_id][]"]').map(function() {
            return this.value;
        }).toArray();
        var hasDups = !itemId.every(function(v, i) {
            return itemId.indexOf(v) == i;
        });
        if (hasDups) {

            $('#productError').text('Please Check, Duplicate Product not allowed');
            $('#productError').css('display', 'block');
            result = false;
        }

        return result;

    });

    // change password validate and submit in user-info
    $("form[id='usersChangePassword']").validate({
        debug: true,
        errorClass: "help-block",
        errorElement: "div",
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            'UserInfo[newPassword]': {
                required: true,
                custompassword: true,
            },
            'UserInfo[confirmPassword]': {
                required: true,
                equalTo: '#UserInfo_newPassword'
            }
        },
        messages: {
            'UserInfo[newPassword]': {
                required: "Please enter new password",
            },
            'UserInfo[confirmPassword]': {
                required: "Please enter confirm password",
                equalTo: "The Password you entered doesn’t match."
            }
        },
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            $(element).parent().parent().addClass('has-error');
            //$('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).parent().parent().removeClass('has-error');
        },
        submitHandler: function(form) {
            $.ajax({
                url: changePassword,
                type: "post",
                data: $(form).serializeArray(),
                success: function(response) {
                    var Result = JSON.parse(response);
                    if (Result.result == true) {
                        $('#passwordMessage').text('Password successfully change');
                        $('#passwordMessage').css('display', 'block');
                        $('#passwordError').css('display', 'none');
                    } else {
                        $('#passwordError').text(Result.error);
                        $('#passwordError').css('display', 'block');
                    }
                }
            });
        }
    });

    //custom validation rule
    $.validator.addMethod("custompassword",
        function(value, element) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/.test(value);
        },
        "Password must contain atleast 8 characters including atleast 1 upprcase ,1 lower case and a number."
    );

    // change password validate and submit in sysUsers
    $("form[id='sysUsersChangePassword']").validate({
        debug: true,
        errorClass: "help-block",
        errorElement: "div",
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            'SysUsers[newPassword]': {
                required: true,
                minlength: 6
            },
            'SysUsers[confirmPassword]': {
                required: true,
                equalTo: '#SysUsers_newPassword'
            }
        },
        messages: {
            'SysUsers[newPassword]': {
                required: "Please enter new password",
                minlength: "Your password must be at least 6 characters long"
            },
            'SysUsers[confirmPassword]': {
                required: "Please enter confirm password",
                equalTo: "Please enter the same password as above"
            }
        },
        highlight: function(element, errorClass) {
            console.log("a");
            $(element).removeClass(errorClass);
            $(element).parent().parent().addClass('has-error');
            //$('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).parent().parent().removeClass('has-error');
        },
        submitHandler: function(form) {
            console.log("a");
            $.ajax({
                url: changePassword,
                type: "post",
                data: $(form).serializeArray(),
                success: function(response) {
                    var Result = JSON.parse(response);
                    if (Result.result == true) {
                        $('#passwordMessage').text('Password successfully change');
                        $('#passwordMessage').css('display', 'block');
                        $('#passwordError').css('display', 'none');
                    } else {
                        $('#passwordError').text(Result.error);
                        $('#passwordError').css('display', 'block');
                    }
                }
            });
        }
    });
});
// set Price total,discount,net total
function setPriceTotal() {
    var totalPrice = parseInt(0);
    var totalDiscount = parseInt(0);
    $(".addMoreProduct").each(function() {
        if ($(this).find('#itemPrice').val() != '') {
            totalPrice += parseInt($(this).find('#itemPrice').val());
            totalDiscount += parseInt($(this).find('#OrderLineItem_item_disc').val());
        }
        //totalDiscount = totalDiscount + parseInt($(this).find('#OrderLineItem_item_disc').val());
    });

    var subTotal = totalPrice - totalDiscount;
    var netTotal = totalPrice; // - totalDiscount;
    $('#totalPrice').text(subTotal);
    $('#totalDiscount').text(totalDiscount);
    $('#netTotal').text(subTotal);
}

function prettyJson(id, object) {
    document.getElementById(id).innerHTML = "";
    document.getElementById(id).appendChild(document.createTextNode(JSON.stringify(object, null, 4)));
}

// string for define local storage variable name
var myString = window.location.pathname;
var defineVarName = myString.replace(/[^a-z0-9\s]/gi, '');

// set columns name in admin grid
function gridDropDown(dropCheckbox) {
    var id = dropCheckbox.id;
    var splitid = id.split("_");
    var colno = splitid[1];
    var checked = true;

    // Checking Checkbox state
    if ($(dropCheckbox).is(":checked")) {
        checked = true;
    } else {
        checked = false;
    }
    if (checked) {
        localStorage.setItem(dropCheckbox.id, true);
        $('#DataTables_Table_0 td:nth-child(' + colno + ')').show();
        $('#DataTables_Table_0 th:nth-child(' + colno + ')').show();
    } else {
        localStorage.setItem(dropCheckbox.id, false);
        $('#DataTables_Table_0 td:nth-child(' + colno + ')').hide();
        $('#DataTables_Table_0 th:nth-child(' + colno + ')').hide();
        $("#select_all")[0].checked = false;
        localStorage.setItem('selectAll', false);
    }

    var count = 0;
    var flag = 0;
    $('.hidecol').each(function() {
        if ($(this).attr('id') != 'select_all') {
            flag++;
            if ($(this).is(":checked")) {
                count++;
            }
        }
    });
    if (count == flag) {
        $("#select_all")[0].checked = true;
        localStorage.setItem('selectAll', true);
    }
}

// on load local storage value if exits and set drop down in admin
$(window).on('load', function() {
    // code here
    var fieldVal = [];
    $(".dataTable th").each(function(k, v) {
        k++;
        if (typeof(Storage) !== "undefined") {
            if (localStorage.getItem(defineVarName + 'col_' + k) !== null) {
                if (localStorage.getItem(defineVarName + 'col_' + k) == 'true') {
                    $('#DataTables_Table_0 td:nth-child(' + k + ')').show();
                    $('#DataTables_Table_0 th:nth-child(' + k + ')').show();
                    fieldVal[k] = '<li><input type="checkbox" class="hidecol" value="' + $(v).text() + '" id="' + defineVarName + 'col_' + k + '" onclick="gridDropDown(' + defineVarName + 'col_' + k + ')" checked="checked"/>' + $(v).text() + '</li>';
                } else {
                    $('#DataTables_Table_0 td:nth-child(' + k + ')').hide();
                    $('#DataTables_Table_0 th:nth-child(' + k + ')').hide();
                    fieldVal[k] = '<li><input type="checkbox" class="hidecol" value="' + $(v).text() + '" id="' + defineVarName + 'col_' + k + '" onclick="gridDropDown(' + defineVarName + 'col_' + k + ')" />' + $(v).text() + '</li>';
                }
            } else {
                localStorage.setItem(defineVarName + 'col_' + k, 'true');
                fieldVal[k] = '<li><input type="checkbox" class="hidecol" value="' + $(v).text() + '" id="' + defineVarName + 'col_' + k + '" onclick="gridDropDown(' + defineVarName + 'col_' + k + ')" checked="checked"/>' + $(v).text() + '</li>';
            }
        }
    });
    $('#userList').append(fieldVal);
    $("#userList li:nth-child(2)").remove();
});

$(function() {
    $("form[name='UserCreate']").validate({
        debug: true,
        errorClass: "help-block error text-right animated fadeInDown",
        errorElement: "div",
        onfocusout: false,
        onkeyup: false,
        rules: {
            'UserInfo[first_name]': {
                required: true
                    // lettersonly: true
            },
            'UserInfo[last_name]': {
                required: true
                    // lettersonly: true
            },
            'UserInfo[city]': {
                required: true
            },
            /*'UserInfo[busAddress_city]': {
                required: true
            },*/
            'UserInfo[postcode]': {
                required: true,
                number: true
            },
            'UserInfo[street]': {
                required: true
            },
            'UserInfo[phone]': {
                number: true
                    // minlength: 8,
                    // maxlength: 10
            },
            'UserInfo[business_phone]': {
                number: true
                    // minlength: 8,
                    // maxlength: 10
            },
            'UserInfo[sponsor_id]': {
                required: true
            },
            'UserInfo[password]': {
                required: true
                    // minlength: 8
            },
            /*'UserInfo[region]': {
                required: true
            },
            'UserInfo[busAddress_region]': {
                required: true
            },*/
            'UserInfo[date_of_birth]': {
                required: true
            },
            /*'UserInfo[country]': {
                required: true
            },*/
            'UserInfo[email]': {
                required: {
                    depends: function() {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                customemail: true
            },
            'UserInfo[role]': {
                required: true
            },
        },
        messages: {
            'UserInfo[first_name]': {
                required: "Please enter first name",
                // lettersonly: "Please Enter only letters"
            },
            'UserInfo[last_name]': {
                required: "Please enter last name",
                // lettersonly: "Please Enter only letters"
            },
            'UserInfo[city]': {
                required: "Please enter city name"
            },
            /*'UserInfo[busAddress_city]': {
                required : "Please Enter business city"
            },*/
            'UserInfo[postcode]': {
                required: "Please Enter postcode",
                number: "Postcode must be number"
            },
            'UserInfo[street]': {
                required: "Please Enter street"
            },
            'UserInfo[sponsor_id]': {
                required: "Please Select Sponser"
            },
            'UserInfo[password]': {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
            /*'UserInfo[region]': {
                required: "Please enter region"
            },
            'UserInfo[busAddress_region]': {
                required: "Please enter business region"
            },*/
            'UserInfo[date_of_birth]': {
                required: "Please Select Date Of Birth"
            },
            /*'UserInfo[country]': {
                required: "Please Select Country"
            },*/
            'UserInfo[role]': {
                required: "Please Select role"
            }

        },
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            $(element).parent().parent().addClass('has-error');
            return false;
            //$('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).parent().parent().removeClass('has-error');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $(function() {
        $("form[name='SysUserCreate']").validate({
            debug: true,
            errorClass: "help-block error text-right animated fadeInDown",
            errorElement: "div",
            onfocusout: false,
            onkeyup: false,
            rules: {
                'SysUsers[username]': {
                    required: true,
                    lettersonly: true,
                },
                'SysUsers[password]': {
                    required: true,
                    minlength: 8,
                },
                'SysUsers[email]': {
                    required: true,
                    customemail: true
                }
            },
            messages: {
                'SysUsers[username]': {
                    required: "Please enter user name",
                    lettersonly: "Please Enter only letters"
                },
                'SysUsers[password]': {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long"
                },
                'SysUsers[email]': {
                    required: "Please enter your email"
                }
            },
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
                $(element).parent().parent().addClass('has-error');
                return false;
                //$('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).parent().parent().removeClass('has-error');
            },
            submitHandler: function(form) {
                form.submit();
            }
        })
    });

});
$(function() {
    $("form[name='UserUpdate']").validate({
        debug: true,
        errorClass: "help-block error text-right animated fadeInDown",
        errorElement: "div",
        onfocusout: false,
        onkeyup: false,
        rules: {
            'UserInfo[first_name]': {
                required: true
                    // lettersonly: true
            },
            'UserInfo[last_name]': {
                required: true
                    // lettersonly: true
            },
            'UserInfo[city]': {
                required: true
            },
            /*'UserInfo[busAddress_city]': {
                required: true
            },*/
            'UserInfo[postcode]': {
                required: true,
                number: true
            },
            'UserInfo[street]': {
                required: true
            },
            'UserInfo[phone]': {
                number: true
                    // minlength: 8,
                    // maxlength: 10
            },
            'UserInfo[business_phone]': {
                number: true
                    // minlength: 8,
                    // maxlength: 10
            },
            'UserInfo[sponsor_id]': {
                required: true
            },
            'UserInfo[password]': {
                required: true
                    // minlength: 8
            },
            /*'UserInfo[region]': {
                required: true
            },
            'UserInfo[busAddress_region]': {
                required: true
            },*/
            'UserInfo[date_of_birth]': {
                required: true
            },
            /*'UserInfo[country]': {
                required: true
            },*/
            'UserInfo[email]': {
                required: {
                    depends: function() {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                customemail: true
            },
            'UserInfo[role]': {
                required: true
            },
        },
        messages: {
            'UserInfo[first_name]': {
                required: "Please enter first name",
                // lettersonly: "Please Enter only letters"
            },
            'UserInfo[last_name]': {
                required: "Please enter last name",
                // lettersonly: "Please Enter only letters"
            },
            'UserInfo[city]': {
                required: "Please enter city name"
            },
            /*'UserInfo[busAddress_city]': {
                required : "Please Enter business city"
            },*/
            'UserInfo[postcode]': {
                required: "Please Enter postcode",
                number: "Postcode must be number"
            },
            'UserInfo[street]': {
                required: "Please Enter street"
            },
            'UserInfo[sponsor_id]': {
                required: "Please Select Sponser"
            },
            'UserInfo[password]': {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
            /*'UserInfo[region]': {
                required: "Please enter region"
            },
            'UserInfo[busAddress_region]': {
                required: "Please enter business region"
            },*/
            'UserInfo[date_of_birth]': {
                required: "Please Select Date Of Birth"
            },
            /*'UserInfo[country]': {
                required: "Please Select Country"
            },*/
            'UserInfo[role]': {
                required: "Please Select role"
            }

        },
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            $(element).parent().parent().addClass('has-error');
            return false;
            //$('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).parent().parent().removeClass('has-error');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $(function() {
        $("form[name='SysUserCreate']").validate({
            debug: true,
            errorClass: "help-block error text-right animated fadeInDown",
            errorElement: "div",
            onfocusout: false,
            onkeyup: false,
            rules: {
                'SysUsers[username]': {
                    required: true,
                    lettersonly: true,
                },
                'SysUsers[password]': {
                    required: true,
                    minlength: 8,
                },
                'SysUsers[email]': {
                    required: true,
                    customemail: true
                }
            },
            messages: {
                'SysUsers[username]': {
                    required: "Please enter user name",
                    lettersonly: "Please Enter only letters"
                },
                'SysUsers[password]': {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long"
                },
                'SysUsers[email]': {
                    required: "Please enter your email"
                }
            },
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
                $(element).parent().parent().addClass('has-error');
                return false;
                //$('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).parent().parent().removeClass('has-error');
            },
            submitHandler: function(form) {
                form.submit();
            }
        })
    });

});

//order update form
$(function() {
    let validator = $("#order-update-form").validate({
        debug: true,
        errorClass: "help-block error text-right animated fadeInDown",
        errorElement: "div",
        onfocusout: false,
        onkeyup: false,
        rules: {
            'UserInfo[city]': {
                required: true
            },
            'UserInfo[postcode]': {
                required: true,
                number: true
            },
            'UserInfo[street]': {
                required: true
            },
            'UserInfo[country]': {
                required: true
            },
            'OrderPayment[payment_mode]': {
                required: true
            },
            'OrderPayment[payment_ref_id]': {
                required: true
            }
        },
        messages: {
            'UserInfo[city]': {
                required: "Please enter city name"
            },
            'UserInfo[postcode]': {
                required: "Please Enter postcode",
                number: "Postcode must be number"
            },
            'UserInfo[street]': {
                required: "Please Enter street"
            },
            'UserInfo[country]': {
                required: "Please Select Country"
            },
            'OrderPayment[payment_mode]': {
                required: "Please Select Payment Mode"
            },
            'OrderPayment[payment_ref_id]': {
                required: "Please Enter Ref"
            }

        },
        highlight: function(element, errorClass) {
            //console.log(element.error());
            $(element).removeClass(errorClass);
            $(element).parent().parent().addClass('has-error');
            return false;
            //$('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).parent().parent().removeClass('has-error');
        },
        submitHandler: function(form) {
            //console.log("Form submitted");
            form.submit();
        }
    });
    //console.log(validator.errorList);
});



$('.admin-edit').on('click', function() {
    var data = $('#profile-email').val();
    $.ajax({
        url: EditAdmin,
        type: 'POST',
        data: { email: data },
        success: function(response) {
            $("#email-success-change").html("Email Successfull Updated");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error("could not delete field");
        }
    });
});
$('#profile-password-new-confirm').on('change', function() {
    var cur_pass = $('#profile-password').val(),
        new_pass = $('#profile-password-new').val(),
        reenter_pass = $('#profile-password-new-confirm').val();
    if (new_pass === reenter_pass) {
        $("#check").html("Password matched");
        $("#check").removeClass("no-match");
    } else {
        $("#check").html("Password not matched");
        $("#check").addClass("no-match");
    }
});
$('.change-pass').on('click', function() {
    var cur_pass = $('#profile-password').val(),
        new_pass = $('#profile-password-new').val(),
        reenter_pass = $('#profile-password-new-confirm').val();
    if (cur_pass && new_pass && reenter_pass && new_pass === reenter_pass) {
        $.ajax({
            url: ChangePass,
            type: 'POST',
            data: { current_pass: cur_pass, New_Pass: new_pass },
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.token == 1) {
                    $("#pass-mismatch").html("Current password not matched");
                    $("#pass-mismatch").addClass("no-match");
                }
                if (res.msg == "Success") {
                    $("#pass-mismatch").html(" ");
                    $("#password-success-change").html("Password Changed Successfully!");
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error("could not delte field");
            }
        });
    }
});

//custom validation rule
$.validator.addMethod("customemail",
    function(value, element) {
        return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
    },
    "Invalid Email Address, Please Enter Valid Email."
);

$.validator.addMethod("alphanumeric",
    function(value, element) {
        return /^[A-Za-z0-9]+$/.test(value);
    },
    "Please Enter Only Alphanumeric Value."
);


$(function() {
    $("form[name='CreateOrder']").validate({
        debug: true,
        errorClass: "help-block error text-right animated fadeInDown",
        errorElement: "div",
        onfocusout: false,
        onkeyup: false,
        rules: {
            'OrderInfo[user_id]': {
                required: true

            },
            'OrderLineItem[product_id][]': {
                required: true
            },
            'OrderLineItem[item_qty][]': {
                required: true,
                number: true
            },
            'OrderPayment[payment_mode]': {
                required: true
            },
            'OrderPayment[payment_ref_id]': {
                required: true
            },
            'OrderPayment[payment_date]': {
                required: true
            }
        },
        messages: {
            'OrderInfo[user_id]': {
                required: "Please Select User"
            },
            'OrderLineItem[product_id][]': {
                required: "Please Select Product Name"
            },
            'OrderLineItem[item_qty][]': {
                required: "Please Enter Quantity",
                number: "Please Enter Only Number"
            },
            'OrderPayment[payment_mode]': {
                required: "Please Select Payment Mode"
            },
            'OrderPayment[payment_ref_id]': {
                required: "Please Enter Payment Refernce"
            },
            'OrderPayment[payment_date]': {
                required: "Please Select Payment Date"
            },

        },
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            $(element).parent().parent().addClass('has-error');
            return false;
            //$('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).parent().parent().removeClass('has-error');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});

$("#select_all").change(function() { //"select all" change

    var status = this.checked; // "select all" checked status

    $('.hidecol').each(function() { //iterate all listed checkbox items
        var id = $(this).attr('id'); //.id;
        var splitid = id.split("_");
        var colno = splitid[1];
        var colname = splitid[0];
        if ($('#select_all').is(":checked")) {
            localStorage.setItem('selectAll', true);
            if (id != 'select_all') {
                localStorage.setItem(id, true);
                localStorage.setItem(colname + '_1', true);
                $('#DataTables_Table_0 td:nth-child(' + colno + ')').show();
                $('#DataTables_Table_0 th:nth-child(' + colno + ')').show();
                $('#DataTables_Table_0 th:nth-child(1)').show();
                $('#DataTables_Table_0 td:nth-child(1)').show();
            }
        } else {
            localStorage.setItem('selectAll', false);
            if (id != 'select_all') {
                localStorage.setItem(id, false);
                localStorage.setItem(colname + '_1', false);
                $('#DataTables_Table_0 td:nth-child(' + colno + ')').hide();
                $('#DataTables_Table_0 th:nth-child(' + colno + ')').hide();
                $('#DataTables_Table_0 th:nth-child(1)').hide();
                $('#DataTables_Table_0 td:nth-child(1)').hide();
                checked = false;
            }
        }
        this.checked = status; //change ".checkbox" checked status
    });

});

$('.hidecol').change(function() { //".checkbox" change
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if (this.checked == false) { //if this item is unchecked
        $("#select_all")[0].checked = false; //change "select all" checked status to false
    }

    //check "select all" if all checkbox items are checked
    if ($('.hidecol:checked').length == $('.hidecol').length) {
        $("#select_all")[0].checked = true; //change "select all" checked status to true
    }
});

$(window).on('load', function() {
    var url = window.location.pathname.split("/");
    var action = url[3];
    if (action == 'admin') {
        if (localStorage.getItem('selectAll') == 'true') {
            $("#select_all")[0].checked = true;
        } else {
            $("#select_all")[0].checked = false;
        }
    }
});

// $("#unilevelplan-plan-form").validate({
//     debug: true,
//     errorClass: "help-block animated fadeInDown",
//     errorElement: "div",
//     onfocusout: false,
//     onkeyup: false,
//     onclick: false,
//     rules: {
//         'Compensations[level]': {
//             required: true,
//             number: true,
//         },
//         'Compensations[rank]': {
//             required: true,
//             number: true,
//         },
//         'Compensations[amount]': {
//             required: true,
//             number: true,
//         },
//         'Compensations[denomination]': {
//             required: true,
//         }
//     },
//     messages: {
//         'Compensations[level]': {
//             required: 'Please enter level',
//             number: true,
//         },
//         'Compensations[rank]': {
//             required: 'Please enter rank',
//             number: true,
//         },
//         'Compensations[amount]': {
//             required: 'Please enter amount',
//             number: true,
//         },
//         'Compensations[denomination]': {
//             required: 'Please enter denomination',
//         }
//     },
//     highlight: function (element, errorClass) {
//         $(element).removeClass(errorClass);
//         $(element).parent().parent().addClass('has-error');
//         //$('.form-group').addClass('has-error');
//     },
//     unhighlight: function (element) {
//         $(element).parent().parent().removeClass('has-error');
//     },
//     submitHandler: function (form) {
//
//     }
// });

$("#create_pool_plan").click(function() {
    if (!$("#user_multi_select").val()) {
        $('#multi_user_error').html('<div id="Compensations_level-error" class="help-block animated fadeInDown">Please enter users</div>');
        $('#multi_user_error').parent().parent().addClass('has-error');
        $("label[for='userSelect']").css('color', '#d26a5c');
        return false;
    } else {
        $('#multi_user_error').html('');
        $('#multi_user_error').parent().parent().removeClass('has-error');
        $("label[for='userSelect']").css('color', '#646464');
    }
});

$("#create_pool_plan").click(function() {
    if (!$("#PoolPlan_pool_amount").val()) {
        $('#amount_error').html('<div id="Compensations_level-error" class="help-block animated fadeInDown">Please enter users</div>');
        $('#amount_error').parent().parent().addClass('has-error');
        return false;
    } else {
        $('#amount_error').html('');
        $('#amount_error').parent().parent().removeClass('has-error');
        return true;
    }
});

$("#create_pool_plan").click(function() {
    if (!$("#PoolPlan_pool_name").val()) {
        $('#poolName_error').html('<div id="Compensations_level-error" class="help-block animated fadeInDown">Please enter users</div>');
        $('#poolName_error').parent().parent().addClass('has-error');
        return false;
    } else {
        $('#poolName_error').html('');
        $('#poolName_error').parent().parent().removeClass('has-error');
    }
});

$("#create_pool_plan").click(function() {
    if (!$("#PoolPlan_pool_denomination").val()) {
        $('#denomination_error').html('<div id="Compensations_level-error" class="help-block animated fadeInDown">Please enter users</div>');
        $('#denomination_error').parent().parent().addClass('has-error');
        return false;
    } else {
        $('#denomination_error').html('');
        $('#denomination_error').parent().parent().removeClass('has-error');
    }
});

$('.select-all').click(function () {
    let $select2 = $(this).parent().siblings('.js-select2')
    $select2.find('option').prop('selected', 'selected')
    $select2.trigger('change')
})
$('.deselect-all').click(function () {
    let $select2 = $(this).parent().siblings('.js-select2')
    $select2.find('option').prop('selected', '')
    $select2.trigger('change')
})