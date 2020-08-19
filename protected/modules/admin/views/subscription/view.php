<?php
/* @var $data ProductSubscription */
$this->pageTitle = 'View Subscription Details';
?>
<style>
    .mb-10{
        margin-bottom: 10px !important;
    }
    .dataTables_filter {
        display: none;
    }
    thead tr th:first-child, tbody tr td:first-child{
        min-width: 55px !important;
        width: 55px !important;
    }
    thead tr th:last-child, tbody tr td:last-child{
        width: 20% !important;
    }
    .date_range_filter{
        width: 65%;
        margin-top: 2px;
    }
    .date-range-span{
        margin-top: 2px;
        width: 30% !important;
    }
    .dt-buttons{
        float: left !important;
    }
    .summary{
        text-align: right;
        padding-bottom: 10px;
    }
    thead tr th:first-child,
    tbody tr td:first-child {
        width: 8em;
        min-width: 8em;
        max-width: 8em;
        word-break: break-all;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="m-b-10" style="float: right;">
            <?php echo CHtml::link('Go to list', array('subscription/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="block block-bordered" style="border-color: #f3c200;">
            <div class="block-header" style="background-color: #f3c200">
                <h3 class="block-title"><font color="white">Account Details</font></h3><br/>
            </div>
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="h5 push-5 mb-10">Username</div>
                                <div class="h5 push-5 mb-10">Email</div>
                                <div class="h5 push-5 mb-10 ">Duration </div>
                                <div class="h5 push-5 mb-10 ">Starts At </div>
                                <div class="h5 push-5 mb-10">Payment Mode</div>
                                <div class="h5 push-5 mb-10">Next Renewal Date </div>
                                <div class="h5 push-5 mb-10">Subscription Status </div>
                            </div>
                            <div class="col-md-6">
                                <div class="h5 push-5 mb-10"><?= $data->user_name; ?></div>
                                <div class="h5 push-5 mb-10"><?= $data->email; ?></div>
                                <div class="h5 push-5 mb-10"><?= $data->duration; ?> <?php
                                    $duration = CylFieldValues::model()->findByAttributes(['field_id' => 244, 'predefined_value'=>$data->duration_denomination]);
                                    echo ($duration->predefined_value == 1 ) ? substr_replace($duration->field_label , "", -1): $duration->field_label ;
                                    ?>
                                </div>
                                <div class="h5 push-5 mb-10"><?= date("d-M-Y",strtotime(str_replace("-","/",$data->starts_at))); ?></div>
                                <div class="h5 push-5 mb-10"><?php if($data->payment_mode== 0){echo "Cash";}else{echo "Check";}?>
                                </div>
                                <div class="h5 push-5 mb-10"><?= date("d-M-Y",strtotime(str_replace("-","/",$data->next_renewal_date))); ?></div>
                                <div class="h5 push-5 mb-10"><?php
                                    $status = CylFieldValues::model()->findByAttributes(['field_id' => 245, 'predefined_value'=>$data->subscription_status]);
                                    if ($data->subscription_status == 0) { ?>
                                        <span class="label label-warning"><?= $status->field_label; ?></span>
                                    <?php }elseif ($data->subscription_status == 1) { ?>
                                        <span class="label label-warning"><?= $status->field_label; ?></span>
                                    <?php }else{ ?>
                                        <span class="label label-success"><?= $status->field_label; ?></span>
                                    <?php } ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="block block-bordered" style="border-color: #67809F;">
            <div class="block-header" style="background-color: #67809F">
                <h3 class="block-title"><font color="white">Product Details</font></h3><br/>
            </div>
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="h5 push-5 mb-10">Product Name </div>
                                <div class="h5 push-5 mb-10">Product Description </div>
                                <div class="h5 push-5 mb-10">Subscription Price </div>
                            </div>
                            <div class="col-md-6">
                                <div class="h5 push-5 mb-10"><?= $data->product_name; ?></div>
                                <div class="h5 push-5 mb-10"><?= $data->product_details; ?></div>
                                <div class="h5 push-5 mb-10">&euro; <?= $data->subscription_price; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" style="padding-bottom: 20px;">
        <h1 class="page-heading">Past Orders</h1>

    </div>
</div>

<div id="order-info-grid">
    <table id="order-info-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
        <thead class="custom-table-head">
        <tr>
            <th class="custom-table-head" ></th>
            <?php $array_cols = Yii::app()->db->schema->getTable('order_info')->columns;
            foreach($array_cols as $key=>$col){ ?>
                <th class="custom-table-head" ><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <thead>
        <tr>
            <?php
            $array_cols = Yii::app()->db->schema->getTable('order_info')->columns;

            $arr = array_values($array_cols);
            foreach($arr as $key=>$col){
                switch($col->name) {

                    case 'order_id':
                        echo "<td ></td>";
                        echo "<td ><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
                        break;
                    case 'order_status':
                        echo "<td><select class='drop-box' data-column='6' style='width:100%'>
                                        <option value=''>select</option>
                                        <option value='1'>Success</option>
                                        <option value='0'>Canceled</option>
                                    </select></td>";
                        break;
                    case 'country':
                        echo "<td><input type='text' data-column='11' class='text-box' style='width:100%'></td>";
                        break;
                    case 'invoice_number':
                        echo "<td><input type='text' data-column='16' class='text-box' style='width:100%'></td>";
                        break;
                    case 'netTotal':
                        echo "<td><input type='text' data-column='15' class='text-box' style='width:100%'></td>";
                        break;
                    case 'invoice_date':
                        ?>
                        <td>
                            <p class="date_filter">
                                <span class="date-range-span" style="float: left;">From: </span><input class="date_range_filter" type="text" id="invoice_min" data-column="17" style="float: right;" />
                                <span class="date-range-span" style="float: left;">To: </span><input class="date_range_filter" type="text" id="invoice_max" data-column="17" style="float: right;"/>
                            </p>
                        </td>
                        <?php
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
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/bootstrap-datepicker/bootstrap-datepicker.js', CClientScript::POS_END);
?>
<script>
    $(".overlay").removeClass("hide");
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var currentDate = d.getFullYear() + '/' +
        ((''+month).length<2 ? '0' : '') + month + '/' +
        ((''+day).length<2 ? '0' : '') + day;

    $(document).ready(function() {
        var datatable = $('#order-info-table').DataTable({
            "autoWidth": false,
            "order": [[ 1, "desc" ]],
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            /*"scrollX" : true,
             "sScrollX": "100%",*/
            'colReorder':true,
            /*"pageLength" : 10,
             responsive: {
             details: {
             renderer: $.fn.dataTable.Responsive.renderer.tableAll({tableClass : 'ui table'})
             }
             },*/
            "processing": true,
            "serverSide": true,
//			"ajax": "serverdata",
            "ajax": {
                "type" : "GET",
                "url" : "<?php echo Yii::app()->createUrl('admin/subscription/SubscriptionData')."/".$data->s_id; ?>",
                "dataSrc": function ( json ) {
                    $(".overlay").addClass("hide");
                    console.info(json.data);
                    return json.data;
                },
                "data": function ( d ) {
                    d.myKey = "myValue";
                    d.created_at_min = $('#created_at_min').val();
                    d.created_at_max = $('#created_at_max').val();
                    d.invoice_min = $('#invoice_min').val();
                    d.invoice_max= $('#invoice_max').val();
                    // etc
                }
            },
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "render" : function(data, type, row) {
                    var update = '';
                    if (data[11] != "<span class='label label-success'>Success</span>") {
                        update = '&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/orderInfo/update/") . '/'; ?>' + data[1] + '"><i class="fa fa-pencil"></i></a>';
                    }
                    return '<a href="<?php echo Yii::app()->createUrl("admin/orderInfo/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>'+update;
                }
                //"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
            },{
                "visible":false,
                "targets":[1,3,4,5,6,8,9,10,11,13,14,15,19,20,21,22,23]
//
            } ]
        });

        $(".date_range_filter").datepicker({
            format : "yyyy-mm-dd",
            autoclose : true
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

        $('#invoice_min').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

        $('#invoice_max').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

        $('#created_at_min').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

        $('#created_at_max').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
        });

        $('#clearfilters').on('click',function() {
            datatable.columns().search('').draw();
            datatable.search('').draw();
            $('input[type=text]').val('');

            $('.drop-box').val('');
            $('.date-field').val('');
        });
    });

</script>