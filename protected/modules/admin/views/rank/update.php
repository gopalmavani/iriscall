<?php
/* @var $this RankController */
/* @var $model Rank */
$this->pageTitle = 'Update Ranks';
?>

<?php $this->renderPartial('_form', array('model'=>$model,'rulesModel'=>$rulesModel,'rankRules'=>$rankRules,'rankRules1'=>$rankRules1)); ?>