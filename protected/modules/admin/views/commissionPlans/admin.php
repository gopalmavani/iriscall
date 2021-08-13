<?php
/* @var $this CommissionPlansController */
/* @var $model CommissionPlan */
$this->pageTitle = 'Commission Plan';
?>
<?php
$sql = "SELECT * FROM commission_plans";
$result = Yii::app()->db->createCommand($sql)->queryAll();
if(!empty($result)){ ?>
    <!--Begin loader-->
    <div class="overlay" style="opacity:0.1 !important;position:unset !important;">
        <div class="loader">
            <p style="font-size: 18px;"><i class="fa fa-cog fa-spin" aria-hidden="true"></i> Loading...</p>
        </div>
    </div>
    <!--End loader-->
    <div class="row hide" id="mydatatable">
        <div class="alert alert-success hide" id="delete" align="center">
            <h4>Commission Plan deleted successfully</h4>
        </div>
        <div class="col-md-12">
            <div class="pull-right m-b-10">
                <?php echo CHtml::link('Create', array('commissionPlans/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>
            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>
            <div id="commissionPlan-grid">
                <table id="commissionPlan-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                    <thead class="custom-table-head">
                    <tr>
                        <!-- <th class="custom-table-head">Action</th> -->
                        <?php
                            $array_cols = Yii::app()->db->schema->getTable('commission_plans')->columns;
                            foreach($array_cols as $key=>$col){ 
                                if($col->name == 'id'){ ?>
                                    <th class="custom-table-head">Action</th>
                                <?php }else{ ?>
								    <th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
							<?php } } ?>
                    </tr>
                    </thead>
                    <thead>
                    <tr>
                        <?php
                            $arr = array_values($array_cols);
                            foreach($arr as $key=>$col){
                                switch($col->name)
                                {
                                    case 'name':
                                        echo "<td></td>";
                                        echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
                                        break;
        
                                    case 'is_active':
                                        echo "<td><select class='drop-box' data-column='2' style='width:100%'>
                                                    <option value=''>Select</option>
                                                    <option value='1'>Active</option>
											        <option value='0'>Inactive</option>
                                                </select></td>";
                                        break;
        
                                    case 'table_name':
                                        echo "<td><input type='text' data-column='3' class='text-box' style='width:100%'></td>";
                                        break;

                                    case 'action_name':
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
        <img src="<?php echo Yii::app()->baseUrl."/plugins/img/wallet.png"; ?>" height="20%" width="10%"><br /><br />
        <h2>No commission plan</h2>
        <p></p>
        <div class="row">
            <?php echo CHtml::link('Create', array('commissionPlans/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
        </div>
        <br />
    </div>
</div>
<?php } ?>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
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
    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();

    var currentDate = d.getFullYear() + '/' +
        ((''+month).length<2 ? '0' : '') + month + '/' +
        ((''+day).length<2 ? '0' : '') + day;

    var datatable = $('#commissionPlan-table').DataTable({
        "fnDrawCallback":function(){
            if($('#commissionPlan-table td').hasClass('dataTables_empty')){
                $('div.dataTables_paginate').hide();
                $('div#commissionPlan-table').hide();
            } else {
                $('div#commissionPlan-table').show();
                $('div.dataTables_paginate').show();
            }
        },
        "order" : [[0,"ASC"]],
        "pageLength":20,
        "lengthMenu": [[20,50,100,200], [20,50,100,200]],
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
                return '<a href="<?php echo Yii::app()->createUrl("admin/commissionPlans/view/").'/'; ?>'+data[0]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/commissionPlans/update/").'/'; ?>'+data[0]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a id='+data[0]+' class="plandelete" href="javascript:void(0)"><i class="fa fa-times"></i></a>';
            }
        },{
            "targets": 2,
            "data": null,
            "render" : function(data, type, row) {
                if(data[2] == '1'){
                    return "<span align='center' class='label label-table label-success'>Active</span>";
                }else{
                    return "<span align='center' class='label label-table label-danger'>Inactive</span>";
                }
            }
        },{
            "visible":false,
            "targets":[5,6,7]
        },{
            "bSortable": false,
            "aTargets": [ 0 ]
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

    $(' body ').on('click','.plandelete',function() {
        var id = $(this).attr('id');
        bootbox.confirm("Are you sure you want to delete this commission plan?", function(result){
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