<?php
/* @var $this TelecomController */
/* @var $model TelecomUserDetails */

$this->pageTitle = 'View Telecom User';
?>
<style type="text/css">
    .block > .nav-tabs > li.active > a, .block > .nav-tabs > li.active > a:hover, .block > .nav-tabs > li.active > a:focus{
        color: #f3f3f3 !important;
        background-color: #ada5a5 !important;
    }
</style>
<div class="block">
    <ul class="nav nav-tabs" data-toggle="tabs">
        <li class="active">
            <a href="#btabs-animated-slideup-profile">Profile</a>
        </li>
        <li>
            <a href="#btabs-animated-slideup-documents">Documents</a>
        </li>
    </ul>
    <div class="block-content tab-content">
        <!--Start Profile tab-->
        <div class="tab-pane fade fade-up in active" id="btabs-animated-slideup-profile">
            <div class="pull-right">
                <?php echo CHtml::link('Go to list', array('telecom/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                <?php echo CHtml::link('Create', array('telecom/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                <?php echo CHtml::link('Update', array('telecom/update/'.$model->id), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                <p></p>
            </div>

            <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$model,
                'htmlOptions' => array('class' => 'table'),
                'attributes'=>array(
                    'first_name',
                    'middle_name',
                    'last_name',
                    'email',
                    'extra_email',
                    'date_of_birth',
                    'language',
                    [
                        'name' => 'gender',
                        'value' => function($model){
                            $fieldName = CylFields::model()->findByAttributes(['field_name' => 'gender']);
                            $fieldValue = CylFieldValues::model()->findByAttributes(['field_id' => $fieldName->field_id, 'predefined_value' => $model->gender ]);
                            return $fieldValue->field_label;
                        }
                    ],
                    'phone',
                    'landline_number',
                    'send_invoice_via',
                    'invoice_detail_type',
                    'building_num',
                    'bus_num',
                    'street',
                    'city',
                    [
                        'name' => 'country',
                        'value' => function($model){
                            $countryName = ServiceHelper::getCountryNameFromId($model->country);
                            return $countryName;
                        }
                    ],
                    'postcode',
                    'nationality',
                    'billing_name',
                    'billing_building_num',
                    'billing_bus_num',
                    'billing_street',
                    'billing_city',
                    'billing_postcode',
                    [
                        'name' => 'billing_country',
                        'value' => function($model){
                            $countryName = ServiceHelper::getCountryNameFromId($model->billing_country);
                            return $countryName;
                        }
                    ],
                    'business_name',
                    [
                        'name' => 'business_country',
                        'value' => function($model){
                            $countryName = ServiceHelper::getCountryNameFromId($model->business_country);
                            return $countryName;
                        }
                    ],
                    'vat',
                    'vat_number',
                    'company_since_in_months',
                    'payment_method',
                    'bank_name',
                    'bank_building_num',
                    'bank_street',
                    'bank_city',
                    'bank_postcode',
                    [
                        'name' => 'bank_country',
                        'value' => function($model){
                            $countryName = ServiceHelper::getCountryNameFromId($model->bank_country);
                            return $countryName;
                        }
                    ],
                    'account_name',
                    'iban',
                    'bic_code',
                    'credit_card_type',
                    'credit_card_number',
                    'credit_card_name',
                    'expiry_date_month',
                    'expiry_date_year',
                    'agent_name',
                    'comments',
                    'created_at',
                    'modified_at',
                ),
            )); ?>
        </div>
        <!--End Profile tab-->
        <!--Start Documents tab-->
        <div class="tab-pane fade fade-up" id="btabs-animated-slideup-documents">
            <div class="block">
                <div class="block-content tab-content">
                    <div class="row">
                        <?php foreach ($documents as $document) { ?>
                            <div class="col-md-7">
                                <span>Download <?= $document['document_name']; ?></span>
                                <div class="pull-right m-b-10">
                                    <a href="<?= Yii::app()->baseUrl.'/'.$document['document_path']; ?>" download class="btn btn-primary"><i class="fa fa-download"></i></a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!--End Documents tab-->
    </div>
</div>
<script>

    jQuery(function () {
        // Init page helpers (Appear + CountTo plugins)
        App.initHelpers(['appear', 'appear-countTo']);
    });

</script>