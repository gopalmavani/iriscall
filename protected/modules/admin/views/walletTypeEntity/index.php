<?php
/* @var $this WalletTypeEntityController */
/* @var $dataProvider CActiveDataProvider */


$this->menu=array(
	array('label'=>'Create WalletTypeEntity', 'url'=>array('create')),
	array('label'=>'Manage WalletTypeEntity', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
