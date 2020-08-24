<?php
/* @var $this ProductInfoController */
/* @var $model ProductInfo */

$this->pageTitle = 'View Company';
$id = $model->id;
?>

<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('calldatarecords/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        'organisation_id',
        'name',
        'shortened_name',
        'language',
        'sip_domain',
        'domain_name',
        'call_pickup_within_group',
        'trunk_clutch',
        'trunk_username',
        'to_number',
        'pbx',
        'created_at',
    ),
)); ?>
