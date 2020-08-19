<?php

if(!isset($_SERVER['HTTP_REFERER'])){
    header("Location: https://www.cbmglobal.io/?signup=".$id);
}
else{
    $querystring = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
    if(empty($querystring)){
        header("Location: https://www.cbmglobal.io/?signup=".$id);
    }
}
?>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/css/newtheme/scss/icons/themify-icons/themify-icons.css" />
<style>
    element.style {
        box-shadow: 0 0 0 0;
    }
    hr{
        /*border: 0;*/
        margin-bottom: 10px;
    }
    @media screen and (max-width: 767px){
        .no-mobile{
            display: none;
        }
    }
    @media screen and (max-width: 768px){
        .wizard-content .wizard>.steps>ul>li {
            width: 33.33%;
        }

    }
    #password-strength-status {padding: 5px 10px;color: #FFFFFF; border-radius:4px;margin-top:5px;}
    .medium-password{background-color: #E4DB11;border:#BBB418 1px solid;}
    .weak-password{background-color: #FF6600;border:#AA4502 1px solid;}
    .strong-password{background-color: #12CC1A;border:#0FA015 1px solid;}
    #system-mail{
        display: none;
    }
    .showonhover:hover #system-mail {
        display: block;
    }
    #market-mail{
        display: none;
    }
    .showhover:hover #market-mail {
        display: block;
    }
    @media (max-width: 480px){
        .wizard-content .wizard>.steps>ul>li {
            width: 33.33%;
        }
    }
</style>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

