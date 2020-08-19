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
							<div class="col-md-8 <?php echo $model->hasErrors('name') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model,'name',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Enter Name')); ?>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-8 <?php echo $model->hasErrors('status') ? 'has-error' : ''; ?>">
								<?php echo $form->dropDownListControlGroup($model, 'status', ['active' => 'Active', 'inactive' => 'Inactive'], array('class' => 'form-control', 'placeholder' => 'Select Status')); ?>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-8 <?php echo $model->hasErrors('table_name') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model,'table_name',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Enter Table Name')); ?>
							</div>
						</div>
						<div class="form-group col-md-12 ">
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
								'class' => 'btn btn-primary col-md-offset-2',
							)); ?>
							<?php echo CHtml::link('Cancel', array('compensationsplan/view'),
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