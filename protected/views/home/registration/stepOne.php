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
    <title>IrisCall</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/wizard-4.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/plugins.bundle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style.bundle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prismjs.bundle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/custom.css');
    ?>
    <style>
        .isDisabled {
            cursor: not-allowed;
            text-decoration: none;
            pointer-events: none;
        }
        #system-mail {
            display: none;
        }
        .showonhover:hover #system-mail {
            display: block;
        }
        #market-mail {
            display: none;
        }
        .showhover:hover #market-mail {
            display: block;
        }
        .form-control[readonly]{
            opacity: 0.7;
            cursor: no-drop;
        }
        .row {
            margin-left: -10px !important;
            margin-right: -10px !important;
        }
        .error{
            color:red;
        }
        .progress{
            width: auto;
            height: 20px;
            background: #ebedf2 !important;
        }
        .custom-control-label::before{
            position: fixed;
        }
        body{
            font-size: 15px;
        }
        .kt-wizard-v4 .kt-wizard-v4__nav .kt-wizard-v4__nav-items .kt-wizard-v4__nav-item {
            flex: 0 0 calc(33.4% - 0.25rem);
            width: calc(33% - 0.25rem);
        }
        .progress-bar-success{
            background-color: #007bff;
        }
        .progress-bar-danger{
            background-color: #bb321f;
        }
        .progress-bar-warning{
            background-color: #FFCC00;
        }
        .mb-10{
            margin-bottom:10px;
        }
        input[type="checkbox"] {
            margin-right: 10px;
        }
        .text-grey {
            color: #afb2b2 !important;
        }
        body{
            /*background-color: #56077E !important;
            background-image: url(<?= Yii::app()->baseUrl. '/images/bg-7.jpg'; ?>) !important;
            background-size: cover !important;
            background-attachment: fixed !important;
            background-repeat: no-repeat !important;*/
        }
        .kt-wizard-v4__nav-number{
            background-color: #256c9e !important;
        }
        .kt-wizard-v4__nav-label-title{
            color: #256c9e !important;
        }
    </style>
</head>
<!-- <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading"> -->
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="logo"><a href="#"><img src="<?= Yii::app()->baseUrl. '/images/logos/iriscall-logo.svg'; ?>" style="width: auto !important; height: 100px !important;"></a></div>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin:0 30% 1%; display: none;">
                        <span id="msg"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="subheader py-2 py-lg-4 subheader-transparent remove" id="kt_subheader">
                        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                            <div class="d-flex align-items-center flex-wrap mr-2">
                                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">New User</h5>
                                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                                <div class="d-flex align-items-center" id="kt_subheader_search">
                                    <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Enter user details and submit</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex flex-column-fluid remove">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Card-->
                            <div class="card card-custom card-transparent">
                                <div class="card-body p-0">
                                    <!--begin::Wizard-->
                                    <div class="wizard wizard-4" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="true">
                                        <div class="card card-custom card-shadowless rounded-top-0">
                                            <div class="card-body p-0">
                                                <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                                                    <div class="col-xl-12 col-xxl-10">
                                                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                                            'id' => 'kt_form',
                                                            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                                                            'enableAjaxValidation' => false,
                                                            'action'=> Yii::app()->createUrl('home/createUserSignup'),
                                                            'htmlOptions' => array(
                                                                'name' => 'UserCreate',
                                                                'class' => 'kt-form validation-wizard1'
                                                            )
                                                        )); ?>
                                                        <!--begin: Form Wizard Step 1-->
                                                        <div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
                                                            <h5 class="text-dark font-weight-bold mb-10">Enter your Account Details</h5>
                                                            <div class="row">
                                                                <div class="col-xl-6">
																	<div class="form-group">
																		<label for="first_name">First Name<span>*</span></label>
																		<div class="input-group input-group-solid">
                                                                        	<input type="text" id="first_name" class="form-control" name="first_name" required="required">
																		</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
																	<div class="form-group">
																		<label for="middle_name">Middle Name<span>*</span></label>
																		<div class="input-group input-group-solid">
                                                                        	<input type="text" id="middle_name" class="form-control" name="middle_name">
																		</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
																	<div class="form-group">
																		<label for="last_name">Last Name<span>*</span></label>
																		<div class="input-group input-group-solid">
                                                                        	<input type="text" id="last_name" class="form-control" name="last_name" required="required">
																		</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
																		<label for="email">Email<span>*</span></label>
																		<div class="input-group input-group-solid">
                                                                        	<input type="email" id="email" class="form-control" name="email" value="<?= isset($model->email) ? $model->email : '' ?>" required="required">
																		</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group" id="password_group">
                                                                        <label>Password<span>*</span></label>
																		<div class="input-group input-group-solid">
																			<input type="password" id="password" class="form-control" name="password" required="required">
																			<div class="input-group-append">
																				<i style="margin-right: 0.50rem" class="far fa-eye-slash" id="togglePassword"></i>
																			</div>
																		</div>
                                                                        <div class="text-sm text-grey">Password Strength</div>
                                                                        <div class="progress progress-striped active">
                                                                            <div id="jak_pstrength" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group" id="confirm_password_group">
                                                                        <label for="confirm_password">Repeat Password<span>*</span></label>
																		<div class="input-group input-group-solid">
                                                                        	<input type="password" id="confirm_password" class="form-control" name="confirm_password" required="required">
																			<div class="input-group-append">
																				<i style="margin-right: 0.50rem" class="far fa-eye-slash" id="toggle-password"></i>
																			</div>
																		</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end: Form Wizard Step 3-->
                                                        <div class="col-md-12">
                                                            <div class="form-group" align="center">
                                                                <?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save', array(
                                                                    'class' => 'btn btn-primary col-md-offset-2',
                                                                    'id' => 'create'
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                        <?php $this->endWidget(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#0BB783", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#D7F9EF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };
</script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins.bundle.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/prismjs.bundle.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/scripts.bundle.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/add-user.js?v=0.0.3', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jaktutorial.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/jquery.validate.min.js', CClientScript::POS_END);
?>

<script type="text/javascript">
    $(document).ready(function () {

        var sioData = "<?= $sioData; ?>";
        if(sioData == 1){
            $('#email').prop("readonly", true);
            $('#password_group').remove();
            $('#confirm_password_group').remove();
            disable_if_present(['#first_name', '#middle_name', '#last_name', '#password']);

            $('#create').click(function(e){
            e.preventDefault();
            $.ajax({
                url: "<?php  echo Yii::app()->createUrl('home/createUserSignup');  ?>",
                type: "POST",
                data: $("#kt_form").serializeArray(),
                success: function () {
                    $('.alert').show();
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $('#msg').html("We have sent a email verification link to your email address.");
                    $('.remove').remove();
                },
                error: function(xhr, status,error){
                    console.log(error);
                    $('.alert').show();
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $('#msg').html("<a href='<?php echo Yii::app()->createUrl('home/index'); ?>' style='color: black; margin: 0 38%;' class='btn btn-default btn-rounded waves-effect waves-light m-b-40'>Back to home</a>");
                    $('.remove').remove();
                }
            });
        });
        }

        if($('#email').val()){
            $('#email').prop("readonly", true);
        }

        $("#password").keyup(function () {
            passwordStrength($(this).val());
        });
        $("#email").keyup(function () {
            var email = $(this).val();
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            var rs = regex.test(email);
            if (rs) {
                $('#custom_mail_checker').hide();
            } else {
                $('#custom_mail_checker').show();
            }
        });
    });

    function disable_if_present(selectorArr){
        $.each(selectorArr, function (index, value) {
            if($(value).val()){
                $(value).prop("readonly", true);
            }
        });
    }

	$("body").on('click', '#togglePassword', function() {
		$(this).toggleClass("fa-eye fa-eye-slash");
			var input = $("#password");
			if (input.attr("type") === "password") {
			input.attr("type", "text");
			} else {
			input.attr("type", "password");
		}
	});

	$("body").on('click', '#toggle-password', function() {
		$(this).toggleClass("fa-eye fa-eye-slash");
		var input = $("#confirm_password");
		if (input.attr("type") === "password") {
			input.attr("type", "text");
		} else {
			input.attr("type", "password");
		}
	});
