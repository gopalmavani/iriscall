<?php
/* @var $this PoolPlanController */
/* @var $model PoolPlan */

$this->pageTitle = 'View Pool Plan';
$id = $model->id;
?>
<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('poolPlan/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Create', array('poolPlan/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
	<?php echo CHtml::link('Update', array('poolPlan/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary'));?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions' => array('class' => 'table'),
	'attributes'=>array(
		'id',
		'pool_name',
		'pool_description',
		'pool_amount',
		'pool_denomination',
		[
			'name' => 'user_id',
			'value' => function($model){
				$Pool_list = 'No user';
				if ($model->user_id){

					$users = explode(',',$model->user_id);
					foreach ($users as $user => $val){
						$users_list = UserInfo::model()->findByAttributes(['user_id' => $val]);
						$Pool_user[] = $users_list->full_name;
					}
					$Pool_list = implode(',', $Pool_user);
					return $Pool_list;
				}else{
					return $Pool_list;
				}
			}
		],
	),
)); ?> 
