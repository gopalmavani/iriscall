<?php
$this->pageTitle = 'Voucher Reference';
?>
<div class="table-responsive">
    <div class="pull-right m-b-10">
        <?php echo CHtml::link('Create', array('voucherReference/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    </div>
    <table id="voucher-reference-index-table" class="table" data-page-size="10">
        <thead>
            <tr>
                <th>Action</th>
                <th>Reference</th>
                <th>Reference Value</th>
                <th>type</th>
                <th>value</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($voucher_info as $value) { ?>
                <tr>
                    <td><?= $value['id']; ?></td>
                    <td><?= $value['reference']; ?></td>
                    <td><?= $value['reference_value']; ?></td>
                    <td><?= $value['type']; ?></td>
                    <td><?= $value['value']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    var table = $('#voucher-reference-index-table').DataTable({
        "columnDefs": [ {
            "targets": 0,
            "render" : function(data, type, row) {
                return '<a href="<?php echo Yii::app()->createUrl("admin/voucherReference/view/").'/'; ?>'+data+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/voucherReference/update/").'/'; ?>'+data+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;';
            }
        }]
    });
</script>