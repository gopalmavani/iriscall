<?php
/* @var $this RankController */
/* @var $model Rank */
$this->pageTitle = 'Ranks';
?>
<?php
$sql = "SELECT * FROM rank";
$result = Yii::app()->db->createCommand($sql)->queryAll();
if(!empty($result)){ ?>
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
            <h4>Rank deleted successfully</h4>
        </div>
        <div class="col-md-12">
            <div class="pull-right m-b-10">
                <?php echo CHtml::link('Create', array('rank/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>
            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>
            <div id="rank-grid">
                <table id="rank-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                    <thead class="custom-table-head">
                    <tr>
                        <th class="custom-table-head">Action</th>
                        <?php
                            $array_cols = Yii::app()->db->schema->getTable('rank')->columns;
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
                            foreach($arr as $key=>$col){
                                switch($col->name)
                                {
                                    case 'id':
                                        echo "<td></td>";
                                        echo "<td><input type='text' data-column='0' class='text-box' style='width:100%'></td>";
                                        break;
        
                                    case 'name':
                                        echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
                                        break;
        
                                    case 'description':
                                        echo "<td></td>";
                                        echo "<td><input type='text' data-column='3' class='text-box' style='width:100%'></td>";
                                        break;
        
                                    case 'abbreviation':
                                        echo "<td><input type='text' data-column='4' class='text-box' style='width:100%'></td>";
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
    <div class="row"><br/></div>
<?php } else { ?>
<div class="row">
    <div align="center">
        <img src="<?php echo Yii::app()->baseUrl."/plugins/img/product.png"; ?>" height="20%" width="10%"><br /><br />
        <h2>No rank</h2>
        <p></p>
        <div class="row">
            <?php echo CHtml::link('Create', array('rank/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
        </div>
        <br />
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">Compute Ranks</div>
        <input type="button" class="btn btn-primary" style="float: right;" name="computerank" id="rankCompute" value="Compute Ranks"/>
    </div>
    <div class="col-md-12">
        <div style="height: 150px;" id="computeResult"></div>
    </div>
</div>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script>
    $(document).ready(function() {
        //compute rank
        $('#rankCompute').click(function () {
            $.ajax({
                url: 'ComputeRank',
                type: "post",
                beforeSend: function(){
                    $(".overlay").removeClass("hide");
                },
                success: function (response) {
                    //console.log(response);
                    var Result = JSON.parse(response);
                    if (Result.users == 0){
                        $('#computeResult').html("Users not eligible for rank update");
                    }else{
                        $('#computeResult').html('Ranks Successfully Updated, ' + Result.users + " Users's rank updated");
                    }
                    $(".overlay").addClass("hide");
                }
            });
        });

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

        var datatable = $('#rank-table').DataTable({
            "fnDrawCallback":function(){
                if($('#rank-table td').hasClass('dataTables_empty')){
                    $('div.dataTables_paginate').hide();
                    $('div#rank-table').hide();
                } else {
                    $('div#rank-table').show();
                    $('div.dataTables_paginate').show();
                }
            },
            "order" : [[0,"ASC"]],
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            /*"scrollX" : true,
            "sScrollX": "100%",*/
            "processing": true,
            "bFilter": false,
            "searching": true,
            "dom":'l,B,f,t,i,p',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'Ranks Data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Ranks Data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Ranks Data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Ranks Data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Ranks Data export '+currentDate
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
                    return '<a href="<?php echo Yii::app()->createUrl("admin/rank/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/rank/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a id='+data[1]+' class="rankdelete" href="javascript:void(0)"><i class="fa fa-times"></i></a>';
                }
            },{
                "visible":false,
                "targets":[6,7]
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

        $(' body ').on('click','.rankdelete',function() {
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure you want to delete this rank?", function(result){
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