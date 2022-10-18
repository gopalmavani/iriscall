<?php
$this->pageTitle = 'View Company Group';
$id = $model->id;
?>
<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('companyGroup/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Create', array('companyGroup/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Update', array('companyGroup/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary'));?>
</div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions' => array('class' => 'table'),
	'attributes'=>array(
		'id',
		'company_id',
		'group_name',
		'external_number',
		'group_id_mytelephony',
		'comment',
		'created_at',
		'updated_at'
	),
)); ?>
