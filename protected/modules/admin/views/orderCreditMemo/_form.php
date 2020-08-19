<?php
/* @var $this OrderCreditMemoController */
/* @var $model OrderCreditMemo */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'order-credit-memo-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                )); ?>

                <?php echo $form->errorSummary($model); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php
                                    $productList = CHtml::listData(ProductInfo::model()->findAll(['order' => 'name']), 'product_id', 'name');
                                    echo $form->dropDownListControlGroup($model, 'product_id', $productList, [
                                        'prompt' => 'Select Product',
                                        'class' => 'form-control',
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('invoice_number') ? 'has-error' : ''; ?>">
                                    <?php echo $form->textFieldControlGroup($model, 'invoice_number', array('autofocus' => 'on', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('payment_status') ? 'has-error' : ''; ?>">
                                    <?php
                                    $fieldId = CylFields::model()->findByAttributes(['field_name' => 'order_status']);
                                    $statusList = CHtml::listData(CylFieldValues::model()->findAllByAttributes(['field_id' => $fieldId->field_id]), 'predefined_value', 'field_label');
                                    echo $form->dropDownListControlGroup($model, 'memo_status', $statusList, [
                                        'prompt' => 'Select Status',
                                        'class' => 'form-control',
                                        'disabled' => 'disabled',
                                        'options' => array(1 =>array('selected'=>true))
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('qty_refunded') ? 'has-error' : ''; ?>">
                                    <?php echo $form->textFieldControlGroup($model, 'qty_refunded', array('autofocus' => 'on', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('amount_to_refund') ? 'has-error' : ''; ?>">
                                    <?php echo $form->textFieldControlGroup($model, 'amount_to_refund', array('autofocus' => 'on','disabled' => 'disabled',  'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-md-12" align="right">
                    <div class="form-group">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                            'class' => 'btn btn-primary',
                        )); ?>
                        <?php echo CHtml::link('Cancel', array('orderCreditMemo/admin'),
                            array(
                                'class' => 'btn btn-default'
                            )
                        );
                        ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('keyup','#OrderCreditMemo_qty_refunded',function () {
        this.value = this.value.replace(/[^0-9]/g, '');
        if(this.value != ''){
            var productItem = $('#OrderCreditMemo_product_id').val();
            var productQty = $('#OrderCreditMemo_qty_refunded').val();
            var data = {qty : productQty,productId : productItem};
            $.ajax({
                type : "POST",
                url : '<?php echo Yii::app()->getUrlManager()->createUrl('admin/OrderInfo/loadprice'); ?>',
                data : data,
                success : function(result){
                    var productData = JSON.parse(result);
                    if(productData.result == true){
                        $('#OrderCreditMemo_amount_to_refund').val(productData.productPrice);
                    }
                }
            });
        }
    });
</script>