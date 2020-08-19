<?php $this->pageTitle = "Micromaxcash | Detailed Product View"; ?>
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
                        <a href="<?= Yii::app()->createUrl('partnerproducts/view').'/'.$product['product_id']; ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <span class="kt-subheader__breadcrumbs-link">Detailed Product View</span>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active"><?= $product['name']; ?></span>
                            </div>
                        </div>
                        <div class="kt-subheader__toolbar">
                            <div class="kt-subheader__wrapper"> <a href="<?= Yii::app()->createUrl('partnerproducts/activated'); ?>" class="btn btn-label-brand btn-bold btn-sm">Back</a></div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="kt-portlet">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-3 col-md-2 col-lg-1 col-xl-1 mb-4"> <img src="<?= Yii::app()->baseUrl.$product['image'] ?>" style="width: 100% !important; height: auto !important;"> </div>
                                <div class="col-12 col-md-7 col-lg-8 col-xl-9 mb-4 mb-sm-0">
                                    <div class="d-sm-flex align-items-end mb-3">
                                        <h2 class="mr-3 mb-3 mb-sm-0"><?= $product['name']; ?></h2>
                                        <span class="btn btn-label-success btn-sm">Premium Partner</span> </div>
                                    <div class="mb-4 d-sm-flex align-items-center">
                                        <div class="mr-4 mb-1"><i class="fas fa-globe mr-2"></i> <a href="<?= $product['asset_manager_link']; ?>" target="_blank"><?= $product['asset_manager_link']; ?></a></div>
                                        <div class="mr-4 mb-1"><i class="fas fa-user mr-2"></i>Managed Account</div>
                                    </div>
                                    <div>Automated trading products on the forex market. A combination of multiple Expert Advisors. The primary EA is an averaging system trading on 18 different currency pairs on conservative settings. The secondary one is a Price Action Strategy trading on multiple currency pairs on conservative settings. This can be joined by a third EA in relevant market conditions.</div>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3 col-xl-2 d-inline-flex align-items-start justify-content-end">
                                    <!-- <div class="kt-widget__name-label kt-font-boldest bg-success kt-font-light mb-3 d-inline-flex">CCV</div> -->
                                    <div><a href="<?= $product['asset_manager_link']; ?>" target="_blank" class="btn btn-label-brand btn-sm btn-bold">Visit Partner Webpage</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4">
                            <!--begin:: Widgets/MMC CB Details-->
                            <div class="kt-portlet kt-portlet--skin-solid kt-portlet-- kt-bg-primary w-cbdetails">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">MMC Cashback Details</h3>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th width="20%"> <h6>Customer Chain</h6>
                                            </th>
                                            <th width="20%"> <h6>Node Value</h6>
                                            </th>
                                            <th width="5%"> </th>
                                            <th width="20%"> <h6>Full Matrix Payout</h6>
                                            </th>
                                            <th width="5%"></th>
                                            <th width="16%"></th>
                                            <th width="5%"></th>
                                            <th width="9%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><div class="kt-widget__name-label kt-font-boldest bg-pink kt-font-light"><?= $product['short_description']; ?></div></td>
                                            <td><div class="kt-widget__name-label kt-font-boldest bg-orange kt-font-light">&euro; <?= $commissionData['node_value']; ?></div></td>
                                            <td><img src="<?= Yii::app()->baseUrl ?>/images/misc/arrow-orange.png"></td>
                                            <td><div class="kt-widget__name-label kt-font-boldest bg-orange kt-font-light">&euro; <?= $commissionData['full_payout']; ?></div></td>
                                            <td><i class="fas fa-plus"></i></td>
                                            <td><span class="node bg-blue"></span> <span class="node bg-pink"></span> <span class="node bg-green"></span> <span class="node bg-orange"></span> <span class="node bg-grey"></span></td>
                                            <td><i class="fas fa-plus"></i></td>
                                            <td><i class="fas fa-recycle"></i></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end:: Widgets/MMC CB Details-->

                            <!--begin:: Widgets/Customer Chain-->
                            <div class="kt-portlet w-customerchain">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">Customer Chain</h3>
                                    </div>
                                    <div class="kt-portlet__head-toolbar small"> Swim-lane Distributions </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <div class="row mb-2 chain chain1">
                                        <div class="col-4"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-blue">Cashback</span> </div>
                                        <div class="col-1"> <img src="<?= Yii::app()->baseUrl ?>/images/misc/arrow-blue.png"> </div>
                                        <div class="col-3"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-blue-light text-center">&euro; <?= $commissionData['Cashback earnings']['max_amount']; ?></span> </div>
                                        <div class="col-1"> <img src="<?= Yii::app()->baseUrl ?>/images/misc/arrow-blue-light.png"> </div>
                                        <div class="col-3"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-grey-light text-center">&euro; <?= $commissionData['Cashback earnings']['max_earnings']; ?> <i class="fas fa-recycle"></i></span> </div>
                                    </div>
                                    <div class="row mb-2 chain chain2">
                                        <div class="col-4"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-pink">Backup Cycle</span> </div>
                                        <div class="col-1"> <img src="<?= Yii::app()->baseUrl ?>/images/misc/arrow-pink.png"> </div>
                                        <div class="col-3"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-pink-light text-center">&euro; <?= $commissionData['Backup Cycle']['max_amount']; ?></span> </div>
                                        <div class="col-1"> <img src="<?= Yii::app()->baseUrl ?>/images/misc/arrow-pink-light.png"> </div>
                                        <div class="col-3"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-grey-light text-center">&euro; <?= $commissionData['Backup Cycle']['max_earnings']; ?></span> </div>
                                    </div>
                                    <div class="row mb-2 chain chain3">
                                        <div class="col-4"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-green">Corporate Account</span> </div>
                                        <div class="col-1"> <img src="<?= Yii::app()->baseUrl ?>/images/misc/arrow-green.png"> </div>
                                        <div class="col-3"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-green-light text-center">&euro; <?= $commissionData['Floating corporate']['max_amount']; ?></span> </div>
                                        <div class="col-1"> <img src="<?= Yii::app()->baseUrl ?>/images/misc/arrow-green-light.png"> </div>
                                        <div class="col-3"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-grey-light text-center">&euro; <?= $commissionData['Floating corporate']['max_earnings']; ?></span> </div>
                                    </div>
                                    <div class="row mb-2 chain chain4">
                                        <div class="col-4"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-orange">Upcycling</span> </div>
                                        <div class="col-1"> <img src="<?= Yii::app()->baseUrl ?>/images/misc/arrow-orange.png"> </div>
                                        <div class="col-3"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-orange-light text-center">&euro; <?= $commissionData['Upcycling']['max_amount']; ?></span> </div>
                                        <div class="col-1"> <img src="<?= Yii::app()->baseUrl ?>/images/misc/arrow-orange-light.png"> </div>
                                        <div class="col-3"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-grey-light text-center">&euro; <?= $commissionData['Upcycling']['max_earnings']; ?></span> </div>
                                    </div>
                                    <div class="row chain chain5">
                                        <div class="col-4"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-grey">FAN/GPA</span> </div>
                                        <div class="col-1"> <img src="<?= Yii::app()->baseUrl ?>/images/misc/arrow-grey.png"> </div>
                                        <div class="col-3"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-grey-light text-center">&euro; <?= $commissionData['FAN/GPA']['max_amount']; ?></span> </div>
                                        <div class="col-1"> <img src="<?= Yii::app()->baseUrl ?>/images/misc/arrow-grey-light.png"> </div>
                                        <div class="col-3"> <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--rounded d-block bg-grey-light text-center">&euro; <?= $commissionData['FAN/GPA']['max_earnings']; ?></span> </div>
                                    </div>
                                </div>
                            </div>
                            <!--end:: Widgets/Customer Chain-->

                            <!--begin:: Widgets/Node Options-->
                            <div class="kt-portlet kt-portlet--skin-solid kt-portlet-- kt-bg-info w-nodeoptions">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">Node Options</h3>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <div class="row">
                                        <div class="col-6 col-sm-3 mb-4 mb-0-md">
                                            <h6>Recycle-Up Node</h6>
                                            <i class="fas fa-check-circle bg-success"></i> </div>
                                        <div class="col-6 col-sm-3 mb-4 mb-0-md">
                                            <h6>Recycle-Down Node</h6>
                                            <i class="fas fa-minus-circle bg-danger"></i> </div>
                                        <div class="col-6 col-sm-3">
                                            <h6>Profit Nodes</h6>
                                            <i class="fas fa-check-circle bg-secondary"></i> </div>
                                        <div class="col-6 col-sm-3">
                                            <h6>Node Ownership</h6>
                                            <i class="bg-success"><span>FULL</span></i> </div>
                                    </div>
                                </div>
                            </div>
                            <!--end:: Widgets/Node Options-->

                        </div>
                        <div class="col-xl-8">
                            <!--begin::Portlet-->
                            <div class="kt-portlet">
                                <div class="kt-portlet__body">
                                    <ul class="nav nav-tabs  nav-tabs-line" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#kt_tabs_1_1" role="tab">Product Information</a> </li>
                                        <!--<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#kt_tabs_1_2" role="tab">Recent Updates</a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#kt_tabs_1_3" role="tab">Related Products</a> </li>-->
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="kt_tabs_1_1" role="tabpanel">
                                            <div class="mb-4"> Details coming soon
                                            </div>
                                        </div>
                                        <!--<div class="tab-pane" id="kt_tabs_1_2" role="tabpanel">
                                            <div class="table-responsive table-responsive2">
                                                <table role="table" class="table table-recentupdates">
                                                    <thead role="rowgroup" class="thead-light">
                                                    <tr>
                                                        <th role="columnheader">Posted on</th>
                                                        <th role="columnheader">Title</th>
                                                        <th role="columnheader">Version</th>
                                                        <th role="columnheader">Build Date</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody role="rowgroup">
                                                    <tr role="row">
                                                        <td role="cell">3 April, 2020</td>
                                                        <td role="cell">Lorem ipsum dolor sit amet, consectetur adipiscing elit</td>
                                                        <td role="cell">5.5.3</td>
                                                        <td role="cell">10 Jan, 2020</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td role="cell">29 March, 2020</td>
                                                        <td role="cell">Lorem ipsum dolor sit amet, consectetur adipiscing elit</td>
                                                        <td role="cell">5.5.2</td>
                                                        <td role="cell">02 Jan, 2020</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td role="cell">20 March, 2020</td>
                                                        <td role="cell">Lorem ipsum dolor sit amet, consectetur adipiscing elit</td>
                                                        <td role="cell">5.5.1</td>
                                                        <td role="cell">01 Jan, 2020</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td role="cell">10 March, 2020</td>
                                                        <td role="cell">Lorem ipsum dolor sit amet, consectetur adipiscing elit</td>
                                                        <td role="cell">5.5.0</td>
                                                        <td role="cell">20 Dec, 2019</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td role="cell">28 Feb, 2020</td>
                                                        <td role="cell">Lorem ipsum dolor sit amet, consectetur adipiscing elit</td>
                                                        <td role="cell">5.4.9</td>
                                                        <td role="cell">01 Dec, 2019</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td role="cell">20 March, 2020</td>
                                                        <td role="cell">Lorem ipsum dolor sit amet, consectetur adipiscing elit</td>
                                                        <td role="cell">5.5.1</td>
                                                        <td role="cell">01 Jan, 2020</td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td role="cell">10 March, 2020</td>
                                                        <td role="cell">Lorem ipsum dolor sit amet, consectetur adipiscing elit</td>
                                                        <td role="cell">5.5.0</td>
                                                        <td role="cell">20 Dec, 2019</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="kt_tabs_1_3" role="tabpanel">
                                            <div class="kt-pricing-1 kt-pricing-1--fixed">
                                                <div class="kt-pricing-1__items row">
                                                    <div class="kt-pricing-1__item col-lg-4">
                                                        <div class="kt-pricing-1__visual"> <img src="assets/media/products/nexiswift.png" style="width: auto !important; height: 150px !important;"> </div>
                                                        <span class="kt-pricing-1__price">NexiSwift</span> <span class="kt-pricing-1__description"> <span>One-time setup fee</span> <span>100% Automated Trading</span> <span>Fully hosted solution ('PAAS' model)</span> <span>Identical results</span> <span>Built-In security measures</span> </span>
                                                        <div class="kt-pricing-1__btn">
                                                            <button type="button" class="btn btn-secondary btn-bold btn-sm">Select Product</button>
                                                        </div>
                                                    </div>
                                                    <div class="kt-pricing-1__item col-lg-4">
                                                        <div class="kt-pricing-1__visual"> <img src="assets/media/products/neximax.png" style="width: auto !important; height: 150px !important;"> </div>
                                                        <span class="kt-pricing-1__price">NexiMax</span> <span class="kt-pricing-1__description"> <span>100% Automated trading</span> <span>Always StopLoss & TakeProfit</span> <span>Fully hosted solution ('PAAS' model)</span> <span>Yield based system</span> <span>Safety by diversification</span> </span>
                                                        <div class="kt-pricing-1__btn">
                                                            <button type="button" class="btn btn-secondary btn-bold btn-sm">Select Product</button>
                                                        </div>
                                                    </div>
                                                    <div class="kt-pricing-1__item col-lg-4">
                                                        <div class="kt-pricing-1__visual"> <img src="assets/media/products/nexisafe.png" style="width: auto !important; height: 150px !important;"> </div>
                                                        <span class="kt-pricing-1__price">NexiSafe</span> <span class="kt-pricing-1__description"> <span>Manual systems monitoring</span> <span>7 Years consistent backtest results</span> <span>Total insight</span> <span>One-time cost & Setup fee</span> <span>All security systems built-in</span> </span>
                                                        <div class="kt-pricing-1__btn">
                                                            <button type="button" class="btn btn-secondary btn-bold btn-sm">Select Product</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Portlet-->

                        </div>
                    </div>
                </div>
                <!-- end:: Content -->
            </div>
        </div>
    </div>
</div>