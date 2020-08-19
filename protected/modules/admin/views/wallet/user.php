<?php
/* @var $this WalletController */
/* @var $model Wallet */

$this->pageTitle = 'User Wallets';
/*if(count($model->search()->getData()) == 0)
{
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/../plugins/js/core/jquery.min.js');
}*/
 ?>

<!--Begin loader-->
    <div class="overlay" style="opacity:0.1 !important;position:unset !important;">
        <div class="loader">
            <!-- <div class="m-loader m-loader--lg m-loader--success" style="width: 30px; display: inline-block;"></div> -->
            <p style="font-size: 18px;"><i class="fa fa-cog fa-spin" aria-hidden="true"></i> Loading...</p>
        </div>
    </div>
<!--End loader-->

<div class="row hide" id="mydatatable">
    
	<div class="col-md-12">
         <?php
		$sql = "SELECT * from wallet";
		$result = Yii::app()->db->CreateCommand($sql)->queryAll();
		if(!empty($model)){ ?>
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
                    <!-- <th class="custom-table-head">Action</th> -->
                     <?php
					$array_cols = Yii::app()->db->schema->getTable('wallet')->columns;
					foreach($array_cols as $key=>$col){
						if($col->name == 'user_id'){ ?>
                    <th class="custom-table-head">User name</th>
                     <?php } else if($col->name == 'wallet_type_id'){ ?>
                    <th  class="custom-table-head">Wallet type</th>
                     <?php } else if($col->name == 'wallet_id'){ ?>
                    <th  class="custom-table-head">Action</th>
                     <?php } else if($col->name == 'denomination_id'){ ?>
                    <th  class="custom-table-head">Denomination</th>
                     <?php } else { ?>
                    <th  class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
                     <?php } } ?>
                     <th class="custom-table-head">CashBack Wallet</th>
                     <th class="custom-table-head">Fan Wallet</th>
                     <th class="custom-table-head">Backup Wallet</th>
                     <th class="custom-table-head">Floating Wallet</th>
                     <th class="custom-table-head">Upcycling Wallet</th>
                     <th class="custom-table-head">Company Wallet</th>
                     <th class="custom-table-head">Swimlane Wallet</th>
                     
                </tr>
                </thead>
                
            </table>
        </div>
            <div class="row"><br/></div>
		 <?php } else {?>
            <div class="row">
                <div align="center">
                    <img src="<?php echo Yii::app()->baseUrl."/plugins/img/wallet.png"; ?>" height="20%" width="10%"><br /><br />
                    <h2>No User Wallet Daata</h2>
                    <br />
                </div>
            </div>
        <?php } ?>
	</div>
</div>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script>
	$(document).ready(function() {
        
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
			"order" : [[12,"DESC"]],
			"pageLength":20,
			"lengthMenu": [[20,50,100,200], [20,50,100,200]],
			
			"processing": true,
			"serverSide": true,
            "bFilter": false,
            "searching": true,
            
			"ajax": {
				"type" : "GET",
				"url" : "Usersdata",
				"dataSrc": function ( json ) {
					
					$('.overlay').addClass("overlayhide");
                    $("#mydatatable").removeClass("hide");
					return json.data;
				}
			},
			"columnDefs": [ {
				"visible":false,
				// "targets":[1,5,6,10,12,13,14]
				"targets":[0,2,3,4,5,6,7,8,9,10,11,12,13]
			},{
				"targets": [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
				"orderable": false
			}]

		});

		$('#clearfilters').on('click',function() {
			datatable.columns().search('').draw();
			datatable.search('').draw();
			$('input[type=text]').val('');
			$('.drop-box').val('');
			$('.date-field').val('');
		});
        
	});
</script>