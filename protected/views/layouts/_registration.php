<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo Yii::app()->request->baseUrl; ?>/images/registration/favicon.png">
    <title>CashBack Matrix</title>
    <?php

    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/bootstrap.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/wizard/steps.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/style.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style1.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/blue.css');

    ?>
    <script src="<?php echo Yii::app()->request->baseUrl ?>/js/newtheme/jquery.min.js"></script>
</head>
<body class="fix-header card-no-border">
<div class="banner-header">
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 align-items-center">
                    <div class="logo"><a class="js-scroll-trigger" href="#"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/registration/logo.svg"></a></div>
                    <div class="button">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="<?php echo Yii::app()->request->baseUrl ?>/images/registration/user.png">
                            </div>
                            <div class="col-md-5 no-mobile">
                                <h6 class="card-subtitle" style="margin-bottom: 0px">Step 1:</h6>
                                <h4 class="card-title">Registration</h4>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center text-blue text-uppercase wow fadeInUp" data-wow-delay="100ms">Join the <span class="text-pink text-semibold">#1</span> investment opportunity.</h3>
                <h3 class="text-center text-pink text-uppercase text-semibold mb2 wow fadeInUp" data-wow-delay="200ms">Get the double profit stream with CBM Global!</h3>

            </div>
        </div>
    </div>
</div>
<?php echo $content; ?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="logo"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/registration/icon-logo.svg"></div>
                <ul class="social-icons">
                    <li><a href="https://www.facebook.com/CBMglobal.io" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
                    <li><a href="https://twitter.com/CBMglobal" target="_blank"><i class="fab fa-twitter-square"></i></a></li>
                </ul>
                <ul class="footer-links">
                    <li><a href="#">Terms and Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                </ul>
                <div class="copyright">© <?php echo date('Y');?> CBM Global.IO. All rights reserved.</div>
                <div class="risk-warning">Risk Warning: You should know that trading foreign exchange (forex) and contracts for difference (cfds) carries a high level of risk to your capital including losing more than your initial deposit. Forex and cfds are leveraged products and the effect of leverage is that both gains and losses are magnified. The past performance of a financial instrument is no guarantee or indicator of future performance. Trading forex and cfds may not be suitable for all investors, so please ensure that you fully understand the risks involved, and seek independent financial advice if necessary. You should only trade forex if you have sufficient investing experience and knowledge, a thorough understanding of the risks involved and if you are dealing with money that you can afford to lose.</div>
            </div>
        </div>
    </div>
