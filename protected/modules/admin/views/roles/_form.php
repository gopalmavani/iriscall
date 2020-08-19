<?php
/* @var $this RolesController */
/* @var $model Roles */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('Roles/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'roles-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'pool-plan-form',
                    )
                )); ?>

                <div class="row">
                    <div class="controls">
                        <div class="col-md-4 <?php echo $model->hasErrors('role_title') ? 'has-error' : ''; ?>">
                            <?php echo $form->labelEx($model,'role_title'); ?>
                            <?php echo $form->textField($model,'role_title',array('size'=>50,'maxlength'=>50)); ?>
                            <span class="help-block"><?php echo $form->error($model,'role_title'); ?></span>
                        </div>
                    </div>
                </div>

                <!--<div class="row">
                <?php /*echo $form->labelEx($model,'created_at'); */?>
                <?php /*echo $form->textField($model,'created_at'); */?>
                <?php /*echo $form->error($model,'created_at'); */?>
            </div>-->

                <!--<div class="row">
                <?php /*echo $form->labelEx($model,'modified_at'); */?>
                <?php /*echo $form->textField($model,'modified_at'); */?>
                <?php /*echo $form->error($model,'modified_at'); */?>
            </div>-->
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group" align="right">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                    'class' => 'btn btn-primary col-md-offset-2',
                    'id' => 'create_roles'
                )); ?>
                <?php echo CHtml::link('Cancel', array('Roles/admin'),
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