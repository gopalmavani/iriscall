<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 22-09-2020
 * Time: 16:24
 */
//echo "<pre>";print_r($details);die;
$this->pageTitle = 'Invoice details';
?>
<div class="view">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Description</th>
                <th>number</th>
                <th>Amount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>

        <?php $i = 1;
        foreach($details as $detail){?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $detail['rule']; ?><?php if(!empty($detail['is_min'])){?></br>
                    <?= $detail['total_time']; ?><?php } ?>
                </td>
                <td><?= $detail['min']; ?></td>
                <td><?= $detail['cost']; ?></td>
                <td><?php
                    $amount = 0.00;
                    if(!empty($detail['min'])){
                        $amount = round($detail['min']*$detail['cost'],2);
                    }
                     echo $amount; ?></td>
            </tr>
            <?php $i++; } ?>
        </tbody>
    </table>
    <br>
    <div class="row">
        <button class="btn btn-primary pull-right" style="margin-right: 10px;">Generate Invoice</button>
        <button class="btn btn-primary pull-right" style="margin-right: 10px;">Generate Order</button>
    </div>
    <div class="row">
        <br>
    </div>
</div>