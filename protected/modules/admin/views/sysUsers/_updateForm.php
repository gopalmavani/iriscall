<?php
/* @var $this SysUsersController */
/* @var $model SysUsers */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <!--			<div class="block-header">-->
            <!--				<h3 class="block-title">Fields with <span class="required">*</span> are required.</h3>-->
            <!--			</div>-->
            <div class="block-content block-content-narrow">
                <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'sys-users-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array(
                        'name' => 'SysUserCreate'
                    )
                ));
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group <?php echo $model->hasErrors('username') ? 'has-error' : ''; ?>">
                            <?php echo $form->textFieldControlGroup($model, 'username', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'User Name')); ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group email-validate <?php echo $model->hasErrors('email') ? 'has-error' : ''; ?>">
                            <?php echo $form->textFieldControlGroup($model, 'email', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Email')); ?>
                            <p id='email-valid' class='animated fadeInDown  help-block'>Please enter valid Email address.</p></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group <?php echo $model->hasErrors('activekey') ? 'has-error' : ''; ?>">
                            <?php echo $form->textFieldControlGroup($model, 'activekey', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Active Key')); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group <?php echo $model->hasErrors('auth_level') ? 'has-error' : ''; ?>">
                            <?php // echo $form->textFieldControlGroup($model, 'auth_level', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Authorization level')); ?>
                            <?php echo $form->dropDownListControlGroup($model, 'auth_level', array(
                                "admin" => "Admin",
                                "editor" => "Editor",
                                "viewer" => "Viewer"
                            ), array("class" => "form-control", "prompt" =>"Authorization level")); ?>
                            <?php echo $form->error($model, 'auth_level'); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group <?php echo $model->hasErrors('status') ? 'has-error' : ''; ?>">
                            <?php echo $form->dropDownListControlGroup($model, 'status', array('1' => 'Active', '0' => 'Deactive'), array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>
                </div>

                <div class="row col-md-12">
                    <div class="form-group">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                            'class' => 'btn btn-primary',
                        )); ?>
                        <?php echo CHtml::link('Cancel', array('sysUsers/admin'),
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
