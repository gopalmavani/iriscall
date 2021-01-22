<?php
/* @var $this UserInfoController */
/* @var $model UserInfo */
/* @var $form CActiveForm */
?>
<style>
    #RadioCompany{
        display: inline;
    }
    #system-mail{
        display: none;
    }
    .showonhover:hover #system-mail {
        display: block;
    }
    #market-mail-1{
        display: none;
    }
    .showhover:hover #market-mail-1 {
        display: block;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="pull-right" style="margin: 0px 15px 15px 0px;">
            <?php echo CHtml::link('Go to list', array('userInfo/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs">
                <li id="profile_tab" class="active">
                    <a href="#user-profile" data-toggle="tab"> Profile Information</a>
                </li>
                <li id="payout_tab" class="disabledTab">
                    <a href="#user-payout" data-toggle="tab"> Payout Information</a>
                </li>
                <li id="email_tab" class="disabledTab">
                    <a href="#user-email" data-toggle="tab"> Notification Email</a>
                </li>
            </ul>
            <div class="block-content tab-content">
                <div class="tab-pane active" id="user-profile">
                    <div class="block-content block-content-narrow">
                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'id' => 'user-info-form',
                            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array(
                                'name' => 'UserProfile'
                            )
                        ));
                        ?>
                        <div class="row">
                            <div class="form-material has-error">
                                <p id="userAddError" class="help-block " style="display: none;">User already saved</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 <?php echo $model->hasErrors('first_name') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'first_name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'First Name')); ?>
                            </div>
                            <div class="col-md-4 <?php echo $model->hasErrors('middle_name') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'middle_name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Middle Name')); ?>
                            </div>
                            <div class="col-md-4  <?php echo $model->hasErrors('last_name') ? 'has-error' : ''; ?> ">
                                <?php echo $form->textFieldControlGroup($model, 'last_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Last Name')); ?>
                            </div>
                            <div class="col-md-6 <?php echo $model->hasErrors('full_name') ? 'has-error' : ''; ?> ">
                                <?php echo $form->textFieldControlGroup($model, 'full_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Full Name', 'readOnly'=>true)); ?>
                            </div>
                            <div class="col-md-6 <?php echo $model->hasErrors('role') ? 'has-error' : ''; ?>">
                                <div class="controls">
                                    <?php echo $form->label($model, 'role', array('class' => 'control-label')); ?>
                                    <span class="required">*</span>
                                    <?php $list = CHtml::listData(Roles::model()->findAll(),'role_title','role_title');
                                    echo $form->dropDownList($model, 'role', $list, array('class' => 'form-control','empty' => 'Select Role')); ?>
                                    <span class="help-block"><?php echo $form->error($model, 'role'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 email-validate <?php echo $model->hasErrors('email') ? 'has-error' : ''; ?> ">
                                <?php echo $form->textFieldControlGroup($model, 'email', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                <p id='email-valid' class='animated fadeInDown  help-block'>Please enter valid Email address.</p>                    </div>
                            <!--<div class="col-md-6 <?php /*echo $model->hasErrors('password') ? 'has-error' : ''; */?> ">
                                <?php /*echo $form->passwordFieldControlGroup($model, 'password', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); */?>
                            </div>-->
                            <div class="col-md-6 <?php echo $model->hasErrors('rank') ? 'has-error' : ''; ?>">
                                <div class="controls">
                                    <?php echo $form->label($model, 'rank', array('class' => 'control-label')); ?>
                                    <span class="required">*</span>
                                    <?php $list = CHtml::listData(Rank::model()->findAll(),'id','name');
                                    echo $form->dropDownList($model, 'rank', $list, array('class' => 'form-control','empty' => 'Select Rank')); ?>
                                    <span class="help-block"><?php echo $form->error($model, 'rank'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <h4>Personal Information</h4>
                            </div>
                        </div>

                        <?php echo $form->labelEx($model, 'gender', array('class' => 'control-label')); ?>
                        <div class="col-md-12 <?php echo $model->hasErrors('gender') ? 'has-error' : ''; ?>">
                            <div class="radio">
                                <?php echo $form->radioButtonList($model, 'gender', array(
                                    '1' => 'Male', '2' => 'Female',
                                ),array(
                                    'labelOptions'=>array('style'=>'display:inline'), // add this code
                                    'separator'=>'  ')); ?>
                            </div>
                            <span class="help-block"><?php echo $form->error($model, 'gender'); ?> </span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('sponsor_id') ? 'has-error' : ''; ?> ">
                                        <div class="controls">
                                            <?php echo $form->label($model, 'sponsor_id', array('class' => 'control-label')); ?>
                                            <span class="required">*</span>
                                            <?php $list = CHtml::listData(UserInfo::model()->findAll(), 'user_id', 'full_name');
                                            echo $form->dropDownList($model, 'sponsor_id', $list, array('class' => 'form-control',
                                                'empty' => 'Select Sponsor'));
                                            ?>
                                            <span class="help-block"><?php echo $form->error($model, 'sponsor_id'); ?> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('date_of_birth') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->labelEx($model, 'dateOfBirth', array('class' => 'control-label')); ?>
                                        <span class="required" aria-required="true">*</span>
                                        <?php
                                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $model,
                                            'attribute' => 'date_of_birth',
                                            //'value'=>$model->dateOfBirth,
                                            // additional javascript options for the date picker plugin
                                            'options' => array(
                                                'showAnim' => '',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                                'dateFormat' => 'yy-mm-dd',
                                                'maxDate' => date('Y-m-d'),
                                                'changeYear' => true,           // can change year
                                                'changeMonth' => true,
                                                'yearRange' => '1900:' . date('Y'),
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'form-control',
                                                //'style'=>'height:20px;background-color:green;color:white;',
                                            ),
                                        ));
                                        ?>
                                        <span class="help-block"><?php echo $form->error($model, 'date_of_birth'); ?> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 custom_fields">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Address</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('building_num') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'building_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('street') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'street', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('region') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'region', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('city') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'city', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('postcode') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'postcode', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('country') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->dropDownListControlGroup($model, 'country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('phone') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'phone', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                        <p id='phone-valid' class='help-block'>Please enter valid Phone number.</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="<?php echo $model->hasErrors('language') ? 'has-error' : ''; ?>">
                                            <?php echo $form->dropDownListControlGroup($model,'language', array('English'=>'English', 'Dutch'=>'Dutch', 'French'=>'French'), array('prompt' => 'Select Language', 'class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Billing Info</h4>
                            </div>
                            <div class="row" id="RadioCompany">
                                <div class="col-md-6">
                                    <input type="radio" value="1" checked name="Business" />
                                    <label> Personal</label>
                                    <input type="radio" value="2" name="Business" />
                                    <label> Business</label>
                                </div>
                            </div>
                        </div>
                        <div class="hiddendefault">
                            <div id="company">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('business_name') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'business_name', array('class' => 'form-control', 'label' => 'Business Name')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('vat_number') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'vat_number', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <div class="col-md-12 form-group">
                                        <input type="checkbox" id="diff_address" name="Diffrent_Address">
                                        <label id="check_box">Use Different Address</label>
                                    </div>
                                </div>
                            </div>
                            <div id="companyAddress">
                                <div class="row" >
                                    <div class="col-md-12">
                                        <h4>Business Address</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('busAddress_building_num') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'busAddress_building_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'Building Number *')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('busAddress_street') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'busAddress_street', array('class' => 'form-control','label'=>'street *')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('busAddress_region') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'busAddress_region', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'region')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('busAddress_city') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'busAddress_city', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'city *')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('busAddress_postcode') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'busAddress_postcode', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'postcode *')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('busAddress_country') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->dropDownListControlGroup($model, 'busAddress_country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control','label'=>'Country *')); ?>
                                            </div>
                                        </div>
                                        <!--<div class="col-md-12">
                                        <div class="form-group <?php /*echo $model->hasErrors('business_phone') ? 'has-error' : ''; */?> ">
                                            <?php /*echo $form->textFieldControlGroup($model, 'business_phone', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); */?>
                                            <p id='business-phone-valid' class='help-block'>Please enter valid Phone number.</p>
                                        </div>
                                    </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- form -->
                    <div class="row col-md-12" align="right">
                        <div class="form-group">
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Save and Continue' : 'Save', array(
                                'class' => 'btn btn-primary',
                            )); ?>
                            <?php echo CHtml::link('Cancel', array('userInfo/admin'),
                                array(
                                    'class' => 'btn btn-default'
                                )
                            );
                            ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <div class="tab-pane" id="user-payout">
                    <div class="block-content block-content-narrow">
                        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'id'=>'payout-info-form',
                            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                            'enableAjaxValidation'=>false,
                            'htmlOptions' => array(
                                'enctype' => 'multipart/form-data',
                                'name' => 'UserPayout',
                            ),
                        )); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-material has-error">
                                        <p id="payoutError" class="help-block has-error" style="display: none;"></p>
                                        <input type="hidden" name="Payout[uid]" value="" id="Payout_uid">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="alert alert-success" id="userSucc" align="center"  style="display: none;">
                                        <h4 id="userAddSuccess">User created successfully</h4>
                                    </div>
                                    <div class="alert alert-success" id="payoutSucc" align="center"  style="display: none;">
                                        <h4 id="payoutMessage">Payout Information created successfully</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12 <?php echo $payout->hasErrors('bank_name') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($payout, 'bank_name', array('class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12 <?php echo $payout->hasErrors('account_name') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($payout, 'account_name', array('class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12 <?php echo $payout->hasErrors('iban') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($payout, 'iban', array('class' => 'form-control','label' => 'IBAN')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12 <?php echo $payout->hasErrors('bic_code') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($payout, 'bic_code', array('class' => 'form-control','label'=> 'BIC Code')); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Bank Address</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12 <?php echo $payout->hasErrors('bank_building_num') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($payout, 'bank_building_num', array('class' => 'form-control','label'=>'Building Number')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12 <?php echo $payout->hasErrors('bank_city') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($payout, 'bank_city', array('class' => 'form-control','label'=>'City')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12 <?php echo $payout->hasErrors('bank_street') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($payout, 'bank_street', array('class' => 'form-control','label'=>'Street')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12 <?php echo $payout->hasErrors('bank_postcode') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($payout, 'bank_postcode', array('class' => 'form-control','label'=>'Postcode')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12 <?php echo $payout->hasErrors('bank_region') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($payout, 'bank_region', array('class' => 'form-control','label'=>'Region')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12<?php echo $payout->hasErrors('bank_country') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->dropDownListControlGroup($payout, 'bank_country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control','label'=>'Country')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12" align="right">
                                    <div class="form-group">
                                        <a href="javascript:void(0);"  class="btn btn-primary" id="pay_btn">Save and Continue</a>
                                        <?php echo CHtml::link('Cancel', array('userInfo/admin'),
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
                <div class="tab-pane" id="user-email">
                    <form method="post" name="mail-setting" id="mail-setting">
                        <div class="row" style="margin-left: 10px;">
                            <div class="col-md-12">
                                <div class="form-material has-error">
                                    <p id="emailError" class="help-block has-error" style="display: none;"></p>
                                    <input type="hidden" name="Email[uid]" value="" id="Email_uid">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-success" id="emailSucc" align="center" style="display: none;">
                                    <h4 id="emailMessage">User created successfully</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        If you would like to receive system mails updating you directly on activities in your system, you need to check the following box
                                    </p>
                                    <div class="form-group">
                                        <div class="checkbox checkbox-success">
                                            <input id="notification-mail" type="checkbox" name="email[notification-mail]" <?php if($model->notification_mail == 1){echo "checked";}?>>
                                            <label for="notification-mail"> I would like to receive notification mails
                                                <span class="showonhover">
                                                        <i class="fa fa-info-circle"></i>
                                                        <div class="col-md-12" id="system-mail" style="background: rgba(0,0,0,.03);border-color: rgba(0,0,0,.03); margin-bottom: 20px;">
                                                    <div class="row" style="margin-left: auto;">
                                                        <div class="form-group" style="margin-top: 10px;margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-1" name="sys-1">
                                                                <label for="sys-1"> I would like to receive a mail when I don't have enough licenses for my remaining capital </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-2" name="sys-2">
                                                                <label for="sys-2"> I would like to receive a mail for evey weekly/monthly commissions payout </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-3" name="sys-3">
                                                                <label for="sys-3"> I would like to receive a mail when I do a withdrawal of my trading capital </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-4" name="sys-4">
                                                                <label for="sys-4"> I would like to receive a mail when a first line affiliate registers to the system </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-5" name="sys-5">
                                                                <label for="sys-5"> I would like to receive a mail when a first line affiliate buys new licenses </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-6" name="sys-6">
                                                                <label for="sys-6"> I would like to receive a mail when a first line affiliate places new nodes </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-7" name="sys-7">
                                                                <label for="sys-7"> I would like to receive a mail when a second line affiliate registers to the system </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-8" name="sys-8">
                                                                <label for="sys-8"> I would like to receive a mail when a first line affiliate buys new licenses </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-9" name="sys-9">
                                                                <label for="sys-9"> I would like to receive a mail when a first line affiliate places new nodes </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-10" name="sys-10">
                                                                <label for="sys-10"> I would like to receive a mail when a second line affiliate registers to the system </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-11" name="sys-11">
                                                                <label for="sys-11"> I would like to receive a mail when a second line affiliate buys new licenses </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-12" name="sys-12">
                                                                <label for="sys-12"> I would like to receive a mail when a second line affiliate places new nodes </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-13" name="sys-13">
                                                                <label for="sys-13"> I would like to receive a mail when a client deposit has been detected in my matrix </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-14" name="sys-14">
                                                                <label for="sys-14"> I would like to receive a mail when there is a spillover in my matrix </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-15" name="sys-15">
                                                                <label for="sys-15"> I would like to receive a mail when there is withdrawal by a client in my matrix </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                                <input type="checkbox" checked id="sys-16" name="sys-16">
                                                                <label for="sys-16"> I would like to receive a mail when the cashback earnings have been calculated </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        In order to keep receiving updates on the company or its products, please let us know here if you want to receive mails.
                                    </p>
                                    <div class="form-group">
                                        <div class="checkbox checkbox-success">
                                            <input id="market-mail" type="checkbox" name="email[market-mail]"  <?php if($model->marketting_mail == 1){echo "checked";}?>>
                                            <label for="market-mail"> I would like to receive marketing mails
                                                <span class="showhover">
                                                        <i class="fa fa-info-circle"></i>
                                                        <div class="col-md-12" id="market-mail-1" style="background: rgba(0,0,0,.03);border-color: rgba(0,0,0,.03); margin-bottom: 20px;">
                                            <div class="row" style="margin-left: auto">
                                                <div class="form-group" style="margin-top: 10px;margin-bottom: 0">
                                                    <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                        <input type="checkbox" checked id="mark-1" name="mark-1">
                                                        <label for="mark-1"> I would like to receive a mail when I don't have enough licenses for my remaining capital </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-left: auto">
                                                <div class="form-group" style="margin-bottom: 0">
                                                    <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                        <input type="checkbox" checked id="mark-2" name="mark-2">
                                                        <label for="mark-2"> I would like to receive a mail for evey weekly/monthly commissions payout </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-left: auto">
                                                <div class="form-group" style="margin-bottom: 0">
                                                    <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px;">
                                                        <input type="checkbox" checked id="mark-3" name="mark-3">
                                                        <label for="mark-3"> I would like to receive a mail when I do a withdrawal of my trading capital </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                    </span>

                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" align="right">
                            <div class="form-group">
                                <a href="javascript:void(0);"  class="btn btn-primary" id="mail_btn">Create</a>
                                <?php echo CHtml::link('Cancel', array('userInfo/admin'),
                                    array(
                                        'class' => 'btn btn-default'
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var required_inputs = ["#UserPayoutInfo_bank_name",/*"#UserPayoutInfo_account_name","#UserPayoutInfo_iban","#UserPayoutInfo_bic_code"*/];
    $(document).ready(function(){
        /*$('#UserInfo_business_name').hide();
        $("#UserInfo_vat_number").hide();
        var label = $("label[for='"+$('#UserInfo_vat_number').attr('id')+"']");
        label.hide();
        var label1 = $("label[for='"+$('#UserInfo_business_name').attr('id')+"']");
        label1.hide();
        $("#diff_address").hide();
        $("#check_box").hide();*/
        $("#company").hide();
        $("#companyAddress").hide();
    });

    showBusinessField();
    $("#Addresses_address_type").change(function (e) {
        showBusinessField();
    });

    $('#user-info-form input').on('change', function() {
        var value = ($('input[name=Business]:checked', '#user-info-form').val());
        if(value == 2){
            $("#company").show();
            if ($('#diff_address').is(":checked")){
                $("#companyAddress").show();
            }else{
                $("#companyAddress").hide();
            }
        }
        else{
            $("#company").hide();
        }

    });
    $('#diff_address').on('change', function() {
        if ($('#diff_address').is(":checked")){
            $("#companyAddress").show();
        }else{
            $("#companyAddress").hide();
        }
    });
    function showBusinessField() {
        if ($('#Addresses_address_type').val() == 1) {
            $('#business_company').show();
            $('#business_vat').show();
            /* Show Business dynamic fields */
            $('#business_fields').show();
        } else {
            $('#business_company').hide();
            $('#business_vat').hide();
            /* Hide Business dynamic fields */
            $('#business_fields').hide();
        }
    }

    $("form[id='user-info-form']").validate({
        debug: true,
        errorClass: "help-block",
        errorElement: "div",
        rules: {
            'UserInfo[first_name]':{
                required: true,
            },
            'UserInfo[last_name]':{
                required: true,
            },
            'UserInfo[email]': {
                required: true,
                email: true,
                remote: {
                    url: '<?php  echo Yii::app()->createUrl("/admin/userInfo/checkEmail");  ?>',
                    type: 'post',
                    data: {
                        'UserInfo[email]': function () {
                            return $('#UserInfo_email').val();
                        }
                    }
                }
            },
            'UserInfo[phone]':{
                required: true,
                number: true,
            },
            'UserInfo[date_of_birth]':{
                required: true,
            },
            'UserInfo[street]': {
                required: true
            },
            'UserInfo[building_num]': {
                required: true
            },
            'UserInfo[city]': {
                required: true
            },
            'UserInfo[postcode]': {
                required: true,
                //number: true
            },
            'UserInfo[country]': {
                required: true
            },
            'UserInfo[language]':{
                required:true
            },
            'UserInfo[password]': {
                required: true,
                custompassword: true
            },
            'UserInfo[business_name]': {
                required: true
            },
            'UserInfo[busAddress_street]': {
                required: true
            },
            'UserInfo[busAddress_building_num]': {
                required: true
            },
            'UserInfo[busAddress_city]': {
                required: true
            },
            'UserInfo[busAddress_postcode]': {
                required: true
                //number: true
            },
            'UserInfo[rank]': {
                required: true
            },
        },
        messages:{
            'UserInfo[first_name]': {
                required: "Please enter first name.",
            },
            'UserInfo[last_name]': {
                required: "Please enter last name.",
            },
            'UserInfo[email]': {
                required: "Please enter email.",
                email: "Please enter valid email.",
                remote: "Email already exist in System."
            },
            'UserInfo[phone]':{
                required: "Please enter phone number.",
                number: "it contains only numbers.",
            },
            'UserInfo[date_of_birth]': {
                required: "Please select your date of birth."
            },
            'UserInfo[street]': {
                required: "Please enter street name."
            },
            'UserInfo[building_num]': {
                required: "Please enter house number."
            },
            'UserInfo[city]': {
                required: "Please enter city name."
            },
            'UserInfo[postcode]': {
                required: "Please enter postal code.",
                //number: "Postcode must be number."
            },
            'UserInfo[country]': {
                required: "Please select country."
            },
            'UserInfo[language]': {
                required: "Please select language."
            },
            'UserInfo[password]': {
                required: "Please enter password.",
            },
            'UserInfo[business_name]': {
                required: "Please enter company Name."
            },
            'UserInfo[busAddress_street]': {
                required: "Please enter street name."
            },
            'UserInfo[busAddress_building_num]': {
                required: "Please enter house number."
            },
            'UserInfo[busAddress_city]': {
                required: "Please enter city name."
            },
            'UserInfo[busAddress_postcode]': {
                required: "Please enter postal code.",
                //number: "Postcode must be number."
            },
            'UserInfo[busAddress_country]': {
                required: "Please select country."
            },
            'UserInfo[rank]': {
                required: "Please select rank."
            },
        },
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            $(element).parent().parent().addClass('has-error');
            //$('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).parent().parent().removeClass('has-error');
        },
        submitHandler:function (form) {
            $(".overlay").removeClass("hide");
            //var formData = new FormData($(form)[0]);
            $.ajax({
                url: '<?php  echo Yii::app()->createUrl('admin/userInfo/create');  ?>',
                type: "post",
                data: $(form).serializeArray(),
                success: function(response) {
                    var result = JSON.parse(response);
                    if(result.token == 0){
                        $("#userAddError").show().delay(5000).fadeOut();
                    }else{
                        $("#userSucc").show().delay(5000).fadeOut();
                    }
                    if(result.result == true){
                        //console.log(result);
                        $(".overlay").addClass("hide");
                        $('#payout_tab').removeClass('disabledTab');
                        $('#email_tab').removeClass('disabledTab');
                        $('#Payout_uid').val(result.userId);
                        $('#status_uid').val(result.userId);
                        $('#Email_uid').val(result.userId);
                        $('#profile_tab').removeClass('active');
                        $('#user-profile').removeClass('active');
                        $('#payout_tab').addClass('active');
                        $('#user-payout').addClass('active');
                    }
                },

            });
        }
    });


    //$("body").on('keyup','#UserPayoutInfo_bank_name,#UserPayoutInfo_account_name,#UserPayoutInfo_iban,#UserPayoutInfo_bic_code',function () {
    $("body").on('keyup','#UserPayoutInfo_bank_name',function () {
        validateFields();
    });

    $("body").on('click','#pay_btn',function () {
        if (validateFields()) {
            $.ajax({
                url: "<?php  echo Yii::app()->createUrl('admin/userInfo/create');  ?>",
                type: "post",
                data: $('#payout-info-form').serializeArray(),
                success: function (response) {
                    var databaseRes = JSON.parse(response);
                    if (databaseRes.result == true) {
                        $('#payoutError').css('display', 'none');
                        $("#payoutSucc").show().delay(5000).fadeOut();
                        $('#payout_tab').removeClass('active');
                        $('#user-payout').removeClass('active');
                        $('#email_tab').addClass('active');
                        $('#user-email').addClass('active');
                    }
                }

            });
        }
    });
    $("body").on('click','#mail_btn',function () {
        $.ajax({
            url: "<?php  echo Yii::app()->createUrl('admin/userInfo/create');  ?>",
            type: "post",
            data: $('#mail-setting').serializeArray(),
            success: function(response) {
                var databaseRes = JSON.parse(response);
                if(databaseRes.result == true){
                    $('#emailError').css('display','none');
                    $("#emailSucc").show().delay(5000).fadeOut();
                }
            }

        });
    });

    //custom validation rule
    $.validator.addMethod("custompassword",
        function (value, element) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/.test(value);
        },
        "Please enter minimum 8 digit with capital,small and number."
    );

    function validateFields(){
        var output = true;
        for(x in required_inputs){
            if($(required_inputs[x]).val() === null || $(required_inputs[x]).val() == 0){
                output = output & false;
                $(required_inputs[x]).addClass("error");
                if($(required_inputs[x]).parent().find(".error_label").length == 0){
                    if(required_inputs[x] == "#UserPayoutInfo_bank_name"){
                        $(required_inputs[x]).parent().append('<label class="error error_label help-block" for="name">Please Enter Bank name</label>');
                    }
                    /*if(required_inputs[x] == "#UserPayoutInfo_account_name"){
                        $(required_inputs[x]).parent().append('<label class="error error_label help-block" for="name">Please Enter Account name</label>');
                    }if(required_inputs[x] == "#UserPayoutInfo_iban"){
                        $(required_inputs[x]).parent().append('<label class="error error_label help-block" for="name">Please Enter IBAN</label>');
                    }if(required_inputs[x] == "#UserPayoutInfo_bic_code"){
                        $(required_inputs[x]).parent().append('<label class="error error_label help-block" for="name">Please Enter BIC code</label>');
                    }*/
                    $(required_inputs[x]).parent().parent().addClass('has-error');
                }
            }
            else{
                $(required_inputs[x]).removeClass("error");
                if($(required_inputs[x]).parent().find(".error_label").length > 0){
                    $(required_inputs[x]).parent().find(".error_label").remove();
                    $(required_inputs[x]).parent().parent().removeClass('has-error');

                }
            }
        }
        return output;

    }

</script>