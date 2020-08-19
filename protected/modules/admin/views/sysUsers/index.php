<?php
/* @var $this SysUsersController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'Create SysUsers', 'url'=>array('create')),
	array('label'=>'Manage SysUsers', 'url'=>array('admin')),
);
?>

<h1>Sys Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
