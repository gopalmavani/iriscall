<?php
/* @var $this WalletTypeEntityController */
/* @var $model WalletTypeEntity */

$this->pageTitle = 'Wallet Settings';
 ?>

<div class="row">
    <div class="alert alert-success hide" id="delete" align="center">
        <h4>WalletTypeEntity deleted successfully</h4>
    </div>
	<div class="col-md-12">
		<div class="block">
			<ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs">
				<li class="active">
					<a href="#btabs-alt-static-justified-home">Wallet Types</a>
				</li>
				<li>
					<a href="#btabs-alt-static-justified-profile">Wallet Meta Types</a>
				</li>
				<li>
					<a href="#btabs-alt-static-justified-settings">Denominations</a>
				</li>
			</ul>
			<div class="block-content tab-content">


				<div class="tab-pane active" id="btabs-alt-static-justified-home">
					<div class="row">
						<div class="col-md-12">
                            <?php
							$walletData = WalletTypeEntity::model()->findAllByAttributes(array());
							if($walletData != null){ ?>
                                <div class="pull-right m-b-10">
                                    <?php echo CHtml::link('Create', array('WalletTypeEntity/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                                </div>
								<div id="wallet-type-entity-grid">
									<table id="wallet-type-table" width="100%" class="table table-striped table-bordered">
										<thead class="custom-table-head">
										<tr>
											<th class="custom-table-head">Action</th>
											<?php
											$array_cols = /*Yii::app()->db->schema->getTable('wallet_type_entity')->columns*/['wallet_type_id', 'wallet_type'];
											foreach($array_cols as $key=>$col){
												?>
												<th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col/*->name*/)); ?></th>

												<?php
											}
											?>
										</tr>
										</thead>

										<tbody>
										<?php
										foreach($walletData as $key=>$walletdata){
											?>
											<tr>
												<td><a href="<?php echo Yii::app()->createUrl('admin/walletTypeEntity/view/').'/'.$walletdata->wallet_type_id; ?>"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl('admin/walletTypeEntity/update/').'/'.$walletdata->wallet_type_id; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)"><i class="fa fa-times delete-walletType" id = <?php echo $walletdata->wallet_type_id;?> ></i></a></td>
                                                <td><?php echo $walletdata->wallet_type_id; ?></td>
                                                <td><?php echo $walletdata->wallet_type; ?></td>
												<!--<td><?php /*echo $walletdata->created_at;*/ ?></td>
												<td><?php /*echo $walletdata->modified_at; */?></td>-->

											</tr>
											<?php
										}
										?>
										</tbody>
									</table>
								</div>
                            <?php } else{	?>
                                <div class="row">
                                    <div align="center">
                                        <img src="<?php echo Yii::app()->baseUrl."/plugins/img/wallet.png"; ?>" height="20%" width="10%"><br /><br />
                                        <h2>No Wallet</h2>
                                        <p></p>
                                        <div class="row">
                                            <?php echo CHtml::link('Create', array('WalletTypeEntity/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
                                        </div>
                                        <br />
                                    </div>
                                </div>
                            <?php } ?>
						</div>
					</div>
				</div>



				<div class="tab-pane" id="btabs-alt-static-justified-profile">
					<div class="row">
                        <div class="alert alert-success hide" id="delete1" align="center">
                            <h4>WalletMetaEntity deleted successfully</h4>
                        </div>
						<div class="col-md-12">
                            <?php
							$walletMeta = WalletMetaEntity::model()->findAllByAttributes(array());
							if($walletMeta){
								?>
							    <div class="pull-right m-b-10">
								    <?php echo CHtml::link('Create', array('WalletMetaEntity/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
							    </div>
								<div id="wallet-meta-entity-grid">
									<table id="wallet-meta-table" width="100%" class="table table-striped table-bordered">
										<thead class="custom-table-head">
										<tr>
                                            <th class="custom-table-head">Action</th>
											<?php
											$array_cols = /*Yii::app()->db->schema->getTable('wallet_meta_entity')->columns*/['reference_id', 'reference_key', 'reference_desc', 'reference_data'];
											foreach($array_cols as $key=>$col){
												?>

                                            <th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col/*->name*/)); ?></th>

											<?php
											}
											?>
										</tr>
										</thead>

										<tbody>
										<?php
										foreach($walletMeta as $key=>$walletmeta){
											?>
											<tr>
                                                <td><a href="<?php echo Yii::app()->createUrl('admin/walletMetaEntity/view/').'/'.$walletmeta->reference_id; ?>"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl('admin/walletMetaEntity/update/').'/'.$walletmeta->reference_id; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)"><i class="fa fa-times delete-walletMetaType" id= <?php echo $walletmeta->reference_id;?> ></i></a></td>
                                                <td><?php echo $walletmeta->reference_id; ?></td>
												<td><?php echo $walletmeta->reference_key; ?></td>
												<td><?php echo $walletmeta->reference_desc; ?></td>
												<td><?php echo $walletmeta->reference_data; ?></td>
												<!--<td><?php /*echo $walletmeta->created_at;*/ ?></td>
												<td><?php /*echo $walletmeta->modified_at; */?></td>-->

											</tr>
											<?php
										}
										?>
										</tbody>

										<!--<tfoot>
											<tr>
												<th>Action</th>
																									<th></th>
																								</tr>
											</tfoot>-->
									</table>
								</div>
                            <?php } else{	?>
                                <div class="row">
                                    <div align="center">
                                        <img src="<?php echo Yii::app()->baseUrl."/plugins/img/wallet.png"; ?>" height="20%" width="10%"><br /><br />
                                        <h2>No Wallet Meta Type</h2>
                                        <p></p>
                                        <div class="row">
                                            <?php echo CHtml::link('Create', array('WalletMetaEntity/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
                                        </div>
                                        <br />
                                    </div>
                                </div>
                            <?php } ?>
						</div>
					</div>
				</div>



				<div class="tab-pane" id="btabs-alt-static-justified-settings">
					<div class="row" xmlns:Yii="http://www.w3.org/1999/xhtml" xmlns:Yii="http://www.w3.org/1999/xhtml"
						 xmlns:Yii="http://www.w3.org/1999/xhtml">
                        <div class="alert alert-success hide" id="delete2" align="center">
                            <h4>Wallet denomination deleted successfully</h4>
                        </div>
						<div class="col-md-12">
                            <?php
							$Denomination = Denomination::model()->findAllByAttributes(array());
							if($Denomination){ ?>
							    <div class="pull-right m-b-10">
								    <?php echo CHtml::link('Create', array('Denomination/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
							    </div>
                                <div id="user-info-grid">
									<table id="denomination-table" width="100%" class="table table-striped table-bordered">
										<thead class="custom-table-head">
										<tr>
                                            <th class="custom-table-head">Action</th>
											<?php
											$array_cols = /*Yii::app()->db->schema->getTable('denomination')->columns*/['denomination_id', 'denomination_type', 'sub_type', 'label', 'currency'];
											foreach($array_cols as $key=>$col){
												?>
                                            <th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col/*->name*/)); ?></th>

											<?php
											}
											?>
										</tr>
										</thead>

										<tbody>
										<?php
										foreach($Denomination as $key=>$denomination){
											?>
											<tr>
												<td><a href="<?php echo Yii::app()->createUrl('admin/denomination/view/').'/'.$denomination->denomination_id; ?>"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl('admin/denomination/update/').'/'.$denomination->denomination_id; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)"><i class="fa fa-times delete-walletDenomination" id=<?php echo $denomination->denomination_id;?> ></i></a></td>
												<td><?php echo $denomination->denomination_id; ?></td>
												<td><?php echo $denomination->denomination_type; ?></td>
												<td><?php echo $denomination->sub_type; ?></td>
												<!--<td><?php /*echo $denomination->created_at;*/ ?></td>
												<td><?php /*echo $denomination->modified_at;*/ ?></td>-->
												<td><?php echo $denomination->label; ?></td>
												<td><?php echo $denomination->currency; ?></td>
											</tr>
											<?php
										}
										?>
										</tbody>

										<!--<tfoot>
											<tr>
												<th>Action</th>
																									<th></th>
																								</tr>
											</tfoot>-->
									</table>
								</div>
                            <?php } else{	?>
                                <div class="row">
                                    <div align="center">
                                        <img src="<?php echo Yii::app()->baseUrl."/plugins/img/wallet.png"; ?>" height="20%" width="10%"><br /><br />
                                        <h2>No Denomination</h2>
                                        <p></p>
                                        <div class="row">
                                            <?php echo CHtml::link('Create', array('Denomination/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
                                        </div>
                                        <br />
                                    </div>
                                </div>
                            <?php } ?>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script>
	$('document').ready(function(){
        if (localStorage.getItem('msg') == "success"){
            $("#delete").removeClass("hide");
            setTimeout(
                function(){
                    $("#delete").addClass("hide");
                },5000
            )
            localStorage.removeItem('msg');
        }
        if (localStorage.getItem('msg1') == "success1"){
            $("#delete1").removeClass("hide");
            setTimeout(
                function(){
                    $("#delete1").addClass("hide");
                },5000
            )
            localStorage.removeItem('msg1');
        }
        if (localStorage.getItem('msg2') == "success2"){
            $("#delete2").removeClass("hide");
            setTimeout(
                function(){
                    $("#delete2").addClass("hide");
                },5000
            );
            localStorage.removeItem('msg2');
        }
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var currentDate = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;

        $('#wallet-type-table').DataTable( {
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'Wallet type data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Wallet type data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Wallet type data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Wallet type data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Wallet type data export '+currentDate
                }
            ]
        } );
        $('#wallet-meta-table').DataTable( {
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'Wallet meta data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Wallet meta data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Wallet meta data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Wallet meta data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Wallet meta data export '+currentDate
                }
            ]
        } );

        $('#denomination-table').DataTable( {
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'Denomination data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Denomination data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Denomination data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Denomination data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Denomination data export '+currentDate
                }
            ]
        } );
        $(' body ').on('click','.delete-walletType',function() {
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure you want to delete this walletTypeEntity?", function(result){
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
                                localStorage.setItem('msg','success');
                                window.location.reload();
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                        }
                    });
                }
            });
        });
        $(' body ').on('click','.delete-walletMetaType',function() {
            var id = $(this).attr('id');
            var url = '<?php echo Yii::app()->createUrl('admin/walletMetaEntity/delete'); ?>';
            bootbox.confirm("Are you sure you want to delete this walletMetaEntity?", function(result){
                if (result === true){
                    $.ajax({
                        url:  url,
                        type: "POST",
                        data: {'id': id},
                        beforeSend: function () {
                            $(".overlay").removeClass("hide");
                        },
                        success: function (response) {
                            var Result = JSON.parse(response);
                            if (Result.token == 1){
                                localStorage.setItem('msg1','success1');
                                window.location.reload();
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                        }
                    });
                }
            });
        });
        $(' body ').on('click','.delete-walletDenomination',function() {
            var id = $(this).attr('id');
            var url = '<?php echo Yii::app()->createUrl('admin/denomination/delete '); ?>';
            bootbox.confirm("Are you sure you want to delete this wallet Denomination?", function(result){
                if (result === true){
                    $.ajax({
                        url:  url,
                        type: "POST",
                        data: {'id': id},
                        beforeSend: function () {
                            $(".overlay").removeClass("hide");
                        },
                        success: function (response) {
                            var Result = JSON.parse(response);
                            if (Result.token == 1){
                                localStorage.setItem('msg2','success2');
                                window.location.reload();
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                        }
                    });
                }
            });
        });
    });
</script>