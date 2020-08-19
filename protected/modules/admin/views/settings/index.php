<?php $this->pageTitle = 'Settings'; ?>


<!-- Main Container -->
<main id="main-container">

    <div class="text-center" id="update-msg" style="display: none;">
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h3 class="font-w300 push-15">Success</h3>
            <p><a class="alert-link" href="javascript:void(0)">Settings</a> applied successfully!</p>
        </div>
    </div>

    <!-- Page Content -->
    <!-- Preview Color Themes -->
    <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
    <div class="content" style="padding: 0%;padding-left:1%">
        <h2 class="content-heading">Preview Color Theme</h2>
    </div>
    <div class="content bg-white">
        <div class="row items-push text-center">
            <div class="col-xs-6 col-sm-6 col-lg-2">
                <a id="oneui" class="theme item item-circle bg-default text-white-op center-block" data-toggle="theme" data-theme="default" href="javascript:void(0)">
                    <i class="si si-drop"></i>
                </a>
                <div class="push-10-t font-w600">Default</div>
            </div>
            <div class="col-xs-6 col-sm-6 col-lg-2">
                <a id="amethyst" class="theme item item-circle bg-amethyst text-white-op center-block" data-toggle="theme" data-theme="assets/css/themes/amethyst.min.css" href="javascript:void(0)">
                    <i class="si si-drop"></i>
                </a>
                <div class="push-10-t font-w600">Amethyst</div>
            </div>
            <div class="col-xs-6 col-sm-6 col-lg-2">
                <a id="city" class="theme item item-circle bg-city text-white-op center-block" data-toggle="theme" data-theme="assets/css/themes/city.min.css" href="javascript:void(0)">
                    <i class="si si-drop"></i>
                </a>
                <div class="push-10-t font-w600">City</div>
            </div>
            <div class="col-xs-6 col-sm-6 col-lg-2">
                <a id="flat" class="theme item item-circle bg-flat text-white-op center-block" data-toggle="theme" data-theme="assets/css/themes/flat.min.css" href="javascript:void(0)">
                    <i class="si si-drop"></i>
                </a>
                <div class="push-10-t font-w600">Flat</div>
            </div>
            <div class="col-xs-6 col-sm-6 col-lg-2">
                <a id="modern" class="theme item item-circle bg-modern text-white-op center-block" data-toggle="theme" data-theme="<?php echo Yii::app()->baseUrl . '/plugins/js/plugins/css/themes/modern.min.css' ?>" href="javascript:void(0)">
                    <i class="si si-drop"></i>
                </a>
                <div class="push-10-t font-w600">Modern</div>
            </div>
            <div class="col-xs-6 col-sm-6 col-lg-2">
                <a id="smooth" class="theme item item-circle bg-smooth text-white-op center-block" data-toggle="theme" data-theme="assets/css/themes/smooth.min.css" href="javascript:void(0)">
                    <i class="si si-drop"></i>
                </a>
                <div class="push-10-t font-w600">Smooth</div>
            </div>
        </div><br><br>
    </div>
    <!-- END Preview Color Themes -->
    <div class="content" style="padding: 0%;padding-left:1%">
        <h2 class="content-heading">Choose Withdrawl Charges:</h2>
    </div>

    <div class="content bg-white">
        <div class="row items-push">
            <div class="col-xs-6 col-sm-6 col-lg-4">
                <input class="form-control"  type="text"  name="percentage_val" id="percentage_val" placeholder="%">
            </div>
            <div class="col-xs-6 col-sm-6 col-lg-5" style="" id="div_transaction">
                <input type="radio" name="transaction_charge" class="transaction_charge" value="percentage">Percentage(%)
                &nbsp;
                <input type="radio"  name="transaction_charge" class="transaction_charge" value="value">Value
                <div class="has-error" style="display:none">please choose percentage or value</div>
            </div>
        </div>
    </div>

    </div>

    <div class="col-xs-6" style="margin-left:3%;margin-top:1%">
        <button class="btn btn-primary" id="set_theme">Apply changes</button>
        <a class="btn btn-default" href="<?php echo Yii::app()->createUrl('admin/home'); ?>" >Cancel</a>
    </div><br><br><br>

    <!-- END Contextual Colors -->
    <!-- END Page Content -->
</main>
<!-- END Main Container -->

<script>
    var settheme = '<?php echo Yii::app()->createUrl('admin/settings/settheme')?>';

    var value = "";
    theme = [];
    theme[0] = 'theme';

    $('.transaction_charge').change(function(){
        var type = $('input[name=transaction_charge]:checked').val();
//        console.info(type);return false;
        if(type == 'value')
        {
            $('#percentage_val').attr("placeholder","currency")
        }
        if(type == 'percentage')
        {
            $('#percentage_val').attr("placeholder","%")
        }
    });
    $('.theme').click(function(){
        value = $(this).attr('id');
        if(value!='oneui')
        {
            var csspath = "<?php echo Yii::app()->baseUrl . '/plugins/css/themes/'; ?>"+value+".min.css";
            $('head').append('<link rel="stylesheet" class="appended"  href='+csspath+' type="text/css" />');
        }
        else
        {
            localStorage.setItem("css","");
            $('.appended').remove();
        }
    });


    $('#set_theme').click(function () {
        var x = $('#percentage_val').val();
        var y = $('input[name=transaction_charge]:checked').val();
        if(!y && x!='')
        {
            $('.has-error').css({"color":'#d26a5c',"display":"block"});
            $('#div_transaction').css({"color":'#d26a5c'});
            return false;
        }

        theme[2] = $('#percentage_val').val();
        theme[3] = $('.transaction_charge').val();
        theme[1] = value;
        $.ajax({
            type: "POST",
            url: settheme,
            data: {theme:theme},
            beforeSend: function () {
                $(".overlay").removeClass("hide");
            },
            success: function (data) {
                $(".overlay").addClass("hide");
                $("#update-msg").show().delay(5000).fadeOut();
                window.scrollTo(0,0);
                value = '';
                $('input[name=transaction_charge]:checked').prop('checked',false);
                $('#percentage_val').attr("placeholder","%");
                $('#percentage_val').val("");
                $('.has-error').css({"display":"none"});
                $('#div_transaction').css({"color":''});
            }
        });
    });
</script>