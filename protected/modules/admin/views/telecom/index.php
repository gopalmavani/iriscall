<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$this->pageTitle = 'Telecom User Details';
?>
<?php $tableName = TelecomUserDetails::model()->tableSchema->name;?>


<!--Begin loader-->
    <div class="overlay" style="opacity:0.1 !important;position:unset !important;">
        <div class="loader">
            <p style="font-size: 18px;"><i class="fa fa-cog fa-spin" aria-hidden="true"></i> Loading...</p>
        </div>
    </div>
    <!--End loader-->
<div class="row hide" id="mydatatable">
    <div class="alert alert-success hide" id="delete" align="center">
        <h4>User deleted successfully</h4>
    </div>
	<div class="col-md-12">
		<?php Yii::app()->session['controllerName'] = Yii::app()->controller->id; ?>
        <?php if(!empty($alldata)){ ?>
        <div class="pull-right m-b-10">
			<?php echo CHtml::link('Create', array('Telecom/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
		</div>
		<div style="margin-right:10px;" class="pull-right m-b-10">
			<a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
		</div>

		<div id="user-info-grid">
			<table id="telecom-info-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
				<thead class="custom-table-head">
				<tr>
					<?php $array_cols = Yii::app()->db->schema->getTable('telecom_user_details')->columns;
					foreach($array_cols as $key=>$col){ ?>
					<th class="custom-table-head">
                        <?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
					<?php } ?>
				</tr>
				</thead>
                <thead>
				<tr>
					<?php $arr = array_values($array_cols);
					foreach($arr as $key=>$col){
						switch($col->name)
						{
							case 'first_name':
								echo "<td></td>";
								echo "<td><input type='text' data-column='2' class='text-box' style='width:100%'></td>";
								break;
                            case 'last_name':
                                echo "<td><input type='text' data-column='4' class='text-box' style='width:100%'></td>";
                                break;
                            case 'email':
								echo "<td><input type='text' data-column='5' class='text-box' style='width:100%'></td>";
								break;
                            case 'phone':
                                echo "<td><input type='text' data-column='9' class='text-box' style='width:100%'></td>";
                                break;
                            case 'landline_number':
                                echo "<td><input type='text' data-column='10' class='text-box' style='width:100%'></td>";
                                break;
                            case 'city':
								echo "<td><input type='text' data-column='18' class='text-box' style='width:100%'></td>";
								break;
                            case 'country':
								$codesql = "select country_code,country_name from countries";
								$country = Yii::app()->db->createCommand($codesql)->queryAll(); ?>
                                <td>
                                    <select class='drop-box' data-column='20' style='width:100%'>
                                        <option value="">Select</option>
                                        <?php foreach($country as $key=>$value){ ?>
                                            <option value='<?php echo $value['country_code']; ?>'><?php echo $value['country_name']; ?></option>
                                        <?php } ?>
								    </select>
								</td>
					        <?php
								break;
							default :
								break;
						}
					} ?>
				</tr>
				</thead>
			</table>
		</div>
        <?php }  else { ?>
        <div class="row">
            <div align="center">
                <img src="<?php echo Yii::app()->baseUrl."/images/misc/order.png"; ?>" height="20%" width="10%"><br /><br />
                <h2>No User</h2>
                <p></p>
                <div class="row">
                    <?php echo CHtml::link('Create', array('telecom/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
                </div>
                <br />
            </div>
        </div>
        <?php } ?>
	</div>
</div>

<!--begin can not delete user Modal -->
<div class="modal fade" id="nodelete" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Not allowed..</b>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h5>
            </div>
            <div class="modal-body">
                <p>This is the main admin of the application so you can not delete this user.</p>
                <p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End can not delete user Modal-->

<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>

<script>
	$(document).ready(function() {

	    var countData = "<?= count($alldata); ?>";
	    if(countData == 0){
            $('.overlay').addClass("overlayhide");
            $("#mydatatable").removeClass("hide");
            //$(".overlay").removeClass("overlayhide");
        }

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
		var datatable = $('#telecom-info-table').DataTable({
			"order" : [[1,"ASC"]],
			"pageLength":20,
			"lengthMenu": [[20,50,100,200], [20,50,100,200]],
			"bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
			"processing": true,
			"serverSide": true,
			"buttons": [
				{
					extend: 'copyHtml5',
					title: 'Users Data export '+currentDate
				},
				{
					extend: 'excelHtml5',
					title: 'Users Data export '+currentDate
				},
				{
					extend: 'csvHtml5',
					title: 'Users Data export '+currentDate
				},
				{
					extend: 'pdfHtml5',
					title: 'Users Data export '+currentDate
				},
				{
					extend: 'print',
					title: 'Users Data export '+currentDate
				}
			],
			"ajax": {
				"type" : "POST",
				"url" : "serverdata",
				"dataSrc": function ( json ) {
					$('.overlay').addClass("overlayhide");
					$("#mydatatable").removeClass("hide");
					return json.data;
				}
			},
			"columnDefs": [ {
				"targets": 0,
				"data": null,
				"render" : function(data, type, row) {
					return '<a href="<?php echo Yii::app()->createUrl("admin/telecom/view/").'/'; ?>'+data[0]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/telecom/update/").'/'; ?>'+data[0]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a id='+data[0]+' class="userdelete" href="javascript:void(0)"><i class="fa fa-times"></i></a>&nbsp;&nbsp;';
				}
			},{
				"visible":false,
				"targets":[1,3,6,7,8,11,12,13,14,15,16,17,19,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53]
            } ]
		});

		$('.text-box').on( 'keyup', function () {   // for text boxes
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

        $('#telecom-info-table').on('click','.userdelete',function(){
            var id = $(this).attr('id');
            if(id == 1){
                $('#nodelete').modal('show');
                return false;
            }
        });

        $(' body ').on('click','.userdelete',function() {
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure you want to delete this user?", function(result){
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
