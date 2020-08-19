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
                                            <h3 class="kt-portlet__head-title">Billing Information <small>update your billing information</small></h3>
                                        </div>
                                    </div>
                                    <form class="kt-form kt-form--label-right" id="update-billing-information" method="post">
                                        <div class="kt-portlet__body">
                                            <div class="kt-section kt-section--first">
                                                <div class="kt-section__body">
                                                    <div class="form-group row">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Private Account</label>
                                                        <div class="col-lg-6 col-xl-6">
                                                            <span class="switch switch-sm">
                                                                <label>
                                                                    <input type="checkbox" name="private_disclosure" checked="<?php if($model->privacy_disclosure == 1){echo "checked";} ?>">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                            <span class="form-text text-muted">To keep your account details private w.r.t your parent.</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-xl-1"></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <h3 class="kt-section__title kt-section__title-sm">Address Info:</h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Building Number *</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="building_num" value="<?php echo $model->building_num ?>" class="form-control form-control-line">
                                                        </div>
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Postcode</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="postcode" value="<?php echo $model->postcode ?>" class="form-control form-control-line">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Street *</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="street" value="<?php echo $model->street ?>" class="form-control form-control-line">
                                                        </div>
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Country</label>
                                                        <div class="col-lg-4 col-xl-4">
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
                                                    <div class="form-group row">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Region *</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="region" value="<?php echo $model->region ?>" class="form-control form-control-line">
                                                        </div>
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Phone</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="phone" value="<?php echo $model->phone ?>" class="form-control form-control-line">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">City *</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="city" value="<?php echo $model->city ?>" class="form-control form-control-line">
                                                        </div>
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Language</label>
                                                        <div class="col-lg-4 col-xl-4">
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

                                                    <div class="row">
                                                        <label class="col-xl-1"></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <h3 class="kt-section__title kt-section__title-sm">Business Details</h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Business Name *</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="business_name" value="<?php echo $model->business_name ?>" class="form-control form-control-line">
                                                        </div>
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Vat Number</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="vat_number" value="<?php echo $model->vat_number ?>" class="form-control form-control-line">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Use Different address</label>
                                                        <div class="col-lg-6 col-xl-6">
                                                            <span class="switch switch-sm">
                                                                <label>
                                                                    <input type="checkbox" name="is_different_address" class="is_different_address" "<?php if (!empty($model->business_name) && (($model->busAddress_building_num != $model->building_num) || ($model->busAddress_street != $model->street) || ($model->busAddress_region != $model->region) || ($model->busAddress_city != $model->city) || ($model->busAddress_postcode != $model->postcode) || ($model->busAddress_country != $model->country))){ echo "checked";} ?>">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                            <span class="form-text text-muted">To keep your business address different w.r.t personal address.</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row differentAddress">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Building Number *</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="busAddress_building_num" id="busAddress_building_num" value="<?php echo $model->busAddress_building_num ?>" class="form-control form-control-line">
                                                        </div>
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Postcode</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="busAddress_postcode" id="busAddress_postcode" value="<?php echo $model->busAddress_postcode ?>" class="form-control form-control-line">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row differentAddress">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Street *</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="busAddress_street" id="busAddress_street" value="<?php echo $model->busAddress_street ?>" class="form-control form-control-line">
                                                        </div>
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Country</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <select  name="busAddress_country" id="busAddress_country"  class="form-control form-control-line">
                                                                <?php
                                                                $country = Yii::app()->ServiceHelper->getCountry();?>
                                                                <option value="">Select Country</option>
                                                                <?php foreach ($country as $key => $value) { ?>
                                                                    <option value="<?php echo $key;?>" <?php if ($model->country == $key) {echo "selected";}?>><?php echo $value ?></option>
                                                                <?php  } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row differentAddress">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Region *</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="busAddress_region" id="busAddress_region" value="<?php echo $model->busAddress_region ?>" class="form-control form-control-line">
                                                        </div>
                                                        <label class="col-xl-2 col-lg-2 col-form-label">Phone</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="business_phone" id="business_phone" value="<?php echo $model->business_phone ?>" class="form-control form-control-line">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row differentAddress">
                                                        <label class="col-xl-2 col-lg-2 col-form-label">City *</label>
                                                        <div class="col-lg-4 col-xl-4">
                                                            <input type="text" name="busAddress_city" id="busAddress_city" value="<?php echo $model->busAddress_city ?>" class="form-control form-control-line">
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
<script type="text/javascript">
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
    });

    $("#update-billing-information").validate({
        rules: {
            building_num:"required",
            postcode: {
                required: true
            },
            street:"required",
            country:"required",
            phone:{
                required: true,
                number: true,
            },
            city:"required",
            language: "required",
            busAddress_building_num: {
                required: "#busAddress_building_num:visible",
            },
            busAddress_street: {
                required: "#busAddress_street:visible",
            },
            busAddress_city: {
                required: "#busAddress_city:visible",
            },
            busAddress_postcode:{
                required: "#busAddress_postcode:visible",
            },
            busAddress_country: {
                required: "#busAddress_country:visible",
            },
            //business_name:"required",
            // vat_number:"required"
        },
        messages: {
            building_num: "Please enter building number ",
            postcode: {
                required:"Please enter postcode",
            },
            street: "Please enter street",
            country: "Please select country",
            phone: {
                required: "Please enter phone",
                number: "Phone must be number",
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
            //business_name: "Please enter your business Name",
            // vat_number: "Please enter Vat number"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>