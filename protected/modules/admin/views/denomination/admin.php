<?php
/* @var $this UserInfoController */
/* @var $model UserInfo */

$this->pageTitle = 'Denominations';
?>
<div class="row" xmlns:Yii="http://www.w3.org/1999/xhtml" xmlns:Yii="http://www.w3.org/1999/xhtml"
     xmlns:Yii="http://www.w3.org/1999/xhtml">
    <div class="col-md-12">
        <div class="pull-right m-b-10">
            <?php echo CHtml::link('Create', array('Denomination/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?></div>

        <?php
        $exist = Denomination::model()->findAll();
        if(count($exist) > 0){ ?>

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
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'user-info-grid',
    'dataProvider'=>$model->search(),
    'enableSorting' => false,
    'enablePagination' => true,
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'beforeAjaxUpdate' => 'function(id) { $(".overlay").removeClass("hide"); }',
    'afterAjaxUpdate' => 'function(id) { $(".overlay").addClass("hide"); }',
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
                    'url' => 'Yii::app()->createUrl("admin/denomination/view/$data->denomination_id")',
                    'options' => array('class' => 'btn-view', 'title' => 'View'),
                ],
                'update' => [
                    'label' => '<button class="btn btn-xs btn-default" type="button"><i class="fa fa-pencil"></i></button>',
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("admin/denomination/update/$data->denomination_id")',
                    'options' => array('class' => 'btn-update', 'title' => 'Edit'),
                ],

                'delete' => [
                    'label' => '<button class="btn btn-xs btn-default" type="button"><i class="fa fa-times"></i></button>',
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("admin/denomination/deletedenomination/$data->denomination_id")',
                    'options' => array('class' => 'btn-delete', 'title' => 'Delete'),
                ],
            ],
        ),
        'denomination_id',
        array(
            'name' => 'denomination_type',
            'filter' => CHtml::activeDropDownList($model, 'denomination_type', CHtml::listData(
                Denomination::model()->findAll(array('order' => 'denomination_type')
                ), 'denomination_type', 'denomination_type'), array('empty' => 'Select Denomination Type')),
        ),
        array(
            'name' => 'sub_type',
            'filter' => CHtml::activeDropDownList($model, 'sub_type', CHtml::listData(
                Denomination::model()->findAll(array('order' => 'sub_type')
                ), 'sub_type', 'sub_type'), array('empty' => 'Select Sub Type')),
        ),
        'created_at',
        'modified_at',
        array(
            'name' => 'label',
            'filter' => CHtml::activeDropDownList($model, 'label', CHtml::listData(
                Denomination::model()->findAll(array('order' => 'label')
                ), 'label', 'label'), array('empty' => 'Select Label')),
        ),
    ),
)); } else {?>
    <div class="raw m-b-10">
        <span class="empty">No results found.</span>
    </div>
<?php } ?>
