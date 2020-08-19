<?php
$this->pageTitle = "View Voucher";
$id = $voucher_model->id;
?>
<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('voucher/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Create', array('voucher/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Update', array('voucher/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$voucher_model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        'voucher_name',
        [
            'name' => 'reference_id',
            'value' => function($model) {
            return VoucherReference::model()->findByPk($model->reference_id)->reference;
            }
        ],
        'voucher_code',
        'start_time',
        'end_time',
        [
            'name' => 'voucher_status',
            'value' => function($model) {
                $fieldId = CylFields::model()->findByAttributes(['field_name' => 'voucher_status']);
                $fieldValue = CylFieldValues::model()->findByAttributes(['field_id' => $fieldId->field_id, 'predefined_value' => $model->voucher_status]) ;
                return $fieldValue->field_label;
            }
        ],
        'type',
        'value',
        'redeemed_at',
        'user_name',
        'email',
        'order_info_id'
    ),
)); ?>
