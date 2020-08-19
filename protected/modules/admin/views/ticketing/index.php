<?php
/* @var $this TicketingController */
/* @var $dataProvider CActiveDataProvider */

?>

<h1>Ticketings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
