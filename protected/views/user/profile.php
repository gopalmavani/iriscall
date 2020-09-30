<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" />
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
                                            <h3 class="kt-portlet__head-title">Personal Information <small>update your personal information</small></h3>
                                        </div>
                                    </div>
                                    <form class="kt-form kt-form--label-right" id="update-Profile" method="post">
                                        <div class="kt-portlet__body">
                                            <div class="kt-section kt-section--first">
                                                <div class="kt-section__body">
                                                    <div class="row">
                                                        <label class="col-xl-3"></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <h3 class="kt-section__title kt-section__title-sm">Customer Info:</h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">First Name *</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="text"name="first_name" value="<?php echo $model->first_name ?>" class="form-control form-control-line">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">Middle Name</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="text"name="middle_name" value="<?php echo $model->middle_name ?>" class="form-control form-control-line">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">Last Name *</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="text"name="last_name" value="<?php echo $model->last_name ?>" class="form-control form-control-line">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">Gender</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input tabindex="7" value="1" <?php if ($model->gender == 1) { echo "checked";} ?> type="radio" class="check" id="minimal-radio-1" name="gender">
                                                            <label for="minimal-radio-1">Male</label>
                                                            <input tabindex="8" type="radio" class="check" id="minimal-radio-2" <?php if ($model->gender != 1) { echo "checked";} ?> value="2" name="gender" >
                                                            <label for="minimal-radio-2">Female</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">Date Of Birth *</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="text"name="date_of_birth" value="<?php echo $model->date_of_birth ?>" id="date_of_birth" class="form-control form-control-line">
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
                                                        <button type="submit" class="btn btn-primary">Submit</button>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script type="text/javascript">
    $('#date_of_birth').bootstrapMaterialDatePicker({maxDate: new Date(),time:false});
    $("#update-Profile").validate({
        rules: {
            first_name:"required",
            last_name:"required",
            date_of_birth:"required"
        },
        messages: {
            first_name: "Please enter First name ",
            last_name: "Please enter Lasrt name",
            date_of_birth: "Please select Date-Of-Birth"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>