<?php
/* @var $this CategoriesController */
/* @var $model OrganizationInfo */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-md-12">
        <div class="pull-right" style="margin: 0px 15px 15px 0px;">
            <?php echo CHtml::link('Go to list', array('calldatarecords/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'cdr-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                )); ?>

                <div class="col-lg-6">
                    <div class="row">
                        <div class="form-group">
                            <?php echo $form->label($model, 'organisation_id', array('class' => 'control-label')); ?>
                            <span class="required">*</span>
                            <?php $list = CHtml::listData(OrganizationInfo::model()->findAll(), 'organisation_id', 'name');
                            echo $form->dropDownList($model, 'organisation_id', $list, array('class' => 'form-control',
                                'empty' => 'Select Organisation'));
                            ?>
                            <span class="help-block"><?php echo $form->error($model, 'organisation_id'); ?> </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="">
                                Start date
                            </label>
                            <input type="date" class="form-control" name="start_date">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label class="">
                                End date
                            </label>
                            <input type="date" class="form-control" name="end_date">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group" align="right">
                <input type="submit" name="submit" value="submit" class="btn btn-primary cat-create">
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    $(document).ready(function (e) {

    });
</script>