<?php
/* @var $this PoolPlanController */
/* @var $model PoolPlan */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pool_id'); ?>
		<?php echo $form->textField($model,'pool_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pool_name'); ?>
		<?php echo $form->textField($model,'pool_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pool_description'); ?>
		<?php echo $form->textField($model,'pool_description',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pool_amount'); ?>
		<?php echo $form->textField($model,'pool_amount',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pool_denomination'); ?>
		<?php echo $form->textField($model,'pool_denomination',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->