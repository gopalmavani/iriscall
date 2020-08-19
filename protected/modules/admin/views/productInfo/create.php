<?php
/* @var $this ProductInfoController */
/* @var $model ProductInfo */

$this->pageTitle = 'Create Product';

?>

<?php $this->renderPartial('_form', array('model'=>$model,'categories'=>$categories,'productCategory' => $productCategory,'productAffiliate' => $productAffiliate,'productLicense' => $productLicense,)); ?>