<?php
/* @var $this ProductInfoController */
/* @var $model ProductInfo */

$this->pageTitle = 'View CDR';
$id = $model->id;
?>

<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('calldatarecords/cdrinfo'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        'callid',
        'organisation_id',
        'start_time',
        'answer_time',
        'end_time',
        'timezone',
        'from_type',
        'from_id',
        'from_number',
        'from_name',
        'to_number',
        'end_reason',
        'unit_cost',
        'date',
        'created_at',
    ),
)); ?>
