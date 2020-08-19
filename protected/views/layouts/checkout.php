<!DOCTYPE html>
<html lang="en">
<?php $user_id = Yii::app()->user->id; ?>
<?php
setlocale(LC_MONETARY, 'nl_NL.UTF-8');
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo Yii::app()->request->baseUrl ?>/images/logos/favicon.ico">
    <title>CashBack Matrix</title>
   
     <?php

     Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/bootstrap.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/morris.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/font-awesome/css/font-awesome.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/simple-line-icons/css/simple-line-icons.css'); 
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/weather-icons/css/weather-icons.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/linea-icons/linea.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/themify-icons/themify-icons.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/flag-icon-css/flag-icon.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/material-design-iconic-font/css/material-design-iconic-font.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/material-design-iconic-font/css/materialdesignicons.min.css');
    // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/animation-iteration-count: ons/material-design-iconic-font/css/materialdesignicons.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/toastr.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/spinners.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/animate.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/style.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/custom.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/blue.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/animate.css');
    // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/wizard/steps.css');
    // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/icheck/skins/all.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/wizard/steps.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/icheck/skins/all.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/checkout/custom.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/checkout/style.css');

    ?>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

<![endif]-->
<style type="text/css">
    .termsc{
            max-width: 10.666667% !important;
    }.footer-txt{
            margin-bottom: 0rem !important;
    }
</style>
</head>

<body>
<script>
    function SetCookie(c_name,value,expiredays)
    {
        var exdate=new Date();
        exdate.setDate(exdate.getDate()+expiredays);
        document.cookie = c_name+"="+value+";path=/;expires="+exdate.toUTCString();
    }
</script>
<div class="cookies-space">
    <?php if(!isset($_COOKIE[$user_id])) { ?>
        <div class="cookies" style="background-color: #005C98">
            <div class="row">
                <div class="col-lg-10 col-sm-9">
                    <h2>Cookies!</h2>
                    <p>This site uses cookies to offer you a better browsing experience. By clicking any link on this page, you are giving your consent for us to set cookies.</p>
                </div>
                <div class="col-lg-2 col-sm-3 text-right">
                    <a class="btn" id="removeCookieDisplay">Yes, I Agree</a>
                    <div class="clearfix"></div>
                    <a href="<?= Yii::app()->getBaseUrl(true) . '/Legal/cookies.html'; ?>" target="_blank" class="link-white">No, I want to find out more</a>
                </div>
            </div>
        </div>
    <?php }?>
    <script>
        if( document.cookie.indexOf("<?= $user_id; ?>") ===-1 ){
            $(".cookies-space").css('display','block');
        }
        $("#removeCookieDisplay").click(function () {
            SetCookie('<?= $user_id; ?>','eucookie',365*10);
            $(".cookies-space").css('display','none');
        });
    </script>
    <?php  ?>