</script>
        <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClUK1XVa7IEl1aTOxGwNrNM04eO303UJc&libraries=places&callback=initAutocomplete" async defer></script> -->
        <script src="<?= Yii::app()->baseUrl . '/js/auto-complete.js?v=0.0.2' ?>"></script>
</body>
<link rel="alternate" type="application/rss+xml" title="IrisCall - Telecom &amp; Websites &raquo; Feed" href="https://mobiel.iriscall.com/feed/" />
<link rel="alternate" type="application/rss+xml" title="IrisCall - Telecom &amp; Websites &raquo; Comments Feed" href="https://mobiel.iriscall.com/comments/feed/" />
<link rel='stylesheet' id='dashicons-css'  href='https://mobiel.iriscall.com/wp-includes/css/dashicons.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='admin-bar-css'  href='https://mobiel.iriscall.com/wp-includes/css/admin-bar.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='hello-elementor-theme-style-css'  href='https://mobiel.iriscall.com/wp-content/themes/hello-elementor/theme.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-menu-hello-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-menu/integration/themes/hello-elementor/assets/css/jet-menu-hello.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-menu-hfe-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-menu/integration/plugins/header-footer-elementor/assets/css/jet-menu-hfe.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-css'  href='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-common-css'  href='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/css/common.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='wp-block-library-css'  href='https://mobiel.iriscall.com/wp-includes/css/dist/block-library/style.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-engine-frontend-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-engine/assets/css/jet-engine-frontend.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='templately-editor-css'  href='https://mobiel.iriscall.com/wp-content/plugins/templately/assets/css/templately-editor.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='cb70d11b8-css'  href='https://mobiel.iriscall.com/wp-content/uploads/essential-addons-elementor/cb70d11b8.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='hfe-style-css'  href='https://mobiel.iriscall.com/wp-content/plugins/header-footer-elementor/assets/css/hfe-style.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-blocks-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-blocks/assets/css/jet-blocks.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-elements-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-elements/assets/css/jet-elements.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-elements-skin-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-elements/assets/css/jet-elements-skin.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-frontend-legacy-css'  href='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/css/frontend-legacy.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-frontend-css'  href='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/css/frontend.min.css' type='text/css' media='all' />

<link rel='stylesheet' id='elementor-post-1058-css'  href='https://mobiel.iriscall.com/wp-content/uploads/elementor/css/post-1058.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-pro-css'  href='https://mobiel.iriscall.com/wp-content/plugins/elementor-pro/assets/css/frontend.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-blog-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-blog/assets/css/jet-blog.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-search-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-search/assets/css/jet-search.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-tabs-frontend-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-tabs/assets/css/jet-tabs-frontend.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-tricks-frontend-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-tricks/assets/css/jet-tricks-frontend.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-1745-css'  href='https://mobiel.iriscall.com/wp-content/uploads/elementor/css/post-1745.css' type='text/css' media='all' />
<link rel='stylesheet' id='hfe-widgets-style-css'  href='https://mobiel.iriscall.com/wp-content/plugins/header-footer-elementor/inc/widgets-css/hfe-widgets-style.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='theplus-front-css-css'  href='//mobiel.iriscall.com/wp-content/uploads/theplus-addons/theplus-post-1745.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='plus-icons-mind-css-css'  href='//mobiel.iriscall.com/wp-content/plugins/theplus_elementor_addon/assets/css/extra/iconsmind.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='plus-pre-loader-css-css'  href='//mobiel.iriscall.com/wp-content/plugins/theplus_elementor_addon/assets/css/main/pre-loader/plus-pre-loader.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='hello-elementor-css'  href='https://mobiel.iriscall.com/wp-content/themes/hello-elementor/style.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='font-awesome-all-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-menu/assets/public/lib/font-awesome/css/all.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='font-awesome-v4-shims-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-menu/assets/public/lib/font-awesome/css/v4-shims.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-menu-public-styles-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-menu/assets/public/css/jet-menu-public-styles.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-popup-frontend-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-popup/assets/css/jet-popup-frontend.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-shared-0-css'  href='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-fa-solid-css'  href='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-fa-regular-css'  href='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/font-awesome/css/regular.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='jet-reviews-css'  href='https://mobiel.iriscall.com/wp-content/plugins/jet-reviews/assets/css/jet-reviews.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-2381-css'  href='https://mobiel.iriscall.com/wp-content/uploads/elementor/css/post-2381.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-2485-css'  href='https://mobiel.iriscall.com/wp-content/uploads/elementor/css/post-2485.css' type='text/css' media='all' />
<link rel='stylesheet' id='recent-posts-widget-with-thumbnails-public-style-css'  href='https://mobiel.iriscall.com/wp-content/plugins/recent-posts-widget-with-thumbnails/recent-posts-widget-with-thumbnails-public-style.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='google-fonts-1-css'  href='https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CPoppins%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CMerriweather%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;display=auto&#038;ver=5.8.1' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-fa-brands-css'  href='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/font-awesome/css/brands.min.css' type='text/css' media='all' />
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/jquery/jquery.min.js' id='jquery-core-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/jquery/jquery-migrate.min.js' id='jquery-migrate-js'></script>
<script type='text/javascript' src='//mobiel.iriscall.com/wp-content/plugins/theplus_elementor_addon/assets/js/main/pre-loader/plus-pre-loader-extra-transition.min.js' id='plus-pre-loader-js2-js'></script>
<script type='text/javascript' src='//mobiel.iriscall.com/wp-content/plugins/theplus_elementor_addon/assets/js/main/pre-loader/plus-pre-loader.min.js' id='plus-pre-loader-js-js'></script>
<script type='text/javascript' src='//maps.googleapis.com/maps/api/js?key=&#038;sensor=false' id='gmaps-js-js'></script>
<script type='text/javascript' id='elementor-pro-app-js-before'>
var elementorAppProConfig = {"baseUrl":"https:\/\/mobiel.iriscall.com\/wp-content\/plugins\/elementor-pro\/","site-editor":[],"kit-library":[]};
</script>
<link rel="https://api.w.org/" href="https://mobiel.iriscall.com/wp-json/" /><link rel="alternate" type="application/json" href="https://mobiel.iriscall.com/wp-json/wp/v2/pages/1745" /><link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://mobiel.iriscall.com/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://mobiel.iriscall.com/wp-includes/wlwmanifest.xml" /> 
<meta name="generator" content="WordPress 5.8.1" />
<link rel='shortlink' href='https://mobiel.iriscall.com/' />
<link rel="alternate" type="application/json+oembed" href="https://mobiel.iriscall.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fmobiel.iriscall.com%2F" />
<link rel="alternate" type="text/xml+oembed" href="https://mobiel.iriscall.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fmobiel.iriscall.com%2F&#038;format=xml" />

<link rel="canonical" href="https://mobiel.iriscall.com/" />
<link rel="icon" href="https://mobiel.iriscall.com/wp-content/uploads/2021/07/cropped-cropped-favicon-32x32.png" sizes="32x32" />
<link rel="icon" href="https://mobiel.iriscall.com/wp-content/uploads/2021/07/cropped-cropped-favicon-192x192.png" sizes="192x192" />
<link rel="apple-touch-icon" href="https://mobiel.iriscall.com/wp-content/uploads/2021/07/cropped-cropped-favicon-180x180.png" />

