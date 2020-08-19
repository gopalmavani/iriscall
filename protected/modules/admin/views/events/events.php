<link href="<?php echo Yii::app()->createUrl('../'); ?>/plugins/css/select2.min.css" rel="stylesheet"
      xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"/>


<?php
/* @var $this BookingController */
/* @var $model Booking */

$primary_key = Events::model()->tableSchema->primaryKey;

$this->pageTitle = 'Events';

$tableName = Events::model()->tableSchema->name;
?>

<div class="row">
    <div class="col-md-12">
        <?php Yii::app()->session['controllerName'] = Yii::app()->controller->id; ?>
        <?php
        $sql = "SELECT * FROM $tableName";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($result)){ ?>
        <!-- Block Tabs Animated Slide Left -->
        <div class="block">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#">All</a>
                </li>
                <li>
                    <a href="<?php echo Yii::app()->createUrl('/admin/events/calendarview'); ?>">Calendar</a>
                </li>
            </ul>
        </div>
        <!-- END Block Tabs Animated Slide Left -->

        <div class="pull-right m-b-10">
            <?php echo CHtml::link('Create', array($tableName.'/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
        <div style="margin-right:10px;" class="pull-right m-b-10">
            <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
        </div>

        <?php  if(!empty($hosts) && Yii::app()->user->role == "admin") { ?>
            <div class="pull-right m-b-10" style="margin-right:10px;">
                <label class="control-label" style="font-size:16px;">Event host</label>
                <select class="dropbox" id="host" data-column="5">
                    <option value="">all</option>
                    <?php foreach ($hosts as $key=>$value) {
                        if($value['full_name'] != ""){ ?>
                            <option value="<?php echo $value['event_host']; ?>"><?php echo $value['full_name']; ?></option>
                        <?php }
                    } ?>
                </select>
            </div>
        <?php } ?>

        <!--Begin data table-->
        <div id="user-info-grid">
            <table id="<?php echo $tableName; ?>-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <th class="custom-table-head">Action</th>
                    <?php
                    $array_cols = Yii::app()->db->schema->getTable($tableName)->columns;
                    foreach($array_cols as $key=>$col){
                        ?>
                        <th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
                        <?php
                    }
                    ?>
                </tr>
                </thead>
                <thead>
                <tr>
                    <?php
                    $arr = array_values($array_cols);
                    echo "<td></td>";
                    foreach($arr as $key=>$col) {
                        switch($col->name){
                            case "event_title":
                            case "event_location":
                            case "price":
                                echo "<td><input type='text' data-column=" .$key. " class='text-box' style='width:100%'></td>";
                                break;

                            case "event_start":
                                ?>
                                <td>
                                    <p class="date_filter">
                                        <span class="date-range-span"><input class="date_range_filter" type="text" id="event_start_min" data-column="<?= $key ?>" placeholder="From" style="width:100%" /></span>
                                        <br/><span class="date-range-span"><input class="date_range_filter" type="text" id="event_start_max" data-column="<?= $key ?>" placeholder="To" style="width:100%" /></span>
                                    </p>
                                </td>
                                <?php
                                break;

                            case "event_end":
                                ?>
                                <td>
                                    <p class="date_filter">
                                        <span class="date-range-span"><input  class="date_range_filter" type="text" id="event_end_min" data-column="<?= $key ?>" placeholder="From" style="width:100%" /></span>
                                        <br/><span class="date-range-span"><input class="date_range_filter" type="text" id="event_end_max" data-column="<?= $key ?>" placeholder="To" style="width:100%" /></span>
                                    </p>
                                </td>
                                <?php
                                break;
                        }
                    }
                    ?>
                </tr>
                </thead>
            </table>
        </div>
        <!--End data table-->
    </div>
</div>
<?php } else { ?>
    <div class="row">
        <div class="col-md-12" align="center">
            <img src="<?php echo Yii::app()->baseUrl."/plugins/img/calendar.png"; ?>" height="20%" width="10%"><br /><br />
            <h2>No events</h2>
            <p></p>
            <div class="row">
                <?php
                if(ServiceProvider::model()->findByAttributes(['id' => '1']) == null){ ?>
                    <span>You can only create event after creating service provider to create service provider <a href="<?php echo Yii::app()->createUrl("/admin/events/serviceProvider"); ?>">Click here.</a></span>
                <?php }else{
                    echo CHtml::link('Create', array($tableName.'/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px'));
                } ?>
            </div>
            <br />
        </div>
    </div>
<?php } ?>

<script src="<?php echo Yii::app()->createUrl('../'); ?>/plugins/bootstrap-datetimepicker/moment.min.js"></script>
<script src="<?php echo Yii::app()->createUrl('../'); ?>/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>
<script src="<?php echo Yii::app()->createUrl('../'); ?>/plugins/js/select2.min.js"></script>
<script src="<?php echo Yii::app()->createUrl('../'); ?>/plugins/js/core/jquery.slimscroll.min.js"></script>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function() {
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var currentDate = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;

        var datatable = $('#<?php echo $tableName; ?>-table').DataTable({
            "fnDrawCallback":function(){
                if($('#<?php echo $tableName; ?>-table td').hasClass('dataTables_empty')){
                    $('div.dataTables_paginate').hide();
                    $('div#<?php echo $tableName; ?>-table_info').hide();
                } else {
                    $('div#<?php echo $tableName; ?>-table_info').show();
                    $('div.dataTables_paginate').show();
                }
            },
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            "scrollX" : true,
            "sScrollX": "100%",
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
            "processing": true,
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'Booking Data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Booking Data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Booking Data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Booking Data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Booking Data export '+currentDate
                }
            ],
            "serverSide": true,
            "ajax": {
                "type" : "GET",
                "url" : "serverdata",
                "data": function ( d ) {
                    d.host = $('#host').val();
                    d.event_start_min = $('#event_start_min').val();
                    d.event_start_max = $('#event_start_max').val();
                    d.event_end_min = $('#event_end_min').val();
                    d.event_end_max = $('#event_end_max').val();
                    // etc
                },
                "dataSrc": function ( json ) {
                    return json.data;
                }
            },
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "render" : function(data, type, row) {
                    return '<a href="<?php echo Yii::app()->createUrl("admin/".$tableName."/eventview/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/".$tableName."/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="javascript:void(0);" class="delete-FbFeed" id="'+data[1]+'"><i class="fa fa-times"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl('/admin/Events/booking')."/"?>'+data[1]+'"><i class="fa fa-book"></i></a>';
                },
            },{
                "visible":false,
                "targets":[1,3,4,5,6,11,12,13,14,15,16,17,18,19,20,21,22]
            } ]
        });

        $('.text-box').on( 'keyup', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
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

        $(".date_range_filter").datepicker({
            format : "yyyy-mm-dd",
            autoclose : true
        });

        $('#host').change(function () {
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

        $('#event_start_min').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

        $('#event_start_max').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

        $('#event_end_min').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

        $('#event_end_max').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

    });
    $(document).ready(function(){
        if (localStorage.getItem('crudCreateMsg') == 1){
            $("#crudCreateId").removeClass('hide');
            setTimeout(function(){
                $("#crudCreateId").fadeOut(4000);
            }, 3000);
            localStorage.crudCreateMsg = 0;
        }

        $(' body ').on('click','.delete-FbFeed',function() {
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure you want to delete this event?", function(result){
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
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/fullcalendar/moment.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/fullcalendar/fullcalendar.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/fullcalendar/gcal.min.js', CClientScript::POS_END);
?>