<?php
/* @var $this OrderCreditMemoController */
/* @var $dataProvider CActiveDataProvider */



$this->menu=array(
	array('label'=>'Create OrderCreditMemo', 'url'=>array('create')),
	array('label'=>'Manage OrderCreditMemo', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
