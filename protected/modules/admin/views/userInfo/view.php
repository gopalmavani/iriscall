<?php
/* @var $this UserInfoController */
/* @var $model UserInfo */

$this->pageTitle = 'View User';
$id = $model->user_id;
$admin = Yii::app()->params['mandatoryFields']['admin_id'];
?>

<style type="text/css">

	.block > .nav-tabs > li.active > a, .block > .nav-tabs > li.active > a:hover, .block > .nav-tabs > li.active > a:focus{
		color: #f3f3f3 !important;
    	background-color: #ada5a5 !important;
	}


</style>
<!-- Header Tiles -->
<div class="row">
	<?php
	$ordercount  = $finalwalletamount = $walletcount = 0;
	if(Yii::app()->db->schema->getTable('order_info')) {
		$countordersql = "SELECT count(*) as countorder from order_info where user_id =" . $model->user_id;
		$ordercount = Yii::app()->db->createCommand($countordersql)->queryAll();
	}
	if(Yii::app()->db->schema->getTable('wallet')) {
		$countwalletsql = "SELECT count(*) as countwallet from wallet where user_id =" . $model->user_id;
		$walletcount = Yii::app()->db->createCommand($countwalletsql)->queryAll();

		$walletcreditsql = "SELECT SUM(amount) as credit from wallet where user_id = " . $model->user_id . " and transaction_type = 0";
		$creditamount = Yii::app()->db->createCommand($walletcreditsql)->queryAll();

		$walletdebitsql = "SELECT SUM(amount) as debit from wallet where user_id = " . $model->user_id . " and transaction_type = 1";
		$debitamount = Yii::app()->db->createCommand($walletdebitsql)->queryAll();

		$finalwalletamount = $creditamount[0]['credit'] - $debitamount[0]['debit'];
	}
	?>
	<?php if(Yii::app()->db->schema->getTable('order_info')) { ?>
		<div class="col-sm-4 col-md-4">
			<div class="block block-link-hover3 text-center" href="javascript:void(0)">
				<div class="block-content block-content-full">
					<div class="h1 font-w700 text-primary" data-toggle="countTo" data-to="<?php echo $ordercount[0]['countorder']; ?>"></div>
				</div>
				<div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Orders</div>
			</div>
		</div>
	<?php } ?>
	<?php if(Yii::app()->db->schema->getTable('order_info')) { ?>
		<div class="col-sm-4 col-md-4">
			<div class="block block-link-hover3 text-center" href="javascript:void(0)">
				<div class="block-content block-content-full">
					<div class="h1 font-w700 text-success" data-toggle="countTo" data-to="<?php echo $walletcount[0]['countwallet']; ?>"></div>
				</div>
				<div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Wallet Transactions</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4">
			<div class="block block-link-hover3 text-center" href="javascript:void(0)">
				<div class="block-content block-content-full">
					<div class="h1 font-w700">$<span data-toggle="countTo" data-to="<?php echo $finalwalletamount; ?>"></span></div>
				</div>
				<div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Wallet Amount</div>
			</div>
		</div>
	<?php } ?>

</div>
<!-- END Header Tiles -->

