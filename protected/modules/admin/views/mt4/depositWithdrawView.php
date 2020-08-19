<?php
/* @var $this Mt4Controller */
/* @var $model CbmDepositWithdraw */
$id = $model->id;
$this->pageTitle = 'View Deposit';

?>
<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('mt4/depositWithdraw'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        'id',
        'login',
        'ticket',
        'symbol',
        'email',
        'api_type',
        'lots',
        'type',
        'open_price',
        'open_time',
        'close_price',
        'close_time',
        'profit',
        'commission',
        'agent_commission',
        'comment',
        'magic_number',
        'stop_loss',
        'take_profit',
        'swap',
        'reason',
        'created_at',
        'modified_at',
        'is_accounted_for'
    ),
)); ?>