<div id="main-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body wizard-content">
                        <div class="row" style="margin-top: 20px;">
                        </div>
                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'id' => 'users-info-form',
                            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array(
                                'name' => 'UserCreate',
                                'class' => 'validation-wizard1 wizard-circle wizard clearfix'
                            )
                        ));
                        ?>
                        <!-- Step 1 -->
                        <h6>Profile Information</h6>
                        <section>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('first_name') ? 'has-error' : ''; ?>">
                                                <?php echo $form->textFieldControlGroup($model, 'first_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'required'=>true)); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('middle_name') ? 'has-error' : ''; ?>">
                                                <?php echo $form->textFieldControlGroup($model, 'middle_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('last_name') ? 'has-error' : ''; ?>">
                                                <?php echo $form->textFieldControlGroup($model, 'last_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'required'=>true)); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('email') ? 'has-error' : ''; ?>">
                                                <?php echo $form->textFieldControlGroup($model, 'email', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'required'=>true, 'id' =>'email')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Email Confirmation *</label>
                                            <input type="text" id="confirm_email" class="form-control" name="confirm_email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-xs-12<?php echo $model->hasErrors('phone') ? 'has-error' : ''; ?>">
                                                <?php echo $form->textFieldControlGroup($model, 'phone', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-xs-12<?php echo $model->hasErrors('date_of_birth') ? 'has-error' : ''; ?>">
                                                <?php echo $form->textFieldControlGroup($model, 'date_of_birth', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <label class="control-label">Gender</label>
                                            <div class="form-check">
                                                <label class="custom-control custom-radio">
                                                    <input name="gender" type="radio" checked class="custom-control-input" value="1">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Male</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input name="gender" type="radio" class="custom-control-input" value="2">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Female</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('street') ? 'has-error' : ''; ?>">
                                                <?php echo $form->textFieldControlGroup($model, 'street', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label' =>'Street Name')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('building_num') ? 'has-error' : ''; ?>">
                                                <?php echo $form->textFieldControlGroup($model, 'building_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label' =>'House Number')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('region') ? 'has-error' : ''; ?>">
                                                <?php echo $form->textFieldControlGroup($model, 'region', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'Region/State')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('city') ? 'has-error' : ''; ?>">
                                                <?php echo $form->textFieldControlGroup($model, 'city', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('postcode') ? 'has-error' : ''; ?>">
                                                <?php echo $form->textFieldControlGroup($model, 'postcode', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'Postal Code')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('country') ? 'has-error' : ''; ?>">
                                                <?php echo $form->dropDownListControlGroup($model, 'country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('language') ? 'has-error' : ''; ?>">
                                                <?php echo $form->dropDownListControlGroup($model,'language', array('English'=>'English', 'Dutch'=>'Dutch', 'French'=>'French'), array('prompt' => 'Select Language', 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-xs-12 <?php echo $model->hasErrors('password') ? 'has-error' : ''; ?>">
                                                <?php echo $form->passwordFieldControlGroup($model, 'password', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'required'=>true,'id'=>'password')); ?>
                                            </div>
                                            <div id="password-strength-status"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Repeat Password *</label>
                                            <input type="password" id="confirm_password" class="form-control" name="confirm_password">
                                        </div>
                                        <span id='message'></span>
                                    </div>
                                </div>
                                <!--/row-->
                            </div>
                        </section>
                        <!-- Step 2 -->
                        <h6>Personal Or Business</h6>
                        <section>
                            <div class="col-md-12">
                                <div class="card-header" style="background: rgba(0,0,0,.03);border-color: rgba(0,0,0,.03); margin-bottom: 20px">
                                    <p>
                                        Your first step in the registration process is done, now please tell us whether you would like to register under personal name, or if you would like to register your business.
                                    </p>
                                    <p>
                                        Individuals will receive automated payouts from the cashback matrix etc. Business users are required to send an invoice to CBM.
                                    </p>
                                    <p>
                                        If you’re not sure now, don’t worry, you can always adjust this information in your profile settings at a later stage.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4  text-center">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="custom-control custom-radio">
                                                        <input id="radio1" name="radio" type="radio" checked class="custom-control-input" value="0">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Personal</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="radio2" name="radio" type="radio" class="custom-control-input" value="1">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Business</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                    <div id="business" style="display: none">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="col-xs-12 <?php echo $model->hasErrors('business_name') ? 'has-error' : ''; ?>">
                                                        <?php echo $form->textFieldControlGroup($model, 'business_name', array('class' => 'form-control','label' => 'Business Name *')); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="col-xs-12 <?php echo $model->hasErrors('vat_number') ? 'has-error' : ''; ?>">
                                                        <?php echo $form->textFieldControlGroup($model, 'vat_number', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-success">
                                                        <input id="checkbox1" type="checkbox" name="diff_address">
                                                        <label for="checkbox1"> Different Address </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="business-address">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-xs-12 <?php echo $model->hasErrors('busAddress_street') ? 'has-error' : ''; ?>">
                                                            <?php echo $form->textFieldControlGroup($model, 'busAddress_street', array('class' => 'form-control','label' => 'Street *')); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-xs-12 <?php echo $model->hasErrors('busAddress_building_num') ? 'has-error' : ''; ?>">
                                                            <?php echo $form->textFieldControlGroup($model, 'busAddress_building_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label' => 'House Number *')); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-xs-12 <?php echo $model->hasErrors('busAddress_region') ? 'has-error' : ''; ?>">
                                                            <?php echo $form->textFieldControlGroup($model, 'busAddress_region', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'Region/State')); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-xs-12 <?php echo $model->hasErrors('busAddress_city') ? 'has-error' : ''; ?>">
                                                            <?php echo $form->textFieldControlGroup($model, 'busAddress_city', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label' => 'City *')); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-xs-12 <?php echo $model->hasErrors('busAddress_postcode') ? 'has-error' : ''; ?>">
                                                            <?php echo $form->textFieldControlGroup($model, 'busAddress_postcode', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label' => 'Postal Code *')); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-xs-12 <?php echo $model->hasErrors('busAddress_country') ? 'has-error' : ''; ?>">
                                                            <?php echo $form->dropDownListControlGroup($model, 'busAddress_country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control','label' => 'Country *')); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Step 3 -->
                        <h6>Payout Information</h6>
                        <section>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="checkbox checkbox-success">
                                                <input id="payoutdetail" type="checkbox" name="payoutdetail">
                                                <label for="payoutdetail"> I want to add payout details </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="bank-detail">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Bank Name *</label>
                                                <input type="text" id="bank" class="form-control" name="payout_bank">
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin-bottom: 15px">
                                            <div class="form-group">
                                                <label class="control-label">Account Name </label>
                                                <input type="text" id="account" class="form-control" name="payout_accountname">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6" style="margin-bottom: 15px">
                                            <div class="form-group">
                                                <label class="control-label">IBAN </label>
                                                <input type="text" id="iban" class="form-control" name="payout_iban">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">BIC Code </label>
                                                <input type="text" id="bic" class="form-control" name="payout_biccode">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin-bottom: 20px">
                                            <h3>Bank Address Detail</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Street</label>
                                                <input type="text" id="bankstreet" class="form-control" name="payout_street">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">House Number</label>
                                                <input type="text" id="bankhouse" class="form-control" name="payout_house">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Region</label>
                                                <input type="text" id="bankregion" class="form-control" name="payout_region">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">City</label>
                                                <input type="text" id="bankcity" class="form-control" name="payout_city">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Postal Code</label>
                                                <input type="text" id="bankpost" class="form-control" name="payout_post">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Country</label>
                                                <select  name="payout_country" id="bankcountry" class="form-control">
                                                    <?php
                                                    $country = Yii::app()->ServiceHelper->getCountry();?>
                                                    <option value="">Select Country</option>
                                                    <?php foreach ($country as $key => $value) { ?>
                                                        <option value="<?php echo $key;?>"><?php echo $value ?></option>
                                                    <?php  } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="checkbox checkbox-success">
                                                <input id="privacy" type="checkbox" name="privacy">
                                                <label for="privacy"> I accept the privacy policy * </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            If you would like to receive system mails updating you directly on activities in your system, you need to check the following box
                                        </p>
                                        <div class="form-group">
                                            <div class="checkbox checkbox-success">
                                                <input id="checkbox3" type="checkbox" name="notification-mail">
                                                <label for="checkbox3"> I would like to receive notification mails
                                                    <span class="showonhover">
                                                        <i class="fa fa-info-circle"></i>
                                                        <div class="col-md-12" id="system-mail" style="background: rgba(0,0,0,.03);border-color: rgba(0,0,0,.03); margin-bottom: 20px;">
                                                    <div class="row" style="margin-left: auto;">
                                                        <div class="form-group" style="margin-top: 10px;margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-1" name="sys-1">
                                                                <label for="sys-1"> I would like to receive a mail when I don't have enough licenses for my remaining capital </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-2" name="sys-2">
                                                                <label for="sys-2"> I would like to receive a mail for evey weekly/monthly commissions payout </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-3" name="sys-3">
                                                                <label for="sys-3"> I would like to receive a mail when I do a withdrawal of my trading capital </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-4" name="sys-4">
                                                                <label for="sys-4"> I would like to receive a mail when a first line affiliate registers to the system </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-5" name="sys-5">
                                                                <label for="sys-5"> I would like to receive a mail when a first line affiliate buys new licenses </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-6" name="sys-6">
                                                                <label for="sys-6"> I would like to receive a mail when a first line affiliate places new nodes </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-7" name="sys-7">
                                                                <label for="sys-7"> I would like to receive a mail when a second line affiliate registers to the system </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-8" name="sys-8">
                                                                <label for="sys-8"> I would like to receive a mail when a first line affiliate buys new licenses </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-9" name="sys-9">
                                                                <label for="sys-9"> I would like to receive a mail when a first line affiliate places new nodes </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-10" name="sys-10">
                                                                <label for="sys-10"> I would like to receive a mail when a second line affiliate registers to the system </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-11" name="sys-11">
                                                                <label for="sys-11"> I would like to receive a mail when a second line affiliate buys new licenses </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-12" name="sys-12">
                                                                <label for="sys-12"> I would like to receive a mail when a second line affiliate places new nodes </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-13" name="sys-13">
                                                                <label for="sys-13"> I would like to receive a mail when a client deposit has been detected in my matrix </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-14" name="sys-14">
                                                                <label for="sys-14"> I would like to receive a mail when there is a spillover in my matrix </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
                                                                <input type="checkbox" checked id="sys-15" name="sys-15">
                                                                <label for="sys-15"> I would like to receive a mail when there is withdrawal by a client in my matrix </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: auto">
                                                        <div class="form-group" style="margin-bottom: 0">
                                                            <div class="checkbox checkbox-success">
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
                                                <input id="checkbox4" type="checkbox" name="market-mail">
                                                <label for="checkbox4"> I would like to receive marketing mails
                                                    <span class="showhover">
                                                        <i class="fa fa-info-circle"></i>
                                                        <div class="col-md-12" id="market-mail" style="background: rgba(0,0,0,.03);border-color: rgba(0,0,0,.03); margin-bottom: 20px;">
                                            <div class="row" style="margin-left: auto">
                                                <div class="form-group" style="margin-top: 10px;margin-bottom: 0">
                                                    <div class="checkbox checkbox-success">
                                                        <input type="checkbox" checked id="mark-1" name="mark-1">
                                                        <label for="mark-1"> I would like to receive a mail when I don't have enough licenses for my remaining capital </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-left: auto">
                                                <div class="form-group" style="margin-bottom: 0">
                                                    <div class="checkbox checkbox-success">
                                                        <input type="checkbox" checked id="mark-2" name="mark-2">
                                                        <label for="mark-2"> I would like to receive a mail for evey weekly/monthly commissions payout </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-left: auto">
                                                <div class="form-group" style="margin-bottom: 0">
                                                    <div class="checkbox checkbox-success">
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
                        </section>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
//$this->widget('zii.widgets.jui.CJuiDatePicker', array(
//    'model' => $model,
//    'attribute' => 'date_of_birth',
//    //'value'=>$model->dateOfBirth,
//    // additional javascript options for the date picker plugin
//    'options' => array(
//        'showAnim' => '',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
//        'dateFormat' => 'yy-mm-dd',
//        'maxDate' => date('Y-m-d'),
//        'changeYear' => true,           // can change year
//        'changeMonth' => true,
//        'yearRange' => '1900:' . date('Y'),
//    ),
//    'htmlOptions' => array(
//        'class' => 'form-control',
//        'readOnly' => true
//        //'style'=>'height:20px;background-color:green;color:white;',
//    ),
//));
//?>
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/moment/moment.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#UserInfo_date_of_birth').bootstrapMaterialDatePicker({maxDate: new Date(),time:false});
        $('#password').keyup(function(){
            checkPasswordStrength();
        });
        $("#bank-detail").hide();
    });

    function checkPasswordStrength() {
        var number = /([0-9])/;
        var alphabets = /([a-z])/;
        var special_characters = /([A-Z])/;
        if($('#password').val().length<8) {
            $('#password-strength-status').removeClass();
            $('#password-strength-status').addClass('weak-password');
            $('#password-strength-status').html("Weak (should be atleast 8 characters with capital,small and number.)");
            return false;
        } else {
            if($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)) {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('strong-password');
                $('#password-strength-status').html("Strong");
            } else {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('medium-password');
                $('#password-strength-status').html("Medium (Please enter atleast 8 characters including atleast 1 upprcase ,1 lower case and a number.)");
                return false;
            }
        }
    }

</script>
