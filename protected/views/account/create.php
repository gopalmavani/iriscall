<?php
$this->pageTitle = "Create Account";
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/wizard-1.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/credit-card/styles/skeuocard.reset.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/credit-card/styles/skeuocard.css');
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/credit-card/styles/demo.css');
?>
<style>
    .datepicker{
        width: unset;
    }
    .dz-remove{
        color: red !important;
        font-size: 12px !important;
    }
    .wrapper {
        margin: 0;
        position: relative;
        width: 400px;
        height: 200px;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .sepa-signature-pad {
        position: absolute;
        left: 0;
        top: 0;
        width:400px;
        height:200px;
        background-color: white;
    }
</style>
<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">New Account</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="<?= Yii::app()->createUrl('telecom/index'); ?>" class="text-muted">All Accounts</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= Yii::app()->createUrl('account/create'); ?>" class="text-muted">New Account</a>
                    </li>
                </ul>
            </div>
        </div>
        <!--<div class="d-flex align-items-center">
            <button type="button"  class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">Save and continue</button>
        </div>-->
    </div>
</div>
<div class="d-flex flex-column-fluid" id="vue-div">
    <div class="container">
        <?php
        if(Yii::app()->user->hasFlash('success')) { ?>
            <div class="alert alert-success info" role="alert">
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        <?php }else{ ?>
            <div class="alert alert-error" role="alert">
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
            <?php
        } ?>
        <div class="card card-custom">
            <div class="card-body p-0">
                <!--begin::Wizard-->
                <div class="wizard wizard-1" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="false">
                    <!--begin::Wizard Nav-->
                    <div class="wizard-nav border-bottom">
                        <div class="wizard-steps p-8 p-lg-10">
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-list"></i>
                                    <h3 class="wizard-title">1. Enter Basic details</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    
                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-earth-globe "></i>
                                    <h3 class="wizard-title">2. Add business details</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">

                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>

                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-home "></i>
                                    <h3 class="wizard-title">3. Add address details</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    
                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-piggy-bank"></i>
                                    <h3 class="wizard-title">4. Payment Details</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-upload-1"></i>
                                    <h3 class="wizard-title">5. Upload Documents</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-trophy"></i>
                                    <h3 class="wizard-title">6. Create Account</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon2-reload"></i>
                                    <h3 class="wizard-title">7. Review</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                        <div class="col-xl-12">
                            <form class="form" id="kt_form" method="POST">
                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                    <div class="col-xxl-7" style="margin: auto">
                                        <h4 class="mb-10 font-weight-bold text-dark">Enter/Verify Basic Details</h4>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>First Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="first_name" placeholder="First Name" value="<?= $telecom_user_detail->first_name; ?>" />
                                                    <span class="form-text text-muted">Please enter your First Name.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>Middle Name</label>
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="middle_name" placeholder="Middle Name" value="<?= $telecom_user_detail->middle_name; ?>" />
                                                    <span class="form-text text-muted">Please enter your Middle Name.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>Last Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="last_name" placeholder="Last Name" value="<?= $telecom_user_detail->last_name; ?>" />
                                                    <span class="form-text text-muted">Please enter your Last Name.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Date Of Birth<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-solid form-control-lg" id="date_of_birth" placeholder="Select date/Enter in yyyy-mm-dd format" name="date_of_birth" value="<?= $telecom_user_detail->date_of_birth; ?>" />
                                                    <span class="form-text text-muted">You need to be of at-least 18 years to enroll.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <div class="col-form-label">
                                                        <div class="">
                                                            <label class="radio radio-success radio-inline">
                                                                <input value="1" <?php if ($telecom_user_detail->gender == 1) { echo "checked";} ?> type="radio" class="check" name="gender">
                                                                <span></span>Male
                                                            </label>
                                                            <label class="radio radio-success radio-inline">
                                                                <input value="2" <?php if ($telecom_user_detail->gender != 1) { echo "checked";} ?> type="radio" class="check" name="gender">
                                                                <span></span>Female
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Fix Email</label>
                                            <input type="text" class="form-control form-control-solid form-control-lg" name="email" value="<?= $telecom_user_detail->email; ?>" <?php if ($telecom_user_detail->email != '') { echo "disabled";} ?> />
                                            <span class="form-text text-muted"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Extra Email</label>
                                            <input type="text" class="form-control form-control-solid form-control-lg" name="extra_email" placeholder="Additional Email" value="<?= $telecom_user_detail->extra_email; ?>" />
                                            <span class="form-text text-muted">Additional email for backup purpose.</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Phone Number<span class="text-danger">*</span></label>
                                                    <input type="tel" class="form-control form-control-solid form-control-lg" name="phone" placeholder="Contact number please" value="<?= $telecom_user_detail->phone; ?>" />
                                                    <span class="form-text text-muted">Please enter phone number.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Landline Number (Fixed)</label>
                                                    <input type="tel" class="form-control form-control-solid form-control-lg" name="landline_number" placeholder="Contact number please" value="<?= $telecom_user_detail->landline_number; ?>" />
                                                    <span class="form-text text-muted">Please enter land-line number as an extra contact information.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!--<div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>Language</label>
                                                    <select name="language" id="language" class="form-control">
                                                        <option value="Dutch">Dutch</option>
                                                        <option value="English">English</option>
                                                        <option value="French">French</option>
                                                        <option value="Nederlands">Nederlands</option>
                                                    </select>
                                                </div>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5" data-wizard-type="step-content">
                                    <div class="col-xxl-7" style="margin: auto">
                                        <h4 class="mb-10 font-weight-bold text-dark">Business Details</h4>
                                        <div class="form-group row">
                                            <div class="col-1">
                                            <span class="switch switch-outline switch-icon switch-success">
                                                <label>
                                                    <input type="checkbox" name="is_business_type" class="is_business_type" />
                                                    <span></span>
                                                </label>
                                            </span>
                                            </div>
                                            <label class="col-6 col-form-label col-form-label-new">Add Business details:</label>
                                        </div>
                                        <div class="business_details" style="display: none;">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Business Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="business_name" placeholder="Business Name" value="<?= $telecom_user_detail->business_name; ?>" />
                                                        <span class="form-text text-muted">Please enter Business Name.</span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">

                                                    <div class="form-group">
                                                        <label>VAT Number<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="vat_number" placeholder="VAT Number" value="<?= $telecom_user_detail->vat_number; ?>" />
                                                        <span class="form-text text-muted">Please enter VAT Number.</span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label for="business_country">Business Country<span class="text-danger">*</span></label>
                                                        <select name="business_country" id="business_country" class="form-control">
                                                            <?php
                                                            $country = Yii::app()->ServiceHelper->getCountry(); ?>
                                                            <option value="">Select Country</option>
                                                            <?php foreach ($country as $key => $value) { ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>VAT Rate (in %)</label>
                                                        <input type="number" class="form-control form-control-solid form-control-lg" name="vat" id="business_vat_rate" placeholder="VAT Rate" value="<?= $telecom_user_detail->vat; ?>" disabled/>
                                                        <span class="form-text text-muted">Applicable VAT rate.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label for="employment_type">Employment Type<span class="text-danger">*</span></label>
                                                        <select name="employment_type" id="employment_type" class="form-control">
                                                            <option value="">Select Employment</option>
                                                            <option value="self_employed">Self Employed</option>
                                                            <option value="company">Company</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="aoa-div">
                                                <div class="form-group row">
                                                    <label class="col-form-label col-lg-12 col-sm-12 aoa_label">File: Articles of Association</label>
                                                    <div class="col-lg-12 col-md-9 col-sm-12">
                                                        <div class="dropzone dropzone-default" id="aoa_file">
                                                            <div class="dropzone-msg dz-message needsclick">
                                                                <h3 class="dropzone-msg-title">Drop Articles-Of-Association file here or click to upload.</h3>
                                                                <h5 class="dropzone-msg-desc">Only PDF file with a cap of 2MB are allowed</h5>
                                                                <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4">Upload here</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5" data-wizard-type="step-content">
                                    <div class="col-xxl-7" style="margin: auto">
                                        <h4 class="mb-10 font-weight-bold text-dark">Address Details</h4>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Street<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="street" placeholder="Street" value="<?= $telecom_user_detail->street; ?>" />
                                                    <span class="form-text text-muted">Please enter street details.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Building Number<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="building_num" placeholder="Building number please" value="<?= $telecom_user_detail->building_num; ?>" />
                                                    <span class="form-text text-muted">Please enter building number.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Bus Number</label>
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="bus_num" placeholder="Bus number please" value="<?= $telecom_user_detail->bus_num; ?>" />
                                                    <span class="form-text text-muted">Please enter bus number.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>Postcode<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="postcode" placeholder="Postcode" value="<?= $telecom_user_detail->postcode; ?>" />
                                                    <span class="form-text text-muted">Please enter postcode details.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>City<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="city" placeholder="City" value="<?= $telecom_user_detail->city; ?>" />
                                                    <span class="form-text text-muted">Please enter city details.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label for="country">Country<span class="text-danger">*</span></label>
                                                    <select name="country" id="country" class="form-control">
                                                        <?php
                                                        $country = Yii::app()->ServiceHelper->getCountry(); ?>
                                                        <option value="">Select Country</option>
                                                        <?php foreach ($country as $key => $value) { ?>
                                                            <option value="<?php echo $key;?>" <?php if ($telecom_user_detail->country == $key) {echo "selected";}?>><?php echo $value ?></option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>Nationality<span class="text-danger">*</span></label>
                                                    <select name="nationality" id="nationality" class="form-control">
                                                        <?php
                                                        $nationality = Yii::app()->ServiceHelper->getNationality(); ?>
                                                        <option value="">Select Nationality</option>
                                                        <?php foreach ($nationality as $key => $value) { ?>
                                                            <option value="<?php echo $key;?>" <?php if ($telecom_user_detail->nationality == $key) {echo "selected";}?>><?php echo $value ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="mb-10 font-weight-bold text-dark">Billing Address</h5>
                                        <div class="form-group row">
                                            <div class="col-1">
                                            <span class="switch switch-outline switch-icon switch-success">
                                                <label>
                                                    <input type="checkbox" name="is_different_address" class="is_different_address" "<?php if (!empty($telecom_user_detail->business_name) && (($telecom_user_detail->billing_building_num != $telecom_user_detail->building_num) || ($telecom_user_detail->billing_street != $telecom_user_detail->street) || ($telecom_user_detail->billing_region != $telecom_user_detail->region) || ($telecom_user_detail->billing_city != $telecom_user_detail->city) || ($telecom_user_detail->billing_postcode != $telecom_user_detail->postcode) || ($telecom_user_detail->billing_country != $telecom_user_detail->country))){ echo "checked";} ?>">
                                                    <span></span>
                                                </label>
                                            </span>
                                            </div>
                                            <label class="col-8 col-form-label col-form-label-new">Use different address for billing purpose:</label>
                                        </div>
                                        <div class="differentAddress" style="display: none;">
                                            <div class="form-group">
                                                <label>Billing Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="billing_name" placeholder="Billing Name" value="<?= $telecom_user_detail->billing_name; ?>" />
                                                <span class="form-text text-muted">Name to be on invoice.</span>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Street<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="billing_street" placeholder="Street" value="<?= $telecom_user_detail->billing_street; ?>" />
                                                        <span class="form-text text-muted">Please enter street details.</span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Building Number<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="billing_building_num" placeholder="Building number please" value="<?= $telecom_user_detail->billing_building_num; ?>" />
                                                        <span class="form-text text-muted">Please enter building number.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Bus Number</label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="billing_bus_num" placeholder="Bus number please" value="<?= $telecom_user_detail->billing_bus_num; ?>" />
                                                        <span class="form-text text-muted">Please enter bus number.</span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Postcode<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="billing_postcode" placeholder="Postcode" value="<?= $telecom_user_detail->billing_postcode; ?>" />
                                                        <span class="form-text text-muted">Please enter postcode details.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>City<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="billing_city" placeholder="City" value="<?= $telecom_user_detail->billing_city; ?>" />
                                                        <span class="form-text text-muted">Please enter city details.</span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label for="billing_country">Country<span class="text-danger">*</span></label>
                                                        <select name="billing_country" id="billing_country" class="form-control">
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
                                    </div>
                                </div>
                                <div class="pb-5" data-wizard-type="step-content">
                                    <div class="col-xxl-7" style="margin: auto">
                                        <h4 class="mb-10 font-weight-bold text-dark">Add Payment Details</h4>
                                        <div class="form-group row">
                                            <label class="col-form-label col-12">Choose required payment method</label>
                                            <div class="col-9 col-form-label">
                                                <div class="radio-inline">
                                                    <label class="radio radio-success sepa_radio radio-inline">
                                                        <input value="SEPA" <?php if ($telecom_user_detail->payment_method == "SEPA") { echo "checked";} ?> type="radio" class="check" name="payment_method">
                                                        <span></span>SEPA
                                                    </label>
                                                    <label class="radio radio-success credit_card_radio radio-inline">
                                                        <input value="CreditCard" <?php if ($telecom_user_detail->payment_method == "CreditCard") { echo "checked";} ?> type="radio" class="check" name="payment_method">
                                                        <span></span>Credit Card
                                                    </label>
                                                    <label class="radio radio-success bank_transfer_radio radio-inline">
                                                        <input value="BankTransfer" <?php if ($telecom_user_detail->payment_method == "BankTransfer") { echo "checked";} ?> type="radio" class="check" name="payment_method">
                                                        <span></span>Bank Transfer
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sepa-div" style="display: none;">
                                            <div class="form-group">
                                                <label>Bank Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="bank_name" placeholder="Bank Name" value="<?= $telecom_user_detail->bank_name; ?>" />
                                                <span class="form-text text-muted">Name of the bank.</span>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">

                                                    <div class="form-group">
                                                        <label>Building Number<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="bank_building_num" placeholder="Building number please" value="<?= $telecom_user_detail->bank_building_num; ?>" />
                                                        <span class="form-text text-muted">Please enter building number.</span>
                                                    </div>

                                                </div>
                                                <div class="col-xl-6">

                                                    <div class="form-group">
                                                        <label>Street<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="bank_street" placeholder="Street" value="<?= $telecom_user_detail->bank_street; ?>" />
                                                        <span class="form-text text-muted">Please enter street details.</span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>City<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="bank_city" placeholder="City" value="<?= $telecom_user_detail->bank_city; ?>" />
                                                        <span class="form-text text-muted">Please enter city details.</span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Postcode<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="bank_postcode" placeholder="Postcode" value="<?= $telecom_user_detail->bank_postcode; ?>" />
                                                        <span class="form-text text-muted">Please enter postcode details.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label for="bank_country">Country<span class="text-danger">*</span></label>
                                                        <select name="bank_country" id="bank_country" class="form-control">
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
                                            <hr>
                                            <div class="form-group">
                                                <label>Account Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="account_name" placeholder="Account Name" value="<?= $telecom_user_detail->account_name; ?>" />
                                                <span class="form-text text-muted">Please add Account Name in the bank.</span>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">

                                                    <div class="form-group">
                                                        <label>iBAN<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="iban" placeholder="IBAN number" value="<?= $telecom_user_detail->iban; ?>" />
                                                        <span class="form-text text-muted">Please enter iBan number.</span>
                                                    </div>

                                                </div>
                                                <div class="col-xl-6">

                                                    <div class="form-group">
                                                        <label>BIC Code<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="bic_code" placeholder="BIC Code" value="<?= $telecom_user_detail->bic_code; ?>" />
                                                        <span class="form-text text-muted">Please enter BIC Code details.</span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="sepa-signature-div">
                                                <h4 class="font-weight-bold text-dark">Please Sign here<span class="text-danger">*</span></h4>
                                                <div class="wrapper">
                                                    <canvas id="sepa-signature-pad" class="sepa-signature-pad" width=400 height=200></canvas>
                                                </div>
                                                <!--<button id="save-png" type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">Save as PNG</button>-->
                                                <button id="sepa-undo" type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base" style="margin: 10px">Undo</button>
                                                <button id="sepa-clear" type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base" style="margin: 10px">Clear</button>
                                                <input type="text" class="form-control form-control-solid form-control-lg sepa-signature" name="sepa_signature" hidden/>
                                            </div>
                                        </div>
                                        <div class="credit-card-payment-div" style="display: none">
                                            <div class="credit-card-input no-js form-group" id="skeuocard">
                                                <p class="no-support-warning">
                                                    Either you have Javascript disabled, or you're using an unsupported browser, amigo! That's why you're seeing this old-school credit card input form instead of a fancy new Card. On the other hand, at least you know it gracefully degrades...
                                                </p>
                                                <label for="cc_type">Card Type</label>
                                                <select name="cc_type">
                                                    <option value="">...</option>
                                                    <option value="visa">Visa</option>
                                                    <option value="discover">Discover</option>
                                                    <option value="mastercard">MasterCard</option>
                                                    <option value="maestro">Maestro</option>
                                                    <option value="jcb">JCB</option>
                                                    <option value="unionpay">China UnionPay</option>
                                                    <option value="amex">American Express</option>
                                                    <option value="dinersclubintl">Diners Club</option>
                                                </select>
                                                <label for="cc_number">Card Number</label>
                                                <input type="text" name="cc_number" id="cc_number" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" size="19">
                                                <label for="cc_exp_month">Expiration Month</label>
                                                <input type="text" name="cc_exp_month" id="cc_exp_month" placeholder="00">
                                                <label for="cc_exp_year">Expiration Year</label>
                                                <input type="text" name="cc_exp_year" id="cc_exp_year" placeholder="00">
                                                <label for="cc_name">Cardholder's Name</label>
                                                <input type="text" name="cc_name" id="cc_name" placeholder="John Doe">
                                                <label for="cc_cvc">Card Validation Code</label>
                                                <input type="text" name="cc_cvc" id="cc_cvc" placeholder="123" maxlength="3" size="3">
                                            </div>
                                        </div>
                                        <div class="bank-transfer-div" style="display: none">
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5" data-wizard-type="step-content">
                                    <h4 class="mb-10 font-weight-bold text-dark" style="text-align: center">Select ID Type<span class="text-danger">*</span></h4>
                                    <div class="row">
                                        <div class="row justify-content-center">
                                            <div class="col-md-4 col-xxl-2 border ribbon ribbon-right" style="margin: 0 10px">
                                                <div class="ribbon-target bg-primary" style="top: 10px; right: -2px; display: none" id="passport_ribbon">Selected</div>
                                                <div class="pt-30 pt-md-25 pb-15 px-5 text-center">
                                                    <div class="d-flex flex-center position-relative mb-25">
                                                        <img class="img-responsive" style="max-width: 100%;" src="<?=  Yii::app()->baseUrl. '/images/passport.jpg' ?>">
                                                    </div>
                                                    <span class="font-size-h3 d-block d-block font-weight-bold text-dark-75 py-2">Passport</span>
                                                    <button type="button" class="btn btn-primary text-uppercase font-weight-bolder  step5_button" style="margin-top: 10px" onclick="selectID('passport')">Select</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xxl-2 border ribbon ribbon-right" style="margin: 0 10px">
                                                <div class="ribbon-target bg-primary" style="top: 10px; right: -2px; display: none" id="driving_ribbon">Selected</div>
                                                <div class="pt-30 pt-md-25 pb-15 px-5 text-center">
                                                    <div class="d-flex flex-center position-relative mb-25">
                                                        <img class="img-responsive" style="max-width: 100%;" src="<?=  Yii::app()->baseUrl. '/images/driving.jpg' ?>">
                                                    </div>
                                                    <span class="font-size-h3 d-block d-block font-weight-bold text-dark-75 py-2">Driving License</span>
                                                    <button type="button" class="btn btn-primary text-uppercase font-weight-bolder  step5_button" style="margin-top: 25px" onclick="selectID('driving')">Select</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xxl-2 border ribbon ribbon-right" style="margin: 0 10px">
                                                <div class="ribbon-target bg-primary" style="top: 10px; right: -2px; display: none" id="identification_ribbon">Selected</div>
                                                <div class="pt-30 pt-md-25 pb-15 px-5 text-center">
                                                    <div class="d-flex flex-center position-relative mb-25">
                                                        <img class="img-responsive" style="max-width: 100%;" src="<?=  Yii::app()->baseUrl. '/images/belgium_id.jpg' ?>">
                                                    </div>
                                                    <span class="font-size-h3 d-block d-block font-weight-bold text-dark-75 py-2">Identification Card</span>
                                                    <button type="button" class="btn btn-primary text-uppercase font-weight-bolder  step5_button" onclick="selectID('identification')">Select</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-7" style="margin: auto; display: none" id="kyc_file_upload">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-12 col-sm-12 passport_label">Upload here<span class="text-danger">*</span></label>
                                            <div class="col-lg-12 col-md-9 col-sm-12">
                                                <div class="dropzone dropzone-default" id="passport_file">
                                                    <div class="dropzone-msg dz-message needsclick">
                                                        <h3 class="dropzone-msg-title">Drop the file here or click to upload.</h3>
                                                        <h5 class="dropzone-msg-desc">Only PDF file with a cap of 2MB are allowed</h5>
                                                        <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4">Upload here</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12">
                                            <span class="switch switch-outline switch-icon switch-success">
                                                <label>
                                                    <input type="checkbox" name="is_document_valid" class="is_document_valid">
                                                    <span></span>
                                                    <label class="col-9 col-form-label">I confirm the document is authentic and valid until the expiry date mentioned in document.<span class="text-danger">*</span></label>
                                                </label>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5" data-wizard-type="step-content">
                                    <div id="business_products" style="display: none">
                                        <?php $this->renderPartial('product-pricing', ['products' => $business_products]); ?>
                                    </div>
                                    <div id="personal_products">
                                        <?php $this->renderPartial('product-pricing', ['products' => $personal_products]); ?>
                                    </div>
                                    <hr>
                                    <h4 class="mb-10 font-weight-bold text-dark">New Account Details</h4>
                                    <div class="form-group">
                                        <div class="col-xl-6">
                                            <label>Account User name</label>
                                            <input type="text" class="form-control form-control-solid form-control-lg" name="user_name" placeholder="User name" value="<?= $telecom_account->user_name; ?>" />
                                            <span class="form-text text-muted">An identifiable account name.</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label class="col-form-label col-8">Account Type</label>
                                                <div class="col-8">
                                                    <select  name="account_type" id="account_type" class="form-control form-control-line">
                                                        <option value="NewActivation" selected>New Activation</option>
                                                        <option value="Prepaid" disabled>Prepaid</option>
                                                        <option value="PostpaidDomestic" disabled>Postpaid Domestic</option>
                                                        <option value="PostpaidBusiness" disabled>Postpaid Business</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label class="col-form-label col-8">Rate</label>
                                                <div class="col-8">
                                                    <select  name="rate" id="tariff_rate" class="form-control form-control-line" disabled>
                                                        <option value="Iriscall">Iriscall</option>
                                                        <option value="Iriscall Home">Iriscall Home</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Extra options</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="extra_options" value="<?/*= $telecom_account->extra_options; */?>" />
                                                <span class="form-text text-muted">Extra data or calls.</span>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="form-group row">
                                        <div class="col-1">
                                            <span class="switch switch-outline switch-icon switch-success">
                                                <label>
                                                    <input type="checkbox" name="is_voice_mail_enabled" class="is_voice_mail_enabled" "<?php if ($telecom_account->is_voice_mail_enabled == 1){ echo "checked";} ?>">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                        <label class="col-6 col-form-label">Use Voice mail</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xl-6">
                                            <label>Comments</label>
                                            <input type="text" class="form-control form-control-solid form-control-lg" name="comments" placeholder="Extra details" value="<?= $telecom_account->comments; ?>" />
                                            <span class="form-text text-muted">Any extra details that need to be mentioned.</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <h4 class="mb-10 font-weight-bold text-dark">Applicable for those who have received the SIM card kit</h4>
                                    <div class="form-group row">
                                        <div class="col-xl-6">
                                            <label>Phone Number</label>
                                            <input type="tel" class="form-control form-control-solid form-control-lg" name="phone_number" value="<?= $telecom_account->phone_number; ?>"/>
                                            <span class="form-text text-muted">Please enter your new phone number.</span>
                                        </div>
                                        <div class="col-xl-6">
                                            <label>Sim Card Number</label>
                                            <input type="tel" class="form-control form-control-solid form-control-lg" name="sim_card_number" placeholder="Sim card number" value="<?= $telecom_account->sim_card_number; ?>" />
                                            <span class="form-text text-muted">Please enter new sim card number.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5" data-wizard-type="step-content">
                                    <h4 class="mb-10 font-weight-bold text-dark">Review details</h4>
                                    <div class="row">
                                        <div class="col-md-6" id="review_basic">
                                            <div class="card card-custom">
                                                <div class="card-header">
                                                    <div class="card-title">
													<span class="card-icon">
														<i class="flaticon2-chat-1 text-primary"></i>
													</span>
                                                        <h3 class="card-label">Basic details
                                                            <!--<small>sub title</small>--></h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-success font-weight-bold" id="review_basic_toolbar_click">
                                                            <i class="flaticon2-cube"></i>Edit</a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Name:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_name"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Date Of Birth:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_dob"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Gender:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_gender"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Fix email:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_fix_email"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Additional Email:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_additional_email"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Phone:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_phone"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Landline:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_landline"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6"  id="review_business" style="display: none">
                                            <div class="card card-custom">
                                                <div class="card-header">
                                                    <div class="card-title">
													<span class="card-icon">
														<i class="flaticon2-chat-1 text-primary"></i>
													</span>
                                                        <h3 class="card-label">Business details
                                                            <!--<small>sub title</small>--></h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-success font-weight-bold" id="review_business_toolbar_click">
                                                            <i class="flaticon2-cube"></i>Edit</a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Business Name:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_business_name"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Business Country:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_business_country"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">VAT Number:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_vat"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">VAT Rate:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_vat_rate"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6"  id="review_address">
                                            <div class="card card-custom">
                                                <div class="card-header">
                                                    <div class="card-title">
													<span class="card-icon">
														<i class="flaticon2-chat-1 text-primary"></i>
													</span>
                                                        <h3 class="card-label">Address details</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-success font-weight-bold" id="review_address_toolbar_click">
                                                            <i class="flaticon2-cube"></i>Edit</a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Address Details:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_address_details"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Nationality:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_nationality"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2" style="display: none" id="review_billing">
                                                        <label class="col-4 col-form-label">Billing Address:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_billing_address"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6"  id="review_payment">
                                            <div class="card card-custom">
                                                <div class="card-header">
                                                    <div class="card-title">
													<span class="card-icon">
														<i class="flaticon2-chat-1 text-primary"></i>
													</span>
                                                        <h3 class="card-label">Payment details</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-success font-weight-bold" id="review_payment_toolbar_click">
                                                            <i class="flaticon2-cube"></i>Edit</a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Payment Method:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_payment_method"></span>
                                                        </div>
                                                    </div>
                                                    <div id="review_sepa_method" style="display:none">
                                                        <div class="form-group row my-2">
                                                            <label class="col-4 col-form-label">Bank Name:</label>
                                                            <div class="col-8">
                                                                <span class="form-control-plaintext font-weight-bolder" id="review_bank_name"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row my-2">
                                                            <label class="col-4 col-form-label">Bank Address:</label>
                                                            <div class="col-8">
                                                                <span class="form-control-plaintext font-weight-bolder" id="review_bank_address"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row my-2">
                                                            <label class="col-4 col-form-label">Account Name:</label>
                                                            <div class="col-8">
                                                                <span class="form-control-plaintext font-weight-bolder" id="review_bank_account_name"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row my-2">
                                                            <label class="col-4 col-form-label">iBAN:</label>
                                                            <div class="col-8">
                                                                <span class="form-control-plaintext font-weight-bolder" id="review_iban"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row my-2">
                                                            <label class="col-4 col-form-label">BIC Code:</label>
                                                            <div class="col-8">
                                                                <span class="form-control-plaintext font-weight-bolder" id="review_bic_code"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="review_credit_card_method" style="display:none">
                                                        <div class="form-group row my-2">
                                                            <label class="col-4 col-form-label">Credit Card Name:</label>
                                                            <div class="col-8">
                                                                <span class="form-control-plaintext font-weight-bolder" id="review_credit_card_name"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row my-2">
                                                            <label class="col-4 col-form-label">Credit Card Number:</label>
                                                            <div class="col-8">
                                                                <span class="form-control-plaintext font-weight-bolder" id="review_credit_card_number"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row my-2">
                                                            <label class="col-4 col-form-label">Expiration Time:</label>
                                                            <div class="col-8">
                                                                <span class="form-control-plaintext font-weight-bolder" id="review_credit_card_expiry"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6"  id="review_account">
                                            <div class="card card-custom">
                                                <div class="card-header">
                                                    <div class="card-title">
													<span class="card-icon">
														<i class="flaticon2-chat-1 text-primary"></i>
													</span>
                                                        <h3 class="card-label">Account details</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-success font-weight-bold" id="review_account_toolbar_click">
                                                            <i class="flaticon2-cube"></i>Edit</a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Tariff Plan:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_tariff_plan"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Account User Name:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_account_user_name"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Account Type:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_account_type"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Account rate:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_account_rate"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Voice Mail:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_voice_mail"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Comments:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_account_comments"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Phone Number:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_phone_number"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-4 col-form-label">Sim Card Number:</label>
                                                        <div class="col-8">
                                                            <span class="form-control-plaintext font-weight-bolder" id="review_sim_card_number"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="review-signature-div">
                                                <h4 class="font-weight-bold text-dark">Please Sign here<span class="text-danger">*</span></h4>
                                                <div class="wrapper">
                                                    <canvas id="review-signature-pad" class="review-signature-pad" width=400 height=200></canvas>
                                                </div>
                                                <!--<button id="save-png" type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">Save as PNG</button>-->
                                                <button id="review-undo" type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base" style="margin: 10px">Undo</button>
                                                <button id="review-clear" type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base" style="margin: 10px">Clear</button>
                                                <input type="text" class="form-control form-control-solid form-control-lg review-signature" name="signature" hidden/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                    <div class="mr-2">
                                        <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit">Submit</button>
                                        <button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script src="<?= Yii::app()->baseUrl . '/plugins/credit-card/javascripts/vendor/cssua.min.js' ?>"></script>
<script src="<?= Yii::app()->baseUrl . '/plugins/credit-card/javascripts/skeuocard.min.js' ?>"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/signature/docs/js/signature_pad.umd.js"></script>
<script type="text/javascript">
    var passport_file_count = 0;
    var aoa_file_count = 0;
    //Used in JS file
    var nationality_array = JSON.parse('<?php echo json_encode($nationalityArray); ?>', true);
    var country_array = JSON.parse('<?php echo json_encode($countryArray); ?>', true);
    var signaturePadSEPA, signaturePadReview ;
    var sepa_canvas, review_canvas;

    $(document).ready(function () {

        //By default
        $('.bank_transfer_radio').hide();
        $('#tariff_rate').val('Iriscall');
        $('#review_fix_email').html('<?= $user->email; ?>');

        //For different billing address
        if($('.is_different_address').is(":checked")){
            $(".differentAddress").show();
        }else {
            $(".differentAddress").hide();
        }
        $('.is_different_address').on('change',function(){
            if($('.is_different_address').is(":checked")){
                $(".differentAddress").show();
                $("#review_billing").show();

            }else {
                $(".differentAddress").hide();
                $("#review_billing").hide();
            }
        });

        //If the customer enters business details
        $('.is_business_type').on('change',function(){
            if($('.is_business_type').is(":checked")){
                $(".business_details").show();
                $('.bank_transfer_radio').show();
                $('#tariff_rate').val('Iriscall');
                $('#review_account_rate').html('Iriscall');

                $('#business_products').show();
                $('#personal_products').hide();

                $('#review_business').show();
            }else {
                $(".business_details").hide();
                $('.bank_transfer_radio').hide();
                $('#tariff_rate').val('Iriscall Home');
                $('#review_account_rate').html('Iriscall Home');

                $('#business_products').hide();
                $('#personal_products').show();

                $('#review_business').hide();
            }
        });

        //On change event for business country
        $('#business_country').on('change', function (e) {
            var country_id = this.value;
            var vat_type = "business";
            calculateVat(country_id, vat_type);
        });

        //Ajax call to get vat details
        function calculateVat(country_id, vat_type) {
            var getVatUrl = "<?= Yii::app()->createUrl('product/getVatPercentage'); ?>";
            var vatdata = {
                'country_id': country_id,
                'vat_type': vat_type
            };
            $.ajax({
                type: "POST",
                url: getVatUrl,
                data: vatdata,
                success: function (data) {
                    $('#business_vat_rate').val(data);
                    $('#review_vat_rate').html(data);
                }
            });
        }

        //Credit card plugin
        card = new Skeuocard($("#skeuocard"), {
            validationState: {
                number: true,
                exp: true,
                name: true,
                cvc: false
            },
            validateLuhn: true
        });

        Dropzone.autoDiscover = false;
        $('#passport_file').dropzone({
            url: "<?= Yii::app()->createUrl('account/uploadfiles') ?>", // Set the url for your upload script location
            paramName: "passport", // The name that will be used to transfer the file
            maxFiles: 1,
            acceptedFiles: "application/pdf",
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            success: function (file, response) {
                passport_file_count = 1;
                var imgName = response;
                //file.previewElement.classList.add("dz-success");
            },
            removedfile: function (file, response) {
                $.ajax({
                    url: "removefiles",
                    type: "POST",
                    data: { "document_id" : 1 },
                    success: function(){
                        passport_file_count = 0;
                        file.previewElement.parentNode.removeChild(file.previewElement);
                    }
                });
            }
        });
        $('#aoa_file').dropzone({
            url: "<?= Yii::app()->createUrl('account/uploadfiles') ?>", // Set the url for your upload script location
            paramName: "articles_of_association", // The name that will be used to transfer the file
            maxFiles: 1,
            acceptedFiles: "application/pdf",
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            //autoProcessQueue: false,
            success: function (file, response) {
                aoa_file_count = 1;
                var imgName = response;
                //file.previewElement.classList.add("dz-success");
            },
            removedfile: function (file, response) {
                $.ajax({
                    url: "removefiles",
                    type: "POST",
                    data: { "document_id" : 3 },
                    success: function(){
                        aoa_file_count = 0;
                        file.previewElement.parentNode.removeChild(file.previewElement);
                    }
                });
            }
        });

        $('input[type=radio][name=payment_method]').on('change', function() {
            if($(this).val() == 'CreditCard'){
                $('.credit-card-payment-div').show();
                $('#review_credit_card_method').show();
            } else {
                $('.credit-card-payment-div').hide();
                $('#review_credit_card_method').hide();
            }
            if($(this).val() == 'BankTransfer'){
                $('.bank-transfer-div').show();
            } else {
                $('.bank-transfer-div').hide();
            }
            if($(this).val() == 'SEPA'){
                $('.sepa-div').show();
                $('#review_sepa_method').show();

                createSignature();
            } else {
                $('.sepa-div').hide();
                $('#review_sepa_method').hide();
            }
        });

        $('#date_of_birth').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            startDate: "01-01-1950",
            endDate: "-18y",
            format: "yyyy-mm-dd",
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        });
    });

    function createSignature(){
        //Signature Pad
        sepa_canvas = document.getElementById('sepa-signature-pad');

        window.onresize = resizeCanvas;
        resizeCanvas();

        signaturePadSEPA = new SignaturePad(sepa_canvas, {
            backgroundColor: 'rgb(243, 246, 249)'
            //backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
        });

        document.getElementById('sepa-clear').addEventListener('click', function () {
            signaturePadSEPA.clear();
        });

        document.getElementById('sepa-undo').addEventListener('click', function () {
            var data = signaturePadSEPA.toData();
            if (data) {
                data.pop(); // remove the last dot or line
                signaturePadSEPA.fromData(data);
            }
        });
    }


    // Adjust canvas coordinate space taking into account pixel ratio,
    // to make it look crisp on mobile devices.
    // This also causes canvas to be cleared.
    function resizeCanvas() {
        // When zoomed out to less than 100%, for some very strange reason,
        // some browsers report devicePixelRatio as less than 1
        // and only part of the canvas is cleared then.
        var ratio =  Math.max(window.devicePixelRatio || 1, 1);
        sepa_canvas.width = sepa_canvas.offsetWidth * ratio;
        sepa_canvas.height = sepa_canvas.offsetHeight * ratio;
        sepa_canvas.getContext("2d").scale(ratio, ratio);
    }

    function selectID(idType){
        $('.ribbon-target').hide();
        $('#'+idType+'_ribbon').show();
        $('#kyc_file_upload').show();
    }
</script>
<script src="<?= Yii::app()->baseUrl . '/js/wizard-1.js?v=0.0.3' ?>"></script>
