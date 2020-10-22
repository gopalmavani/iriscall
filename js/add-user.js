"use strict";

// Class Definition
var KTAddUser = function () {
	// Private Variables
	var _wizardEl;
	var _formEl;
	var _wizardObj;
	var _avatar;
	var _validations = [];

	// Private Functions
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

			var checked = 1;
			console.log("Step:" + wizard.getStep());
			if(wizard.getStep() == 3){
                checked = $('.privacy:checkbox:checked').length;
                if(checked == 0){
                    Swal.fire({
                        text: "Sorry, You need to accept the privacy policy to proceed further",
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
					if (status == 'Valid' && checked == 1) {
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
							KTUtil.scrollTop();
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

	var _initValidations = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/

		// Validation Rules For Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
                    'UserInfo[first_name]': {
						validators: {
							notEmpty: {
								message: 'First Name is required'
							}
						}
					},
					'UserInfo[last_name]': {
						validators: {
							notEmpty: {
								message: 'Last Name is required'
							}
						}
					},
                    'UserInfo[phone]': {
						validators: {
							notEmpty: {
								message: 'Phone is required'
							}
						}
					},
                    password: {
						validators: {
							notEmpty: {
								message: 'Password is required'
							}
						}
					},
                    confirm_password: {
                        validators: {
                            identical: {
                                compare: function() {
                                    return _formEl.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
					'UserInfo[email]': {
						validators: {
							notEmpty: {
								message: 'Email is required'
							},
							emailAddress: {
								message: 'The value is not a valid email address'
							},
                            remote: {
                                message: 'Email Already Exist in System. Please login',
                                method: 'POST',
                                url: '../checkEmail'
                            }
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: ''
					})
				}
			}
		));

		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					// Step 2
					'UserInfo[street]': {
						validators: {
							notEmpty: {
								message: 'Please enter street name'
							}
						}
					},
                    'UserInfo[building_num]': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter building number'
                            }
                        }
                    },
                    'UserInfo[city]': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter City'
                            }
                        }
                    },
                    'UserInfo[postcode]': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter post code'
                            }
                        }
                    },
					'UserInfo[country]': {
                        validators: {
                            notEmpty: {
                                message: 'Please select a country'
                            }
                        }
                    },
                    'UserInfo[business_name]': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter Business Name'
                            }
                        }
                    },
                    'UserInfo[vat_number]': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter Vat Number'
                            }
                        }
                    },
                    'UserInfo[busAddress_street]': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter street name'
                            }
                        }
                    },
                    'UserInfo[busAddress_building_num]': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter building number'
                            }
                        }
                    },
                    'UserInfo[busAddress_city]': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter City'
                            }
                        }
                    },
                    'UserInfo[busAddress_postcode]': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter post code'
                            }
                        }
                    },
                    'UserInfo[busAddress_country]': {
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
                    icon: new FormValidation.plugins.Icon({
                        valid: 'fa fa-check',
                        invalid: 'fa fa-times',
                        validating: 'fa fa-refresh'
                    }),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: ''
					})
				}
			}
		));

		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
                    /*privacy: {
                        validators: {
                            notEmpty: {
                                message: 'Please accept the privacy policy'
                            }, choice: {
                                min: 1,
                                max: 1,
                                message: 'You have to accept all agreements to continue'
                            }
                        }
                    },*/
                    payout_bank: {
						validators: {
							notEmpty: {
								message: 'Bank name is required'
							}
						}
					},
                    payout_accountname: {
						validators: {
							notEmpty: {
								message: 'Account Name is required'
							}
						}
					},
                    payout_iban: {
						validators: {
							notEmpty: {
								message: 'IBAN is required'
							}
						}
					},
                    payout_biccode: {
						validators: {
							notEmpty: {
								message: 'BIC-CODE is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
                    excluded: new FormValidation.plugins.Excluded(),
                    icon: new FormValidation.plugins.Icon({
                        valid: 'fa fa-check',
                        invalid: 'fa fa-times',
                        validating: 'fa fa-refresh'
                    }),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: ''
					})
				}
			}
		));
	}

	var _initAvatar = function () {
		_avatar = new KTImageInput('kt_user_add_avatar');
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard');
			_formEl = KTUtil.getById('kt_form');

			_initWizard();
			_initValidations();
			_initAvatar();
		}
	};
}();

jQuery(document).ready(function () {
	KTAddUser.init();
});
