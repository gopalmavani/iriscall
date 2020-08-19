<?php
/* @var $this RankController */
/* @var $data Rank */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('rankId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->rankId), array('view', 'id'=>$data->rankId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rankName')); ?>:</b>
	<?php echo CHtml::encode($data->rankName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rankIcon')); ?>:</b>
	<?php echo CHtml::encode($data->rankIcon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descriptions')); ?>:</b>
	<?php echo CHtml::encode($data->descriptions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userPaidOut')); ?>:</b>
	<?php echo CHtml::encode($data->userPaidOut); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->createdDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->ModifiedDate); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('rankAbbreviation')); ?>:</b>
	<?php echo CHtml::encode($data->rankAbbreviation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('level')); ?>:</b>
	<?php echo CHtml::encode($data->level); ?>
	<br />

	*/ ?>

</div>