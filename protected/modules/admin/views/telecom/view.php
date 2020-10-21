<?php
/* @var $this TelecomController */
/* @var $model TelecomUserDetails */

$this->pageTitle = 'View User';
$id = $model->user_id;
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
    </ul>
    <div class="block-content tab-content">
        <!--Start Profile tab-->
        <div class="tab-pane fade fade-up in active" id="btabs-animated-slideup-profile">
            <div class="pull-right">
                <?php echo CHtml::link('Go to list', array('telecom/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                <?php echo CHtml::link('Create', array('telecom/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                <?php echo CHtml::link('Update', array('telecom/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
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
                    'country',
                    'postcode',
                    'nationality',
                    'billing_name',
                    'billing_building_num',
                    'billing_bus_num',
                    'billing_street',
                    'billing_city',
                    'billing_country',
                    'billing_postcode',
                    'billing_country',
                    'business_name',
                    'business_country',
                    'vat_rate',
                    'vat_number',
                    'company_since_in_months',
                    'payment_method',
                    'bank_name',
                    'bank_building_num',
                    'bank_street',
                    'bank_city',
                    'bank_postcode',
                    'bank_country',
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
    </div>
</div>
<script>
    jQuery(function () {
        // Init page helpers (Appear + CountTo plugins)
        App.initHelpers(['appear', 'appear-countTo']);
    });

</script>