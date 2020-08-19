<?php
/* @var $this CompensationsController */
/* @var $model Compensations */

$this->pageTitle = 'Commission Plans';
$plans = CompensationsPlan::model()->findAll();
?>
<div class="row">
    <div class="col-lg-12">
        <!-- Default Table -->
        <div class="block">
            <div class="block-content">
                <table class="table">
                    <thead class="custom-table-head">
                    <tr>
                        <th class="text-center custom-table-head" style="width: 50px;">#</th>
                        <th class="custom-table-head">Name</th>
                        <th class="hidden-xs custom-table-head" style="width: 30%;">Table Name</th>
                        <th class="text-center custom-table-head" style="width: 30%;">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($plans) {
                        foreach ($plans as $plan) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $plan->id ?></td>
                                <td><?php echo $plan->name ?></td>
                                <td class="hidden-xs">
                                    <?php echo $plan->table_name ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($plan->status == 'active') { ?>
                                        <a href="javascript:void(0);" id="<?php echo $plan->id; ?>"
                                           class="deactive"><span
                                                class="label label-success"><?php echo $plan->status ?></span></a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0);" id="<?php echo $plan->id; ?>" class="active"><span
                                                class="label label-danger"><?php echo $plan->status ?></span></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }else{
                        ?>
                        <tr>
                            <td class="text-center"></td>
                            <td></td>
                            <td class="hidden-xs">
                                <b>No records</b>
                            </td>
                            <td class="text-center">

                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Default Table -->
    </div>
</div>
<script>
    $(".active, .deactive").click(function () {
        //alert(this.id); return false;
        var status = this.className;
        var id = this.id;
        var params = {"status": status, "id": id};
        if (confirm("Are you sure you want to " + status + " this plan?")) {
            $.ajax({
                url: "StatusChange",
                type: "post",
                data: params,
                success: function (response) {
                    var Result = JSON.parse(response);
                    if (Result.token == '1') {
                        var f_id = '#' + id;
                        if (status == 'active') {
                            $(f_id).removeClass("active");
                            $(f_id).addClass("deactive");
                            $(f_id).children("span").removeClass("label-danger");
                            $(f_id).children("span").html("active");
                            $(f_id).children("span").addClass("label-success");
                        } else {
                            $(f_id).children("span").html("inactive");
                            $(f_id).removeClass("deactive");
                            $(f_id).addClass("active");
                            $(f_id).children("span").addClass("label-danger");
                            $(f_id).children("span").removeClass("label-success");
                        }
                    }
                }
            });
        }
    });
</script>