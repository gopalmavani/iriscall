<?php
$this->pageTitle = 'Vouchers';
?>
<div class="table-responsive" id="orderTable">
    <div class="pull-right m-b-10">
        <?php echo CHtml::link('Create', array('voucher/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    </div>
    <table id="voucher-index-table" class="table" data-page-size="10">
        <thead>
            <tr>
                <th>Action</th>
                <th>Name</th>
                <th>Reference</th>
                <th>Code</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Voucher Status</th>
                <th>Redeemed At</th>
                <th>Email</th>
                <th>Order Info Id</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($voucher_info as $value) { ?>
                <tr>
                    <td><?= $value['id']; ?></td>
                    <td><?= $value['voucher_name']; ?></td>
                    <td><?= $value['reference_id']; ?></td>
                    <td><?= $value['voucher_code']; ?></td>
                    <td><?= $value['start_time']; ?></td>
                    <td><?= $value['end_time']; ?></td>
                    <td><?= $value['voucher_status']; ?></td>
                    <td><?= $value['redeemed_at']; ?></td>
                    <td><?= $value['email']; ?></td>
                    <td><?= $value['order_info_id']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script type="text/javascript">
    var table = $('#voucher-index-table').DataTable({
        "columnDefs": [ {
            "targets": 0,
            "render" : function(data, type, row) {
                return '<a href="<?php echo Yii::app()->createUrl("admin/voucher/view/").'/'; ?>'+data+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/voucher/update/").'/'; ?>'+data+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a id='+data+' class="voucher-delete" href="javascript:void(0)"><i class="fa fa-times"></i></a>';
            }
        }],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    $(' body ').on('click','.voucher-delete',function() {
        var id = $(this).attr('id');
        bootbox.confirm("Are you sure you want to delete this voucher?", function(result){
            if (result === true){
                $.ajax({
                    url: "Delete",
                    type: "POST",
                    data: {'id': id},
                    beforeSend: function () {
                        $(".overlay").removeClass("hide");
                    },
                    success: function (response) {
                        var Result = JSON.parse(response);
                        if (Result.token == 1){
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });
</script>