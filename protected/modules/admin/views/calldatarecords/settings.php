<?php
/* @var $this CalldatarecordsController */
/* @var $model CallDataRecordsInfo */

$this->pageTitle = 'Settings';
?>
<div class="block">
    <div class="block-content">
        <div class="row">
            <div class="col-md-7">
            <span>Fetch Call data records.</span>
                <div class="pull-right m-b-10">
                    <?php echo CHtml::link('Fetch CDR', array('calldatarecords/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
            <span>Fetch Call data records from number.</span>
                <div class="pull-right m-b-10">
                    <?php echo CHtml::link('Fetch From Number', array('calldatarecords/getfromnumber'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
            <span>Calculate cost of Call data records.</span>
                <div class="pull-right m-b-10">
                    <?php echo CHtml::link('Calculate Cost', array('calldatarecords/costcalculate'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                </div>
            </div>
        </div>
    </div>
</div>