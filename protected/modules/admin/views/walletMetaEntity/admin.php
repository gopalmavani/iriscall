<?php
/* @var $this WalletMetaEntityController */
/* @var $model WalletMetaEntity */

$this->pageTitle = 'WalletMeta';
?>
<div class="row">
	<div class="col-md-12">
		<div class="pull-right m-b-10">
			<?php echo CHtml::link('Create', array('WalletMetaEntity/create'), array('class' => 'btn btn-minw btn-square btn-warning')); ?>
		</div>

<?php
$walletData = WalletMetaEntity::model()->findAll();
if($walletData != null){
	?>
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
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'wallet-meta-entity-grid',
	'dataProvider'=>$model->search(),
	'enableSorting' => false,
	'enablePagination' => true,
	'type' => TbHtml::GRID_TYPE_BORDERED,
	'beforeAjaxUpdate' => 'function(id) { $(".overlay").removeClass("hide"); }',
	'afterAjaxUpdate' => 'function(id) { $(".overlay").addClass("hide"); }',
	'filter'=>$model,
	'summaryText' => false,
	//'itemsCssClass' => 'js-dataTable-full',
	'columns'=>array(
	[
		'header' => 'Action',
		'class' => 'CButtonColumn',
		'template' => '{view}{update}{delete}',
			'buttons' => [
				'view' => [
				'title' => 'view',
				'label' => '<button class="btn btn-xs btn-default" type="button"><i class="fa fa-eye"></i></button>',
				'imageUrl' => false,
				'url' => 'Yii::app()->createUrl("admin/walletMetaEntity/view/$data->reference_id")',
				'options' => array('class' => 'btn-view', 'title' => 'View'),
				],
				'update' => [
				'label' => '<button class="btn btn-xs btn-default" type="button" ><i class="fa fa-pencil"></i></button>',
				'imageUrl' => false,
				'url' => 'Yii::app()->createUrl("admin/walletMetaEntity/update/$data->reference_id")',
				'options' => array('class' => 'btn-update', 'title' => 'Edit'),
				],
				'delete' => [
				'label' => '<button class="btn btn-xs btn-default" type="button"><i class="fa fa-times"></i></button>',
				'imageUrl' => false,
				'url' => 'Yii::app()->createUrl("admin/walletMetaEntity/delete/<!--$data->reference_id-->")',
				'options' => array('class' => 'btn-delete', 'title' => 'Delete'),
				],
		],
	],
		'reference_id',
		'reference_key',
		'reference_desc',
		'reference_data',
		'created_at',
		'modified_at',
	),
));
} else{ ?>
<div class="raw m-b-10">
	<span class="empty">No results found.</span>
</div>
<?php } ?>