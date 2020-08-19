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
		border-color: #aaaaaa;
	}
	#select2-user_multi_select-results{
		width:370px;
	}
</style>

<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('poolPlan/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>

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
							<div class="col-md-8 <?php echo $model->hasErrors('pool_name') ? 'has-error' : ''; ?>">
								<label class=control-label"><?php echo $form->labelEx($model,'pool_name'); ?></label>
								<?php echo $form->textField($model,'pool_name',array('size'=>60,'maxlength'=>255, 'class' => 'form-control', 'placeholder' => 'Pool Name')); ?>
								<div id="poolName_error"></div>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-8 <?php echo $model->hasErrors('pool_description') ? 'has-error' : ''; ?>">
								<label class=control-label"><?php echo $form->labelEx($model,'pool_description'); ?></label>
								<?php echo $form->textField($model,'pool_description',array('size'=>60,'maxlength'=>255, 'class' => 'form-control', 'placeholder' => 'Pool Description')); ?>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-8 <?php echo $model->hasErrors('pool_amount') ? 'has-error' : ''; ?>
 ">
								<label class="control-label"><?php echo $form->labelEx($model,'pool_amount'); ?></label>
								<?php echo $form->textField($model,'pool_amount',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Pool Amount')); ?>
								<div id="amount_error"></div>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-8 <?php echo $model->hasErrors('pool_denomination') ? 'has-error' : ''; ?>
">								<label class="control-label"><?php echo $form->labelEx($model,'pool_denomination'); ?></label>
								<?php echo $form->textField($model,'pool_denomination',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Pool Denomination')); ?>
								<div id="denomination_error"></div>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-8">
								<label style="float: left;" for="userSelect"> Add user to pool</label>
								<select class="js-select2 form-control" id="user_multi_select" name="PoolPlan[user_id][]" style="width: 100%;" data-placeholder="Select User" multiple>
									<?php $users = UserInfo::model()->findAll();
									foreach ($users as $user) {
										?>
										<option
											value="<?php echo $user->user_id ?>"><?php echo $user->full_name ?></option>
										<?php
									}
									?>
								</select>
								<div id="multi_user_error"></div>
								<?php echo $form->error($model,'user_id'); ?>
							</div>
						</div>
						<div class="form-group col-md-12 ">
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
								'class' => 'btn btn-primary col-md-offset-2',
								'id' => 'create_pool_plan'
							)); ?>
							<?php echo CHtml::link('Cancel', array('poolplan/admin'),
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