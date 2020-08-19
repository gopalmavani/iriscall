<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="format-detection" content="telephone=no">
    <meta name="authoring-tool" content="Adobe_Animate_CC">
    <title>CashBack Matrix</title>
    <?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/bootstrap.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/registrationStyle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/registrationResponsive.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/animate/animate.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/createjs.min.js', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/intro/intro.js');
    ?>
    <script>
        var canvas, stage, exportRoot, anim_container, dom_overlay_container, fnStartAnimation;
        function init() {
            canvas = document.getElementById("canvas");
            anim_container = document.getElementById("animation_container");
            dom_overlay_container = document.getElementById("dom_overlay_container");
            var comp=AdobeAn.getComposition("EA5571A2295DF7458D9934B992E3E739");
            var lib=comp.getLibrary();
            var loader = new createjs.LoadQueue(false);
            loader.addEventListener("fileload", function(evt){handleFileLoad(evt,comp)});
            loader.addEventListener("complete", function(evt){handleComplete(evt,comp)});
            var lib=comp.getLibrary();
            loader.loadManifest(lib.properties.manifest);
        }
        function handleFileLoad(evt, comp) {
            var images=comp.getImages();
            if (evt && (evt.item.type == "image")) { images[evt.item.id] = evt.result; }
        }
        function handleComplete(evt,comp) {
            //This function is always called, irrespective of the content. You can use the variable "stage" after it is created in token create_stage.
            var lib=comp.getLibrary();
            var ss=comp.getSpriteSheet();
            var queue = evt.target;
            var ssMetadata = lib.ssMetadata;
            for(i=0; i<ssMetadata.length; i++) {
                ss[ssMetadata[i].name] = new createjs.SpriteSheet( {"images": [queue.getResult(ssMetadata[i].name)], "frames": ssMetadata[i].frames} )
            }
            exportRoot = new lib.intro();
            stage = new lib.Stage(canvas);
            stage.enableMouseOver();
            //Registers the "tick" event listener.
            fnStartAnimation = function() {
                stage.addChild(exportRoot);
                createjs.Ticker.framerate = lib.properties.fps;
                createjs.Ticker.addEventListener("tick", stage);
            }
            //Code to support hidpi screens and responsive scaling.
            AdobeAn.makeResponsive(true,'both',true,1,[canvas,anim_container,dom_overlay_container]);
            AdobeAn.compositionLoaded(lib.properties.id);
            fnStartAnimation();
        }
    </script>
</head>
<body onload="init();" id="intro" class="demo bg-light-blue">
<!-- ########## Wrapper Start ########## -->
<div class="wrapper">
    <!-- ########## Page Content Start ########## -->
    <div class="wrap-demovideo">
        <div id="animation_container">
            <canvas id="canvas"></canvas>
            <div id="dom_overlay_container"></div>
        </div>
        <div class="button-bl text-center">
            <div class="wow fadeInUp" data-wow-delay="200ms">
                <a href="#" target="_blank" class="btn">View Full Demo</a>
                <a href="#" class="btn wow fadeInRight" data-wow-delay="200ms">Proceed With Registration</a>
            </div>
        </div>
    </div>
    <!-- ########## Page Content End ########## -->
</div>
<!-- ########## Wrapper End ########## -->
<?php /*echo $content; */?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/bootstrap.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/animate/animate.min.js');
?>
<script type="text/javascript">
    $(document).ready(function(){
        /*$("#business").hide();
        $("#footer").load("footer.html");
        $("#privacy-error").remove();*/
        new WOW().init();
    });


    /*$('#checkbox1').on('click', function() {
        if ($('#checkbox1').is(":checked")){
            $("#business-address").show();
        }
        else {
            $("#business-address").hide();
        }
    });*/


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

    /*$('body').on('change','#users-info-form input', function() {
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

    });*/

    //var form1 = $(".validation-wizard1").show();

    /*$(".validation-wizard1").steps({
        headerTag: "h6"
        , bodyTag: "section"
        , transitionEffect: "fade"
        , titleTemplate: '<span class="step">#index#</span> #title#'
        , labels: {
            finish: "Submit"
        }, onStepChanging: function (event, currentIndex, newIndex) {
            return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form1.find(".body:eq(" + newIndex + ") label.error").remove(), form1.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form1.validate().settings.ignore = ":disabled,:hidden", form1.valid())
        }, onFinished: function (event, currentIndex) {
            var form = $(this);
            // Submit form input
            form.submit();
        }
    });*/

    /*$(".validation-wizard1").validate({
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
                    url: checkEmailUrl,
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
            privacy:{
                required: ""
            }
        },
    });*/

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

