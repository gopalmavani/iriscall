<!-- Main Container -->
<main id="main-container">
    <!-- Hero Content -->
    <div class="bg-image"  style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/plugins/img/photos/photo3@2x.jpg.jpg');">
        <div class="bg-primary-dark-op">
            <section class="content content-full content-boxed overflow-hidden">
                <!-- Section Content -->
                <div class="push-30-t push-30 text-center">
                    <h1 class="h2 text-white push-10 visibility-hidden" data-toggle="appear" data-class="animated fadeInDown"><?php echo $product->name?></h1>
                </div>
                <!-- END Section Content -->
            </section>
        </div>
    </div>
    <!-- END Hero Content -->
    <!-- e-Commerce Header -->
    <!--<div class="bg-white">
        <section class="content content-mini content-boxed">
            <div class="row items-push">
                <div class="col-xs-6 col-sm-9 text-right" style="float: right">
                    <button class="btn btn-default" type="button" data-toggle="layout" data-action="side_overlay_toggle">
                        <i class="fa fa-shopping-cart push-5-r"></i> <span class="hidden-xs">Cart</span> (3)
                    </button>
                    <button class="btn btn-default hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_open">
                        <i class="fa fa-navicon"></i>
                    </button>
                </div>
            </div>
        </section>
    </div>-->
    <!-- END e-Commerce Header -->

    <!-- Side Content and Product -->
    <div class="bg-gray-lighter">
        <section class="content content-boxed">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Product -->
                    <div class="block">
                        <div class="block-content">
                            <div class="row items-push">
                                <div class="col-sm-6">
                                    <!-- Images -->
                                    <div class="row js-gallery">
                                        <div class="col-xs-12 push-10">
                                            <a class="img-link" href="<?php echo Yii::app()->getBaseUrl(true) . $product->image; ?>">
                                                <img src="<?php echo Yii::app()->getBaseUrl(true) . $product->image; ?>" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END Images -->
                                </div>
                                <div class="col-sm-6">
                                    <!-- Vital Info -->
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            <span class="h2 font-w700 text-success">&euro; <?php echo $product->price; ?></span>
                                        </div>
                                        <span class="h5">
                                                        <span class="font-w600 text-success">IN STOCK</span><br><small>200 Available</small>
                                                    </span>
                                    </div>
                                    <!--<hr>
                                    <form class="form-inline" action="frontend_ecom_product.html" method="post" onsubmit="return false;">
                                        <button type="submit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus push-5-r"></i> Add to Cart</button>
                                        <select class="form-control input-sm" id="ecom-license" name="ecom-license" size="1">
                                            <option value="0" disabled selected>LICENSE</option>
                                            <option value="simple">Simple</option>
                                            <option value="multiple">Multiple</option>
                                        </select>
                                    </form>-->
                                    <hr>
                                    <div class="push-20">
                                        <a class="btn btn-sm btn-primary addCart"
                                           id="cart_<?php echo $product->product_id; ?>"
                                           href="javascript:void(0)">
                                            <i class="fa fa-plus"></i> Add to cart
                                        </a>

                                        <a class="btn btn-sm btn-default addWishlist pull-right"
                                           id="wishlist_<?php echo $product->product_id; ?>"
                                           href="javascript:void(0)">
                                            <i class="fa fa-plus"></i> Add to Wishlist
                                        </a>
                                    </div>


                                    <p><?php echo $product->description; ?></p>
                                    <!-- END Vital Info -->
                                </div>

                                <div class="col-xs-12">
                                    <!-- Author -->
                                    <div class="block block-rounded remove-margin-b">
                                        <div class="block-content block-content-full bg-gray-lighter clearfix">
                                            <div class="pull-right">
                                                <img class="img-avatar" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar2.jpg" alt="">
                                            </div>
                                            <div class="pull-left push-5-t">
                                                <div class="push-10">
                                                    Brand <a class="font-w600" href="javascript:void(0)">Apple computers</a>
                                                </div>
                                                <div>
                                                    <a class="btn btn-sm btn-default" href="javascript:void(0)"><i class="fa fa-plus push-5-r"></i> Follow</a>
                                                    <a class="btn btn-sm btn-default" href="javascript:void(0)"><i class="fa fa-envelope"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Author -->
                                </div>

                                <div class="col-xs-12">
                                    <!-- Extra Info -->
                                    <div class="block">
                                        <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs">
                                            <li class="active">
                                                <a href="#ecom-product-info">Info</a>
                                            </li>
                                            <li>
                                                <a href="#ecom-product-comments">Comments</a>
                                            </li>
                                            <li>
                                                <a href="#ecom-product-reviews">Reviews</a>
                                            </li>
                                        </ul>
                                        <div class="block-content tab-content">
                                            <!-- Info -->
                                            <div class="tab-pane pull-r-l active" id="ecom-product-info">
                                                <table class="table table-striped table-borderless remove-margin-b">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="2">File Formats</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td style="width: 20%;">Sketch</td>
                                                        <td>
                                                            <i class="fa fa-check text-success"></i>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PSD</td>
                                                        <td>
                                                            <i class="fa fa-check text-success"></i>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PDF</td>
                                                        <td>
                                                            <i class="fa fa-times text-danger"></i>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>AI</td>
                                                        <td>
                                                            <i class="fa fa-check text-success"></i>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>EPS</td>
                                                        <td>
                                                            <i class="fa fa-check text-success"></i>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped table-borderless remove-margin-b">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="2">Extra</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td style="width: 20%;"><i class="fa fa-calendar text-muted push-5-r"></i> Date</td>
                                                        <td>January 15, 2016</td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa fa-anchor text-muted push-5-r"></i> File Size</td>
                                                        <td>265.36 MB</td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="si si-vector text-muted push-5-r"></i> Vector</td>
                                                        <td>
                                                            <i class="fa fa-check text-success"></i>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa fa-expand text-muted push-5-r"></i> Dimensions</td>
                                                        <td>
                                                            <div class="push-5">16 x 16 px</div>
                                                            <div class="push-5">32 x 32 px</div>
                                                            <div class="push-5">64 x 64 px</div>
                                                            <div class="push-5">128 x 128 px</div>
                                                            <div>256 x 256 px</div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- END Info -->

                                            <!-- Comments -->
                                            <div class="tab-pane pull-r-l" id="ecom-product-comments">
                                                <div class="media push-15">
                                                    <div class="media-left">
                                                        <a href="javascript:void(0)">
                                                            <img class="img-avatar img-avatar32" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar3.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="media-body font-s13">
                                                        <a class="font-w600" href="javascript:void(0)">Lisa Gordon</a>
                                                        <mark class="font-w600 font-s13 text-danger">Purchased</mark>
                                                        <div class="push-5">High quality, thanks so much for sharing!</div>
                                                        <div class="font-s12">
                                                            <a href="javascript:void(0)">Like!</a> -
                                                            <a href="javascript:void(0)">Reply</a> -
                                                            <span class="text-muted"><em>12 min ago</em></span>
                                                        </div>
                                                        <div class="media push-10">
                                                            <div class="media-left">
                                                                <a href="javascript:void(0)">
                                                                    <img class="img-avatar img-avatar32" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar2.jpg" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="media-body font-s13">
                                                                <a class="font-w600" href="javascript:void(0)">Emma Cooper</a>
                                                                <mark class="font-w600 font-s13 text-success">Author</mark>
                                                                <div class="push-5">Thanks so much!!</div>
                                                                <div class="font-s12">
                                                                    <a href="javascript:void(0)">Like!</a> -
                                                                    <a href="javascript:void(0)">Reply</a> -
                                                                    <span class="text-muted"><em>20 min ago</em></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="media push-15">
                                                    <div class="media-left">
                                                        <a href="javascript:void(0)">
                                                            <img class="img-avatar img-avatar32" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar12.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="media-body font-s13">
                                                        <a class="font-w600" href="javascript:void(0)">Jeremy Fuller</a>
                                                        <mark class="font-w600 font-s13 text-danger">Purchased</mark>
                                                        <div class="push-5">Great work, thank you!</div>
                                                        <div class="font-s12">
                                                            <a href="javascript:void(0)">Like!</a> -
                                                            <a href="javascript:void(0)">Reply</a> -
                                                            <span class="text-muted"><em>30 min ago</em></span>
                                                        </div>
                                                        <div class="media push-10">
                                                            <div class="media-left">
                                                                <a href="javascript:void(0)">
                                                                    <img class="img-avatar img-avatar32" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar2.jpg" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="media-body font-s13">
                                                                <a class="font-w600" href="javascript:void(0)">Emma Cooper</a>
                                                                <mark class="font-w600 font-s13 text-success">Author</mark>
                                                                <div class="push-5">Thanks so much!!</div>
                                                                <div class="font-s12">
                                                                    <a href="javascript:void(0)">Like!</a> -
                                                                    <a href="javascript:void(0)">Reply</a> -
                                                                    <span class="text-muted"><em>20 min ago</em></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="media push-15">
                                                    <div class="media-left">
                                                        <a href="javascript:void(0)">
                                                            <img class="img-avatar img-avatar32" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar14.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="media-body font-s13">
                                                        <a class="font-w600" href="javascript:void(0)">John Parker</a>
                                                        <div class="push-5">Really nice!</div>
                                                        <div class="font-s12">
                                                            <a href="javascript:void(0)">Like!</a> -
                                                            <a href="javascript:void(0)">Reply</a> -
                                                            <span class="text-muted"><em>42 min ago</em></span>
                                                        </div>
                                                        <div class="media push-10">
                                                            <div class="media-left">
                                                                <a href="javascript:void(0)">
                                                                    <img class="img-avatar img-avatar32" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar2.jpg" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="media-body font-s13">
                                                                <a class="font-w600" href="javascript:void(0)">Emma Cooper</a>
                                                                <mark class="font-w600 font-s13 text-success">Author</mark>
                                                                <div class="push-5">Thanks so much!!</div>
                                                                <div class="font-s12">
                                                                    <a href="javascript:void(0)">Like!</a> -
                                                                    <a href="javascript:void(0)">Reply</a> -
                                                                    <span class="text-muted"><em>20 min ago</em></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form class="form-horizontal remove-margin-b" action="base_ui_timeline_social.html" method="post" onsubmit="return false;">
                                                    <input class="form-control" type="text" placeholder="Write a comment..">
                                                </form>
                                            </div>
                                            <!-- END Comments -->

                                            <!-- Reviews -->
                                            <div class="tab-pane pull-r-l" id="ecom-product-reviews">
                                                <!-- Average Rating -->
                                                <div class="block block-rounded">
                                                    <div class="block-content bg-gray-lighter text-center">
                                                        <p class="h2 text-warning push-10">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </p>
                                                        <p>
                                                            <strong>5.0</strong>/5.0 out of <strong>5</strong> Ratings
                                                        </p>
                                                    </div>
                                                </div>
                                                <!-- END Average Rating -->

                                                <!-- Ratings -->
                                                <div class="media push-15">
                                                    <div class="media-left">
                                                        <a href="javascript:void(0)">
                                                            <img class="img-avatar img-avatar32" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar12.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="media-body font-s13">
                                                                    <span class="text-warning">
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                    </span>
                                                        <a class="font-w600" href="javascript:void(0)">Ronald George</a>
                                                        <div class="push-5">Awesome Quality!</div>
                                                        <div class="font-s12">
                                                            <span class="text-muted"><em>2 hours ago</em></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="media push-15">
                                                    <div class="media-left">
                                                        <a href="javascript:void(0)">
                                                            <img class="img-avatar img-avatar32" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar2.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="media-body font-s13">
                                                                    <span class="text-warning">
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                    </span>
                                                        <a class="font-w600" href="javascript:void(0)">Laura Bell</a>
                                                        <div class="push-5">So cool badges!</div>
                                                        <div class="font-s12">
                                                            <span class="text-muted"><em>5 hours ago</em></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="media push-15">
                                                    <div class="media-left">
                                                        <a href="javascript:void(0)">
                                                            <img class="img-avatar img-avatar32" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar16.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="media-body font-s13">
                                                                    <span class="text-warning">
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                    </span>
                                                        <a class="font-w600" href="javascript:void(0)">Eugene Burke</a>
                                                        <div class="push-5">They look great, thank you!</div>
                                                        <div class="font-s12">
                                                            <span class="text-muted"><em>15 hours ago</em></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="media push-15">
                                                    <div class="media-left">
                                                        <a href="javascript:void(0)">
                                                            <img class="img-avatar img-avatar32" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar15.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="media-body font-s13">
                                                                    <span class="text-warning">
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                    </span>
                                                        <a class="font-w600" href="javascript:void(0)">Roger Hart</a>
                                                        <div class="push-5">Badges for life!</div>
                                                        <div class="font-s12">
                                                            <span class="text-muted"><em>20 hours ago</em></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="media push-15">
                                                    <div class="media-left">
                                                        <a href="javascript:void(0)">
                                                            <img class="img-avatar img-avatar32" src="<?php echo Yii::app()->getBaseUrl(true); ?>/plugins/img/avatars/avatar7.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="media-body font-s13">
                                                                    <span class="text-warning">
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                    </span>
                                                        <a class="font-w600" href="javascript:void(0)">Evelyn Willis</a>
                                                        <div class="push-5">So good, keep it up!</div>
                                                        <div class="font-s12">
                                                            <span class="text-muted"><em>22 hours ago</em></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END Ratings -->
                                            </div>
                                            <!-- END Reviews -->
                                        </div>
                                    </div>
                                    <!-- END Extra Info -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Product -->
                </div>
            </div>
        </section>
    </div>
    <!-- END Side Content and Product -->
</main>
<!-- END Main Container -->

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/magnific-popup/magnific-popup.min.js', CClientScript::POS_END); ?>