<?php
/* @var $this CompanyGroupController */
/* @var $model CompanyGroupInfo */
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('companyGroup/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'company-group-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'name' => 'company-group-form',
                    )
                )); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('company_id') ? 'has-error' : ''; ?>">
                                <?php
                                $companyList = CHtml::listData(OrganizationInfo::model()->findAll(["order" => "name"]), "id", "name");
                                echo $form->dropDownListControlGroup($model, "company_id", $companyList, [
                                    "prompt" => "Select Company",
                                    "class" => "js-select2 form-control",
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('group_name') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'group_name', array('autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter group name')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('external_number') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'external_number', array('autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter external number')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('group_id_mytelephony') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'group_id_mytelephony', array('autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter group id mytelephony')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('comment') ? 'has-error' : ''; ?>">
                                <?php echo $form->textareaControlGroup($model, 'comment', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Comment here...')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group" align="right">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                    'class' => 'btn btn-primary col-md-offset-2'
                )); ?>
                <?php echo CHtml::link('Cancel', array('companyGroup/index'),
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
    $("form[id='company-group-form']").validate({
        debug: true,
        errorClass: "help-block",
        errorElement: "span",
        rules: {
            'CompanyGroupInfo[company_id]': {
                required: true
            },
            'CompanyGroupInfo[group_name]': {
                required: true
            },
            'CompanyGroupInfo[external_number]': {
                required: true
            },
            'CompanyGroupInfo[group_id_mytelephony]': {
                required: true
            }
        },
        messages: {
            'CompanyGroupInfo[company_id]': {
                required: "Please select company."
            },
            'CompanyGroupInfo[group_name]': {
                required: "Please enter group name."
            },
            'CompanyGroupInfo[external_number]': {
                required: "Please enter external number."
            },
            'CompanyGroupInfo[group_id_mytelephony]': {
                required: "Please enter group id mytelephony."
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