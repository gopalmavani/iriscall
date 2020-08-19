<?php
/* @var $this DenominationController */
/* @var $model Denomination */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right m-b-10">
            <?php echo CHtml::link('Go to list', array('WalletTypeEntity/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'pool-plan-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'Denomination-form',
                    )
                )); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            <div class="col-md-8 <?php echo $model->hasErrors('denomination_type') ? 'has-error' : ''; ?>">
                                <label class=control-label"><?php echo $form->labelEx($model,'denomination_type'); ?></label>
                                <?php echo $form->textField($model,'denomination_type',array('size'=>60,'maxlength'=>255, 'class' => 'form-control', 'placeholder' => 'Denomination Type', 'disabled' => 'disabled')); ?>
                                <?php echo $form->error($model, 'denomination_type',array('class' => 'help-block')) ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-8 <?php echo $model->hasErrors('sub_type') ? 'has-error' : ''; ?>">
                                <label class="control-label"><?php echo $form->labelEx($model,'sub_type'); ?></label>
                                <?php echo $form->textField($model,'sub_type',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Sub Type' ,'disabled' => 'disabled')); ?>
                                <?php echo $form->error($model, 'sub_type',array('class' => 'help-block')) ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-8 <?php echo $model->hasErrors('label') ? 'has-error' : ''; ?>">								<label class="control-label"><?php echo $form->labelEx($model,'label'); ?></label>
                                <?php echo $form->textField($model,'label',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Label')); ?>
                                <?php echo $form->error($model, 'label',array('class' => 'help-block')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group col-md-12 " align="right">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
            'class' => 'btn btn-primary col-md-offset-2',
            'id' => 'create_denomination'
        )); ?>
        <?php echo CHtml::link('Cancel', array('WalletTypeEntity/admin'),
            array(
                'class' => 'btn btn-default'
            )
        );
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
