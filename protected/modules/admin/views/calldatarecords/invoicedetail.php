<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 22-09-2020
 * Time: 16:24
 */
$this->pageTitle = 'Invoice details';

foreach($org_id as $id){ ?>
<div class="view">
    <h4 class="text-muted"><?= $selected[$id] ?? $id ?></h4>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Description</th>
                <th>number</th>
                <th>Amount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(isset($details[$id])) {
                $i = 1;
                foreach($details[$id] as $detail) {
                    $detail = (array)$detail; ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $detail['rule']; ?><?php if(!empty($detail['is_min'])) {?></br>
                        <?= $detail['total_time']; ?><?php } ?>
                    </td>
                    <td><?= $detail['min']; ?></td>
                    <td><?= $detail['cost']; ?></td>
                    <td>
                    <?php 
                        $amount = 0.00;
                        if(!empty($detail['min'])) {
                            $amount = round($detail['min'] * $detail['cost'], 2);
                        }
                        echo $amount;
                    ?>
                    </td>
                </tr>
            <?php $i++; } } ?>
        </tbody>
    </table>
    <br>
    <div class="row">
        <button class="btn btn-primary pull-right generate-order" data-id="<?= $id ?>" style="margin-right: 30px;">Generate Order</button>
    </div>
    <hr>
</div>
<?php } ?>

<script type="text/javascript">
$(document).ready(function () {
    Heading();
    var details = '<?php echo json_encode($details) ?>';
    var orgDetails = JSON.parse(details)

    $('.generate-order').click(function(){
        var id = $(this).data('id');
        var detail = orgDetails[id] ? orgDetails[id] : [];

        $.ajax({
            url: "generateorder",
            type: "POST",
            data: {
                details: detail,
                org_id: id
            },
            success: function (response) {
                var resp = JSON.parse(response);
                if(resp['status'] == 1){
                    toastr.success(resp['message']);
                    var url = "<?php echo Yii::app()->createUrl('admin/orderInfo/view/').'/'; ?>";
                    var order_info_id = resp['order_info_id'];
                    url += order_info_id;
                    window.open(url, '_blank');
                }else {
                    toastr.warning(resp['message']);
                }
            },
            error: function(xhr, status,error){
                console.log(error);
                toastr.error('Something went wrong.');
            }
        });
    });
    
    function Heading() {
        $('.page-heading').parent().removeClass('col-sm-7');
        $('.page-heading').parent().addClass('col-sm-12');
    }
});
</script>