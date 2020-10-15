<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" />
<style>
    .has-error input {
        border-color: red;
    }
</style>
<div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Details-->
        <div class="d-flex align-items-center flex-wrap mr-2">
            <!--begin::Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Edit User</h5>
            <!--end::Title-->
            <!--begin::Separator-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
            <!--end::Separator-->
            <!--begin::Search Form-->
            <div class="d-flex align-items-center" id="kt_subheader_search">
                <span class="text-dark-50 font-weight-bold" id="kt_subheader_total"><?= $model->full_name; ?></span>
            </div>
            <!--end::Search Form-->
        </div>
        <!--end::Details-->
        <!--begin::Toolbar-->

        <!--end::Toolbar-->
    </div>
</div>
<div class="d-flex flex-column-fluid">
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
            <div class="card-header card-header-tabs-line nav-tabs-line-3x">
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                        <!--begin::Item-->
                        <li class="nav-item mr-3">
                            <a class="nav-link active" data-toggle="tab" href="#kt_user_edit_tab_1">
														<span class="nav-icon">
															<span class="svg-icon">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24" />
																		<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
																		<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                <span class="nav-text font-size-lg">Profile</span>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_2">
														<span class="nav-icon">
															<span class="svg-icon">
																<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24" />
																		<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																		<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                <span class="nav-text font-size-lg">Account</span>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_3">
														<span class="nav-icon">
															<span class="svg-icon">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
																		<path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
																		<path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
                                <span class="nav-text font-size-lg">Change Password</span>
                            </a>
                        </li>
                        <!--end::Item-->
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active px-7" id="kt_user_edit_tab_1" role="tabpanel">
                        <form class="form" id="update-Profile" method="POST">
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-7 my-2">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <label class="col-3"></label>
                                        <div class="col-9">
                                            <h6 class="text-dark font-weight-bold mb-10">Customer Info:</h6>
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-lg-right text-left">First Name</label>
                                        <div class="col-9">
                                            <input type="text" name="first_name" value="<?php echo $model->first_name ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-lg-right text-left">Middle Name</label>
                                        <div class="col-9">
                                            <input type="text" name="middle_name" value="<?php echo $model->middle_name ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-lg-right text-left">Last Name</label>
                                        <div class="col-9">
                                            <input type="text" name="last_name" value="<?php echo $model->last_name ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-lg-right text-left">Gender</label>
                                        <div class="col-9 col-form-label">
                                            <div class="radio-inline">
                                                <label class="radio radio-success">
                                                    <input value="1" <?php if ($model->gender == 1) { echo "checked";} ?> type="radio" class="check" id="minimal-radio-1" name="gender">
                                                    <span></span>Male
                                                </label>
                                                <label class="radio radio-success">
                                                    <input value="2" <?php if ($model->gender != 1) { echo "checked";} ?> type="radio" class="check" id="minimal-radio-1" name="gender">
                                                    <span></span>Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-lg-right text-left">Date Of Birth</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text" name="date_of_birth" value="<?php echo $model->date_of_birth ?>" id="date_of_birth" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center" style="float: right;">
                                        <a href="<?= Yii::app()->createUrl('home/index'); ?>" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base">Back</a>
                                        <button type="submit" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane show px-7" id="kt_user_edit_tab_2" role="tabpanel">
                        <form class="form" id="update-account-profile" method="POST">
                            <div class="row">
                                <div class="col-xl-12 my-2">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <label class="col-1"></label>
                                        <div class="col-11">
                                            <h6 class="text-dark font-weight-bold mb-10">Account Info:</h6>
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-lg-right text-left">Building Number</label>
                                        <div class="col-4">
                                            <input type="text" name="building_num" value="<?php echo $model->building_num ?>" class="form-control form-control-line">
                                        </div>
                                        <label class="col-form-label col-2 text-lg-right text-left">Postcode</label>
                                        <div class="col-4">
                                            <input type="text" name="postcode" value="<?php echo $model->postcode ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-lg-right text-left">Street</label>
                                        <div class="col-4">
                                            <input type="text" name="street" value="<?php echo $model->street ?>" class="form-control form-control-line">
                                        </div>
                                        <label class="col-form-label col-2 text-lg-right text-left">Country</label>
                                        <div class="col-4">
                                            <select  name="country" id="country-select" class="form-control form-control-line">
                                                <?php
                                                $country = Yii::app()->ServiceHelper->getCountry();?>
                                                <option value="">Select Country</option>
                                                <?php foreach ($country as $key => $value) { ?>
                                                    <option value="<?php echo $key;?>" <?php if ($model->country == $key) {echo "selected";}?>><?php echo $value ?></option>
                                                <?php  } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-lg-right text-left">Region</label>
                                        <div class="col-4">
                                            <input type="text" name="region" value="<?php echo $model->region ?>" class="form-control form-control-line">
                                        </div>
                                        <label class="col-form-label col-2 text-lg-right text-left">phone</label>
                                        <div class="col-4">
                                            <input type="text" name="phone" value="<?php echo $model->phone ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-lg-right text-left">City</label>
                                        <div class="col-4">
                                            <input type="text" name="city" value="<?php echo $model->city ?>" class="form-control form-control-line">
                                        </div>
                                        <label class="col-form-label col-2 text-lg-right text-left">Language</label>
                                        <div class="col-4">
                                            <select  name="language" id="language-select" class="form-control form-control-line">
                                                <?php
                                                $lang = ["English","Dutch","French"];?>
                                                <option value="">Select Language</option>
                                                <?php foreach ($lang as $key => $value) { ?>
                                                    <option value="<?php echo $key;?>" <?php if ($model->language == $key) {echo "selected";}?>><?php echo $value ?></option>
                                                <?php  } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-1"></div>
                                        <div class="col-1">
                                            <span class="switch switch-outline switch-icon switch-success">
                                                <label>
                                                    <input type="checkbox" name="is_business_type" class="is_business_type" />
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                        <label class="col-3 col-form-label">Add Business details:</label>
                                    </div>

                                    <div class="business_details" style="display: none;">
                                        <div class="form-group row">
                                            <label class="col-form-label col-2 text-lg-right text-left">Business Name</label>
                                            <div class="col-4">
                                                <input type="text" name="business_name" id="business_name" value="<?php echo $model->business_name ?>" class="form-control form-control-line">
                                            </div>
                                            <label class="col-form-label col-2 text-lg-right text-left">Postcode</label>
                                            <div class="col-4">
                                                <input type="text" name="vat_number" id="vat_number" value="<?php echo $model->vat_number ?>" class="form-control form-control-line">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-1"></div>
                                            <div class="col-1">
                                            <span class="switch switch-outline switch-icon switch-success">
                                                <label>
                                                    <input type="checkbox" name="is_different_address" class="is_different_address" "<?php if (!empty($model->business_name) && (($model->busAddress_building_num != $model->building_num) || ($model->busAddress_street != $model->street) || ($model->busAddress_region != $model->region) || ($model->busAddress_city != $model->city) || ($model->busAddress_postcode != $model->postcode) || ($model->busAddress_country != $model->country))){ echo "checked";} ?>">
                                                    <span></span>
                                                </label>
                                            </span>
                                            </div>
                                            <label class="col-3 col-form-label">Use Different address:</label>
                                        </div>

                                        <div class="differentAddress" style="display: none;">
                                            <div class="form-group row">
                                                <label class="col-form-label col-2 text-lg-right text-left">Building Number</label>
                                                <div class="col-4">
                                                    <input type="text" name="busAddress_building_num" value="<?php echo $model->busAddress_building_num ?>" class="form-control form-control-line">
                                                </div>
                                                <label class="col-form-label col-2 text-lg-right text-left">Postcode</label>
                                                <div class="col-4">
                                                    <input type="text" name="busAddress_postcode" value="<?php echo $model->busAddress_postcode ?>" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-form-label col-2 text-lg-right text-left">Street</label>
                                                <div class="col-4">
                                                    <input type="text" name="busAddress_street" value="<?php echo $model->busAddress_street ?>" class="form-control form-control-line">
                                                </div>
                                                <label class="col-form-label col-2 text-lg-right text-left">Country</label>
                                                <div class="col-4">
                                                    <select  name="busAddress_country" id="country-select" class="form-control form-control-line">
                                                        <?php
                                                        $country = Yii::app()->ServiceHelper->getCountry();?>
                                                        <option value="">Select Country</option>
                                                        <?php foreach ($country as $key => $value) { ?>
                                                            <option value="<?php echo $key;?>" <?php if ($model->busAddress_country == $key) {echo "selected";}?>><?php echo $value ?></option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <!--begin::Group-->
                                            <div class="form-group row">
                                                <label class="col-form-label col-2 text-lg-right text-left">Region</label>
                                                <div class="col-4">
                                                    <input type="text" name="busAddress_region" value="<?php echo $model->busAddress_region ?>" class="form-control form-control-line">
                                                </div>
                                                <label class="col-form-label col-2 text-lg-right text-left">phone</label>
                                                <div class="col-4">
                                                    <input type="text" name="business_phone" value="<?php echo $model->business_phone ?>" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <!--end::Group-->
                                            <div class="form-group row">
                                                <label class="col-form-label col-2 text-lg-right text-left">City</label>
                                                <div class="col-4">
                                                    <input type="text" name="busAddress_city" value="<?php echo $model->busAddress_city ?>" class="form-control form-control-line">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center" style="float: right;">
                                        <a href="<?= Yii::app()->createUrl('home/index'); ?>" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base">Back</a>
                                        <button type="submit" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane show px-7" id="kt_user_edit_tab_3" role="tabpanel">
                        <form class="form" id="update-profile-password" method="POST">
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-7 my-2">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <label class="col-3"></label>
                                        <div class="col-9">
                                            <h6 class="text-dark font-weight-bold mb-10">Change your password:</h6>
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-lg-right text-left">Current Password</label>
                                        <div class="col-9">
                                            <input type="password" name="current_password" id="current_password" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-lg-right text-left">New Password</label>
                                        <div class="col-9">
                                            <input type="password" id="new_password" name="new_password" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-lg-right text-left">Verify Password</label>
                                        <div class="col-9">
                                            <input type="password" id="confirm-pass" name="confirm_password" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                    <div class="d-flex align-items-center" style="float: right;">
                                        <a href="<?= Yii::app()->createUrl('home/index'); ?>" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base">Back</a>
                                        <button type="submit" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script type="text/javascript">
    $('#date_of_birth').bootstrapMaterialDatePicker({maxDate: new Date(),time:false});
    var email = "<?= $model->email; ?>";
    var verify_pass_url = "<?= Yii::app()->createUrl('user/verifyOldPassword'); ?>";

    $(document).ready(function(){
        if($('.is_different_address').is(":checked")){
            $(".differentAddress").show();
        }else {
            $(".differentAddress").hide();
        }
        $('.is_different_address').on('change',function(){
            if($('.is_different_address').is(":checked")){
                $(".differentAddress").show();
            }else {
                $(".differentAddress").hide();
            }
        });
        $('.is_business_type').on('change',function(){
            if($('.is_business_type').is(":checked")){
                $(".business_details").show();
            }else {
                $(".business_details").hide();
            }
        });
    });

    $("#update-Profile").validate({
        debug: true,
        errorClass: "text-danger",
        errorElement: "div",
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            first_name:"required",
            last_name:"required",
            date_of_birth:"required"
        },
        messages: {
            first_name: "Please enter First name ",
            last_name: "Please enter Last name",
            date_of_birth: "Please select Date-Of-Birth"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    $("#update-account-profile").validate({
        debug: true,
        errorClass: "text-danger",
        errorElement: "div",
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            building_num:"required",
            postcode: {
                required: true
            },
            street:"required",
            country:"required",
            phone:{
                required: true,
                number: true
            },
            city:"required",
            language: "required",
            busAddress_building_num: {
                required: "#busAddress_building_num:visible"
            },
            busAddress_street: {
                required: "#busAddress_street:visible"
            },
            busAddress_city: {
                required: "#busAddress_city:visible"
            },
            busAddress_postcode:{
                required: "#busAddress_postcode:visible"
            },
            busAddress_country: {
                required: "#busAddress_country:visible"
            },
            business_name:{
                required: "#business_name:visible"
            },
            vat_number:{
                required: "#vat_number:visible"
            }
        },
        messages: {
            building_num: "Please enter building number ",
            postcode: {
                required:"Please enter postcode"
            },
            street: "Please enter street",
            country: "Please select country",
            phone: {
                required: "Please enter phone",
                number: "Phone must be number"
            },
            city: "Please enter city",
            language:"Please select language",
            busAddress_building_num : 'Please enter building number',
            busAddress_street : 'Please enter street',
            busAddress_city : 'Please enter city',
            busAddress_postcode : {
                required:"Please enter postcode"
            },
            busAddress_country : 'Please select country',
            business_name: "Please enter your business Name",
            vat_number: "Please enter Vat number"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    $("form[id='update-profile-password']").validate({
        debug: true,
        errorClass: "text-danger",
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
        }
    });
</script>