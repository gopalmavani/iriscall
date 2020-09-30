<style>
    .kt-active {
        background-color: #f5f6fc !important;
        color: #044e80 !important;
    }
    .kt-active:hover {
        color: #044e80 !important;
    }
</style>
<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
    <div class="kt-header__top">
        <div class="kt-container  kt-container--fluid ">

            <!-- begin:: Brand -->
            <div class="kt-header__brand kt-grid__item" id="kt_header_brand">
                <div class="kt-header__brand-logo">
                    <a href="#">
                        <img alt="Logo" src="<?= Yii::app()->request->baseUrl ?>/images/logos/iriscall-logo.svg" class="kt-header__brand-logo-default" />
                        <img alt="Logo" src="<?= Yii::app()->request->baseUrl ?>/images/logos/iriscall-logo.svg" class="kt-header__brand-logo-sticky" />
                    </a>
                </div>
            </div>
            <!-- end:: Brand -->

            <!-- begin:: Header Topbar -->
            <div class="kt-header__topbar">
                <!--begin: Cart -->
                <div class="kt-header__topbar-item dropdown">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,10px"> <span class="kt-header__topbar-icon"><i class="flaticon2-shopping-cart-1"></i></span> </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
                        <form>
                            <div class="kt-mycart">
                                <?php
                                $cartData = Yii::app()->db->createCommand()
                                    ->select('c.product_id, c.cart_id, name, description, p.image, qty, amount')
                                    ->from('cart c')
                                    ->join('product_info p','c.product_id=p.product_id')
                                    ->where('user_id=:uId', [':uId'=>Yii::app()->user->getId()])
                                    ->queryAll();
                                ?>
                                <div class="kt-mycart__head kt-head" style="background-image: url('<?= Yii::app()->baseurl; ?>/images/misc/bg-1.jpg');">
                                    <div class="kt-mycart__info"> <span class="kt-mycart__icon"><i class="flaticon2-shopping-cart-1 kt-font-success"></i></span>
                                        <h3 class="kt-mycart__title">My Cart</h3>
                                    </div>
                                    <div class="kt-mycart__button">
                                        <button type="button" id="cat_total_items" class="btn btn-secondary btn-sm" style=" "><?php echo count($cartData); ?> Items</button>
                                    </div>
                                </div>
                                <div class="kt-mycart__body kt-scroll" data-scroll="true" data-height="<?php if(!empty($cartData)){ ?>245<?php }?>" data-mobile-height="200">
                                    <?php
                                    if(!empty($cartData)){
                                        foreach ($cartData as $cartItem){?>
                                            <div class="kt-mycart__item cart_item_<?= $cartItem['product_id']; ?>">
                                                <div style="padding-right: 20px;padding-top: 20px;">
                                                    <a href="javascript:void(0)" class="pull-right" onclick="removeFromCart(<?= $cartItem['cart_id']; ?>,<?= $cartItem['product_id']; ?>)">
                                                        <i class="fa fa-times-circle"></i>
                                                    </a>
                                                </div>
                                                <div class="kt-mycart__container">
                                                    <div class="kt-mycart__info">
                                                        <a href="#" class="kt-mycart__title"><?= $cartItem['name']; ?></a>
                                                        <span class="kt-mycart__desc"> <?= $cartItem['description']; ?> </span>
                                                        <div class="kt-mycart__action">
                                                            <span class="kt-mycart__price_<?= $cartItem['product_id']; ?>">&euro; <?= $cartItem['amount']; ?></span>
                                                            <span class="kt-mycart__text">for</span>
                                                            <span class="kt-mycart__quantity_<?= $cartItem['product_id']; ?>"><?= $cartItem['qty']; ?></span>
                                                            <!--<a href="#" class="btn btn-label-success btn-icon">&minus;</a>
                                                            <a href="#" class="btn btn-label-success btn-icon">&plus;</a>-->
                                                        </div>
                                                    </div>
                                                    <a href="#" class="kt-mycart__pic"> <img src="<?= Yii::app()->request->baseUrl . $cartItem['image']; ?>" style="width: auto !important; height: 60px !important;"> </a> </div>
                                            </div>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <div class="kt-mycart__item empty_cat_body">
                                            <div class="kt-mycart__container">
                                                <p>Your cart is Empty</p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php
                                if(!empty($cartData)) {
                                    ?>
                                    <div class="kt-mycart__footer">
                                        <!--<div class="kt-mycart__section">
                                            <div class="kt-mycart__subtitel"> <span>Sub Total</span> <span>Taxes</span> <span>Total</span> </div>
                                            <div class="kt-mycart__prices"> <span>&euro; 13.000</span> <span>$ 72.00</span> <span class="kt-font-brand">&euro; 10.372</span> </div>
                                        </div>-->
                                        <div class="kt-mycart__button kt-align-right">
                                            <a href="<?php echo Yii::app()->createUrl('marketplace/checkout'); ?>"
                                               class="btn btn-primary btn-sm">Place Order</a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end: Cart-->

                <!--begin: Language bar -->
                <!--<div class="kt-header__topbar-item kt-header__topbar-item--langs">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,10px"> <span class="kt-header__topbar-icon"> <img class="" src="assets/media/flags/226-united-states.svg" alt="" /> </span> </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">
                        <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
                            <li class="kt-nav__item kt-nav__item--active"> <a href="#" class="kt-nav__link"> <span class="kt-nav__link-icon"><img src="assets/media/flags/226-united-states.svg" alt="" /></span> <span class="kt-nav__link-text">English</span> </a> </li>
                            <li class="kt-nav__item"> <a href="#" class="kt-nav__link"> <span class="kt-nav__link-icon"><img src="assets/media/flags/128-spain.svg" alt="" /></span> <span class="kt-nav__link-text">Spanish</span> </a> </li>
                            <li class="kt-nav__item"> <a href="#" class="kt-nav__link"> <span class="kt-nav__link-icon"><img src="assets/media/flags/162-germany.svg" alt="" /></span> <span class="kt-nav__link-text">German</span> </a> </li>
                        </ul>
                    </div>
                </div>-->
                <!--end: Language bar -->

                <!--begin: User bar -->
                <div class="kt-header__topbar-item kt-header__topbar-item--user">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,10px">
                        <span class="kt-header__topbar-welcome kt-visible-desktop">Hi,</span>
                        <span class="kt-header__topbar-username kt-visible-desktop"><?= $user->full_name; ?></span>
                        <img alt="Pic" src="<?= Yii::app()->request->baseUrl ?>/images/user.png" />
                        <span class="kt-header__topbar-icon kt-bg-brand kt-font-lg kt-font-bold kt-font-light kt-hidden">S</span>
                        <span class="kt-header__topbar-icon kt-hidden"><i class="flaticon2-user-outline-symbol"></i></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                        <!--begin: Head -->
                        <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                            <div class="kt-user-card__avatar"> <img class="kt-hidden-" alt="Pic" src="<?= Yii::app()->request->baseUrl ?>/images/user.png" />
                                <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span> </div>
                            <div class="kt-user-card__name"><?= $user->full_name; ?></div>
                            <!--<div class="kt-user-card__badge"> <span class="btn btn-label-primary btn-sm btn-bold btn-font-md">23 messages</span> </div>-->
                        </div>
                        <!--end: Head -->
                        <!--begin: Navigation -->
                        <div class="kt-notification">
                            <a href="<?php echo Yii::app()->createUrl('user/profile'); ?>" class="kt-notification__item">
                                <div class="kt-notification__item-icon"> <i class="flaticon2-calendar-3 kt-font-success"></i> </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold"> My Profile </div>
                                    <div class="kt-notification__item-time"> Account settings and more </div>
                                </div>
                            </a>
                            <?php if($user->role == 'Admin') { ?>
                                <a href="<?php echo Yii::app()->createUrl('admin/home/index'); ?>" class="kt-notification__item">
                                    <div class="kt-notification__item-icon"> <i class="flaticon-user-settings kt-font-warning"></i> </div>
                                    <div class="kt-notification__item-details">
                                        <div class="kt-notification__item-title kt-font-bold"> Go to Admin </div>
                                    </div>
                                </a>
                            <?php } ?>
                            <!--<a href="#" class="kt-notification__item">
                                <div class="kt-notification__item-icon"> <i class="flaticon2-rocket-1 kt-font-danger"></i> </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold"> My Activities </div>
                                    <div class="kt-notification__item-time"> Logs and notifications </div>
                                </div>
                            </a> <a href="#" class="kt-notification__item">
                                <div class="kt-notification__item-icon"> <i class="flaticon2-hourglass kt-font-brand"></i> </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold"> My Tasks </div>
                                    <div class="kt-notification__item-time"> latest tasks and projects </div>
                                </div>
                            </a> <a href="#" class="kt-notification__item">
                                <div class="kt-notification__item-icon"> <i class="flaticon2-cardiogram kt-font-warning"></i> </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold"> Billing </div>
                                    <div class="kt-notification__item-time"> billing & statements <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">2 pending</span> </div>
                                </div>
                            </a>-->
                            <div class="kt-notification__custom kt-space-between"> <a href="<?php echo Yii::app()->createUrl('home/logout'); ?>" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a> <!--<a href="#" target="_blank" class="btn btn-clean btn-sm btn-bold">Upgrade Plan</a>--> </div>
                        </div>
                        <!--end: Navigation -->
                    </div>
                </div>
                <!--end: User bar -->
            </div>
            <!-- end:: Header Topbar -->
        </div>
    </div>
    <div class="kt-header__bottom">
        <div class="kt-container  kt-container--fluid ">
            <!-- begin: Header Menu -->
            <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
            <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
                <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                    <ul class="kt-menu__nav">

                        <?php if(Yii::app()->controller->id == 'home' && Yii::app()->controller->action->id == 'index') { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="dashboard-link"><a href="<?= Yii::app()->createUrl('home/index'); ?>" class="kt-menu__link kt-active"><span class="kt-menu__link-text">Dashboard</span></a> </li>
                        <?php } else { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="dashboard-link"><a href="<?= Yii::app()->createUrl('home/index'); ?>" class="kt-menu__link"><span class="kt-menu__link-text">Dashboard</span></a> </li>
                        <?php } ?>

                        <?php if(Yii::app()->controller->id == 'account') { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="cashback-link"><a href="<?= Yii::app()->createUrl('account/index'); ?>" class="kt-menu__link kt-active"><span class="kt-menu__link-text">Cashback</span></a> </li>
                        <?php } else { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="cashback-link"><a href="<?= Yii::app()->createUrl('account/index'); ?>" class="kt-menu__link"><span class="kt-menu__link-text">Cashback</span></a> </li>
                        <?php } ?>

                        <?php if(Yii::app()->controller->id == 'partnerproducts') { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="partnerproducts-link"><a href="<?= Yii::app()->createUrl('partnerproducts/list'); ?>" class="kt-menu__link kt-active"><span class="kt-menu__link-text">Partner Products</span></a> </li>
                        <?php } else { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="partnerproducts-link"><a href="<?= Yii::app()->createUrl('partnerproducts/list'); ?>" class="kt-menu__link"><span class="kt-menu__link-text">Partner Products</span></a> </li>
                        <?php } ?>

                        <?php if(Yii::app()->controller->id == 'affiliate') { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="affiliateprogram-link"><a href="<?= Yii::app()->createUrl('affiliate/softwaresales'); ?>" class="kt-menu__link kt-active"><span class="kt-menu__link-text">Affiliate Program</span></a> </li>
                        <?php } else { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="affiliateprogram-link"><a href="<?= Yii::app()->createUrl('affiliate/softwaresales'); ?>" class="kt-menu__link"><span class="kt-menu__link-text">Affiliate Program</span></a> </li>
                        <?php } ?>

                        <?php if(Yii::app()->controller->id == 'wallet') { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="affiliateprogram-link"><a href="<?= Yii::app()->createUrl('wallet/index'); ?>" class="kt-menu__link kt-active"><span class="kt-menu__link-text">Wallet</span></a> </li>
                        <?php } else { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="affiliateprogram-link"><a href="<?= Yii::app()->createUrl('wallet/index'); ?>" class="kt-menu__link"><span class="kt-menu__link-text">Wallet</span></a> </li>
                        <?php } ?>

                        <?php if(Yii::app()->controller->id == 'marketplace') { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="wallet-link"><a href="<?= Yii::app()->createUrl('marketplace/index'); ?>" class="kt-menu__link kt-active kt-active"><span class="kt-menu__link-text">Marketplace</span></a> </li>
                        <?php } else { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="wallet-link"><a href="<?= Yii::app()->createUrl('marketplace/index'); ?>" class="kt-menu__link"><span class="kt-menu__link-text">Marketplace</span></a> </li>
                        <?php } ?>

                        <?php if(Yii::app()->controller->id == 'product') { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="wallet-link"><a href="<?= Yii::app()->createUrl('product/index'); ?>" class="kt-menu__link kt-active kt-active"><span class="kt-menu__link-text">Grid Licenses</span></a> </li>
                        <?php } else { ?>
                            <li class="kt-menu__item kt-menu__item--rel" id="wallet-link"><a href="<?= Yii::app()->createUrl('product/index'); ?>" class="kt-menu__link"><span class="kt-menu__link-text">Grid Licenses</span></a> </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <!-- end: Header Menu -->
        </div>
    </div>
</div>
<script>
    var base_url = '<?= Yii::app()->baseurl; ?>';
    function removeFromCart(cart_id,product_id){
        var url = "<?= Yii::app()->createUrl('marketplace/removefromcart'); ?>";
        var data = {
            'cart_id': cart_id,
            'product_id':product_id
        };
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (data) {
                var res = JSON.parse(data);
                if(res.token){
                    //$('.cart_item_'+product_id).css('display','none');
                    if(res.cartCount == 0){
                        $('.kt-mycart__body').html('<div class="kt-mycart__item empty_cat_body">\n' +
                            '<div class="kt-mycart__container">\n' +
                            '<p>Your cart is Empty</p>\n' +
                            '</div>\n' +
                            '</div>');
                        $('.proceed_btn_form').css('display','none');
                        $('#cat_total_items').html(res.cartCount+' Items');
                        $('.kt-mycart__button').css('display','none');
                        $('.kt-mycart__body').attr('data-height','60px');
                        $('.kt-mycart__body').css('height','60px');
                    }else{
                        $('.proceed_btn_form').css('display','block');
                        $('#cat_total_items').html(res.cartCount+' Items');
                        appendDataItemsToCart(res.cartData);
                    }
                }
            }
        });
    }


    //Update cart page UI
    function appendDataItemsToCart(cartDataArr) {
        var cart_div = '';
        $.each(cartDataArr, function(key,value) {

            var div = '<div class="kt-mycart__item cart_item_'+value.product_id+'">'+
                '<div style="padding-right: 20px;padding-top: 20px;">\n' +
                '<a href="javascript:void(0)" class="pull-right" onclick="removeFromCart('+value.cart_id+','+value.product_id+')">\n'+
                '<i class="fa fa-times-circle"></i>\n' +
                '</a>\n' +
                '</div>'+
                '<div class="kt-mycart__container">'+
                '<div class="kt-mycart__info">'+
                '<a href="#" class="kt-mycart__title">'+value.name+'</a>'+
                '<span class="kt-mycart__desc">'+value.description+'</span>'+
                '<div class="kt-mycart__action">'+
                '<span class="kt-mycart__price_'+value.product_id+'">&euro; '+value.amount+'</span>'+
                '<span class="kt-mycart__text">for</span>'+
                '<span class="kt-mycart__quantity_'+value.product_id+'">'+value.qty+'</span>'+
                '</div>'+
                '</div>'+
                '<a href="#" class="kt-mycart__pic"> <img src="'+value.image+'" style="width: auto !important; height: 60px !important;"> </a> </div></div>';

            cart_div += div;
        });
        $('.kt-mycart__body').html(cart_div);

    }

</script>