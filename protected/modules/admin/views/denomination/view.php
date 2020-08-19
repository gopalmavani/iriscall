<?php
/* @var $this CompensationsController */
/* @var $model Compensations */

$this->pageTitle = 'View Pool Plan';
$id = $model->denomination_id;
?>
    <div class="pull-right m-b-10">
        <?php echo CHtml::link('Go to list', array('WalletTypeEntity/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        <?php echo CHtml::link('Create', array('denomination/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        <?php echo CHtml::link('Update', array('denomination/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary'));?>
    </div>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        'denomination_id',
        'denomination_type',
        'sub_type',
        'label',
        'created_at',
        'modified_at',

    ),
)); ?>