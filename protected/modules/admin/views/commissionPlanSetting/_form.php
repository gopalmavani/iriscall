<?php
/* @var $this CommissionPlanSettingController */
/* @var $model CommissionPlanSettings */
/* @var $form CActiveForm */
?>
<style>
    .ui-slider-range {
        background:green;
    }
    .percent {
        color:green;
        font-weight:bold;
        text-align:center;
        width:100%;
        border:none;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('commissionPlanSetting/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'commissionPlanSettings-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'commissionPlanSettings-form',
                    )
                )); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('commission_plan_id') ? 'has-error' : ''; ?>">
								<?php $commissionPlan = CHtml::listData(CommissionPlan::model()->findAll(['order' => 'name']), 'id','name');
								echo $form->dropDownListControlGroup($model, 'commission_plan_id', $commissionPlan, ['prompt' => 'Select Commission Plan','class' => 'form-control']); ?>
							</div>
						</div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="<?php echo $model->hasErrors('user_level') ? 'has-error' : ''; ?>">
                                    <?php echo $form->dropDownListControlGroup($model,'user_level', array('0'=>'User', '1'=>'Level 1', '2'=>'Level 2', '3'=>'Level 3', '4'=>'Level 4', '5'=>'Level 5'), array('prompt' => 'Select Level', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('rank_id') ? 'has-error' : ''; ?>">
								<?php $rank = CHtml::listData(Rank::model()->findAll(['order' => 'name']), 'id','name');
								echo $form->dropDownListControlGroup($model, 'rank_id', $rank, ['prompt' => 'Select Rank','class' => 'form-control']); ?>
							</div>
						</div>
                        <div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('category_id') ? 'has-error' : ''; ?>">
								<?php $categoryList = CHtml::listData(Categories::model()->findAll(['order' => 'category_name']), 'category_id', 'category_name');
								echo $form->dropDownListControlGroup($model, 'category_id', $categoryList, ['prompt' => 'Select Category','class' => 'form-control']); ?>
							</div>
						</div>
                        <div class="col-md-12" style="margin-top: 3%;">
                            <div class="form-group">
                                <lable style="font-weight: 600; font-size: 13px;">Select Product *</lable>
                                <select class="js-select2 form-control" name="product_id" id="product_id">
                                    <!-- <option value="">Select Product</option> -->
                                <?php $productInfo = ProductInfo::model()->findAll(['order' => 'name']);
                                    foreach ($productInfo as $product) { ?>
                                        <option value="<?= $product['product_id']; ?>"><?= 'Name: '.$product['name']; ?>
                                        <?= ', Price: '.$product['price']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>    
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Wallet Status</label>
                                <div class="row">
                                    <div class="radio-inline">
                                        <label class="radio radio-success radio-inline">
                                            <input value="1" type="radio"  <?php if ($model->wallet_status == 1) { echo "checked";} ?>  class="check details" name="wallet_status">
                                            <span></span>Confirmed
                                        </label>
                                        <label class="radio radio-success radio-inline pl-5">
                                            <input value="0" type="radio"  <?php if ($model->wallet_status == 0) { echo "checked";} ?> class="check details" name="wallet_status">
                                            <span></span>Pending
                                        </label>
                                    </div>
                                </div>
                            </div>
						</div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Amount Type</label>
                                <div class="row">
                                    <div class="radio-inline">
                                        <label class="radio radio-success radio-inline">
                                            <input value="1" type="radio"  <?php if ($model->amount_type == 1) { echo "checked";} ?>  class="check details" name="amount_type">
                                            <span></span>Percentage
                                        </label>
                                        <label class="radio radio-success radio-inline pl-5">
                                            <input value="0" type="radio"  <?php if ($model->amount_type == 0) { echo "checked";} ?> class="check details" name="amount_type">
                                            <span></span>Fixed
                                        </label>
                                    </div>
                                </div>
                            </div>
						</div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="<?php echo $model->hasErrors('amount') ? 'has-error' : ''; ?>">
                                    <?php echo $form->textFieldControlGroup($model, 'amount', array('autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Amount')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('wallet_type_id') ? 'has-error' : ''; ?>">
								<?php
                                    $typeList = CHtml::listData(WalletTypeEntity::model()->findAll(['order' => 'wallet_type']), 'wallet_type_id','wallet_type');
                                    echo $form->dropDownListControlGroup($model, 'wallet_type_id', $typeList, ['prompt' => 'Select Wallet Type', 'class' => 'form-control']); 
                                ?>
							</div>
						</div>
                        <div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('denomination_id') ? 'has-error' : ''; ?>">
								<?php
                                    $list = CHtml::listData(Denomination::model()->findAll(["order" => "denomination_id"]),"denomination_id",
									function ($data){
										$fieldId = CylFields::model()->findByAttributes(["field_name" => "denomination_type"]);
										$fieldLabel = CylFieldValues::model()->findByAttributes(["field_id" => $fieldId->field_id,"predefined_value" => $data->denomination_id]);
										return "{$fieldLabel->field_label}  {$data->currency}";
									});
								    echo $form->dropDownListControlGroup($model, "denomination_id", $list, ["prompt" => "Select Denomination","class" => "form-control"]);
								?>
							</div>
						</div>
                        <div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('wallet_reference_id') ? 'has-error' : ''; ?>">
								<?php
                                    $metaList = CHtml::listData(WalletMetaEntity::model()->findAll(['order' => 'reference_key']), 'reference_id','reference_key');
                                    echo $form->dropDownListControlGroup($model, 'wallet_reference_id', $metaList, ['prompt' => 'Select Reference','class' => 'form-control']);
                                ?>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group" align="right">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                    'class' => 'btn btn-primary col-md-offset-2',
                    'id' => 'create_roles'
                )); ?>
                <?php echo CHtml::link('Cancel', array('commissionPlanSetting/admin'),
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

<script type="text/javascript">
$(document).ready(function() {
    $("form[id='commissionPlanSettings-form']").validate({
        debug: true,
        errorClass: "help-block",
        errorElement: "span",
        rules: {
            'CommissionPlanSettings[commission_plan_id]': {
                required: true
            },
            'CommissionPlanSettings[user_level]': {
                required: true
            },
            'CommissionPlanSettings[rank_id]': {
                required: true
            },
            product_id: {
                required: true
            },
            'CommissionPlanSettings[category_id]': {
                required: true
            },
            'CommissionPlanSettings[amount]': {
                required: true
            },
            'CommissionPlanSettings[wallet_type_id]': {
                required: true
            },
            'CommissionPlanSettings[wallet_reference_id]': {
                required: true
            },
            'CommissionPlanSettings[denomination_id]': {
                required: true
            }
        },
        messages: {
            'CommissionPlanSettings[commission_plan_id]': {
                required: "Please select commission plan."
            },
            'CommissionPlanSettings[user_level]': {
                required: "Please select user level."
            },  
            'CommissionPlanSettings[rank_id]': {
                required: "Please select rank."
            },
            product_id: {
                required: "Please select product."
            },
            'CommissionPlanSettings[category_id]': {
                required: "Please select category."
            },
            'CommissionPlanSettings[amount]': {
                required: "Please enter amount."
            },
            'CommissionPlanSettings[wallet_type_id]': {
                required: "Please select wallet type."
            },
            'CommissionPlanSettings[wallet_reference_id]': {
                required: "Please select wallet reference."
            },
            'CommissionPlanSettings[denomination_id]': {
                required: "Please select denomination."
            }
        },
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            $(element).parent().parent().addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).parent().parent().removeClass('has-error');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>