<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="format-detection" content="telephone=no">
    <meta name="authoring-tool" content="Adobe_Animate_CC">
    <title>Micromaxcash</title>
    <?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/bootstrap.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/registrationStyle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/registrationResponsive.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/toastr.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/animate/animate.min.css');
    ?>
    <style>
        #step1-registration{
            background: #044e80 !important;
        }
        .boxshadow-content{
            background: #FFF !important;
        }
    </style>
</head>
<body id="step1-registration">
<div class="wrapper">
    <?php //include("registrationSidebar.php"); ?>
    <div id="content" style="margin-left: unset !important;">
        <div class="content-inner">
            <!--<div class="btnCollapse"> <i></i> </div>-->
            <div class="container">
                <div class="row mb9 mb6-md">
                    <div class="col-md-12 text-center">
                        <div class="logo mb3 wow fadeInUp" data-wow-delay="100ms"><img src="<?= Yii::app()->baseUrl. '/images/logo-sio-icon.png'; ?>" class="img-fluid"></div>
                    </div>
                </div>
                <div class="row mb3">
                    <div class="col-md-12 text-center">
                        <div class="email-box wow fadeInUp boxshadow-content">
                            <h4 class="text-blue text-semibold text-center mb2 mbsm1 text-uppercase wow fadeInUp" data-wow-delay="200ms">
                                Welcome to MMC !
                            </h4>
                            <p class="mb3 mbsm2 font24 wow fadeInUp" data-wow-delay="250ms">Please enter your email address</p>
                            <div class="form-group email-input wow fadeInUp"data-wow-delay="300ms">
                                <input type="email" class="form-control" id="email" required="required">
                            </div>
                            <div class="mt3 wow fadeInUp" data-wow-delay="350ms">
                                <button type="button" onclick="verifyEmail()" class="btn btn-primary">Verify <i class="fa fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="proceed_registration" style="display: none">
                    <div class="col-md-12 text-center">
                        <div class="wow fadeInUp" data-wow-delay="400ms">
                            <a onclick="proceed_step_initial()" style="color: #fff; background: #28a745 !important;" class="btn">Proceed</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ########## Page Content End ########## -->
    <div class="sio-flex">
        <div class="sio-logo">
            <img src="<?= Yii::app()->baseUrl. '/images/logo-sio-icon.png'; ?>" alt="">
        </div>
        <div class="sio-text">
            <p class="sio-heading">MMC Global registration is powered by Sign In Once</p>
            <p class="sio-sub-heading">By continuing with registration, you agree to the
                <a target="_blank" href="#">terms & conditions.</a></p>
        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/popper.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/bootstrap.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/toastr.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/animate/animate.min.js');
?>
<script type="text/javascript">
    new WOW().init();
</script>

<!-- Sidebar Toggle Script -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.btnCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
        $('#personalAccount').trigger('click');
    });
    function verifyEmail() {
        var email = $("#email").val();
        if(email == ''){
            toastr.error("Invalid email");
        } else {
            var registration_email_verification_url = "<?= Yii::app()->createUrl('home/verifyEmail'); ?>";
            $.ajax({
                url: registration_email_verification_url,
                type: "POST",
                data: {
                    email: email
                },
                success: function (response) {
                    var resp = JSON.parse(response);
                    /*
                    * 0 - Error
                    * 1 - Registration can begin
                    * 2 - Email exists in CBM itself. Kindly login
                    * 3 - User is already registered at SIO. Please proceed registration with some necessary data.
                    * */
                    if(resp['status'] == 2){
                        toastr.warning(resp['message']);
                    } else if(resp['status'] == 3){
                        toastr.warning(resp['message']);
                        console.log(resp['verification_url']);
                        //$('#proceed_registration').css('display', 'block');
                    }  else if(resp['status'] == 1){
                        toastr.success(resp['message']);
                        proceed_step_initial();
                        //$('#proceed_registration').css('display', 'block');
                    } else {
                        toastr.error(resp['message']);
                    }
                }
            })
        }
    }

    function proceed_step_initial() {
        window.location = "<?= Yii::app()->createUrl('home/registrationStepOneInitial'); ?>";
    }
</script>

<!-- Accordion Script -->
<script type="text/javascript">
    $('.panel-collapse').on('show.bs.collapse', function () {
        $(this).siblings('.panel-heading').addClass('active');
    });

    $('.panel-collapse').on('hide.bs.collapse', function () {
        $(this).siblings('.panel-heading').removeClass('active');
    });
</script>
</body>
</html>