<?php
/* @var $this WalletTypeEntityController */
/* @var $model WalletTypeEntity */

$this->pageTitle = 'View WalletType';
$id = $model->wallet_type_id; 
?>
<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('walletTypeEntity/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?> 
	<?php echo CHtml::link('Create', array('walletTypeEntity/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?> 
	<?php echo CHtml::link('Update', array('walletTypeEntity/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary')); ?></div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions' => array('class' => 'table'),
	'attributes'=>array(
		'wallet_type_id',
		'wallet_type',
		'created_at',
		'modified_at',
	),
)); ?>
