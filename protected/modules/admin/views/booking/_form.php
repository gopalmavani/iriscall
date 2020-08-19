<?php
/* @var $this BookingController */
/* @var $model Booking */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="pull-right m-b-10">
            <?php echo CHtml::link('Go to list', array('booking/index'), array('class' => 'btn btn-minw btn-square btn btn-primary')); ?>
        </div>
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'booking-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array(
                        'name' => 'UserCreate'
                    )
                ));
                ?>

                <div class="row">
                    <div class="row">
                        <div class="form-group <?php echo $model->hasErrors('username') ? 'has-error' : ''; ?> ">
                            <?php echo $form->textFieldControlGroup($model, 'username', array('size' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Full name')); ?>
                            <div id="Booking_username_error" class="custom-error help-block text-right"></div>
                        </div>

                        <div class="form-group <?php echo $model->hasErrors('email') ? 'has-error' : ''; ?> ">
                            <?php echo $form->textFieldControlGroup($model, 'email', array('size' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'email')); ?>
                            <div id="Booking_email_error" class="custom-error help-block text-right"></div>
                        </div>

                        <div class="form-group <?php echo $model->hasErrors('mobile_number') ? 'has-error' : ''; ?> ">
                            <?php echo $form->textFieldControlGroup($model, 'mobile_number', array('size' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Mobile number')); ?>
                            <div id="Booking_mobile_number_error" class="custom-error help-block text-right"></div>
                        </div>


                        <div class="form-group <?php echo $model->hasErrors('address') ? 'has-error' : ''; ?> ">
                            <label class="">
                                <?php echo $form->labelEx($model, 'address', array('class' => 'control-label')); ?>
                            </label>
                            <?php echo $form->textArea($model, 'address', array('size'=>60, 'class' => 'form-control', 'placeholder' => 'Address')); ?>
                            <span class="help-block"><?php echo $form->error($model, 'address'); ?> </span>
                        </div>


                    </div>
                    <div class="col-md-12">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                            'class' => 'btn btn-primary',
                        )); ?>
                        <?php echo CHtml::link('Cancel', array('booking/admin'),
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