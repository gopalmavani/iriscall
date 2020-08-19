<div class="row">
    <div class="col-md-12">
        <div class="pull-right" style="margin: 0 15px 15px 0;">
            <?php echo CHtml::link('Go to list', array('voucherReference/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'voucher-reference-info-form',
            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
            'enableAjaxValidation' => false,
            'htmlOptions' => array(
                'name' => 'VoucherReference'
            )
        ));
        ?>
        <div class="row">
            <h4 style="padding: 15px">Voucher Reference Details</h4>

            <div class="col-md-6 <?php echo $model->hasErrors('reference') ? 'has-error' : ''; ?>">
                <?php echo $form->textFieldControlGroup($model, 'reference', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Reference')); ?>
            </div>
            <div class="col-md-6 <?php echo $model->hasErrors('reference_value') ? 'has-error' : ''; ?> ">
                <?php echo $form->textFieldControlGroup($model, 'reference_value', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Reference Value')); ?>
            </div>
            <div class="col-md-6 <?php echo $model->hasErrors('type') ? 'has-error' : ''; ?> ">
                <?php echo $form->textFieldControlGroup($model, 'type', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'License, Discount, Percentage')); ?>
            </div>
            <div class="col-md-6 <?php echo $model->hasErrors('value') ? 'has-error' : ''; ?> ">
                <?php echo $form->textFieldControlGroup($model, 'value', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => '10, 20, etc..')); ?>
            </div>
            <div class="col-md-6 <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?> ">
                <?php echo $form->textFieldControlGroup($model, 'description', array('size' => 250, 'maxlength' => 250, 'class' => 'form-control', 'placeholder' => 'Description')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="right">
                <div class="form-group">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                        'class' => 'btn btn-primary',
                        'id' => 'voucher_ref_submit_button'
                    )); ?>
                    <?php echo CHtml::link('Cancel', array('voucherReference/index'),
                        array(
                            'class' => 'btn btn-default'
                        )
                    ); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    $("form[id='voucher-reference-info-form']").validate({
        errorClass: "help-block",
        errorElement: "div",
        rules: {
            'VoucherReference[reference]':{
                required: true
            }
        },
        messages:{
            'VoucherReference[reference]': {
                required: "Please enter strategy name."
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
            if ($(form).valid())
            {
                form.submit();
            }
            return false; // prevent normal form posting
        }
    });
</script>