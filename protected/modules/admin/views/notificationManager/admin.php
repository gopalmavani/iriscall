<?php
/* @var $this NotificationManagerController */
/* @var $model NotificationManager */

$this->pageTitle = 'NotificationManager';
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/core/jquery.min.js', CClientScript::POS_HEAD);
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
	<style>
        .dt-buttons{
            float: left !important;
        }
		thead tr th:first-child,
		tbody tr td:first-child {
			width: 7.5em;
			min-width: 7.5em;
			max-width: 7.5em;
			word-break: break-all;
		}
	</style>
<div class="row">
    <div class="alert alert-success hide" id="delete" align="center">
        <h4>Category deleted successfully</h4>
    </div>
    <div class="alert alert-danger hide" id="cate-delete" align="center">
        <h4>This category can not be delete</h4>
    </div>
    <div class="col-md-12">
        <div class="pull-right m-b-10">
            <?php echo CHtml::link('Create', array('NotificationManager/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
</div>
    <?php echo Yii::app()->user->getFlash('deleteError'); ?>
    <div class="error-msg">
    <?php if(Yii::app()->user->hasFlash('deleteError')){
            echo Yii::app()->user->getFlash('deleteError');
                Yii::app()->user->setFlash('deleteError', null);
            }?>
    <?php foreach(Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }?>
    </div>

    <div id="NotificationManager-grid">
        <table id="NotificationManager-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
            <thead class="custom-table-head">
            <tr>
                <th class="custom-table-head">Action</th>
                <?php $array_cols = Yii::app()->db->schema->getTable('notification_manager')->columns;
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
                                        <option value=''>select</option>
                                        <option value='1'>Yes</option>
                                        <option value='0'>No</option>
                                    </select></td>";
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
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/core/jquery.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/datatables/jquery.dataTables.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/pages/base_tables_datatables.js', CClientScript::POS_HEAD);
?>
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
        if (localStorage.getItem('error')){
            $("#cate-delete").removeClass("hide");
            setTimeout(
                function(){
                    $("#cate-delete").addClass("hide");
                },5000
            );
            localStorage.removeItem('error');
        }

        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var currentDate = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;
        var datatable = $('#NotificationManager-table').DataTable({
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            "scrollX" : true,
            "sScrollX": "100%",
            "processing": true,
            "dom": 'lBfrtip',
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
                    return json.data;
                }
            },
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "render" : function(data, type, row) {
                    return '<a href="<?php echo Yii::app()->createUrl("admin/NotificationManager/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/NotificationManager/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)"><i class="fa fa-times delete-category" id="'+data[1]+'"></i></a>';
                }
                //"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
            },{
                "visible":false,
                "targets":[]
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
                        url: "Delete/"+id,
                        type: "POST",
                        beforeSend: function () {
                            $(".overlay").removeClass("hide");
                        },
                        success: function (response) {
                            var Result = JSON.parse(response);
                            if (Result.token == 1){
                                localStorage.setItem('msg','success');
                                window.location.reload();
                            }
                            if (Result.token == 2){
                                localStorage.setItem('error','unsuccess');
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
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/bootbox.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>