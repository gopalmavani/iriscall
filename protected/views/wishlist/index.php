<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<main id="main-container">

    <div class="bg-image" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/plugins/img/photos/photo3@2x.jpg.jpg');">
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
            <div class="alert alert-success hide" id="delete" align="center">
                <h4>Product removed successfully</h4>
            </div>
            <div class="alert alert-success hide" id="add" align="center">
                <h4>Product moved into cart successfully</h4>
            </div>
            <div class="col-sm-8 col-sm-offset-2">
                <!-- Products -->
                <div class="block" style="padding-bottom: 50px;">
                    <div class="block-header">
                        <h3 class="block-title">My Wishlist <b>(<?php echo ($wishlist) ? count($wishlist) : 0 ; ?>)</b></h3>
                    </div>
                    <div class="block-content">
                        <table id="wishTable" style="display: block;" class="table table-borderless table-vcenter">
                            <?php
                            if ($wishlist) { ?>
                            <thead>
                            <tr>
                                <td style="width: 55px;" class="text-center font-w600">
                                    #
                                </td>
                                <td style="width: 55px;" class="text-right ">

                                </td>
                                <td class="text-left font-w600" style="width: 55px;">Details</td>

                                <td class="text-right">
                                    <div class="font-w600">Amount</div>
                                </td>
                                <td class="text-left font-w600" style="width: 55px;"></td>
                                <td class="text-left font-w600" style="width: 55px;"></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count = 0;
                            foreach ($wishlist as $item) {
                                $count++;
                                ?>
                                <tr id="trBox_<?php echo $item['product_id']; ?>">
                                    <td style="max-width: 55px;" class="text-center">
                                        <?php echo $count; ?>
                                    </td>
                                    <td style="width: 55px;">
                                        <img src="<?php echo Yii::app()->getBaseUrl(true) . $item['product_image']; ?>" class="img-responsive">
                                    </td>
                                    <td style="width: 200px;">
                                        <a href="<?php echo Yii::app()->createUrl('product/detail/' . $item['product_id']); ?>"><?php echo $item['product_name']; ?></a>
                                        <div class="font-s12 text-muted hidden-xs"><?php echo $item['product_summary']; ?></div>
                                    </td>

                                    <td class="text-right">
                                        <div class="font-w600 text-success">&euro; <?php echo $item['product_price']; ?></div>
                                    </td>
                                    <td width="15%">
                                        <a class="h5 moveCart btn btn-primary" id="moveTocart_<?php echo $item['product_id']; ?>" href="javascript:void(0);">Move to cart</a>
                                    </td>
                                    <td width="15%">
                                        <a class="h5 rwishlist btn btn-primary" id="removeWishlist_<?php echo $item['product_id']; ?>" href="javascript:void(0);">Remove</a>
                                    </td>
                                </tr>
                            <?php }
                            }else{?>
                                <div class="col-md-12">
                                    <div class="text-center text-primary font-w600">Your wishlist is empty</span></div>
                                </div>
                            <?php } ?>
                            <div id="EmptyWish" style="display: none;" class="col-md-12">
                                <div class="text-center text-primary font-w600">Your wishlist is empty</span></div>
                            </div>
                            <!--<tr>
                                <td class="text-right" colspan="6">
                                    <button class="btn moveAllTocart btn-sm btn-primary" type="button" data-dismiss="modal">Move to cart</button>
                                </td>
                            </tr>-->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END Products -->
            </div>
        </div>
    </section>
</main>

<script>
    var RemoveCart = '<?php echo Yii::app()->createUrl('Wishlist/RemoveCart')?>';
    $('.rwishlist').click(function () {
        var str = $(this).attr('id');
        var id = str.split('_');

        var formdata = {
            'id': id[1]
        };

        $.ajax({
            type: "POST",
            url: RemoveCart,
            data: formdata,
            beforeSend: function () {
                $(".overlay").removeClass("hide");
            },
            success: function (data) {
                var res = jQuery.parseJSON(data);
                if (res.token == 1) {
                    if (res.wishCount == 0){
                        $('#wishTable').hide();
                        $('#EmptyWish').show();
                    }
                    $("#delete").removeClass("hide");
                    setTimeout(
                        function()
                        {
                            $("#delete").addClass("hide");
                        }, 5000);
                    $('#trBox_'+res.id).hide();
                    $(".overlay").addClass("hide");
                }
            }
        });
    });

    var AddCart = '<?php echo Yii::app()->createUrl('Wishlist/AddToCart')?>';
    $('.moveCart').click(function () {
        var str = $(this).attr('id');
        var id = str.split('_');

        var formdata = {
            'id': id[1],
        };

        $.ajax({
            type: "POST",
            url: AddCart,
            data: formdata,
            beforeSend: function () {
                $(".overlay").removeClass("hide");
            },
            success: function (data) {
                var res = jQuery.parseJSON(data);
                if (res.token == 1) {
                    $('#trBox_' + id[1]).hide();
                    $("#add").removeClass("hide");
                    setTimeout(
                        function()
                        {
                            $("#add").addClass("hide");
                        }, 5000);
                    if ($(".overlay").addClass("hide")) {
//                        alert(res.msg);
                        window.location.reload();
                    }
                }
            }
        });
    });
</script>


