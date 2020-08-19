<?php
/* @var $this Mt4Controller */
/* @var $model CbmDepositWithdraw */

$primary_key = CbmDepositWithdraw::model()->tableSchema->primaryKey;

$this->pageTitle = 'View Deposit';
?>

<style>
    #api_deposit_withdraw-grid{
        width: 100%;
        overflow-x: auto;
        white-space: nowrap;
    }
</style>
<?php $tableName = CbmDepositWithdraw::model()->tableSchema->name;
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
        <?php Yii::app()->session['controllerName'] = Yii::app()->controller->id; ?>
        <?php
        $sql = "SELECT * FROM $tableName";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($result)){
            ?>
            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>
            <?php
        }
        ?>

        <div id="<?php echo $tableName; ?>-grid">
            <table id="<?php echo $tableName; ?>-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <!-- <th class="custom-table-head">Action</th> -->
                    <?php
                    $array_cols = Yii::app()->db->schema->getTable($tableName)->columns;
                    foreach($array_cols as $key=>$col){
                        if($col->name == 'id'){ ?>
                            <th class="custom-table-head">Action</th>
                        <?php }else{ ?>
                            <th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th> 
                        <?php } ?>
                    <?php } ?>
                   <!--  <th class="custom-table-head">Login</th>
                    <th class="custom-table-head">Ticket</th>
                    <th></th>
                    <th class="custom-table-head">Email</th>
                    <th class="custom-table-head">Type</th>
                    <th class="custom-table-head">Close Time</th>
                    <th class="custom-table-head">Profit</th>
                    <th class="custom-table-head">Comment</th>
                    <th class="custom-table-head">Is Accounted For</th> -->
                </tr>
                </thead>
                <thead>
                <tr>
                    <?php
                    $arr = array_values($array_cols);
                    echo "<td></td>";
                    foreach($arr as $key=>$col) {
                       
                       // echo "<td><input type='text' data-column=".$key." class='text-box' style='width:100%'></td>";
                        switch($col->name) {
                            case 'login':
                                echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
                                break;

                            case 'ticket':
                                echo "<td><input type='text' data-column='2' class='text-box' style='width:100%'></td>";
                                break;

                            case 'email':
                                echo "<td><input type='text' data-column='4' class='text-box' style='width:100%'></td>";
                                break;

                            case 'type':
                                //echo "<td><input type='text' data-column='7' class='text-box' style='width:100%'></td>";
                                echo "<td><select class='drop-box' data-column='7' style='width:100%'>
                                        <option value=''>Select</option>
                                        <option value='deposit'>Deposit</option>
                                        <option value='withdraw'>Withdraw</option>
                                    </select></td>";
                                break;

                            case 'close_time':
                                ?>
                                <td>
                                    <input class="date_range_filter" type="text" id="starts_at_min" data-column="11" style='width:100%' placeholder="From"/><br/>
                                    <input class="date_range_filter" type="text" id="starts_at_max" data-column="11" style='width:100%' placeholder="To"/>
                                </td>
                                <?php
                                break;

                            case 'profit':
                                echo "<td><input type='text' data-column='12' class='text-box' style='width:100%'></td>";
                                break;

                            case 'comment':
                                echo "<td><input type='text' data-column='15' class='text-box' style='width:100%'></td>";
                                break;
                            case 'is_accounted_for':
                                echo "<td><select class='drop-box' data-column='23' style='width:100%'>
                                        <option value=''>select</option>
                                        <option value='0'>UnProccessed</option>
                                        <option value='1'>Proccessed</option>
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
        <div class="row"><br/></div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/bootstrap-datepicker/bootstrap-datepicker.js', CClientScript::POS_END);
?>
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
            "order": [[ 11, "desc" ]],
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            //"scrollX" : true,
            //"sScrollX": "100%",
             "colReorder": true,
            "processing": true,
            "bFilter": true,
            "searching": true,
            "dom":'l,B,t,i,p',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'CbmDepositWithdraw Data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'CbmDepositWithdraw Data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'CbmDepositWithdraw Data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'CbmDepositWithdraw Data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'CbmDepositWithdraw Data export '+currentDate
                }
            ],
            "serverSide": true,
            "ajax": {
                "type" : "GET",
                "url" : "datatable",
                "data": function ( d ) {
                    d.myKey = "myValue";
                    d.min = $('#starts_at_min').val();
                    d.max = $('#starts_at_max').val();
                // etc
                },
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
                    return '<a href="<?php echo Yii::app()->createUrl("admin/mt4/depositWithdrawView/").'/'; ?>'+data[0]+'"><i class="fa fa-eye"></i></a>';
                }
            },{
                "visible":false,
                // "targets":[1,4,6,7,9,10,11,14,15,17,18,19,20,21,22,23]
                "targets":[3,6,7,8,9,10,13,14,16,17,18,19,20,21,22]
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
</script>