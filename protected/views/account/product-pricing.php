<h4 class="mb-10 font-weight-bold text-dark">Select your Tariff Plan</h4>
<div class="row">
    <div class="row justify-content-center">
    <?php foreach ($products as $product) { ?>
        <div class="col-md-4 col-xxl-2 border ribbon ribbon-right" style="margin: 0 10px">
            <div class="ribbon-target bg-primary" style="top: 10px; right: -2px; display: none" id="<?= $product['product_id'].'_ribbon' ?>">Selected</div>
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
                <button type="button" class="btn btn-primary text-uppercase font-weight-bolder" onclick="selectProduct(<?= $product['product_id'] ?>)">Select</button>
                <!--end::Content-->
            </div>
        </div>
    <?php } ?>
        <input type="text" class="form-control form-control-solid form-control-lg tariff_plan" name="tariff_plan" id="tariff_plan" hidden/>
</div>
</div>
<script type="text/javascript">
    function selectProduct(product_id) {
        $('.ribbon-target').hide();
        $('.tariff_plan').val(product_id);
        $('#'+product_id+'_ribbon').show();
    }
</script>