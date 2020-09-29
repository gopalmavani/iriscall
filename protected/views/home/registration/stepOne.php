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
    <title>Micromaxcash</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <?php
    /*Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/bootstrap.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/registrationStyle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/registrationResponsive.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jaktutorial.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/animate/animate.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');*/
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/plugins.bundle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style.bundle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/custom.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/signup.css');
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
            background-color: #56077E !important;
            background-image: url(<?= Yii::app()->baseUrl. '/images/bg-7.jpg'; ?>) !important;
            background-size: cover !important;
            background-attachment: fixed !important;
            background-repeat: no-repeat !important;
        }
    </style>
</head>
<body id="kt_body" class="header-fixed subheader-enabled page-loading">


<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid" id="kt_wrapper">

            <!-- begin:: Header -->
            <div class="logo"><a href="signin.php"><img src="<?= Yii::app()->baseUrl. '/images/logos/logo-8.png'; ?>" style="width: auto !important; height: 100px !important;"></a></div>
            <!-- end:: Header -->

            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid">
                <div class="kt-wizard-v4" id="kt_wizard_v4" data-ktwizard-state="step-first">

                    <!--begin: Form Wizard Nav -->
                    <div class="kt-wizard-v4__nav">

                        <!--doc: Remove "kt-wizard-v4__nav-items--clickable" class and also set 'clickableSteps: false' in the JS init to disable manually clicking step titles -->
                        <div class="kt-wizard-v4__nav-items kt-wizard-v4__nav-items--clickable">
                            <div class="kt-wizard-v4__nav-item" data-ktwizard-type="step" data-ktwizard-state="current">
                                <div class="kt-wizard-v4__nav-body">
                                    <div class="kt-wizard-v4__nav-number"> 1 </div>
                                    <div class="kt-wizard-v4__nav-label">
                                        <div class="kt-wizard-v4__nav-label-title"> Add Account </div>
                                        <div class="kt-wizard-v4__nav-label-desc"> Add User Details </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-wizard-v4__nav-item" data-ktwizard-type="step">
                                <div class="kt-wizard-v4__nav-body">
                                    <div class="kt-wizard-v4__nav-number"> 2 </div>
                                    <div class="kt-wizard-v4__nav-label">
                                        <div class="kt-wizard-v4__nav-label-title"> Your Address </div>
                                        <div class="kt-wizard-v4__nav-label-desc"> Add Your Address </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-wizard-v4__nav-item" data-ktwizard-type="step">
                                <div class="kt-wizard-v4__nav-body">
                                    <div class="kt-wizard-v4__nav-number"> 3 </div>
                                    <div class="kt-wizard-v4__nav-label">
                                        <div class="kt-wizard-v4__nav-label-title"> Payout Information </div>
                                        <div class="kt-wizard-v4__nav-label-desc"> Add Payout Information </div>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="kt-wizard-v4__nav-item" data-ktwizard-type="step">
                                <div class="kt-wizard-v4__nav-body">
                                    <div class="kt-wizard-v4__nav-number"> 4 </div>
                                    <div class="kt-wizard-v4__nav-label">
                                        <div class="kt-wizard-v4__nav-label-title"> Completed </div>
                                        <div class="kt-wizard-v4__nav-label-desc"> Review and Submit </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>

                    <!--end: Form Wizard Nav -->
                    <div class="kt-portlet">
                        <div class="kt-portlet__body kt-portlet__body--fit">
                            <div class="kt-grid">
                                <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">

                                    <!--begin: Form Wizard Form-->
                                    <!--<form class="kt-form" id="kt_form">-->
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
                                        <div class="kt-wizard-v4__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                            <div class="kt-heading kt-heading--md">Enter your Account Details</div>
                                            <div class="kt-form__section kt-form__section--first">
                                                <div class="kt-wizard-v4__form">
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
                                                            <div class="form-group <?php echo $model->hasErrors('language') ? 'has-error' : ''; ?>">
                                                                <?php echo $form->dropDownListControlGroup($model, 'language', array('English' => 'English', 'Dutch' => 'Dutch', 'French' => 'French'), array('prompt' => 'Select Language', 'class' => 'form-control')); ?>
                                                            </div>
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
                                            </div>
                                        </div>
                                        <!--end: Form Wizard Step 1-->

                                        <!--begin: Form Wizard Step 2-->
                                        <div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
                                            <div class="kt-heading kt-heading--md">Setup Your Address</div>
                                            <div class="kt-form__section kt-form__section--first">
                                                <div class="kt-wizard-v4__form">
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <?php echo $form->textFieldControlGroup($model, 'street', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control ignore', 'label' => 'Street Name')); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <?php echo $form->textFieldControlGroup($model, 'building_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control ignore', 'label' => 'House Number')); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <?php echo $form->textFieldControlGroup($model, 'city', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control ignore')); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <?php echo $form->textFieldControlGroup($model, 'postcode', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control ignore', 'label' => 'Postal Code')); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <?php echo $form->textFieldControlGroup($model, 'region', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control ignore', 'label' => 'Region/State')); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <?php echo $form->dropDownListControlGroup($model, 'country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control ignore', 'label' => 'Country ')); ?>
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
                                                                    <?php echo $form->textFieldControlGroup($model, 'business_name', array('class' => 'form-control ignore', 'label' => 'Business Name *')); ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group <?php echo $model->hasErrors('vat_number') ? 'has-error' : ''; ?>">
                                                                    <?php echo $form->textFieldControlGroup($model, 'vat_number', array('size' => 50, 'class' => 'form-control ignore', 'label' => 'Vat Number *')); ?>
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
                                                                        <?php echo $form->textFieldControlGroup($model, 'busAddress_street', array('class' => 'form-control ignore', 'label' => 'Street *')); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group <?php echo $model->hasErrors('busAddress_building_num') ? 'has-error' : ''; ?>">
                                                                        <?php echo $form->textFieldControlGroup($model, 'busAddress_building_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control ignore', 'label' => 'House Number *')); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group <?php echo $model->hasErrors('busAddress_city') ? 'has-error' : ''; ?>">
                                                                        <?php echo $form->textFieldControlGroup($model, 'busAddress_city', array('class' => 'form-control ignore', 'label' => 'City *')); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group <?php echo $model->hasErrors('busAddress_postcode') ? 'has-error' : ''; ?>">
                                                                        <?php echo $form->textFieldControlGroup($model, 'busAddress_postcode', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control ignore', 'label' => 'Postal Code *')); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group <?php echo $model->hasErrors('busAddress_region') ? 'has-error' : ''; ?>">
                                                                        <?php echo $form->textFieldControlGroup($model, 'busAddress_region', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control ignore', 'label' => 'Region')); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group <?php echo $model->hasErrors('busAddress_country') ? 'has-error' : ''; ?>">
                                                                        <?php echo $form->dropDownListControlGroup($model, 'busAddress_country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control ignore', 'label' => 'Country *')); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end: Form Wizard Step 2-->

                                        <!--begin: Form Wizard Step 3-->
                                        <div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
                                            <div class="kt-heading kt-heading--md">Enter your Payment Details</div>
                                            <div class="kt-form__section kt-form__section--first">
                                                <div class="kt-wizard-v4__form">
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
                                                                    <input type="text" id="bank" class="form-control ignore"
                                                                           name="payout_bank">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="account">Account Name<span>*</span></label>
                                                                    <input type="text" id="account" class="form-control ignore"
                                                                           name="payout_accountname">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="iban">IBAN<span>*</span></label>
                                                                    <input type="text" id="iban" class="form-control ignore"
                                                                           name="payout_iban">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="bic">BIC Code<span>*</span></label>
                                                                    <input type="text" id="bic" class="form-control ignore"
                                                                           name="payout_biccode">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-6">
                                                                <div class="form-group">
                                                                    <label for="payout_street">Street Name</label>
                                                                    <input type="text" id="bankstreet"
                                                                           class="form-control ignore" name="payout_street">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-xl-6">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="payout_house">House No.</label>
                                                                            <input type="text" id="bankhouse"
                                                                                   class="form-control ignore"
                                                                                   name="payout_house">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="bankpost">Postal Code</label>
                                                                            <input type="text" id="bankpost"
                                                                                   class="form-control ignore"
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
                                                                    <input type="text" id="bankcity" class="form-control ignore"
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
                                                                            class="form-control ignore">
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
                                                            <div class="custom-control mb-10">
                                                                <p class="form-text text-muted text-sm text-grey">If you would like to receive
                                                                    notification mails updating you directly on activities in
                                                                    your system, you need to check the following box.</p>
                                                            </div>
                                                            <div class="custom-control custom-checkbox agree">
                                                                <input type="checkbox" id="checkbox3" name="notification-mail">
                                                                <label class="custom-control-label text-normal" for="checkbox3">I
                                                                    would like to receive notification mails
                                                                    <span class="showonhover"><i class="fa fa-info-circle"></i>
                                                                    <div class="col-md-12" id="system-mail"
                                                                         style="background: rgba(0,0,0,.03);border-color: rgba(0,0,0,.03); margin-bottom: 20px;">
                                                                        <div class="row" style="margin-left: auto;">
                                                                            <div class="form-group"
                                                                                 style="margin-top: 10px;margin-bottom: 0">
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
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-3" name="sys-3">
                                                                                    <label for="sys-3"> I would like to receive a mail when I do a withdrawal of my trading capital </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-4" name="sys-4">
                                                                                    <label for="sys-4"> I would like to receive a mail when a first line affiliate registers to the system </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-5" name="sys-5">
                                                                                    <label for="sys-5"> I would like to receive a mail when a first line affiliate buys new licenses </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-6" name="sys-6">
                                                                                    <label for="sys-6"> I would like to receive a mail when a first line affiliate places new nodes </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-7" name="sys-7">
                                                                                    <label for="sys-7"> I would like to receive a mail when a second line affiliate registers to the system </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-8" name="sys-8">
                                                                                    <label for="sys-8"> I would like to receive a mail when a first line affiliate buys new licenses </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-9" name="sys-9">
                                                                                    <label for="sys-9"> I would like to receive a mail when a first line affiliate places new nodes </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-10" name="sys-10">
                                                                                    <label for="sys-10"> I would like to receive a mail when a second line affiliate registers to the system </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-11" name="sys-11">
                                                                                    <label for="sys-11"> I would like to receive a mail when a second line affiliate buys new licenses </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-12" name="sys-12">
                                                                                    <label for="sys-12"> I would like to receive a mail when a second line affiliate places new nodes </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-13" name="sys-13">
                                                                                    <label for="sys-13"> I would like to receive a mail when a client deposit has been detected in my matrix </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-14" name="sys-14">
                                                                                    <label for="sys-14"> I would like to receive a mail when there is a spillover in my matrix </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group"
                                                                                 style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked
                                                                                           id="sys-15" name="sys-15">
                                                                                    <label for="sys-15"> I would like to receive a mail when there is withdrawal by a client in my matrix </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-left: auto">
                                                                            <div class="form-group" style="margin-bottom: 0">
                                                                                <div class="checkbox checkbox-success">
                                                                                    <input type="checkbox" checked id="sys-16"
                                                                                           name="sys-16">
                                                                                    <label for="sys-16"> I would like to receive a mail when the cashback earnings have been calculated </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox agree mb-10 mb2">
                                                                <p class="text-sm text-grey form-text text-muted">In order to keep receiving updates
                                                                    on the company or its products, please let us know here if
                                                                    you want to receive mails.</p>
                                                            </div>
                                                            <div class="custom-control custom-checkbox agree mb-10">
                                                                <input type="checkbox" id="checkbox4" name="market-mail">
                                                                <label class="custom-control-label text-normal" for="checkbox4">I
                                                                    would like to receive marketing mails
                                                                    <span class="showhover">
                                                                <i class="fa fa-info-circle"></i>
                                                                <div class="col-md-12" id="market-mail"
                                                                     style="background: rgba(0,0,0,.03);border-color: rgba(0,0,0,.03); margin-bottom: 20px;">
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
                                        </div>
                                        <!--end: Form Wizard Step 3-->

                                        <!--begin: Form Wizard Step 4-->
                                        <!--<div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
                                            <div class="kt-heading kt-heading--md">Review your Details and Submit</div>
                                            <div class="kt-form__section kt-form__section--first">
                                                <div class="kt-wizard-v4__review">
                                                    <div class="kt-wizard-v4__review-item">
                                                        <div class="kt-wizard-v4__review-title"> Your Account Details </div>
                                                        <div class="kt-wizard-v4__review-content"> John Wick<br />
                                                            Phone: +61412345678<br />
                                                            Email: johnwick@reeves.com </div>
                                                    </div>
                                                    <div class="kt-wizard-v4__review-item">
                                                        <div class="kt-wizard-v4__review-title"> Your Address Details </div>
                                                        <div class="kt-wizard-v4__review-content"> Address Line 1<br />
                                                            Address Line 2<br />
                                                            Melbourne 3000, VIC, Australia </div>
                                                    </div>
                                                    <div class="kt-wizard-v4__review-item">
                                                        <div class="kt-wizard-v4__review-title"> Payment Details </div>
                                                        <div class="kt-wizard-v4__review-content"> Card Number: xxxx xxxx xxxx 1111<br />
                                                            Card Name: John Wick<br />
                                                            Card Expiry: 01/21 </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->

                                        <!--end: Form Wizard Step 4-->

                                        <!--begin: Form Actions -->
                                        <div class="kt-form__actions">
                                            <button class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev"> Previous </button>
                                            <button type="submit" class="btn btn-primary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit"> Submit </button>
                                            <button class="btn btn-primary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next"> Next Step </button>
                                        </div>
                                        <!--end: Form Actions -->
                                    <?php $this->endWidget(); ?>
                                    <!--</form>-->
                                    <!--end: Form Wizard Form-->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end:: Content -->
        </div>
    </div>
</div>

<script type="text/javascript">
    let KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#044e80",
                "light": "#ffffff",
                "dark": "#5e5e5f",
                "primary": "#044e80",
                "success": "#5cb85c",
                "info": "#5bc0de",
                "warning": "#f0ad4e",
                "danger": "#d9534f"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins.bundle.js?v=7.0.4');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/prismjs.bundle.js?v=7.0.4');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/scripts.bundle.js?v=7.0.4');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/custom.js?v=7.0.4');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/toastr/toastr.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/wizard.js');

