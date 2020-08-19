<?php
$this->pageTitle = "Payout Details by Month";
?>
<div class="content content-boxed">
    <div class="push-30 text-center">
        <h3 class="text-black push-5" style="font-weight: 200"><strong>Payout</strong> Details</h3> for <?= DateTime::createFromFormat('!m', $month)->format('F').', '.$year; ?>
    </div>
    <div class="row">
        <table id="wallet-payout-month-user-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
            <thead class="custom-table-head">
            <tr>
                <th>User Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Earnings</th>
                <th>Cumulative Earnings</th>
                <th>Current Balance</th>
                <th>Payout Eligible</th>
                <th>Vat Number</th>
                <th>Vat Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <thead>
            <tr style="background: white; color: black">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th><select class='drop-box' data-column='8' style='width:100%; margin-bottom: 0'>
                        <option value="">Select</option>
                        <option value='Present'>Present</option>
                        <option value='Absent'>Absent</option>
                    </select></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($currentMonthEar as $item) { ?>
                    <tr>
                        <td><?= $item['user_id']; ?></td>
                        <td><?= $item['full_name']; ?></td>
                        <td><?= $item['email']; ?></td>
                        <?php $currentMonthEarnings = $item['credit_amt']; ?>
                        <td><?= round($currentMonthEarnings, 4); ?></td>
                        <td><?= round($cumulativeEarnings[$item['user_id']], 4); ?></td>
                        <td><?= round($userBalance[$item['user_id']], 4); ?></td>
                        <?php if($earningWRTTimeArr[$item['user_id']] >= Yii::app()->params['MinimumPayoutValue']) { ?>
                            <?php if($earningWRTTimeArr[$item['user_id']] > $userBalance[$item['user_id']]) { ?>
                                <td style="background: red;color: white;"><?= round($earningWRTTimeArr[$item['user_id']], 4); ?></td>
                            <?php } else { ?>
                                <td><?= round($earningWRTTimeArr[$item['user_id']], 4); ?></td>
                            <?php } ?>

                        <?php } else { ?>
                            <td>0</td>
                        <?php } ?>
                        <td><?= $item['vat_number']; ?></td>
                        <td><?php if(!empty($item['vat_number'])) { ?>
                                Present
                            <?php } else {?>
                                Absent
                            <?php } ?>
                        </td>
                        <td style="text-align: center">
                            <a href="<?= Yii::app()->createUrl('admin/wallet/userPayout').'?user_id='.$item['user_id'].'&month='.$month.'&year='.$year; ?>"><i class="fa fa-eye fa-lg"></i></a>&nbsp;
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    var table = $('#wallet-payout-month-user-table').DataTable({
        "columnDefs": [
            { "orderable": false,
                "targets": [8, 9]
            }
        ],
        "scrollX": true
    });

    $('.drop-box').on('change', function () {
        var i =$(this).attr('data-column');
        var v =$(this).val();
        table.columns(i).search(v).draw();
    } );

    $('.text-box').on('keyup', function () {
        var i =$(this).attr('data-column');
        var v =$(this).val();
        table.columns(i).search(v).draw();
    } );
</script>

