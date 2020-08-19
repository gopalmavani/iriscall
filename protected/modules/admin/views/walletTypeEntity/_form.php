<?php
/* @var $this WalletTypeEntityController */
/* @var $model WalletTypeEntity */
/* @var $form CActiveForm */
?>

<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('walletTypeEntity/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?> 
        </div>
    </div>
	<div class="col-lg-12">
		<div class="block">
			<div class="block-content block-content">
				<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
					'id'=>'wallet-type-entity-form',
					'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                    )
				)); ?>

				<div class="row">

					<div class="col-md-6">
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('wallet_type') ? 'has-error' : ''; ?> ">
								<?php echo $form->textFieldControlGroup($model, 'wallet_type', array('size'=>60,'maxlength'=>80, 'class' => 'form-control')); ?>
							</div>
						</div>
					</div>
					<div class="col-md-12" align="right">
						<div class="form-group">
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
								'class' => 'btn btn-primary',
							)); ?>
							<?php echo CHtml::link('Cancel', array('walletTypeEntity/admin'),
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