<div class="block">
	<ul class="nav nav-tabs" data-toggle="tabs">
		<li class="active">
			<a href="#btabs-animated-slideup-profile">Profile</a>
		</li>
		<li>
			<a href="#btabs-animated-slideup-addresses">Addresses</a>
		</li>
		<?php if(Yii::app()->db->schema->getTable('order_info')) { ?>
			<li>
				<a href="#btabs-animated-slideup-order">Orders</a>
			</li>
		<?php }
		if(Yii::app()->db->schema->getTable('wallet')) { ?>
			<li>
				<a href="#btabs-animated-slideup-wallet">Wallet</a>
			</li>
		<?php } ?>
		<li>
			<a href="#btabs-animated-slideup-changepassword">Change password</a>
		</li>
        <li>
			<a href="#btabs-animated-slideup-PayoutInfo">Payout Information</a>
		</li>
	</ul>


	<div class="block-content tab-content">
		<!--Start Profile tab-->
		<div class="tab-pane fade fade-up in active" id="btabs-animated-slideup-profile">
			<div class="pull-right">
				<?php echo CHtml::link('Go to list', array('userInfo/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
				<?php echo CHtml::link('Create', array('userInfo/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
				<?php if ($id != $admin){ echo CHtml::link('Update', array('userInfo/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary')); }?>
				<?php /*echo CHtml::link('Change Password', array('userInfo/changePassword/'.$id), array('class' => 'btn btn-minw btn-square btn-primary')); */?>
				<?php
				$user = UserInfo::model()->findByPk(['user_id' => $id]);
				$userTable = CylTables::model()->findByAttributes(['table_name' => 'user_info']);
				$activeField = CylFields::model()->findByAttributes(['table_id' => $userTable->table_id, 'field_name' => 'is_active']);
				if($user->is_active == 1){ $userActive = 0; $label = 'Inactive'; }else { $userActive = 1; $label = 'Active';}
				$fieldValue = CylFieldValues::model()->findByAttributes(['field_id' => $activeField->field_id, 'predefined_value' => $userActive]);
				if ($id != $admin) { echo CHtml::link($label, array('userInfo/userActive/', 'id' => $id, 'is_active' => $user->is_active), array('class' => 'btn btn-minw btn-square btn-primary'));}?>
				<p></p>
			</div>

			<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'htmlOptions' => array('class' => 'table'),
				'attributes'=>array(
					/*'user_id',*/
					'full_name',
					'first_name',
					'middle_name',
					'last_name',
					'email',
					/*'password',*/
					'date_of_birth',
					'language',
					[
					        'name' => 'notification_mail',
                            'value' => function($model) {
					            if($model->notification_mail == 0){
					                return "false";
                                }else{
					                return "true";
                                }
                            }
                    ],
                    [
					        'name' => 'marketting_mail',
                            'value' => function($model) {
					            if($model->marketting_mail == 0){
					                return "false";
                                }else{
					                return "true";
                                }
                            }
                    ],
					[
						'name' => 'gender',
						'value' => function($model){
							$tableName = CylTables::model()->findByAttributes(['table_name' => 'user_info']);
							$fieldName = CylFields::model()->findByAttributes(['field_name' => 'gender', 'table_id' => $tableName->table_id]);
							$fieldValue = CylFieldValues::model()->findByAttributes(['field_id' => $fieldName->field_id, 'predefined_value' => $model->gender ]);
							return $fieldValue->field_label;
						}
					],
					[
						'name' => 'is_enabled',
						'value' => function($model){
							$tableName = CylTables::model()->findByAttributes(['table_name' => 'user_info']);
							$fieldName = CylFields::model()->findByAttributes(['field_name' => 'is_enabled', 'table_id' => $tableName->table_id]);
							$fieldValue = CylFieldValues::model()->findByAttributes(['field_id' => $fieldName->field_id, 'predefined_value' => $model->is_enabled ]);
							return $fieldValue->field_label;
						}
					],
					[
						'name' => 'is_active',
						'value' => function($model){
							$tableName = CylTables::model()->findByAttributes(['table_name' => 'user_info']);
							$fieldName = CylFields::model()->findByAttributes(['field_name' => 'is_active', 'table_id' => $tableName->table_id]);
							$fieldValue = CylFieldValues::model()->findByAttributes(['field_id' => $fieldName->field_id, 'predefined_value' => $model->is_active ]);
							return $fieldValue->field_label;
						}
					],
					'created_at',
					'modified_at',
					/*'business_name',
                    'vat_number',
                    'busAddress_building_num',
                    'busAddress_street',
                    'busAddress_region',
                    'busAddress_city',
                    'busAddress_postcode',
                    'busAddress_country',
                    'business_phone',
                    'building_num',
                    'street',
                    'region',
                    'city',
                    'postcode',
                    'country',
                    'phone',
                    'is_delete',
                    'image',*/
					'auth_level',
				),
			)); ?>

		</div>
		<!--End Profile tab-->

		<!--Start Addresses tab-->
		<div class="tab-pane fade fade-up" id="btabs-animated-slideup-addresses">
			<div class="block">
				<div class="block-content">
					<div class="row">
						<div class="col-lg-6">
							<!-- Shipping Address -->
							<div class="block block-bordered">
								<div class="block-header">
									<h3 class="block-title">Personal Address</h3>
								</div>
								<div class="block-content block-content-full">
									<div class="h4 push-5"><?php echo $model->full_name; ?></div>
									<address>
										<?php if($model->building_num){echo $model->building_num;} if($model->street){echo $model->street."<br>";}?>
										<?php if($model->region){echo $model->region."<br>" ;}?>
										<?php if($model->city){echo $model->city."<br>";} ?>
										<?php $codesql = "select country_name from countries where country_code = "."'$model->country'";
										$country = Yii::app()->db->createCommand($codesql)->queryAll();
										if(!empty($country)){
											echo $country[0]['country_name'].",".$model->postcode.".";?><br><br>
											<?php
										}
										else{
											echo $model->country.",".$model->postcode; ?><br><br>
											<?php
										}
										?>
										<i class="fa fa-phone"></i> <?php echo $model->phone; ?><br>
										<i class="fa fa-envelope-o"></i> <a href="javascript:void(0)"><?php echo $model->email; ?></a>
									</address>
								</div>
							</div>
							<!-- END Shipping Address -->
						</div>

						<div class="col-lg-6">
							<?php if($model->business_name != ''){?>
								<!-- Business Address -->
								<div class="block block-bordered">
									<div class="block-header">
										<h3 class="block-title">Business Address</h3>
									</div>
									<div class="block-content block-content-full">
										<div class="h4 push-5"><?php echo $model->business_name; ?></div>

										<address>
											 <?php if($model->vat_number){ ?><div class="push-5">VAT :- <?php echo $model->vat_number."<br>" ;?></div><?php } ?>
											<?php if($model->busAddress_building_num){echo $model->busAddress_building_num;}if($model->busAddress_street){echo $model->busAddress_street."<br>" ; }?>
											<?php if($model->busAddress_region){echo $model->busAddress_region."<br>" ;}?>
											<?php if($model->busAddress_city){echo $model->busAddress_city."<br>";} ?>
											<?php $codesql = "select country_name from countries where country_code = "."'$model->busAddress_country'";
											$country = Yii::app()->db->createCommand($codesql)->queryAll();
											if(!empty($country)){
												echo $country[0]['country_name'].",".$model->busAddress_postcode; ?><br><br>
												<?php
											}
											else{
												echo $model->busAddress_country.",".$model->busAddress_postcode; ?><br><br>
												<?php
											}
											?>
											<i class="fa fa-phone"></i> <?php echo $model->business_phone; ?><br>
											<i class="fa fa-envelope-o"></i> <a href="javascript:void(0)"><?php echo $model->email; ?></a>
										</address>
									</div>
								</div>
								<!-- END Billing Address -->
							<?php } ?>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!--End Addresses tab-->

		<!--Start Order tab-->
		<?php if(Yii::app()->db->schema->getTable('order_info')) { ?>
			<div class="tab-pane fade fade-up" id="btabs-animated-slideup-order">
				<a class="btn btn-outline-primary pull-right" id="clearfiltersorder">Clear Filters <i class="fa fa-times"></i></a>
				<div id="order-info-grid">
					<table id="order-info-table" class="table table-striped table-bordered dataTable no-footer" width="100%" style="font-size:13px;width: 100%;" cellspacing="0" cellpadding="0">
						<thead class="custom-table-head">
						<tr>
							<!-- <th class="custom-table-head sorting">Action</th> -->
							<?php
							$array_cols = Yii::app()->db->schema->getTable('order_info')->columns;
							foreach($array_cols as $key=>$col){
								if($col->name == 'user_id'){
									?>
									<th class="custom-table-head sorting">Username</th>
								<?php } elseif ($col->name == 'order_status') { ?>
									<th class="custom-table-head sorting">Status</th>
								<?php }elseif ($col->name == 'invoice_date') { ?>
									<th class="custom-table-head sorting">Date</th>
								<?php }elseif ($col->name == 'order_info_id') { ?>
									<th class="custom-table-head sorting">Action</th>
								<?php }elseif ($col->name == 'is_subscription_enabled') { ?>
									<th class="custom-table-head sorting">Subscription</th>
								<?php }else{ ?>
									<th class="custom-table-head sorting"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
									<?php
								}
							}
							?>
						</tr>
						</thead>
						<thead>
						<tr>
							<?php
							$arr = array_values($array_cols);
							foreach($arr as $key=>$col){
								switch($col->name)
								{

									case 'order_id':
					echo "<td></td>";
					echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
					break;

				case 'user_id':
						echo "<td><input type='text' data-column='24' class='text-box' style='width:100%'></td>";
						break;
					case 'order_status':
					echo "<td><select class='drop-box' data-column='7' style='width:100%'>
																	<option value=''>Select</option>
																	<option value='1'>Success</option>
																	<option value='0'>Cancelled</option>
																	<option value='2'>Pending</option>
															</select></td>";
					break;

			case 'order_origin':
											echo "<td><input type='text' data-column='8' class='text-box' style='width:100%'></td>";
											break;



			case 'netTotal':
													echo "<td><input type='text' data-column='17' class='text-box' style='width:100%'></td>";
											break;

				case 'invoice_number':
					echo "<td><input type='text' data-column='18' class='text-box' style='width:100%'></td>";
					break;

				case 'invoice_date':
					// echo "<td><input type='date' data-column='17' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
					?>
											<td>
													<input class="date_range_filter" type="text" id="starts_at_min" data-column="19" style='width:100%' placeholder="From"/><br/>
													<input class="date_range_filter" type="text" id="starts_at_max" data-column="19" style='width:100%' placeholder="To"/>
											</td>
											<?php
					break;



									default :
										break;
								}
							}
							?>
						</tr>
						</thead>
					</table>
				</div>
			</div>
		<?php } ?>
		<!--Start Order tab-->

		<!--Start Wallet tab-->
		<?php if(Yii::app()->db->schema->getTable('wallet')) { ?>
			<div class="tab-pane fade fade-up" id="btabs-animated-slideup-wallet">
				<div id="wallet-grid">
					<a class="btn btn-outline-primary pull-right" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
					<table id="wallet-table" class="table table-striped table-bordered" style="font-size:13px; width: 100%;" cellspacing="0" cellpadding="0">
						<thead class="custom-table-head">
						<tr>
							<!-- <th class="custom-table-head">Action</th> -->
							<?php
							$array_cols = Yii::app()->db->schema->getTable('wallet')->columns;
							foreach($array_cols as $key=>$col){
								if($col->name == 'wallet_type_id'){
									?>
									<th class="custom-table-head">Wallet type</th>
									<?php
								}
								else if($col->name == 'wallet_id'){
									?>
									<th class="custom-table-head">Action</th>
									<?php
								}else if($col->name == 'denomination_id'){
									?>
									<th class="custom-table-head">Denomination</th>
									<?php
								}else if($col->name == 'transaction_status'){
									?>
									<th class="custom-table-head">Status</th>
									<?php
								}else if($col->name == 'created_at'){
									?>
									<th class="custom-table-head">Date</th>
									<?php
								}
								else{
									?>
									<th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
									<?php
								}
							}
							?>
						</tr>
						</thead>
						<thead>
						<tr>
							<td></td>
							<?php
							$arr = array_values($array_cols);
							foreach($arr as $key=>$col){
								switch($col->name)
								{

									case 'transaction_type':
										echo "<td>
                                    <select class='drop-box' data-column='3' style='width:100%'>
                                    <option value=''>Select</option>
                                    <option value='0'>Credit</option>
                                    <option value='1'>Debit</option>
                                </select>
                                </td>";
										//						echo "<td><input type='text' data-column='3' class='text-box'></td>";
										break;

									case 'transaction_comment':
										echo "<td><input type='text' data-column='6' class='text-box' style='width:100%'></td>";
										break;

									case 'denomination_id':
										$denominationsql = "select denomination_id,denomination_type from denomination";
										$denominations = Yii::app()->db->createCommand($denominationsql)->queryAll();
										?><td><select class='drop-box' data-column='7' style='width:100%'>
											<option value=''>Select</option>
											<?php foreach($denominations as $key=>$value){ ?>
												<option value='<?php echo $value['denomination_id']; ?>'><?php echo $value['denomination_type']; ?></option>
											<?php } ?>
										</select>
										</td>
										<?php

										//						echo "<td><input type='text' data-column='7' class='text-box'></td>";
										break;

									case 'transaction_status':
										echo "<td><select class='drop-box' data-column='8' style='width:100%'>
                                   <option value=''>Select</option>
                                   <option value='0'>Pending</option>
                                   <option value='1'>On Hold</option>
                                   <option value='2'>Approved</option>
                                   <option value='3'>Rejected</option>
                                   </select>
                                   </td>";
										break;

									case 'amount':
										echo "<td><input type='text' data-column='10' class='text-box' style='width:100%'></td>";
										break;

									case 'created_at':
										// echo "<td><input type='date' data-column='12' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
										?>
		                                <td>
		                                    <input class="date_range_filter" type="text" id="starts_at_minW" data-column="12" style='width:100%' placeholder="From"/><br/>
		                                    <input class="date_range_filter" type="text" id="starts_at_maxW" data-column="12" style='width:100%' placeholder="To"/>
		                                </td>
		                                <?php
										break;

									default :
										break;
								}
							}
							?>
						</tr>
						</thead>


					</table>
				</div>
			</div>
		<?php } ?>
		<!--End Wallet tab-->

		<!--Start Change password tab-->
		<div class="tab-pane fade fade-up" id="btabs-animated-slideup-changepassword">
			<div class="block">
				<div class="block-content block-content-narrow">
					<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
						'id' => 'usersChangePassword',
						'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
						'enableAjaxValidation' => false,
					));
					?>
					<div class="row">
						<div class="col-md-12">
							<div class="form-material has-error">
								<p id="passwordError" class="help-block has-error" style="display: none;"></p>
							</div>
							<div class="form-material has-success">
								<p id="passwordMessage" class="help-block " style="display: none;"></p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="col-md-12">
								<div class="form-group ">
									<div class="control-group">
										<label class="control-label required" for="UserInfo_newPassword">New Password <span class="required">*</span></label>
										<div class="controls">
											<input maxlength="50" class="form-control input-50" name="UserInfo[newPassword]" id="UserInfo_newPassword" type="password">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group ">
									<div class="control-group">
										<label class="control-label required" for="UserInfo_confirmPassword">Confirm Password <span class="required">*</span></label>
										<div class="controls">
											<input maxlength="50" class="form-control input-50" name="UserInfo[confirmPassword]" id="UserInfo_confirm_password" type="password">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row col-md-12">
						<div class="form-group">
							<?php echo CHtml::submitButton($model->isNewRecord ? 'Change' : 'Save', array(
								'class' => 'btn btn-primary',
							)); ?>
							<?php echo CHtml::link('Cancel', array('userInfo/admin'),
								array(
									'class' => 'btn btn-default'
								)
							);
							?>
						</div>
					</div>
					<?php $this->endWidget(); ?>
				</div>
			</div>
		</div>
		<!--Start Change Password tab-->

        <div class="tab-pane fade fade-up" id="btabs-animated-slideup-PayoutInfo">
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$payout,
                'htmlOptions' => array('class' => 'table'),
                'attributes'=>array(
                    'user_id',
                    'bank_name',
                    'account_name',
                    'iban',
                    'bic_code',
                    'bank_building_num',
                    'bank_street',
                    'bank_region',
                    'bank_city',
                    'bank_postcode',
                    'bank_country',
                    'created_at',
                    'modified_at'
                ),
            )); ?>
        </div>
	</div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/bootstrap-datepicker/bootstrap-datepicker.js', CClientScript::POS_END);
