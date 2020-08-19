<?php
/* @var $this NotificationManagerController */
/* @var $model NotificationManager */

$this->pageTitle = 'NotificationManager';
?>
	<style>
		thead tr th:first-child,
		tbody tr td:first-child {
			width: 7.5em;
			min-width: 7.5em;
			max-width: 7.5em;
			word-break: break-all;
		}
	</style>
<div class="pull-right m-b-10">
	<?php echo CHtml::link('Create', array('NotificationManager/create'), array('class' => 'btn btn-minw btn-square btn-warning')); ?></div>

<?php echo Yii::app()->user->getFlash('deleteError');
$exist = NotificationManager::model()->findAll();
if(count($exist) > 0){ ?>
	<div class="pull-left">
		<div class="btn-group dropdown ">
			<button class="form-group btn dropdown-toggle field-list" data-toggle="dropdown">
				<label>Select Fields</label>
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" id="userList" role="menu" aria-labelledby="dropdownMenu"></ul>
		</div>
	</div>
	<div class="error-msg">

<?php if(Yii::app()->user->hasFlash('deleteError')){
				echo Yii::app()->user->getFlash('deleteError');
			Yii::app()->user->setFlash('deleteError', null);
	}?>
<?php
foreach(Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}
?>
	</div>
	<br/><br/>
<?php 
	$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'NotificationManager-grid',
	'dataProvider'=>$model->search(),
	'enableSorting' => true,
	'enablePagination' => false,
	'type' => TbHtml::GRID_TYPE_BORDERED,
	'filter'=> $model,
	'summaryText' => false,
	'itemsCssClass' => 'js-dataTable-full',
	'columns'=>array(
		array(
			'class'=>'CButtonColumn',
			'header' => 'Action',
			'template' => '{view}{update}{delete}',
			'buttons' => [
				'view' => [
				'title' => 'view',
				'label' => '<button class="btn btn-xs btn-default" type="button"><i class="fa fa-eye"></i></button>',
				'imageUrl' => false,
				'url' => 'Yii::app()->createUrl("admin/NotificationManager/view/$data->category_id")',
				'options' => array('class' => 'btn-view', 'title' => 'View'),
				],
				'update' => [
				'label' => '<button class="btn btn-xs btn-default" type="button" ><i class="fa fa-pencil"></i></button>',
				'imageUrl' => false,
				'url' => 'Yii::app()->createUrl("admin/NotificationManager/update/$data->category_id")',
				'options' => array('class' => 'btn-update', 'title' => 'Edit'),
				'visible' => 'Yii::app()->params[\'mandatoryFields\'][\'category_id\'] != $data->category_id',
				],
				'delete' => [
				'label' => '<button class="btn btn-xs btn-default" type="button"><i class="fa fa-times"></i></button>',
				'imageUrl' => false,
				'url' => 'Yii::app()->createUrl("admin/NotificationManager/delete/$data->category_id")',
				'options' => array('class' => 'btn-delete', 'title' => 'Delete'),
				'visible' => 'Yii::app()->params[\'mandatoryFields\'][\'category_id\'] != $data->category_id',
			],
			],
		),
		'category_id',
		'category_name',
		'description',
		[
			'name' => 'portal_id',
			'value' => function ($data) {
				$Portal = Portals::model()->findByAttributes(['portal_id' =>$data->portal_id ]);
				return $Portal->portal_name;
			}
		],
		'is_active',
	),
)); } else {?>
	<div class="raw m-b-10">
		<span class="empty">No results found.</span>
	</div>
<?php } ?>