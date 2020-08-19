<?php
$this->pageTitle = "View Voucher";
$id = $voucher_reference->id;
?>
<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('voucherReference/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Create', array('voucherReference/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Update', array('voucherReference/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$voucher_reference,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        'reference',
        'reference_value',
        'type',
        'value',
        'description',
    ),
)); ?>
