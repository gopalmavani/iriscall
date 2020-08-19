<?php
/* @var $this UserInfoController */
/* @var $dataProvider CActiveDataProvider */


$this->menu=array(
	array('label'=>'Create UserInfo', 'url'=>array('create')),
	array('label'=>'Manage UserInfo', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
