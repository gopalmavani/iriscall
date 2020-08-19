<?php
/* @var $this TicketingController */
/* @var $model Ticketing */
$this->pageTitle = 'View Deposit';
?>
<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('nautilus/deposits'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
    <?php echo CHtml::link('Update', array('nautilus/depositsupdate/'.$model->id), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        'id',
        [
            'name' => 'username',
            'value' => function($model){
                if(isset($model->user_id)){
                    $userName = UserInfo::model()->findByAttributes(['user_id' => $model->user_id]);
                    return $userName->full_name;;
                }
            },
        ],
        [
            'name' => 'amount',
            'value' => Yii::app()->numberFormatter->formatCurrency($model->amount, "EUR"),
        ],
        'type',
        [
            'name' => 'status',
            'value' => function($model){
                if($model->status == 0){
                    return 'Pending';
                }elseif($model->status == 1){
                    return 'Aprooved';
                }
                else{
                    return 'Processed';
                }
            },
        ],
        'comment',
        'created_at',
        'modified_at',
    ),
)); ?>
