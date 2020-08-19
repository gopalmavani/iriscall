<?php
/* @var $this NautilusController */
/* @var $model NuClientDepositWithdraw */
/* @var $form CActiveForm */
$userName = UserInfo::model()->findByAttributes(['user_id' => $model->user_id]);
$this->pageTitle = 'Update Deposit of ' . $userName->full_name;
?>
<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('nautilus/deposits'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'depositupdate',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'depositUpdate'
                    )
                ));
                ?>
                <div class="row">

                    <div class="col-md-12">
                        <div class=" <?php echo $model->hasErrors('amount') ? 'has-error' : ''; ?>">
                            <?php echo $form->textFieldControlGroup($model,'amount', array('size' => 50, 'autofocus' => 'on', 'class' => 'form-control','disabled'=>"disabled")); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class=" <?php echo $model->hasErrors('type') ? 'has-error' : ''; ?>">
                            <?php echo $form->dropDownListControlGroup($model,'type', array('Bank Transfer'=>'Bank Transfer', 'Visa'=>'Visa', 'Maestro'=>'Maestro','Paypal' =>'Paypal'), array('prompt' => 'Choose', 'class' => 'form-control','disabled'=>"disabled")); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class=" <?php echo $model->hasErrors('status') ? 'has-error' : ''; ?>">
                            <?php echo $form->dropDownListControlGroup($model,'status', array('0'=>'Pending', '1'=>'Approved', '2'=>'Processed'), array('prompt' => 'Choose', 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class=" <?php echo $model->hasErrors('comment') ? 'has-error' : ''; ?>">
                            <label class=""> <?php echo $form->labelEx($model, 'comment', array('class' => 'control-label')); ?></label>
                            <?php echo $form->textArea($model,'comment', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px">
                    <div class="col-md-12" align="right">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Update' : 'Save', array(
                            'class' => 'btn btn-primary',
                        )); ?>
                        <?php echo CHtml::link('Cancel', array('nautilus/deposits'),
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
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/ckeditor.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/config.js', CClientScript::POS_HEAD);
?>
<script>
    CKEDITOR.editorConfig = function (config) {
        config.language = 'es';
        config.uiColor = '#F7B42C';
        config.height = 300;
        config.toolbarCanCollapse = true;

    };
    CKEDITOR.replace('NuClientDepositWithdraw_comment');
</script>
