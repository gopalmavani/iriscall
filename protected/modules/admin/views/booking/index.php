<?php
/* @var $this BookingController */
/* @var $dataProvider CActiveDataProvider */

?>

<h1>Bookings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
