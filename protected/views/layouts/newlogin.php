
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
    <link rel="icon" type="image/ico" sizes="16x16" href="<?php echo Yii::app()->request->baseUrl ?>/images/logos/iriscall-favicon.png">
    <title>Iriscall</title>
    <!-- Bootstrap Core CSS -->
    <!-- <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Custom CSS -->
    <!-- <link href="css/style.css" rel="stylesheet"> -->
    <!-- You can change the theme colors from here -->
    <!-- <link href="css/colors/blue.css" id="theme" rel="stylesheet"> -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <?php

    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/bootstrap.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/morris.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/font-awesome/css/font-awesome.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/simple-line-icons/css/simple-line-icons.css'); 
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/weather-icons/css/weather-icons.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/linea-icons/linea.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/themify-icons/themify-icons.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/icons/flag-icon-css/flag-icon.min.css');
    // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/animation-iteration-count: ons/material-design-iconic-font/css/materialdesignicons.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/spinners.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/animate.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/style.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/blue.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/animate.css');
    ?>


</head>

<body>
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
    <section id="wrapper">
        <div class="login-register" style="background-image:url(<?php echo Yii::app()->baseUrl ?>/images/login-register.jpg);">
            <div class="login-box card">
                <div class="card-body">
                <div class="center m-b-20" align="center">
                  <img src="<?php echo Yii::app()->request->baseUrl ?>/images/logos/iriscall-logo.svg" alt="homepage" class="dark-logo" style="height: 80px;width: auto;" />
                </div>
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
   <?php 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.min.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/popper.min.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/bootstrap.min.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.slimscroll.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/waves.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/sidebarmenu.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/sticky-kit.min.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/custom.min.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.sparkline.min.js');
    // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/raphael-min.js');
    // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/morris.min.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jQuery.style.switcher.js');
     ?>
</body>

</html>

 