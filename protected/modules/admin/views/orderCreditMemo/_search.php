<?php
/* @var $this OrderCreditMemoController */
/* @var $model OrderCreditMemo */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'credit_memo_id'); ?>
		<?php echo $form->textField($model,'credit_memo_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_info_id'); ?>
		<?php echo $form->textField($model,'order_info_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty_refunded'); ?>
		<?php echo $form->textField($model,'qty_refunded'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount_to_refund'); ?>
		<?php echo $form->textField($model,'amount_to_refund'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_number'); ?>
		<?php echo $form->textField($model,'invoice_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'memo_status'); ?>
		<?php echo $form->textField($model,'memo_status'); ?>
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