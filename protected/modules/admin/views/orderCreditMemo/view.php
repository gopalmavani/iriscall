<?php
/* @var $this OrderCreditMemoController */
/* @var $model OrderCreditMemo */

$this->pageTitle = 'View CreditMemo';


$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'htmlOptions' => array('class' => 'table'),
    'attributes'=>array(
        'credit_memo_id',
        'order_info_id',
        'invoice_number',
        'refund_amount',
        'vat',
        'order_total'
    ),
)); ?>
<hr>
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-header"><h3>Credit Items</h3></div>
            <div class="block-content">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Product Name</th>
                        <th>Order Quantity</th>
                        <th>Refunded Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($creditItems as $k=>$item){ ?>
                        <tr>
                            <td class="text-center"><?= $k+1; ?></td>
                            <td><?= $item->product_name; ?></td>
                            <td><?= $item->order_item_qty; ?></td>
                            <td><?= $item->refund_item_qty; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
