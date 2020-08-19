<?php
$this->pageTitle = 'Facebook Feed';
?>
<div class="row">
    <div class="alert alert-success
     hide" id="delete" align="center">
        <h4>Post deleted successfully</h4>
    </div>
    <div class="col-md-12">
        <?php
        $sql = "SELECT * FROM fb_feed";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($result)){
            ?>
            <div class="pull-right m-b-10">
                <?php echo CHtml::link('Create', array('FbFeed/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>
            <Button type="button" class="btn btn-minw btn-primary" onclick="getFBData()">Sync with FB</Button>

            <div style="margin-right:10px;" class="pull-right m-b-10">
                <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
            </div>
            <div id="fb-updates-grid">
                <table id="fb-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                    <thead class="custom-table-head">
                    <tr>
                        <th class="custom-table-head">Action</th>
                        <?php
                        $array_cols = Yii::app()->db->schema->getTable('fb_feed')->columns;
                        foreach($array_cols as $key=>$col){
                            ?>
                            <th class="custom-table-head"><?php echo ucfirst(str_replace("_"," ",$col->name)); ?></th>
                            <?php
                        }
                        ?>
                    </tr>
                    </thead>


                    <thead>
                    <tr>
                        <?php
                        $arr = array_values($array_cols);
                        /*echo "<pre>";
                        print_r($arr);die;*/
                        foreach($arr as $key=>$col){
                            switch($col->name)
                            {

                                case 'title':
                                    echo "<td></td>";
                                    echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
                                    break;

                                case 'description':
                                    echo "<td><input type='text' data-column='2' class='text-box' style='width:100%'></td>";
                                    break;

                                /*case 'created_at':
                                    echo "<td><input type='date' data-column='3' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
                                    break;*/

                                case 'is_enabled':
                                    echo "<td><select class='drop-box' data-column='4' style='width:100%'>
									<option value=''>select</option>
									<option value='1'>Yes</option>
									<option value='0'>No</option>
								</select></td>";
                                    break;

                                default :
                                    break;
                            }
                        }
                        ?>
                    </tr>
                    </thead>


                    <!--<tfoot>
                <tr>
                    <th>Action</th>
                    <?php
                    /*                    //                    $array_cols = Yii::app()->db->schema->getTable('sys_users')->columns;
                                        foreach($array_cols as $key=>$col){
                                            */?>
                        <th><?php /*echo ucfirst($col->name); */?></th>
                        <?php
                    /*                    }
                                        */?>
                </tr>
                </tfoot>-->
                </table>
                <div class="row"><br/></div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div align="center">
                    <img src="<?php echo Yii::app()->baseUrl."/plugins/img/reports.png"; ?>" height="20%" width="10%"><br /><br />
                    <h2>No Facebook Feed</h2>
                    <p></p>
                    <div class="row">
                        <?php echo CHtml::link('Create', array('FbFeed/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
                    </div>
                    <br />
                </div>
            </div>
        <?php } ?>


    </div>
</div>

<?php
/*$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'news-updates-grid',
    'dataProvider'=>$model->search(),
    'enableSorting' => true,
    'enablePagination' => true,
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'beforeAjaxUpdate' => 'function(id) { $(".overlay").removeClass("hide"); }',
    'afterAjaxUpdate' => 'function(id) { $(".overlay").addClass("hide"); }',
    'filter'=> $model,
    'columns'=>array(
        'title',
        'description',
        'created_at',
        [
            'name' => 'is_enabled',
            'filter' => CHtml::activeDropDownList($model, 'is_enabled', CHtml::listData(
                CylFieldValues::model()->findAllByAttributes(array('field_id' => 209), array('order' => 'field_label')
                ), 'predefined_value', 'field_label'), array('empty' => 'Select Status')),
            'value' => function($model){
            $fields = CylFields::model()->findByAttributes(['field_name' => 'is_enabled', 'table_id' => 1, ]);
            $fieldValue = CylFieldValues::model()->findByAttributes(['field_id' => $fields->field_id, 'predefined_value' => $model->is_enabled]);
            return $fieldValue->field_label;
            }
        ],
        'source',
        array(
            'header' => 'Action',
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => [
                'view' => [
                    'title' => 'view',
                    'label' => '<button class="btn btn-xs btn-default" type="button"><i class="fa fa-eye"></i></button>',
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("admin/NewsAndUpdates/view/$data->id")',
                    'options' => array('class' => 'btn-view', 'title' => 'View'),
                ],
                'update' => [
                    'label' => '<button class="btn btn-xs btn-default" type="button" ><i class="fa fa-pencil"></i></button>',
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("admin/NewsAndUpdates/update/$data->id")',
                    'options' => array('class' => 'btn-update', 'title' => 'Edit'),
                ],
                'delete' => [
                    'label' => '<button class="btn btn-xs btn-default" type="button"><i class="fa fa-times"></i></button>',
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("admin/NewsAndUpdates/delete/$data->id")',
                    'options' => array('class' => 'btn-delete', 'title' => 'Delete'),
                ],
            ],
        ),
    )
)); */?>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script>
    function getFBData()
    {
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('admin/FbFeed/getFBData'); ?>',
            type: "GET",
            success: function(data){
                bootbox.alert("Synced Successfully");
            },
            error: function(data){
                bootbox.alert("Synced UnSuccessfully");
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var currentDate = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;

        if (localStorage.getItem('msg')){
            $("#delete").removeClass("hide");
            setTimeout(
                function(){
                    $("#delete").addClass("hide");
                },5000
            );
            localStorage.removeItem('msg');
        }
        var datatable = $('#fb-table').DataTable({
            "fnDrawCallback":function(){
                if($('#fb-table td').hasClass('dataTables_empty')){
                    $('div.dataTables_paginate').hide();
                    $('div#fb-table_info').hide();
                } else {
                    $('div#fb-table_info').show();
                    $('div.dataTables_paginate').show();
                }
            },
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            "scrollX" : true,
            "sScrollX": "100%",

            /*responsive: {
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
                    title: 'Facebook feed data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Facebook feed data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Facebook feed data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Facebook feed data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Facebook feed data export '+currentDate
                }
            ],
            "serverSide": true,
//			"ajax": "serverdata",
            "ajax": {
                "type" : "GET",
                "url" : "<?php echo Yii::app()->createUrl('admin/FbFeed/serverdata'); ?>",
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
                }
            },
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "render" : function(data, type, row) {
                    return '<a href="<?php echo Yii::app()->createUrl("admin/FbFeed/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/FbFeed/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)"><i class="fa fa-times delete-FbFeed" id="'+data[1]+'"></i></a>';
                }
                //"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
            },{
                "visible":false,
                "targets":[1,4,6,7]
            } ]

        });

        $('.text-box').on( 'keyup click', function () {   // for text boxes
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

        $(' body ').on('click','.delete-FbFeed',function() {
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure you want to delete this post?", function(result){
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


