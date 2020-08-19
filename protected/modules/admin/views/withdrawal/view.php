<?php
$this->pageTitle = 'Transaction details for <strong>'.$email.'</strong>';
?>
<div class="row">
    <div class="col-md-6">
        <h3>Withdrawals</h3>
        <?php foreach ($unprocessedWithdrawal as $withdrawal) { ?>
            <div class="checkbox">
                <label class="css-input css-checkbox css-checkbox-danger">
                    <input type="checkbox" name="withdrawal" value="<?= $withdrawal['ticket'] ?>" ><span></span><?= $withdrawal['unprocessed_withdrawal']; ?> from login <?= $withdrawal['login']; ?>
                </label>
            </div>
        <?php } ?>
    </div>
    <div class="col-md-6">
        <h3>Deposits</h3>
        <?php foreach ($unprocessedDeposit as $deposit) { ?>
            <div class="checkbox">
                <label class="css-input css-checkbox css-checkbox-success">
                    <input type="checkbox" name="deposit" value="<?= $deposit['ticket'] ?>" ><span></span><?= $deposit['unprocessed_withdrawal']; ?> to login <?= $deposit['login']; ?>
                </label>
            </div>
        <?php } ?>
    </div>
    <div class="col-md-12">
        <a type="button" class="process-withdrawal btn btn-success pull-right" href="javascript:void(0);" style="margin: 25px">Process</a>
        <?php /*if($processValidity) { */?><!--
            <a type="button" class="process-withdrawal btn btn-success pull-right" href="javascript:void(0);" style="margin: 25px">Process</a>
        <?php /*} else { */?>
            <a type="button" class="unprocess-withdrawal btn btn-danger pull-right disabled" href="#" style="margin: 25px">Cannot be processed</a>
        --><?php /*} */?>
    </div>
</div>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script type="text/javascript">
    $(' body ').on('click','.process-withdrawal',function() {
        let withdrawals = [];
        let deposits = [];
        $.each($("input[name='withdrawal']:checked"), function(){
            withdrawals.push($(this).val());
        });
        $.each($("input[name='deposit']:checked"), function(){
            deposits.push($(this).val());
        });
        let email = "<?= $email; ?>";
        let url = "<?= Yii::app()->createUrl('admin/withdrawal/process'); ?>";
        bootbox.confirm("Are you sure you want to process this withdrawal? Kindly check for previous month commissions if nodes are getting destroyed", function(result){
            if (result === true){
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        'email': email,
                        'withdrawals':withdrawals,
                        'deposits':deposits
                    },
                    beforeSend: function () {
                        $(".overlay").removeClass("hide");
                    },
                    success: function (response) {
                        $(".overlay").addClass("hide");
                        let result = JSON.parse(response);
                        bootbox.alert({
                            title: result.status,
                            message: result.msg,
                            backdrop: true,
                            callback: function () {
                                window.location.reload();
                            }
                        });
                    }
                });
            }
        });
    });
</script>
