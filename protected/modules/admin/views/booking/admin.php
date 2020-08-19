<?php
/* @var $this BookingController */
/* @var $model Booking */

$primary_key = Booking::model()->tableSchema->primaryKey;

$this->pageTitle = 'Booking';
?>
<?php $tableName = Booking::model()->tableSchema->name;
?>
<div class="row">
    <div class="col-md-12">
        <?php
        $sql = "SELECT * FROM $tableName";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($result)){?>
            <!-- Block Tabs Animated Slide Left -->
            <div class="block">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#">All</a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/admin/booking/calendarview'); ?>">Calendar</a>
                    </li>
                </ul>
            </div>
            <!-- END Block Tabs Animated Slide Left -->

            <?php Yii::app()->session['controllerName'] = Yii::app()->controller->id; ?>

            <?php Yii::app()->session['controllerName'] = Yii::app()->controller->id; ?>
            <?php /*echo CHtml::link('Edit Crud', array('Builder/editCrud/'.$TableID->table_id), array('class' => 'btn btn-primary')); */?>

            <div class="pull-right m-b-10">
                <?php /*echo CHtml::link('Create', array($tableName.'/create'), array('class' => 'btn btn-minw btn-square btn-primary')); */?>
            </div>
            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>

            <?php  if(!empty($hosts) && Yii::app()->user->role == "admin") { ?>
                <div class="pull-right" style="margin-right:10px;">
                    <label class="control-label" style="font-size:16px;">Event host</label>
                    <select id="host" data-column="0">
                        <option value="">all</option>
                        <?php foreach ($hosts as $key=>$value) {
                            if($value['full_name'] != ""){?>
                                <option value="<?php echo $value['event_host']; ?>"><?php echo $value['full_name']; ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            <?php } ?>

            <div id="<?php echo $tableName; ?>-grid">
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
                            if($col->name != "booking_id" && $col->name != "user_id" && $col->name != "created_at" && $col->name != "modified_at")
                                echo "<td><input type='text' data-column=" .$key. " class='text-box' style='width:100%'></td>";
                        }
                        ?>
                    </tr>
                    </thead>
                </table>
            </div>
        <?php } else { ?>
            <div class="row">
                <div align="center">
                    <img src="<?php echo Yii::app()->baseUrl."/plugins/img/calendar.png"; ?>" height="20%" width="10%"><br /><br />
                    <h2>No bookings yet</h2>
                    <p></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
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
            "processing": true,
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
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
                },
                "dataSrc": function ( json ) {
                    return json.data;
                }
            },
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "render" : function(data, type, row) {
                    return '<a href="<?php echo Yii::app()->createUrl("admin/".$tableName."/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/".$tableName."/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="javascript:void(0);" class="delete-FbFeed" id="'+data[1]+'"><i class="fa fa-times"></i></a>';
                }
            },{
                "visible":false,
                "targets":[1,7,10,11]
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

        $('#host').change(function(){
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
    });

    $(' body ').on('click','.delete-FbFeed',function() {
        var id = $(this).attr('id');
        bootbox.confirm("Are you sure you want to delete this booking?", function(result){
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
</script>