<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>
<div class="content overflow-hidden">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
			<div class="block block-themed animated fadeIn">
				<div class="block-header bg-primary">
					<h3 class="block-title">Login</h3>
				</div>
				<div class=" form block-content block-content-full block-content-narrow">
					<div class="login-logo">
						<img src="<?php echo Yii::app()->createUrl('/../admin/plugins/images/CYL-Logo.png') ?>">
						<p>Welcome, please login.</p>
					</div>
					<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'login-form',
						'enableClientValidation'=>true,
						'clientOptions'=>array(
							'validateOnSubmit'=>true,
						),
						'htmlOptions'=>array(
							'class'=>'js-validation-login form-horizontal push-30-t push-50',
						),
					));?>
					<div class="form-group">
						<div class="col-xs-12">
							<div class="form-material form-material-primary floating">
								<?php echo $form->textField($model,'username',array('class' => 'form-control', 'id' => 'login-username')); ?>
								<label for="login-username"><?php echo $form->labelEx($model,'username'); ?></label>
								<?php echo $form->error($model,'username'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<div class="form-material form-material-primary floating">
								<?php echo $form->passwordField($model,'password',array('class' => 'form-control', 'id' => 'login-password')); ?>
								<label for="login-password"><?php echo $form->labelEx($model,'password'); ?></label>
								<?php echo $form->error($model,'password'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12 col-sm-6 col-md-4">
							<?php echo CHtml::tag('Button',array('class'=>'btn btn-block btn-primary'),'<i class="fa fa-sign-in pull-right"></i> Login'); ?>
						</div>
					</div>
					<?php $this->endWidget(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="push-10-t text-center animated fadeInUp">
	<small class="text-muted font-w600"><span class="js-year-copy"></span> &copy; Cyclone</small>
</div>