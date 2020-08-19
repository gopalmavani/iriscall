<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<main id="main-container">

    <div class="bg-image">
        <div class="bg-primary-dark-op">
            <section class="content content-full content-boxed overflow-hidden">
                <!-- Section Content -->
                <div class="push-30-t push-30 text-center">
                    <h1 class="h2 text-white push-10 visibility-hidden" data-toggle="appear" data-class="animated fadeInDown"><i class="fa fa-shopping-cart"></i> Checkout</h1>
                </div>
                <!-- END Section Content -->
            </section>
        </div>
    </div>
<section class="content content-boxed">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
                <!-- Products -->
                <div class="block" style="padding-bottom: 50px;">
                    <div class="block-header">
                        <h3 class="block-title">My Cart</h3>
                    </div>
                    <div class="block-content">
                        <table id="viewCartTable" style="display: block" class="table table-borderless table-vcenter">
                            <?php if ($cartItem) { ?>
                            <thead>
                            <tr>
                                <td style="width: 55px;" class="text-center font-w600">
                                    Action
                                </td>
                                <td style="width: 55px;" class="text-right ">

                                </td>
                                <td class="text-left font-w600" style="width: 55px;">
                                    Details
                                </td>

                                <td class="text-right">
                                    <div class="font-w600">Qty</div>
                                </td>
                                <td class="text-right">
                                    <div class="font-w600">Amount</div>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                                $count = 0;
                                foreach ($cartItem as $item) {
                                    $count++;
                                    ?>
                                        <tr id="product_<?php echo $item['product_id']; ?>">
                                            <td style="max-width: 55px;" class="text-center">
                                                <a class="text-danger removeCart" href="javascript:void(0)" id="remove_<?php echo $item['product_id']; ?>"><i class="fa fa-times"></i></a>
                                            </td>
                                            <td style="width: 55px;">
                                                <img src="<?php echo Yii::app()->getBaseUrl(true) . $item['product_image']; ?>" class="img-responsive">
                                            </td>
                                            <td style="width: 430px;">
                                                <a class="h5" href="frontend_ecom_product.html"><?php echo $item['product_name']; ?></a>
                                                <div class="font-s12 text-muted hidden-xs"><?php echo $item['product_summary']; ?></div>
                                            </td>
                                            <td class="text-right">
                                                <div class="font-w600">Qty - <?php echo $item['product_qty']; ?></div>
                                            </td>
                                            <td class="text-right">
                                                <div class="font-w600 text-success">&euro; <?php echo $item['product_price']; ?></div>
                                            </td>
                                        </tr>
                                <?php } ?>
                            <tr class="success">
                                <td class="text-right" colspan="4">
                                    <input type="hidden" id="cartTotalField" value="<?php echo $cartTotal; ?>" />
                                    <span class="h4 font-w600">Total</span>
                                </td>
                                <td class="text-right">
                                    <div class="h4 font-w600 text-success">&euro; <?php echo $cartTotal; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="5">
                                    <button class="btn placeOrder btn-sm btn-primary" type="button" data-dismiss="modal">Place Order</button>
                                </td>
                            </tr>
                            </tbody>
                            <?php }else{?>
                            <div class="block-content">
                                <div class="col-md-12">
                                    <div class="text-center text-primary font-w600">Your cart is empty</span>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                                <div id="EmptyCart" style="display: none;" class="col-md-12">
                                    <div class="text-center text-primary font-w600">Your wishlist is empty</span></div>
                                </div>
                        </table>
                    </div>
                </div>
                <!-- END Products -->
            </div>
        </div>
    </section>
    </main>


<?php
$order = RAND(1, 999);
$ogonepspid = 'OGONETEST';
$amount = 100;
$passphrasein = 'TESTPHASEIN';
$PSPID = $ogonepspid; //'OGONETEST';
$Price = $amount * 100;
$passphrase = $passphrasein;//'TESTPHASEIN';
$unique_id = RAND(890000, 895689596);
$baseUrl = Yii::app()->getBaseUrl(true);
$acceprtUrl = $baseUrl . "/order/success";
$cancelUrl = $baseUrl . "/order/cancel";
$declineUrl = $baseUrl . "/order/decline";
$exceptionUrl = $baseUrl . "/order/exception";

$Ogone_sha1 = "ACCEPTURL = " . $acceprtUrl . $passphrase .
    "AMOUNT=" . $Price . $passphrase .
    "CANCELURL= " . $cancelUrl . $passphrase .
    "CN=\"deepeak" . $passphrase .
    "CURRENCY=EUR" . $passphrase .
    "DECLINEURL= " . $acceprtUrl . $passphrase .
    "EMAIL=\"deepakvisani@gmail.com" . $passphrase .
    "EXCEPTIONURL= " . $exceptionUrl . $passphrase .
    "LANGUAGE=en_us" . $passphrase .
    "LOGO= \"http://localhost/cyclone/common/app2/Logo.png" . $passphrase .
    "OPERATION=SAL" . $passphrase .
    "ORDERID=" . $unique_id . $passphrase .
    "PSPID=" . $PSPID . $passphrase;

$Ogone_shaOut = "ACCEPTURL = " . $acceprtUrl . $passphrase .
    "CANCELURL= " . $cancelUrl . $passphrase .
    "CN=\"deepak" . $passphrase .
    "CURRENCY=EUR" . $passphrase .
    "DECLINEURL= " . $acceprtUrl . $passphrase .
    "EMAIL=\"deepakvisani@gmail.com" . $passphrase .
    "EXCEPTIONURL= " . $exceptionUrl . $passphrase .
    "LANGUAGE=en_us" . $passphrase .
    "LOGO= \"http://localhost/cyclone/common/app2/Logo.png" . $passphrase .
    "OPERATION=SAL" . $passphrase .
    "PSPID=" . $PSPID . $passphrase;

$Ogone_sha1 = sha1($Ogone_sha1);
$Ogone_sha_out = sha1($Ogone_shaOut);
?>

<form action="https://ogone.test.v-psp.com/ncol/test//orderstandard_utf8.asp" method="post" name="ogone"
      id="paymentSubmit">
    <input name="PSPID" type="hidden" value="deepak2499"/>
    <input name="ORDERID" id="orderId" type="hidden" value=""/>
    <input name="TITLE" id="title" type="hidden" value=""/>
    <input name="AMOUNT" id="orderAmount" type="hidden" value=""/>
    <input name="CURRENCY" type="hidden" value="EUR"/>
    <input name="LANGUAGE" type="hidden" value="en_us"/>
    <input name="USERID" type="hidden" value="<?php echo Yii::app()->user->getId(); ?>"/>
    <input name="CN" type="hidden" value="Deepak Visani1"/>
    <input name="EMAIL" type="hidden" value="deepakvisani1@gmail.com"/>
    <input name="OPERATION" type="hidden" value="SAL"/>
    <input name="SHASIGN" type="hidden" value="<?php echo $Ogone_sha1; ?>;"/>
    <input name="LOGO" type="hidden" value="Logo to be shown on page"/>


    <input name="acceptUrl" type="hidden" value="<?php echo $acceprtUrl; ?>"/>
    <input name="declineUrl" type="hidden" value="<?php echo $declineUrl; ?>"/>
    <input name="exceptionUrl" type="hidden" value="<?php echo $exceptionUrl; ?>"/>
    <input name="cancelurl" type="hidden" value="<?php echo $cancelUrl; ?>"/>
    <input name="submit" id="submitOgone" class="hide" type="submit" value="submit"/>
</form>

<script>

    var PlaceOrder = '<?php echo Yii::app()->createUrl('Order/PlaceOrder')?>';
    $('.placeOrder').click(function () {
        var cartValue = <?php echo $cartTotal; ?>;
        $('#orderAmount').val($('#cartTotalField').val() * 100);
        $('#title').val('Product Buy');
        $('#orderId').val('<?php
            $invoiceNo = 3071;
            $userDetail = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
            $OrderId = OrderInfo::model()->find(array('order' => 'order_info_id DESC'));
            //$model->attributes = $_POST['OrderInfo'];
            if ($OrderId == '') {
                echo $invoiceNo;
            } else {
                echo $OrderId['order_id'] + 1;
            }
            ?>');

        var formdata = {
            'amount': $('#cartTotalField').val(),
            'order_id': $('#orderId').val()
        };

        $.ajax({
            type: "POST",
            url: PlaceOrder,
            data: formdata,
            beforeSend: function () {
                $(".overlay").removeClass("hide");
            },
            success: function (data) {
                var res = jQuery.parseJSON(data);
                if (res.token == 1) {
                    $('#submitOgone').click();
                }
            }
        });
    });

    var RemoveFromCart = '<?php echo Yii::app()->createUrl('product/RemoveFromCart')?>';
    $('.removeCart').click(function () {
        alert($(this));
        var id = $(this).attr('id');
        var splitid = id.split("_");
        var id_no = splitid[1];

        var formdata = {
            'id': id_no
        };
        $.ajax({
            type: "POST",
            url: RemoveFromCart,
            data: formdata,
            /*beforeSend: function () {
             $(".overlay").removeClass("hide");
             },*/
            success: function (data) {
                var res = jQuery.parseJSON(data);

                if (res.token == 1) {
                    if (res.cartCount == 0 ){
                        $('#EmptyCart').show();
                        $('#viewCartTable').hide();
                    }

                    $('#product_'+res.id).hide();
                    $('#cart-count').html('<i class="fa fa-shopping-cart push-5-r"></i> <span class="hidden-xs">Cart</span>('+ res.cartCount + ')');
                    $('#cartTotalField').val(res.cartTotal);
                    $('#newTotal').html('€ '+res.cartTotal);
                    $('#shoppingCart').html('Shopping Cart ('+res.cartCount+')');
                }
            }
        });
    });
</script>


