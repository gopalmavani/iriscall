<?php
/* @var $this OrderInfoController */
/* @var $model OrderInfo */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'order-info-credit-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                )); ?>

                <input style="display: none;" name="order_info_id" value="<?= $order->order_info_id; ?>">
                <input style="display: none;" name="invoice_number" value="<?= $order->invoice_number; ?>">
                <div class="form-material has-error">
                    <p id="memoError" class="help-block has-error" style="display: none;"></p>
                </div>
                <?php if($error != ''){ ?>
                    <div class="form-material has-error">
                        <span id="customError" class="help-block has-error"><?= $error; ?></span>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php if($orderItem != NULL){ ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Qty</th>
                                    <th>Refund Quantity</th>
                                    <th class="text-center">Amount</th>
                                    <th>Refund Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($orderItem as $key => $item) { ?>
                                <tr>
                                    <td class="col-md-2 text-center">
                                        <?php echo $item->product_name ?>
                                        <input style="display: none" name="OrderCreditMemo[order_line_item_id][]" id="productId<?= '_'.$key; ?>" value="<?php echo $item['order_line_item_id']; ?>"/>
                                    </td>
                                    <td class="col-md-1 text-center" id="itemQty"><?= $item->item_qty;; ?></td>
                                    <td class="col-md-2">
                                        <div class="col-md-12">
                                            <input autofocus="autofocus" class="form-control item_qty" min="1" max="<?= $item->item_qty; ?>" name="OrderCreditMemo[qty_refund][]" id="item_qty<?= '_'.$key; ?>" type="number" value="0" >
                                        </div>
                                    </td>
                                    <td class="col-md-1 text-center" id="item_price_<?= $key; ?>">
                                        <?php echo ($item->item_price - $item->item_disc); ?>
                                    </td>
                                    <td class="col-md-1 text-center item_refund" id="item_refund_amt_<?= $key; ?>">
                                        0
                                    </td>
                                    <!--<td class="col-md-2 col-md-12">
                                        <div class="form-group">
                                            <?php
/*                                            $fieldId = CylFields::model()->findByAttributes(['field_name' => 'memo_status']);
                                            $statusList = CHtml::listData(CylFieldValues::model()->findAllByAttributes(['field_id' => $fieldId->field_id]), 'predefined_value', 'field_label');
                                            echo $form->dropDownList($creditMemo , 'memo_status', $statusList, [
                                                'prompt' => 'Select Status',
                                                'class' => 'form-control',
                                                'disabled' => 'disabled',
                                                'options' => array(1 =>array('selected'=>true))
                                            ]);
                                            */?>
                                        </div>
                                    </td>-->
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4" class="text-right">
                                    <h3 class="profile-username">Amount to Refund:</h3>
                                </td>
                                <td><input name="refund_amount" class="form-control" type="text" value="0" id="final_refund">+ VAT</td>
                            </tr>
                            </tbody>
                        </table>
                        <?php } else { ?>
                            <span>No Product Found</span>
                        <?php } ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group pull-right">
                            <?php echo CHtml::submitButton($creditMemo->isNewRecord ? 'Generate Memo' : 'Save', array(
                                'class' => 'btn btn-primary',
                            )); ?>
                            <?php echo CHtml::link('Cancel', array('orderInfo/admin'),
                                array(
                                    'class' => 'btn btn-default'
                                )
                            );
                            ?>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    //Update refund amount on change in quantity
    $('.item_qty').on('keyup change', function (e) {
        var id_text = $(this).attr('id');
        var id_array = id_text.split('_');
        var id = id_array['2'];
        var item_qty = parseInt($(this).val());
        var item_amt = $('#item_price_'+id).html();
        var item_refund_amt = item_qty * item_amt;
        if(item_refund_amt)
            $('#item_refund_amt_'+id).html(item_refund_amt);
        else
            $('#item_refund_amt_'+id).html(0);

        //Update total refund amount
        var total_refund = 0;
        $('.item_refund').each(function () {
            total_refund += parseFloat($(this).html());
        });
        $('#final_refund').val(total_refund);
    });
</script>