<body class="home page-template page-template-elementor_header_footer page page-id-1745 logged-in admin-bar no-customize-support ehf-template-hello-elementor ehf-stylesheet-hello-elementor theplus-preloader jet-desktop-menu-active elementor-page-1645 elementor-page-1728 elementor-default elementor-template-full-width elementor-kit-1058 elementor-page elementor-page-1745">
<div style="font-size: 16px;" data-elementor-type="footer" data-elementor-id="2485" class="elementor elementor-2485 elementor-location-footer" data-elementor-settings="[]">
		<div class="elementor-section-wrap">
					<section data-particle_enable="false" data-particle-mobile-disabled="false" class="elementor-section elementor-top-section elementor-element elementor-element-698d7f0 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="698d7f0" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
						<div class="elementor-container elementor-column-gap-default">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-16 elementor-top-column elementor-element elementor-element-22aeae14" data-id="22aeae14" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-214bbf38 elementor-widget elementor-widget-image" data-id="214bbf38" data-element_type="widget" data-widget_type="image.default">
				<div class="elementor-widget-container">
								<div class="elementor-image">
												<img width="200" height="80"   alt="" data-src="https://mobiel.iriscall.com/wp-content/uploads/2021/09/logo.png" class="attachment-full size-full lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" /><noscript><img width="200" height="80" src="https://mobiel.iriscall.com/wp-content/uploads/2021/09/logo.png" class="attachment-full size-full" alt="" /></noscript>														</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-43c72d62 elementor-widget elementor-widget-text-editor" data-id="43c72d62" data-element_type="widget" data-widget_type="text-editor.default">
				<div class="elementor-widget-container">
								<div class="elementor-text-editor elementor-clearfix">
				<p>Met een persoonlijke service helpen we iedere ondernemer verder. IrisCall is jouw partner voor telefonie en websites.</p>					</div>
						</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-16 elementor-top-column elementor-element elementor-element-d0aadb" data-id="d0aadb" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-2f307fa8 elementor-widget elementor-widget-heading" data-id="2f307fa8" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Cloud</h2>		</div>
				</div>
				<div class="elementor-element elementor-element-5b61b062 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="5b61b062" data-element_type="widget" data-widget_type="icon-list.default">
				<div class="elementor-widget-container">
					<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
											<a href="https://cloud.iriscall.com/">

											<span class="elementor-icon-list-text">Cloud</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://cloud.iriscall.com/waarom-cloud/">

											<span class="elementor-icon-list-text">Waarom cloud?</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://cloud.iriscall.com/iriscall-telefooncentrale/">

											<span class="elementor-icon-list-text">IrisCall Telefooncentrale</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://cloud.iriscall.com/toestellen/">

											<span class="elementor-icon-list-text">Toestellen</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://cloud.iriscall.com/contact/">

											<span class="elementor-icon-list-text">Contact</span>
											</a>
									</li>
						</ul>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-16 elementor-top-column elementor-element elementor-element-64ddfe96" data-id="64ddfe96" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-27fd76d8 elementor-widget elementor-widget-heading" data-id="27fd76d8" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Websites</h2>		</div>
				</div>
				<div class="elementor-element elementor-element-4900447a elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="4900447a" data-element_type="widget" data-widget_type="icon-list.default">
				<div class="elementor-widget-container">
					<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
											<a href="https://websites.iriscall.com/">

											<span class="elementor-icon-list-text">Websites</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://websites.iriscall.com/onze-aanpak/">

											<span class="elementor-icon-list-text">Onze aanpak</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://websites.iriscall.com/klantverhalen/">

											<span class="elementor-icon-list-text">Klantverhalen</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://websites.iriscall.com/prijzen/">

											<span class="elementor-icon-list-text">Prijzen</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://websites.iriscall.com/boek-een-gesprek/">

											<span class="elementor-icon-list-text">Boek een gesprek</span>
											</a>
									</li>
						</ul>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-16 elementor-top-column elementor-element elementor-element-4b87d02d" data-id="4b87d02d" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-64f85b8 elementor-widget elementor-widget-heading" data-id="64f85b8" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Mobiel</h2>		</div>
				</div>
				<div class="elementor-element elementor-element-60e8e112 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="60e8e112" data-element_type="widget" data-widget_type="icon-list.default">
				<div class="elementor-widget-container">
					<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
											<a href="https://mobiel.iriscall.com/">

											<span class="elementor-icon-list-text">Mobiel</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://mobiel.iriscall.com/">

											<span class="elementor-icon-list-text">Zakelijk</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://mobiel.iriscall.com/particulier">

											<span class="elementor-icon-list-text">Particulier</span>
											</a>
									</li>
						</ul>
				</div>
				</div>
				<div class="elementor-element elementor-element-15659be8 elementor-widget elementor-widget-heading" data-id="15659be8" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Axis</h2>		</div>
				</div>
				<div class="elementor-element elementor-element-452f214c elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="452f214c" data-element_type="widget" data-widget_type="icon-list.default">
				<div class="elementor-widget-container">
					<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
											<a href="https://axis.iriscall.com/">

											<span class="elementor-icon-list-text">Axis</span>
											</a>
									</li>
						</ul>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-16 elementor-top-column elementor-element elementor-element-70abbc9e" data-id="70abbc9e" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-4b85cc21 elementor-widget elementor-widget-heading" data-id="4b85cc21" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Shop</h2>		</div>
				</div>
				<div class="elementor-element elementor-element-38c9d707 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="38c9d707" data-element_type="widget" data-widget_type="icon-list.default">
				<div class="elementor-widget-container">
					<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
											<a href="https://shop.iriscall.com/product-category/smartphone/apple/">

											<span class="elementor-icon-list-text">Apple</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://shop.iriscall.com/product-category/smartphone/samsung/">

											<span class="elementor-icon-list-text">Samsung</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://shop.iriscall.com/product-category/smartphone/getnord/">

											<span class="elementor-icon-list-text">Getnord</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://shop.iriscall.com/product-category/telefoon-accessoires/">

											<span class="elementor-icon-list-text">Mobiele accessoires</span>
											</a>
									</li>
						</ul>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-16 elementor-top-column elementor-element elementor-element-14b818a1" data-id="14b818a1" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-4ab8e47e elementor-widget elementor-widget-heading" data-id="4ab8e47e" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Volg ons</h2>		</div>
				</div>
				<div class="elementor-element elementor-element-322e379f elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="322e379f" data-element_type="widget" data-widget_type="icon-list.default">
				<div class="elementor-widget-container">
					<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
											<a href="https://www.facebook.com/IrisCallBE" target="_blank">

												<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="fab fa-facebook"></i>						</span>
										<span class="elementor-icon-list-text">Facebook</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://www.instagram.com/iriscall_be/" target="_blank">

												<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="fab fa-instagram"></i>						</span>
										<span class="elementor-icon-list-text">Instagram</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://www.linkedin.com/company/iriscall/" target="_blank">

												<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="fab fa-linkedin-in"></i>						</span>
										<span class="elementor-icon-list-text">Linkedin</span>
											</a>
									</li>
								<li class="elementor-icon-list-item">
											<a href="https://twitter.com/iriscallbe" target="_blank">

												<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="fab fa-twitter"></i>						</span>
										<span class="elementor-icon-list-text">Twitter</span>
											</a>
									</li>
						</ul>
				</div>
				</div>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
				<footer data-particle_enable="false" data-particle-mobile-disabled="false" class="elementor-section elementor-top-section elementor-element elementor-element-0c2790d elementor-section-content-middle elementor-section-height-min-height elementor-section-boxed elementor-section-height-default elementor-section-items-middle" data-id="0c2790d" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
						<div class="elementor-container elementor-column-gap-no">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-55b559f" data-id="55b559f" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-5d81ba0 elementor-widget elementor-widget-copyright" data-id="5d81ba0" data-element_type="widget" data-widget_type="copyright.default">
				<div class="elementor-widget-container">
					<div class="hfe-copyright-wrapper">
							<span>© Copyright 2021 |  IrisCall - Telecom &amp; Websites  | Alle rechten voorbehouden</span>
					</div>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-78e956e" data-id="78e956e" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-6105ea8 elementor-icon-list--layout-inline elementor-align-right elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="6105ea8" data-element_type="widget" data-widget_type="icon-list.default">
				<div class="elementor-widget-container">
					<ul class="elementor-icon-list-items elementor-inline-items">
							<li class="elementor-icon-list-item elementor-inline-item">
											<a href="/algemene-voorwaarden-zakelijk/" target="_blank">

											<span class="elementor-icon-list-text">Algemene Voorwaarden</span>
											</a>
									</li>
								<li class="elementor-icon-list-item elementor-inline-item">
											<a href="https://mobiel.iriscall.com/privacy-policy-zakelijk/" target="_blank">

											<span class="elementor-icon-list-text">Privacybeleid</span>
											</a>
									</li>
						</ul>
				</div>
				</div>
						</div>
					</div>
		</div>
								</div>
					</div>
		</footer>
				</div>
		</div>
		
