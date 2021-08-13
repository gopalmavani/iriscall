<?php
/* @var $this CommissionPlanSettingsController */
/* @var $model CommissionPlanSettings */
$this->pageTitle = 'View Commission Plan Settings';
$id = $model->id;
?>
<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('commissionPlan/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Create', array('commissionPlan/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Update', array('commissionPlan/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary'));?>
</div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions' => array('class' => 'table'),
	'attributes'=>array(
		'id',
		'name',
		'table_name',
		'action_name',
		'icon',
		'created_at',
		'modified_at',
	),
)); ?>
