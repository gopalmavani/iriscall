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
    <title>CashBack Matrix</title>
    <?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/bootstrap.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/registrationStyle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/registrationResponsive.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/animate/animate.min.css');
    ?>
    <script>
        let baseUrl = '<?=Yii::app()->baseUrl;?>';
    </script>
    <script type="text/javascript" src="<?= Yii::app()->baseUrl; ?>/js/createjs.min.js"></script>
    <script type="text/javascript" src="<?= Yii::app()->baseUrl; ?>/js/registration/step1-registration.js"></script>
    <script>
        var canvas, stage, exportRoot, anim_container, dom_overlay_container, fnStartAnimation;
        function init() {
            canvas = document.getElementById("canvas");
            anim_container = document.getElementById("animation_container");
            dom_overlay_container = document.getElementById("dom_overlay_container");
            var comp=AdobeAn.getComposition("EA5571A2295DF7458D9934B992E3E739");
            var lib=comp.getLibrary();
            var loader = new createjs.LoadQueue(false);
            loader.addEventListener("fileload", function(evt){handleFileLoad(evt,comp)});
            loader.addEventListener("complete", function(evt){handleComplete(evt,comp)});
            var lib=comp.getLibrary();
            loader.loadManifest(lib.properties.manifest);
        }
        function handleFileLoad(evt, comp) {
            var images=comp.getImages();
            if (evt && (evt.item.type == "image")) { images[evt.item.id] = evt.result; }
        }
        function handleComplete(evt,comp) {
            //This function is always called, irrespective of the content. You can use the variable "stage" after it is created in token create_stage.
            var lib=comp.getLibrary();
            var ss=comp.getSpriteSheet();
            var queue = evt.target;
            var ssMetadata = lib.ssMetadata;
            for(i=0; i<ssMetadata.length; i++) {
                ss[ssMetadata[i].name] = new createjs.SpriteSheet( {"images": [queue.getResult(ssMetadata[i].name)], "frames": ssMetadata[i].frames} )
            }
            exportRoot = new lib.step1registration();
            stage = new lib.Stage(canvas);
            stage.enableMouseOver();
            //Registers the "tick" event listener.
            fnStartAnimation = function() {
                stage.addChild(exportRoot);
                createjs.Ticker.framerate = lib.properties.fps;
                createjs.Ticker.addEventListener("tick", stage);
            };
            //Code to support hidpi screens and responsive scaling.
            AdobeAn.makeResponsive(true,'both',true,1,[canvas,anim_container,dom_overlay_container]);
            AdobeAn.compositionLoaded(lib.properties.id);
            fnStartAnimation();
        }
    </script>
</head>
<body onload="init();" class="demo" id="step1-registration">
<div class="wrapper">
    <?php include("registrationSidebar.php"); ?>
    <div id="content">
        <div>
            <div class="btnCollapse"> <i></i> </div>
            <div class="wrap-demovideo wrap-demovideo-inner">
                <div id="animation_container">
                    <canvas id="canvas"></canvas>
                    <div id="dom_overlay_container"></div>
                </div>
                <div class="button-bl text-center">
                    <!--<a href="registration-demo/registration-demo.html" target="_blank" class="btn wow fadeInLeft" data-wow-delay="200ms">View Full Demo</a>-->
                    <a href="<?= Yii::app()->createUrl('home/registrationStepEmailVerification'); ?>" class="btn wow fadeInRight" data-wow-delay="200ms">Proceed With Registration</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>