<link rel='stylesheet' id='elementor-post-2546-css'  href='https://mobiel.iriscall.com/wp-content/uploads/elementor/css/post-2546.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-2105-css'  href='https://mobiel.iriscall.com/wp-content/uploads/elementor/css/post-2105.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-2108-css'  href='https://mobiel.iriscall.com/wp-content/uploads/elementor/css/post-2108.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-2112-css'  href='https://mobiel.iriscall.com/wp-content/uploads/elementor/css/post-2112.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-1895-css'  href='https://mobiel.iriscall.com/wp-content/uploads/elementor/css/post-1895.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-1907-css'  href='https://mobiel.iriscall.com/wp-content/uploads/elementor/css/post-1907.css' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-1911-css'  href='https://mobiel.iriscall.com/wp-content/uploads/elementor/css/post-1911.css' type='text/css' media='all' />
<link rel='stylesheet' id='e-animations-css'  href='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/animations/animations.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='google-fonts-2-css'  href='https://fonts.googleapis.com/css?family=Oswald%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;display=auto&#038;ver=5.8.1' type='text/css' media='all' />
<script type='text/javascript' id='cb70d11b8-js-extra'>
/* <![CDATA[ */
var localize = {"ajaxurl":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin-ajax.php","nonce":"182aed75af","i18n":{"added":"Added ","compare":"Compare","loading":"Loading..."},"ParticleThemesData":{"default":"{\"particles\":{\"number\":{\"value\":160,\"density\":{\"enable\":true,\"value_area\":800}},\"color\":{\"value\":\"#ffffff\"},\"shape\":{\"type\":\"circle\",\"stroke\":{\"width\":0,\"color\":\"#000000\"},\"polygon\":{\"nb_sides\":5},\"image\":{\"src\":\"img\/github.svg\",\"width\":100,\"height\":100}},\"opacity\":{\"value\":0.5,\"random\":false,\"anim\":{\"enable\":false,\"speed\":1,\"opacity_min\":0.1,\"sync\":false}},\"size\":{\"value\":3,\"random\":true,\"anim\":{\"enable\":false,\"speed\":40,\"size_min\":0.1,\"sync\":false}},\"line_linked\":{\"enable\":true,\"distance\":150,\"color\":\"#ffffff\",\"opacity\":0.4,\"width\":1},\"move\":{\"enable\":true,\"speed\":6,\"direction\":\"none\",\"random\":false,\"straight\":false,\"out_mode\":\"out\",\"bounce\":false,\"attract\":{\"enable\":false,\"rotateX\":600,\"rotateY\":1200}}},\"interactivity\":{\"detect_on\":\"canvas\",\"events\":{\"onhover\":{\"enable\":true,\"mode\":\"repulse\"},\"onclick\":{\"enable\":true,\"mode\":\"push\"},\"resize\":true},\"modes\":{\"grab\":{\"distance\":400,\"line_linked\":{\"opacity\":1}},\"bubble\":{\"distance\":400,\"size\":40,\"duration\":2,\"opacity\":8,\"speed\":3},\"repulse\":{\"distance\":200,\"duration\":0.4},\"push\":{\"particles_nb\":4},\"remove\":{\"particles_nb\":2}}},\"retina_detect\":true}","nasa":"{\"particles\":{\"number\":{\"value\":250,\"density\":{\"enable\":true,\"value_area\":800}},\"color\":{\"value\":\"#ffffff\"},\"shape\":{\"type\":\"circle\",\"stroke\":{\"width\":0,\"color\":\"#000000\"},\"polygon\":{\"nb_sides\":5},\"image\":{\"src\":\"img\/github.svg\",\"width\":100,\"height\":100}},\"opacity\":{\"value\":1,\"random\":true,\"anim\":{\"enable\":true,\"speed\":1,\"opacity_min\":0,\"sync\":false}},\"size\":{\"value\":3,\"random\":true,\"anim\":{\"enable\":false,\"speed\":4,\"size_min\":0.3,\"sync\":false}},\"line_linked\":{\"enable\":false,\"distance\":150,\"color\":\"#ffffff\",\"opacity\":0.4,\"width\":1},\"move\":{\"enable\":true,\"speed\":1,\"direction\":\"none\",\"random\":true,\"straight\":false,\"out_mode\":\"out\",\"bounce\":false,\"attract\":{\"enable\":false,\"rotateX\":600,\"rotateY\":600}}},\"interactivity\":{\"detect_on\":\"canvas\",\"events\":{\"onhover\":{\"enable\":true,\"mode\":\"bubble\"},\"onclick\":{\"enable\":true,\"mode\":\"repulse\"},\"resize\":true},\"modes\":{\"grab\":{\"distance\":400,\"line_linked\":{\"opacity\":1}},\"bubble\":{\"distance\":250,\"size\":0,\"duration\":2,\"opacity\":0,\"speed\":3},\"repulse\":{\"distance\":400,\"duration\":0.4},\"push\":{\"particles_nb\":4},\"remove\":{\"particles_nb\":2}}},\"retina_detect\":true}","bubble":"{\"particles\":{\"number\":{\"value\":15,\"density\":{\"enable\":true,\"value_area\":800}},\"color\":{\"value\":\"#1b1e34\"},\"shape\":{\"type\":\"polygon\",\"stroke\":{\"width\":0,\"color\":\"#000\"},\"polygon\":{\"nb_sides\":6},\"image\":{\"src\":\"img\/github.svg\",\"width\":100,\"height\":100}},\"opacity\":{\"value\":0.3,\"random\":true,\"anim\":{\"enable\":false,\"speed\":1,\"opacity_min\":0.1,\"sync\":false}},\"size\":{\"value\":50,\"random\":false,\"anim\":{\"enable\":true,\"speed\":10,\"size_min\":40,\"sync\":false}},\"line_linked\":{\"enable\":false,\"distance\":200,\"color\":\"#ffffff\",\"opacity\":1,\"width\":2},\"move\":{\"enable\":true,\"speed\":8,\"direction\":\"none\",\"random\":false,\"straight\":false,\"out_mode\":\"out\",\"bounce\":false,\"attract\":{\"enable\":false,\"rotateX\":600,\"rotateY\":1200}}},\"interactivity\":{\"detect_on\":\"canvas\",\"events\":{\"onhover\":{\"enable\":false,\"mode\":\"grab\"},\"onclick\":{\"enable\":false,\"mode\":\"push\"},\"resize\":true},\"modes\":{\"grab\":{\"distance\":400,\"line_linked\":{\"opacity\":1}},\"bubble\":{\"distance\":400,\"size\":40,\"duration\":2,\"opacity\":8,\"speed\":3},\"repulse\":{\"distance\":200,\"duration\":0.4},\"push\":{\"particles_nb\":4},\"remove\":{\"particles_nb\":2}}},\"retina_detect\":true}","snow":"{\"particles\":{\"number\":{\"value\":450,\"density\":{\"enable\":true,\"value_area\":800}},\"color\":{\"value\":\"#fff\"},\"shape\":{\"type\":\"circle\",\"stroke\":{\"width\":0,\"color\":\"#000000\"},\"polygon\":{\"nb_sides\":5},\"image\":{\"src\":\"img\/github.svg\",\"width\":100,\"height\":100}},\"opacity\":{\"value\":0.5,\"random\":true,\"anim\":{\"enable\":false,\"speed\":1,\"opacity_min\":0.1,\"sync\":false}},\"size\":{\"value\":5,\"random\":true,\"anim\":{\"enable\":false,\"speed\":40,\"size_min\":0.1,\"sync\":false}},\"line_linked\":{\"enable\":false,\"distance\":500,\"color\":\"#ffffff\",\"opacity\":0.4,\"width\":2},\"move\":{\"enable\":true,\"speed\":6,\"direction\":\"bottom\",\"random\":false,\"straight\":false,\"out_mode\":\"out\",\"bounce\":false,\"attract\":{\"enable\":false,\"rotateX\":600,\"rotateY\":1200}}},\"interactivity\":{\"detect_on\":\"canvas\",\"events\":{\"onhover\":{\"enable\":true,\"mode\":\"bubble\"},\"onclick\":{\"enable\":true,\"mode\":\"repulse\"},\"resize\":true},\"modes\":{\"grab\":{\"distance\":400,\"line_linked\":{\"opacity\":0.5}},\"bubble\":{\"distance\":400,\"size\":4,\"duration\":0.3,\"opacity\":1,\"speed\":3},\"repulse\":{\"distance\":200,\"duration\":0.4},\"push\":{\"particles_nb\":4},\"remove\":{\"particles_nb\":2}}},\"retina_detect\":true}","nyan_cat":"{\"particles\":{\"number\":{\"value\":150,\"density\":{\"enable\":false,\"value_area\":800}},\"color\":{\"value\":\"#ffffff\"},\"shape\":{\"type\":\"star\",\"stroke\":{\"width\":0,\"color\":\"#000000\"},\"polygon\":{\"nb_sides\":5},\"image\":{\"src\":\"http:\/\/wiki.lexisnexis.com\/academic\/images\/f\/fb\/Itunes_podcast_icon_300.jpg\",\"width\":100,\"height\":100}},\"opacity\":{\"value\":0.5,\"random\":false,\"anim\":{\"enable\":false,\"speed\":1,\"opacity_min\":0.1,\"sync\":false}},\"size\":{\"value\":4,\"random\":true,\"anim\":{\"enable\":false,\"speed\":40,\"size_min\":0.1,\"sync\":false}},\"line_linked\":{\"enable\":false,\"distance\":150,\"color\":\"#ffffff\",\"opacity\":0.4,\"width\":1},\"move\":{\"enable\":true,\"speed\":14,\"direction\":\"left\",\"random\":false,\"straight\":true,\"out_mode\":\"out\",\"bounce\":false,\"attract\":{\"enable\":false,\"rotateX\":600,\"rotateY\":1200}}},\"interactivity\":{\"detect_on\":\"canvas\",\"events\":{\"onhover\":{\"enable\":false,\"mode\":\"grab\"},\"onclick\":{\"enable\":true,\"mode\":\"repulse\"},\"resize\":true},\"modes\":{\"grab\":{\"distance\":200,\"line_linked\":{\"opacity\":1}},\"bubble\":{\"distance\":400,\"size\":40,\"duration\":2,\"opacity\":8,\"speed\":3},\"repulse\":{\"distance\":200,\"duration\":0.4},\"push\":{\"particles_nb\":4},\"remove\":{\"particles_nb\":2}}},\"retina_detect\":true}"},"eael_translate_text":{"required_text":"is a required field","invalid_text":"Invalid","billing_text":"Billing"},"eael_login_nonce":"692b2e31a2","eael_register_nonce":"f21c2268ff"};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/uploads/essential-addons-elementor/cb70d11b8.min.js' id='cb70d11b8-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/uploads/siteground-optimizer-assets/plus-purge-js.min.js' id='plus-purge-js-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/jquery/ui/core.min.js' id='jquery-ui-core-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/jquery/ui/mouse.min.js' id='jquery-ui-mouse-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/jquery/ui/slider.min.js' id='jquery-ui-slider-js'></script>
<script type='text/javascript' src='//mobiel.iriscall.com/wp-content/uploads/theplus-addons/theplus-post-1745.min.js' id='theplus-front-js-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-reviews/assets/js/lib/vue.min.js' id='jet-vue-js'></script>
<script type='text/javascript' id='jet-menu-public-scripts-js-extra'>
/* <![CDATA[ */
var jetMenuPublicSettings = {"version":"2.1.1","ajaxUrl":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin-ajax.php","isMobile":"false","templateApiUrl":"https:\/\/mobiel.iriscall.com\/wp-json\/jet-menu-api\/v1\/elementor-template","menuItemsApiUrl":"https:\/\/mobiel.iriscall.com\/wp-json\/jet-menu-api\/v1\/get-menu-items","restNonce":"116ae9fede","devMode":"true","wpmlLanguageCode":"","menuSettings":{"jetMenuRollUp":"true","jetMenuMouseleaveDelay":"500","jetMenuMegaWidthType":"selector","jetMenuMegaWidthSelector":"body","jetMenuMegaOpenSubType":"hover","jetMenuMegaAjax":"false"}};
var CxCollectedCSS = {"type":"text\/css","title":"cx-collected-dynamic-style","css":".jet-menu .jet-menu-item .top-level-link .jet-menu-icon {align-self:center; }.jet-menu  {justify-content:flex-end !important; }.jet-menu ul.jet-sub-menu {min-width:200px; }.jet-mobile-menu-single .jet-menu-icon {-webkit-align-self:center; align-self:center; }.jet-mobile-menu-single .jet-menu-badge {-webkit-align-self:flex-start; align-self:flex-start; }"};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/uploads/siteground-optimizer-assets/jet-menu-public-scripts.min.js' id='jet-menu-public-scripts-js'></script>
<script type='text/javascript' id='jet-menu-public-scripts-js-after'>
function CxCSSCollector(){"use strict";var t,e=window.CxCollectedCSS;void 0!==e&&((t=document.createElement("style")).setAttribute("title",e.title),t.setAttribute("type",e.type),t.textContent=e.css,document.head.appendChild(t))}CxCSSCollector();
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/jquery/ui/draggable.min.js' id='jquery-ui-draggable-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/underscore.min.js' id='underscore-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/backbone.min.js' id='backbone-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/backbone/backbone.marionette.min.js' id='backbone-marionette-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/backbone/backbone.radio.min.js' id='backbone-radio-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/js/common-modules.min.js' id='elementor-common-modules-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/dialog/dialog.min.js' id='elementor-dialog-js'></script>
<script type='text/javascript' id='wp-api-request-js-extra'>
/* <![CDATA[ */
var wpApiSettings = {"root":"https:\/\/mobiel.iriscall.com\/wp-json\/","nonce":"116ae9fede","versionString":"wp\/v2\/"};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/api-request.min.js' id='wp-api-request-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/dist/vendor/regenerator-runtime.min.js' id='regenerator-runtime-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/dist/vendor/wp-polyfill.min.js' id='wp-polyfill-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/dist/hooks.min.js' id='wp-hooks-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/dist/i18n.min.js' id='wp-i18n-js'></script>
<script type='text/javascript' id='wp-i18n-js-after'>
wp.i18n.setLocaleData( { 'text direction\u0004ltr': [ 'ltr' ] } );
</script>
<script type='text/javascript' id='elementor-common-js-translations'>
( function( domain, translations ) {
	var localeData = translations.locale_data[ domain ] || translations.locale_data.messages;
	localeData[""].domain = domain;
	wp.i18n.setLocaleData( localeData, domain );
} )( "elementor", { "locale_data": { "messages": { "": {} } } } );
</script>
<script type='text/javascript' id='elementor-common-js-before'>
var elementorCommonConfig = {"version":"3.4.4","isRTL":false,"isDebug":false,"isElementorDebug":false,"activeModules":["ajax","finder","connect"],"experimentalFeatures":{"e_import_export":true,"landing-pages":true,"elements-color-picker":true,"admin-top-bar":true,"form-submissions":true},"urls":{"assets":"https:\/\/mobiel.iriscall.com\/wp-content\/plugins\/elementor\/assets\/","rest":"https:\/\/mobiel.iriscall.com\/wp-json\/"},"ajax":{"url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin-ajax.php","nonce":"f3450a5d52"},"finder":{"data":{"edit":{"title":"Edit","dynamic":true,"name":"edit"},"general":{"title":"General","dynamic":false,"items":{"saved-templates":{"title":"Saved Templates","icon":"library-save","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?post_type=elementor_library&tabs_group=library","keywords":["template","section","page","library"]},"system-info":{"title":"System Info","icon":"info-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor-system-info","keywords":["system","info","environment","elementor"]},"role-manager":{"title":"Role Manager","icon":"person","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor-role-manager","keywords":["role","manager","user","elementor"]},"knowledge-base":{"title":"Knowledge Base","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=go_knowledge_base_site","keywords":["help","knowledge","docs","elementor"]},"theme-builder":{"title":"Theme Builder","icon":"library-save","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor-app&ver=3.4.4#\/site-editor","keywords":["template","header","footer","single","archive","search","404","library"]},"popups":{"title":"Popups","icon":"library-save","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?post_type=elementor_library&tabs_group=popup&elementor_library_type=popup","keywords":["template","popup","library"]}},"name":"general"},"create":{"title":"Create","dynamic":false,"items":{"post":{"title":"Add New Post","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=post&_wpnonce=c7dc8afd16","keywords":["post","page","template","new","create"]},"page":{"title":"Add New Page","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=page&_wpnonce=c7dc8afd16","keywords":["post","page","template","new","create"]},"jet-menu":{"title":"Add New Mega Menu Item","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=jet-menu&_wpnonce=c7dc8afd16","keywords":["post","page","template","new","create"]},"jet-popup":{"title":"Add New JetPopup","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=jet-popup&_wpnonce=c7dc8afd16","keywords":["post","page","template","new","create"]},"e-landing-page":{"title":"Add New Landing Page","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=e-landing-page&_wpnonce=c7dc8afd16","keywords":["post","page","template","new","create"]},"elementor_library":{"title":"Add New Template","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?post_type=elementor_library#add_new","keywords":["post","page","template","new","create"]},"plus-mega-menu":{"title":"Add New Plus Mega Menu","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=plus-mega-menu&_wpnonce=c7dc8afd16","keywords":["post","page","template","new","create"]},"elementor-hf":{"title":"Add New Elementor Header & Footer Builder","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=elementor-hf&_wpnonce=c7dc8afd16","keywords":["post","page","template","new","create"]},"jet-theme-core":{"title":"Add New Template","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=jet-theme-core&_wpnonce=c7dc8afd16","keywords":["post","page","template","new","create"]},"jet-engine":{"title":"Add New Listing Item","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=jet-engine&_wpnonce=c7dc8afd16","keywords":["post","page","template","new","create"]},"popups":{"title":"Add New Popup","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?post_type=elementor_library&tabs_group=popup&elementor_library_type=popup#add_new","keywords":["template","theme","popup","new","create"]},"theme-template":{"title":"Add New Theme Template","icon":"plus-circle-o","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?post_type=elementor_library&tabs_group=theme#add_new","keywords":["template","theme","new","create"]}},"name":"create"},"site":{"title":"Site","dynamic":false,"items":{"homepage":{"title":"Homepage","url":"https:\/\/mobiel.iriscall.com","icon":"home-heart","keywords":["home","page"]},"wordpress-dashboard":{"title":"Dashboard","icon":"dashboard","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/","keywords":["dashboard","wordpress"]},"wordpress-menus":{"title":"Menus","icon":"wordpress","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/nav-menus.php","keywords":["menu","wordpress"]},"wordpress-themes":{"title":"Themes","icon":"wordpress","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/themes.php","keywords":["themes","wordpress"]},"wordpress-customizer":{"title":"Customizer","icon":"wordpress","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/customize.php","keywords":["customizer","wordpress"]},"wordpress-plugins":{"title":"Plugins","icon":"wordpress","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/plugins.php","keywords":["plugins","wordpress"]},"wordpress-users":{"title":"Users","icon":"wordpress","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/users.php","keywords":["users","profile","wordpress"]}},"name":"site"},"settings":{"title":"Settings","dynamic":false,"items":{"general-settings":{"title":"General Settings","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor","keywords":["general","settings","elementor"]},"advanced":{"title":"Advanced","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor#tab-advanced","keywords":["advanced","settings","elementor"]},"experiments":{"title":"Experiments","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor#tab-experiments","keywords":["settings","elementor","experiments"]},"custom-fonts":{"title":"Custom Fonts","icon":"typography","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?post_type=elementor_font","keywords":["custom","fonts","elementor"]},"custom-icons":{"title":"Custom Icons","icon":"favorite","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/edit.php?post_type=elementor_icons","keywords":["custom","icons","elementor"]}},"name":"settings"},"tools":{"title":"Tools","dynamic":false,"items":{"tools":{"title":"Tools","icon":"tools","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor-tools","keywords":["tools","regenerate css","safe mode","debug bar","sync library","elementor"]},"replace-url":{"title":"Replace URL","icon":"tools","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor-tools#tab-replace_url","keywords":["tools","replace url","domain","elementor"]},"version-control":{"title":"Version Control","icon":"time-line","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor-tools#tab-versions","keywords":["tools","version","control","rollback","beta","elementor"]},"maintenance-mode":{"title":"Maintenance Mode","icon":"tools","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor-tools#tab-maintenance_mode","keywords":["tools","maintenance","coming soon","elementor"]}},"name":"tools"},"jet-popup-finder-category":{"title":"JetPopup Settings","dynamic":false,"items":{"jet-popup-settings":{"title":"JetPopup Settings","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=jet-dashboard-settings-page&subpage=jet-popup-integrations","keywords":["general","popup","settings","jet","mailchimp"]},"jet-popup-library":{"title":"JetPopup Library","url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?&page=jet-popup-library","icon":"folder","keywords":["popup","library","jet","create","new"]}},"name":"jet-popup-finder-category"}}},"connect":{"is_user_connected":false,"connect_url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor-connect&app=library&action=authorize&nonce=a86bedb494"}};
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/js/common.min.js' id='elementor-common-js'></script>
<script type='text/javascript' id='elementor-app-loader-js-before'>
var elementorAppConfig = {"menu_url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor-app&ver=3.4.4#\/site-editor","assets_url":"https:\/\/mobiel.iriscall.com\/wp-content\/plugins\/elementor\/assets\/","return_url":"https:\/\/mobiel.iriscall.com\/wp-admin\/","hasPro":true,"admin_url":"https:\/\/mobiel.iriscall.com\/wp-admin\/","login_url":"https:\/\/mobiel.iriscall.com\/wp-login.php","site-editor":[],"import-export":[],"kit-library":[]};
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/js/app-loader.min.js' id='elementor-app-loader-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/wp-smush-pro/app/assets/js/smush-lazy-load.min.js' id='smush-lazy-load-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/wp-embed.min.js' id='wp-embed-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/jquery-numerator/jquery-numerator.min.js' id='jquery-numerator-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/imagesloaded.min.js' id='imagesloaded-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-tricks/assets/js/lib/tippy/popperjs.js' id='jet-tricks-popperjs-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-tricks/assets/js/lib/tippy/tippy-bundle.js' id='jet-tricks-tippy-bundle-js'></script>
<script type='text/javascript' src='https://www.google.com/recaptcha/api.js?render=explicit&#038;ver=3.4.1' id='elementor-recaptcha_v3-api-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor-pro/assets/js/webpack-pro.runtime.min.js' id='elementor-pro-webpack-runtime-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/js/webpack.runtime.min.js' id='elementor-webpack-runtime-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/js/frontend-modules.min.js' id='elementor-frontend-modules-js'></script>
<script type='text/javascript' id='elementor-pro-frontend-js-before'>
var ElementorProFrontendConfig = {"ajaxurl":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin-ajax.php","nonce":"03f65cf40c","urls":{"assets":"https:\/\/mobiel.iriscall.com\/wp-content\/plugins\/elementor-pro\/assets\/","rest":"https:\/\/mobiel.iriscall.com\/wp-json\/"},"i18n":{"toc_no_headings_found":"No headings were found on this page."},"shareButtonsNetworks":{"facebook":{"title":"Facebook","has_counter":true},"twitter":{"title":"Twitter"},"google":{"title":"Google+","has_counter":true},"linkedin":{"title":"LinkedIn","has_counter":true},"pinterest":{"title":"Pinterest","has_counter":true},"reddit":{"title":"Reddit","has_counter":true},"vk":{"title":"VK","has_counter":true},"odnoklassniki":{"title":"OK","has_counter":true},"tumblr":{"title":"Tumblr"},"digg":{"title":"Digg"},"skype":{"title":"Skype"},"stumbleupon":{"title":"StumbleUpon","has_counter":true},"mix":{"title":"Mix"},"telegram":{"title":"Telegram"},"pocket":{"title":"Pocket","has_counter":true},"xing":{"title":"XING","has_counter":true},"whatsapp":{"title":"WhatsApp"},"email":{"title":"Email"},"print":{"title":"Print"}},"facebook_sdk":{"lang":"en_US","app_id":""},"lottie":{"defaultAnimationUrl":"https:\/\/mobiel.iriscall.com\/wp-content\/plugins\/elementor-pro\/modules\/lottie\/assets\/animations\/default.json"}};
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor-pro/assets/js/frontend.min.js' id='elementor-pro-frontend-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/waypoints/waypoints.min.js' id='elementor-waypoints-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/swiper/swiper.min.js' id='swiper-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/lib/share-link/share-link.min.js' id='share-link-js'></script>
<script type='text/javascript' id='elementor-frontend-js-before'>
var elementorFrontendConfig = {"environmentMode":{"edit":false,"wpPreview":false,"isScriptDebug":false},"i18n":{"shareOnFacebook":"Share on Facebook","shareOnTwitter":"Share on Twitter","pinIt":"Pin it","download":"Download","downloadImage":"Download image","fullscreen":"Fullscreen","zoom":"Zoom","share":"Share","playVideo":"Play Video","previous":"Previous","next":"Next","close":"Close"},"is_rtl":false,"breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"responsive":{"breakpoints":{"mobile":{"label":"Mobile","value":767,"default_value":767,"direction":"max","is_enabled":true},"mobile_extra":{"label":"Mobile Extra","value":880,"default_value":880,"direction":"max","is_enabled":false},"tablet":{"label":"Tablet","value":1024,"default_value":1024,"direction":"max","is_enabled":true},"tablet_extra":{"label":"Tablet Extra","value":1200,"default_value":1200,"direction":"max","is_enabled":false},"laptop":{"label":"Laptop","value":1366,"default_value":1366,"direction":"max","is_enabled":false},"widescreen":{"label":"Widescreen","value":2400,"default_value":2400,"direction":"min","is_enabled":false}}},"version":"3.4.4","is_static":false,"experimentalFeatures":{"e_import_export":true,"landing-pages":true,"elements-color-picker":true,"admin-top-bar":true,"form-submissions":true},"urls":{"assets":"https:\/\/mobiel.iriscall.com\/wp-content\/plugins\/elementor\/assets\/"},"settings":{"page":[],"editorPreferences":[]},"kit":{"active_breakpoints":["viewport_mobile","viewport_tablet"],"global_image_lightbox":"yes","lightbox_enable_counter":"yes","lightbox_enable_fullscreen":"yes","lightbox_enable_zoom":"yes","lightbox_enable_share":"yes","lightbox_title_src":"title","lightbox_description_src":"description"},"post":{"id":1745,"title":"Home%20%7C%20IrisCall%20-%20Telecom%20%26%20Websites","excerpt":"","featuredImage":"https:\/\/mobiel.iriscall.com\/wp-content\/uploads\/2021\/01\/Mobiel_Zakelijk_Home_Blog_BesteApps-2-1024x683-1.jpg"},"user":{"roles":["administrator"]}};
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/js/frontend.min.js' id='elementor-frontend-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor-pro/assets/js/preloaded-elements-handlers.min.js' id='pro-preloaded-elements-handlers-js'></script>
<script type='text/javascript' id='jet-blocks-js-extra'>
/* <![CDATA[ */
var JetHamburgerPanelSettings = {"ajaxurl":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin-ajax.php","isMobile":"false","templateApiUrl":"https:\/\/mobiel.iriscall.com\/wp-json\/jet-blocks-api\/v1\/elementor-template","devMode":"true"};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-blocks/assets/js/jet-blocks.min.js' id='jet-blocks-js'></script>
<script type='text/javascript' id='jet-elements-js-extra'>
/* <![CDATA[ */
var jetElements = {"ajaxUrl":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin-ajax.php","isMobile":"false","templateApiUrl":"https:\/\/mobiel.iriscall.com\/wp-json\/jet-elements-api\/v1\/elementor-template","devMode":"true","messages":{"invalidMail":"Please specify a valid e-mail"}};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-elements/assets/js/jet-elements.min.js' id='jet-elements-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-menu/includes/elementor/assets/public/js/legacy/widgets-scripts.js' id='jet-menu-elementor-widgets-scripts-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-elements/assets/js/lib/anime-js/anime.min.js' id='jet-anime-js-js'></script>
<script type='text/javascript' id='jet-popup-frontend-js-extra'>
/* <![CDATA[ */
var jetPopupData = {"elements_data":{"sections":[],"columns":[],"widgets":[]},"version":"1.5.5","ajax_url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin-ajax.php"};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-popup/assets/js/jet-popup-frontend.js' id='jet-popup-frontend-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/dist/vendor/lodash.min.js' id='lodash-js'></script>
<script type='text/javascript' id='lodash-js-after'>
window.lodash = _.noConflict();
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/dist/url.min.js' id='wp-url-js'></script>
<script type='text/javascript' id='wp-api-fetch-js-translations'>
( function( domain, translations ) {
	var localeData = translations.locale_data[ domain ] || translations.locale_data.messages;
	localeData[""].domain = domain;
	wp.i18n.setLocaleData( localeData, domain );
} )( "default", { "locale_data": { "messages": { "": {} } } } );
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/dist/api-fetch.min.js' id='wp-api-fetch-js'></script>
<script type='text/javascript' id='wp-api-fetch-js-after'>
wp.apiFetch.use( wp.apiFetch.createRootURLMiddleware( "https://mobiel.iriscall.com/wp-json/" ) );
wp.apiFetch.nonceMiddleware = wp.apiFetch.createNonceMiddleware( "116ae9fede" );
wp.apiFetch.use( wp.apiFetch.nonceMiddleware );
wp.apiFetch.use( wp.apiFetch.mediaUploadMiddleware );
wp.apiFetch.nonceEndpoint = "https://mobiel.iriscall.com/wp-admin/admin-ajax.php?action=rest-nonce";
</script>
<script type='text/javascript' id='jet-reviews-frontend-js-extra'>
/* <![CDATA[ */
var jetReviewPublicConfig = {"version":"2.2.4","ajax_url":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin-ajax.php","current_url":"https:\/\/mobiel.iriscall.com","getPublicReviewsRoute":"\/jet-reviews-api\/v1\/get-public-reviews-list","submitReviewCommentRoute":"\/jet-reviews-api\/v1\/submit-review-comment","submitReviewRoute":"\/jet-reviews-api\/v1\/submit-review","likeReviewRoute":"\/jet-reviews-api\/v1\/update-review-approval","reviewTypeData":{"id":"1","name":"Default","slug":"default","description":"","source":"default","fields":[{"label":"Rating","step":1,"max":5}],"meta_data":""},"labels":{"alreadyReviewed":"*Already reviewed","notApprove":"*Your review must be approved by the moderator","notValidField":"*This field is required or not valid","captchaValidationFailed":"*Captcha validation failed"},"recaptchaConfig":""};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-reviews/assets/js/jet-reviews-frontend.js' id='jet-reviews-frontend-js'></script>
<script type='text/javascript' id='jet-tabs-frontend-js-extra'>
/* <![CDATA[ */
var JetTabsSettings = {"ajaxurl":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin-ajax.php","isMobile":"false","templateApiUrl":"https:\/\/mobiel.iriscall.com\/wp-json\/jet-tabs-api\/v1\/elementor-template","devMode":"true"};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-tabs/assets/js/jet-tabs-frontend.min.js' id='jet-tabs-frontend-js'></script>
<script type='text/javascript' id='jet-tricks-frontend-js-extra'>
/* <![CDATA[ */
var JetTricksSettings = {"elements_data":{"sections":{"b32cae5":{"view_more":false,"particles":"false","particles_json":null},"1fb0bde9":{"view_more":false,"particles":"false","particles_json":null},"53b1533":{"view_more":false,"particles":"false","particles_json":null},"605cc7ae":{"view_more":false,"particles":"false","particles_json":null},"2f8f48ae":{"view_more":false,"particles":"false","particles_json":null},"d668b28":{"view_more":false,"particles":"false","particles_json":null},"6f2d6c0":{"view_more":false,"particles":"false","particles_json":null},"0132135":{"view_more":false,"particles":"false","particles_json":null},"153d29a":{"view_more":false,"particles":"false","particles_json":null},"33a2684":{"view_more":false,"particles":"false","particles_json":null},"26e92d9":{"view_more":false,"particles":"false","particles_json":null},"672d855":{"view_more":false,"particles":"false","particles_json":null},"45bb6f6":{"view_more":false,"particles":"false","particles_json":null},"732ef7a":{"view_more":false,"particles":"false","particles_json":null},"3ad2431":{"view_more":false,"particles":"false","particles_json":null},"826e4d3":{"view_more":false,"particles":"false","particles_json":null},"40b7c6f":{"view_more":false,"particles":"false","particles_json":null},"f178b04":{"view_more":false,"particles":"false","particles_json":null},"7714984":{"view_more":false,"particles":"false","particles_json":null},"7c1a73c8":{"view_more":false,"particles":"false","particles_json":null},"0c11e65":{"view_more":false,"particles":"false","particles_json":null},"c8a266b":{"view_more":false,"particles":"false","particles_json":null},"bb9dbe3":{"view_more":false,"particles":"false","particles_json":null},"594b7e21":{"view_more":false,"particles":"false","particles_json":null},"1747efa":{"view_more":false,"particles":"false","particles_json":null},"7ac1a37":{"view_more":false,"particles":"false","particles_json":null},"6bc5498":{"view_more":false,"particles":"false","particles_json":null},"3228ef35":{"view_more":false,"particles":"false","particles_json":null},"5d73b01":{"view_more":false,"particles":"false","particles_json":null},"4d4a75b8":{"view_more":false,"particles":"false","particles_json":null},"1a373aa8":{"view_more":false,"particles":"false","particles_json":null},"698d7f0":{"view_more":false,"particles":"false","particles_json":null},"0c2790d":{"view_more":false,"particles":"false","particles_json":null}},"columns":[],"widgets":{"875dced":[],"b32e958":[],"65ff7e7f":[],"c146e62":[],"25a68ede":[],"ac7abd2":[],"778d46d3":[],"38878ab5":[],"104f7b8d":[],"44df306":[],"91a8d62":[],"9206a6a":[],"6da487a5":[],"769b6f72":[],"73323342":[],"2d51b43f":[],"54f93186":[],"770d90e":[],"5e1b27e":[],"6f5c38a":[],"9c5b977":[],"75534bc":[],"da63426":[],"8b2ab32":[],"a011cc6":[],"642c6f4":[],"f3769d4":[],"fb111dd":[],"b25e857":[],"b8ad871":[],"f7a9482":[],"77f6c14":[],"7454a6a":[],"c28224b":[],"8ff697e":[],"aef640f":[],"a585595":[],"4896a55":[],"098303a":[],"000c3db":[],"7555f75":[],"6f216ce":[],"2b3fba1":[],"02b154a":[],"1b94c28":[],"050a0ce":[],"d9dcef7":[],"97be349":[],"d7fa23e":[],"ee5d4ff":[],"c68dcc7":[],"482aa61":[],"920b2db":[],"61fb83f":[],"fed11ae":[],"03df0c3":[],"37cce53":[],"c930f9a":[],"643f872":[],"e70700e":[],"2d589e4":[],"22cabf9":[],"129ec35":[],"11443c8":[],"ad55848":[],"38d1457":[],"4f77572":[],"9eb8921":[],"14e7f6c":[],"76c12c8":[],"9e12c63":[],"a98ba5e":[],"30856f9":[],"8c06a7e":[],"0a5c436":[],"89258ac":[],"430c827":[],"de41d00":[],"5d2c498":[],"3b78dde":[],"c0c5f66":[],"56a3a24":[],"d06257f":[],"c6f425f":[],"4b9f593":[],"0509ad5":[],"c6f58a4":[],"f9b91c5":[],"1d8ed90":[],"183bd5a":[],"31cd525":[],"71e91dd":[],"0c29f6b":[],"808ae5f":[],"a039165":[],"97b2bbf":[],"7984fec":[],"eede8d5":[],"c8c0fe8":[],"406cba9":[],"d07d5b1":[],"dcad446":[],"06fd067":[],"d69289d":[],"fcbb4b8":[],"e1e3c54":[],"a9b7275":[],"d025169":[],"e853f2d":[],"7bf50e2":[],"2912178":[],"4636137":[],"be51676":[],"1c1350e":[],"214bbf38":[],"43c72d62":[],"2f307fa8":[],"5b61b062":[],"27fd76d8":[],"4900447a":[],"64f85b8":[],"60e8e112":[],"15659be8":[],"452f214c":[],"4b85cc21":[],"38c9d707":[],"4ab8e47e":[],"322e379f":[],"5d81ba0":[],"6105ea8":[]}}};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-tricks/assets/js/jet-tricks-frontend.js' id='jet-tricks-frontend-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/theplus_elementor_addon/assets/js/main/event-tracker/plus-event-tracker.min.js' id='plus-event-tracker-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/theplus_elementor_addon/assets/js/main/section-column-link/plus-section-column-link.min.js' id='plus-section-column-link-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/js/preloaded-modules.min.js' id='preloaded-modules-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor-pro/assets/lib/sticky/jquery.sticky.min.js' id='e-sticky-js'></script>
<script type='text/javascript' id='jet-blog-js-extra'>
/* <![CDATA[ */
var JetBlogSettings = {"ajaxurl":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin-ajax.php"};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-blog/assets/js/jet-blog.min.js' id='jet-blog-js'></script>
<script type='text/javascript' id='wp-util-js-extra'>
/* <![CDATA[ */
var _wpUtilSettings = {"ajax":{"url":"\/wp-admin\/admin-ajax.php"}};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/wp-util.min.js' id='wp-util-js'></script>
<script type='text/javascript' id='jet-search-js-extra'>
/* <![CDATA[ */
var jetSearchSettings = {"ajaxurl":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin-ajax.php","action":"jet_ajax_search","nonce":"202528db0f"};
/* ]]> */
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/jet-search/assets/js/jet-search.js' id='jet-search-js'></script>
<script type='text/javascript' id='elementor-admin-bar-js-before'>
var elementorAdminBarConfig = {"elementor_edit_page":{"id":"elementor_edit_page","title":"Edit with Elementor","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/post.php?post=1745&action=elementor","children":{"2381":{"id":"elementor_edit_doc_2381","title":"Header","sub_title":"Header","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/post.php?post=2381&action=elementor"},"2546":{"id":"elementor_edit_doc_2546","title":"mega-item-2545","sub_title":"Post","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/post.php?post=2546&action=elementor"},"2105":{"id":"elementor_edit_doc_2105","title":"Header-img1","sub_title":"Page","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/post.php?post=2105&action=elementor"},"2108":{"id":"elementor_edit_doc_2108","title":"Header-img2","sub_title":"Page","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/post.php?post=2108&action=elementor"},"2112":{"id":"elementor_edit_doc_2112","title":"Header-img3","sub_title":"Page","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/post.php?post=2112&action=elementor"},"1895":{"id":"elementor_edit_doc_1895","title":"Prijzen zakelijk","sub_title":"Page","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/post.php?post=1895&action=elementor"},"1907":{"id":"elementor_edit_doc_1907","title":"data top-up zakelijk","sub_title":"Page","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/post.php?post=1907&action=elementor"},"1911":{"id":"elementor_edit_doc_1911","title":"data abonnementen zakelijk","sub_title":"Page","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/post.php?post=1911&action=elementor"},"2485":{"id":"elementor_edit_doc_2485","title":"Footer","sub_title":"Footer","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/post.php?post=2485&action=elementor"},"2547":{"id":"elementor_site_settings","title":"Site Settings","sub_title":"Site","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/post.php?post=1745&action=elementor#e:run:panel\/global\/open","class":"elementor-site-settings","parent_class":"elementor-second-section"},"2548":{"id":"elementor_app_site_editor","title":"Theme Builder","sub_title":"Site","href":"https:\/\/mobiel.iriscall.com\/wp-admin\/admin.php?page=elementor-app&ver=3.4.4#\/site-editor","class":"elementor-app-link","parent_class":"elementor-second-section"}}}};
</script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-content/plugins/elementor/assets/js/elementor-admin-bar.min.js' id='elementor-admin-bar-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/hoverintent-js.min.js' id='hoverintent-js-js'></script>
<script type='text/javascript' src='https://mobiel.iriscall.com/wp-includes/js/admin-bar.min.js' id='admin-bar-js'></script>
<script type="text/javascript">
    (function() {
        var request, b = document.body, c = 'className', cs = 'customize-support', rcs = new RegExp('(^|\\s+)(no-)?'+cs+'(\\s+|$)');

            request = true;

        b[c] = b[c].replace( rcs, ' ' );
        // The customizer requires postMessage and CORS (if the site is cross domain).
        b[c] += ( window.postMessage && request ? ' ' : ' no-' ) + cs;
    }());
</script>
</html>
</html>