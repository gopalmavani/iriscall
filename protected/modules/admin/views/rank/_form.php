<?php
/* @var $this RankController */
/* @var $model Rank */
/* @var $form CActiveForm */
?>
<div class="pull-right m-b-10">
	<?php echo CHtml::link('Go to list', array('rank/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
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
						'name' => 'Rank-form',
					)
				)); ?>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group col-md-12">
							<div class="col-md-8 <?php echo $model->hasErrors('rankName') ? 'has-error' : ''; ?>">
								<label class=control-label"><?php echo $form->labelEx($model,'rankName'); ?></label>
								<?php echo $form->textField($model,'rankName',array('size'=>60,'maxlength'=>255, 'class' => 'form-control', 'placeholder' => 'Rank Name')); ?>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-8 <?php echo $model->hasErrors('rankIcon') ? 'has-error' : ''; ?>
 ">
								<label class="control-label"><?php echo $form->labelEx($model,'rankIcon'); ?></label>
								<?php echo $form->textField($model,'rankIcon',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Rank Icon')); ?>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-8 <?php echo $model->hasErrors('descriptions') ? 'has-error' : ''; ?>
">								<label class="control-label"><?php echo $form->labelEx($model,'descriptions'); ?></label>
								<?php echo $form->textField($model,'descriptions',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Descriptions')); ?>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-8 <?php echo $model->hasErrors('userPaidOut') ? 'has-error' : ''; ?>
">								<label class="control-label"><?php echo $form->labelEx($model,'userPaidOut'); ?></label>
								<?php echo $form->textField($model,'userPaidOut',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'User Paid Out')); ?>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-8 <?php echo $model->hasErrors('rankAbbreviation') ? 'has-error' : ''; ?>
">								<label class="control-label"><?php echo $form->labelEx($model,'rankAbbreviation'); ?></label>
								<?php echo $form->textField($model,'rankAbbreviation',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Rank Abbriviation')); ?>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-8 <?php echo $model->hasErrors('level') ? 'has-error' : ''; ?>
">								<label class="control-label"><?php echo $form->labelEx($model,'level'); ?></label>
								<?php echo $form->textField($model,'level',array('size'=>50,'maxlength'=>50, 'class' => 'form-control', 'placeholder' => 'Level')); ?>
							</div>
						</div>

						<div class="page-heading">Rules</div>

						<?php
						$cnt=0;$id=1;
						foreach ($rulesModel as $key => $value){
							$cnt++;
							$rankRules=Rankrules::model()->findByAttributes(array('rankId'=>$model->rankId,'ruleId'=>$value->ruleId));
							if($rankRules['isActive'] == 1)
								$checkVal=true;
							else
								$checkVal=false;
							?>
							<div class="form-group col-md-12">
								<div class="col-md-6 <?php echo $model->hasErrors('level') ? 'has-error' : ''; ?>">
									<label >
										<?php echo tbHtml::checkBox('description['.$value->ruleId.']',$checkVal,array('label' => $value->description)); ?>
									</label>
									<input type="hidden" name="desc[<?php echo $value->ruleId; ?>]" value="<?php echo $value->description; ?>"/>
									<?php echo tbHtml::textField('value1['.$value->ruleId.']',$rankRules['value1'],array('size'=>60,'maxlength'=>100)); ?> <br>
									<?php echo tbHtml::textField('value2['.$value->ruleId.']',$rankRules['value2'],array('size'=>60,'maxlength'=>100)); ?>
								</div>
							</div>

							<?php
						}
						?>
						<input type="hidden" name="count" id="count" value=<?php echo $cnt;?>  />

						<div class="form-group col-md-12 ">
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
								'class' => 'btn btn-primary col-md-offset-2',
								'id' => 'create_rank'
							)); ?>
							<?php echo CHtml::link('Cancel', array('rank/admin'),
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