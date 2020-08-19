<?php
$this->pageTitle = Yii::app()->name . '| Affiliates';
?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-container kt-container--fit  kt-container--fluid  kt-grid kt-grid--ver">
            <?php echo $this->renderPartial('aside',[]);  ?>
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                <!-- begin:: Subheader -->
                <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title">Affiliate Program </h3>
                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="<?= Yii::app()->createUrl('affiliate/softwaresales'); ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span> <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Software Sales</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->

                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="row">
                        <div class="col-md-4 col-xl-4">
                            <div class="kt-portlet kt-portlet--skin-solid kt-bg-primary kt-portlet--height-fluid">
                                <div class="kt-portlet__body">
                                    <div class="kt-portlet__content">
                                        <div class=" d-flex align-items-center">
                                            <h5>First Tier Clients</h5>
                                            <h3 class="ml-auto"><?= $levelOneChildCount; ?></h3>
                                        </div>
                                        <div class=" d-flex align-items-center">
                                            <h5>First Tier Licenses</h5>
                                            <h3 class="ml-auto"><?= $levelOneChildLicenseCount; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-4">
                            <div class="kt-portlet kt-portlet--skin-solid kt-bg-danger kt-portlet--height-fluid">
                                <div class="kt-portlet__body">
                                    <div class="kt-portlet__content">
                                        <div class=" d-flex align-items-center">
                                            <h5>Second Tier Clients</h5>
                                            <h3 class="ml-auto"><?= $levelTwoChildCount; ?></h3>
                                        </div>
                                        <div class=" d-flex align-items-center">
                                            <h5>Second Tier Licenses</h5>
                                            <h3 class="ml-auto"><?= $levelTwoChildLicenseCount; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-4">
                            <div class="kt-portlet kt-portlet--skin-solid kt-bg-success kt-portlet--height-fluid">
                                <div class="kt-portlet__body">
                                    <div class="kt-portlet__content d-flex align-items-center">
                                        <h2>Total<br>
                                            Commissions</h2>
                                        <h1 class="ml-auto">&euro;<?= $affiliateEarnings; ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            <div class="mb-1">First Level Users</div>
                                            <!-- <div class="small">Users that were directly registered through your affiliate link.</div> -->
                                        </h3>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <div class="table-responsive table-userlevels">
                                        <table role="table" class="table">
                                            <thead role="rowgroup" class="thead-light">
                                            <tr>
                                                <th width="60%" role="columnheader">Name</th>
                                                <th width="20%" role="columnheader">Clients</th>
                                                <th width="20%" role="columnheader">License</th>
                                            </tr>
                                            </thead>
                                            <tbody role="rowgroup">
                                                <?php foreach ($finalArr as $item=>$value) { ?>
                                                    <tr role="row" data-toggle="collapse" data-target="#row<?= $item; ?>" class="accordion-toggle">
                                                        <td role="cell">
                                                            <i class="fa fa-plus" style="color: #5e5e5f"></i>
                                                            <h6><?= $value['name']; ?><div class="small mt-1"><?= $value['email']; ?></div></h6>
                                                        </td>
                                                        <td role="cell"><?= $value['client_count'] ?></td>
                                                        <td role="cell"><?= $value['license_count']; ?><span class="text-success" style="font-size: initial">/<?= $value['active_license_count']; ?></span></td>
                                                    </tr>
                                                    <tr role="row">
                                                        <td colspan="4" class="hiddenRow">
                                                            <div class="accordian-body collapse" id="row<?= $item; ?>">
                                                                <table role="table" class="table table-sm">
                                                                    <?php if(count($value['inner_level']) > 0) { ?>
                                                                        <thead role="rowgroup">
                                                                        <tr>
                                                                            <th width="60%" role="columnheader"></th>
                                                                            <th width="20%" role="columnheader">Clients</th>
                                                                            <th width="20%" role="columnheader">Licenses</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody role="rowgroup">
                                                                            <?php foreach ($value['inner_level'] as $innerValue) { ?>
                                                                                <tr role="row">
                                                                                    <th role="cell"><?= $innerValue['name']; ?></th>
                                                                                    <td role="cell"><?= $innerValue['client_count']; ?></td>
                                                                                    <td role="cell"><?= $innerValue['license_count']; ?><span class="text-success" style="font-size: initial">/<?= $innerValue['active_license_count']; ?></span></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    <?php } ?>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
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
<script type="text/javascript">
    $('.accordion-toggle').click(function() {
        $(this).find('i').toggleClass('fas fa-plus fas fa-minus');
    });
</script>