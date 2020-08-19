<?php
/* @var $this RankController */
/* @var $model Rank */

$this->pageTitle = 'View Ranks';
$id = $model->rankId;
?>
<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('rank/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Create', array('rank/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Update', array('rank/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary'));?>
</div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions' => array('class' => 'table'),
	'attributes'=>array(
		'rankId',
		'rankName',
		'rankIcon',
		'descriptions',
		'userPaidOut',
		'rankAbbreviation',
		'level',
		'created_at',
		'modified_at',
	),
)); ?>
