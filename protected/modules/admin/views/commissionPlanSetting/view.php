<?php
/* @var $this CommissionPlanSettingController */
/* @var $model CommissionPlanSettings */
$this->pageTitle = 'View Commission Plan Setting';
$id = $model->id;
?>
<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('commissionPlanSetting/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Create', array('commissionPlanSetting/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Update', array('commissionPlanSetting/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary'));?>
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
