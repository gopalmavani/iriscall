<?php
/* @var $this OrderInfoController */
/* @var $model OrderInfo */

$userName = UserInfo::model()->findByAttributes(['user_id' => $model->user_id]);

if(!empty($userName)){
$this->pageTitle = "ORDER ". $model->order_id . " | " . Yii::app()->dateFormatter->format("MMM dd, yyyy h:m:s", $model->created_date);
}
else{
$this->pageTitle = 'View Order';
}
$id = $model->order_info_id;

?>

<div class="tab-content">
    <div class="tab-pane active">
        <div class="row">
            <div class="pull-right">
                <?php echo CHtml::link('Go to list', array('orderInfo/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>

                <?php // echo CHtml::link('Create', array('orderInfo/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                <?php if(isset($model->invoice_number)){ ?>
                <a href="<?php echo Yii::app()->createUrl('invoice/Generateinvoice/' . $model->order_info_id); ?> "
                   data-toggle="tooltip" title="Download Invoice" class="btn btn-minw btn-square btn-success">Generate Invoice</a>
                <?php }if($model->order_status != 1){ ?>
                    <?php echo CHtml::link('Update', array('orderInfo/update/'.$id), array('class' => 'btn btn-minw btn-square btn-primary')); ?> 
                <?php }elseif ($model->order_status == 1) {?>
                   <a href="<?php echo Yii::app()->createUrl('admin/orderInfo/creditMemo/'.$model->order_info_id); ?>" data-toggle="tooltip" title="Credit Memo" class="btn btn-minw btn-square btn-info">Credit Memo</a>
                <?php } ?>
                <p></p>
            </div>
        </div>
        <!-- Page Content -->
        <!-- Order Details -->
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="block block-bordered" style="border-color: #f3c200;">
                    <div class="block-header" style="background-color: #f3c200">
                        <h3 class="block-title"><font color="white"><i class="fa fa-cogs"></i> Order Details</font></h3><br/>
                    </div>
                    <div class="block-content block-content-full">
                        <?php $userName = UserInfo::model()->findByAttributes(['user_id' => $model->user_id]); ?>
                        <div class="row">
                            <div class="col-md-5"> <b>Customer Name:</b> </div>
                            <div class="col-md-7"><?php if(!empty($userName)){ ?>
                                    <a target="_blank" href="<?php echo Yii::app()->CreateUrl('admin/userInfo/view').'/'.$model->user_id; ?>"><?php echo $model->user_name; ?></a>

                                <?php } else{
                                    echo $model->user_name;
                                }
                                ?>
                                </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-5"><b>Customer Email:</b></div>
                            <div class="col-md-7"><?php echo $model->email; ?></div>
                        </div>
                        <p></p>
                        <?php if($model->company != ''){ ?>
                            <div class="row">
                                <div class="col-md-5">
                                    <span><b>Company :</b></span>
                                </div>
                                <div class="col-md-7">
                                    <span><?php echo $model->company; ?></span>
                                </div>
                            </div>
                            <?php } ?>
                        <p></p>
                        <div class="row">
                            <div class="col-md-5">
                                <span><b>Order Status: </b></span>
                            </div>
                            <div class="col-md-7">
                                        <span>
                                            <?php if($model->order_status == 0){
                                                echo "<span class='label label-danger'>Canceled</span>";
                                            } else if($model->order_status == 2){
                                                echo "<span class='label label-warning'>Pending</span>";
                                            }
                                            else{
                                                echo "<span class='label label-success'>Success</span>";
                                            }?>
                                        </span>
                            </div>
                        </div><p></p>
                        <?php if($model->vat_number != ''){ ?>
                            <div class="row">
                                <div class="col-md-5">
                                    <span><b>Vat Number :</b></span>
                                </div>
                                <div class="col-md-7">
                                    <span><?php echo $model->vat_number; ?></span>
                                </div>
                            </div>
                            <?php } ?>
                        <p></p>
                        <div class="row">
                            <div class="col-md-5">
                                <span><b>Invoice Number: </b></span>
                            </div>
                            <div class="col-md-7">
                                <span><?php echo $model->invoice_number; ?>
</span>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-5">
                                <span><b>Grand Total: </b></span>
                            </div>
                            <div class="col-md-7">
                                <span>&euro; <?php echo round($model->netTotal, 3); ?></span>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-5">
                                <span><b>Subscription:</b></span>
                            </div>
                            <div class="col-md-7">
                                <span>
                                    <?php if($model->is_subscription_enabled == 0){
                                        echo "No";
                                    }
                                    else{
                                        echo "Yes";
                                    }?>
                                </span>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div  class="col-md-6">
                                <span><b>Structured communication:</b></span>
                            </div class="col-md-7">
                            <div>
                                <span>
                                    <?php echo $model->order_comment ?>
                                </span>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-5">
                                <span><b>Reference:</b></span>
                            </div>
                            <div class="col-md-7">
                                <span>
                                    <?php echo $model->order_comment ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div class="block block-bordered" style="border-color: #67809F;">
                        <div class="block-header" style="background-color: #67809F">
                            <h3 class="block-title"><font color="white"><i class="fa fa-cogs"></i> Payment Details</font></h3><br/>
                        </div>
                        <div class="block-content block-content-full">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <th>Payment Mode</th>
                                    <th>Payment Reference Id</th>
                                    <th>Amount</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($paymentModel as $value) { ?>
                                        <tr>
                                            <td><?= Payment::model()->findByPk($value->payment_mode)->gateway; ?></td>
                                            <td><?= $value->payment_ref_id; ?></td>
                                            <td>&euro; <?= round($value->total, 3); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="block block-bordered" style="border-color: #E26A6A;">
                        <div class="block-header" style="background-color: #E26A6A">
                            <h3 class="block-title"><font color="white"><i class="fa fa-cogs"></i> Billing Address</font> </h3><br/>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="h4 push-5"><b><?php echo $userName->full_name.","; ?></b></div>
                            <address>
                                <?php if($model->building){echo $model->building.",";} if($model->street){echo $model->street.","."<br>";}?>
                                <?php if($model->region){echo $model->region.","."<br>" ;}?>
                                <?php if($model->city){echo $model->city.",".$model->postcode.".";} ?>
                                <?= ServiceHelper::getCountryNameFromId($model->country); ?>
                                <?php if(!empty($userName)){ ?>
                                    <i class="fa fa-phone"></i><?php echo $userName->phone; ?><br>
                                    <i class="fa fa-envelope-o"></i> <a href="javascript:void(0)"><?php echo $userName->email; ?></a>
                                <?php } ?>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Order Details -->
        </div>

        <!-- END Page Content -->
        <div class="row">
            <div class="block block-bordered" style="border-color: #95A5A6;">
                <div class="block-header" style="background-color: #95A5A6;">
                    <h3 class="block-title"><font color="white"><i class="fa fa-cogs"></i> Shopping Cart</font></h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th  style="text-transform: capitalize;">ProductName</th>
                                <th  style="text-transform: capitalize;">SKU</th>
                                <th  style="text-transform: capitalize;">Quantity</th>
                                <th  style="text-transform: capitalize;">Discount</th>
                                <th  style="text-transform: capitalize;">Price</th>
                                <th  style="text-transform: capitalize;" width="31%">Comment</th>
                                <th  style="text-transform: capitalize;">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($itemModel as $key => $item){ ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo Yii::app()->createUrl('admin/productInfo/view').'/'.$item['product_id']; ?>" target="_blank">
                                        <?php echo $item['product_name']; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $item['product_sku']; ?></td>
                                    <td><?php echo $item['item_qty']; ?></td>
                                    <?php 
                                        $discount = (!empty($item['item_disc'])) ? $item['item_disc'] : 0;
                                        $total = $item['item_qty'] * $item['item_price'] - $discount;
                                    ?>
                                    <td>&euro; <?php echo $discount; ?></td>
                                    <td>&euro; <?php echo $item['item_price']; ?></td>
                                    <td><?php echo $item['comment']; ?></td>
                                    <td>&euro; <?php echo round($total, 3); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7"></div>
                <div class="col-lg-5">
                    <div class="well">
                        <div class="row static-info align-reverse">
                            <div class="col-md-8">
                                <span><b>Order Total: </b></span>
                            </div>
                            <div class="col-md-3 text-right">
                                <span>&euro; <?php echo round($model->orderTotal, 3); ?></span>
                            </div>
                        </div>
                        <div class="row static-info align-reverse">
                            <div class="col-md-8">
                                <span><b>Discount: </b></span>
                            </div>
                            <div class="col-md-3 text-right">
                                <span>&euro; <?php echo (!empty($model->discount)) ? $model->discount : 0; ?></span>
                            </div>
                        </div>
                        <?php 
                        if($model->vat != 0){
                            $vatpercent = $model->vat / ($model->orderTotal - $model->discount) * 100; ?>   
                            <div class="row static-info align-reverse">
                                <div class="col-md-8">
                                    <span><b>Vat(<?php echo round($vatpercent); ?>%): </b></span>
                                </div>
                                <div class="col-md-3 text-right">
                                    <span>&euro; <?php echo $model->vat; ?></span>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div class="row static-info align-reverse">
                                <div class="col-md-8">
                                    <span><b>Vat: </b></span>
                                </div>
                                <div class="col-md-3 text-right">
                                    <span>&euro; <?php echo $model->vat; ?></span>
                                </div>
                            </div>
                        <?php }?>
                        
                        <div class="row static-info align-reverse">
                            <div class="col-md-8">
                                <span><b>Net Total: </b></span>
                            </div>
                            <div class="col-md-3 text-right">
                                <span>&euro; <?php echo round($model->netTotal, 3); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="well">
                        <div class="row static-info align-reverse">
                            <div class="col-md-12">
                            We kindly request you to transfer the amount owed of <span>&euro; <b><?php echo round($model->netTotal, 3); ?></b></span> within the due date to IBAN BE85 0689 0467 8106 in the name of IrisCall, stating the invoice number.<br><br>

                            In case of non-payment by the due date, IrisCall will send you or the paying third party designated by you a reminder. From the second reminder, the customer will owe a reminder fee of EUR 12.10 including VAT to IrisCall. In addition, after termination of the services, the invoices that are not paid on time will be increased with conventional default interest at 10% on an annual basis, calculated from the due date until full payment, as well as with a 15% damage clause on the outstanding amounts with a minimum of 50.00 euros incl. VAT, without prejudice to IrisCall's right to claim a higher compensation, subject to proof of higher actual damage.<br><br>

                            If you have any questions about the invoice or payment, please contact ilka.vandebroeck@iriscall.be.<br><br>

                            IrisCall is a trade name of Force International CVBA.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
