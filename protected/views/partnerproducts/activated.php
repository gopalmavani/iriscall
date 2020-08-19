<?php $this->pageTitle = "Micromaxcash | Activated Products"; ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-container kt-container--fit  kt-container--fluid  kt-grid kt-grid--ver">
            <?php echo $this->renderPartial('/partnerproducts/partner-products-aside');  ?>
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                <!-- begin:: Subheader -->
                <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title">Partner Products </h3>
                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="<?= Yii::app()->createUrl('partnerproducts/activated'); ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <span class="kt-subheader__breadcrumbs-link">Affiliated Partners</span>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Activated Products</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <?php foreach ($products as $product) { ?>
                        <div class="kt-portlet">
                            <div class="kt-portlet__body">
                                <div class="row">
                                    <div class="col-4 col-sm-1 mb-4 mb-sm-0"> <img src="<?= Yii::app()->baseUrl.$product['image']; ?>" style="width: 100% !important; height: auto !important;"> </div>
                                    <div class="col-8 col-sm-4 mb-4 mb-sm-0">
                                        <h5><?= $product['name'] ?></h5>
                                        <div class="mb-3"><?= $product['description'] ?></div>
                                        <div><i>By NexiTrade</i></div>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <div class="row">
                                            <div class="col-8 col-lg-9">
                                                <h6>Invested Amount</h6>
                                            </div>
                                            <div class="col-4 col-lg-3 text-right"> &euro; <?= $product['deposited_amount']; ?> </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-lg-9">
                                                <h6>Initial Nodes Generated</h6>
                                            </div>
                                            <div class="col-4 col-lg-3 text-right"> <?= $product['nodes_generated']; ?> </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 text-right">
                                        <div class="kt-widget__name-label kt-font-boldest bg-success kt-font-light mb-3 d-inline-flex"><?= $product['short_description']; ?></div>
                                        <div><a href="<?= Yii::app()->createUrl('partnerproducts/view').'/'.$product['product_id']; ?>" class="btn btn-primary btn-sm btn-bold">View Details</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- For real estate -->
                    <!--<div class="kt-portlet">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-12 col-sm-2 mb-4 mb-sm-0">
                                    <div class="mb-3"><img src="<?/*= Yii::app()->baseUrl; */?>/images/logos/logo-ip-big.png" style="width: 80% !important; height: auto !important;"></div>
                                    <div class="mb-2"><i>offered by</i></div>
                                    <div><img src="<?/*= Yii::app()->baseUrl; */?>/images/logos/logo-tl.png" style="width: 80% !important; height: auto !important;"></div>
                                </div>
                                <div class="col-12 col-sm-4 offset-sm-1 mb-4 mb-sm-0">
                                    <div class="row">
                                        <div class="col-8">
                                            <h6>Project</h6>
                                        </div>
                                        <div class="col-4 text-right"> VAIOX </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <h6>Project Scope</h6>
                                        </div>
                                        <div class="col-4 text-right"> &euro; 6.000.000 </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <h6>Invested Amount</h6>
                                        </div>
                                        <div class="col-4 text-right"> &euro; 10.000 </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <h6>Initial Nodes Generated</h6>
                                        </div>
                                        <div class="col-4 text-right"> 10 </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 offset-sm-1"> <img src="<?/*= Yii::app()->baseUrl; */?>/images/img-product-vaiox.jpg" style="width: 100% !important; height: auto !important;"> </div>
                            </div>
                        </div>
                    </div>-->
                </div>
                <!-- end:: Content -->
            </div>
        </div>
    </div>
</div>