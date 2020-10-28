<?php
$this->pageTitle = "Create new Account";
?>
<style>
    .datepicker{
        width: unset;
    }
    .wrapper {
        position: relative;
        width: 400px;
        height: 200px;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .signature-pad {
        position: absolute;
        left: 0;
        top: 0;
        width:400px;
        height:200px;
        background-color: white;
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
                    <?php $this->renderPartial('product-pricing', ['products' => $products]); ?>
                    <hr>
                    <h4 class="mb-10 font-weight-bold text-dark">New Account Details</h4>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="col-form-label col-8">Account User name</label>
                                <div class="col-6">
                                    <input type="text" class="form-control form-control-solid form-control-lg" name="user_name" placeholder="User name" value="<?= $telecom_account->user_name; ?>" />
                                </div>
                                <span class="form-text text-muted col-4">An identifiable account name.</span>
                            </div>
                        </div>
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
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group row mt-5">
                                <div class="col-1 ml-5">
                                    <span class="switch switch-outline switch-icon switch-success">
                                        <label>
                                            <input type="checkbox" name="is_voice_mail_enabled" class="is_voice_mail_enabled" "<?php if ($telecom_account->is_voice_mail_enabled == 1){ echo "checked";} ?>">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                                <div class="col-3 ml-5">
                                    <label class="col-form-label">Use Voice mail</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="col-form-label col-8">Rate</label>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-solid form-control-lg" name="rate" value="<?= $telecom_account->rate;?>" disabled/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="col-form-label col-4">Extra options</label>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-solid form-control-lg" name="extra_options" value="<?/*= $telecom_account->extra_options; */?>" />
                                </div>
                                <span class="form-text text-muted col-4">Extra data or calls.</span>
                            </div>
                        </div>
                    </div>-->
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
                    <hr>
                    <div class="signature-div">
                        <h4 class="font-weight-bold text-dark">Please Sign here</h4>
                        <div class="wrapper">
                            <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
                        </div>
                        <!--<button id="save-png" type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">Save as PNG</button>-->
                        <button id="undo" type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base" style="margin: 10px">Undo</button>
                        <button id="clear" type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base" style="margin: 10px">Clear</button>
                        <input type="text" class="form-control form-control-solid form-control-lg signature" name="signature" hidden/>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/plugins/signature/docs/js/signature_pad.umd.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var canvas = document.getElementById('signature-pad');

        // Adjust canvas coordinate space taking into account pixel ratio,
        // to make it look crisp on mobile devices.
        // This also causes canvas to be cleared.
        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            var ratio =  Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        window.onresize = resizeCanvas;
        resizeCanvas();

        var signaturePad = new SignaturePad(canvas, {
            //backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
            backgroundColor: 'rgb(243, 246, 249)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
        });

        document.getElementById('clear').addEventListener('click', function () {
            signaturePad.clear();
        });

        document.getElementById('undo').addEventListener('click', function () {
            var data = signaturePad.toData();
            if (data) {
                data.pop(); // remove the last dot or line
                signaturePad.fromData(data);
            }
        });

        $("#new-connection").validate({
            debug: true,
            errorClass: "text-danger",
            errorElement: "div",
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            rules: {
                user_name: "required"
            },
            messages: {
                user_name: "Please enter the account user name"
            },
            submitHandler: function(form) {
                var error = 0;
                var message = "";
                if (signaturePad.isEmpty()) {
                    error++;
                    message = "You need to sign the document please";

                }
                if ($('.tariff_plan').val() == '') {
                    error++;
                    message = "You need to select the plan first";

                }
                if(error > 0){
                    Swal.fire({
                        text: message,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light"
                        }
                    });
                } else {
                    $('.signature').val(signaturePad.toDataURL('image/png'));
                    form.submit();
                }

            }
        });
    });
</script>