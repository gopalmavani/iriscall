<?php
/* @var $this OrderCreditMemoController */
/* @var $data OrderCreditMemo */
?>

<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('credit_memo_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->credit_memo_id), array('view', 'id'=>$data->credit_memo_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_info_id')); ?>:</b>
	<?php echo CHtml::encode($data->order_info_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_refunded')); ?>:</b>
	<?php echo CHtml::encode($data->qty_refunded); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_to_refund')); ?>:</b>
	<?php echo CHtml::encode($data->amount_to_refund); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_number')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('memo_status')); ?>:</b>
	<?php echo CHtml::encode($data->memo_status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />

	*/ ?>

</div>