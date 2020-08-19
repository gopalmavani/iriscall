<?php
/* @var $this PoolPlanController */
/* @var $model PoolPlan */

$this->pageTitle = 'Role Management';
?>
<?php $tableName = Roles::model()->tableSchema->name; ?>
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
        <h4>Role deleted successfully</h4>
    </div>
    <div class="col-md-12 tdasdf">
        <?php Yii::app()->session['controllerName'] = Yii::app()->controller->id; ?>
        <?php
        $sql = "SELECT * FROM roles";
        $result = Yii::app()->db->CreateCommand($sql)->queryAll();
        if(!empty($result)){ ?>
            <?php echo CHtml::link('Edit Crud', array('Builder/editCrud/'.$TableID->table_id), array('class' => 'btn btn-primary')); ?>
            <div class="pull-right m-b-10">
                <?php echo CHtml::link('Create', array('Roles/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>
            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>
            <div id="pool-plan-grid">
                <table id="pool-plan-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                    <thead class="custom-table-head">
                    <tr>
                        <th class="custom-table-head">Action</th>
                        <?php
                        $array_cols = Yii::app()->db->schema->getTable('roles')->columns;
                        foreach($array_cols as $key=>$col){
                            ?>
                            <th class="custom-table-head"><?php echo ucfirst(str_replace("_"," ",$col->name)); ?></th>
                            <?php
                        }
                        ?>
                    </tr>
                    </thead>

                    <thead>
                    <tr>
                        <?php
                        $arr = array_values($array_cols);
                        /*echo "<pre>";
                        print_r($arr);die;*/
                        foreach($arr as $key=>$col){
                            switch($col->name)
                            {
                                case 'role_id':
                                    echo "<td></td>";
                                    echo "<td><input type='text' data-column='0' class='text-box' style='width:100%'></td>";
                                    break;

                                case 'role_title':
                                    echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
                                    break;

                                /*case 'created_at':
                                    echo "<td><input type='date' data-column='2' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
                                    break;

                                case 'modified_at':
                                    echo "<td><input type='date' data-column='2' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
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
        <?php } else {?>
            <div class="row">
                <div align="center">
                    <img src="<?php echo Yii::app()->baseUrl."/plugins/img/calendar.png"; ?>" height="20%" width="10%"><br /><br />
                    <h2>No roles</h2>
                    <p></p>
                    <div class="row">
                        <?php echo CHtml::link('Create', array('Roles/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
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
                <p>This is the main role of the application so you can not delete this role.</p>
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
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var currentDate = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;

        if (localStorage.getItem('msg')){
            $("#delete").removeClass("hide");
            setTimeout(
                function(){
                    $("#delete").addClass("hide");
                },5000
            )
            localStorage.removeItem('msg');
        }

        var datatable = $('#pool-plan-table').DataTable({
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            "scrollX" : true,
            "sScrollX": "100%",
            "processing": true,
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'Roles data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Roles data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Roles data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Roles data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Roles data export '+currentDate
                }
            ],
            "serverSide": true,
            "ajax": {
                "type" : "GET",
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
                    return '<a href="<?php echo Yii::app()->createUrl("admin/Roles/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/Roles/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a id='+data[1]+' class="roledelete" href="javascript:void(0)"><i class="fa fa-times"></i></a>';
                }
                //"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
            },{
                "visible":false,
                "targets":[3,4]
            } ]

        });

        $('.text-box').on('keyup', function () {   // for text boxes
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

        $('#pool-plan-table').on('click','.roledelete',function(){
            var id = $(this).attr('id');
            if(id == 1 || id ==2){
                $('#nodelete').modal('show');
                return false;
            }
        });

        $(' body ').on('click','.roledelete',function() {
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure you want to delete this role?", function(result){
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

