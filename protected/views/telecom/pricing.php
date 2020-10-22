<?php
$this->pageTitle = "View Product pricing";
?>
<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Products</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="<?= Yii::app()->createUrl('product/pricing'); ?>" class="text-muted">Product pricing</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="d-flex flex-column-fluid" id="vue-div">
    <div class="container">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-chart text-primary"></i>
                    </span>
                    <h3 class="card-label">Product Pricing</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center my-20">
                    <?php foreach ($products as $product) { ?>
                        <div class="col-md-4 col-xxl-3">
                            <div class="pt-30 pt-md-25 pb-15 px-5 text-center">
                                <!--begin::Icon-->
                                <div class="d-flex flex-center position-relative mb-25">
														<span class="svg svg-fill-primary opacity-4 position-absolute">
															<svg width="175" height="200">
																<polyline points="87,0 174,50 174,150 87,200 0,150 0,50 87,0" />
															</svg>
														</span>
                                    <span class="svg-icon svg-icon-5x svg-icon-primary">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Flower3.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24" />
																	<path d="M1.4152146,4.84010415 C11.1782334,10.3362599 14.7076452,16.4493804 12.0034499,23.1794656 C5.02500006,22.0396582 1.4955883,15.9265377 1.4152146,4.84010415 Z" fill="#000000" opacity="0.3" />
																	<path d="M22.5950046,4.84010415 C12.8319858,10.3362599 9.30257403,16.4493804 12.0067693,23.1794656 C18.9852192,22.0396582 22.5146309,15.9265377 22.5950046,4.84010415 Z" fill="#000000" opacity="0.3" />
																	<path d="M12.0002081,2 C6.29326368,11.6413199 6.29326368,18.7001435 12.0002081,23.1764706 C17.4738192,18.7001435 17.4738192,11.6413199 12.0002081,2 Z" fill="#000000" opacity="0.3" />
																</g>
															</svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Content-->
                                <span class="font-size-h1 d-block d-block font-weight-boldest text-dark-75 py-2"><?= $product['price']; ?><sup class="font-size-h3 font-weight-normal pl-1">&euro;</sup></span>
                                <h4 class="font-size-h6 d-block d-block font-weight-bold mb-7 text-dark-50"><?= $product['name']; ?></h4>
                                <p class="mb-15 d-flex flex-column">
                                    <span>Lorem ipsum dolor sit amet edipiscing elit</span>
                                    <span>sed do eiusmod elpors labore et dolore</span>
                                    <span>magna siad enim aliqua</span>
                                </p>
                                <?php if($first_account) { ?>
                                    <a href="<?= Yii::app()->createUrl('account/create') . '?tariff_product_id='.$product['product_id'] ?>" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">Purchase</a>
                                <?php } else { ?>
                                    <a href="<?= Yii::app()->createUrl('account/newconnection') . '?tariff_product_id='.$product['product_id'] ?>" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">Purchase</a>
                                <?php } ?>
                                <!--end::Content-->
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

</script>