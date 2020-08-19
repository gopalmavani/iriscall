<?php
/**
 * Created by PhpStorm.
 * User: imyuvii
 * Date: 29/06/17
 * Time: 12:54 PM
 */
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus" lang="en"> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true).'/plugins/css/bootstrap.min.css'; ?>"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true).'/plugins/css/oneui.css'; ?>"/>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true).'/plugins/css/custom.css'; ?>"/>
    <link rel="shortcut icon" href="<?php echo Yii::app()->getBaseUrl(true) ?>/plugins/img/favicons/favicon.png">
    <title><?php echo ucfirst(Yii::app()->params['applicationName']); ?></title>
</head>
<body>
<!-- Error Content -->
<div class="content bg-white text-center pulldown overflow-hidden">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <!-- Error Titles -->
            <h1 class="font-s128 font-w300 text-flat animated bounceIn"><?php echo $data['code']; ?></h1>
            <h2 class="h3 font-w300 push-50 animated fadeInUp"><?php echo nl2br(CHtml::encode($data['message'])); ?></h2>
            <!-- END Error Titles -->
        </div>
    </div>
</div>
<div class="content pulldown text-muted text-center">
    <p>The above error occurred when the Web server was processing your request.</p>
    <p>If you think this is a server error, please contact <?php echo $data['admin']; ?>.</p>
    <p>Thank you.</p>
    <div class="version"><?php echo date('Y-m-d H:i:s',$data['time']) .' '. $data['version']; ?></div>
    <p>Would you like to let us know about it?</p>
    <!--<a class="link-effect" href="javascript:void(0)">Report it</a> or --><a class="link-effect" href="<?php echo Yii::app()->getBaseUrl(true); ?>">Go Back to Dashboard</a>
</div>
</body>
</html>

