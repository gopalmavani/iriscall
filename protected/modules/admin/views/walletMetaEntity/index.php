<?php
/* @var $this WalletMetaEntityController */
/* @var $dataProvider CActiveDataProvider */


$this->menu=array(
	array('label'=>'Create WalletMetaEntity', 'url'=>array('create')),
	array('label'=>'Manage WalletMetaEntity', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
