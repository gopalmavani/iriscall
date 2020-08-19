<?php $this->pageTitle = "Micromaxcash | List of Partners"; ?>
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
                                <a href="<?= Yii::app()->createUrl('partnerproducts/list'); ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <span class="kt-subheader__breadcrumbs-link">Affiliated Partners</span>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">List of Partners</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="kt-portlet">
                        <div class="kt-portlet__body">
                            <div class="table-listofpartners">
                                <div class="table-responsive table-responsive3 mb-4">
                                    <table role="table" class="table">
                                        <thead role="rowgroup" class="thead-light">
                                        <tr>
                                            <th role="columnheader">Product</th>
                                            <th role="columnheader">Offered by</th>
                                            <th role="columnheader">MMC Commissioning</th>
                                            <!--<th role="columnheader">Date Added</th>-->
                                            <th role="columnheader">Type</th>
                                            <th role="columnheader">Dynamics</th>
                                            <th role="columnheader">Status</th>
                                            <th role="columnheader"></th>
                                        </tr>
                                        </thead>
                                        <tbody role="rowgroup">
                                            <?php foreach ($products as $product) { ?>
                                                <tr role="row">
                                                    <td role="cell">
                                                        <div class="d-flex">
                                                            <div class="mr-3"><img src="<?= Yii::app()->baseUrl.$product['image']; ?>" style="width: auto !important; height: 40px !important;"></div>
                                                            <div>
                                                                <h5><?= $product['name']; ?></h5>
                                                                <div><?= $product['description']; ?></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td role="cell">
                                                        <div class="d-flex">
                                                            <!--<div class="mr-3"></div>-->
                                                            <div class="text-center">
                                                                <img src="<?= Yii::app()->baseUrl.$product['asset_manager_logo']; ?>" style="width: auto !important; height: 40px !important;">
                                                                <h5><?= $product['asset_manager']; ?></h5>
                                                                <div><a href="<?= $product['asset_manager_link']; ?>" target="_blank"><?= $product['asset_manager_link']; ?></a></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td role="cell">
                                                        <div class="commissioning d-flex align-items-center">
                                                            <div class="kt-widget__name-label kt-font-boldest bg-primary kt-font-light d-inline-flex mr-1"><?= $product['short_description'] ?></div>
                                                            <?php if($product['agent'] == Yii::app()->params['NexiMaxAgent']) { ?>
                                                                <div class="kt-widget__name-label kt-font-boldest bg-secondary kt-font-light d-inline-flex mr-3">&euro; 1,5625</div>
                                                            <?php } else { ?>
                                                                <div class="kt-widget__name-label kt-font-boldest bg-secondary kt-font-light d-inline-flex mr-3">&euro; 6,75</div>
                                                            <?php } ?>
                                                            <div class="small">
                                                                <div class="d-flex">
                                                                    <div><span class="kt-badge kt-badge--warning kt-badge--dot mr-2"></span></div>
                                                                    <div>Recycling Up</div>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div><span class="kt-badge kt-badge--warning kt-badge--dot mr-2"></span></div>
                                                                    <div>Recycling Down</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <!--<td role="cell">Dec 1, 2016</td>-->
                                                    <td role="cell"><span class="btn btn-label-warning btn-sm small">Monthly Recurring</span></td>
                                                    <td role="cell small">
                                                        <div class="d-block">
                                                            <div><span class="text-success mr-2"><i class="far fa-check-circle"></i></span>Profit Nodes</div>
                                                            <div><span class="text-success mr-2"><i class="far fa-check-circle"></i></span>Full Beneficiary Ownership</div>
                                                        </div>
                                                    </td>
                                                    <td role="cell">
                                                        <?php if(CBMAccountHelper::getAccountStatus($product['group']) == 'Active') { ?>
                                                            <span class="kt-badge kt-badge--inline kt-badge--success">Active</span>
                                                        <?php } else {?>
                                                            <span class="kt-badge kt-badge--inline kt-badge--danger">Inactive</span>
                                                        <?php } ?>

                                                    </td>
                                                    <td role="cell"><a href="<?= Yii::app()->createUrl('partnerproducts/view').'/'.$product['product_id']; ?>" class="btn btn-primary btn-sm">View Details</a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Content -->
            </div>
        </div>
    </div>
</div>
