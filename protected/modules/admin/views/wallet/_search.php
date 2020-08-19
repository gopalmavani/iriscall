<?php
/* @var $this WalletController */
/* @var $model Wallet */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'wallet_id'); ?>
		<?php echo $form->textField($model,'wallet_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wallet_type_id'); ?>
		<?php echo $form->textField($model,'wallet_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'transaction_type'); ?>
		<?php echo $form->textField($model,'transaction_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reference_id'); ?>
		<?php echo $form->textField($model,'reference_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reference_num'); ?>
		<?php echo $form->textField($model,'reference_num',array('size'=>60,'maxlength'=>80)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'transaction_comment'); ?>
		<?php echo $form->textField($model,'transaction_comment',array('size'=>60,'maxlength'=>80)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'denomination_id'); ?>
		<?php echo $form->textField($model,'denomination_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'transaction_status'); ?>
		<?php echo $form->textField($model,'transaction_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'portal_id'); ?>
		<?php echo $form->textField($model,'portal_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount'); ?>
		<?php echo $form->textField($model,'amount',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_balance'); ?>
		<?php echo $form->textField($model,'updated_balance',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modified_at'); ?>
		<?php echo $form->textField($model,'modified_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->