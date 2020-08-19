<?php
/* @var $this SysUsersController */
/* @var $model SysUsers */

$this->pageTitle = 'View System User';

$id = $model->id;
$admin = Yii::app()->params['mandatoryFields']['admin_id'];
?>

<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('sysUsers/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Create', array('sysUsers/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php if ($id != $admin){ echo CHtml::link('Update', array('sysUsers/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary')); }?>
    <?php echo CHtml::link('Change Password', array('sysUsers/changePassword/'.$id), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
		'id',
		'username',
		'password',
		'email',
		'activekey',
		'auth_level',
		'status',
		'created_at',
		'lastvisit_at',
	),
)); ?>
