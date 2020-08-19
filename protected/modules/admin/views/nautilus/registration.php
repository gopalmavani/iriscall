<?php
/* @var $this ProductInfoController */
/* @var $model ProductInfo */
$this->pageTitle = 'Nautilus Registration';
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
        <?php
        $sql = "SELECT * FROM nu_registrations";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($result)){ ?>
            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>
            <div id="product-info-grid">
                <table id="registration-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                    <thead class="custom-table-head">
                    <tr>
                        <th class="custom-table-head">Action</th>
                        <?php
                        $array_cols = Yii::app()->db->schema->getTable('nu_registrations')->columns;
                        foreach($array_cols as $key=>$col){
                            ?>
                            <?php if($col->name == 'fullname_user1'){ ?>
	                    	<th class="custom-table-head">Full Name</th>
	                    <?php }elseif($col->name == 'user_id'){ ?>
	                    	<th class="custom-table-head">User Name</th>
	                    <?php }else{ ?>
                            <th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
                            <?php
                        } }
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

                                case 'user_id':
                                    echo "<td></td>";
                                    echo "<td><input type='text' data-column='1' class='text-box' style='width:100%;'></td>";
                                    break;

                                case 'fullname_user1':
                                    echo "<td><input type='text' data-column='5' class='text-box' style='width:100%;'></td>";
                                    break;

                                case 'country':
                                    $codesql = "select country_code,country_name from countries";
                                    $country = Yii::app()->db->createCommand($codesql)->queryAll();
                                    ?><td><select class='drop-box' data-column='13' style='width:100%'>
                                        <option value="">Select</option>
                                        <?php foreach($country as $key=>$value){ ?>
                                            <option value='<?php echo $value['country_code']; ?>'><?php echo $value['country_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    </td>
                                    <?php
                                    break;

                                case 'created_at':
                                    ?>
                                    <td>
                                        <input class="date_range_filter" type="text" id="starts_at_minW" data-column="20" style='width:100%' placeholder="From"/><br/>
                                        <input class="date_range_filter" type="text" id="starts_at_maxW" data-column="20" style='width:100%' placeholder="To"/>
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
            <div class="row"><br/></div>
        <?php } else { ?>
            <div class="row">
                <div align="center">
                    <img src="<?php echo Yii::app()->baseUrl."/plugins/img/product.png"; ?>" height="20%" width="10%"><br /><br />
                    <h2>No Registrations</h2>
                    <p></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/bootstrap-datepicker/bootstrap-datepicker.js', CClientScript::POS_END);
?>
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

        var datatable = $('#registration-table').DataTable({
            "fnDrawCallback":function(){
                if($('#product-info-table td').hasClass('dataTables_empty')){
                    $('div.dataTables_paginate').hide();
                    $('div#product-info-table_info').hide();
                } else {
                    $('div#product-info-table_info').show();
                    $('div.dataTables_paginate').show();
                }
            },
            "order":[[0,"DESC"]],
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            /*"scrollX" : true,
            "sScrollX": "100%",*/
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
            /*responsive: {
             details: {
             renderer: $.fn.dataTable.Responsive.renderer.tableAll({tableClass : 'ui table'})
             }
             },*/
            "processing": true,
            "serverSide": true,
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'Registrations Data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Registrations Data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Registrations Data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Registrations Data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Registrations Data export '+currentDate
                }
            ],
            "ajax": {
                "type" : "GET",
                "url" : "serverdata",
                "data": function ( d ) {
                    d.min = $('#starts_at_minW').val();
                    d.max = $('#starts_at_maxW').val();
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
                    return '<a href="<?php echo Yii::app()->createUrl("admin/nautilus/registrationview/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>';
                }
            },{
                "visible":false,
                "targets":[1,3,4,5,7,8,9,10,11,12,13,14,15,17,18,19,20,21,22,24]
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

        $(".date_range_filter").datepicker({
            format : "yyyy-mm-dd",
            autoclose : true
        });

        $('#starts_at_minW, #starts_at_maxW').change(function(){
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