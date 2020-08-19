<?php
$this->pageTitle = "User Payout details";
?>
<div class="content content-boxed">
    <div class="push-30 text-center">
        <h3 class="text-black push-5" style="font-weight: 200"><strong><?= $user->full_name; ?></strong> Payout Details</h3>
        <h4 class="text-muted">Current Balance: <?= round($currentBalance, 4); ?></h4>
    </div>
    <div class="push-15">
        <h5>Generate a new Payout Request</h5>
        <h5 class="text-muted" style="margin-bottom: 5px">Note: A transfer charge of <?= Yii::app()->params['PayoutTransferCharges']; ?> euro will be deducted from the user wallet
            <br> irrespective of transaction status.</h5>
        <div class="row">
            <div class="col-md-4">
                <label for="transaction_reference">Payout Details</label>
                <span style="display: none; color: red" id="transaction_reference_error">Please enter transaction comments</span>
                <input type="text" class="form-control" name="transaction_reference" id="transaction_reference">
            </div>
            <div class="col-md-4">
                <label for="transaction_amount">Payout Amount</label>
                <span style="display: none; color: red" id="transaction_amount_error">Please enter transaction amount</span>
                <input type="number" class="form-control" name="transaction_amount" id="transaction_amount">
            </div>
            <div class="col-md-4">
                <label for="transaction_status">Select Payout Status</label>
                <span style="display: none; color: red" id="transaction_status_error">Please select appropriate transaction status</span>
                <select id="transaction_status" name="transaction_status" class="form-control">
                    <option value="">Select</option>
                    <option value="0">Pending</option>
                    <option value="1">On Hold</option>
                    <option value="2">Approved</option>
                    <option value="3">Rejected</option>
                </select>
            </div>
        </div>
        <div class="row" style="margin: auto; padding-top: 10px; max-width: fit-content">
            <button type="button" id="transaction_submit" class="form-control btn btn-primary">Submit</button>
        </div>
    </div>
    <!--<div class="push-15">
        <h5>User Earnings</h5>
        <h6 class="text-muted">This includes cash-back and affiliate Earnings</h6>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="wallet-earnings-user-table" class="table table-striped table-bordered" width="100%"
                   style="font-size:13px;" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <th>Details</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php /*foreach ($earningsArr as $item) { */?>
                    <tr>
                        <?php /*if ($item['mnt'] == '' || is_null($item['mnt'])) { */?>
                            <td>Commission Earnings for Unknown Date</td>
                        <?php /*} else { */?>
                            <td>Commission Earnings
                                for <?/*= DateTime::createFromFormat('!m', $item['mnt'])->format('F') . ", " . $item['yr']; */?></td>
                        <?php /*} */?>
                        <td><?/*= $item['amt']; */?></td>
                    </tr>
                <?php /*} */?>
                </tbody>
            </table>
        </div>
    </div>-->

    <div class="row">
        <?php if (count($paidOurArr) > 0) { ?>
            <h5 class="push-15">Pay Out Details</h5>
            <div class="col-md-12">
                <table id="wallet-earnings-user-table" class="table table-striped table-bordered" width="100%"
                       style="font-size:13px;" cellspacing="0" cellpadding="0">
                    <thead class="custom-table-head">
                    <tr>
                        <th>Details</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($paidOurArr as $item) { ?>
                        <tr>
                            <td><?= $item['transaction_comment']; ?></td>
                            <td><?= $item['amount']; ?></td>
                            <td><?= date('d F, y', strtotime($item['reference_num'])); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <h5 class="push-15 text-center">No Pay Out Details Found</h5>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    $('#transaction_submit').click(function () {
        var trans_comment = $('#transaction_reference').val();
        var trans_amount = $('#transaction_amount').val();
        var trans_status = $('#transaction_status').val();
        var user_id = "<?= $user->user_id ?>";
        var month = "<?= $month; ?>";
        var year = "<?= $year; ?>";

        if(trans_status == ''){
            $('#transaction_status_error').css('display','block');
        }
        if(trans_comment == ''){
            $('#transaction_reference_error').css('display','block');
        }
        if(trans_amount == ''){
            $('#transaction_amount_error').css('display','block');
        }

        if((trans_status != '') && (trans_comment != "") && (trans_amount != "")){
            var post_payout_url = "<?= Yii::app()->createUrl('admin/wallet/postPayoutTransaction'); ?>";
            $.ajax({
                url: post_payout_url,
                type: "POST",
                data: {
                    'trans_comment': trans_comment,
                    'trans_amount': trans_amount,
                    'trans_status': trans_status,
                    'user_id': user_id,
                    'month': month,
                    'year': year
                },
                success: function (response) {
                    if(response == 1){
                        swal({
                                title: "Payout Transaction placed",
                                text: "Status of an payout transaction can be updated in All Wallet Transactions.",
                                closeOnConfirm: false
                            },
                            function () {
                                window.location.reload();
                            });
                    } else {
                        swal({
                            title: "Issue while adding a payout transaction"
                        });
                    }
                    /*var Result = JSON.parse(response);
                    if (Result.token == 1){
                        localStorage.setItem('msg','success');
                        window.location.reload();
                    }*/
                }
            });
        }

    })
</script>
