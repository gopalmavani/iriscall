<?php
/* @var $this WalletMetaEntityController */
/* @var $model WalletMetaEntity */

$this->pageTitle = 'View WalletMeta';
$id = $model->reference_id; 
?>
<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('WalletTypeEntity/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?> 
	<?php echo CHtml::link('Create', array('walletMetaEntity/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?> 
	<?php echo CHtml::link('Update', array('walletMetaEntity/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary')); ?></div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions' => array('class' => 'table'),
	'attributes'=>array(
		'reference_id',
		'reference_key',
		'reference_desc',
		'reference_data',
		'created_at',
		'modified_at',
	),
)); ?>
