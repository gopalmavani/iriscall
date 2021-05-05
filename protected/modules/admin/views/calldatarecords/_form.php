<?php
/* @var $this CalldatarecorrdsController */
/* @var $model OrganizationInfo */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('calldatarecords/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'organization-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'name' => 'organization-form',
                    )
                )); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('organisation_id') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'organisation_id', array('autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter organization id')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('name') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter organization name')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('shortened_name') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'shortened_name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter shortened name')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="<?php echo $model->hasErrors('language') ? 'has-error' : ''; ?>">
                                    <?php echo $form->dropDownListControlGroup($model,'language', array('English'=>'English', 'Dutch'=>'Dutch', 'French'=>'French'), array('prompt' => 'Select Language', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('sip_domain') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'sip_domain', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter SIP domain')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('domain_name') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'domain_name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter domain name')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('call_pickup_within_group') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'call_pickup_within_group', array('autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter call pickup within group')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('trunk_clutch') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'trunk_clutch', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter trunk clutch')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('trunk_username') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'trunk_username', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter trunk name')); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group <?php echo $model->hasErrors('pbx') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'pbx', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Enter pbx')); ?>
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
                )); ?>
                <?php echo CHtml::link('Cancel', array('calldatarecords/admin'),
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
    $("form[id='organization-form']").validate({
        debug: true,
        errorClass: "help-block",
        errorElement: "span",
        rules: {
            'OrganizationInfo[organisation_id]': {
                required: true,
                digits: true
            },
            'OrganizationInfo[name]': {
                required: true
            },
            'OrganizationInfo[shortened_name]': {
                required: true
            },
            'OrganizationInfo[language]': {
                required: true
            },
            'OrganizationInfo[sip_domain]': {
                required: true
            },
            // 'OrganizationInfo[domain_name]': {
            //     required: true
            // },
            'OrganizationInfo[call_pickup_within_group]': {
                required: true,
                digits: true
            },
            'OrganizationInfo[trunk_clutch]': {
                required: true
            },
            'OrganizationInfo[trunk_username]': {
                required: true
            },
            'OrganizationInfo[pbx]': {
                required: true
            }
        },
        messages: {
            'OrganizationInfo[organisation_id]': {
                required: "Please enter organisation id.",
                digits: "Please enter number only."
            },
            'OrganizationInfo[name]': {
                required: "Please enter the name."
            },
            'OrganizationInfo[shortened_name]': {
                required: "Please enter shortened name."
            },
            'OrganizationInfo[language]': {
                required: "Please select the language."
            },
            'OrganizationInfo[sip_domain]': {
                required: "Please enter sip domain."
            },
            // 'OrganizationInfo[domain_name]': {
            //     required: "Please enter domain name."
            // },
            'OrganizationInfo[call_pickup_within_group]': {
                required: "Please enter call pickup within group.",
                digits: "Please enter number only."
            },
            'OrganizationInfo[trunk_clutch]': {
                required: "Please enter trunk clutch."
            },
            'OrganizationInfo[trunk_username]': {
                required: "Please enter the trunk name."
            },
            'OrganizationInfo[pbx]': {
                required: "Please enter pbx."
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