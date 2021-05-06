<?php
/* @var $this OrderInfoController */
/* @var $model OrderInfo */
$this->pageTitle = 'Settings';
?>
<style>
.msg{
    display: none;
}
</style>
<div class="block block-themed block-rounded">
    <div class="block-header bg-flat-light">
        <h3 class="block-title">Reminders settings Module</h3>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <lable>Select Reminder</lable>
                    <select class="form-control" name="reminder" id="reminder">
                        <option value="1">Remider 1</option>
                        <option value="2">Remider 2</option>
                        <option value="3">Remider 3</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <lable>Cost</lable>
                    <input type="text" class="form-control" name="cost" id="cost" autocomplete="off" value="0"/>
                    <span class="text-danger msg cost">Please enter cost</span>
                </div>
            </div>
            <div class="col-md-3" style="margin-right:10%">
                <div class="form-group">
                    <lable>Send after how many days?</lable>
                    <input type="text" class="form-control" name="days" id="days" autocomplete="off" value="0"/>
                    <span class="text-danger msg days">Please enter days</span>
                </div>
            </div>
            <button style="margin-top:2%" align="right" type="submit" id="submit" class='col-md-1 btn btn-minw btn-square btn-info'>Save</button>
        </div>
    </div>
</div>
<script>
$('#submit').click(function(e){
    e.preventDefault();
    var reminder = $('#reminder').val();
    var cost = $('#cost').val();
    var days = $('#days').val();
    if(cost == '' && days == ''){
        $('.msg').show();
    }else if(days == ''){
        $('.days').show();
    }else if(cost == ''){
        $('.cost').show();
    }else{
        $.ajax({
            url: "ReminderSettings",
            type: "POST",
            data: {
                reminder: reminder,
                cost: cost,
                days: days
            },
            success: function (response) {
                var resp = JSON.parse(response);
                if(resp['status'] == 1){
                    toastr.success(resp['message']);
                }else if(resp['status'] == 0){
                    toastr.warning(resp['message']);
                }
            },
            error: function(xhr, status,error){
                console.log(error);
                toastr.error('Something went wrong.');
            }
        });
    }
});
</script>