<?php
/* @var $this RolesController */
/* @var $model Roles */
$this->pageTitle = "Role : ".$model->role_title;
$id = $model->role_id;
?>

<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('Roles/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Create', array('Roles/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Update', array('Roles/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary'));?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
	'attributes'=>array(
		'role_id',
		'role_title',
		'created_at',
		'modified_at',
	),
)); ?>
