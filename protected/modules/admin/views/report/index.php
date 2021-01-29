<?php
$this->pageTitle = "Report Page";
?>
<style>
    .ui-datepicker-calendar {
        display: none;
    }
    .month-picker {
        width: 300px;
        margin: auto;
    }
</style>
<div class="block block-themed block-rounded">
    <div class="block-header bg-flat-light">
        <div class="col-md-6">
            <h3 class="block-title" style="margin-top: 7px; color: white">Required Initial Step </h3>
        </div>
        <div class="col-md-3">
            Select Date<?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'start_date',
                'options' => array(
                    'dateFormat'=>'MM, yy',
                    'showButtonPanel'=> true,
                    'changeYear' => true,           // can change year
                    'changeMonth' => true,
                    'onClose' => "js:function(dateText, inst){
                                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                            }",
                    'beforeShow' => "js:function(dateText, inst){
                                if ((datestr = $(this).val()).length > 0) {
                                    year = datestr.substring(datestr.length-4, datestr.length);
                                    month = getMonthFromString(datestr.substring(0, datestr.length-6));
                                    $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
                                    $(this).datepicker('setDate', new Date(year, month-1, 1));
                                }
                            }"
                ),
                'htmlOptions' => array(
                    'class' => 'form-control month-picker',
                    'required' => true,
                ),
            ));
            ?>
        </div>
        <div class="col-md-3">
            <button class="pull-right btn btn-danger btn-rounded" onclick="downloadInvoices()" style="margin-top: 20px">Download Invoices</button>
        </div>
        <div class="row">
            <p id="status" style="text-align: center"></p>
        </div>
    </div>
</div>
<div class="loader" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
    <i class="fa fa-4x fa-cog fa-spin text-success"></i>
</div>
<script type="text/javascript">
    function getMonthFromString(mon){

        var d = Date.parse(mon + "1, 2012");
        if(!isNaN(d)){
            return new Date(d).getMonth() + 1;
        }
        return -1;
    }
    function downloadInvoices() {
        var start_date = $('#start_date').val();
        if(start_date == ''){
            $('#status').css('color','red');
            $('#status').html("Please select appropriate month and year.");
        } else {
            $('#status').html("");
            let url = '<?= Yii::app()->createUrl('/admin/report/downloadInvoices'); ?>' + '?start_date=' + start_date;
            window.location = url;
        }
    }
</script>