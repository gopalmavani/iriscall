<?php
/* @var $this OrderInfoController */
/* @var $model OrderInfo */

$this->pageTitle = 'Update Order';

?>
<?php $this->renderPartial('_updateForm', array('model'=>$model, 'orderItem' => $orderItem,'orderPayment' => $orderPayment, 'productName'=>$productName,)); ?>