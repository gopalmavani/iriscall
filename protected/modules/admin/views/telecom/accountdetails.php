<?php
/* @var $this TelecomController */
/* @var $model TelecomUserDetails */

$this->pageTitle = 'View Account details';
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
                    'user_id',
                    'client_id',
                    'email',
                    'account_type',
                    'rate',
                    'phone_number',
                    'sim_card_number',
                    'old_sim_card_number',
                    'contract_duration_in_months',
                    'is_voice_mail_enabled',
                    'tariff_plan',
                    'extra_options',
                    'comments',
                    'activation_date',
                    'credit_limit',
                    'previous_operator_client_id',
                    'previous_operator_name',
                    'previous_operator_client_invoice_name',
                    'authorised_person_name',
                    'authorised_person_vat_number',
                    'telecom_request_status',
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