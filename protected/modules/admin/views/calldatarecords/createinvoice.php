<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18-09-2020
 * Time: 17:46
 */
/* @var $this CategoriesController */
/* @var $model OrganizationInfo */
/* @var $form CActiveForm */
$this->pageTitle = 'Create Invoice';
?>
<style>
.ui-datepicker-calendar {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right" style="margin: 0px 15px 15px 0px;">
            <?php echo CHtml::link('Go to list', array('calldatarecords/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="form-group">
                            <?php $list = CHtml::listData(OrganizationInfo::model()->findAll(), 'organisation_id', 'name'); ?>
                            <label class="control-label">Organisation</label>
                            <span class="required">*</span>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">Select all</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">Deselect all</span>
                            </div>
                            <select class="form-control js-select2" multiple="multiple" name="organisation_id[]" id="organisation_id">
                                <?php
                                foreach($list as $id => $name){ ?>
                                    <option value="<?= $id ?>"><?= $name ?></option>
                                <?php } ?>
                            </select>
                            <span class="help-block" style="color: red" id="org-err"></span>
                        </div>
                    </div>
                    <div class="group-list"></div>
                    <div class="row">
                        <div class="form-group">
                            <label class="control-lable">
                                Select Month
                            </label>
                            <!-- <?php /*
                            $months = array('2020-01-31' => 'January - 2020', '2020-02-29' => 'February - 2020', '2020-03-31' => 'March - 2020', '2020-04-30' => 'April - 2020', '2020-05-31' => 'May - 2020', '2020-06-30' => 'June - 2020', '2020-07-31' => 'July - 2020', '2020-08-31' => 'August - 2020', '2020-09-30' => 'September - 2020', '2020-10-31' => 'October - 2020', '2020-11-30' => 'November - 2020', '2020-12-31' => 'December - 2020','2021-01-31' => 'January - 2021', '2021-02-28' => 'February - 2021', '2021-03-31' => 'March - 2021', '2021-04-30' => 'April - 2021', '2021-05-31' => 'May - 2021', '2021-06-30' => 'June - 2021', '2021-07-31' => 'July - 2021', '2021-08-31' => 'August - 2021', '2021-09-30' => 'September - 2021', '2021-10-31' => 'October - 2021', '2021-11-30' => 'November - 2021', '2021-12-31' => 'December - 2021');
                            ?>
                            <select name="month" class="form-control">
                                <option>Select month</option>
                                <?php
                                foreach ($months as $key => $month){?>
                                    <option value="<?= $key; ?>"><?= $month; ?></option>
                                <?php }
                                */ ?>
                            </select>
                            <span class="help-block"></span> -->
                            <input type="text" class="form-control" name="month" placeholder='Select Month' autocomplete="off", id='datepickerfilter'>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group" align="right">
                <input type="button" name="submit" value="create" class="btn btn-primary cat-create" id="createInvoice">
            </div>
        </div>
        <div class="col-md-12">
            <p style="background: whitesmoke !important;" id="msg"></p>
            <div id="loader-invoice" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                <i class="fa fa-4x fa-cog fa-spin text-success"></i>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
<script>
$(document).ready(function (e) {
//year-month calender
    $('#datepickerfilter').datepicker({
        dateFormat: "MM-yy",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        onClose: function(dateText, inst){
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        },
        beforeShow: function(dateText, inst) {
            if ((datestr = $(this).val()).length > 0) {
                year = datestr.substring(0, 4);
                //month = getMonthFromString(datestr.substring(0, datestr.length-6));
                month = datestr.substring(5);
                $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
                $(this).datepicker('setDate', new Date(year, month-1, 1));
            }
        },
    });

    /*$('#organisation_id').on('change', function(e) {
        $('.group-list').html('')
        $.ajax({
            type: 'POST',
            url: '<?php //echo Yii::app()->getUrlManager()->createUrl('admin/companyGroup/getGroups'); ?>' ,
            data: {
                organisation_id: $(this).val()
            },
            success:function (result) {
                var groupList = JSON.parse(result);
                if(groupList.status == true){
                    $('.group-list').html(groupList.data)
                }
            }
        });
    });*/

    $('#createInvoice').click(function(e){
        e.preventDefault();
        var organization = $('#organisation_id').val();
        var month_year = $('#datepickerfilter').val();

        if(organization == null){
            $('#org-err').html("Please select organization."); 
        } else {
            $('#msg').html('');
            $('#org-err').html('');
            $.ajax({
                url: "GenerateInvoice",
                type: "POST",
                timeout: 0,
                data: {
                    'month_year':month_year,
                    'organization':organization
                },
                beforeSend:function () {
                    $('#createInvoice').prop('disabled',true);
                    $('#loader-invoice').css('display','block');
                },
                success: function(data) {
                    $('#loader-invoice').css('display','none');
                    $('#createInvoice').prop('disabled',false);

                    if(data != ''){
                        var startIndex = data.indexOf("{");
                        var jsonResponse = data.substring(startIndex);
                        try {
                            var dataObj = JSON.parse(jsonResponse);
                            if(dataObj.details){
                                $.ajax({
                                    url: "invoice",
                                    type: "POST",
                                    data: { 
                                        'data': data
                                    },
                                    success: function(response) {
                                        console.log('Success')
                                        $('body').html(response);
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        $('#msg').html(errorThrown);
                                    }
                                });
                            }
                        } catch (error) {
                            $('#msg').html('something went wrong. Please try again.');
                            console.error("Error parsing JSON:", error);
                        }
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $('#msg').html(errorThrown);
                }
            });
        }
    });
});
</script>