</footer>
<script src="<?php echo Yii::app()->request->baseUrl ?>/js/newtheme/popper.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/js/newtheme/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/js/newtheme/jquery.slimscroll.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/js/newtheme/waves.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/js/newtheme/sidebarmenu.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/js/newtheme/sticky-kit.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/js/newtheme/jquery.sparkline.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/js/newtheme/custom.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/wizard/jquery.steps.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/wizard/jquery.validate.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/wizard/steps.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/js/newtheme/jQuery.style.switcher.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#business").hide();
        /*$("#market-mail").hide();*/
        /*$("#system-mail").hide();*/
        $("#footer").load("footer.html");
        $("#privacy-error").remove();

    });


    $('#checkbox1').on('click', function() {
        if ($('#checkbox1').is(":checked")){
            $("#business-address").show();
        }
        else {
            $("#business-address").hide();
        }
    });


    /*$('#checkbox4').on('click', function() {
        if ($('#checkbox4').is(":checked")){
            $("#market-mail").show();
        }
        else {
            $("#market-mail").hide();
        }
    });

    $('#checkbox3').on('click', function() {
        if ($('#checkbox3').is(":checked")){
            $("#system-mail").show();
        }
        else {
            $("#system-mail").hide();
        }
    });*/

    $('body').on('change','#users-info-form input', function() {
        var value = ($('input[name=radio]:checked', '#users-info-form').val());
        if(value == 1){
            $("#business").show();
            if ($('#checkbox1').is(":checked")){
                $("#business-address").show();
            }
            else {
                $("#business-address").hide();
            }
        }
        else{
            $("#business").hide();
        }
        $('#payoutdetail').on('click', function() {
            if ($('#payoutdetail').is(":checked")){
                $("#bank-detail").show();
            }
            else {
                $("#bank-detail").hide();
            }
        });

    });

    var form1 = $(".validation-wizard1").show();

    $(".validation-wizard1").steps({
        headerTag: "h6"
        , bodyTag: "section"
        , transitionEffect: "fade"
        , titleTemplate: '<span class="step">#index#</span> #title#'
        , labels: {
            finish: "Submit"
        }
        , onStepChanging: function (event, currentIndex, newIndex) {
            return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form1.find(".body:eq(" + newIndex + ") label.error").remove(), form1.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form1.validate().settings.ignore = ":disabled,:hidden", form1.valid())
        }
        /*, onFinishing: function (event, currentIndex) {
            return form.validate().settings.ignore = ":disabled", form.valid()
        }*/
        , onFinished: function (event, currentIndex) {
            var form = $(this);
            // Submit form input
            form.submit();
            /*if($('#privacy').prop('checked') == true){
                form.submit();
            } else {
                $('#privacy').parent().parent().addClass("text-danger");
            }*/

        }
    });

    $(".validation-wizard1").validate({
        ignore: ".ignore",
        errorClass: "text-danger",
        errorElement: "span",
        successClass: "text-success",
        highlight: function (element, errorClass) {
            $(element).parent().parent().addClass(errorClass);

        },
        unhighlight: function (element, errorClass) {
            $(element).parent().parent().removeClass(errorClass);

        },
        errorPlacement: function (error, element) {
            jQuery(element).parents('.form-group ').append(error);
        },
        rules: {
            'UserInfo[first_name]':{
                required: true,
            },
            'UserInfo[last_name]':{
                required: true,
            },
            'UserInfo[email]': {
                required: true,
                email: true,
                remote: {
                    url: '<?php  echo Yii::app()->createUrl("home/checkEmail");  ?>',
                    type: 'post',
                    data: {
                        'UserInfo[email]': function () {
                            return $('#email').val();
                        }
                    }
                }
            },
            'confirm_email':{
                required: true,
                equalTo: '#email'
            },
            'UserInfo[phone]':{
                required: true,
                number: true,
            },
            'UserInfo[date_of_birth]':{
                required: true,
            },
            'UserInfo[street]': {
                required: true
            },
            'UserInfo[building_num]': {
                required: true
            },
            'UserInfo[city]': {
                required: true
            },
            'UserInfo[postcode]': {
                required: true,
                //number: true
            },
            'UserInfo[country]': {
                required: true
            },
            'UserInfo[language]':{
                required:true
            },
            'UserInfo[password]': {
                required: true,
                // custompassword: true
            },
            'UserInfo[business_name]': {
                required: true
            },
            'confirm_password': {
                required: true,
                equalTo: '#password'
            },
            'UserInfo[busAddress_street]': {
                required: true
            },
            'UserInfo[busAddress_building_num]': {
                required: true
            },
            'UserInfo[busAddress_city]': {
                required: true
            },
            'UserInfo[busAddress_postcode]': {
                required: true,
                //number: true
            },
            'UserInfo[busAddress_country]': {
                required: true
            },
            payout_bank:{
                required: true
            },
            /*payout_iban:{
                required: true
            },
            payout_accountname: {
                required: true
            },
            payout_biccode: {
                required: true
            },
            payout_post: {
                //number: true
            },*/
            privacy:{
                required:true
            }

        },
        messages:{
            'UserInfo[first_name]': {
                required: "Please enter first name.",
            },
            'UserInfo[last_name]': {
                required: "Please enter last name.",
            },
            'UserInfo[email]': {
                required: "Please enter email.",
                email: "Please enter valid email.",
                remote: "Email Already Exist in System."
            },
            'confirm_email': {
                required: "Please enter confirm email.",
                equalTo: "The Email you entered doesn’t match."
            },
            'UserInfo[phone]':{
                required: "Please enter phone number.",
                number: "it contains only numbers.",
            },
            'UserInfo[date_of_birth]': {
                required: "Please select your date of birth."
            },
            'UserInfo[street]': {
                required: "Please enter street name."
            },
            'UserInfo[building_num]': {
                required: "Please enter house number."
            },
            'UserInfo[city]': {
                required: "Please enter city name."
            },
            'UserInfo[postcode]': {
                required: "Please enter postcode.",
                //number: "Postcode must be number."
            },
            'UserInfo[country]': {
                required: "Please select country."
            },
            'UserInfo[language]': {
                required: "Please select language."
            },
            'UserInfo[password]': {
                required: "Please enter password.",
            },
            'confirm_password': {
                required: "Please enter confirm password.",
                equalTo: "The Password you entered doesn’t match."
            },
            'UserInfo[business_name]': {
                required: "Please enter Company Name."
            },
            'UserInfo[busAddress_street]': {
                required: "Please enter street name."
            },
            'UserInfo[busAddress_building_num]': {
                required: "Please enter house number."
            },
            'UserInfo[busAddress_city]': {
                required: "Please enter city name."
            },
            'UserInfo[busAddress_postcode]': {
                required: "Please enter postal code.",
                //number: "Postcode must be number."
            },
            'UserInfo[busAddress_country]': {
                required: "Please select country."
            },
            payout_bank: {
                required: "Please enter bank name."
            },
            /*payout_iban: {
                required: "Please enter IBAN."
            },
            payout_accountname: {
                required: "Please enter account name."
            },
            payout_biccode: {
                required: "Please enter BIC Code."
            },
            payout_post: {
                //number: "Postcode must be number."
            },*/
            privacy:{
                required: ""
            }
        },
    });

    //custom validation rule
    /*$.validator.addMethod("custompassword",
        function (value, element) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/.test(value);
        },
        "Password must contain atleast 8 characters including atleast 1 upprcase ,1 lower case and a number."
    );*/
</script>
</body>
</html>

