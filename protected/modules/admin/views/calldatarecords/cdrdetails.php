<?php
/* @var $this CalldatarecordsController */
/* @var $model CallDataRecordsInfo */
$this->pageTitle = 'CDR Details';
$org_id = '';
$date = '';
if(isset($_GET['organisation_id'])){
    $org_id = $_GET['organisation_id'];
}
if(isset($_GET['date'])){
    $date = $_GET['date'];
}
?>
<style>
.filter-class .ui-datepicker-calendar {
        display: none;
    }
</style>
<div class="pull-left m-b-10">
    <div class="tab-content">
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
            <div class="col-md-6">
                <div class="controls">
                    <?php $list = CHtml::listData(OrganizationInfo::model()->findAll(),'organisation_id','name');
                    echo $form->dropDownList($model, 'organisation_id', $list, array('options' => array(isset($_REQUEST['organisation_id']) ? $_REQUEST['organisation_id'] : '' => array('selected'=>true)),'class' => 'form-control', 'name' => 'organisation_id', 'id' => 'organization', 'empty' => 'Select Organization')); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="controls">
                <input type="text" class="form-control" name="date" placeholder='Select Date' autocomplete="off", value="<?php echo isset($_REQUEST['date']) ? $_REQUEST['date'] : '' ?>", id='datepickerfilter'>
                </div>
            </div>
        </div>
    <?php $this->endWidget(); ?>
    </div>
</div>
<div style="margin-right:10px;" class="col-md-6">
    <a class="btn btn-primary" id="filter">Filter</a>
    <a class="btn btn-outline-primary" id="clearDate">Clear date <i class="fa fa-times"></i></a>
</div>
<div style="margin-top:50px;" class="row">
    <div class="col-md-6">
        <label>Show 
            <select id="records">
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
            </select> 
        entries</label>
    </div>
</div>
<div id="cdr-details-grid"></div>
<!--Begin script-->
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
<!--End script-->
<script>
$(document).ready(function(){

    $("#cdr-details-grid").jsGrid({
        width: "100%",
        height: "auto",

        heading: true,
        filtering: true,
        rowNum: 20,
        rowList: [20,50,100,200],
        editing: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageButtonCount: 5,
        noDataContent: "No data found",

        controller: {
            loadData: function(data) {
                var orgID = "<?= $org_id ?>";
                var date = "<?= $date ?>";
                if(orgID !==''){
                        data['organisation_id'] = orgID;
                    }
                if(date !==''){
                        data['date'] = date;
                    }
                return $.ajax({
                    type: "GET",
                    url: "cdrdata",
                    dataType: "json",
                    data: data
                });
            },

            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "updatecdrdata",
                    data: item
                });
            },
        },

        fields: [
            { name: "from_number", title: "From number", type: "text", headercss: "custom-table-head", editing: false, width: 60},
            { name: "from_name", title: "From name", type: "text", headercss: "custom-table-head", editing: false, width: 70},
            { name: "to_number", title: "To number", type: "text", headercss: "custom-table-head", editing: false, width: 60},
            { name: "unit_cost", title: "Unit cost", type: "text", headercss: "custom-table-head", width: 40},
            { name: "date", title: "Date", type: "text", headercss: "custom-table-head", editing: false, width: 60},
            { name: "total_time", title: "Total time", type: "text", headercss: "custom-table-head", editing: false, width: 50},
            { name: "comment", title: "Comment", type: "text", headercss: "custom-table-head"},
            { type: "control",
                deleteButton: false
            }
        ]
    });

    //year-month calender
    $('#datepickerfilter').datepicker({
        dateFormat: "yy-mm",
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

    $("#records").on("change", function() {
        var record = $(this).val();
        $("#cdr-details-grid").jsGrid("option", "pageSize", record);
    });

    //clear date
    var $dates = $('#datepickerfilter').datepicker();
    $('#clearDate').on('click', function () {
        $dates.datepicker('setDate', null);
    });
    //filter by organization and date
    $('#filter').on('click', function(){
        var newUrl = "<?php echo Yii::app()->createUrl('admin/calldatarecords/cdrdetails'); ?>";
        var organisation_id = $('#organization').val();
        var date = $('#datepickerfilter').val();
        newUrl += '?organisation_id='+organisation_id+'&date='+date;
        window.location = newUrl;
    });
});
</script>