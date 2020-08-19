<?php
/* @var $this WalletController */
/* @var $model Wallet */
/* @var $form CActiveForm */
?>

<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('wallet/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
	<div class="col-lg-12">
		<div class="block">
			<div class="block-content block-content">
				<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
					'id'=>'wallet-form',
					'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'product-info-form',
                    )
				)); ?>

				<div class="row">
					<div class="col-md-6">
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('user_id') ? 'has-error' : ''; ?>">
								<?php
								$usersList = CHtml::listData(UserInfo::model()->findAll(['order' => 'full_name']), 'user_id','full_name');
								echo $form->dropDownListControlGroup($model, 'user_id', $usersList, [
									'prompt' => 'Select User',
									'class' => 'js-select2 form-control',
								]);
								?>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('wallet_type_id') ? 'has-error' : ''; ?>">
								<?php
								$usersList = CHtml::listData(WalletTypeEntity::model()->findAll(['order' => 'wallet_type']), 'wallet_type_id','wallet_type');
								echo $form->dropDownListControlGroup($model, 'wallet_type_id', $usersList, [
									'prompt' => 'Select Wallet Type',
									'class' => 'js-select2 form-control',
								]);
								?>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('transaction_type') ? 'has-error' : ''; ?>">
								<?php
								$fieldId = CylFields::model()->findByAttributes(['field_name' => 'transaction_type']);
								$list = CHtml::listData(CylFieldValues::model()->findAllByAttributes(['field_id' => $fieldId->field_id ]),'predefined_value','field_label');
								echo $form->dropDownListControlGroup($model, 'transaction_type', $list, [
									'prompt' => 'Select Transaction Type',
									'class' => 'js-select2 form-control',
								]);
								?>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('reference_id') ? 'has-error' : ''; ?>">
								<?php
								$usersList = CHtml::listData(WalletMetaEntity::model()->findAll(['order' => 'reference_desc']), 'reference_id','reference_desc');
								echo $form->dropDownListControlGroup($model, 'reference_id', $usersList, [
									'prompt' => 'Select Reference Desc',
									'class' => 'js-select2 form-control',
								]);
								?>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('transaction_comment') ? 'has-error' : ''; ?>">
								<?php echo $form->textAreaControlGroup($model, 'transaction_comment', array('size'=>60,'maxlength'=>80, 'class' => 'form-control')); ?>
							</div>
						</div>

											</div>

					<div class="col-md-6">
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('reference_num') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model, 'reference_num', array('size'=>60,'maxlength'=>80, 'class' => 'form-control')); ?>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('denomination_id') ? 'has-error' : ''; ?>">
								<?php
								$list = CHtml::listData(Denomination::model()->findAll(["order" => "denomination_id"]),"denomination_id",
									function ($data){
										$fieldId = CylFields::model()->findByAttributes(["field_name" => "denomination_type"]);
										$fieldLabel = CylFieldValues::model()->findByAttributes(["field_id" => $fieldId->field_id,"predefined_value" => $data->denomination_id]);
										return "{$fieldLabel->field_label}  {$data->currency}";
									});
								echo $form->dropDownListControlGroup($model, "denomination_id", $list, [
									"prompt" => "Select Denomination",
									"class" => "js-select2 form-control",
								]);
								?>							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('transaction_status') ? 'has-error' : ''; ?>">
								<?php
								$fieldId = CylFields::model()->findByAttributes(['field_name' => 'transaction_status']);
								$list = CHtml::listData(CylFieldValues::model()->findAllByAttributes(['field_id' => $fieldId->field_id ]),'predefined_value','field_label');
								echo $form->dropDownListControlGroup($model, 'transaction_status', $list, [
									'prompt' => 'Select Transaction Status',
									'class' => 'js-select2 form-control',
								]);
								?>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('portal_id') ? 'has-error' : ''; ?>">
								<?php
								$usersList = CHtml::listData(Portals::model()->findAll(['order' => 'portal_name']), 'portal_id','portal_name');
								echo $form->dropDownListControlGroup($model, 'portal_id', $usersList, [
									'prompt' => 'Select Portal',
									'class' => 'js-select2 form-control',
								]);
								?>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('amount') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model, 'amount', array('size'=>60,'maxlength'=>80, 'class' => 'form-control')); ?>
							</div>
						</div>
					</div>

					<div class="col-md-12" align="right">
						<div class="form-group">
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
								'class' => 'btn btn-primary',
							)); ?>
							<?php echo CHtml::link('Cancel', array('wallet/admin'),
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