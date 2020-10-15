<?php
$this->pageTitle = "Create Account";
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/wizard-1.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/credit-card/styles/skeuocard.reset.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/credit-card/styles/skeuocard.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/credit-card/styles/demo.css');
?>
<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">New Account</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="<?= Yii::app()->createUrl('account/index'); ?>" class="text-muted">All Accounts</a>
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
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-piggy-bank"></i>
                                    <h3 class="wizard-title">2. Payment Details</h3>
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
                                    <h3 class="wizard-title">3. Upload Documents</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-trophy"></i>
                                    <h3 class="wizard-title">4. Create Account</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                        <div class="col-xl-12 col-xxl-7">
                            <form class="form" id="kt_form" method="POST">
                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                    <h4 class="mb-10 font-weight-bold text-dark">Enter/Verify Basic Details</h4>
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control form-control-solid form-control-lg" name="email" value="<?= $user->email; ?>" disabled/>
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Agent Name</label>
                                        <input type="text" class="form-control form-control-solid form-control-lg" name="agent_name" placeholder="Agent Name" value="<?= $telecom_user_detail->agent_name; ?>" />
                                        <span class="form-text text-muted">Agent Name.</span>
                                    </div>
                                    <!--end::Input-->
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <!--begin::Input-->
                                            <div class="form-group">
                                                <label>Bus number</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="bus_number" placeholder="Address Bus number" value="<?= $telecom_user_detail->bus_number; ?>" />
                                                <span class="form-text text-muted">Please enter your bus number.</span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <div class="col-xl-4">
                                            <!--begin::Input-->
                                            <div class="form-group">
                                                <label>Company's Age in months</label>
                                                <input type="number" class="form-control form-control-solid form-control-lg" name="company_since_in_months" placeholder="1, 2, 12, 24, etc.." value="<?= $telecom_user_detail->company_since_in_months; ?>" />
                                                <span class="form-text text-muted">Time period in months from your company's inception.</span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <div class="col-xl-4">
                                            <!--begin::Input-->
                                            <div class="form-group">
                                                <label>Landline Number</label>
                                                <input type="number" class="form-control form-control-solid form-control-lg" name="landline_number" placeholder="Contact number please" value="<?= $telecom_user_detail->landline_number; ?>" />
                                                <span class="form-text text-muted">Please enter land-line number as an extra contact information.</span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5" data-wizard-type="step-content">
                                    <h4 class="mb-10 font-weight-bold text-dark">Add Payment Details</h4>
                                    <!--begin::Input-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-12">Choose required payment method</label>
                                        <div class="col-9 col-form-label">
                                            <div class="radio-inline">
                                                <label class="radio radio-success">
                                                    <input value="SEPA" <?php if ($telecom_user_detail->payment_method == "SEPA") { echo "checked";} ?> type="radio" class="check" name="payment_method">
                                                    <span></span>SEPA
                                                </label>
                                                <label class="radio radio-success">
                                                    <input value="CreditCard" <?php if ($telecom_user_detail->payment_method == "CreditCard") { echo "checked";} ?> type="radio" class="check" name="payment_method">
                                                    <span></span>Credit Card
                                                </label>
                                                <label class="radio radio-success">
                                                    <input value="BankTransfer" <?php if ($telecom_user_detail->payment_method == "BankTransfer") { echo "checked";} ?> type="radio" class="check" name="payment_method">
                                                    <span></span>Bank Transfer
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Input-->
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
                                </div>
                                <div class="pb-5" data-wizard-type="step-content">
                                    <h3 class="mb-10 font-weight-bold text-dark">Upload KYC Documents</h3>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12 col-sm-12">File: Passport</label>
                                        <div class="col-lg-12 col-md-9 col-sm-12">
                                            <div class="dropzone dropzone-default" id="passport_file">
                                                <div class="dropzone-msg dz-message needsclick">
                                                    <h3 class="dropzone-msg-title">Drop Passport file here or click to upload.</h3>
                                                    <span class="dropzone-msg-desc">Only PDF file with a cap of 2MB are allowed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12 col-sm-12">File: SEPA</label>
                                        <div class="col-lg-12 col-md-9 col-sm-12">
                                            <div class="dropzone dropzone-default" id="sepa_file">
                                                <div class="dropzone-msg dz-message needsclick">
                                                    <h3 class="dropzone-msg-title">Drop SEPA file here or click to upload.</h3>
                                                    <span class="dropzone-msg-desc">Only PDF file with a cap of 2MB are allowed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-12 col-sm-12">File: Articles Of Association</label>
                                        <div class="col-lg-12 col-md-9 col-sm-12">
                                            <div class="dropzone dropzone-default" id="aoa_file">
                                                <div class="dropzone-msg dz-message needsclick">
                                                    <h3 class="dropzone-msg-title">Drop Articles-Of-Association file here or click to upload.</h3>
                                                    <span class="dropzone-msg-desc">Only PDF file with a cap of 2MB are allowed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5" data-wizard-type="step-content">
                                    <h4 class="mb-10 font-weight-bold text-dark">Create New Account</h4>
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="tel" class="form-control form-control-solid form-control-lg" name="phone_number" value="<?= $telecom_account->phone_number; ?>"/>
                                        <span class="form-text text-muted">Please enter your new phone number.</span>
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Sim Card Number</label>
                                        <input type="tel" class="form-control form-control-solid form-control-lg" name="sim_card_number" placeholder="Sim card number" value="<?= $telecom_account->sim_card_number; ?>" />
                                        <span class="form-text text-muted">Please enter new sim card number.</span>
                                    </div>
                                    <!--end::Input-->
                                    <div class="form-group row">
                                        <div class="col-1">
                                            <span class="switch switch-outline switch-icon switch-success">
                                                <label>
                                                    <input type="checkbox" name="is_voice_mail_enabled" class="is_voice_mail_enabled" "<?php if ($telecom_account->is_voice_mail_enabled == 1){ echo "checked";} ?>">
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                        <label class="col-3 col-form-label">Use Voice mail</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <!--begin::Input-->
                                            <div class="form-group">
                                                <label class="col-form-label col-4">Tariff Plan</label>
                                                <div class="col-8">
                                                    <select  name="tariff_plan" id="tariff_plan" class="form-control form-control-line">
                                                        <option value="">Select Tariff Plan</option>
                                                        <?php foreach ($products as $product) { ?>
                                                            <option value="<?php echo $product['product_id'];?>" <?php if ($tariff_product_id == $product['product_id']) {echo "selected";}?>><?php echo $product['name'] ?></option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <div class="col-xl-6">
                                            <!--begin::Input-->
                                            <div class="form-group">
                                                <label>Extra options</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="extra_options" value="<?= $telecom_account->extra_options; ?>" />
                                                <span class="form-text text-muted">Extra data or calls.</span>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <input type="text" class="form-control form-control-solid form-control-lg" name="comments" placeholder="Extra details" value="<?= $telecom_account->comments; ?>" />
                                        <span class="form-text text-muted">Any extra details that need to be mentioned.</span>
                                    </div>
                                    <!--end::Input-->
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
</div>
<script src="<?= Yii::app()->baseUrl . '/plugins/credit-card/javascripts/vendor/cssua.min.js' ?>"></script>
<script src="<?= Yii::app()->baseUrl . '/plugins/credit-card/javascripts/skeuocard.min.js' ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
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
                var imgName = response;
                file.previewElement.classList.add("dz-success");
                console.log("Successfully uploaded :" + imgName);
            },
            error: function (file, response) {
                file.previewElement.classList.add("dz-error");
            }
        });
        $('#sepa_file').dropzone({
            url: "<?= Yii::app()->createUrl('account/uploadfiles') ?>", // Set the url for your upload script location
            paramName: "sepa", // The name that will be used to transfer the file
            maxFiles: 1,
            acceptedFiles: "application/pdf",
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            success: function (file, response) {
                var imgName = response;
                file.previewElement.classList.add("dz-success");
                console.log("Successfully uploaded :" + imgName);
            },
            error: function (file, response) {
                file.previewElement.classList.add("dz-error");
            }
        });
        $('#aoa_file').dropzone({
            url: "<?= Yii::app()->createUrl('account/uploadfiles') ?>", // Set the url for your upload script location
            paramName: "articles_of_association", // The name that will be used to transfer the file
            maxFiles: 1,
            acceptedFiles: "application/pdf",
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            success: function (file, response) {
                var imgName = response;
                file.previewElement.classList.add("dz-success");
                console.log("Successfully uploaded :" + imgName);
            },
            error: function (file, response) {
                file.previewElement.classList.add("dz-error");
            }
        });

        $('input[type=radio][name=payment_method]').on('change', function() {
            if($(this).val() == 'CreditCard'){
                $('.credit-card-payment-div').show();
            } else {
                $('.credit-card-payment-div').hide();
            }
        });
    });
</script>
<script src="<?= Yii::app()->baseUrl . '/js/wizard-1.js' ?>"></script>
