<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->pageTitle = 'Categories';
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
    <div class="alert alert-success hide" id="delete" align="center">
        <h4>Category deleted successfully</h4>
    </div>
	<div class="col-md-12">
        <?php
		$sql = "SELECT * FROM categories";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		if(!empty($result)){
			?> 
            <div class="pull-right m-b-10">
                <?php echo CHtml::link('Create', array('Categories/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>

            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>

            <div id="categories-grid">
            <table id="categories-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <th class="custom-table-head">Action</th>
                    <?php $array_cols = Yii::app()->db->schema->getTable('categories')->columns;
                    foreach($array_cols as $key=>$col){ ?>
                    <th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
                    <?php } ?>
                </tr>
                </thead>


                <thead>
                <tr>
                    <?php
					$arr = array_values($array_cols);
					foreach($arr as $key=>$col){
						switch($col->name)
						{

							case 'category_name':
								echo "<td></td>";
								echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
								break;

							case 'description':
								echo "<td><input type='text' data-column='2' class='text-box' style='width:100%'></td>";
								break;

							case 'is_active':
								echo "<td><select class='drop-box' data-column='3' style='width:100%'>
                                        <option value=''>Select</option>
                                        <option value='1'>Yes</option>
                                        <option value='0'>No</option>
                                    </select></td>";
								break;

							/*case 'created_at':
								echo "<td><input type='date' data-column='4' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
								break;*/

							default :
								break;
						}
					}
					?>
                </tr>
                </thead>


                <!--<tfoot>
                    <tr>
                        <th>Action</th>
                                                    <th></th>
                                                </tr>
                    </tfoot>-->
            </table>
        </div>
            <div class="row"><br/></div>
        <?php } else { ?> 
            <div class="row">
                <div align="center">
                    <img src="<?php echo Yii::app()->baseUrl."/plugins/img/product.png"; ?>" height="20%" width="10%"><br /><br />
                    <h2>No Category</h2>
                    <p></p>
                    <div class="row">
                        <?php echo CHtml::link('Create', array('Categories/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
                    </div>
                    <br />
                </div>
            </div>
        <?php } ?>


	</div>
</div>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script>
	$(document).ready(function() {
        if (localStorage.getItem('msg')){
            $("#delete").removeClass("hide");
            setTimeout(
                function(){
                    $("#delete").addClass("hide");
                },5000
            );
            localStorage.removeItem('msg');
        }
		var d = new Date();

		var month = d.getMonth()+1;
		var day = d.getDate();

		var currentDate = d.getFullYear() + '/' +
			((''+month).length<2 ? '0' : '') + month + '/' +
			((''+day).length<2 ? '0' : '') + day;
		var datatable = $('#categories-table').DataTable({
            "fnDrawCallback":function(){
                if($('#categories-table td').hasClass('dataTables_empty')){
                    $('div.dataTables_paginate').hide();
                    $('div#categories-table_info').hide();
                } else {
                    $('div#categories-table_info').show();
                    $('div.dataTables_paginate').show();
                }
            },
			"pageLength":20,
			"lengthMenu": [[20,50,100,200], [20,50,100,200]],
			"scrollX" : true,
			"sScrollX": "100%",
			/*"pageLength" : 10,
			 responsive: {
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
					title: 'Category Data export '+currentDate
				},
				{
					extend: 'excelHtml5',
					title: 'Category Data export '+currentDate
				},
				{
					extend: 'csvHtml5',
					title: 'Category Data export '+currentDate
				},
				{
					extend: 'pdfHtml5',
					title: 'Category Data export '+currentDate
				},
				{
					extend: 'print',
					title: 'Category Data export '+currentDate
				}
			],
			"serverSide": true,
//			"ajax": "serverdata",
			"ajax": {
				"type" : "GET",
				"url" : "serverdata",
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
                    $('.overlay').addClass("overlayhide");
                    $("#mydatatable").removeClass("hide");					
					return json.data;
				}
			},
			"columnDefs": [ {
				"targets": 0,
				"data": null,
				"render" : function(data, type, row) {
					return '<a href="<?php echo Yii::app()->createUrl("admin/categories/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/categories/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)"><i class="fa fa-times delete-category" id="'+data[1]+'"></i></a>';
				}
				//"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
			},{
				"visible":false,
				"targets":[1,5,6,7]
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

        $(' body ').on('click','.delete-category',function() {
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure you want to delete this category?", function(result){
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
	});
</script>