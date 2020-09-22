<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18-09-2020
 * Time: 17:46
 */
/* @var $this CategoriesController */
/* @var $model OrganizationInfo */
/* @var $form CActiveForm */
$this->pageTitle = 'Create Invoice';
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
                            <label class="control-lable">
                                Select month
                            </label>
                            <?php $months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'); ?>
                            <select name="month" class="form-control">
                                <option>Select month</option>
                                <?php
                                foreach ($months as $key => $month){?>
                                    <option value="<?= $key; ?>"><?= $month; ?></option>
                                <?php }
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group" align="right">
                <input type="submit" name="submit" value="create" class="btn btn-primary cat-create">
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    $(document).ready(function (e) {

    });
</script>
