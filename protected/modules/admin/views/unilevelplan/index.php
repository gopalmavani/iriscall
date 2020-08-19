<?php
/* @var $this CompensationsController */
/* @var $dataProvider CActiveDataProvider */


$this->menu=array(
	array('label'=>'Create Uni level plan', 'url'=>array('create')),
	array('label'=>'Manage Uni level plan', 'url'=>array('admin')),
);
?>


<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
