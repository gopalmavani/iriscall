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
                                <span><?php echo $model->netTotal; ?> &euro;</span>
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
                                            <td><?= $value->total; ?></td>
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
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($itemModel as $key => $item){ ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo Yii::app()->createUrl('admin/productInfo/view').'/'.$item['product_id']; ?>" target="_blank"><?php $Product_Name = ProductInfo::model()->findByAttributes(['product_id' => $item['product_id']]); 
                                        echo $Product_Name->name;
                                        ?>    
                                        </a>
                                    </td>
                                    <td><?php echo $item['product_sku']; ?></td>
                                    <td><?php echo $item['item_qty']; ?></td>
                                    <td><?php echo $item['item_disc']; ?></td>
                                    <td><?php echo $item['item_price']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6"></div>
                <div class="col-lg-6">
                    <div class="well">
                        <div class="row static-info align-reverse">
                            <div class="col-md-8">
                                <span><b>Order Total: </b></span>
                            </div>
                            <div class="col-md-3">
                                <span>&euro;<?php echo $model->orderTotal; ?></span>
                            </div>
                        </div>
                        <div class="row static-info align-reverse">
                            <div class="col-md-8">
                                <span><b>Discount: </b></span>
                            </div>
                            <div class="col-md-3">
                                <span>&euro;<?php echo $model->discount; ?></span>
                            </div>
                        </div>
                        <?php 
                        if($model->vat != 0){
                            $vatpercent = $model->vat / ($model->orderTotal - $model->discount) * 100; ?>   
                            <div class="row static-info align-reverse">
                                <div class="col-md-8">
                                    <span><b>Vat(<?php echo round($vatpercent); ?>%): </b></span>
                                </div>
                                <div class="col-md-3">
                                    <span>&euro;<?php echo $model->vat; ?></span>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div class="row static-info align-reverse">
                                <div class="col-md-8">
                                    <span><b>Vat: </b></span>
                                </div>
                                <div class="col-md-3">
                                    <span>&euro;<?php echo $model->vat; ?></span>
                                </div>
                            </div>
                        <?php }?>
                        
                        <div class="row static-info align-reverse">
                            <div class="col-md-8">
                                <span><b>Net Total: </b></span>
                            </div>
                            <div class="col-md-3">
                                <span>&euro;<?php echo $model->netTotal; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
