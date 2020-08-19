<?php
/* @var $this WalletTypeEntityController */
/* @var $data WalletTypeEntity */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('wallet_type_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->wallet_type_id), array('view', 'id'=>$data->wallet_type_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wallet_type')); ?>:</b>
	<?php echo CHtml::encode($data->wallet_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />


</div>