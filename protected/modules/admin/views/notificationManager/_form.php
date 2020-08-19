<?php
/* @var $this NotificationManagerController */
/* @var $model NotificationManager */
/* @var $form CActiveForm */
?>

<div class="row">
	<div class="col-lg-12">
		<div class="block">
			<div class="block-content block-content-narrow">
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'NotificationManager-form',
				'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
				'enableAjaxValidation'=>false,
			)); ?>

				<div class="col-lg-6">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('category_name') ? 'has-error' : ''; ?> ">
								<?php echo $form->textFieldControlGroup($model, 'category_name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Category Name')); ?>
								<div id="NotificationManager_category_error" class="custom-error help-block text-right"></div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?> ">
								<label class="">
									<?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?>
								</label>
								<?php echo $form->textArea($model, 'description', array('size'=>60, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Category Description')); ?>
								<span class="help-block"><?php echo $form->error($model, 'description'); ?> </span>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : ''; ?> ">
								<?php echo $form->dropDownListControlGroup($model, 'is_active', array('1' => 'Yes', '0' => 'No'), array('class' => 'form-control')); ?>
								<?php echo $form->error($model, 'is_active'); ?>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('portal_id') ? 'has-error' : ''; ?>">
								<?php $PortalList = CHtml::listData(Portals::model()->findAll(['order' => 'portal_id']), 'portal_id', 'portal_name'); ?>
								<?php echo $form->dropDownListControlGroup($model, 'portal_id', $PortalList, array('class' => 'form-control', 'empty' => 'Select Portal')); ?>
							</div>
						</div>
					</div>



					<div class="row buttons">
						<div class="form-group">
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
								'class' => 'btn btn-primary cat-create',
							)); ?>
							<?php echo CHtml::link('Cancel', array('NotificationManager/admin'),
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
<script>
	$(document).ready(function (e) {
		$("#NotificationManager_category_name").focusout(function () {
			//$(".cat-create").click(function () {
			var cat_name = $('#NotificationManager_category_name').val();

			$.ajax({
				url: '<?php  echo Yii::app()->createUrl('admin/NotificationManager/CheckCat');  ?>',
				type: 'POST',
				dataType: "json",
				data: {category: cat_name},
				success: function (response) {
					if (response.token === 1) {
						$("#NotificationManager_category_error").html(response.msg);
						$('.cat-create').attr('disabled','disabled');
					} else {
						$("#NotificationManager_category_error").html(" ");
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