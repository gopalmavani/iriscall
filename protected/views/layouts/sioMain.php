<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" sizes="16x16" href="<?php echo Yii::app()->request->baseUrl ?>/images/logos/favicon.ico">
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/SIO/color.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/SIO/main.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/SIO/responsive.css');
?>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet"/>
</head>
<body>
<main class="login">
    <?php echo $content; ?>
</main>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        duration: 1200,
        easing: 'ease',
        anchorPlacement: 'center-bottom',
    });
</script>
</body>
</html>
