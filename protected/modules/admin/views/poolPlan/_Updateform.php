<?php
/* @var $this PoolPlanController */
/* @var $model PoolPlan */
/* @var $form CActiveForm */
?>

<style>
    .control-group{
        padding-left: 15px;
    }
    .form-control, .select2-selection--multiple{
        width:370px;
        border-color: #aaaaaa !important;
    }
    #select2-user_multi_select-results{
        width:370px;
    }
</style>
<div class="row">
    <div class="col-lg-9">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'pool-plan-form',
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
                            <?php echo $form->error($model,'pool_name'); ?>
                            <div class="col-md-8">
                                <label class=control-label"><?php echo $form->labelEx($model,'pool_name'); ?> </label>
                                <?php echo $form->textField($model,'pool_name',array('size'=>60,'maxlength'=>255, 'class' => 'form-control', 'placeholder' => 'Pool Name')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <?php echo $form->error($model,'pool_description'); ?>
                            <div class="col-md-8">
                                <label class=control-label"><?php echo $form->labelEx($model,'pool_description'); ?> </label>
                                <?php echo $form->textField($model,'pool_description',array('size'=>60,'maxlength'=>255, 'class' => 'form-control', 'placeholder' => 'Pool Description')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <?php echo $form->error($model,'pool_amount'); ?>
                            <div class="col-md-8">
                                <label class="control-label"><?php echo $form->labelEx($model,'pool_amount'); ?> </label>
                                <?php echo $form->textField($model,'pool_amount',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Pool Amount')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <?php echo $form->error($model,'pool_denomination'); ?>
                            <div class="col-md-8">
                                <label class="control-label"><?php echo $form->labelEx($model,'pool_denomination'); ?> </label>
                                <?php echo $form->textField($model,'pool_denomination',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Pool Denomination')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-8">
                                <?php echo $form->error($model,'user_id'); ?>
                                <label class="control-label" for="val-select2-multiple">Add user to pool</label>
                                <select class="js-select2 form-control" id="user_multi_select" multiple="multiple" name="PoolPlan[user_id][]" style="width: 100%;" data-placeholder="Choose at least two.." >
                                    <?php $users = UserInfo::model()->findAll();
                                    foreach ($users as $user) {
                                        ?>
                                        <option
                                                value="<?php echo $user->user_id ?>"><?php echo $user->full_name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-12 ">
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                                'class' => 'btn btn-primary col-md-offset-2',
                            )); ?>
                            <?php echo CHtml::link('Cancel', array('poolPlan/admin'),
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
<?php
$Update_user = explode(',', $model->user_id);
$t1 = json_encode($Update_user);

?>
<script>
    $('#user_multi_select').val(<?php echo $t1; ?>).trigger('change');
</script>