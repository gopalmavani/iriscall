<?php
/* @var $this WalletMetaEntityController */
/* @var $data WalletMetaEntity */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->reference_id), array('view', 'id'=>$data->reference_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference_key')); ?>:</b>
	<?php echo CHtml::encode($data->reference_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference_desc')); ?>:</b>
	<?php echo CHtml::encode($data->reference_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference_data')); ?>:</b>
	<?php echo CHtml::encode($data->reference_data); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />


</div>