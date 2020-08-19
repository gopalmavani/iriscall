<?php
/* @var $this ProductInfoController */
/* @var $model ProductInfo */

$this->pageTitle = 'Update Product';?>
<?php $this->renderPartial('_updateForm', array('model'=>$model,'categories'=>$categories,'productCategory' => $productCategory, 'productAffiliate' => $productAffiliate,'productLicense' => $productLicense)); ?>