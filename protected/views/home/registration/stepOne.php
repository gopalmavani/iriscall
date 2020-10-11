<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="format-detection" content="telephone=no">
    <meta name="authoring-tool" content="Adobe_Animate_CC">
    <title>Iriscall</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/wizard-4.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/plugins.bundle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style.bundle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prismjs.bundle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/custom.css');
    ?>
    <style>
        .isDisabled {
            cursor: not-allowed;
            text-decoration: none;
            pointer-events: none;
        }
        #system-mail {
            display: none;
        }
        .showonhover:hover #system-mail {
            display: block;
        }
        #market-mail {
            display: none;
        }
        .showhover:hover #market-mail {
            display: block;
        }
        .form-control[readonly]{
            opacity: 0.7;
            cursor: no-drop;
        }
        .row {
            margin-left: -10px !important;
            margin-right: -10px !important;
        }
        .error{
            color:red;
        }
        .progress{
            width: auto;
            height: 20px;
            background: #ebedf2 !important;
        }
        .custom-control-label::before{
            position: fixed;
        }
        body{
            font-size: 15px;
        }
        .kt-wizard-v4 .kt-wizard-v4__nav .kt-wizard-v4__nav-items .kt-wizard-v4__nav-item {
            flex: 0 0 calc(33.4% - 0.25rem);
            width: calc(33% - 0.25rem);
        }
        .progress-bar-success{
            background-color: #007bff;
        }
        .progress-bar-danger{
            background-color: #bb321f;
        }
        .progress-bar-warning{
            background-color: #FFCC00;
        }
        .mb-10{
            margin-bottom:10px;
        }
        input[type="checkbox"] {
            margin-right: 10px;
        }
        .text-grey {
            color: #afb2b2 !important;
        }
        body{
            /*background-color: #56077E !important;
            background-image: url(<?= Yii::app()->baseUrl. '/images/bg-7.jpg'; ?>) !important;
            background-size: cover !important;
            background-attachment: fixed !important;
            background-repeat: no-repeat !important;*/
        }
        .kt-wizard-v4__nav-number{
            background-color: #256c9e !important;
        }
        .kt-wizard-v4__nav-label-title{
            color: #256c9e !important;
        }
    </style>
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="logo"><a href="#"><img src="<?= Yii::app()->baseUrl. '/images/logos/iriscall-logo.svg'; ?>" style="width: auto !important; height: 100px !important;"></a></div>
                    <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
                        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                            <div class="d-flex align-items-center flex-wrap mr-2">
                                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">New User</h5>
                                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                                <div class="d-flex align-items-center" id="kt_subheader_search">
                                    <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">Enter user details and submit</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Card-->
                            <div class="card card-custom card-transparent">
                                <div class="card-body p-0">
                                    <!--begin::Wizard-->
                                    <div class="wizard wizard-4" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="true">
                                        <div class="wizard-nav">
                                            <div class="wizard-steps">
                                                <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                                    <div class="wizard-wrapper">
                                                        <div class="wizard-number">1</div>
                                                        <div class="wizard-label">
                                                            <div class="wizard-title">Add Account</div>
                                                            <div class="wizard-desc">Add User Details</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="wizard-step" data-wizard-type="step">
                                                    <div class="wizard-wrapper">
                                                        <div class="wizard-number">2</div>
                                                        <div class="wizard-label">
                                                            <div class="wizard-title">Address</div>
                                                            <div class="wizard-desc">Personal and Business Addesses</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="wizard-step" data-wizard-type="step">
                                                    <div class="wizard-wrapper">
                                                        <div class="wizard-number">3</div>
                                                        <div class="wizard-label">
                                                            <div class="wizard-title">Payout Information</div>
                                                            <div class="wizard-desc">Bank details</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-custom card-shadowless rounded-top-0">
                                            <div class="card-body p-0">
                                                <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                                                    <div class="col-xl-12 col-xxl-10">
                                                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                                            'id' => 'kt_form',
                                                            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                                                            'enableAjaxValidation' => false,
                                                            'action'=> Yii::app()->createUrl('home/createUserSignup'),
                                                            'htmlOptions' => array(
                                                                'name' => 'UserCreate',
                                                                'class' => 'kt-form validation-wizard1'
                                                            )
                                                        )); ?>
                                                        <!--begin: Form Wizard Step 1-->
                                                        <div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
                                                            <h5 class="text-dark font-weight-bold mb-10">Enter your Account Details</h5>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group <?php echo $model->hasErrors('first_name') ? 'has-error' : ''; ?>">
                                                                        <?php echo $form->textFieldControlGroup($model, 'first_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'required' => true)); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group <?php echo $model->hasErrors('email') ? 'has-error' : ''; ?>">
                                                                        <?php echo $form->textFieldControlGroup($model, 'email', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'required' => true, 'id' => 'email')); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group  <?php echo $model->hasErrors('middle_name') ? 'has-error' : ''; ?>">
                                                                        <?php echo $form->textFieldControlGroup($model, 'middle_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group <?php echo $model->hasErrors('phone') ? 'has-error' : ''; ?>">
                                                                        <?php echo $form->textFieldControlGroup($model, 'phone', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group <?php echo $model->hasErrors('last_name') ? 'has-error' : ''; ?>">
                                                                        <?php echo $form->textFieldControlGroup($model, 'last_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'required' => true)); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Password<span>*</span></label>
                                                                        <input type="password" id="password" class="form-control" name="password" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group" id="confirm_password_group">
                                                                        <label for="confirm_password">Repeat
                                                                            Password<span>*</span></label>
                                                                        <input type="password" id="confirm_password"
                                                                               class="form-control" name="confirm_password">
                                                                        <div class="text-sm text-grey">Password Strength</div>
                                                                        <div class="progress progress-striped active">
                                                                            <div id="jak_pstrength" class="progress-bar"
                                                                                 role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                                 aria-valuemax="100" style="width: 0%"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <label style="margin-bottom: 10px;">Gender :</label>
                                                                    <div class="row mb1">
                                                                        <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                                                                            <div class="form-group">
                                                                                <div class="custom-radio">
                                                                                    <input type="radio" id="male" name="gender" checked
                                                                                           value="1">
                                                                                    <label class="custom-control-label" for="male">Male</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                                                                            <div class="form-group">
                                                                                <div class="custom-radio" style="width: max-content;">
                                                                                    <input type="radio" id="female" name="gender" value="2">
                                                                                    <label class="custom-control-label"
                                                                                           for="female">Female</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <label style="margin-bottom: 10px;">Account Type:</label>
                                                                    <div class="row mb1">
                                                                        <div class="col-4 col-sm-4 col-md-3 col-lg-3">
                                                                            <div class="form-group">
                                                                                <div class="custom-radio" style="width: max-content;">
                                                                                    <input type="radio" id="personal" name="accountType" checked
                                                                                           value="personal">
                                                                                    <label class="custom-control-label" for="personal">Personal</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4 col-sm-4 col-md-3 col-lg-3">
                                                                            <div class="form-group">
                                                                                <div class="custom-radio" style="width: max-content;">
                                                                                    <input type="radio" id="corporate" name="accountType" value="corporate">
                                                                                    <label class="custom-control-label"
                                                                                           for="corporate">Corporate</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!--end: Form Wizard Step 1-->
                                                        <!--begin: Form Wizard Step 2-->
                                                        <div class="my-5 step" data-wizard-type="step-content">
                                                            <h5 class="text-dark font-weight-bold mb-10">Setup Your Address</h5>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <?php echo $form->textFieldControlGroup($model, 'street', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'label' => 'Street Name')); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <?php echo $form->textFieldControlGroup($model, 'building_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'label' => 'House Number')); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <?php echo $form->textFieldControlGroup($model, 'city', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <?php echo $form->textFieldControlGroup($model, 'postcode', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'label' => 'Postal Code')); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <?php echo $form->textFieldControlGroup($model, 'region', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'label' => 'Region/State')); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <?php echo $form->dropDownListControlGroup($model, 'country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control', 'label' => 'Country ')); ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" id="business_details_check_id"
                                                                               name="business_details_check_id">
                                                                        <label class="custom-control-label text-normal"
                                                                               for="business_details_check_id">Add Business
                                                                            Details</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div id="business_detail" style="display: none">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group <?php echo $model->hasErrors('business_name') ? 'has-error' : ''; ?>">
                                                                            <?php echo $form->textFieldControlGroup($model, 'business_name', array('class' => 'form-control', 'label' => 'Business Name *')); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group <?php echo $model->hasErrors('vat_number') ? 'has-error' : ''; ?>">
                                                                            <?php echo $form->textFieldControlGroup($model, 'vat_number', array('size' => 50, 'class' => 'form-control', 'label' => 'Vat Number *')); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="sameAddress"
                                                                                   name="sameAddress" checked>
                                                                            <label class="custom-control-label text-normal"
                                                                                   for="sameAddress">Same Address</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div id="business_address" style="display: none">
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <div class="form-group <?php echo $model->hasErrors('busAddress_street') ? 'has-error' : ''; ?>">
                                                                                <?php echo $form->textFieldControlGroup($model, 'busAddress_street', array('class' => 'form-control', 'label' => 'Street *')); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <div class="form-group <?php echo $model->hasErrors('busAddress_building_num') ? 'has-error' : ''; ?>">
                                                                                <?php echo $form->textFieldControlGroup($model, 'busAddress_building_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'label' => 'House Number *')); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <div class="form-group <?php echo $model->hasErrors('busAddress_city') ? 'has-error' : ''; ?>">
                                                                                <?php echo $form->textFieldControlGroup($model, 'busAddress_city', array('class' => 'form-control', 'label' => 'City *')); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <div class="form-group <?php echo $model->hasErrors('busAddress_postcode') ? 'has-error' : ''; ?>">
                                                                                <?php echo $form->textFieldControlGroup($model, 'busAddress_postcode', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'label' => 'Postal Code *')); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <div class="form-group <?php echo $model->hasErrors('busAddress_region') ? 'has-error' : ''; ?>">
                                                                                <?php echo $form->textFieldControlGroup($model, 'busAddress_region', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'label' => 'Region')); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <div class="form-group <?php echo $model->hasErrors('busAddress_country') ? 'has-error' : ''; ?>">
                                                                                <?php echo $form->dropDownListControlGroup($model, 'busAddress_country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control', 'label' => 'Country *')); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end: Form Wizard Step 2-->
                                                        <!--begin: Form Wizard Step 3-->
                                                        <div class="my-5 step" data-wizard-type="step-content">
                                                            <h5 class="text-dark font-weight-bold mb-10">Enter your Payment Details</h5>
                                                            <div class="row mb2 mb-10">
                                                                <div class="col-md-12">
                                                                    <div class="custom-control custom-checkbox agree">
                                                                        <input type="checkbox" id="payoutDetailsId"
                                                                               name="payoutDetailsId">
                                                                        <label class="custom-control-label text-normal"
                                                                               for="payoutDetailsId">I would like to add payout
                                                                            details</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="payoutDetails" style="display: none">
                                                                <div class="row mb3">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="bank">Bank Name<span>*</span></label>
                                                                            <input type="text" id="bank" class="form-control"
                                                                                   name="payout_bank">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="account">Account Name<span>*</span></label>
                                                                            <input type="text" id="account" class="form-control"
                                                                                   name="payout_accountname">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="iban">IBAN<span>*</span></label>
                                                                            <input type="text" id="iban" class="form-control"
                                                                                   name="payout_iban">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="bic">BIC Code<span>*</span></label>
                                                                            <input type="text" id="bic" class="form-control"
                                                                                   name="payout_biccode">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-xl-6">
                                                                        <div class="form-group">
                                                                            <label for="payout_street">Street Name</label>
                                                                            <input type="text" id="bankstreet"
                                                                                   class="form-control" name="payout_street">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-xl-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group">
                                                                                    <label for="payout_house">House No.</label>
                                                                                    <input type="text" id="bankhouse"
                                                                                           class="form-control"
                                                                                           name="payout_house">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group">
                                                                                    <label for="bankpost">Postal Code</label>
                                                                                    <input type="text" id="bankpost"
                                                                                           class="form-control"
                                                                                           name="payout_post">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="payout_city">City</label>
                                                                            <input type="text" id="bankcity" class="form-control"
                                                                                   name="payout_city">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="payout_region">Region</label>
                                                                            <input type="text" id="bankregion" class="form-control"
                                                                                   name="payout_region">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb3">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="payout_country">Country</label>
                                                                            <select name="payout_country" id="bankcountry"
                                                                                    class="form-control">
                                                                                <?php
                                                                                $country = Yii::app()->ServiceHelper->getCountry(); ?>
                                                                                <option value="">Select Country</option>
                                                                                <?php foreach ($country as $key => $value) { ?>
                                                                                    <option value="<?php echo $key; ?>"><?php echo $value ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb2">
                                                                <div class="col-md-12">
                                                                    <div class="checkbox-single custom-control">
                                                                        <label class="checkbox mb-2">
                                                                            <input type="checkbox" id="privacy" name="privacy">I accept the <a target="_blank" href="https://www.cbmglobal.io/legal/terms-conditions.html">privacy
                                                                                policy</a>
                                                                            <span>*</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end: Form Wizard Step 3-->
                                                        <div class="d-flex justify-content-between border-top pt-10 mt-15">
                                                            <div class="mr-2">
                                                                <button type="button" id="prev-step" class="btn btn-light-primary font-weight-bolder px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                                            </div>
                                                            <div>
                                                                <button type="button" class="btn btn-success font-weight-bolder px-9 py-4" data-wizard-type="action-submit">Submit</button>
                                                                <button type="button" id="next-step" class="btn btn-primary font-weight-bolder px-9 py-4" data-wizard-type="action-next">Next</button>
                                                            </div>
                                                        </div>
                                                        <?php $this->endWidget(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#0BB783", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#D7F9EF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };
</script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins.bundle.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/prismjs.bundle.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/scripts.bundle.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/add-user.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jaktutorial.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/jquery.validate.min.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/wizard.js');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/toastr/toastr.js');
?>

<script type="text/javascript">
    var currentTab = 1;
    $(document).ready(function () {

        var sioData = "<?= $sioData; ?>";
        if(sioData == 1){
            $('#email').prop("readonly", true);
            $('#confirm_email_group').css("display", "none");
            $('#password_group').css("display", "none");
            $('#confirm_password_group').css("display", "none");
            disable_if_present(['#UserInfo_first_name', '#UserInfo_country', '#UserInfo_phone', '#UserInfo_middle_name',
                '#UserInfo_date_of_birth', '#UserInfo_last_name', '#UserInfo_street', '#UserInfo_building_num', '#UserInfo_postcode',
                '#UserInfo_city', '#UserInfo_region', '#UserInfo_business_name', '#UserInfo_vat_number', '#UserInfo_busAddress_country',
                '#UserInfo_busAddress_street', '#UserInfo_busAddress_building_num', '#UserInfo_busAddress_postcode', '#UserInfo_busAddress_city',
                '#UserInfo_busAddress_region', '#password']);
        }

        if($('#email').val()){
            $('#email').prop("readonly", true);
            $('#confirm_email').val($('#email').val());
            $('#confirm_email').prop("readonly", true);
        }

        $('.btnCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
        /*$('#UserInfo_date_of_birth').bootstrapMaterialDatePicker(
            {
                maxDate: new Date(),
                format: 'LL',
                time: false
            }
        );*/
        //var accountType = "<?php //echo $_GET['accountType']; ?>";
        //$('#accountType').val(accountType);

        $("#password").keyup(function () {
            passwordStrength($(this).val());
        });
        $("#email").keyup(function () {
            var email = $(this).val();
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            var rs = regex.test(email);
            if (rs) {
                $('#custom_mail_checker').hide();
            } else {
                $('#custom_mail_checker').show();
            }
        });

        /*jQuery.validator.addMethod("visibleEmailEquals", function(value, element) {
            if(element.id == 'confirm_email'){
                if($('#confirm_email').is(":visible")){
                    if($('#confirm_email').val() == $('#email').val()){
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            }
        }, "The Email you entered doesn’t match.");
        jQuery.validator.addMethod("visiblePasswordEquals", function(value, element) {
            if(element.id == 'confirm_password'){
                if($('#confirm_password').is(":visible")){
                    if($('#confirm_password').val() == $('#password').val()){
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            }
        }, "The Password you entered doesn’t match.");
        var validator = $(".validation-wizard1").validate({
            ignore: ".ignore",
            errorClass: "text-danger",
            errorElement: "span",
            successClass: "text-success",
            highlight: function (element, errorClass) {
                $(element).parent().parent().addClass(errorClass);
            },
            unhighlight: function (element, errorClass) {
                $(element).parent().parent().removeClass(errorClass);
            },
            errorPlacement: function (error, element) {
                jQuery(element).parents('.form-group').append(error);
            },
            submitHandler: function (form) {
                console.log("INside Handler");
                return false;
            },
            rules: {
                'UserInfo[first_name]': {
                    required: true
                },
                'UserInfo[last_name]': {
                    required: true
                },
                'UserInfo[email]': {
                    required: true,
                    email: true,
                    remote: {
                        url: '',
                        type: 'post',
                        data: {
                            'UserInfo[email]': function () {
                                return $('#email').val();
                            }
                        }
                    }
                },
                'confirm_email': {
                    required: "#confirm_email:visible",
                    visibleEmailEquals: true
                },
                'UserInfo[phone]': {
                    required: true,
                    number: true,
                },
                'UserInfo[date_of_birth]': {
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
                },
                'UserInfo[country]': {
                    required: true
                },
                'password': {
                    required: "#password:visible",
                },
                'UserInfo[business_name]': {
                    required: "#UserInfo_business_name:visible"
                },
                'UserInfo[vat_number]': {
                    required: "#UserInfo_vat_number:visible"
                },
                'confirm_password': {
                    required: "#confirm_password:visible",
                    visiblePasswordEquals: true
                    //equalTo: '#password'
                },
                'UserInfo[busAddress_street]': {
                    required: "#UserInfo_busAddress_street:visible"
                },
                'UserInfo[busAddress_building_num]': {
                    required: "#UserInfo_busAddress_building_num:visible"
                },
                'UserInfo[busAddress_city]': {
                    required: "#UserInfo_busAddress_city:visible"
                },
                'UserInfo[busAddress_postcode]': {
                    required: "#UserInfo_busAddress_postcode:visible",
                },
                'UserInfo[busAddress_country]': {
                    required: "#UserInfo_busAddress_country:visible"
                },
                'payout_bank': {
                    required: "#bank:visible"
                },
                'payout_accountname': {
                    required: "#account:visible"
                },
                'payout_biccode': {
                    required: "#bic:visible"
                },
                'payout_iban': {
                    required: "#iban:visible"
                },
                'privacy': {
                    required: "#privacy:visible"
                },
                'payout_street': {
                    required: function () {
                        if($('#payoutDetailsId').is(":checked")){
                            return !checkIfInEU();
                        } else {
                            return false;
                        }
                    }
                },
                'payout_house': {
                    required: function () {
                        if($('#payoutDetailsId').is(":checked")){
                            return !checkIfInEU();
                        } else {
                            return false;
                        }
                    }
                },
                'payout_city': {
                    required: function () {
                        if($('#payoutDetailsId').is(":checked")){
                            return !checkIfInEU();
                        } else {
                            return false;
                        }
                    }
                },
                'payout_post': {
                    required: function () {
                        if($('#payoutDetailsId').is(":checked")){
                            return !checkIfInEU();
                        } else {
                            return false;
                        }
                    }
                },
                'payout_region': {
                    required: function () {
                        if($('#payoutDetailsId').is(":checked")){
                            return !checkIfInEU();
                        } else {
                            return false;
                        }
                    }
                },
                'payout_country': {
                    required: function () {
                        if($('#payoutDetailsId').is(":checked")){
                            return !checkIfInEU();
                        } else {
                            return false;
                        }
                    }
                }
            },
            messages: {
                'UserInfo[first_name]': {
                    required: "Please enter first name.",
                },
                'UserInfo[last_name]': {
                    required: "Please enter last name.",
                },
                'UserInfo[email]': {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                    remote: "Email Already Exist in System. Please login"
                },
                'confirm_email': {
                    required: "Please enter confirm email.",
                    //equalTo: "The Email you entered doesn’t match."
                },
                'UserInfo[phone]': {
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
                    required: "Please enter postcode.",
                },
                'UserInfo[country]': {
                    required: "Please select country."
                },
                'password': {
                    required: "Please enter password.",
                },
                'confirm_password': {
                    required: "Please enter confirm password.",
                    //equalTo: "The Password you entered doesn’t match."
                },
                'UserInfo[business_name]': {
                    required: "Please enter Company Name."
                },
                'UserInfo[vat_number]': {
                    required: "Please enter Vat number."
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
                },
                'UserInfo[busAddress_country]': {
                    required: "Please select country."
                },
                'payout_bank': {
                    required: "Please enter bank name."
                },
                'privacy': {
                    required: "Please accept the privacy policy"
                },
                'payout_biccode': {
                    required: "Please enter biccode."
                },
                'payout_iban': {
                    required: "Please enter Iban."
                },
                'payout_street': {
                    required: "Please enter street."
                },
                'payout_house': {
                    required: "Please enter house number."
                },
                'payout_city': {
                    required: "Please enter city."
                },
                'payout_post': {
                    required: "Please enter post code."
                },
                'payout_region': {
                    required: "Please enter region."
                },
                'payout_country': {
                    required: "Please enter country."
                }
            }
        });
        console.log(validator.errorList);*/
    });

    function disable_if_present(selectorArr){
        $.each(selectorArr, function (index, value) {
            if($(value).val()){
                $(value).prop("readonly", true);
            }
        });
    }

    //Update the current tab
    $('.nav-link').on('click', function () {
        var navId = $(this).attr('id');
        if(navId === 'step1_reg'){
            currentTab = 1;
        }
        if(navId === 'step2_reg'){
            currentTab = 2;
        }
        if(navId === 'step3_reg'){
            currentTab = 3;
        }
        updateTabs(navId);
    });

    function updateTabs(navId) {
        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('active');
        $('#'+navId).addClass('active');
        if(navId === 'step1_reg'){
            $('#st_reg_one').addClass('active');
        }
        if(navId === 'step2_reg'){
            $('#st_reg_two').addClass('active');
        }
        if(navId === 'step3_reg'){
            $('#st_reg_three').addClass('active');
        }
    }

    $('#business_details_check_id').on('change', function () {
        if (this.checked) {
            $('#business_detail').show();
        } else {
            $('#business_detail').hide();
        }
    });

    $('#sameAddress').on('change', function () {
        if (this.checked) {
            $('#business_address').hide();
        } else {
            $('#business_address').show();
        }
    });

    $('#payoutDetailsId').on('change', function () {
        if (this.checked) {
            $('#payoutDetails').show();
        } else {
            $('#payoutDetails').hide();
        }
    });

    /*
    * Check whether payout bank address details are required or not
    * based upon users country is from EU or not
    * */
    function checkIfInEU(){
        var europeanCountiesArray = [14,21,33,54,56,66,71,72,80,84,97,104,106,121,127,128,136,155,176,177,181,196,197,202,210];
        var userCountry = parseInt($('#UserInfo_country option:selected').val());
        if($.inArray(userCountry, europeanCountiesArray) >= 0){
            return true;
        } else {
            return false;
        }
    }

    function formValidation() {

    }
</script>

</body>
</html>