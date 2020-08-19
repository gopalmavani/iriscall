<?php
    /* @var $this OrderInfoController */
    /* @var $model OrderInfo */

$this->pageTitle = 'Create CreditMemo';

?>

<?php $this->renderPartial('_creditMemo', array('order'=>$order, 'orderItem' => $orderItem, 'creditMemo' => $creditMemo, 'error' => $error)); ?>