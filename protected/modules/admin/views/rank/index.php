<?php
/* @var $this RankController */
/* @var $dataProvider CActiveDataProvider */
?>

<h1>Ranks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
