<?php
/* @var $this CompensationsController */
/* @var $model Compensations */

$this->pageTitle = 'View Uni Level Plan';
$id = $model->id;
?>
<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('unilevelplan/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Create', array('unilevelplan/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Update', array('unilevelplan/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary'));?>
</div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions' => array('class' => 'table'),
	'attributes'=>array(
		'level',
		'rank',
		'amount',
		[
			'name' => 'denomination',
			'value' => function($model){
				$denomination_name=Denomination::model()->findByAttributes(['denomination_id' => $model->denomination]);
				return $denomination_name->denomination_type;
			}
		],
		'created_at',
		'modified_at',
	),
)); ?> 
 