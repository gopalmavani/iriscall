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
    <title>Iriscall</title>
    <?php
    /*Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/bootstrap.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/registrationStyle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/registrationResponsive.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/toastr.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/animate/animate.min.css');*/
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/wizard-4.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/plugins.bundle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style.bundle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prismjs.bundle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/custom.css');
    ?>
    <style>
        .boxshadow-content{
            background: #FFF !important;
        }
    </style>
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid page">
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="row mb9 mb6-md">
                    <div class="col-md-12 text-center">
                        <div class="logo mb3 wow fadeInUp" data-wow-delay="100ms"><img src="<?= Yii::app()->baseUrl. '/images/logo-sio-icon.png'; ?>" class="img-fluid"></div>
                    </div>
                </div>
                <div class="card card-custom">
                    <div class="card-header" style="margin: auto">
                        <div class="card-title">
                            <h3 class="card-label">Welcome to <?= Yii::app()->params['applicationName'] ?></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="mb3 mbsm2 font24 wow fadeInUp text-center" data-wow-delay="250ms">Please enter your email address</p>
                        <div class="form-group row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input type="email" class="form-control" id="email" required="required" placeholder="Enter email here">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" onclick="verifyEmail()" class="btn btn-primary">Verify <i class="fa fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sio-flex text-center">
                    <div class="sio-logo">
                        <img src="<?= Yii::app()->baseUrl. '/images/logo-sio-icon.png'; ?>" alt="">
                    </div>
                    <div class="sio-text">
                        <p class="sio-heading">Iriscall registration is powered by Sign In Once</p>
                        <p class="sio-sub-heading">By continuing with registration, you agree to the
                            <a target="_blank" href="#">terms & conditions.</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">

</div>
<?php
/*Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/popper.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/bootstrap.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/toastr.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/animate/animate.min.js');*/
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins.bundle.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/prismjs.bundle.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/scripts.bundle.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jaktutorial.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/jquery.validate.min.js', CClientScript::POS_END);
?>

<!-- Sidebar Toggle Script -->
<script type="text/javascript">
    $(document).ready(function () {});
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
                    * 2 - Email exists in Iriscall itself. Kindly login
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
</body>
</html>