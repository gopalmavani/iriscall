<?php
/* @var $this CommissionPlanSettingController */
/* @var $model CommissionPlanSettings */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('commission_plan_id')); ?>:</b>
	<?php echo CHtml::encode($data->commission_plan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_level')); ?>:</b>
	<?php echo CHtml::encode($data->user_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rank_id')); ?>:</b>
	<?php echo CHtml::encode($data->rank_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_type')); ?>:</b>
	<?php echo CHtml::encode($data->amount_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wallet_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->wallet_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wallet_reference_id')); ?>:</b>
	<?php echo CHtml::encode($data->wallet_reference_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('denomination_id')); ?>:</b>
	<?php echo CHtml::encode($data->denomination_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wallet_status')); ?>:</b>
	<?php echo CHtml::encode($data->wallet_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->createdDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->ModifiedDate); ?>
	<br />

</div>