?>
<script>
	jQuery(function () {
		// Init page helpers (Appear + CountTo plugins)
		App.initHelpers(['appear', 'appear-countTo']);
	});
	var changePassword = '<?php  echo Yii::app()->createUrl('admin/userInfo/changePassword/'.$model->user_id);  ?>';

	var userorders = '<?php  echo Yii::app()->createUrl('admin/userInfo/userorders/'.$model->user_id);  ?>';

	//$(".overlay").removeClass("hide");
	$(document).ready(function() {
		var datatable = $('#order-info-table').DataTable({
			"order": [[ 18, "desc" ]],
			"pageLength":20,
			"lengthMenu": [[20,50,100,200], [20,50,100,200]],
			// "scrollX" : true,
			// "sScrollX": "100%",
			"dom":'l,t',
			/*"pageLength" : 10,
			 responsive: {
			 details: {
			 renderer: $.fn.dataTable.Responsive.renderer.tableAll({tableClass : 'ui table'})
			 }
			 },*/
			"processing": true,
			"serverSide": true,
			// "searching": false,
//			"ajax": "serverdata",
			"ajax": {
				"type" : "GET",
				"url" : userorders,
				"data": function ( d ) {
                	d.myKey = "myValue";
                	d.min = $('#starts_at_min').val();
                	d.max = $('#starts_at_max').val();
                // etc
            	},
				"dataSrc": function ( json ) {
//					console.info(json.data[0]);
//					console.info(json.data.length);
					/*var i;
					 for (i = 0; i<json.data.length ; i++) {
					 if(json.data[0][8] == 1)
					 {

					 json.data[0][8] = 'male';

					 }
					 else{
					 json.data[0][8] = 'male';

					 }
					 console.info(i);
					 }*/
					// $("#order-info-table_filter").addClass("hide");
					return json.data;
				}
			},
			"columnDefs": [ {
				"targets": 0,
				"data": null,
				"render" : function(data, type, row) {
					return '<a href="<?php echo Yii::app()->createUrl("admin/orderInfo/view/").'/'; ?>'+data[0]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/orderInfo/creditMemo/").'/'; ?>'+data[0]+'"><i class="fa fa-external-link"></i></a>';
				}
				//"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
			},{
				"visible":false,
				"targets":[3,4,5,6,9,10,11,12,13,14,15,16,20,21,22,23,24,25]
				// "targets":[2,3,4,5,8,9,10,12,14,15,16,17,20,21,23,24,25]

			} ]
		});

		$('.text-box').on('keyup', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			datatable.columns(i).search(v).draw();
		} );

		$(".date_range_filter").datepicker({
            format : "yyyy-mm-dd",
            autoclose : true
        });

        $('#starts_at_min, #starts_at_max').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

		$('.date-field').on('change', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			datatable.columns(i).search(v).draw();
		} );

		$('.drop-box').on('change', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			datatable.columns(i).search(v).draw();
		} );

		$('#clearfiltersorder').on('click',function() {
			datatable.columns().search('').draw();
			datatable.search('').draw();
			$('input[type=text]').val('');
			$('.drop-box').val('');
			$('.date-field').val('');
		});

	});
