<?php
/* @var $this CalldatarecorrdsController */
/* @var $model CdrCostRulesInfo */

$this->pageTitle = 'View CDR Cost Rule';
$id = $model->id;
?>
<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('calldatarecords/cdrcostrules'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Create', array('calldatarecords/createcdrcostrules'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Update', array('calldatarecords/updatecdrcostrules/'.$id), array('class' => 'btn btn-minw btn-square btn-primary'));?>
</div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions' => array('class' => 'table'),
	'attributes'=>array(
		'id',
		'start_with',
		'digit',
		'cost',
		'from_number_start_with',
		'from_number_digit',
		[
			'name' => 'country',
			'value' => function($model){
				$codesql = "select country_name from countries where id = "."'$model->country'";
					$country = Yii::app()->db->createCommand($codesql)->queryAll();
					if(!empty($country)){
						return $country[0]['country_name'];
					}
					else{
						return $model->country;
					}
			}
		],
		'comment',
		'created_at',
		'modified_at'
	),
)); ?>
