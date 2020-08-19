<?php
/* @var $this PoolPlanController */
/* @var $dataProvider CActiveDataProvider */


$this->menu=array(
	array('label'=>'Create PoolPlan', 'url'=>array('create')),
	array('label'=>'Manage PoolPlan', 'url'=>array('admin')),
);
?>


<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
