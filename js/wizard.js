"use strict";

// Class definition
var KTWizard4 = function () {
	// Base elements
	var wizardEl;
	var formEl;
	var validator;
	var wizard;

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		wizard = new KTWizard('kt_wizard', {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		wizard.on('beforeNext', function(wizardObj) {
			if (validator.form() !== true) {
				wizardObj.stop();  // don't go to the next step
			}
		});

		wizard.on('beforePrev', function(wizardObj) {
			/*if (validator.form() !== true) {
				wizardObj.stop();  // don't go to the next step
			}*/
		});

		// Change event
		wizard.on('change', function(wizard) {
			KTUtil.scrollTop();
		});
	}

	var initValidation = function() {
		validator = formEl.validate({
			// Validate only visible fields
			ignore: ":hidden",

			// Validation rules
			rules: {
				//= Step 1
                'UserInfo[first_name]': {
					required: true
				},
                'UserInfo[last_name]': {
					required: true
				},
                'UserInfo[phone]': {
					required: true
				},
                'UserInfo[email]': {
					required: true,
					email: true,
                    remote: {
                        url: '../checkEmail',
                        type: 'post',
                        data: {
                            'email': function () {
                                return $('#email').val();
                            }
                        }
                    }
				},
                password: {
                    required: true,
                },
                confirm_password: {
                    equalTo: '#password'
                },
                'UserInfo[language]': {
                    required: true
                },

				//= Step 2
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
                'UserInfo[business_name]': {
                    required: "#UserInfo_business_name:visible"
                },
                'UserInfo[vat_number]': {
                    required: "#UserInfo_vat_number:visible"
                },

				//= Step 3
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
				/*ccname: {
					required: true
				},
				ccnumber: {
					required: true,
					//creditcard: true
				},
				ccmonth: {
					required: true
				},
				ccyear: {
					required: true
				},
				cccvv: {
					required: true,
					minlength: 2,
					maxlength: 3
				},*/
			},

			// Display error
			invalidHandler: function(event, validator) {
				KTUtil.scrollTop();

				swal.fire({
					"title": "",
					"text": "There are some errors in your submission. Please correct them.",
					"type": "error",
					"confirmButtonClass": "btn btn-secondary"
				});
			},

			// Submit valid form
			submitHandler: function (form) {
                form.submit();
			}
		});
	}

	var initSubmit = function() {
		var btn = formEl.find('[data-ktwizard-type="action-submit"]');

		btn.on('click', function(e) {
			e.preventDefault();

			if (validator.form()) {
				// See: src\js\framework\base\app.js
				KTApp.progress(btn);
				//KTApp.block(formEl);
                $("#kt-").submit();
				// See: http://malsup.com/jquery/form/#ajaxSubmit
                formEl.submit();
				/*console.info($(formEl).serializeArray());
				var form_data = $(formEl).serializeArray();
                $.ajax({
                    type: "POST",
                    url: "../home/createUserSignup",
                    data: form_data,
                    beforeSend: function () {
                        /!*$(".lds-ellipsis").css('display', 'block');
                        $('.wizard-content').addClass('disabledDiv');*!/
                    },
                    success: function (data) {
                        //var response = JSON.parse(data);

                        //$('#order_id').val(response['orderId']);


                    }
                });
				return false;*/
				/*formEl.ajaxSubmit({
					success: function() {
						KTApp.unprogress(btn);
						//KTApp.unblock(formEl);

						swal.fire({
							"title": "",
							"text": "The application has been successfully submitted!",
							"type": "success",
							"confirmButtonClass": "btn btn-secondary"
						});
					}
				});*/
			}
		});
	}

	return {
		// public functions
		init: function() {
			wizardEl = KTUtil.get('kt_wizard_v4');
			formEl = $('#kt_form');

			initWizard();
			initValidation();
			initSubmit();
		}
	};
}();

jQuery(document).ready(function() {
	KTWizard4.init();
});
