<?php
$this->pageTitle = "Payout Home page";
?>
<div class="content content-boxed">
    <div class="push-30 text-center">
        <h3 class="text-black push-5" style="font-weight: 200"><strong>Payout</strong> Details</h3> for User wallet
    </div>
    <div class="row">
        <table id="wallet-payout-month-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
            <thead class="custom-table-head">
            <tr>
                <th>Month</th>
                <th>Year</th>
                <th>Commission generated</th>
                <th>Cumulative Commission</th>
                <th>Total User Balance which are eligible for payout</th>
                <th>Eligible for Payout</th>
                <th>Action</th>
            </tr>
            </thead>
            <thead>
            <tr style="background: white; color: black">
                <th><input type='text' data-column='0' class='text-box'></th>
                <th><input type='text' data-column='1' class='text-box' ></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php //print('<pre>');print_r($earningsArr); exit; ?>
                <?php foreach ($earningsArr as $earningYear) { ?>
                    <?php foreach ($earningYear as $earningItem) { ?>
                        <tr>
                            <td><?= DateTime::createFromFormat('!m', $earningItem['mnt'])->format('F'); ?></td>
                            <td><?= $earningItem['yr']; ?></td>
                            <td><?= round($earningItem['commissions'], 4); ?></td>
                            <td><?= round($earningItem['cumulative_commissions'], 4); ?></td>
                            <td><?= round($earningItem['balance'], 4); ?></td>
                            <td><?= round($earningItem['payout_value'], 4); ?></td>
                            <td style="text-align: center"><a href="<?= Yii::app()->createUrl('admin/wallet/payoutByMonth').'?month='.$earningItem['mnt'].'&year='.$earningItem['yr']; ?>"><i class="fa fa-eye fa-lg"></i></a>&nbsp;</td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    var table = $('#wallet-payout-month-table').DataTable({
        "columnDefs": [
            { "orderable": false,
                "targets": [0, 5, 6]
            }
        ],
        "aaSorting": []
    });

    $('.text-box').on('keyup', function () {
        var i =$(this).attr('data-column');
        var v =$(this).val();
        table.columns(i).search(v).draw();
    } );
</script>


