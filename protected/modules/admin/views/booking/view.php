<?php
/* @var $this BookingController */
/* @var $model Booking */
$this->pageTitle = "View Booking"
?>

<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('booking/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        /*'booking_id',*/
        /*'event_id',*/
        [
            'name'=>'event title',
            'type'=>'raw',
            'value'=>function($model){
                $event = Events::model()->findByAttributes(['event_id'=>$model->event_id]);
                return CHtml::link($event->event_title, Yii::app()->createUrl("/admin/events/eventview/")."/".$model->event_id);
            },

        ],
        'username',
        'email',
        'mobile_number',
        'address',
        'is_member',
        'price',
        'coupon_code',
        'created_at',
        'modified_at',
    ),
)); ?>
