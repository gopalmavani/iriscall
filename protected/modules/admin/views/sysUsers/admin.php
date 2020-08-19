<?php
/* @var $this SysUsersController */
/* @var $model SysUsers */

$this->pageTitle = 'System Users';

?>

<div class="row">
    <div class="col-md-12">
        <div class="pull-right m-b-10">
            <?php echo CHtml::link('Create', array('SysUsers/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>

        <div style="margin-right:10px;" class="pull-right m-b-10">
            <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
        </div>


        <div id="sys-users-grid">
            <table id="sys-users-table" class="table table-striped table-bordered" style="font-size:13px;" width="100%" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <th class="custom-table-head">Action</th>
                    <?php
                    $array_cols = Yii::app()->db->schema->getTable('sys_users')->columns;
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

                            case 'username':
                                echo "<td></td>";
                                echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
                                break;

                            case 'email':
                                echo "<td><input type='text' data-column='3' class='text-box' style='width:100%'></td>";
                                break;

                            case 'activekey':
                                echo "<td><input type='text' data-column='4' class='text-box' style='width:100%'></td>";
                                break;

                            case 'auth_level':
                                echo "<td><select class='drop-box' data-column='5' style='width:100%'>
                                            <option value=''>select</option>
                                            <option>superAdmin</option>
                                            <option>admin</option>
                                            <option>editor</option>
                                            <option>viewer</option>
                                        </select></td>";
                                break;

                            case 'created_at':
                                echo "<td><input type='date' data-column='7' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
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
                /*                    $array_cols = Yii::app()->db->schema->getTable('sys_users')->columns;
                                    foreach($array_cols as $key=>$col){
                                        */?>
                        <th><?php /*echo ucfirst($col->name); */?></th>
                        <?php
                /*                    }
                                    */?>
                </tr>
                </tfoot>-->
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var currentDate = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;
        var datatable = $('#sys-users-table').DataTable({
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
            "dom": 'lBfrtip',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'System users data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'System users data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'System users data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'System users data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'System users data export '+currentDate
                }
            ],
            "serverSide": true,
//			"ajax": "serverdata",
            "ajax": {
                "type" : "GET",
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
                }
            },
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "render" : function(data, type, row) {
                    return '<a href="<?php echo Yii::app()->createUrl("admin/sysUsers/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/sysUsers/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/sysUsers/delete/").'/'; ?>'+data[1]+'"><i class="fa fa-times"></i></a>';
                }
                //"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
            },{
                "visible":false,
                "targets":[1,3,7,9]
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



<?php
/*        $exist = SysUsers::model()->findAll();
        if(count($exist) > 0){ */?><!--
        <div class="pull-left">
            <div class="btn-group dropdown ">
                <button class="form-control btn dropdown-toggle field-list" data-toggle="dropdown">
                    <label>Select Fields</label>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="userList" role="menu" aria-labelledby="dropdownMenu">
                    <li><input type="checkbox" class="hidecol" value="SelectAll" id="select_all">Select All</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
/*$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'sys-users-grid',
    'dataProvider'=>$model->search(),
    'enableSorting' => false,
    'enablePagination' => true,
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'filter'=> null,
    'summaryText' => false,
    //'itemsCssClass' => 'js-dataTable-full',
    'columns'=>array(
        array(
            'header' => 'Action',
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => [
                'view' => [
                    'title' => 'view',
                    'label' => '<button class="btn btn-xs btn-default" type="button"><i class="fa fa-eye"></i></button>',
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("admin/sysUsers/view/$data->id")',
                    'options' => array('class' => 'btn-view', 'title' => 'View'),
                ],
                'update' => [
                    'label' => '<button class="btn btn-xs btn-default" type="button" ><i class="fa fa-pencil"></i></button>',
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("admin/sysUsers/update/$data->id")',
                    'options' => array('class' => 'btn-update', 'title' => 'Edit'),
                    'visible' => 'Yii::app()->params[\'mandatoryFields\'][\'admin_id\'] != $data->id',
                ],
                'delete' => [
                    'label' => '<button class="btn btn-xs btn-default" type="button"><i class="fa fa-times"></i></button>',
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("admin/sysUsers/delete/$data->id")',
                    'options' => array('class' => 'btn-delete', 'title' => 'Delete'),
                    'visible' => 'Yii::app()->params[\'mandatoryFields\'][\'admin_id\'] != $data->id',
                ],
            ],
        ),
        'id',
        'username',
        'password',
        'email',
        'activekey',
        'auth_level',
        'status',
        array(
            'name' => 'created_at',
            'header' => 'Registration Date',
            'value' => 'Yii::app()->dateFormatter->format("yyyy-MM-dd",strtotime($data->created_at))',
        ),
    ),
)); } else {*/?>
    <div class="raw m-b-10">
        <span class="empty">No results found.</span>
    </div>
--><?php /*} */?>
