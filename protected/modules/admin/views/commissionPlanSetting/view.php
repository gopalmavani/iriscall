<?php
/* @var $this OrderInfoController */
/* @var $model OrderInfo */
$this->pageTitle = 'View Commission Plan Setting';
?>
<div class="tab-content">
    <div class="tab-pane active">
        <div class="row">
            <div class="pull-right">
				<?php echo CHtml::link('Go to list', array('commissionPlanSetting/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                <?php echo CHtml::link('Create', array('commissionPlanSetting/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
				<?php echo CHtml::link('Update', array('commissionPlanSetting/update'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>
        </div>
        <!-- Page Content -->
        <div class="row" style="margin-top: 3%;">
			<div class="block block-bordered" style="border-color: #67809F;">
				<div class="block-header" style="background-color: #67809F">
					<h3 class="block-title"><font color="white"><i class="fa fa-euro"></i> Commission Plan Details</font></h3><br/>
				</div>
				<div class="block-content block-content-full">
					<table class="table table-hover table-bordered table-striped">
						<thead>
							<th>Commission Plan</th>
							<th>User Level</th>
							<th>Rank</th>
						</thead>
						<?php $commissionPlan = CommissionPlan::model()->findByPk($model->commission_plan_id); 
							$userLevel = ['0'=>'User', '1'=>'Level 1', '2'=>'Level 2', '3'=>'Level 3', '4'=>'Level 4', '5'=>'Level 5'];
							$rank = Rank::model()->findByPk($model->rank_id);
						?>
						<tbody>
							<tr>
								<td>
								<?php if(!empty($commissionPlan)){ ?>
									<a target="_blank" href="<?php echo Yii::app()->CreateUrl('admin/commissionPlans/view').'/'.$model->commission_plan_id; ?>"><?php echo $commissionPlan->name; ?></a>
								<?php } else{
									echo $model->commission_plan_id; 
								} ?>
								</td>
								<td>
								<?php if($userLevel[$model->user_level] == "User"){ ?>
									<span align='center' class='label label-table label-success'><?php echo $userLevel[$model->user_level]; ?></span>
								<?php } else{ ?>
									<span align='center' class='label label-table label-info'><?php echo $userLevel[$model->user_level]; ?></span>
								<?php } ?>
								</td>
								<td>
								<?php if(!empty($rank)){ ?>
									<?php echo $rank->name; ?>
								<?php } else{
									echo $model->rank_id; 
								} ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
            <div class="col-md-6 col-sm-12">
				<div class="block block-bordered" style="border-color: #E26A6A;">
					<div class="block-header" style="background-color: #E26A6A">
						<h3 class="block-title"><font color="white"><i class="fa fa-product-hunt"></i> Product Details</font></h3><br/>
					</div>
					<div class="block-content block-content-full">
						<?php $productInfo = ProductInfo::model()->findByPk($model->product_id); ?>
						<div class="row">
							<div class="col-md-5"> <b>Product Name:</b> </div>
							<div class="col-md-7"><?php if(!empty($productInfo)){ ?>
									<?php echo $productInfo->name; ?>
								<?php } else{
									echo $model->product_id;
								} ?>
							</div>
						</div>
						<p></p>
						<?php $category = Categories::model()->findByPk($model->category_id); ?>
						<div class="row">
							<div class="col-md-5"> <b>Category Name:</b> </div>
							<div class="col-md-7"><?php if(!empty($category)){ ?>
									<?php echo $category->category_name; ?>
								<?php } else{
									echo $model->category_id;
								} ?>
							</div>
						</div>
						<p></p>
						<div class="row">
							<div class="col-md-5">
								<span><b>Amount Type:</b></span>
							</div>
							<div class="col-md-7">
								<?php if ($model->amount_type == 0) { 
									echo "<span align='center' class='label label-table label-success'>Fixed</span>";
								}else{ 
									echo "<span align='center' class='label label-table label-danger'>Percentage</span>"; 
								} ?>
							</div>
						</div>
						<p></p>
						<div class="row">
							<div class="col-md-5">
								<span><b>Amount:</b></span>
							</div>
							<div class="col-md-7"><?= $model->amount; ?><?php if ($model->amount_type == 1) { echo " %";}else{ echo " €"; } ?></div>
						</div>
					</div>
				</div>
            </div>
            <div class="col-md-6 col-sm-12">
				<div class="block block-bordered" style="border-color: #95A5A6;">
					<div class="block-header" style="background-color: #95A5A6">
						<h3 class="block-title"><font color="white"><i class="fa fa-cogs"></i> Wallet Details</font></h3><br/>
					</div>
					<div class="block-content block-content-full">
						<?php $walletType = WalletTypeEntity::model()->findByPk($model->wallet_type_id); ?>
						<div class="row">
							<div class="col-md-5"> <b>Wallet Type:</b> </div>
							<div class="col-md-7"><?php if(!empty($walletType)){ ?>
									<?php echo $walletType->wallet_type; ?>
								<?php } else{
									echo $model->wallet_type_id;
								} ?>
							</div>
						</div>
						<p></p>
						<?php $walletMeta = WalletMetaEntity::model()->findByPk($model->wallet_reference_id); ?>
						<div class="row">
							<div class="col-md-5"><b>Wallet Reference:</b></div>
							<div class="col-md-7"><?php if(!empty($walletMeta)){ ?>
									<?php echo $walletMeta->reference_key; ?>
								<?php } else{
									echo $model->wallet_reference_id;
								} ?>
							</div>
						</div>
						<p></p>
						<?php 
							$list = Denomination::model()->findByPk($model->rank_id); ?>
							<div class="row">
								<div class="col-md-5">
									<span><b>Denomination :</b></span>
								</div>
								<div class="col-md-7">
								<?php if(!empty($list)){ ?>
										<span><?php echo $list->denomination_type; ?></span>
									<?php } else{
									echo $model->denomination_id;
								} ?>
								</div>
							</div>
						<p></p>
						<div class="row">
							<div class="col-md-5">
								<span><b>Wallet Status:</b></span>
							</div>
							<div class="col-md-7">
								<?php if ($model->wallet_status == 1) { 
									echo "<span align='center' class='label label-table label-success'>Confirmed</span>";
								}else{ 
									echo "<span align='center' class='label label-table label-danger'>Pending</span>"; 
								} ?>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
        <!-- END Page Content -->
    </div>
</div>
