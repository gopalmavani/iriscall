<?php
/* @var $this CommissionPlanSettingsController */
/* @var $model CommissionPlanSettings */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('commissionPlan/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'commissionPlan-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'commissionPlan-form',
                    )
                )); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('name') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Name')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="<?php echo $model->hasErrors('is_active') ? 'has-error' : ''; ?>">
                                    <?php echo $form->dropDownListControlGroup($model,'is_active', array('1'=>'Active', '0'=>'Inactive'), array('prompt' => 'Select Active', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('icon') ? 'has-error' : ''; ?>">
                                <?php echo $form->fileFieldControlGroup($model, 'icon'); ?>
                                <?php echo !$model->isNewRecord ? '<span>Icon is already uploaded, adding the new image would overwrite the previous one.</span>' : ''?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('table_name') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'table_name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Table Name')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('action_name') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'action_name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Action Name')); ?>
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
                <?php echo CHtml::link('Cancel', array('commissionPlan/admin'),
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
    $("form[id='commissionPlan-form']").validate({
        debug: true,
        errorClass: "help-block",
        errorElement: "span",
        rules: {
            'CommissionPlan[icon]': {
                accept: "image/jpg,image/jpeg,image/png"
            }
        },
        messages: {
            'CommissionPlan[icon]': {
                accept: "Please select image file only."
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