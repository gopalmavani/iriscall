<?php
$this->pageTitle = 'Product Subscription';
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<style>
    .dataTables_filter{
        display: none;
    }
    .form-inline input {
        margin-bottom: 10px!important;
    }
    .date_range_filter{
        margin-bottom: 10px!important;
    }
    .dt-buttons{
        float: left !important;
    }
</style>
<div class="row">
    <div class="col-sm-8 col-lg-4">
        <a class="block block-bordered block-link-hover3 text-center" href="javascript:void(0)">
            <div class="block-content block-content-full bg-gray-lighter border-b">
                <div class="h1 font-w700"> <span class="h2 text-muted">&lt;</span> <?= $pending['pending_subs']; ?></div>
                <div class="h5 text-muted text-uppercase push-5-t">Pending Subscriptions</div>
            </div>
            <div class="block-content block-content-full block-content-mini">
                <strong> &euro; <?= number_format($pending['total_amount'],2); ?></strong> In cash
            </div>
        </a>
    </div>
    <div class="col-sm-8 col-lg-4">
        <a class="block block-bordered block-link-hover3 text-center" href="javascript:void(0)">
            <div class="block-content block-content-full bg-gray-lighter border-b">
                <div class="h1 font-w700"> <span class="h2 text-muted">+</span><?= $upcoming['upcoming_subs']; ?></div>
                <div class="h5 text-muted text-uppercase push-5-t">Upcoming Subscription</div>
            </div>
            <div class="block-content block-content-full block-content-mini">
                <strong> &euro; <?= number_format($upcoming['total_amount'],2); ?></strong> In cash
            </div>
        </a>
    </div>
    <div class="col-sm-8 col-lg-4">
        <a class="block block-bordered block-link-hover3 text-center" href="javascript:void(0)">
            <div class="block-content block-content-full bg-gray-lighter border-b">
                <div class="h1 font-w700"><span class="h2 text-muted">+</span><?= $new['new_subs']; ?></div>
                <div class="h5 text-muted text-uppercase push-5-t">New Subscription</div>
            </div>
            <div class="block-content block-content-full block-content-mini">
                <strong> &euro; <?= number_format($new['total_amount'],2); ?></strong> In cash
            </div>
        </a>
    </div>
</div>
<?php
$sql = "SELECT * FROM product_subscription";
$result = Yii::app()->db->createCommand($sql)->queryAll();
if(!empty($result)){
    ?>
    <div class="pull-right m-b-10">
        <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="subscription-info-grid">
                <table id="subscription-info-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                    <thead class="custom-table-head">
                    <tr>
                        <th class="custom-table-head" >Action</th>
                        <?php
                        $array_cols = Yii::app()->db->schema->getTable('product_subscription')->columns;
                        foreach($array_cols as $key=>$col){ ?>
                            <th class="custom-table-head" ><?php echo ucfirst(str_replace("_"," ",$col->name)); ?></th>
                        <?php } ?>
                    </tr>
                    </thead>

                    <thead>
                    <tr>
                        <?php
                        $arr = array_values($array_cols);
                        foreach($arr as $key=>$col){
                            switch($col->name)
                            {
                                case 'user_name':
                                    echo "<td></td>";
                                    echo "<td><input type='text' data-column='2' class='text-box' style='width:100%'></td>";
                                    break;

                                case 'product_name':
                                    echo "<td><input type='text' data-column='4' class='text-box' style='width:100%'></td>";
                                    break;

                                case 'subscription_price':
                                    echo "<td><input type='text' data-column='6' class='text-box' style='width:100%'></td>";
                                    break;

                                case 'starts_at':
                                    ?>
                                    <td>
                                        <input class="date_range_filter" type="text" id="starts_at_min" data-column="9" placeholder="From"/><br/>
                                        <input class="date_range_filter" type="text" id="starts_at_max" data-column="9" placeholder="To"/>
                                    </td>
                                    <?php
                                    break;

                                case 'next_renewal_date':
                                    ?>
                                    <td>
                                        <input class="date_range_filter" type="text" id="next_renewal_date_min" data-column="10" placeholder="From"/><br/>
                                        <input class="date_range_filter" type="text" id="next_renewal_date_max" data-column="10" placeholder="To"/>
                                    </td>
                                    <?php
                                    break;

                                case 'subscription_status':
                                    $meta = "select field_label,predefined_value from cyl_field_values WHERE field_id = 245";
                                    $cylFields = Yii::app()->db->createCommand($meta)->queryAll();
                                    ?><td><select class='drop-box' data-column='12' style='width:100%'>
                                        <option value=''>Select</option>
                                        <?php foreach($cylFields as $key=>$value){ ?>
                                            <option value='<?php echo $value['predefined_value']; ?>'> <?php echo $value['field_label']; ?></option>
                                        <?php } ?>
                                    </select>
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
        </div>
    </div>

<?php } else {?>
    <div class="row">
        <div align="center">
            <img src="<?php echo Yii::app()->baseUrl."/plugins/img/order.png"; ?>" height="20%" width="10%"><br /><br />
            <h2>No Subscription</h2>
            <p></p>
            <div class="row">
                <?php echo CHtml::link('Create', array('orderInfo/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
            </div>
            <br />
        </div>
    </div>
<?php } ?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/bootstrap-datepicker/bootstrap-datepicker.js', CClientScript::POS_END);
?>
<script>
    $(document).ready(function() {
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var currentDate = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;
        var datatable = $('#subscription-info-table').DataTable({
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            /*"scrollX" : true,
            "sScrollX": "100%",*/
            /*"pageLength" : 10,
             responsive: {
             details: {
             renderer: $.fn.dataTable.Responsive.renderer.tableAll({tableClass : 'ui table'})
             }
             },*/
            "processing": true,
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'Subscription data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Subscription data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Subscription data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Subscription data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Subscription data export '+currentDate
                }
            ],
            "serverSide": true,
//			"ajax": "serverdata",
            "ajax": {
                "type" : "POST",
                "url" : "serverdata",
                "dataSrc": function ( json ) {
//					console.info(json.data[0]);
//					console.info(json.data.length);
                    /*var i;
                     for (i = 0; i<json.data.length ; i++) {
                     if(json.data[0][8] == 1)
                     {

                     json.data[0][8] = 'male';

                     }
                     else{
                     json.data[0][8] = 'male';

                     }
                     console.info(i);
                     }*/
                    return json.data;
                },
                "data": function ( d ) {
                    d.myKey = "myValue";
                    d.starts_at_min = $('#starts_at_min').val();
                    d.starts_at_max = $('#starts_at_max').val();
                    d.next_renewal_date_min = $('#next_renewal_date_min').val();
                    d.next_renewal_date_max = $('#next_renewal_date_max').val();
                }
            },
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "render" : function(data, type, row) {
                    return '<a href="<?php echo Yii::app()->createUrl("admin/subscription/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/subscription/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>';
                }
                //"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
            },{
                "visible":false,
                "targets":[1,2,4,6,8,9,12,14,15]
            } ]
        });

        $(".date_range_filter").datepicker({
            format : "yyyy-mm-dd",
            autoclose : true
        });

        $('#starts_at_min, #starts_at_max,#next_renewal_date_min,#next_renewal_date_max').change(function(){
            var i =$(this).attr('data-column');
            var v =$(this).val();
            datatable.columns(i).search(v).draw();
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
