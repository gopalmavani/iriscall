<?php
/* @var $this CalldatarecordsController */
/* @var $model CallDataRecordsInfo */

$this->pageTitle = 'Settings';
?>
<style>
.filter-class .ui-datepicker-calendar {
        display: none;
    }
</style>
<div class="block block-themed block-rounded">
    <div class="block-content">
        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'cdr-details-form',
                'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                'enableAjaxValidation' => false,
                'htmlOptions' => array(
                    'name' => 'CDR-Details'
                )
            ));
            ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="controls">
                        <select name="organisation_id" class="form-control org" id="organization">
                            <option value=''>Select Organization</option>
                            <option value='All Organizations'>Select All Organizations</option>
                        <?php foreach ($organizationInfo as $organization){?>
                                <option value="<?= $organization['name']; ?>"><?= $organization['name']; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="controls">
                        <input type="text" class="form-control month" name="month_year" placeholder='Select Month and Year' autocomplete="off", id='datepickerfilter'>
                    </div>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-outline-primary" id="clearDate">Clear date <i class="fa fa-times"></i></a>
                </div>
            </div>
        <?php $this->endWidget(); ?>
        <div class="row">
            <p id="status" style="text-align: center;margin-top:10px"></p>
        </div>
        <div class="row" style="margin-top: 70px">
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs">
                    <li class="active">
                        <a href="#btabs-alt-static-fetchCDR">Fetch CDR</a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-fetchFromNumber">Fetch From Number</a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-calculateCost">Calculate Cost</a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-generateInvoice">Generate Invoice</a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <div class="tab-pane active" id="btabs-alt-static-fetchCDR">
                        <button class="btn btn-minw btn-primary" type="button" id="callFetchCDR">Fetch CDR</button>
                        <p style="margin-top: 15px"> On button click, following process will be executed sequentially: <br>
                            1. All CDR related rows will be added in cdr_info table.<br>
                        </p>
                        <p style="background: whitesmoke !important; display: none" id="fetchCDR"></p>
                        <div id="loader-fetchCDR" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                            <i class="fa fa-4x fa-cog fa-spin text-success"></i>
                        </div>
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-fetchFromNumber">
                        <button class="btn btn-minw btn-primary" type="button" id="callFetchFromNumber">Fetch From Number</button>
                        <p style="margin-top: 15px"> On button click, following process will be executed sequentially: <br>
                            1. CDR related rows will be updated in cdr_info table.<br>
                        </p>
                        <p style="background: whitesmoke !important; display: none" id="fetchFromNumber"></p>
                        <div id="loader-fetchFromNumber" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                            <i class="fa fa-4x fa-cog fa-spin text-success"></i>
                        </div>
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-calculateCost">
                        <button class="btn btn-minw btn-primary" type="button" id="callCalculateCost">Calculate Cost</button>
                        <p style="margin-top: 15px"> On button click, following process will be executed sequentially: <br>
                            1. Cost Calculation related rows will be added in cdr_info table.<br>
                        </p>
                        <p style="background: whitesmoke !important; display: none" id="calculateCost"></p>
                        <div id="loader-calculateCost" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                            <i class="fa fa-4x fa-cog fa-spin text-success"></i>
                        </div>
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-generateInvoice">
                        <?php echo CHtml::link('Generate Invoice', array('calldatarecords/invoice'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                        <!-- <button class="btn btn-minw btn-primary" type="button" id="callGenerateInvoice">Generate Invoice</button> -->
                        <p style="margin-top: 15px"> On button click, following process will be executed sequentially: <br>
                            1. Order generated and rows will be added in order_info, order_line_item, order_payment table.<br>
                        </p>
                        <p style="background: whitesmoke !important; display: none" id="generateInvoice"></p>
                        <div id="loader-generateInvoice" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                            <i class="fa fa-4x fa-cog fa-spin text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block" style="display:none;">
    <div class="block-content">
        <div class="row">
            <div class="col-md-7">
            <span>Fetch call data records.</span>
                <div class="pull-right m-b-10">
                    <?php echo CHtml::link('Fetch CDR', array('calldatarecords/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
            <span>Fetch call data records from number.</span>
                <div class="pull-right m-b-10">
                    <?php echo CHtml::link('Fetch From Number', array('calldatarecords/getfromnumber'), array('id' => 'getfromnumber', 'class' => 'btn btn-minw btn-square btn-primary')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
            <span>Calculate cost of call data records.</span>
                <div class="pull-right m-b-10">
                    <?php echo CHtml::link('Calculate Cost', array('calldatarecords/costcalculate'), array('id' => 'costcalculate', 'class' => 'btn btn-minw btn-square btn-primary')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
            <span>Generate invoice of call data records.</span>
                <div class="pull-right m-b-10">
                <?php echo CHtml::link('Generate Invoice', array('calldatarecords/invoice'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Begin script-->
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
<!--End script-->
<script type="text/javascript">
$(document).ready(function () {
    $('#callFetchCDR').click(function(e){
        e.preventDefault();
        var organization = $('#organization').val();
        var month_year = $('#datepickerfilter').val();
        if(month_year == '' && organization == ''){
            $('#status').css('color','red');
            $('#status').html("Please select organization and appropriate month and year.");
        }else if(organization == ''){
            $('#status').css('color','red');
            $('#status').html("Please select organization."); 
        }else if(month_year == ''){
            $('#status').css('color','red');
            $('#status').html("Please select appropriate month and year."); 
        }else {
            $('#status').css('color','green');
            $('#status').html("Fetching CDR for "+ organization +", for "+ month_year);
            $.ajax({
                url: "index",
                type: "POST",
                timeout: 0,
                data: {
                    'month_year':month_year,
                    'organization':organization
                },
                beforeSend:function () {
                    $('.month').prop('readonly', true);
                    $('.btn,.org').prop('disabled',true);
                    $('#fetchCDR').css('display','none');
                    $('#loader-fetchCDR').css('display','block');
                },
                success: function(data) {
                    $('.month').prop('readonly', false);
                    $('#loader-fetchCDR').css('display','none');
                    $('.btn,.org').prop('disabled',false);
                    $('#fetchCDR').css('display','block');
                    $('#fetchCDR').html(data);
                }
            });
        }
    });

    //for CDR get from number
    $('#callFetchFromNumber').click(function(e){
        e.preventDefault();
        $.ajax({
            url: "getfromnumber",
            type: "POST",
            beforeSend:function () {
                $('.month').prop('readonly', true);
                $('.btn,.org').prop('disabled',true);
                $('#fetchFromNumber').css('display','none');
                $('#loader-fetchFromNumber').css('display','block');
            },
            success: function(data) {
                $('.month').prop('readonly', false);
                $('#loader-fetchFromNumber').css('display','none');
                $('.btn,.org').prop('disabled',false);
                $('#fetchFromNumber').css('display','block');
                var resp = JSON.parse(data);
                if(resp['status'] == 1){
                    $('#fetchFromNumber').html(resp['message']);
                } else {
                    $('#fetchFromNumber').html(resp['message']);
                }
            }
        });
    });
    //for CDR cost calculate
    $('#callCalculateCost').click(function(e){
        e.preventDefault();
        $.ajax({
            url: "costcalculate",
            type: "POST",
            beforeSend:function () {
                $('.month').prop('readonly', true);
                $('.btn,.org').prop('disabled',true);
                $('#calculateCost').css('display','none');
                $('#loader-calculateCost').css('display','block');
            },
            success: function(data) {
                $('.month').prop('readonly', false);
                $('#loader-calculateCost').css('display','none');
                $('.btn,.org').prop('disabled',false);
                $('#calculateCost').css('display','block');
                var resp = JSON.parse(data);
                if(resp['status'] == 1){
                    $('#calculateCost').html(resp['message']);
                }
            }
        });
    });

    //year-month calender
    $('#datepickerfilter').datepicker({
        dateFormat: "MM, yy",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        onClose: function(dateText, inst){
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        },
        beforeShow: function(dateText, inst) {
            $('#ui-datepicker-div').addClass('filter-class');
            if ((datestr = $(this).val()).length > 0) {
                year = datestr.substring(0, 4);
                //month = getMonthFromString(datestr.substring(0, datestr.length-6));
                month = datestr.substring(5);
                $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
                $(this).datepicker('setDate', new Date(year, month-1, 1));
            }
        },
    });

    //clear month and year
    var $dates = $('#datepickerfilter').datepicker();
    $('#clearDate').on('click', function () {
        $dates.datepicker('setDate', null);
    });
});
</script>