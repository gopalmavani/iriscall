<?php
/* @var $this Mt4Controller */
/* @var $model CbmAccounts */
$id = $model->login;
$this->pageTitle = 'View Mt4 Account';

?>
<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('mt4/accounts'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        'login',
        'name',
        'currency',
        'balance',
        'equity',
        'email_address',
        'group',
        'agent',
        'registration_date',
        'leverage',
        'address',
        'city',
        'state',
        'postcode',
        'country',
        'phone_number',
        'created_at',
        'modified_at'
    ),
)); ?>
