<?php
/* @var $this OrderInfoController */
/* @var $model OrderInfo */

$this->pageTitle = 'Orders';
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
		$sql = "SELECT * FROM order_info";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		if(!empty($result)){ ?>
            <div class="pull-right m-b-10">
                <?php echo CHtml::link('Create', array('orderInfo/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>
			<div style="margin-right:10px;" class="pull-right m-b-10">
				<a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
			</div>
            <div id="order-info-grid">
            <table id="order-info-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <!-- <th class="custom-table-head">Action</th> -->
                    <?php $array_cols = Yii::app()->db->schema->getTable('order_info')->columns;
                    foreach($array_cols as $key=>$col){ ?>
                    	<?php if($col->name == 'user_id'){ ?>
	                    	<th class="custom-table-head">Full Name</th>
	                    <?php }elseif ($col->name == 'created_date') { ?>
	                    	<th class="custom-table-head">Date</th>
	                    <?php }elseif ($col->name == 'order_info_id') { ?>
	                   		<th class="custom-table-head">Action</th>
	                    <?php }else{ ?>
	                    	<th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
	                    <?php } ?>
                    <?php } ?>
                </tr>
                </thead>
                <thead>
                <tr>
                    <?php
					$array_cols = Yii::app()->db->schema->getTable('order_info')->columns;

			        $arr = array_values($array_cols);
					foreach($arr as $key=>$col){

					switch($col->name) {

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

					    case 'created_date':
						    // echo "<td><input type='date' data-column='17' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
					     	?>
                            <td>
                                <input class="date_range_filter" type="text" id="starts_at_min" data-column="20" style='width:100%' placeholder="From"/><br/>
                                <input class="date_range_filter" type="text" id="starts_at_max" data-column="20" style='width:100%' placeholder="To"/>
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
            <div class="row"><br/></div>
        <?php } else { ?>
            <div class="row">
            <div align="center">
                <img src="<?php echo Yii::app()->baseUrl."/plugins/img/order.png"; ?>" height="20%" width="10%"><br /><br />
                <h2>No Order</h2>
                <p></p>
                <div class="row">
                    <?php echo CHtml::link('Create', array('orderInfo/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
                </div>
                <br />
            </div>
            </div>
        <?php } ?>
	</div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/bootstrap-datepicker/bootstrap-datepicker.js', CClientScript::POS_END);
?>

<script>
	//$(".overlay").removeClass("hide");
	var d = new Date();

	var month = d.getMonth()+1;
	var day = d.getDate();

	var currentDate = d.getFullYear() + '/' +
		((''+month).length<2 ? '0' : '') + month + '/' +
		((''+day).length<2 ? '0' : '') + day;
	$(document).ready(function() {
		var datatable = $('#order-info-table').DataTable({
            "fnDrawCallback":function(){
                if($('#order-info-table td').hasClass('dataTables_empty')){
                    $('div.dataTables_paginate').hide();
                    $('div#order-info-table_info').hide();
                } else {
                    $('div#order-info-table_info').show();
                    $('div.dataTables_paginate').show();
                }
            },
			"order": [[ 20, "desc" ]],
			"pageLength":20,
			"lengthMenu": [[20,50,100,200], [20,50,100,200]],
			// "scrollX" : true,
			// "sScrollX": "100%",
			'colReorder':true,
			/*"pageLength" : 10,
			 responsive: {
			 details: {
			 renderer: $.fn.dataTable.Responsive.renderer.tableAll({tableClass : 'ui table'})
			 }
			 },*/
			"processing": true,
            "bFilter": true,
            "searching": true,
            "dom":'l,B,t,i,p',
			"buttons": [
				{
					extend: 'copyHtml5',
					title: 'Order data export '+currentDate
				},
				{
					extend: 'excelHtml5',
					title: 'Order data export '+currentDate
				},
				{
					extend: 'csvHtml5',
					title: 'Order data export '+currentDate
				},
				{
					extend: 'pdfHtml5',
					title: 'Order data export '+currentDate
				},
				{
					extend: 'print',
					title: 'Order data export '+currentDate
				}
			],
			"serverSide": true,
//			"ajax": "serverdata",
			"ajax": {
				"type" : "GET",
				"url" : "serverdata",
				"data": function ( d ) {
                    d.myKey = "myValue";
                    d.min = $('#starts_at_min').val();
                    d.max = $('#starts_at_max').val();
                // etc
                },
				"dataSrc": function ( json ) {
					/*var i;
					 for (i = 0; i<json.data.length ; i++) {
					 if(json.data[0][8] == 1)
					 {

					 json.data[0][8] = 'male';

					 }
					 else{
					 json.data[0][8] = 'male';

					 }
					 }*/
					$('.overlay').addClass("overlayhide");
                    $("#mydatatable").removeClass("hide");
					return json.data;
				}
			},
			<?php //if('+data[7]+' == "Success"){?>
			"columnDefs": [ {
				"targets": 0,
				"data": null,
				"render" : function(data, type, row) {
                    if(data[7] == '1'){
                        return '<a href="<?php echo Yii::app()->createUrl("admin/orderInfo/view/").'/'; ?>'+data[0]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;' +
                            '<a href="<?php echo Yii::app()->createUrl("admin/orderInfo/update/").'/'; ?>'+data[0]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;' +
                            '<a href="<?php echo Yii::app()->createUrl("invoice/Generateinvoice/").'/'; ?>'+data[0]+'" download><i class="fa fa-download"></i></a>&nbsp;&nbsp;&nbsp;' +
                            '<a href="<?php echo Yii::app()->createUrl("admin/orderInfo/creditMemo/").'/'; ?>'+data[0]+'"><i class="fa fa-external-link"></i></a>';
                    }else{
                        return '<a href="<?php echo Yii::app()->createUrl("admin/orderInfo/view/").'/'; ?>'+data[0]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/orderInfo/update/").'/'; ?>'+data[0]+'"><i class="fa fa-pencil"></i></a>';
                    }
				}
				//"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
			},{
				"targets": 7,
				"data": null,
				"render" : function(data, type, row) {
					if(data[7] == '1'){
						return "<span align='center' class='label label-table label-success'>Success</span>";
					}else if(data[7] == '0'){
						return "<span align='center' class='label label-table label-danger'>Cancelled</span>";
					}else{
						return "<span align='center' class='label label-table label-warning'>Pending</span>";
					}
				}
				//"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
			},{
				"visible":false,
                "targets":[3,4,5,6,9,10,11,12,13,14,15,16,19,21,22,23,24,25]
			} ]
		});

		$(".date_range_filter").datepicker({
            format : "yyyy-mm-dd",
            autoclose : true
        });

        $('#starts_at_min, #starts_at_max').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });


		$('.text-box').on('keyup', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			datatable.columns(i).search(v).draw();
		} );

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
