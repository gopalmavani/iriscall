<?php
/* @var $this NotificationManagerController */
/* @var $dataProvider CActiveDataProvider */



$this->menu=array(
	array('label'=>'Create NotificationManager', 'url'=>array('create')),
	array('label'=>'Manage NotificationManager', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
