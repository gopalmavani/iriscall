<?php
/* @var $this Mt4Controller */
/* @var $model CbmAccounts */

$primary_key = CbmAccounts::model()->tableSchema->primaryKey;

$this->pageTitle = 'View MT4 Account';

$tableName = CbmAccounts::model()->tableSchema->name;?>

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
                    <th class="custom-table-head">Action</th>
                    <?php
                    $array_cols = Yii::app()->db->schema->getTable($tableName)->columns;
                    foreach($array_cols as $key=>$col){
                        ?>
                        <th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
                        <?php
                    }
                    ?>
                    <!--  <th class="custom-table-head">0</th>
                    <th class="custom-table-head">1</th>
                    <th class="custom-table-head">2</th>
                    <th class="custom-table-head">3</th>
                    <th class="custom-table-head">4</th>
                    <th class="custom-table-head">5</th>
                    <th class="custom-table-head">6</th>
                    <th class="custom-table-head">7</th>
                    <th class="custom-table-head">8</th>
                    <th class="custom-table-head">9</th>
                    <th class="custom-table-head">10</th>
                    <th class="custom-table-head">11</th>
                    <th class="custom-table-head">12</th>
                    <th class="custom-table-head">13</th>
                    <th class="custom-table-head">14</th>
                    <th class="custom-table-head">15</th>
                    <th class="custom-table-head">16</th>
                    <th class="custom-table-head">17</th>
                    <th class="custom-table-head">18</th>
                    <th class="custom-table-head">19</th>
                    <th class="custom-table-head">20</th>
                    <th class="custom-table-head">21</th>
                    <th class="custom-table-head">22</th> -->
                </tr>
                </thead>
                 <thead>
                <tr>
                <!-- <td></td> -->
                    <?php
                    $arr = array_values($array_cols);
                    echo "<td></td>";
                    foreach($arr as $key=>$col) {
                        switch($col->name){
                            case 'login':
                                echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
                                break;

                            case 'name':
                                echo "<td><input type='text' data-column='2' class='text-box' style='width:100%'></td>";
                                break;

                            case 'email_address':
                                echo "<td><input type='text' data-column='8' class='text-box' style='width:100%'></td>";
                                break;

                            case 'balance':
                                echo "<td><input type='text' data-column='4' class='text-box' style='width:100%'></td>";
                                break;

                            case 'equity':
                                echo "<td><input type='text' data-column='6' class='text-box' style='width:100%'></td>";
                                break;

                            case 'agent':
                                echo "<td><input type='text' data-column='10' class='text-box' style='width:100%'></td>";
                                break;

                            case 'registration_date':
                                // echo "<td><input type='text' data-column='12' class='text-box' style='width:100%'></td>";
                                ?>
                                <td>
                                    <input class="date_range_filter" type="text" id="starts_at_min" data-column="13" style='width:100%' placeholder="From"/><br/>
                                    <input class="date_range_filter" type="text" id="starts_at_max" data-column="13" style='width:100%' placeholder="To"/>
                                </td>
                                <?php
                                break;

                            default :
                                break;
                        }
                        //echo "<td><input type='text' data-column=" .$key. " class='text-box' style='width:100%'></td>";
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
            "order": [[ 13, "desc" ]],
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            // "scrollX" : true,
            //"sScrollX": "100%",
            "processing": true,
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'Api Data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Api Data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Api Data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Api Data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Api Data export '+currentDate
                }
            ],
            "serverSide": true,
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
                    $('.overlay').addClass("overlayhide");
                    $("#mydatatable").removeClass("hide");
                    return json.data;
                }
            },
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "render" : function(data, type, row) {
                    return '<a href="<?php echo Yii::app()->createUrl("admin/mt4/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>';
                }
            },{
                "visible":false,
                "targets":[3,5,7,9,11,12,14,15,16,17,18,19,20]
            } ]
        });

        $('.text-box').on( 'keyup', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            var v =$(this).val();  // getting search input value
            datatable.columns(i).search(v).draw();
        } );

        $(".date_range_filter").datepicker({
            format : "yyyy-mm-dd",
            autoclose : true
        });

        $('#starts_at_min, #starts_at_max').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

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
