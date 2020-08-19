<div class="row">
    <div class="col-md-12">
        <div class="pull-right" style="margin: 0 15px 15px 0;">
            <?php echo CHtml::link('Go to list', array('voucher/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'voucher-info-form',
            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
            'enableAjaxValidation' => false,
            'htmlOptions' => array(
                'name' => 'VoucherInfo'
            )
        ));
        ?>
        <div class="row">
            <h4 style="padding: 15px">Voucher Details</h4>

            <div class="col-md-6 <?php echo $model->hasErrors('voucher_name') ? 'has-error' : ''; ?>">
                <?php echo $form->textFieldControlGroup($model, 'voucher_name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Voucher Name')); ?>
            </div>
            <div class="col-md-6 <?php echo $model->hasErrors('reference_id') ? 'has-error' : ''; ?>">
                <div class="controls">
                    <?php echo $form->label($model, 'reference_id', array('class' => 'control-label')); ?>
                    <span class="required">*</span>
                    <?php $list = CHtml::listData(VoucherReference::model()->findAll(), 'id', 'reference');
                    echo $form->dropDownList($model, 'reference_id', $list, array('class' => 'form-control',
                        'empty' => 'Select Strategy'));
                    ?>
                    <span class="help-block"><?php echo $form->error($model, 'reference_id'); ?> </span>
                </div>
            </div>
            <?php $model->voucher_code = VoucherHelper::random_strings(10); ?>
            <div class="col-md-6 <?php echo $model->hasErrors('voucher_code') ? 'has-error' : ''; ?> ">
                <?php echo $form->textFieldControlGroup($model, 'voucher_code', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Last Name')); ?>
            </div>
            <div class="col-md-6 <?php echo $model->hasErrors('voucher_status') ? 'has-error' : ''; ?> ">
                <?php
                $fieldId = CylFields::model()->findByAttributes(['field_name' => 'voucher_status']);
                $statusList = CHtml::listData(CylFieldValues::model()->findAllByAttributes(['field_id' => $fieldId->field_id]), 'predefined_value', 'field_label');
                echo $form->dropDownListControlGroup($model, 'voucher_status', $statusList, [
                    'prompt' => 'Select Status',
                    'class' => 'js-select2 form-control',
                    'options' => array(1 =>array('selected'=>true))
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <h4 style="padding: 15px">Voucher Date details</h4>
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="form-group <?php echo $model->hasErrors('start_time') ? 'has-error' : ''; ?> " id="start_time">
                        <?php echo $form->labelEx($model, 'start_time', array('class' => 'control-label')); ?>
                        <span class="required" aria-required="true">*</span>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', [
                            'model' => $model,
                            'attribute' => 'start_time',
                            'options' => [
                                'dateFormat' => 'yy-mm-dd',
                                'maxDate' => '+1y',
                            ],
                            'htmlOptions' => [
                                'class' => 'form-control'
                            ],
                        ]);
                        ?>
                        <span class="help-block" id="start_time_msg"><?php echo $form->error($model, 'start_time'); ?></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group <?php echo $model->hasErrors('end_time') ? 'has-error' : ''; ?> " id="end_time">
                        <?php echo $form->labelEx($model, 'end_time', array('class' => 'control-label')); ?>
                        <span class="required" aria-required="true">*</span>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'end_time',
                            'options' => [
                                'dateFormat' => 'yy-mm-dd'
                            ],
                            'htmlOptions' => [
                                'class' => 'form-control'
                            ]
                        ));
                        ?>
                        <span class="help-block" id="end_time_msg"><?php echo $form->error($model, 'end_time'); ?></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group <?php echo $model->hasErrors('redeemed_at') ? 'has-error' : ''; ?> " id="redeemed_at">
                        <?php echo $form->labelEx($model, 'redeemed_at', array('class' => 'control-label')); ?>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'redeemed_at',
                            'options' => [
                                'dateFormat' => 'yy-mm-dd'
                            ],
                            'htmlOptions' => [
                                'class' => 'form-control'
                            ]
                        ));
                        ?>
                        <span class="help-block" id="redeemed_at_msg"><?php echo $form->error($model, 'redeemed_at'); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <h4 style="padding: 15px">Voucher Other details</h4>
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="form-group"  id="user">
                        <?php
                        $usersList = CHtml::listData(UserInfo::model()->findAll(["order" => "full_name"]), "user_id",
                            function ($data){
                                $string = $data->first_name." ".$data->last_name."(".$data->email.')';
                                return $string;
                            });
                        echo $form->dropDownListControlGroup($model, "user_id", $usersList, [
                            "prompt" => "Select User",
                            "class" => "js-select2 form-control"
                        ]);
                        ?>
                        <div class="help-block" id="user_msg"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 <?php echo $model->hasErrors('order_info_id') ? 'has-error' : ''; ?>">
                <?php echo $form->textFieldControlGroup($model, 'order_info_id', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Order Info Id')); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="right">
                <div class="form-group">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                        'class' => 'btn btn-primary',
                        'id' => 'voucher_submit_button'
                    )); ?>
                    <?php echo CHtml::link('Cancel', array('voucher/index'),
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
    $("form[id='voucher-info-form']").validate({
        errorClass: "help-block",
        errorElement: "div",
        rules: {
            'VoucherInfo[voucher_name]':{
                required: true,
            },
            'VoucherInfo[reference_id]':{
                required: true,
            },
            'VoucherInfo[voucher_code]':{
                required: true,
            },
            'VoucherInfo[start_time]':{
                required: true,
            },
            'VoucherInfo[end_time]': {
                required: true
            },
            'VoucherInfo[user_id]': {
                required: true
            }
        },
        messages:{
            'VoucherInfo[voucher_name]': {
                required: "Please enter voucher name.",
            },
            'VoucherInfo[reference_id]': {
                required: "Please select strategy.",
            },
            'VoucherInfo[voucher_code]': {
                required: "Please enter voucher code.",
            },
            'VoucherInfo[start_time]': {
                required: "Please select start time."
            },
            'VoucherInfo[end_time]':{
                required: "Please select end time."
            },
            'VoucherInfo[user_id]': {
                required: "Please select user"
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