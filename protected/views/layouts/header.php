<div id="kt_header" class="header flex-column header-fixed">
    <div class="header-top">
        <div class="container">
            <div class="d-none d-lg-flex align-items-center mr-3">
                <!--begin::Logo-->
                <a href="<?= Yii::app()->createUrl('home/index'); ?>" class="mr-20">
                    <img alt="Logo" src="<?= Yii::app()->request->baseUrl ?>/images/logos/iriscall-logo-white.png" class="max-h-35px" />
                </a>
                <!--end::Logo-->
            </div>
            <!-- begin:: Header Topbar -->
            <div class="topbar">
                <div class="dropdown">
                    <!--begin::Toggle-->
                    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                        <div class="btn btn-icon btn-hover-transparent-white btn-dropdown btn-lg mr-1 pulse pulse-white">
												<span class="svg-icon svg-icon-xl">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
															<path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
														</g>
													</svg>
                                                    <!--end::Svg Icon-->
												</span>
                            <span class="pulse-ring"></span>
                        </div>
                    </div>
                    <!--end::Toggle-->
                    <!--begin::Dropdown-->
                    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                        <form>
                            <!--begin::Header-->
                            <div class="d-flex flex-column pt-12 bg-dark-o-5 rounded-top">
                                <!--begin::Title-->
                                <h4 class="d-flex flex-center">
                                    <span class="text-dark">User Notifications</span>
                                    <span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">0 new</span>
                                </h4>
                                <!--end::Title-->
                                <!--begin::Tabs-->
                                <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-primary mt-3 px-8" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_notifications">Alerts</a>
                                    </li>
                                </ul>
                                <!--end::Tabs-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Content-->
                            <div class="tab-content">
                                <!--begin::Tabpane-->
                                <div class="tab-pane active show p-8" id="topbar_notifications_notifications" role="tabpanel">
                                    <!--begin::Scroll-->
                                    <div class="scroll pr-7 mr-n7" data-scroll="true" data-height="300" data-mobile-height="200">
                                        <!--begin::Item-->
                                        <!--<div class="d-flex align-items-center mb-6">
                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
																	<span class="symbol-label">
																		<span class="svg-icon svg-icon-lg svg-icon-primary">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
																					<rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
																				</g>
																			</svg>
                                                                        </span>
																	</span>
                                            </div>
                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">First Notification</a>
                                                <span class="text-muted">Marketing campaign planning</span>
                                            </div>
                                        </div>-->
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Scroll-->
                                    <!--begin::Action-->
                                    <!--<div class="d-flex flex-center pt-7">
                                        <a href="#" class="btn btn-light-primary font-weight-bold text-center">See All</a>
                                    </div>-->
                                    <!--end::Action-->
                                </div>
                                <!--end::Tabpane-->
                            </div>
                            <!--end::Content-->
                        </form>
                    </div>
                    <!--end::Dropdown-->
                    <!--begin::My Cart-->
                    <div class="dropdown">
                        <!--begin::Toggle-->
                        <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                            <div class="btn btn-icon btn-hover-transparent-white btn-dropdown btn-lg mr-1">
												<span class="svg-icon svg-icon-xl">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
															<path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000" />
														</g>
													</svg>
                                                </span>
                            </div>
                        </div>
                        <!--end::Toggle-->
                        <!--begin::Dropdown-->
                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-xl dropdown-menu-anim-up">
                            <?php
                            $cartData = Yii::app()->db->createCommand()
                                ->select('c.product_id, c.cart_id, name, description, p.image, qty, amount')
                                ->from('cart c')
                                ->join('product_info p','c.product_id=p.product_id')
                                ->where('user_id=:uId', [':uId'=>Yii::app()->user->getId()])
                                ->queryAll();
                            ?>
                            <form>
                                <!--begin::Header-->
                                <div class="d-flex align-items-center py-10 px-8 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url('<?= Yii::app()->baseurl; ?>/images/misc/bg-1.jpg');">
													<span class="btn btn-md btn-icon bg-white-o-15 mr-4">
														<i class="flaticon2-shopping-cart-1 text-success"></i>
													</span>
                                    <h4 class="text-white m-0 flex-grow-1 mr-3">My Cart</h4>
                                    <button type="button" class="btn btn-success btn-sm"><?php echo count($cartData); ?> Items</button>
                                </div>
                                <!--end::Header-->
                                <!--begin::Scroll-->
                                <div class="scroll scroll-push" data-scroll="true" data-height="250" data-mobile-height="200">
                                    <?php
                                        if(!empty($cartData)){
                                            foreach ($cartData as $cartItem){   ?>
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center justify-content-between p-8 cart_item_<?= $cartItem['product_id']; ?>">
                                                    <div class="d-flex flex-column mr-2">
                                                        <a href="#" class="font-weight-bold text-dark-75 font-size-lg text-hover-primary"><?= $cartItem['name']; ?></a>
                                                        <span class="text-muted"><?= $cartItem['description']; ?></span>
                                                        <div class="d-flex align-items-center mt-2">
                                                            <span class="font-weight-bold mr-1 text-dark-75 font-size-lg">&euro; <?= $cartItem['amount']; ?></span>
                                                            <span class="text-muted mr-1">for</span>
                                                            <span class="font-weight-bold mr-2 text-dark-75 font-size-lg"><?= $cartItem['qty']; ?></span>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="symbol symbol-70 flex-shrink-0">
                                                        <img src="<?= Yii::app()->request->baseUrl . $cartItem['image']; ?>" style="width: auto !important; height: 60px !important;" title="" alt="" />
                                                    </a>
                                                    <div style="padding-right: 20px;padding-top: 20px;">
                                                        <a href="javascript:void(0)" class="pull-right" onclick="removeFromCart(<?= $cartItem['cart_id']; ?>,<?= $cartItem['product_id']; ?>)">
                                                            <i class="fa fa-times-circle"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Separator-->
                                                <div class="separator separator-solid"></div>
                                                <!--end::Separator-->
                                        <?php }
                                    } ?>
                                </div>
                                <!--end::Scroll-->
                                <!--begin::Summary-->
                                <?php if(!empty($cartData)) { ?>
                                    <div class="p-8">
                                        <!--<div class="d-flex align-items-center justify-content-between mb-4">
                                            <span class="font-weight-bold text-muted font-size-sm mr-2">Total</span>
                                            <span class="font-weight-bolder text-dark-50 text-right">$1840.00</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-7">
                                            <span class="font-weight-bold text-muted font-size-sm mr-2">Sub total</span>
                                            <span class="font-weight-bolder text-primary text-right">$5640.00</span>
                                        </div>-->
                                        <div class="text-right">
                                            <a href="<?php echo Yii::app()->createUrl('marketplace/checkout'); ?>" type="button" class="btn btn-primary text-weight-bold">Place Order</a>
                                        </div>
                                    </div>
                                <?php }?>
                                <!--end::Summary-->
                            </form>
                        </div>
                        <!--end::Dropdown-->
                    </div>
                    <!--end::My Cart-->
                    <div class="topbar-item">
                        <div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                            <div class="d-flex flex-column text-right pr-3">
                                <span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-md-inline">Hi,</span>
                                <span class="text-white font-weight-bolder font-size-sm d-none d-md-inline"><?= $user->full_name; ?></span>
                            </div>
                            <span class="symbol symbol-35">
                                <span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30"><?= substr($user->full_name, 0, 1); ?></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end:: Header Topbar -->
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <!-- begin: Header Menu -->
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                <div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
                    <ul class="menu-nav">

                        <li class="menu-item menu-item-submenu menu-item-rel">
                            <a href="<?= Yii::app()->createUrl('home/index'); ?>" class="menu-link">
                                <span class="menu-text">Dashboard</span>
                                <span class="menu-desc">Recent Updates &amp; Reports</span>
                                <i class="menu-arrow"></i>
                            </a>
                        </li>

                        <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="hover" aria-haspopup="true">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="menu-text">Affiliates</span>
                                <span class="menu-desc">Earnings</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-active" aria-haspopup="true">
                                        <a href="<?= Yii::app()->createUrl('affiliate/softwaresales'); ?>" class="menu-link">
                                            <span class="menu-text">Software Sales</span>
                                            <span class="menu-desc"></span>
                                        </a>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="<?= Yii::app()->createUrl('affiliate/promotiontools'); ?>" class="menu-link">
                                            <span class="menu-text">Promotion Tools</span>
                                            <span class="menu-desc"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="menu-item menu-item-submenu menu-item-rel">
                            <a href="<?= Yii::app()->createUrl('wallet/index'); ?>" class="menu-link">
                                <span class="menu-text">Wallet</span>
                                <span class="menu-desc">Recent Updates &amp; Reports</span>
                                <i class="menu-arrow"></i>
                            </a>
                        </li>
                        <li class="menu-item menu-item-submenu menu-item-rel">
                            <a href="<?= Yii::app()->createUrl('product/pricing'); ?>" class="menu-link">
                                <span class="menu-text">Telecom Products</span>
                                <span class="menu-desc">Tariff plans and packages</span>
                                <i class="menu-arrow"></i>
                            </a>
                        </li>
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