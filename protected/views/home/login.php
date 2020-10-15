<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/plugins.bundle.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style.bundle.css');
?>
<style>
    body{
        background: #044e80 !important;
    }
    .boxshadow-content{
        background: #FFF !important;
    }
    body{
        background-color: #56077E !important;
        background-image: url(<?= Yii::app()->baseUrl. '/images/bg-7.jpg'; ?>) !important;
        background-size: cover !important;
        background-attachment: fixed !important;
        background-repeat: no-repeat !important;
    }
</style>
<main id="main-container">
	<!-- Hero Content -->
	<div class="bg-primary-dark">
		<section class="content no-padding content-full content-boxed overflow-hidden">
			<div class="push-100-t push-50 text-center" align="center">
                <!--<h2 class="box-title m-b-20" style="color: #FFF;">Micromaxcash</h2>-->
				<!-- <h1 class="h2 text-white push-10 " data-toggle="appear" data-class="animated fadeInDown">Log in to your dashboard.</h1> -->
			</div>
		</section>
	</div>
    <div class="row" align="center">
        <div class="col-md-12" align="center">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--skin-solid kt-portlet-- kt-bg-primary">
                <div class="kt-portlet__body pt-0">
                    <?php if (isset($success)){ ?>
                        <div style="font-weight: 600;"><?php echo $success; ?></div>
                    <?php }?>
                    <?php if (isset($error)){ ?>
                        <div style="font-weight: 600; color: darkred;"><?php echo $error; ?></div>
                    <?php }?>
                    <?php if (isset($login) && !empty($login)){ ?>
                    <div style="font-weight: 600;margin-top: 10px;">You can login from <a href="<?= Yii::app()->createurl('home/login'); ?>">here</a></div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
<!-- Log In Form -->
<div class="bg-white" style="display: none;">
	<section class="content content-boxed">
		<!-- Section Content -->
		<div class="row items-push push-50-t push-30">
			<div class="col-md-12 col-md-offset-3">

                <?php /*$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'login-form',
                    'action' => Yii::app()->createUrl('home/login'),
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array(
                        'name' => 'UserCreate'
                    )
                ));
                */?><!--
						<div class="form-group">
						<div class="col-xs-12">
							<div class="form-material form-material-primary">
								<label for="frontend-login-username">></label>
								<?php /*echo $form->textField($model,'username', array('placeholder'=>'Enter your Email','class'=>'form-control','autofocus'=>'true')); */?>
								<?php /*echo $form->error($model,'username'); */?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<div class="form-material form-material-primary m-b-20">
								<label for="frontend-login-password"></label>
								<?php /*echo $form->passwordField($model,'password', array('class'=>'form-control','placeholder'=>'Enter your password')); */?>
								<?php /*echo $form->error($model,'password'); */?>
							</div>
							<a  href="<?php /*echo Yii::app()->createUrl('/user/forgot'); */?>"> Forgot Password? </a>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12 text-center">
							<?php /*echo $form->checkBox($model,'rememberMe'); */?>
							<?php /*echo $form->label($model,'rememberMe'); */?>
							<?php /*echo $form->error($model,'rememberMe'); */?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12 col-sm-12 col-sm-offset-3">
						<button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
						</div>
					</div>
					<div class="form-group m-b-0">
                </div>
					--><?php /*$this->endWidget(); */?>
			</div>
		</div>
	</section>
</div>
</main>