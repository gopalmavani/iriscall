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
                    },
                    landline_number: {
                        validators: {
                            notEmpty: {
                                message: 'Land line number as an alternate contact number is required'
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

		// Step 3
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

        // Step 6
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
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
			var cardError = 0;
			if(wizard.getStep() == 4){
				if($('input[type=radio][name=payment_method]:checked').val() == 'CreditCard'){
					if(!card.isValid()){
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected in credit card details",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light"
                            }
                        }).then(function () {
                            //KTUtil.scrollTop();
                        });
                        cardError = 1;
					}
				} else {
                    cardError = 0;
				}
			}
			var fileError = 0;
			if(wizard.getStep() == 5){
			    if(passport_file_count == 0){
			        $('.passport_label').addClass('text-danger');
                    $('.passport_label').html('Passport is required');
                    fileError = fileError + 1;
                } else {
                    $('.passport_label').removeClass('text-danger');
                    $('.passport_label').html('File: Passport');
                }
                if(sepa_file_count == 0){
                    $('.sepa_label').addClass('text-danger');
                    $('.sepa_label').html('SEPA is required');
                    fileError = fileError + 1;
                } else {
                    $('.sepa_label').removeClass('text-danger');
                    $('.sepa_label').html('File: SEPA');
                }
                if(aoa_file_count == 0){
                    $('.aoa_label').addClass('text-danger');
                    $('.aoa_label').html('Articles Of Association is required');
                    fileError = fileError + 1;
                } else {
                    $('.aoa_label').removeClass('text-danger');
                    $('.aoa_label').html('File: Articles Of Association');
                }
                if(fileError > 0){
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected while uploading documents",
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
            }

			// Validate form before change wizard step
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					if (status == 'Valid' && cardError == 0 && fileError == 0) {
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

jQuery(document).ready(function () {
	KTWizard1.init();
});
