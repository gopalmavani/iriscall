<?php
/* @var $this PoolPlanController */
/* @var $data PoolPlan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pool_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pool_id), array('view', 'id'=>$data->pool_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pool_name')); ?>:</b>
	<?php echo CHtml::encode($data->pool_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pool_description')); ?>:</b>
	<?php echo CHtml::encode($data->pool_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pool_amount')); ?>:</b>
	<?php echo CHtml::encode($data->pool_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pool_denomination')); ?>:</b>
	<?php echo CHtml::encode($data->pool_denomination); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />


</div>