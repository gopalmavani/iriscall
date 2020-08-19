<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>
<main id="main-container">
	<!-- Hero Content -->
	<div class="bg-primary-dark">
		<section class="content no-padding content-full content-boxed overflow-hidden">
			<div class="push-100-t push-50 text-center">
                <h2 class="box-title m-b-20">Reset your password</h2>
            </div>
		</section>
	</div>
<!-- Log In Form -->
<div class="bg-white">
	<section class="content content-boxed">
		<!-- Section Content -->
		<div class="row items-push push-50-t push-30">
			<div class="col-md-12 col-md-offset-3">
                    <?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'login-form',
						'enableClientValidation'=>true,
						'clientOptions'=>array(
							'validateOnSubmit'=>true,
						),
						'htmlOptions' =>[
							'class' => 'form-horizontal'
						],
					)); ?>
                    <div class="form-group" style="margin-bottom: 5px;">
						<div class="col-xs-12">
							<div class="form-material form-material-primary">
								<label for="frontend-login-username">Enter your email address</label>
								<input type="text" id="email_address" name="email" class="form-control">
							</div>
						</div>
					</div>
                    <div class="form-group" style="margin-bottom: 8px;">
                        <div class="col-xs-12">
                            <?php if (isset($success)){ ?>
                                <div style="font-weight: 600; color: green;"><?php echo $success; ?></div>
                            <?php }?>
                            <?php if (isset($error)){ ?>
                                <div style="font-weight: 600; color: darkred;"><?php echo $error; ?></div>
                            <?php }?>
                            <?php if (isset($empty)){ ?>
                                <div style="font-weight: 600; color: orangered;"><?php echo $empty; ?></div>
                            <?php }?>
                            <?php if (isset($wrong)){ ?>
                                <div style="font-weight: 600; color: darkred;"><?php echo $wrong; ?></div>
                            <?php }?>
                            <?php if (isset($invalid)) {?>
                                <div class="form-group" style="margin-bottom: 8px;">
                                    <div class="mismatch"><?php echo $invalid; ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
					<div class="form-group" style="margin-top: 25px;margin-bottom: 0;">
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                                <button class="btn btn-block btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
					</div>
					<?php $this->endWidget(); ?>
			</div>
		</div>
	</section>
</div>
</main>