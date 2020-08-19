<?php
/* @var $this TicketingController */
/* @var $model Ticketing */

$primary_key = Ticketing::model()->tableSchema->primaryKey;

$this->pageTitle = 'Ticketing';
?>
<?php $tableName = Ticketing::model()->tableSchema->name; ?>
<?php
$settingsql = "SELECT * from settings where module_name = 'jira'";
$result = Yii::app()->db->createCommand($settingsql)->queryAll();
if(empty($result)){
    $class = "stopjira";
}
else{
    $class = "";
}
?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">

<div class="alert alert-success" role="alert" id="newstopjira">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="alert-heading text-center">Please enter jira credentials in settings..</h4>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success hide" role="alert" id="myHideEffect">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="alert-heading text-center">Your crud "Ticketing" is generated successfully.</h4>
        </div>
        <?php Yii::app()->session['controllerName'] = Yii::app()->controller->id; ?>

        <?php
        $sql = "SELECT * FROM ticketing";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($result)){ ?>
            <div class="pull-right m-b-10">
                <?php echo CHtml::link('Create', array($tableName.'/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>
            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>
            <?php /*if($class == ""){ */?><!--
            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a data-toggle="modal" data-target="#stopjira" class="btn btn-primary">Jira Credentials</a>
            </div>
            --><?php /*} */?>

            <div id="<?php echo $tableName; ?>-grid">
                <table id="<?php echo $tableName; ?>-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                    <thead class="custom-table-head">
                    <tr>
                        <th class="custom-table-head">Action</th>
                        <?php
                        $array_cols = Yii::app()->db->schema->getTable($tableName)->columns;
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
                        foreach($arr as $key=>$col){
                            switch($col->name)
                            {

                                case 'ticket_id':
                                    echo "<td></td>";
                                    echo "<td><input type='text' data-column='0' class='text-box' style='width:100%'></td>";
                                    break;

                                case 'user_id':
                                    echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
                                    break;

                                case 'title':
                                    echo "<td><input type='text' data-column='2' class='text-box' style='width:100%'></td>";
                                    break;

                                case 'ticket_detail':
                                    echo "<td><input type='text' data-column='3' class='text-box' style='width:100%'></td>";
                                    break;

                                /*case 'description':
                                    echo "<td><input type='text' data-column='4' class='text-box' style='width:100%'></td>";
                                    break;*/

                                case 'status':
                                    echo "<td><select class='drop-box' data-column='5' style='width:100%'>
                                            <option value=''>select</option>
                                            <option value='inprogress'>In Progress</option>
                                            <option value='done'>Done</option>
                                        </select></td>";
                                    break;

                                /*case 'created_at':
                                    echo "<td><input type='date' data-column='7' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
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
        <?php } else { ?>
            <div class="row">
                <div align="center">
                    <img src="<?php echo Yii::app()->baseUrl."/plugins/img/calendar.png"; ?>" height="20%" width="10%"><br /><br />
                    <h2>No Tickets</h2>
                    <p></p>
                    <div class="row">
                        <?php echo CHtml::link('Create', array($tableName.'/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
                    </div>
                    <br />
                </div>
            </div>
        <?php } ?>


    </div>
</div>

<!--uninstall confirmation modal for deleting ticket-->
<div class="modal fade" id="removeticket" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel"><b>Confirmation</b></h5>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>-->
            </div>
            <div class="modal-body">
                <span>Are you sure you want to delete this ticket and its comments?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                <a id="remove" class="btn btn-danger" href="">Delete</a>
            </div>
        </div>
    </div>
</div>



<!--stopjira module when credentials are not given..-->
<div class="modal fade" id="stopjira" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel"><b>Enter Credentials</b></h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo Yii::app()->createUrl('/admin/ticketing/savecredentials') ?>" id="stopjiraform">
                    <input type="text" name="update" value="<?php if(isset($update)){ echo $update; } ?>" hidden>
                    <div class="form-group">
                        <label class="control-label">Create jira issue url*</label>
                        <div>
                            <input type="text" class="form-control" name="createissueurl" id="createissueurl" value="<?php if(isset($url)){ echo $url; } ?>">
                            <span class="help-block hide" id="urlerror">Please enter url.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Username*</label>
                        <div>
                            <input type="text" class="form-control" name="username" id="username" value="<?php if(isset($username)){ echo $username; } ?>">
                            <span class="help-block hide" id="usernameerror">Please enter username.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Password*</label>
                        <div>
                            <input type="password" class="form-control" name="password" id="password"  value="<?php if(isset($password)){ echo $password; } ?>">
                            <span class="help-block hide" id="passworderror">Please enter password.</span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                        <button type="submit" id="stopjirasubmit" class="btn btn-primary">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!--Form for creating issue in jira-->
<div class="modal fade bd-example-modal-lg" id="createjiraissue" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/ckeditor.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/config.js', CClientScript::POS_HEAD);
?>

<!--datepicker js-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/js/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<script>
    $(document).ready(function() {
        $('#newstopjira').hide();

        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var currentDate = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;
        var datatable = $('#<?php echo $tableName; ?>-table').DataTable({
            "fnDrawCallback":function(){
                if($('#ticketing-table td').hasClass('dataTables_empty')){
                    $('div.dataTables_paginate').hide();
                    $('div#ticketing-table_info').hide();
                } else {
                    $('div#ticketing-table_info').show();
                    $('div.dataTables_paginate').show();
                }
            },
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
                    title: 'Titcketing data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Titcketing data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Titcketing data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Titcketing data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Titcketing data export '+currentDate
                }
            ],
            "serverSide": true,
            "ajax": {
                "type" : "GET",
                "url" : "serverdata",
                "dataSrc": function ( json ) {
                    return json.data;
                }
            },

            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "render" : function(data, type, row) {
                    return '<a data-toggle="tooltip" title="View" href="<?php echo Yii::app()->createUrl("admin/".$tableName."/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" title="Edit" href="<?php echo Yii::app()->createUrl("admin/".$tableName."/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" title="Delete" class="deleteticket" href="<?php echo Yii::app()->createUrl("admin/".$tableName."/remove/").'/'; ?>'+data[1]+'"><i class="fa fa-times"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/" . $tableName . "/forum/") . '/'; ?>'+data[1]+'" ><i class="fa fa-comments"></i></a>&nbsp;&nbsp;<a data-toggle="modal" data-target="#createjiraissue" class="<?php echo $class; ?>" title="Create issue in jira" href="<?php echo Yii::app()->createUrl("admin/" . $tableName . "/createissue/") . '/'; ?>'+data[1]+'"><i class="fa fa-bolt"></i></a>';
                }
            },{
                "visible":false,
                "targets":[5,7,9,10]
            } ],
        });

        $('.text-box').on( 'keyup', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            var v =$(this).val();  // getting search input value
            datatable.columns(i).search(v).draw();
        });

        $('.date-field').on('change', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            console.info(i);
            var v =$(this).val();  // getting search input value
            datatable.columns(i).search(v).draw();
        });

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

        $('#<?php echo $tableName; ?>-table').on('click', '.deleteticket', function(){
            var url = $(this).attr('href');
            $('#removeticket').modal('show');
            $('#remove').attr('href',url);
            return false;
        });

        $('#<?php echo $tableName; ?>-table').on('click', '.stopjira', function(){
            var classname = $(this).attr('class');
            if(classname == 'stopjira'){
                $('#newstopjira').show().fadeOut(5500);
                return false;
            }
        });
    });
</script>