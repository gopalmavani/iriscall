<?php
$this->pageTitle = 'Update Subscription';
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'subscription-plan-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'name' => 'Subscirption-form',
    )
)); ?>
    <div id="subscription_details" class="block">
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="form-group <?php echo $model->hasErrors('user_id') ? 'has-error' : ''; ?>">
                        <?php echo $form->textFieldControlGroup($model, 'user_id', array('disabled' => 'true', 'class' => 'form-control', 'value' => $userName)); ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group <?php echo $model->hasErrors('duration') ? 'has-error' : ''; ?>">
                        <?php echo $form->textFieldControlGroup($model, 'duration', array('autofocus' => 'on', 'class' => 'form-control', 'placeHolder' => 'Enter number of days, weeks, etc..')); ?>
                    </div>
                </div>

                <!--<div class="col-md-12">
                    <div class="form-group <?php /*echo $model->hasErrors('billing_cycles') ? 'has-error' : ''; */?>">
                        <?php /*echo $form->textFieldControlGroup($model, 'billing_cycles', array('class' => 'form-control', 'placeHolder' => 'How many times does the product has to be billed?')); */?>
                    </div>
                </div>-->

                <div class="col-md-12">
                    <div class="form-group <?php echo $model->hasErrors('status') ? 'has-error' : ''; ?>">
                        <?php
                        $statusList = CHtml::listData(CylFieldValues::model()->findAllByAttributes(['field_id' => 210]), 'predefined_value', 'field_label');
                        echo $form->dropDownListControlGroup($model, 'subscription_status', $statusList, [
                            'prompt' => 'Select Status',
                            'class' => 'form-control',
                        ]);
                        ?>
                    </div>
                </div>

            </div>
            <div class="col-md-6">

                <div class="col-md-12">
                    <div class="form-group <?php echo $model->hasErrors('product_name') ? 'has-error' : ''; ?>">
                        <?php echo $form->textFieldControlGroup($model, 'product_name', array('disabled' => 'true', 'class' => 'form-control', 'value' => $productName)); ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group <?php echo $model->hasErrors('duration_denomination') ? 'has-error' : ''; ?>">
                        <?php echo $form->dropDownListControlGroup($model, 'duration_denomination',
                            array('1'=>'Days', '2'=>'Weeks', '3'=>'Months', '4'=>'Years'),
                            array('autofocus' => 'on', 'class' => 'form-control')); ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group <?php echo $model->hasErrors('next_renewal_date') ? 'has-error' : ''; ?> ">
                        <?php echo $form->labelEx($model, 'next_renewal_date', array('class' => 'control-label')); ?>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'next_renewal_date',
                            'options' => array(
                                'showAnim' => '',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                'dateFormat' => 'yy-mm-dd',
                                'maxDate' => date('Y-m-d'),
                                'changeYear' => true,           // can change year
                                'changeMonth' => true,
                                'yearRange' => '1900:' . date('Y'),
                            ),
                            'htmlOptions' => array(
                                'class' => 'form-control'
                            ),
                        ));
                        ?>
                        <span class="help-block"><?php echo $form->error($model, 'next_renewal_date'); ?> </span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group <?php echo $model->hasErrors('starts_at') ? 'has-error' : ''; ?> ">
                        <?php echo $form->labelEx($model, 'starts_at', array('class' => 'control-label')); ?>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'starts_at',
                            'options' => array(
                                'showAnim' => '',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                'dateFormat' => 'yy-mm-dd',
                                'maxDate' => date('Y-m-d'),
                                'changeYear' => true,           // can change year
                                'changeMonth' => true,
                                'yearRange' => '1900:' . date('Y'),
                            ),
                            'htmlOptions' => array(
                                'class' => 'form-control'
                            ),
                        ));
                        ?>
                        <span class="help-block"><?php echo $form->error($model, 'starts_at'); ?> </span>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="margin-left: 18px;">
                <div class="form-group">
                    <?php echo CHtml::submitButton('Save', array(
                        'class' => 'btn btn-primary',
                    )); ?>
                    <?php echo CHtml::link('Cancel', array('subscription/admin'),
                        array(
                            'class' => 'btn btn-default'
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->endWidget(); ?>