</script>
<script>
	var userwallet = '<?php  echo Yii::app()->createUrl('admin/userInfo/userwallet/'.$model->user_id);  ?>';
	//$(".overlay").removeClass("hide");
	$(document).ready(function() {
		var datatable = $('#wallet-table').DataTable({
			"order": [[ 12, "desc" ]],
			"pageLength":20,
			"lengthMenu": [[20,50,100,200], [20,50,100,200]],
			// "scrollX" : true,
			// "sScrollX": "100%",
			"dom":'l,t',
			// "searching": false,
			/*responsive: {
			 details: {
			 renderer: $.fn.dataTable.Responsive.renderer.tableAll({tableClass : 'ui table'})
			 }
			 },*/
			"processing": true,
			"serverSide": true,
//			"ajax": "serverdata",
			"ajax": {
				"type" : "GET",
				"url" : userwallet,
				"data": function ( d ) {
                	d.myKey = "myValue";
                	d.min = $('#starts_at_minW').val();
                	d.max = $('#starts_at_maxW').val();
                // etc
            	},
				"dataSrc": function ( json ) {
//					console.info(json.data[0]);
//					console.info(json.data.length);
					/*var i;
					 for (i = 0; i<json.data.length ; i++) {
					 if(json.data[0][8] == 1)
					 {

					 json.data[0][8] = 'male';

					 }
					 else{
					 json.data[0][8] = 'male';

					 }
					 console.info(i);
					 }*/
					// $("#wallet-table_filter").addClass("hide");
					return json.data;
				}
			},
			"columnDefs": [ {
				"targets": 0,
				"data": null,
				"render" : function(data, type, row) {
					return '<a href="<?php echo Yii::app()->createUrl("admin/wallet/view/").'/'; ?>'+data[0]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/wallet/update/").'/'; ?>'+data[0]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/wallet/delete/").'/'; ?>'+data[0]+'"><i class="fa fa-times"></i></a>';
				}
				//"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
			},{
				"visible":false,
				// "targets":[1,2,5,6,10,11,14]
				// "targets":[1,2,3,5,6,10,12,14]
				"targets":[1,2,4,5,9,11,13]
			} ]

		});

		$('.text-box').on( 'keyup', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			datatable.columns(i).search(v).draw();
		} );

		$(".date_range_filter").datepicker({
            format : "yyyy-mm-dd",
            autoclose : true
        });

        $('#starts_at_minW, #starts_at_maxW').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

		$('.date-field').on('change', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			datatable.columns(i).search(v).draw();
		} );

		$('.drop-box').on('change', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			datatable.columns(i).search(v).draw();
		} );

		$('#clearfilters').on('click',function() {
			datatable.columns().search('').draw();
			datatable.search('').draw();
			$('input[type=text]').val('');
			$('.drop-box').val('');
			$('.date-field').val('');
		});

	});
</script>
