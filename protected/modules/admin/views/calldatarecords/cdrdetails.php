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
    <a data-toggle="tooltip" title="Download CSV" id="downloadCSV" class="btn btn-minw btn-square btn-success pull-right">Download CSV</a>
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

    //Download CSV file
    $('#downloadCSV').click(function(){
        var fileData = $("#cdr-details-grid").jsGrid('option', 'data');
        console.log(fileData);
        if(fileData == ''){
            toastr.warning("Nothing to download");
            return;
        }
        
        JSONToCSVConvertor(fileData, "CDR Details", true);
    });

    function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
        //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
        var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
        
        var CSV = '';    
        //Set Report title in first row or line
        
        //CSV += ReportTitle + '\r\n\n';

        //This condition will generate the Label/Header
        if (ShowLabel) {
            var row = "";
            
            //This loop will extract the label from 1st index of on array
            for (var index in arrData[0]) {
                
                //Now convert each value to string and comma-seprated
                row += index + ',';
            }

            row = row.slice(0, -1);
            
            //append Label row with line break
            CSV += row + '\r\n';
        }
        
        //1st loop is to extract each row
        for (var i = 0; i < arrData.length; i++) {
            var row = "";
            
            //2nd loop will extract each column and convert it in string comma-seprated
            for (var index in arrData[i]) {
                row += '"' + arrData[i][index] + '",';
            }

            row.slice(0, row.length - 1);
            
            //add a line break after each row
            CSV += row + '\r\n';
        }

        if (CSV == '') {       
            toastr.error("Invalid data format");
            return;
        }   
        
        //Generate a file name
        var fileName = "CDR_Details";
        //this will remove the blank-spaces from the title and replace it with an underscore
        //fileName += ReportTitle.replace(/ /g,"_");   
        
        //Initialize file format you want csv or xls
        var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
        
        // Now the little tricky part.
        // you can use either>> window.open(uri);
        // but this will not work in some browsers
        // or you will not get the correct file extension    
        
        //this trick will generate a temp <a /> tag
        var link = document.createElement("a");    
        link.href = uri;
        
        //set the visibility hidden so it will not effect on your web-layout
        link.style = "visibility:hidden";
        link.download = fileName + ".csv";
        
        //this part will append the anchor tag and remove it after automatic click
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
});
</script>