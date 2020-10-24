<?php
$this->pageTitle = "Create new Account";
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/signature/css/jquery.signature.css');
?>
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
<style>
    .datepicker{
        width: unset;
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
                        <a href="<?= Yii::app()->createUrl('telecom/newconnection'); ?>" class="text-muted">New Account</a>
                    </li>
                </ul>
            </div>
        </div>
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
            <div class="card-body">
                <form class="form" id="new-connection" method="POST">
                    <h4 class="mb-10 font-weight-bold text-dark">Create New Account</h4>
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
                                    <select  name="rate" id="rate" class="form-control form-control-line">
                                        <option value="Iriscall">Iriscall</option>
                                        <option value="Iriscall Home">Iriscall Home</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="col-form-label col-4">Tariff Plan</label>
                                <div class="col-8">
                                    <select  name="tariff_plan" id="tariff_plan" class="form-control form-control-line">
                                        <?php foreach ($products as $product) { ?>
                                            <option value="<?php echo $product['product_id'];?>" <?php if ($tariff_product_id == $product['product_id']) {echo "selected";}?>><?php echo $product['name'] ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="col-form-label col-4">Extra options</label>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-solid form-control-lg" name="extra_options" value="<?= $telecom_account->extra_options; ?>" />
                                </div>
                                <span class="form-text text-muted col-4">Extra data or calls.</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-1 ml-5">
                            <span class="switch switch-outline switch-icon switch-success">
                                <label>
                                    <input type="checkbox" name="is_voice_mail_enabled" class="is_voice_mail_enabled" "<?php if ($telecom_account->is_voice_mail_enabled == 1){ echo "checked";} ?>">
                                    <span></span>
                                </label>
                            </span>
                        </div>
                        <label class="col-3 col-form-label">Use Voice mail</label>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-4">Comments</label>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-solid form-control-lg" name="comments" placeholder="Extra details" value="<?= $telecom_account->comments; ?>" />
                        </div>
                        <span class="form-text text-muted col-4">Any extra details that need to be mentioned.</span>
                    </div>
                    <hr>
                    <h4 class="mb-10 font-weight-bold text-dark">Applicable for those who have received the SIM card kit</h4>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="col-form-label col-4">Phone Number</label>
                                <div class="col-8">
                                    <input type="tel" class="form-control form-control-solid form-control-lg" name="phone_number" value="<?= $telecom_account->phone_number; ?>"/>
                                </div>
                                <span class="form-text text-muted col-4">Please enter your new phone number.</span>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="col-form-label col-4">Sim Card Number</label>
                                <div class="col-8">
                                    <input type="tel" class="form-control form-control-solid form-control-lg" name="sim_card_number" placeholder="Sim card number" value="<?= $telecom_account->sim_card_number; ?>" />
                                </div>
                                <span class="form-text text-muted col-4">Please enter new sim card number.</span>
                            </div>
                        </div>
                    </div>
                    <div class="row signature">

                    </div>
                    <div class="d-flex align-items-center" style="float: right;">
                        <a href="<?= Yii::app()->createUrl('telecom/index'); ?>" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base mr-3">Back</a>
                        <button type="submit" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">Create Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/signature/js/jquery.signature.js"></script>
<script type="text/javascript">
    $("#new-connection").validate({
        debug: true,
        errorClass: "text-danger",
        errorElement: "div",
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {

        },
        messages: {

        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $(document).ready(function () {
        $('.signature').signature({color: '#00f'});
    });
</script>