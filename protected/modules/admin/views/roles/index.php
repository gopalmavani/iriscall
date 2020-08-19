<?php
/* @var $this RolesController */
/* @var $dataProvider CActiveDataProvider */

?>

<h1>Roles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
