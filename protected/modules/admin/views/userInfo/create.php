<?php
/* @var $this UserInfoController */
/* @var $model UserInfo */

$this->pageTitle = 'Create User';

?>

<!--<h1>Create --><!--</h1>-->

<?php $this->renderPartial('_form', array('model'=>$model,'payout' => $payout)); ?>