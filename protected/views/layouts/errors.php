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
     <link rel="icon" type="image/png" sizes="16x16" href="<?php echo Yii::app()->request->baseUrl ?>/images/logos/iriscall-favicon.png">
    <title>Iriscall</title>
    <!-- Bootstrap Core CSS -->
    <!-- <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Custom CSS -->
    <!-- <link href="css/style.css" rel="stylesheet"> -->
    <!-- You can change the theme colors from here -->
    <!-- <link href="css/colors/blue.css" id="theme" rel="stylesheet"> -->
   
    <?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/bootstrap.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/blue.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/style.css');
    ?>

</head>

<body class="fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="error-page">
        <div class="error-box">
        <?php echo $content; ?>    
        <footer class="footer text-center">Copyright © <?php echo date('Y');?> Iriscall</footer>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- <script src="../assets/plugins/jquery/jquery.min.js"></script> -->
    <!-- Bootstrap tether Core JavaScript -->
    <!-- <script src="../assets/plugins/bootstrap/js/popper.min.js"></script> -->

    <!-- <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script> -->
    <!--Wave Effects -->
    <!-- <script src="js/waves.js"></script> -->

    <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/popper.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/bootstrap.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/waves.js');
    ?>


</body>

</html>
