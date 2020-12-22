"use strict";

// Class definition
var KTWizard1 = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizardObj;
	var _validations = [];

	// Private functions
	var _initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
                    first_name: {
                        validators: {
                            notEmpty: {
                                message: 'First Name is required'
                            }
                        }
                    },
                    last_name: {
                        validators: {
                            notEmpty: {
                                message: 'Last Name is required'
                            }
                        }
                    },
                    phone: {
                        validators: {
                            notEmpty: {
                                message: 'Phone is required'
                            }
                        }
                    },
                    date_of_birth: {
                        validators: {
                            notEmpty: {
                                message: 'Birth-date is required'
                            }
                        }
                    }
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

        // Step 2
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    business_name: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter Business name'
                            }
                        }
                    },
                    vat_number: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter VAT number'
                            }
                        }
                    },
                    business_country: {
                        validators: {
                            notEmpty: {
                                message: 'Please select a Country'
                            }
                        }
                    },
                    vat_rate: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter vat rate'
                            }
                        }
                    },
                    employment_type: {
                        validators: {
                            notEmpty: {
                                message: 'Please select employment type'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    excluded: new FormValidation.plugins.Excluded(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ));

		// Step 3
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
                    street: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter street name'
                            }
                        }
                    },
                    building_num: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter building number'
                            }
                        }
                    },
                    city: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter City'
                            }
                        }
                    },
                    postcode: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter post code'
                            }
                        }
                    },
                    country: {
                        validators: {
                            notEmpty: {
                                message: 'Please select a country'
                            }
                        }
                    },
                    nationality: {
                        validators: {
                            notEmpty: {
                                message: 'Please select a nationality'
                            }
                        }
                    },
                    billing_name: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter Billing name'
                            }
                        }
                    },
                    billing_street: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter street name'
                            }
                        }
                    },
                    billing_building_num: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter building number'
                            }
                        }
                    },
                    billing_city: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter City'
                            }
                        }
                    },
                    billing_postcode: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter post code'
                            }
                        }
                    },
                    billing_country: {
                        validators: {
                            notEmpty: {
                                message: 'Please select a country'
                            }
                        }
                    }
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
                    excluded: new FormValidation.plugins.Excluded(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

		// Step 4
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					payment_method: {
                        validators: {
                            notEmpty: {
                                message: 'Please select a payment method'
                            }
                        }
                    },
                    bank_name: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter bank name'
                            }
                        }
                    },
                    bank_street: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter street name'
                            }
                        }
                    },
                    bank_building_num: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter building number'
                            }
                        }
                    },
                    bank_city: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter City'
                            }
                        }
                    },
                    bank_postcode: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter post code'
                            }
                        }
                    },
                    bank_country: {
                        validators: {
                            notEmpty: {
                                message: 'Please select a country'
                            }
                        }
                    },
                    account_name: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter account name'
                            }
                        }
                    },
                    iban: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter IBAN number'
                            }
                        }
                    },
                    bic_code: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter BIC code'
                            }
                        }
                    }
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
                    excluded: new FormValidation.plugins.Excluded(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

        // Step 5
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    is_document_valid: {
                        validators: {
                            notEmpty: {
                                message: 'Please accept the document terms'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    excluded: new FormValidation.plugins.Excluded(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ));

        // Step 6
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    user_name: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter Account user name'
                            }
                        }
                    }/*,
                    tariff_plan: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter Account user name'
                            }
                        }
                    }*/
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ));
	}

	var _initWizard = function () {
		// Initialize form wizard
		_wizardObj = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: false  // allow step clicking
		});

		// Validation before going to next page
		_wizardObj.on('change', function (wizard) {
			if (wizard.getStep() > wizard.getNewStep()) {
				return; // Skip if stepped back
			}
			console.log("Wizard Step: "+wizard.getStep());

			//On Click events for edit button in review steps
            $('#review_basic_toolbar_click').on('click', function () {
                wizard.goTo(1);
            });
            $('#review_business_toolbar_click').on('click', function () {
                wizard.goTo(2);
            });
            $('#review_address_toolbar_click').on('click', function () {
                wizard.goTo(3);
            });
            $('#review_payment_toolbar_click').on('click', function () {
                wizard.goTo(4);
            });
            $('#review_account_toolbar_click').on('click', function () {
                wizard.goTo(6);
            });


			if(wizard.getStep() == 6){
			    //Add details to review section
			    var formData = $('#kt_form').serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {});

                //Basic Details
                $('#review_name').html(formData['first_name'] + " "  + formData['middle_name'] + " " + formData['last_name']);
			    $('#review_dob').html(formData['date_of_birth']);
			    if(formData['gender'] == '1')
			        $('#review_gender').html('Male');
			    else
                    $('#review_gender').html('Female');
			    $('#review_additional_email').html(formData['extra_email']);
			    $('#review_phone').html(formData['phone']);
			    $('#review_landline').html(formData['landline_number']);

			    //Business Details
                $('#review_business_name').html(formData['business_name']);
                $('#review_business_country').html(country_array[formData['business_country']]);
                $('#review_vat').html(formData['vat_number']);

                //Address Details
                $('#review_address_details').html(formData['building_num'] + ", "  + formData['bus_num'] + ", <br>" + formData['street'] + ", " + formData['city']
                                + ", <br>" + country_array[formData['country']] + "-"  + formData['postcode']);
                $('#review_nationality').html(nationality_array[formData['nationality']]);
                $('#review_billing_address').html(formData['billing_name'] + " <br>" + formData['billing_building_num'] + ", "  + formData['billing_bus_num'] + ", <br>" + formData['billing_street'] + ", " + formData['billing_city']
                    + ", <br>" + country_array[formData['billing_country']] + "-"  + formData['billing_postcode']);

                //Payment Details
                $('#review_payment_method').html(formData['payment_method']);
                //SEPA
                $('#review_bank_name').html(formData['bank_name']);
                $('#review_bank_address').html(formData['bank_building_num'] + ", <br>" + formData['bank_street'] + ", " + formData['bank_city']
                    + ", <br>" + country_array[formData['bank_country']] + "-"  + formData['bank_postcode']);
                $('#review_bank_account_name').html(formData['account_name']);
                $('#review_iban').html(formData['iban']);
                $('#review_bic_code').html(formData['bic_code']);
                //Credit Card
                $('#review_credit_card_name').html(formData['cc_name']);
                $('#review_credit_card_number').html(formData['cc_number']);
                $('#review_credit_card_expiry').html(formData['cc_exp_month'] + "/" + formData['cc_exp_year']);

                //Account Details
                $('#review_tariff_plan').html(formData['tariff_plan']);
                $('#review_account_user_name').html(formData['user_name']);
                $('#review_account_type').html(formData['account_type']);
                $('#review_voice_mail').html(formData['is_voice_mail_enabled']);
                $('#review_account_comments').html(formData['comments']);
                $('#review_phone_number').html(formData['phone_number']);
                $('#review_sim_card_number').html(formData['sim_card_number']);

                //Create Signature
                createReviewSignature();
            }

			var cardError = 0;
			var SEPASignatureError = 0;
            var fileError = 0;
            if(wizard.getStep() == 2){
                if($('.is_business_type').is(":checked")){
                    var employment_type = $('#employment_type').val();
                    if(employment_type == 'company'){
                        if(aoa_file_count == 0){
                            $('.aoa_label').addClass('text-danger');
                            $('.aoa_label').html('Articles-Of-Association is required');
                            fileError = fileError + 1;
                        } else {
                            $('.aoa_label').removeClass('text-danger');
                            $('.aoa_label').html('File: Articles of Association');
                        }
                    }
                }
            }
			if(wizard.getStep() == 4){
				if($('input[type=radio][name=payment_method]:checked').val() == 'CreditCard'){
					if(!card.isValid()){
                        cardError = 1;
					} else {
                        cardError = 0;
                    }
				} else if($('input[type=radio][name=payment_method]:checked').val() == 'SEPA'){
                    cardError = 0;
                    if(signaturePadSEPA){
                        if (signaturePadSEPA.isEmpty()) {
                            SEPASignatureError++;
                        } else {
                            SEPASignatureError = 0;
                            $('.sepa-signature').val(signaturePadSEPA.toDataURL('image/png'));
                        }
                    }
                } else {
                    cardError = 0;
                    SEPASignatureError = 0;
                }
			}
			if(wizard.getStep() == 5){
                fileError = 0;
			    if(passport_file_count == 0){
			        $('.passport_label').addClass('text-danger');
                    $('.passport_label').html('Document is required');
                    fileError = fileError + 1;
                } else {
                    $('.passport_label').removeClass('text-danger');
                    $('.passport_label').html('Upload Here');
                }
            }

			// Validate form before change wizard step
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					if (status == 'Valid' && cardError == 0 && fileError == 0 && SEPASignatureError == 0) {
						wizard.goTo(wizard.getNewStep());

						KTUtil.scrollTop();
					} else {
						Swal.fire({
							text: "Sorry, looks like there are some errors detected, please try again.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn font-weight-bold btn-light"
							}
						}).then(function () {
							//KTUtil.scrollTop();
						});
					}
				});
			}

			return false;  // Do not change wizard step, further action will be handled by he validator
		});

		// Change event
		_wizardObj.on('changed', function (wizard) {
			KTUtil.scrollTop();
		});

		// Submit event
		_wizardObj.on('submit', function (wizard) {
            if (signaturePadReview.isEmpty()) {
                Swal.fire({
                    text: "Sorry, You first need to sign the please.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light"
                    }
                });
            } else {
                $('.review-signature').val(signaturePadReview.toDataURL('image/png'));
                Swal.fire({
                    text: "All is good! Please confirm the form submission.",
                    icon: "success",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, submit!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-primary",
                        cancelButton: "btn font-weight-bold btn-default"
                    }
                }).then(function (result) {
                    if (result.value) {
                        _formEl.submit(); // Submit form
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "Your form has not been submitted!.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-primary",
                            }
                        });
                    }
                });
            }
		});
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard');
			_formEl = KTUtil.getById('kt_form');

			_initValidation();
			_initWizard();
		}
	};
}();

function createReviewSignature(){
    //Signature Pad
    review_canvas = document.getElementById('review-signature-pad');

    signaturePadReview = new SignaturePad(review_canvas, {
        backgroundColor: 'rgb(243, 246, 249)'
        //backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
    });

    document.getElementById('review-clear').addEventListener('click', function () {
        signaturePadReview.clear();
    });

    document.getElementById('review-undo').addEventListener('click', function () {
        var data = signaturePadReview.toData();
        if (data) {
            data.pop(); // remove the last dot or line
            signaturePadReview.fromData(data);
        }
    });
}

jQuery(document).ready(function () {
	KTWizard1.init();
});
