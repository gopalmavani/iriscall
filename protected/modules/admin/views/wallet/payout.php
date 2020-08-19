<?php
$this->pageTitle = "Payout details";
?>
<div class="content content-boxed">
    <div class="push-30 text-center">
        <h3 class="text-black push-5" style="font-weight: 200"><strong>Payout</strong> Details</h3> for User wallet
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="wallet-payout-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <th>User Id</th>
                    <th>User Details</th>
                    <th>Amount</th>
                    <th>Vat Number</th>
                    <th>Vat Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <thead>
                <tr style="background: white; color: black">
                    <th><input type='text' data-column='0' class='text-box'></th>
                    <th><input type='text' data-column='1' class='text-box' ></th>
                    <th></th>
                    <th></th>
                    <th><select class='drop-box' data-column='4' style='width:100%; margin-bottom: 0'>
                            <option value="">Select</option>
                            <option value='Present'>Present</option>
                            <option value='Absent'>Absent</option>
                        </select></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($userBalance as $item) { ?>
                        <tr>
                            <td><?= $item['user_id']; ?></td>
                            <td>
                                <?= $item['full_name']; ?>
                                <br><span class="text-muted"><?= $item['email']; ?></span>
                            </td>
                            <td><?= $item['amt']; ?></td>
                            <td><?= $item['vat_number']; ?></td>
                            <td><?php if(!empty($item['vat_number'])) { ?>
                                    Present
                                <?php } else {?>
                                    Absent
                                <?php } ?>
                            </td>
                            <td style="text-align: center">
                                <a href="<?= Yii::app()->createUrl('admin/wallet/userPayout').'?user_id='.$item['user_id']; ?>"><i class="fa fa-eye fa-lg"></i></a>&nbsp;
                                <a href="#"><i class="fa fa-envelope fa-lg"></i></a>&nbsp;
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    var table = $('#wallet-payout-table').DataTable({
        "columnDefs": [
            { "orderable": false,
                "targets": [4,5]
            }
        ]
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