?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/jquery.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/popper.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/newtheme/bootstrap.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/animate/animate.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/jquery.validate.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jaktutorial.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/moment/moment.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');
?>

<script type="text/javascript">
    $(document).ready(function () {

        let sioData = "<?= $sioData; ?>";
        if(sioData == 1){
            $('#email').prop("readonly", true);
            $('#confirm_email_group').css("display", "none");
            $('#password_group').css("display", "none");
            $('#confirm_password_group').css("display", "none");
            disable_if_present(['#UserInfo_first_name', '#UserInfo_country', '#UserInfo_language', '#UserInfo_phone', '#UserInfo_middle_name',
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
    });

    function disable_if_present(selectorArr){
        $.each(selectorArr, function (index, value) {
            if($(value).val()){
                $(value).prop("readonly", true);
            }
        });
    }
</script>

<script type="text/javascript">
    let currentTab = 1;
    $(document).ready(function () {
        $('.btnCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
        $('#UserInfo_date_of_birth').bootstrapMaterialDatePicker(
            {
                maxDate: new Date(),
                format: 'LL',
                time: false
            }
        );
        //let accountType = "<?php //echo $_GET['accountType']; ?>";
        //$('#accountType').val(accountType);

        $("#password").keyup(function () {
            passwordStrength($(this).val());
        });
        $("#email").keyup(function () {
            let email = $(this).val();
            let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            let rs = regex.test(email);
            if (rs) {
                $('#custom_mail_checker').hide();
            } else {
                $('#custom_mail_checker').show();
            }
        });
    });

    //Update the current tab
    $('.nav-link').on('click', function () {
        let navId = $(this).attr('id');
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
        let europeanCountiesArray = [14,21,33,54,56,66,71,72,80,84,97,104,106,121,127,128,136,155,176,177,181,196,197,202,210];
        let userCountry = parseInt($('#UserInfo_country option:selected').val());
        if($.inArray(userCountry, europeanCountiesArray) >= 0){
            return true;
        } else {
            return false;
        }
    }

    function formValidation() {
        jQuery.validator.addMethod("visibleEmailEquals", function(value, element) {
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
        let validatior = $(".validation-wizard1").validate({
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
                switch (currentTab) {
                    case 1:
                        $('#st_reg_two input').removeClass('ignore');
                        $('#step2_reg').trigger('click');
                        updateTabs('step2_reg');
                        $('#step2_reg').removeClass('isDisabled');
                        currentTab = 2;
                        break;
                    case 2:
                        $('#st_reg_three input').removeClass('ignore');
                        $('#step3_reg').trigger('click');
                        updateTabs('step3_reg');
                        $('#step3_reg').removeClass('isDisabled');
                        currentTab = 3;
                        break;
                    case 3:
                        $(".finalSubmitBtn").attr("disabled", true);
                        form.submit();
                        break;
                }
            },
            rules: {
                'UserInfo[first_name]': {
                    required: true,
                },
                'UserInfo[last_name]': {
                    required: true,
                },
                'UserInfo[email]': {
                    required: true,
                    email: true,
                    remote: {
                        url: '<?php  echo Yii::app()->createUrl("home/checkEmail");  ?>',
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
                'UserInfo[language]': {
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
                    remote: "Email Already Exist in System."
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
                'UserInfo[language]': {
                    required: "Please select language."
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
                },
            }
        });
        console.log(validatior.errorList);
    }
</script>

</body>
</html>