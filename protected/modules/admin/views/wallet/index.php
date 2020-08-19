<?php
/* @var $this WalletController */
/* @var $dataProvider CActiveDataProvider */


$this->menu=array(
	array('label'=>'Create Wallet', 'url'=>array('create')),
	array('label'=>'Manage Wallet', 'url'=>array('admin')),
);
?>


<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
