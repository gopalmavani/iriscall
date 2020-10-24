<?php
/* @var $this TelecomController */
/* @var $model TelecomUserDetails */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right" style="margin: 0px 15px 15px 0px;">
            <?php echo CHtml::link('Go to list', array('telecom/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs">
                <li id="profile_tab" class="active">
                    <a href="#telecom-user-profile" data-toggle="tab"> Profile Information</a>
                </li>
            </ul>
            <div class="block-content tab-content">
                <div class="tab-pane active" id="telecom-user-profile">
                    <div class="block-content block-content-narrow">
                        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'id' => 'telecom-info-form',
                            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array(
                                'name' => 'UserProfile',
                                'enctype' => 'multipart/form-data',
                            )
                        ));
                        ?>
                        <div class="row">
                            <div class="form-material has-error">
                                <p id="userAddError" class="help-block " style="display: none;">User already saved</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 <?php echo $model->hasErrors('first_name') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'first_name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'First Name')); ?>
                            </div>
                            <div class="col-md-4 <?php echo $model->hasErrors('middle_name') ? 'has-error' : ''; ?>">
                                <?php echo $form->textFieldControlGroup($model, 'middle_name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Middle Name')); ?>
                            </div>
                            <div class="col-md-4  <?php echo $model->hasErrors('last_name') ? 'has-error' : ''; ?> ">
                                <?php echo $form->textFieldControlGroup($model, 'last_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Last Name')); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 email-validate <?php echo $model->hasErrors('email') ? 'has-error' : ''; ?> ">
                                <?php echo $form->textFieldControlGroup($model, 'email', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                <p id='email-valid' class='animated fadeInDown  help-block'>Please enter valid Email address.</p>                    </div>
                            <div class="col-md-4 email-validate <?php echo $model->hasErrors('extra_email') ? 'has-error' : ''; ?> ">
                                <?php echo $form->textFieldControlGroup($model, 'extra_email', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                <p id='email-valid' class='animated fadeInDown  help-block'>Please enter valid Email address.</p>                    </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="<?php echo $model->hasErrors('language') ? 'has-error' : ''; ?>">
                                        <?php echo $form->dropDownListControlGroup($model,'language', array('English'=>'English', 'Dutch'=>'Dutch', 'French'=>'French', 'Nederlands'=>'Nederlands'), array('prompt' => 'Select Language', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Personal Information</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('date_of_birth') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->labelEx($model, 'dateOfBirth', array('class' => 'control-label')); ?>
                                        <span class="required" aria-required="true">*</span>
                                        <?php
                                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $model,
                                            'attribute' => 'date_of_birth',
                                            //'value'=>$model->dateOfBirth,
                                            // additional javascript options for the date picker plugin
                                            'options' => array(
                                                'showAnim' => '',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                                'dateFormat' => 'yy-mm-dd',
                                                'maxDate' => date('Y-m-d'),
                                                'changeYear' => true,           // can change year
                                                'changeMonth' => true,
                                                'yearRange' => '1900:' . date('Y'),
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'form-control',
                                                //'style'=>'height:20px;background-color:green;color:white;',
                                            ),
                                        ));
                                        ?>
                                        <span class="help-block"><?php echo $form->error($model, 'date_of_birth'); ?> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php echo $form->labelEx($model, 'gender', array('class' => 'control-label')); ?>
                                <div class="<?php echo $model->hasErrors('gender') ? 'has-error' : ''; ?>">
                                    <div class="radio">
                                        <?php echo $form->radioButtonList($model, 'gender', array(
                                            '1' => 'Male', '2' => 'Female',
                                        ),array(
                                            'labelOptions'=>array('style'=>'display:inline'), // add this code
                                            'separator'=>'  ')); ?>
                                    </div>
                                    <span class="help-block"><?php echo $form->error($model, 'gender'); ?> </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('phone') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'phone', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('landline_number') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'landline_number', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('send_invoice_via') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->dropDownListControlGroup($model,'send_invoice_via', array('Email'=>'Email', 'Post'=>'Post', 'Post + Email'=>'Post + Email'), array('prompt' => 'Send Invoice Via', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('invoice_detail_type') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->dropDownListControlGroup($model,'invoice_detail_type', array('Standard'=>'Standard', 'FullDetail'=>'FullDetail', 'FullFreeDetail'=>'FullFreeDetail', 'NoDetail'=>'NoDetail'), array('prompt' => 'Invoice Detail type', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Address</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('building_num') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'building_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('bus_num') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'bus_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('street') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'street', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('city') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'city', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('postcode') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'postcode', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('country') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->dropDownListControlGroup($model, 'country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('nationality') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->dropDownListControlGroup($model, 'nationality', Yii::app()->ServiceHelper->getNationality(), array('prompt' => 'Select Nationality', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Business Info</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('business_name') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'business_name', array('class' => 'form-control', 'label' => 'Business Name')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('vat_number') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'vat_number', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('business_country') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->dropDownListControlGroup($model, 'business_country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('vat_rate') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->textFieldControlGroup($model, 'vat_rate', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('comments') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'comments', array('class' => 'form-control','label'=>'Extra Comments')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="hiddendefault">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Billing Info</h4>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" id="diff_address" name="Diffrent_Address">
                                    <label id="check_box">Use Different Address for billing purpose</label>
                                </div>
                            </div>
                            <div id="companyAddress">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Billing Address</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('billing_name') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'billing_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'Building Name')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('billing_building_num') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'billing_building_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('billing_bus_num') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'billing_bus_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('billing_country') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->dropDownListControlGroup($model, 'billing_country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('billing_street') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'billing_street', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('billing_city') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'billing_city', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group <?php echo $model->hasErrors('billing_postcode') ? 'has-error' : ''; ?> ">
                                                <?php echo $form->textFieldControlGroup($model, 'billing_postcode', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Payment Info</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('payment_method') ? 'has-error' : ''; ?> ">
                                        <?php echo $form->dropDownListControlGroup($model, 'payment_method', ['SEPA'=>'SEPA', 'CreditCard'=>'CreditCard', 'BankTransfer'=>'BankTransfer'], array('prompt' => 'Select Payment Method', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="credit-card-payment-div" style="display: none">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo $model->hasErrors('credit_card_number') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($model, 'credit_card_number', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'Credit card number')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo $model->hasErrors('credit_card_type') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($model, 'credit_card_type', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'Type of credit card')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo $model->hasErrors('credit_card_name') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($model, 'credit_card_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'Credit Card Name')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo $model->hasErrors('expiry_date_month') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($model, 'expiry_date_month', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'Expiration Month of credit card')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo $model->hasErrors('expiry_date_year') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($model, 'expiry_date_year', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'Expiration Year of credit card')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bank-payment-div" style="display: none">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo $model->hasErrors('bank_name') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($model, 'bank_name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','label'=>'Building Name')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo $model->hasErrors('bank_building_num') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($model, 'bank_building_num', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo $model->hasErrors('bank_street') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($model, 'bank_street', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo $model->hasErrors('bank_country') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->dropDownListControlGroup($model, 'bank_country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo $model->hasErrors('bank_city') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($model, 'bank_city', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group <?php echo $model->hasErrors('bank_postcode') ? 'has-error' : ''; ?> ">
                                            <?php echo $form->textFieldControlGroup($model, 'bank_postcode', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Upload Documents</h4>
                            </div>

                            <?php if(isset($documents)) { ?>
                                <div class="col-md-12">
                                    <span class="text-muted" style="margin: 10px 0">Uploading New documents would remove the previous ones</span>
                                </div>
                                <div class="row">
                                    <?php foreach ($documents as $document) { ?>
                                        <div class="col-md-4" style="margin-left: 15px;">
                                            <a href="<?= Yii::app()->baseUrl.'/'.$document['document_path']; ?>" download class="btn btn-primary">Download <?= $document['document_name']; ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php }?>

                            <div class="col-md-12">
                                <label class="control-label" for="TelecomUserDetails_passport">Passport file</label>
                                <input type="file" name="passport" id="passport_file">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label" for="TelecomUserDetails_sepa">SEPA file</label>
                                <input type="file" name="sepa" id="sepa_file">
                            </div>
                            <div class="col-md-12">
                                <label class="control-label" for="TelecomUserDetails_aoa">AOA file</label>
                                <input type="file" name="aoa" id="aoa_file">
                            </div>
                        </div>

                    </div>
                    <div class="row col-md-12" align="right">
                        <div class="form-group">
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Save and Continue' : 'Save', array(
                                'class' => 'btn btn-primary',
                            )); ?>
                            <?php echo CHtml::link('Cancel', array('telecom/index'),
                                array(
                                    'class' => 'btn btn-default'
                                )
                            );
                            ?>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#company").hide();
        $("#companyAddress").hide();

        $("#TelecomUserDetails_payment_method").change(function() {
            var payment_method = $('option:selected', this).text();
            if(payment_method == 'CreditCard'){
                $('.bank-payment-div').hide();
                $('.credit-card-payment-div').show();
            } else {
                if(payment_method == 'BankTransfer'){
                    $('.bank-payment-div').show();
                    $('.credit-card-payment-div').hide();
                } else {
                    $('.bank-payment-div').hide();
                    $('.credit-card-payment-div').hide();
                }
            }
        });
    });

    showBusinessField();
    $("#Addresses_address_type").change(function (e) {
        showBusinessField();
    });

    $('#telecom-info-form input').on('change', function() {
        var value = ($('input[name=Business]:checked', '#telecom-info-form').val());
        if(value == 2){
            $("#company").show();
            if ($('#diff_address').is(":checked")){
                $("#companyAddress").show();
            }else{
                $("#companyAddress").hide();
            }
        }
        else{
            $("#company").hide();
        }

    });
    $('#diff_address').on('change', function() {
        if ($('#diff_address').is(":checked")){
            $("#companyAddress").show();
        }else{
            $("#companyAddress").hide();
        }
    });
    function showBusinessField() {
        if ($('#Addresses_address_type').val() == 1) {
            $('#business_company').show();
            $('#business_vat').show();
            /* Show Business dynamic fields */
            $('#business_fields').show();
        } else {
            $('#business_company').hide();
            $('#business_vat').hide();
            /* Hide Business dynamic fields */
            $('#business_fields').hide();
        }
    }

    var validator = $("form[id='telecom-info-form']").validate({
        debug: true,
        errorClass: "help-block",
        errorElement: "div",
        rules: {
            'TelecomUserDetails[first_name]':{
                required: true
            },
            'TelecomUserDetails[last_name]':{
                required: true
            },
            'TelecomUserDetails[email]': {
                required: true,
                email: true,
                remote: {
                    url: '<?php  echo Yii::app()->createUrl("/admin/telecom/checkEmail");  ?>',
                    type: 'post',
                    data: {
                        'email': function () {
                            return $('#TelecomUserDetails_email').val();
                        }
                    }
                }
            },
            'TelecomUserDetails[phone]':{
                required: true,
                number: true
            },
            'TelecomUserDetails[date_of_birth]':{
                required: true
            },
            'TelecomUserDetails[street]': {
                required: true
            },
            'TelecomUserDetails[building_num]': {
                required: true
            },
            'TelecomUserDetails[city]': {
                required: true
            },
            'TelecomUserDetails[postcode]': {
                required: true
            },
            'TelecomUserDetails[country]': {
                required: true
            },
            'TelecomUserDetails[language]':{
                required:true
            }
        },
        messages:{
            'TelecomUserDetails[first_name]': {
                required: "Please enter first name."
            },
            'TelecomUserDetails[last_name]': {
                required: "Please enter last name."
            },
            'TelecomUserDetails[email]': {
                required: "Please enter email.",
                email: "Please enter valid email.",
                remote: "Email not registered in Iriscall."
            },
            'TelecomUserDetails[phone]':{
                required: "Please enter phone number.",
                number: "it contains only numbers."
            },
            'TelecomUserDetails[date_of_birth]': {
                required: "Please select your date of birth."
            },
            'TelecomUserDetails[street]': {
                required: "Please enter street name."
            },
            'TelecomUserDetails[building_num]': {
                required: "Please enter house number."
            },
            'TelecomUserDetails[city]': {
                required: "Please enter city name."
            },
            'TelecomUserDetails[postcode]': {
                required: "Please enter postal code."
            },
            'TelecomUserDetails[country]': {
                required: "Please select country."
            },
            'TelecomUserDetails[language]': {
                required: "Please select language."
            }
        },
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            $(element).parent().parent().addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).parent().parent().removeClass('has-error');
        },
        submitHandler:function (form) {
            $(".overlay").removeClass("hide");
            form.submit();
        }
    });
</script>