<?php
/* @var $this CompensationsPlanController */
/* @var $dataProvider CActiveDataProvider */
?>

<h1>Compensations Plans</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
