<?php
/* @var $this CategoriesController */
/* @var $model Categories */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-md-12">
        <div class="pull-right" style="margin: 0px 15px 15px 0px;">
            <?php echo CHtml::link('Go to list', array('categories/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?> 
        </div>
    </div>
	<div class="col-lg-12">
		<div class="block">
			<div class="block-content block-content-narrow">
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'categories-form',
				'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
				'enableAjaxValidation'=>false,
			)); ?>

				<div class="col-lg-6">
					<div class="row">
						<div class="form-group <?php echo $model->hasErrors('category_name') ? 'has-error' : ''; ?> ">
							<?php echo $form->textFieldControlGroup($model, 'category_name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Category Name')); ?>
                            <div id="Categories_category_error" class="custom-error help-block text-right"></div>
						</div>
					</div>

					<div class="row">
						<div class="form-group <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?> ">
							<label class="">
								<?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?>
							</label>
							<?php echo $form->textArea($model, 'description', array('size'=>60, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Category Description')); ?>
							<span class="help-block"><?php echo $form->error($model, 'description'); ?> </span>
						</div>
					</div>

					<div class="row">
						<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : ''; ?> ">
							<?php echo $form->dropDownListControlGroup($model, 'is_active', array('1' => 'Yes', '0' => 'No'), array('class' => 'form-control')); ?>
							<?php echo $form->error($model, 'is_active'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
        <div class="col-md-12">
            <div class="form-group" align="right">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
								'class' => 'btn btn-primary cat-create',
							)); ?>
                <?php echo CHtml::link('Cancel', array('categories/admin'),
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
<script>
	$(document).ready(function (e) {
		$("#Categories_category_name").focusout(function () {
			//$(".cat-create").click(function () {
			var cat_name = $('#Categories_category_name').val();

			$.ajax({
				url: '<?php  echo Yii::app()->createUrl('admin/categories/CheckCat');  ?>',
				type: 'POST',
				dataType: "json",
				data: {category: cat_name},
				success: function (response) {
					if (response.token === 1) {
						$("#Categories_category_error").html(response.msg);
						$('.cat-create').attr('disabled','disabled');
					} else {
						$("#Categories_category_error").html(" ");
						$('.cat-create').removeAttr('disabled');
					}
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					alert(errorThrown);
				}
			});
		});
	});
</script>