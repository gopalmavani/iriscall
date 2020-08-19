<?php
/* @var $this TicketingController */
/* @var $model Ticketing */
$this->pageTitle = 'View Ticket';
?>
<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('ticketing/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Create', array('ticketing/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Update', array('ticketing/update/'.$model->ticket_id), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        'ticket_id',
        'title',
        'ticket_detail',
        'description',
        [
            'name' => 'status',
            'value' => function($model){
                if($model->status == 0){
                    return 'In Progress';
                }
                else{
                    return 'Done';
                }
            },
        ],
        [
            'name' => 'attachment',
            'value' => function($model) {
                $images = json_decode($model->attachment);
                $displayimages = "";
                if(!empty($images)){
                    foreach ($images as $image){
                        $displayimages .= '<div style="display: block; width: 150px; height: 150px; position: relative; overflow: hidden; border: 1px solid; text-align: center;">' .
                            CHtml::image(Yii::app()->baseUrl . $image, 'No Image',
                                ['height' => 100, 'width' => 150, 'style' => "position: absolute; margin: auto; top: -9999px; bottom: -9999px; left: -9999px; right: -9999px; width: 100%; display: block;"]
                            ) . '</div>';
                    }
                }
                return $displayimages;
            },
            'type' => 'raw'

        ],
        'created_at',
        'modified_at',
    ),
)); ?>
