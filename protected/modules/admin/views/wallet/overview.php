<?php
$this->pageTitle = "Wallet Overview";
?>
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
<div class="content content-boxed" style="background-color: #f5f5f5">
    <div class="row">
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
                                updateWalletDet();
                            }",
            ),
            'htmlOptions' => array(
                'class' => 'form-control month-picker',
                'required' => true,
            ),
        ));
        ?>
    </div>
    <div class="row">
        <p id="status" style="margin-bottom: 0; text-align: center"></p>
    </div>
    <hr style="border-top: 2px solid white">
    <div class="row">
        <div class="col-md-6">
            <h4 class="default-month font-w300">
                Total Distributed<br>
                Commission: <?= $totalCommission ;?>
            </h4>
        </div>
        <div class="col-md-6">
            <h4 class="report-month font-w300 pull-right" style="text-align: right">
                Commission obtained<br>
                as per the report: <?= $totalCommission ;?>
            </h4>
        </div>
    </div>
    <div class="row push-10-t">
        <?php foreach ($wallets as $key=>$wallet) { ?>
            <div class="col-md-6 col-lg-4">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <div class="push-5-t push-5">
                            <i class="si si-wallet text-warning pull-right push-10-t"></i>
                            <a class="h3 text-success font-w600" href="<?= Yii::app()->createUrl('admin/wallet/admin').'?type='.$key; ?>" data-toggle="modal">
                                <?= $wallet['name']; ?> Wallet
                            </a>
                        </div>
                        <div class="push-20 h5">
                            <span class="font-w600" id="<?= $key; ?>"><?= $wallet['amount']; ?></span>
                        </div>
                        <div class="push-5">
                            <a class="btn btn-default wallet-det" id="<?= $key.'-link'; ?>" href="<?= $wallet['href']; ?>">
                                <i class="fa fa-qrcode push-5-r"></i> Node specific Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    function updateWalletDet() {
        var start_date = $('#start_date').val();
        if(start_date == ''){
            $('#status').css('color','red');
            $('#status').html("Please select appropriate start date and end date.");
        } else {
            $('#status').css('color','green');
            $('#status').html("Commission for "+ start_date);
            var url = '<?= Yii::app()->createUrl('admin/wallet/overview'); ?>';
            var href = '<?= Yii::app()->createUrl('admin/wallet/details').'?type='; ?>';
            $.ajax({
                url: url,
                type: "POST",
                data:{
                    'start_date':$('#start_date').val()
                },
                success: function (data) {
                    var res = JSON.parse(data);
                    var total = res.total;
                    var reportTotal = res.reportTotal;
                    var dataArr = res.result;
                    $('.default-month').html('Total Distributed<br>Commission: '+total);
                    $('.report-month').html('Commission obtained<br>as per the report: '+reportTotal);
                    $.each(dataArr, function(key, value) {
                        var newHref = href + key + '&month=' + res.month + '&year=' + res.year;
                        $('#'+key).html(value.amount);
                        $('#'+key+'-link').attr('href',newHref);
                    });
                }
            });
        }
    }
</script>
