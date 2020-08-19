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
                        <div class="logo mb3 wow fadeInUp" data-wow-delay="100ms"><img src="<?= Yii::app()->baseUrl. '/images/logos/logo-8.png'; ?>" class="img-fluid"></div>
                        <h5 class="text-semibold text-center text-uppercase wow fadeInUp" style="color: #FFF;" data-wow-delay="200ms">Type of Account</h5>
                    </div>
                </div>
                <div class="account-type" data-toggle="buttons">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4 wow fadeInLeft" data-wow-delay="300ms">
                            <div class="btn" id="personalAccount"> <i><img src="<?= Yii::app()->baseUrl. '/images/icon-personal-account.svg'; ?>"></i>
                                <h6 class="mb1">Personal Account</h6>
                                <p>You are one individual registering for one account.</p>
                                <input type="radio" name="accountType" value="personal" checked>
                            </div>
                        </div>
                        <div class="col-md-4 wow fadeInRight" data-wow-delay="300ms">
                            <div class="btn" id="businessAccount"> <i><img src="<?= Yii::app()->baseUrl. '/images/icon-corporate-account.svg'; ?>"></i>
                                <h6 class="mb1">Corporate Account</h6>
                                <p>You want to register under a business name.</p>
                                <input type="radio" name="accountType" value="business">
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <!--<div class="col-md-6 col-lg-6 col-xl-4 offset-xl-2 mb9-sm wow fadeInLeft" data-wow-delay="300ms" style="margin-left: 13%">
                            <div class="btn" id="personalAccount"> <i><img src="<?/*= Yii::app()->baseUrl. '/images/icon-personal-account.svg'; */?>"></i>
                                <h6 class="mb1">Personal Account</h6>
                                <p>You are one individual registering for one account.</p>
                                <input type="radio" name="accountType" value="personal" checked>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-4 mb4-md wow fadeInRight" data-wow-delay="300ms">
                            <div class="btn" id="businessAccount"> <i><img src="<?/*= Yii::app()->baseUrl. '/images/icon-corporate-account.svg'; */?>"></i>
                                <h6 class="mb1">Corporate Account</h6>
                                <p>You want to register under a business name.</p>
                                <input type="radio" name="accountType" value="business">
                            </div>
                        </div>-->
                    </div>
                </div>
                <br>
                <div class="row" id="proceed_with_initial_registration" style="display: none">
                    <div class="col-md-12 text-center">
                        <div class="wow fadeInUp" data-wow-delay="400ms"><a onclick="continueClick()" style="color: #fff" class="btn">Continue</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ########## Page Content End ########## -->
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/popper.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/bootstrap.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/toastr.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/animate/animate.min.js');
?>
<script type="text/javascript">
    //new WOW().init();
</script>

<!-- Sidebar Toggle Script -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.btnCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
        $('#personalAccount').trigger('click');

        //Check for SSO status, if any
        let ssoResponseStatus = "<?= $status; ?>";
        if(ssoResponseStatus != 0){
            //For token verification cases
            if(ssoResponseStatus == 1){
                toastr.success('Token validated. Please proceed with registration.');
                $('#proceed_with_initial_registration').css('display','block');
            } else {
                toastr.error('Please permit us to use SIO details by verifing the email.');
            }
        } else {
            //For normal cases
            $('#proceed_with_initial_registration').css('display','block');
        }
    });
    function continueClick() {
        let accountType = $("input[name='accountType']:checked").val();
        let stepOneUrl = "<?= Yii::app()->createUrl('home/registrationStepOne').'?accountType='; ?>"+accountType;
        window.location = stepOneUrl;
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