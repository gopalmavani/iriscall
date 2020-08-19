<?php
/* @var $this Mt4Controller */
/* @var $model CbmAccounts */

$this->pageTitle = 'CBM User Accounts';
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
        if(!empty($userAccounts)){
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

                    <?php
                    $array_cols = Yii::app()->db->schema->getTable($tableName)->columns;

                    foreach($array_cols as $key=>$col){ ?>
                        <?php if($col->name != 'matrix_id') { ?>
                            <th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
                        <?php } else { ?>
                            <th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ','matrix_name')); ?></th>
                        <?php } ?>

                    <?php } ?>
                </tr>
                </thead>
                <thead>
                <tr>
                    <?php
                    $arr = array_values($array_cols);
                    foreach($arr as $key=>$col) {
                        switch($col->name){
                            case 'user_account_num':
                                echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
                                break;

                             case 'login':
                                 echo "<td><input type='text' data-column='2' class='text-box' style='width:100%'></td>";
                                 break;

                            case 'email_address':
                                echo "<td><input type='text' data-column='4' class='text-box' style='width:100%'></td>";
                                break;

                             case 'type':
                                 echo "<td><select class='drop-box' data-column='3' style='width:100%'>
                                        <option value=''>select</option>
                                        <option value='Self Funded'>Self Funded</option>
                                        <option value='Profit Funded'>Profit Funded</option>
                                    </select></td>";
                                 break;

                             case 'balance':
                                 echo "<td><input type='text' data-column='7' class='text-box' style='width:100%'></td>";
                                 break;

                            case 'equity':
                                echo "<td><input type='text' data-column='8' class='text-box' style='width:100%'></td>";
                                break;

                            case 'matrix_node_num':
                                echo "<td><input type='text' data-column='11' class='text-box' style='width:100%'></td>";
                                break;

                            case 'matrix_id':
//                                echo "<td><input type='text' data-column='12' class='text-box' style='width:100%'></td>";
//                                break;
                                echo "<td><select class='drop-box' data-column='12' style='width:100%'>
                                        <option value=''>select</option>
                                        <option value='1'>MMC Matrix</option>
                                    </select></td>";
                                break;

                            case 'user_ownership':
                                echo "<td><input type='text' data-column='13' class='text-box' style='width:100%'></td>";
                                break;

                            default :
                                break;
                        }
                    }
                    ?>
                    <!--<td>
                        <select class='drop-box' data-column='12' style='width:100%'>
                            <option value=''>select</option>
                            <option value='ten_euro_matrix'><?/*= ucfirst(str_replace('_',' ','ten_euro_matrix'));*/?></option>
                            <option value='fifty_euro_matrix'><?/*= ucfirst(str_replace('_',' ','fifty_euro_matrix'));*/?></option>
                        </select>
                    </td>-->
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
        var serverDataURL = '<?= Yii::app()->createUrl('admin/Cbmuseraccount/serverData'); ?>';

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
            //"scrollX" : true,
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
                "url" : serverDataURL,
                "dataSrc": function ( json ) {
                    $('.overlay').addClass("overlayhide");
                    $("#mydatatable").removeClass("hide");
                    return json.data;
                }
            },
            "columnDefs": [
                {
                    "visible":false,
                    "targets":[0,5,6,9,10,14,15,16]
                }
            ]
        });

        $('.text-box').on( 'keyup', function () {   // for text boxes
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