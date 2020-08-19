<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="en">

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/css/bootstrap.min.css">
    <link rel="stylesheet" id="css-main" href="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/css/oneui.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/../admin/plugins/css/custom.css">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<?php echo $content; ?>


<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/js/core/jquery.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/js/core/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/js/core/jquery.slimscroll.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/js/core/jquery.scrollLock.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/js/core/jquery.appear.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/js/core/jquery.countTo.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/js/core/jquery.placeholder.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/js/core/js.cookie.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/js/app.js"></script>

<!-- Page JS Plugins -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/jquery-validation/jquery.validate.min.js"></script>

<!-- Validation Plugin JS-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/jquery-validation/additional-methods.min.js" ></script>

<!-- Page JS Code -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/js/pages/base_pages_login.js"></script>


<!-- Page JS Form-Validation Code-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/form-validations.js" ></script>

</body>
</html>
