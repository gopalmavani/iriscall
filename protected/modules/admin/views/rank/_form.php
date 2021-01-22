<?php
/* @var $this RankController */
/* @var $model Rank */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('rank/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'rank-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'rank-form',
                    )
                )); ?>

				<div class="col-md-6">
					<div class="col-md-12">
						<div class="form-group <?php echo $model->hasErrors('name') ? 'has-error' : ''; ?>">
							<?php echo $form->textFieldControlGroup($model, 'name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Rank Name')); ?>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group <?php echo $model->hasErrors('icon') ? 'has-error' : ''; ?>">
							<?php echo $form->fileFieldControlGroup($model, 'icon'); ?>
                            <?php echo !$model->isNewRecord ? '<span>Icon is already uploaded, adding the new image would overwrite the previous one.</span>' : ''?>
                        </div>
					</div>

					<div class="col-md-12">
						<div class="form-group <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?>">
							<?php echo $form->textareaControlGroup($model, 'description', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Description...')); ?>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group <?php echo $model->hasErrors('abbreviation') ? 'has-error' : ''; ?>">
							<?php echo $form->textFieldControlGroup($model, 'abbreviation', array('size' => 50, 'maxlength' => 10, 'autofocus' => 'on', 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Abbreviation')); ?>
						</div>
					</div>
				</div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group" align="right">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                    'class' => 'btn btn-primary col-md-offset-2',
                    'id' => 'create_roles'
                )); ?>
                <?php echo CHtml::link('Cancel', array('rank/admin'),
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

<script type="text/javascript">
$(document).ready(function () {
    $("form[id='rank-form']").validate({
        debug: true,
        errorClass: "help-block",
        errorElement: "span",
        rules: {
            'Rank[name]': {
                required: true
            },
            'Rank[icon]': {
                accept: "image/jpg,image/jpeg,image/png,image/gif"
            },
            'Rank[description]': {
                required: true
            },
            'Rank[abbreviation]': {
                required: true
            }
        },
        messages: {
            'Rank[name]': {
                required: "Please enter the rank name."
            },
            'Rank[icon]': {
                accept: "Please select image file only."
            },  
            'Rank[description]': {
                required: "Please enter the description."
            },
            'Rank[abbreviation]': {
                required: "Please enter the abbreviation."
            }
        },
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            $(element).parent().parent().addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).parent().parent().removeClass('has-error');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>