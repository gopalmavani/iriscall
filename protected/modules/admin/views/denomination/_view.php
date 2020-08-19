<?php
/* @var $this DenominationController */
/* @var $data Denomination */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('denomination_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->denomination_id), array('view', 'id'=>$data->denomination_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('denomination_type')); ?>:</b>
	<?php echo CHtml::encode($data->denomination_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_type')); ?>:</b>
	<?php echo CHtml::encode($data->sub_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('label')); ?>:</b>
	<?php echo CHtml::encode($data->label); ?>
	<br />


</div>