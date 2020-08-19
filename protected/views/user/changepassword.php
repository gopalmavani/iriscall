<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
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
            <!-- begin:: Subheader -->
            <?php echo $this->renderPartial('/user/profile-header',['model'=>$model]);  ?>
            <!-- end:: Subheader -->
            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">
                    <button class="kt-app__aside-close" id="kt_user_profile_aside_close"><i class="la la-close"></i>
                    </button>
                    <!--Begin:: App Aside-->
                    <?php echo $this->renderPartial('/user/profile-aside',['model'=>$model]);  ?>
                    <!--End:: App Aside-->
                    <!--Begin:: App Content-->
                    <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="kt-portlet">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">Change Password<small>Change your account password</small></h3>
                                        </div>
                                    </div>
                                    <form class="kt-form kt-form--label-right" id="password_change" method="post">
                                        <div class="kt-portlet__body">
                                            <div class="kt-section kt-section--first">
                                                <div class="kt-section__body">
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">Current Password</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="password" name="current_password" id="current_password" class="form-control form-control-line">
                                                        </div>
                                                        <span class="old_password_error" style="color:red"></span><br />
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="password" id="new_password" name="new_password" class="form-control form-control-line">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">Verify Password</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="password" id="confirm-pass" name="confirm_password" class="form-control form-control-line">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-portlet__foot">
                                            <div class="kt-form__actions">
                                                <div class="row">
                                                    <div class="col-lg-3 col-xl-3"> </div>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <button type="submit" class="change-password btn btn-primary">Submit</button>
                                                        &nbsp;
                                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End:: App Content-->
                </div>
            </div>
            <!-- end:: Content -->
        </div>
    </div>
</div>
<script>
    let email = "<?= $model->email; ?>";
    let verify_pass_url = "<?= Yii::app()->createUrl('user/verifyOldPassword'); ?>";
    let changePasswordURL = '<?php echo Yii::app()->createUrl('user/updatePassword')?>';

    $("form[id='password_change']").validate({
        debug: true,
        errorClass: "help-block",
        errorElement: "div",
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            'current_password': {
                required: true,
                remote : {
                    url: verify_pass_url,
                    type: "POST",
                    data: {
                        email: email
                    }
                }
            },
            'new_password': {
                required: true,
                minlength: 8
            },
            'confirm_password': {
                required: true,
                equalTo: '#new_password'
            }
        },
        messages: {
            'current_password': {
                required: "Please enter current password",
                remote: "Issue with current password"
            },
            'new_password': {
                required: "Please enter new password",
                minlength: "Your password must be at least 8 characters long"
            },
            'confirm_password': {
                required: "Please enter confirm password",
                equalTo: "Please enter the same password as above"
            }
        },
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
            $(element).parent().parent().addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).parent().parent().removeClass('has-error');
        },
        submitHandler: function (form) {
            form.submit();
            /*$.ajax({
                type: "POST",
                url: changePasswordURL,
                data: $('form').serialize(),
                beforeSend: function () {
                    $(".overlay").removeClass("hide");
                },
                success: function (data) {
                    let resp = JSON.parse(data);
                    if(resp['status'] == 1){
                        window.location.reload();
                    }
                }
            });*/
        }
    });
</script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jquery-validation/jquery.validate.min.js', CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jquery-validation/additional-methods.min.js', CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jquery-validation/jquery.md5.js', CClientScript::POS_BEGIN);
?>