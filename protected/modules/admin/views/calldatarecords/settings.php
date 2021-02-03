<?php
/* @var $this CalldatarecordsController */
/* @var $model CallDataRecordsInfo */

$this->pageTitle = 'Settings';
?>
<div class="block">
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

<script type="text/javascript">
$(document).ready(function () {
    //for CDR get from number
    $('#getfromnumber').click(function(e){
        e.preventDefault();
        $.ajax({
            url: "getfromnumber",
            type: "POST",
            //data: data,
            success: function (response) {
                var resp = JSON.parse(response);
                if(resp['status'] == 1){
                    toastr.success(resp['message']);
                } else {
                    toastr.error(resp['message']);
                }
            }
        });
    });
    //for CDR cost calculate
    $('#costcalculate').click(function(e){
        e.preventDefault();
        $.ajax({
            url: "costcalculate",
            type: "POST",
            success: function (response) {
                var resp = JSON.parse(response);
                if(resp['status'] == 1){
                    toastr.success(resp['message']);
                } else {
                    toastr.error(resp['message']);
                }
            }
        });
    });
});
</script>