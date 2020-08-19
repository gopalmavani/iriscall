<?php $this->pageTitle = 'Commission Distribution'; ?>
<style>
    .ui-datepicker-calendar {
        display: none;
    }
    .month-picker {
        width: 300px;
        margin: auto;
        margin-top: 10px;
    }
</style>
<div class="block block-themed block-rounded">
    <div class="block-content">
        <h4 style="text-align: center"> Select Month and Year :  </h4>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'start_date',
            'options' => array(
                'dateFormat'=>'MM, yy',
                'showButtonPanel'=> true,
                'changeYear' => true,           // can change year
                'changeMonth' => true,
                'onClose' => "js:function(dateText, inst){
                                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                            }"
            ),
            'htmlOptions' => array(
                'class' => 'form-control month-picker',
                'required' => true,
            ),
        ));
        ?>
        <div class="row">
            <p id="status" style="text-align: center"></p>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs">
                    <li class="active">
                        <a href="#btabs-alt-static-comm">Commission Distribution</a>
                    </li>
                    <li>
                        <a href="#btabs-alt-static-generalize-comm">Wallet Normalization</a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <div class="tab-pane active" id="btabs-alt-static-comm">
                        <p style="color: cadetblue; margin-bottom: 10px">Before proceeding, please ensure latest commission data has been added to cbm_commission table.</p>
                        <button class="btn btn-minw btn-primary" type="button" onclick="distributeComm()">Distribute Commission</button>
                        <p style="margin-top: 15px"> On button click, following process will be executed sequentially: <br>
                            1. All Commission related rows will be added to wallet_commission table.<br>
                            2. Commission Distribution for Cashback earnings.<br>
                            3. Commission Distribution for Floating corporate account and upcycling account.<br>
                            4. Commission Distribution for Company profit matrix.<br>
                        </p>
                        <p style="background: whitesmoke !important; display: none" id="updateCommDisPara"></p>
                        <div class="loader" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                            <i class="fa fa-4x fa-cog fa-spin text-success"></i>
                        </div>
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-generalize-comm">
                        <button class="btn btn-minw btn-primary" type="button" onclick="normalizeWallet()">Normalize Wallet</button>
                        <p style="color: cadetblue; margin-bottom: 10px">This step is mandatory as this will add normalized data to wallet table.</p>
                        <p style="margin-top: 15px"> On button click, following process will be executed sequentially: <br>
                            1. Add commission to wallet table based upon<br> one row per node per commission scheme.
                        </p>
                        <p style="background: whitesmoke !important; display: none" id="updateCommDisPara"></p>
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

    function distributeComm() {
        var start_date = $('#start_date').val();
        if(start_date == ''){
            $('#status').css('color','red');
            $('#status').html("Please select appropriate month and year.");
        } else {
            $('#status').css('color','green');
            $('#status').html("Calculating commission for "+ start_date);
            var url = '<?= Yii::app()->createUrl('/admin/commission/distributeCommission'); ?>';
            $.ajax({
                url: url,
                type: "POST",
                timeout: 0,
                data: {
                    'start_date':start_date
                },
                beforeSend:function () {
                    $('.btn').prop('disabled',true);
                    $('#updateCommDisPara').css('display','none');
                    $('.loader').css('display','block');
                },
                success: function(data) {
                    $('.loader').css('display','none');
                    $('.btn').prop('disabled',false);
                    $('#updateCommDisPara').css('display','block');
                    $('#updateCommDisPara').html(data);
                }
            });
        }
    }

    function normalizeWallet() {
        var start_date = $('#start_date').val();
        if(start_date == ''){
            $('#status').css('color','red');
            $('#status').html("Please select appropriate month and year.");
        } else {
            $('#status').css('color', 'green');
            $('#status').html("Adding normalized commission date to wallet table for " + start_date);
            var url = '<?= Yii::app()->createUrl('/admin/commission/normalizeCommission'); ?>';
            $.ajax({
                url: url,
                type: "POST",
                timeout: 0,
                data: {
                    'start_date':start_date
                },
                beforeSend:function () {
                    $('.btn').prop('disabled',true);
                    $('#updateCommDisPara').css('display','none');
                    $('.loader').css('display','block');
                },
                success: function(data) {
                    $('.loader').css('display','none');
                    $('.btn').prop('disabled',false);
                    $('#updateCommDisPara').css('display','block');
                    $('#updateCommDisPara').html(data);
                }
            });
        }
    }
</script>