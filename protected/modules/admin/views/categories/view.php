<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$id = $model->category_id; 
?>

<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('categories/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?> 
	<?php echo CHtml::link('Create', array('categories/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?> 
	<?php echo CHtml::link('Update', array('categories/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary')); ?></div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions' => array('class' => 'table'),
	'attributes'=>array(
		'category_id',
		'category_name',
		'description',
		'is_active',
		'created_at',
		'modified_at',
		'is_delete',
	),
)); ?>
