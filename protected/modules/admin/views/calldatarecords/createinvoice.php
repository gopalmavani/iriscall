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
                            <?php
                            $months = array('2020-01-31' => 'January - 2020', '2020-02-29' => 'February - 2020', '2020-03-31' => 'March - 2020', '2020-04-30' => 'April - 2020', '2020-05-31' => 'May - 2020', '2020-06-30' => 'June - 2020', '2020-07-31' => 'July - 2020', '2020-08-31' => 'August - 2020', '2020-09-30' => 'September - 2020', '2020-10-31' => 'October - 2020', '2020-11-30' => 'November - 2020', '2020-12-31' => 'December - 2020','2021-01-31' => 'January - 2021', '2021-02-28' => 'February - 2021', '2021-03-31' => 'March - 2021', '2021-04-30' => 'April - 2021', '2021-05-31' => 'May - 2021', '2021-06-30' => 'June - 2021', '2021-07-31' => 'July - 2021', '2021-08-31' => 'August - 2021', '2021-09-30' => 'September - 2021', '2021-10-31' => 'October - 2021', '2021-11-30' => 'November - 2021', '2021-12-31' => 'December - 2021');
                            ?>
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
