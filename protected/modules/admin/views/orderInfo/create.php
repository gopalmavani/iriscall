<?php
/* @var $this OrderInfoController */
/* @var $model OrderInfo */

$this->pageTitle = 'Create Order';

?>
<?php $this->renderPartial('_form', array('model'=>$model,'orderItem'=>$orderItem,'orderPayment' => $orderPayment,'productSubscription' => $productSubscription)); ?>