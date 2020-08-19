<?php
/* @var $this RankController */
/* @var $model Rank */

$this->pageTitle = 'View Facebook Feed';
$id = $model->id;
?>
<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('fbFeed/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Create', array('fbFeed/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Update', array('fbFeed/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary'));?>
</div>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        'title',
        'description',
        [
         'label' => 'is_enabled',
         'value' => function($model){
            if ($model->is_enabled == 0){
                return 'No';
            }else{
                return 'Yes';
            }
         }
        ],
        'created_at',
        'source'
    ),
)); ?>
