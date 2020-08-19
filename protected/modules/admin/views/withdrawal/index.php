<?php
$this->pageTitle = 'Unprocessed Withdrawals';
?>
<style>
    span.strong {
        font-weight: bold;
    }
    h5 {
        margin: 20px auto 5px;
    }
</style>
<div class="table-responsive" id="orderTable">
    <table id="unprocessed-withdrawals-table" class="table table-striped table-bordered" data-page-size="10">
        <thead class="custom-table-head">
            <tr>
                <th>Email</th>
                <th>Unpro. Withdrawals</th>
                <th>Unpro. Deposits</th>
                <th>Received At</th>
                <th>Due Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <thead>
        <tr>
            <td><input type='text' data-column='0' class='text-box' style='width:100%'></td>
            <td><input type='text' data-column='1' class='text-box' style='width:100%'></td>
            <td><input type='text' data-column='2' class='text-box' style='width:100%'></td>
            <td>
                <input class="date_range_filter" type="text" id="starts_at_min" data-column="3" style='width:100%' placeholder="Date"/><br/>
                <!--<input class="date_range_filter" type="text" id="starts_at_max" data-column="3" style='width:100%' placeholder="To"/>-->
            </td>
            <td>
                <input class="date_range_filter" type="text" id="due_starts_at_min" data-column="4" style='width:100%' placeholder="Date"/><br/>
                <!--<input class="date_range_filter" type="text" id="due_starts_at_max" data-column="4" style='width:100%' placeholder="To"/>-->
            </td>
        </tr>
        </thead>

        <tbody>
            <?php foreach ($unprocessed_data as $value) { ?>
                <tr>
                    <td><?= $value['email']; ?></td>
                    <td>
                        <?= $value['unprocessed_withdrawal']; ?>
                        <p class="text-muted"><?= "Login: ".$value['withdrawal_login']; ?></p>
                    </td>
                    <td>
                        <?= $value['unprocessed_deposit']; ?>
                        <p class="text-muted"><?= "Login: ".$value['deposit_login']; ?></p>
                    </td>
                    <td><?= $value['received_at']; ?></td>
                    <td><?= $value['due_date']; ?></td>
                    <td><a href="<?=Yii::app()->createUrl('admin/withdrawal/view?email=').$value['email'];?>"><i class="fa fa-eye fa-2x"></i></a> </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(".date_range_filter").datepicker({
        format : "yyyy-mm-dd",
        autoclose : true
    });

    var table = $('#unprocessed-withdrawals-table').DataTable({
        "columnDefs": [ {
            "targets": 5,
            /*"render" : function(data, type, row) {
                if(data != ''){
                    return '<a id='+data+' class="process-withdrawal" href="javascript:void(0);"><i class="fa fa-angle-double-right fa-2x"></i></a>';
                } else {
                    return "";
                }
            }*/
        }]
    });

    $( 'input').on( 'keyup change clear', function () {
        let data_column = $(this).data('column');
        table.column(data_column).search(this.value).draw();
    });
</script>