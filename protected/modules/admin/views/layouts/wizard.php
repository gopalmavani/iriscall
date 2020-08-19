<!DOCTYPE html>
<!--[if IE 9]>
<html class="ie9 no-focus" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-focus" lang="en"> <!--<![endif]-->
<head>
    <?php $basePath = Yii::app()->params['basePath'];
    $siteUrl = Yii::app()->params['siteUrl'];
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerCssFile('http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700');
    Yii::app()->clientScript->registerCssFile(
        Yii::app()->assetManager->publish("$basePath/plugins/css/bootstrap.min.css")
    );


    Yii::app()->clientScript->registerCss('font-css',"
        @font-face {
            font-family: 'FontAwesome';
            src: url('$siteUrl/plugins/fonts/fontawesome-webfont.eot?v=4.6.3');
            src: url('$siteUrl/plugins/fonts/fontawesome-webfont.eot?#iefix&v=4.6.3') format('embedded-opentype'), url('$siteUrl/plugins/fonts/fontawesome-webfont.woff2?v=4.6.3') format('woff2'), url('$siteUrl/plugins/fonts/fontawesome-webfont.woff?v=4.6.3') format('woff'), url('$siteUrl/plugins/fonts/fontawesome-webfont.ttf?v=4.6.3') format('truetype'), url('$siteUrl/plugins/fonts/fontawesome-webfont.svg?v=4.6.3#fontawesomeregular') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family:Simple-Line-Icons;
            src:url($siteUrl/plugins/fonts/Simple-Line-Icons.eot);
            src:url($siteUrl/plugins/fonts/Simple-Line-Icons.eot?#iefix) format('embedded-opentype'), url($siteUrl/plugins/fonts/Simple-Line-Icons.woff) format('woff'), url($siteUrl/plugins/fonts/Simple-Line-Icons.ttf) format('truetype'), url($siteUrl/plugins/fonts/Simple-Line-Icons.svg#Simple-Line-Icons) format('svg');
            font-weight:400;
            font-style:normal
        }");
    Yii::app()->clientScript->registerCssFile(
        Yii::app()->assetManager->publish("$basePath/plugins/css/oneui.min.css")
    );
    Yii::app()->clientScript->registerCssFile(
        Yii::app()->assetManager->publish("$basePath/admin/plugins/css/custom.css")
    );
    ?>
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/../plugins/img/favicons/favicon.png">
    <title>Cyclone</title>
</head>
<body>
<?php echo $content; ?>
<?php
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish("$basePath/plugins/js/oneui.min.js"),
    CClientScript::POS_END
);
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish("$basePath/plugins/jquery-validation/jquery.validate.min.js"),
    CClientScript::POS_END
);
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish("$basePath/plugins/jquery-validation/additional-methods.min.js"),
    CClientScript::POS_END
);
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish("$basePath/admin/js/form-validations.js"),
    CClientScript::POS_END
);
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish("$basePath/admin/plugins/js/validation.js"),
    CClientScript::POS_END
);
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish("$basePath/admin/plugins/js/custom.js"),
    CClientScript::POS_END
);
?>
</body>
</html>
