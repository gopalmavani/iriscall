<!DOCTYPE html>
<html lang="en">
<?php
$user_id = Yii::app()->user->id;
$user = UserInfo::model()->findByPk($user_id);
setlocale(LC_MONETARY, 'nl_NL.UTF-8');
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?= Yii::app()->request->baseUrl ?>/images/logos/iriscall-favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500">
    <title>Iriscall</title>
    <?php
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/plugins.bundle.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style.bundle.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/trip.min.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/custom.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/toastr/toastr.css');
    ?>
</head>
<style>
    .no-js #loader { display: none;  }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .se-pre-con {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("<?= Yii::app()->request->baseUrl ?>/images/preloader.gif") center no-repeat #fff;
    }
</style>
<body class="kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent">
<div class="se-pre-con" style="display: none;"></div>
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
        <div class="cookies" style="background-color: white; bottom: 0">
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
</div>
    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="#">
                <img alt="Logo" src="<?= Yii::app()->request->baseUrl ?>/images/logos/logo-8.png" class="kt-header__brand-logo-default" />
                <img alt="Logo" src="<?= Yii::app()->request->baseUrl ?>/images/logos/logo-8-inverse.png" class="kt-header__brand-logo-sticky" />
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button>
        </div>
    </div>
    <!-- end:: Header Mobile -->
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                <?php echo $this->renderPartial('/layouts/header',['user'=>$user]);  ?>
                <?php echo $content; ?>
                <?php echo $this->renderPartial('/layouts/footer');  ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#044e80",
                    "light": "#ffffff",
                    "dark": "#5e5e5f",
                    "primary": "#044e80",
                    "success": "#5cb85c",
                    "info": "#5bc0de",
                    "warning": "#f0ad4e",
                    "danger": "#d9534f"
                },
                "base": {
                    "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                    "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
                }
            }
        };
    </script>
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins.bundle.js?v=7.0.4');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/wizard/prismjs.bundle.js?v=7.0.4');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/scripts.bundle.js?v=7.0.4');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/list.min.js?v=7.0.4');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/trip.min.js?v=7.0.4');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/custom.js?v=7.0.4');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/toastr/toastr.js');
    Yii::app()->clientScript->registerScriptFile('https://js.stripe.com/v3/', CClientScript::POS_END);
    ?>
</body>

</html>