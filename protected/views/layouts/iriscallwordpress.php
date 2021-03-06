<!DOCTYPE html>
<html lang="en">
<?php
setlocale(LC_MONETARY, 'nl_NL.UTF-8');
?>
<style>
    body {
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
    }
    .wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step .wizard-label{
        margin: unset !important;
    }
    .dropzone.dropzone-default .dropzone-msg-desc{
        font-size: large !important;
    }
    .wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-title {
        font-size: 0.75rem !important;
    }
    .wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-icon {
        font-size: 2.75rem !important;
    }
    .radio-inline {
        margin-top: 10px !important;
        display: inline-flex !important;
        padding-left: unset !important;
    }
    .col-form-label-new {
        margin-left: 10px;
        padding-top: 5px !important;
    }
    .step5_button {
        padding: 6px 12px !important;
    }
</style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?= Yii::app()->request->baseUrl ?>/images/logos/iriscall-favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,400;0,700;1,500&display=swap" rel="stylesheet">
    <title>Iriscall</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/plugins.bundle.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style.bundle.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prismjs.bundle.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/fonts/iriscall_wordpress_fonts.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/iriscall_wordpress.css?v=0.0.5');
        //Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
    ?>
</head>
<body style="background-color:darkgrey">
<?php echo $this->renderPartial('/layouts/iriscall_header');  ?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <?php echo $content; ?>
</div>
<?php echo $this->renderPartial('/layouts/iriscall_footer');  ?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#0BB783", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#D7F9EF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };
</script>

<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins.bundle.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/wizard/prismjs.bundle.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/scripts.bundle.min.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/widgets.js');
    //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');
?>
</body>

</html>