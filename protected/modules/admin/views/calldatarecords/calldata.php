<?php
/* @var $this ProductInfoController */
/* @var $model ProductInfo */
$this->pageTitle = 'CDR';
?>

<!--Begin loader-->

<!--End loader-->
<?php
$sql = "SELECT * FROM cdr_info";
$result = Yii::app()->db->createCommand($sql)->queryAll();
if(!empty($result)){ ?>
    <div class="overlay" style="opacity:0.1 !important;position:unset !important;">
        <div class="loader">
            <p style="font-size: 18px;"><i class="fa fa-cog fa-spin" aria-hidden="true"></i> Loading...</p>
        </div>
    </div>

    <div class="row hide" id="mydatatable">
    <div class="col-md-12">
            <div class="pull-right m-b-10">
                <?php echo CHtml::link('Generate Invoice', array('calldatarecords/invoice'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                <?php echo CHtml::link('Fetch CDR', array('calldatarecords/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                <?php echo CHtml::link('Fetch From Number', array('calldatarecords/getfromnumber'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                <?php echo CHtml::link('Calculate Cost', array('calldatarecords/costcalculate'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>
            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>
            <div id="product-info-grid">
                <table id="product-info-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                    <thead class="custom-table-head">
                    <tr>
                        <th class="custom-table-head">Action</th>
                        <?php
                        $array_cols = Yii::app()->db->schema->getTable('cdr_info')->columns;
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
                        //echo "<pre>";print_r($arr);die;
                        foreach($arr as $key=>$col){
                            switch($col->name)
                            {
                                case 'from_name':
                                    echo "<td></td>";
                                    echo "<td><input type='text' data-column='10' class='text-box' style='width:100%;'></td>";
                                    break;

                                case 'to_number':
                                    echo "<td><input type='text' data-column='11' class='text-box' style='width:100%;'></td>";
                                    break;

                                /*case 'start_time':
                                    echo "<td><input type='date' data-column='4' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
                                    break;*/

                                case 'unit_cost':
                                    echo "<td><input type='text' data-column='14' class='text-box' style='width:100%;'></td>";
                                    break;

                                case 'total_time':
                                    echo "<td><input type='text' data-column='16' class='text-box' style='width:100%;'></td>";
                                    break;

                                case 'comment':
                                    echo "<td><input type='text' data-column='17' class='text-box' style='width:100%;'></td>";
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
<?php } else { ?>
    <div class="row">
        <div align="center">
            <h2>No Call data records</h2>
            <p></p>
            <div class="row">
                <?php echo CHtml::link('Fetch CDR', array('calldatarecords/index'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
            </div>
            <br />
        </div>
    </div>
<?php } ?>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script>
    $(document).ready(function() {

        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();

        var currentDate = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;

        var datatable = $('#product-info-table').DataTable({
            "fnDrawCallback":function(){
                /*if($('#product-info-table td').hasClass('dataTables_empty')){
                    $('div.dataTables_paginate').hide();
                    $('div#product-info-table_info').hide();
                } else {
                    $('div#product-info-table_info').show();
                    $('div.dataTables_paginate').show();
                }*/
            },
            //"order":[[11,"DESC"]],
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            /*"scrollX" : true,
            "sScrollX": "100%",*/
            "processing": true,
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'CDR Data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'CDR Data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'CDR Data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'CDR Data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'CDR Data export '+currentDate
                }
            ],
            "serverSide": true,
            "ajax": {
                "type" : "GET",
                "url" : "servercalldata",
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
                    return '<a href="<?php echo Yii::app()->createUrl('/admin/calldatarecords/view/').'/'; ?>'+data[1]+'"><i class="fa fa-eye" id="'+data[1]+'"></i></a>';
                }
            },{
                "visible":false,
                "targets":[1,2,3,4,5,6,7,8,9,10,13,15]
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
    });
</script>