<?php $this->pageTitle = 'Settings'; ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js', CClientScript::POS_HEAD); ?>
<div class="block block-themed block-rounded">
    <div class="block-header bg-flat-light">
        <h3 class="block-title">Virtual Percentage Allocation Management Module</h3>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-3">
                    <label>Start Date : </label>
                </div>
                <div class="col-md-9" style="margin-left: -10%">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'start_date',
                        'options' => array(
                            'showAnim' => '',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                            'dateFormat' => 'yy-mm-dd',
                            'maxDate' => date('Y-m-d'),
                            'changeYear' => true,           // can change year
                            'changeMonth' => true,
                            'yearRange' => '1900:2100',
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control',
                            'required' => true,
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-3">
                    <label>End Date : </label>
                </div>
                <div class="col-md-9" style="margin-left: -10%">
                    <input type="text" class="form-control" id="end_date" name="end_date" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <p id="status"></p>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs">
                    <li class="active">
                        <a href="#btabs-alt-static-home">Update MT4 details</a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-profile">Update User Account details</a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <div class="tab-pane active" id="btabs-alt-static-home">
                        <button class="btn btn-minw btn-primary" type="button" onclick="updateMT4()">Update MT4</button>
                        <p style="margin-top: 15px"> On button click, following process will be executed sequentially: <br>
                            1. Fetch MT4 Data.<br>
                            2. Add Deposit/Withdrawal rows.<br>
                            3. Add/Update Api-Accounts.<br>
                            4. Add Daily Balance.<br>
                        </p>
                        <p style="background: whitesmoke !important; display: none" id="updateMt4Para"></p>
                        <div class="loader" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                            <i class="fa fa-4x fa-cog fa-spin text-success"></i>
                        </div>
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-profile">
                        <button class="btn btn-minw btn-primary" type="button" onclick="updateUser()">Update User details</button>
                        <p style="margin-top: 15px"> On button click, following process will be executed sequentially: <br>
                            1. Create new CBM user accounts based on deposits<br>
                            2. Update balance and equity of all cbm user accounts.<br>
                            3. Create new CBM profit user accounts based on step 2.<br>
                            4. Place the newly created self and profit accounts to Matrix.<br>
                        </p>
                        <p style="background: whitesmoke !important; display: none" id="updateUserPara"></p>
                        <div class="loader" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                            <i class="fa fa-4x fa-cog fa-spin text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $("#start_date").on("change", function()
    {
        $('#end_date').datepicker({
            dateFormat: 'yy-mm-dd',
            //showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1999:2030',
            //showOn: "button",
            //buttonImage: "images/calendar.gif",
            //buttonImageOnly: true,
            minDate: /*new Date(1999, 10 - 1, 25)*/ $("#start_date").val(),
            maxDate: new Date(),
            inline: true
        });
    });

    function updateMT4() {
        if(($('#start_date').val() == '') && ($('#end_date').val() == '')){
            $('#status').css('color','red');
            $('#status').html("Please select appropriate start date and end date.");
        } else {
            $('#status').css('color','green');
            $('#status').html("Start Date set to "+ $('#start_date').val() +" and end date is set to "+ $('#end_date').val());
            var url = '<?= Yii::app()->createUrl('/admin/mt4/updatemt4'); ?>';
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    'start_date':$('#start_date').val(),
                    'end_date':$('#end_date').val()
                },
                beforeSend:function () {
                    $('#updateMt4Para').css('display','none');
                    $('.loader').css('display','block');
                },
                success: function(data) {
                    var res = JSON.parse(data);
                    $('.loader').css('display','none');
                    $('#updateMt4Para').css('display','block');
                    $('#updateMt4Para').html(
                        res.CBMResponse.summary + res.CBMResponse.messageLog +
                        res.BahamasResponse.summary + res.BahamasResponse.messageLog
                    );
                }
            });
        }
    }

    function updateUser() {
        var url = '<?= Yii::app()->createUrl('/admin/mt4/createUserAcc'); ?>';
        $.ajax({
            url: url,
            type: "GET",
            beforeSend:function () {
                $('#updateUserPara').css('display','none');
                $('.loader').css('display','block');
            },
            success: function(data) {
                $('.loader').css('display','none');
                $('#updateUserPara').css('display','block');
                $('#updateUserPara').html(data);
            }
        });
    }
</script>
