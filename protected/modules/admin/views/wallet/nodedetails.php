<?php
$this->pageTitle = $user->full_name." Node details";
?>
<div class="content content-boxed">
    <div class="push-30 text-center">
        <h3 class="text-black push-5" style="font-weight: 200">Node specific <strong><?= $wallet_type; ?> Wallet </strong> Details</h3>
        <h4 class="text-muted"><?= 'For ' . $monthYear; ?></h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="wallet-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <th>CBM Account Number</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Balance</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    var data = '<?= json_encode($result); ?>';
    var datatable = $('#wallet-table').DataTable({
        data:JSON.parse(data),
        columns: [
            { data: 'account_num' },
            { data: 'credit' },
            { data: 'debit' },
            { data: 'effective_balance' }
        ]
    });
</script>
