<?php
/* @var $this CompensationsController */
/* @var $model Compensations */

$this->pageTitle = 'Commission Plans';
$plans = CompensationsPlan::model()->findAll();
?>
<div class="row">
	<div class="col-lg-12">
        <div class="pull-right m-b-10">
            <?php echo CHtml::link('Create', array('compensationsPlan/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
        <!-- Default Table -->
		<div class="block">
			<div class="block-content">
				<table class="table">
					<thead>
					<tr>
						<th class="text-center" style="width: 50px;">#</th>
						<th>Name</th>
						<th class="text-center" style="width: 30%;">Status</th>
						<th class="text-center">Action</th>
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
								<td class="text-center">
									<input type="hidden" id="plan_id_field_<?php echo $plan->id;?>" value="<?php echo $plan->id;?>">
									<?php echo CHtml::dropDownList('plan-status',12, ['active' => 'Active', 'inactive'=>'Inactive'],array('options' => array( $plan->status => array('selected'=>true)), 'class' =>'plan_status', 'id' => 'planstatus_'.$plan->id)   ); ?>
									<div id="statusInfo_<?php echo $plan->id;?>" style="font-weight: 600; color: seagreen; margin-top: 5px;"></div>
								</td>
								<td class="text-center">
                                    <?php echo CHtml::link('<i class="fa fa-pencil"></i>', array('compensationsPlan/Update/'.$plan->id)); ?> &nbsp;&nbsp;
                                    <?php echo CHtml::link('<i class="fa fa-close"></i>', array('compensationsPlan/DeletePlan/'.$plan->id), array('class' => 'deleteplan')); ?>
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
	$(".plan_status").change(function () {
		var status = $(this).val();
        var str = (this.id);
        var string = str.split("_");
        var id = string[1];

		var params = {"status": status, "id": id};
		if (confirm("Are you sure you want to " + status + " this plan?")) {
			$.ajax({
				url: "StatusChange",
				type: "post",
				data: params,
				beforeSend: function () {
					$(".overlay").removeClass("hide");
				},
				success: function (response) {
					var Result = JSON.parse(response);
					if (Result.token == '1') {
						$(".overlay").addClass("hide");
						$("#statusInfo_"+Result.id).html('Status changed').show().delay(3000).fadeOut();;
					}
				}
			});
		}
	});

    $(".deleteplan").change(function () {
        if (confirm("Are you sure you want to " + status + " this plan?")) {

        }
    });
</script>