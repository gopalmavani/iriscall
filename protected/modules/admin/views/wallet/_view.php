<?php
/* @var $this WalletController */
/* @var $data Wallet */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('wallet_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->wallet_id), array('view', 'id'=>$data->wallet_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wallet_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->wallet_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_type')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference_id')); ?>:</b>
	<?php echo CHtml::encode($data->reference_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference_num')); ?>:</b>
	<?php echo CHtml::encode($data->reference_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_comment')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_comment); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('denomination_id')); ?>:</b>
	<?php echo CHtml::encode($data->denomination_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_status')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('portal_id')); ?>:</b>
	<?php echo CHtml::encode($data->portal_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_balance')); ?>:</b>
	<?php echo CHtml::encode($data->updated_balance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />

	*/ ?>

</div>