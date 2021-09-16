<?php
/* @var $this CommissionPlanSettingController */
/* @var $model CommissionPlanSettings */
$this->pageTitle = 'Commission Rules';
?>
<?php
$sql = "SELECT * FROM commission_plan_settings";
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
            <h4>Commission Rule deleted successfully</h4>
        </div>
        <div class="col-md-12">
            <div class="pull-right m-b-10">
                <?php echo CHtml::link('Create', array('commissionPlanSetting/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>
            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>
            <div id="commissionPlanSettings-grid">
                <table id="commissionPlanSettings-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                    <thead class="custom-table-head">
                    <tr>
                        <!-- <th class="custom-table-head">Action</th> -->
                        <?php
                            $array_cols = Yii::app()->db->schema->getTable('commission_plan_settings')->columns;
                            foreach($array_cols as $key=>$col){ 
                                if($col->name == 'id'){ ?>
                                    <th class="custom-table-head">Action</th>
                                <?php }elseif($col->name == 'commission_plan_id'){ ?>
                                    <th class="custom-table-head">Commission Plan</th>
                                <?php }elseif($col->name == 'rank_id'){ ?>
                                    <th class="custom-table-head">Rank</th>
                                <?php }elseif($col->name == 'amount'){ ?>
                                    <th class="custom-table-head">Amount(€ / %)</th>
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
                                    case 'commission_plan_id':
                                        echo "<td></td>";
                                        $commissionsql = "select name,id from commission_plans";
                                        $commissionPlan = Yii::app()->db->createCommand($commissionsql)->queryAll(); ?>
                                        <td>
                                            <select class='drop-box' data-column='1' style='width:100%'>
                                                <option value=''>Select</option>
                                                <?php foreach($commissionPlan as $key=>$value){ ?>
                                                <option value='<?php echo $value['id']; ?>'> <?php echo $value['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <?php
                                        break;
        
                                    case 'user_level':
                                        echo "<td><select class='drop-box' data-column='2' style='width:100%'>
                                                    <option value=''>Select</option>
                                                    <option value='0'>User</option>
											        <option value='1'>Level 1</option>
                                                    <option value='2'>Level 2</option>
                                                    <option value='3'>Level 3</option>
                                                    <option value='4'>Level 4</option>
                                                    <option value='5'>Level 5</option>
                                                </select></td>";
                                        break;
        
                                    case 'rank_id':
                                        $ranksql = "select name,id from rank";
                                        $rank = Yii::app()->db->createCommand($ranksql)->queryAll(); ?>
                                        <td>
                                            <select class='drop-box' data-column='3' style='width:100%'>
                                                <option value=''>Select</option>
                                                <?php foreach($rank as $key=>$value){ ?>
                                                <option value='<?php echo $value['id']; ?>'> <?php echo $value['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <?php
                                        break;

                                    case 'amount_type':
                                        echo "<td><select class='drop-box' data-column='6' style='width:100%'>
                                                    <option value=''>Select</option>
                                                    <option value='1'>Percentage</option>
                                                    <option value='0'>Fixed</option>
                                                </select></td>";
                                        break;

                                    case 'amount':
                                        echo "<td><input type='text' data-column='7' class='text-box' style='width:100%'></td>";
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
            <?php echo CHtml::link('Create', array('commissionPlanSetting/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
        </div>
        <br />
    </div>
</div>
<?php } ?>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script>
$(document).ready(function() {
    var ranks = '<?php echo json_encode($rankArray); ?>';
    var rankArr = JSON.parse(ranks);
    var commissionPlans = '<?php echo json_encode($commissionArray); ?>';
    var commissionArr = JSON.parse(commissionPlans);

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

    var datatable = $('#commissionPlanSettings-table').DataTable({
        "fnDrawCallback":function(){
            if($('#commissionPlanSettings-table td').hasClass('dataTables_empty')){
                $('div.dataTables_paginate').hide();
                $('div#commissionPlanSettings-table').hide();
            } else {
                $('div#commissionPlanSettings-table').show();
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
                return '<a href="<?php echo Yii::app()->createUrl("admin/commissionPlanSetting/view/").'/'; ?>'+data[0]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/commissionPlanSetting/update/").'/'; ?>'+data[0]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a id='+data[0]+' class="plandelete" href="javascript:void(0)"><i class="fa fa-times"></i></a>';
            }
        },{
            "targets": 1,
            "data": null,
            "render" : function(data, type, row) {
                return commissionArr[data[1]];
            }
        },{
            "targets": 2,
            "data": null,
            "render" : function(data, type, row) {
                if(data[2] == '0'){
                    return "<span align='center' class='label label-table label-success'>User</span>";
                }else{
                    return "<span align='center' class='label label-table label-info'>Level "+ data[2] +"</span>";
                }
            }
        },{
            "targets": 3,
            "data": null,
            "render" : function(data, type, row) {
                return rankArr[data[3]];
            }
        },{
            "targets": 6,
            "data": null,
            "render" : function(data, type, row) {
                if(data[6] == '0'){
                    return "<span align='center' class='label label-table label-success'>Fixed</span>";
                }else{
                    return "<span align='center' class='label label-table label-warning'>Percentage</span>";
                }
            }
        },{
            "visible":false,
            "targets":[4,5,8,9,10,11,12,13]
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
        bootbox.confirm("Are you sure you want to delete this commission rule?", function(result){
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