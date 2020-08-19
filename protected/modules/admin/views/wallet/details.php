<?php
    $this->pageTitle = $wallet_name . ' Wallet';
?>
<div class="content content-boxed">
    <div class="push-30 text-center">
        <h3 class="text-black push-5" style="font-weight: 200">User and Transaction specific <strong><?= $wallet_type; ?>  Wallet</strong> Details</h3>
        <h4 class="text-muted"><?= 'For ' . $monthYear; ?></h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="wallet-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Transaction Type</th>
                    <th>Amount</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    var data = '<?= addslashes(json_encode($userSummary)); ?>';
    var wallet_type = '<?= $_GET['type'] ?>';
    var month = '<?= $_GET['month'] ?>';
    var year = '<?= $_GET['year'] ?>';
    console.log(data);
    var datatable = $('#wallet-table').DataTable({
        data:JSON.parse(data),
        columns: [
            {
                data: 'user_name',
                render: function(data, type, row, meta)
                {
                    if(type === 'display'){
                        var href = '<?= Yii::app()->createUrl('admin/wallet/nodespecificdetails') ?>' + '?type='+wallet_type+'&month='+month+'&year='+year+'&email=';
                        href = href.concat(row.email);
                        data = '<a href="' + href + '">' + data + '</a>';
                        href = null;
                    }
                    return data;
                }
            },
            { data: 'email' },
            { data: 'transaction_type' },
            { data: 'amount' }
        ]
    });
</script>
