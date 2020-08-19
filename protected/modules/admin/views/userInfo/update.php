<?php
/* @var $this UserInfoController */
/* @var $model UserInfo */

$this->pageTitle = 'Update User';

?>
<?php $this->renderPartial('_updateForm', array('model'=>$model,'payout'=>$payout, 'registrationStatus' => $registrationStatus)); ?>