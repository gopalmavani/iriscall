<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
?>

<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<h1 class="font-s128 font-w300 text-flat text-center animated bounceIn"><?php echo $code; ?></h1>
		<h2 class="h3 font-w300 push-50 animated fadeInUp"><?php echo CHtml::encode($message); ?></h2>
	</div>
</div>
<div class="row">
	<div class="col-sm-6 col-sm-offset-3 text-center">
		<button onclick="history.back(1);" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Go Back</button>
	</div>
</div>
<div class="row">
	<p>&nbsp;</p>
</div>