</div>
    <div class="fix-header fix-sidebar card-no-border">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
            <header class="topbar">
                <nav class="navbar top-navbar navbar-expand-md navbar-light">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="<?= Yii::app()->createUrl('home/index'); ?>">
                            <!-- Logo icon --><b>
                                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                                <!-- Dark Logo icon -->
                                <img src="<?php echo Yii::app()->request->baseUrl ?>/images/CBM-Logo-Option1.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo icon -->

                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span>
                            <img src="<?php echo Yii::app()->request->baseUrl ?>/images/CBM-Logo-Option2.png" alt="homepage" class="dark-logo">
                        </span>
                            <!-- dark Logo text -->
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-collapse">
                        <!-- ============================================================== -->
                        <!-- toggle and nav items -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav mr-auto mt-md-0">
                            <!-- This is  -->
                            <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                            <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        </ul>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav my-lg-0">
                            <!-- Profile -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    $model = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
                                    echo $model->full_name;
                                    ?>
                                    <!-- <img src="../assets/images/users/1.jpg" alt="user" class="profile-pic" /> -->
                                </a>
                                <div class="dropdown-menu dropdown-menu-right scale-up">
                                    <ul class="dropdown-user">
                                        <!-- <li role="separator" class="divider"></li> -->
                                        <li><a href="<?php echo Yii::app()->createUrl('user/profile'); ?>"><i class="ti-user"></i> My Profile</a></li>
                                        <?php if($model->role == 'Admin') { ?>
                                            <li><a href="<?php echo Yii::app()->createUrl('admin/home/index'); ?>"><i class="ti-user"></i> Admin </a></li>
                                        <?php } ?>
                                        <!-- <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li> -->
                                        <!-- <li><a href="#"><i class="ti-email"></i> Inbox</a></li> -->
                                        <!-- <li role="separator" class="divider"></li> -->
                                        <!-- <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li> -->
                                        <li role="separator" class="divider"></li>
                                        <?php $adminLogin = Yii::app()->session['adminLogin']; ?>
                                        <?php if($adminLogin != 1 ) {?>
                                            <li><a href="<?php echo Yii::app()->createUrl('home/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <aside class="left-sidebar">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- User profile -->
                    <div class="user-profile">
                        <!-- User profile image -->
                        <!-- <div class="profile-img">  -->
                        <!-- <img src="<?php echo Yii::app()->request->baseUrl ?>/images/users/profile.png" alt="user" /> -->
                        <!-- this is blinking heartbit-->
                        <!-- <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div> -->
                        <!-- </div> -->
                        <!-- User profile text-->
                        <!-- <div class="profile-text">

                            <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a>
                            <a href="app-email.html" class="" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
                            <a href="pages-login.html" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
                            <div class="dropdown-menu animated flipInY">

                                <a href="#" class="dropdown-item"><i class="ti-user"></i> My Profile</a>

                                <a href="#" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>

                                <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>

                                <div class="dropdown-divider"></div>

                                <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>

                                <div class="dropdown-divider"></div>

                                <a href="login.html" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>

                            </div>
                        </div> -->
                    </div>
                    <!-- End User profile text-->
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="nav-devider"></li>
                            <li class="nav-small-cap"></li>
                            <li>
                                <a style="background-color: white;" class="" href="<?php echo Yii::app()->createUrl('home/index'); ?>"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a>
                            </li>
                            <li>
                                <a style="background-color: white;" class="" href="<?php echo Yii::app()->createUrl('user/promote'); ?>" ><i class="mdi mdi-chart-bubble"></i><span class="hide-menu"></i>Affiliate Program</span></a>
                            </li>
                            <li>
                                <a style="background-color: white;" class="" href="<?php echo Yii::app()->createUrl('product/index'); ?>" ><i class="mdi mdi-package-variant"></i><span class="hide-menu">Packages</span></a>
                            </li>
                            <?php if($model->role == 'Admin') { ?>

                            <li>
                                <a style="background-color: white;" class="" href="<?php echo Yii::app()->createUrl('account/index'); ?>" ><i class="mdi mdi-account-multiple-plus"></i><span class="hide-menu"></i>Accounts</span></a>
                            </li>
                            <li>
                                <a style="background-color: white;" class="" href="<?php echo Yii::app()->createUrl('wallet/'); ?>" ><i class="mdi mdi-wallet"></i><span class="hide-menu"></i>My Wallet</span></a>
                            </li>
                            <li>
                                <a style="background-color: white;" class="" href="<?php echo Yii::app()->createUrl('genealogy/'); ?>" ><i class="icon-layers"></i><span class="hide-menu"></i>Genealogy</span></a>
                            </li>

                            <?php } ?>
                            
                            <li>
                                <a style="background-color: white;" class="" href="<?php echo Yii::app()->createUrl('order/index'); ?>" ><i class="mdi mdi-cart-plus"></i><span class="hide-menu">My Orders</span></a>
                            </li>
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor" style="text-transform: capitalize;"><?php echo Yii::app()->controller->id ; ?></h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" style="text-transform: capitalize;"><a href="javascript:void(0)"><?php echo Yii::app()->controller->id ; ?></a></li>
                            <li class="breadcrumb-item active" style="text-transform: capitalize;"><?php echo Yii::app()->controller->action->id; ?></li>
                        </ol>
                    </div>
                    <div>
                        <!-- <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button> -->
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->
                    <!-- Row -->

                    <!-- ============================================================== -->
                    <!-- End PAge Content -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Right sidebar -->
                    <!-- ============================================================== -->
                    <!-- .right-sidebar -->
                    <?php echo $content; ?>
                    <!-- ============================================================== -->
                    <!-- End Right sidebar -->
                    <!-- ============================================================== -->
                </div>

                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- footer -->
                <!-- ============================================================== -->
                <footer class="footer">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="footer-txt">Copyright © <?php echo date('Y');?> CBM Global.<br> CBM Global is a trade name of Force International CVBA.</p>
                        </div>
                        <div class="col-md-1">
                            <a href="<?= Yii::app()->getBaseUrl(true) . '/Legal/imprint.html'; ?>" target="_blank">Imprint</a>
                        </div>
                        <div class="col-md-2 termsc">
                            <a href="<?= Yii::app()->getBaseUrl(true) . '/Legal/terms-conditions.html'; ?>" target="_blank">Terms & Conditions</a>
                        </div>
                        <div class="col-md-1">
                            <a href="<?= Yii::app()->getBaseUrl(true) . '/Legal/privacy.html'; ?>" target="_blank">Privacy Policy</a>
                        </div>
                    </div>
                </footer>
                <!-- ============================================================== -->
                <!-- End footer -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
        </div>
   
        <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.min.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/popper.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/bootstrap.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.slimscroll.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/waves.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/sidebarmenu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/sticky-kit.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.sparkline.min.js',CClientScript::POS_END);
        // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/custom.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/checkout/custom.min.js',CClientScript::POS_END);
        // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/raphael-min.js',CClientScript::POS_END);
        // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/morris.min.js',CClientScript::POS_END);
        // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jQuery.style.switcher.js',CClientScript::POS_END);
        // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/toastr.min.js',CClientScript::POS_END);
        // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.validate.min.js',CClientScript::POS_END);
       
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/jquery.steps.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/jquery.validate.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/steps.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/sticky-kit-master/dist/sticky-kit.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.sparkline.min.js',CClientScript::POS_END);
        // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/waves.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/icheck/icheck.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/icheck/icheck.init.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/checkout/custom.min.js',CClientScript::POS_END);
        // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/styleswitcher/jQuery.style.switcher.js',CClientScript::POS_END);
        ?>
    </div>
   
</body>

</html>
    <script>
    $(function() {
  $(".headlable").on("click", function() {
    $(".headlable").removeClass("active");
    $(this).addClass("active");
  });
   
});
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/styleswitcher/jQuery.style.switcher.js',CClientScript::POS_END);
    
?>