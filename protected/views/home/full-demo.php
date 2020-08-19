<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="authoring-tool" content="Adobe_Animate_CC">
    <title>CashBack RegistrationDemo</title>
    <style>
        #animation_container {
            position:absolute;
            margin:auto;
            left:0;right:0;
        }
    </style>
    <script>
        let baseUrl = '<?=Yii::app()->baseUrl;?>';
    </script>
    <script type="text/javascript" src="<?= Yii::app()->baseUrl; ?>/js/createjs.min.js"></script>
    <script type="text/javascript" src="<?= Yii::app()->baseUrl; ?>/js/registration/registration-demo.js"></script>
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
            exportRoot = new lib.CBMRegistrationDemo();
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
<body onload="init();" style="margin:0px;">
<div id="animation_container" style="background-color:rgba(255, 255, 255, 1.00); width:1920px; height:1080px">
    <canvas id="canvas" width="1920" height="1080" style="position: absolute; display: block; background-color:rgba(255, 255, 255, 1.00);"></canvas>
    <div id="dom_overlay_container" style="pointer-events:none; overflow:hidden; width:1920px; height:1080px; position: absolute; left: 0; top: 0; display: block;">
    </div>
</div>
</body>
</html>
