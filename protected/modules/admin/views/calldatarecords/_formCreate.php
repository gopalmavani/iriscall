<?php
/* @var $this CalldatarecorrdsController */
/* @var $model CdrCostRulesInfo */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('calldatarecords/cdrcostrules'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'cdr-cost-rules-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'name' => 'cdr-cost-rules-form',
                    )
                )); ?>

				<div class="col-md-6">
					<div class="col-md-12">
						<div class="form-group <?php echo $model->hasErrors('start_with') ? 'has-error' : ''; ?>">
							<?php echo $form->textFieldControlGroup($model, 'start_with', array('size' => 50, 'maxlength' => 30, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter start with')); ?>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group <?php echo $model->hasErrors('digit') ? 'has-error' : ''; ?>">
							<?php echo $form->textFieldControlGroup($model, 'digit', array('autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter digit')); ?>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group <?php echo $model->hasErrors('cost') ? 'has-error' : ''; ?>">
							<?php echo $form->textFieldControlGroup($model, 'cost', array('autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter cost')); ?>
						</div>
					</div>
				</div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group" align="right">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                    'class' => 'btn btn-primary col-md-offset-2',
                    'id' => 'create_cdr_cost_rules'
                )); ?>
                <?php echo CHtml::link('Cancel', array('calldatarecords/cdrcostrules'),
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
$(document).ready(function () {
    $("form[id='cdr-cost-rules-form']").validate({
        debug: true,
        errorClass: "help-block",
        errorElement: "span",
        rules: {
            'CdrCostRulesInfo[start_with]': {
                required: true
            },
            'CdrCostRulesInfo[digit]': {
                required: true
            },
            'CdrCostRulesInfo[cost]': {
                required: true
            },
            'CdrCostRulesInfo[country]': {
                required: true
            }
        },
        messages: {
            'CdrCostRulesInfo[start_with]': {
                required: "Please enter the start with."
            },
            'CdrCostRulesInfo[digit]': {
                required: "Please enter the digit."
            },
            'CdrCostRulesInfo[cost]': {
                required: "Please enter the cost."
            },
            'CdrCostRulesInfo[country]': {
                required: "Please select the country."
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