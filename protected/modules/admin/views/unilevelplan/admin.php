<?php
/* @var $this CompensationsController */
/* @var $model Compensations */

$this->pageTitle = 'Uni Level Plans';
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right m-b-10">
            <?php echo CHtml::link('Create', array('unilevelplan/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>

        <?php
        $sql = "SELECT * FROM unilevelplan";
        $result = Yii::app()->db->CreateCommand($sql)->queryAll();
        if(!empty($result)){
        ?>
        <div style="margin-right:10px;" class="pull-right m-b-10">
            <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
        </div>
        <?php } ?>

        <div id="user-info-grid">
            <table id="unilevelplan-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <th class="custom-table-head">Action</th>
                    <?php
                    $array_cols = Yii::app()->db->schema->getTable('unilevelplan')->columns;
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

                            case 'level':
                                echo "<td></td>";
                                echo "<td><input type='text' data-column='1' class='text-box' style='width:100%'></td>";
                                break;

                            case 'rank':
                                echo "<td><input type='text' data-column='2' class='text-box' style='width:100%'></td>";
                                break;

                            case 'amount':
                                echo "<td><input type='text' data-column='3' class='text-box' style='width:100%'></td>";
                                break;

                            case 'denomination':
                                $denominationsql = "select denomination_id,denomination_type from denomination";
                                $denominations = Yii::app()->db->createCommand($denominationsql)->queryAll();
                                ?><td><select class='drop-box' data-column='4' style='width:100%'>
                                    <option value=''>Select</option>
                                    <?php foreach($denominations as $key=>$value){ ?>
                                        <option value='<?php echo $value['denomination_id']; ?>'><?php echo $value['denomination_type']; ?></option>
                                    <?php } ?>
                                </select>
                                </td>
                                <?php
//								echo "<td><input type='text' data-column='4' class='text-box'></td>";
                                break;

                            case 'created_at':
                                echo "<td><input type='date' data-column='6' data-date-inline-picker='true' class='date-field' style='width:100%' /></td>";
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
/*                    //					$array_cols = Yii::app()->db->schema->getTable('sys_users')->columns;
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

        var datatable = $('#unilevelplan-table').DataTable({
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
                    title: 'Unilevel plan data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'Unilevel plan data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'Unilevel plan data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Unilevel plan data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'Unilevel plan data export '+currentDate
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
                    return '<a href="<?php echo Yii::app()->createUrl("admin/unilevelplan/view/").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/unilevelplan/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/unilevelplan/remove/").'/'; ?>'+data[1]+'"><i class="fa fa-times"></i></a>';
                }
                //"defaultContent": "<a href=''><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-pencil'></i></a>&nbsp;&nbsp;<a href=''><i class='fa fa-times'></i></a>"
            },{
                "visible":false,
                "targets":[1,7]
            } ]

        });

        $('.text-box').on( 'keyup', function () {   // for text boxes
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
/*		$exist = Unilevelplan::model()->findAll();
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
	'id'=>'user-info-grid',
	'dataProvider'=>$model->search(),
	'enableSorting' => false,
	'enablePagination' => true,
	'type' => TbHtml::GRID_TYPE_BORDERED,
	'filter'=> $model,
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
					'url' => 'Yii::app()->createUrl("admin/unilevelplan/view/$data->id")',
					'options' => array('class' => 'btn-view', 'title' => 'View'),
				],
				'update' => [
					'label' => '<button class="btn btn-xs btn-default" type="button" ><i class="fa fa-pencil"></i></button>',
					'imageUrl' => false,
					'url' => 'Yii::app()->createUrl("admin/unilevelplan/update/$data->id")',
					'options' => array('class' => 'btn-update', 'title' => 'Edit'),
				],
				'delete' => [
					'label' => '<button class="btn btn-xs btn-default" type="button"><i class="fa fa-times"></i></button>',
					'imageUrl' => false,
					'url' => 'Yii::app()->createUrl("admin/unilevelplan/deletec/$data->id")',
					'options' => array('class' => 'btn-delete', 'title' => 'Delete'),
				],
			],
		),
		'id',
		'level',
		'rank',
		'amount',
		[
			'name' => 'denomination',
			'value' => function($model){
				$denomination_name=Denomination::model()->findByAttributes(['denomination_id' => $model->denomination]);
				return $denomination_name->denomination_type;
			},
			'filter' => CHtml::activeDropDownList($model, 'denomination', CHtml::listData(
				Denomination::model()->findAll(array('order' => 'denomination_type')
				), 'denomination_id', 'denomination_type'), array('empty' => 'Select Denomination')),
		],
		'created_at',
		'modified_at',

	),
));
} else {*/?>
	<div class="raw m-b-10">
		<span class="empty">No results found.</span>
	</div>
--><?php /*} */?>
