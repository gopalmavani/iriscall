<?php
/* @var $this CompensationsController */
/* @var $model Compensations */
/* @var $form CActiveForm */
?>
<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('unilevelplan/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'unilevelplan-plan-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'pool-plan-form',
                    )
                )); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            <div class="col-md-8 <?php echo $model->hasErrors('level') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model,'level',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Enter Level')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-8 <?php echo $model->hasErrors('rank') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model,'rank',array('size'=>60,'maxlength'=>255, 'class' => 'form-control', 'placeholder' => 'Enter Rank')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-8 <?php echo $model->hasErrors('amount') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model,'amount',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Enter Amount')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-8 <?php echo $model->hasErrors('denomination') ? 'has-error' : ''; ?>">
                                <?php
                                $denominationlist = CHtml::listData(Denomination::model()->findAll(['order' => 'denomination_type']), 'denomination_id', 'denomination_type');
                                echo $form->dropDownListControlGroup($model, 'denomination', $denominationlist, [
                                    'class' => 'form-control',
                                    'options'=>array(1=>array('selected'=>'selected'))
                                ]);
                                //echo $form->textFieldControlGroup($model,'denomination',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Enter Denomination'));
                                ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12 ">
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                                'class' => 'btn btn-primary col-md-offset-2',
                            )); ?>
                            <?php echo CHtml::link('Cancel', array('unilevelplan/admin'),
                                array(
                                    'class' => 'btn btn-default'
                                )
                            );
                            ?>
                        </div>
                    </div>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
</div>