<?php
	/* @var $this WalletController */
	/* @var $model Wallet */

$this->pageTitle = 'Pending Wallet Records';
if(count($model->search()->getData()) == 0)
{
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/../plugins/js/core/jquery.min.js');
}
?>
<div class="row">
    <div class="alert alert-success hide" id="delete" align="center">
        <h4>Wallet deleted successfully</h4>
    </div>
    <div class="col-md-12">
         <?php
		$sql = "SELECT * from wallet where transaction_status=0";
		$result = Yii::app()->db->CreateCommand($sql)->queryAll();
		if(!empty($result)){
			?>
            <div class="pull-right m-b-10">
                 <?php echo CHtml::link('Create', array('Wallet/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>
            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>
            <div id="wallet-grid">
            <table id="wallet-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <th class="custom-table-head">Action</th>
                     <?php
					$array_cols = Yii::app()->db->schema->getTable('wallet')->columns;
					foreach($array_cols as $key=>$col){
						if($col->name == 'user_id'){
							?>
                    <th class="custom-table-head">User name</th>
                     <?php
						}
						else if($col->name == 'wallet_type_id'){
							?>
                    <th class="custom-table-head">Wallet type</th>
                     <?php
						}
						else if($col->name == 'denomination_id'){
							?>
                    <th class="custom-table-head">Denomination</th>
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
                     <?php
					$arr = array_values($array_cols);
					foreach($arr as $key=>$col){
						switch($col->name)
						{

							case 'user_id':
								echo "<td></td>";
								$usernamesql = "select user_id,full_name from user_info";
								$usernames = Yii::app()->db->createCommand($usernamesql)->queryAll();
								?><td><select class='drop-box' data-column='1' style='width:100%'>
                            <option value=''>Select</option>
                             <?php foreach($usernames as $key=>$value){ ?>
                            <option value=' <?php echo $value['user_id']; ?>'> <?php echo $value['full_name']; ?></option>
                             <?php } ?>
                        </select>
                    </td>
                     <?php
								//						echo "<td><input type='text' data-column='1' class='text-box'></td>";
								break;

							case 'wallet_type_id':
								$wallettypesql = "select wallet_type_id,wallet_type from wallet_type_entity";
								$wallettypenames = Yii::app()->db->createCommand($wallettypesql)->queryAll();
								?><td><select class='drop-box' data-column='2' style='width:100%'>
                            <option value=''>Select</option>
                             <?php foreach($wallettypenames as $key=>$value){ ?>
                            <option value='<?php echo $value['wallet_type_id']; ?>'> <?php echo $value['wallet_type']; ?></option>
                             <?php } ?>
                        </select>
                    </td>
                     <?php
								//						echo "<td><input type='text' data-column='2' class='text-box'></td>";
								break;

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
                            <option value=' <?php echo $value['denomination_id']; ?>'> <?php echo $value['denomination_type']; ?></option>
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

							case 'updated_balance':
								echo "<td><input type='text' data-column='11' class='text-box' style='width:100%'></td>";
								break;

							/*case 'created_at':
								echo "<td><input type='date' data-column='12' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
								break;*/

							default :
								break;
						}
					}
					?>
                </tr>
                </thead>
            </table>
        </div>
            <div class="row"><br/></div>
         <?php } else {?>
            <div class="row">
                <div align="center">
                    <img src="<?php echo Yii::app()->baseUrl."/plugins/img/wallet.png"; ?>" height="20%" width="10%"><br /><br />
                    <h2>No Wallet</h2>
                    <p></p>
                    <div class="row">
                        <?php echo CHtml::link('Create', array('Wallet/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
                    </div>
                    <br />
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>

<script>
    //$(".overlay").removeClass("hide");
    $(document).ready(function() {
        if (localStorage.getItem('msg')){
            $("#delete").removeClass("hide");
            setTimeout(
                function(){
                    $("#delete").addClass("hide");
                },5000
            )
            localStorage.removeItem('msg');
        }

        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var currentDate = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;

        var datatable = $('#wallet-table').DataTable({
            "fnDrawCallback":function(){
                if($('#wallet-table td').hasClass('dataTables_empty')){
                    $('div.dataTables_paginate').hide();
                    $('div#wallet-table_info').hide();
                } else {
                    $('div#wallet-table_info').show();
                    $('div.dataTables_paginate').show();
                }
            },
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            "scrollX" : true,
            "sScrollX": "100%",
            /*responsive: {
                details: {
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({tableClass : 'ui table'})
                }
            },*/
            "processing": true,
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'Wallet pending data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Wallet pending data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Wallet pending data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Wallet pending data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Wallet pending data export '+currentDate
                }
            ],
            "serverSide": true,
//			"ajax": "serverdata",
            "ajax": {
                "type" : "GET",
                "url" : "pendingdata",
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
                    $(".overlay").addClass("hide");
                    return json.data;
                }
            },
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "render" : function(data, type, row) {
                    return '<a href="<?php echo Yii::app()->createUrl("admin/wallet/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/wallet/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)"><i class="fa fa-times delete-wallet" id="'+data[1]+'"></i></a>';
                }
                //"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
            },{
                "visible":false,
                "targets":[1,5,6,10,11,13,14]
            } ]

        });

        $('.text-box').on( 'keyup', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            console.info(i);
            var v =$(this).val();  // getting search input value
            datatable.columns(i).search(v).draw();
        } );

        $('.date-field').on('change', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            console.info(i);
            var v =$(this).val();  // getting search input value
            datatable.columns(i).search(v).draw();
        } );

        $('.drop-box').on('change', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            console.info(i);
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

        $(' body ').on('click','.delete-wallet',function() {
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure you want to delete this wallet?", function (result) {
                if (result === true) {
                    $.ajax({
                        url: "Delete",
                        type: "POST",
                        data: {'id': id},
                        beforeSend: function () {
                            $(".overlay").removeClass("hide");
                        },
                        success: function (response) {
                            var Result = JSON.parse(response);
                            if (Result.token == 1) {
                                localStorage.setItem('msg', 'success');
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

