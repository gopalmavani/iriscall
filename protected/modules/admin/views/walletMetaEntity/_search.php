<?php
/* @var $this WalletMetaEntityController */
/* @var $model WalletMetaEntity */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'reference_id'); ?>
		<?php echo $form->textField($model,'reference_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reference_key'); ?>
		<?php echo $form->textField($model,'reference_key',array('size'=>60,'maxlength'=>80)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reference_desc'); ?>
		<?php echo $form->textField($model,'reference_desc',array('size'=>60,'maxlength'=>80)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reference_data'); ?>
		<?php echo $form->textField($model,'reference_data',array('size'=>60,'maxlength'=>80)); ?>
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