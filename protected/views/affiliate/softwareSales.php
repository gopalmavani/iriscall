<?php
$this->pageTitle = Yii::app()->name . '| Affiliates';
?>
<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Promotion Tools</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-muted">Affiliates</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= Yii::app()->createUrl('affiliate/softwaresales'); ?>" class="text-muted">Software Sales</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="d-flex flex-column-fluid" id="vue-div">
    <div class="container">
        <div class="row mt-0 mt-lg-3">
            <div class="col-xl-4">
                <div class="card card-custom gutter-b card-stretch">
                    <div class="card-header border-0 pt-5">
                        <div class="card-title font-weight-bolder">
                            <div class="card-label">First Tier Stats</div>
                        </div>
                    </div>
                    <div class="card-body p-0 d-flex flex-column">
                        <!--begin::Items-->
                        <div class="flex-grow-1 card-spacer">
                            <div class="row row-paddingless mt-5 mb-10">
                                <!--begin::Item-->
                                <div class="col">
                                    <div class="d-flex align-items-center mr-2">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0">
                                            <div class="symbol-label">
																		<span class="svg-icon svg-icon-lg svg-icon-info">
																			<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																					<path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000" />
																				</g>
																			</svg>
                                                                            <!--end::Svg Icon-->
																		</span>
                                            </div>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div>
                                            <div class="font-size-h4 text-dark-75 font-weight-bolder"><?= $levelOneChildCount; ?></div>
                                            <div class="font-size-sm text-muted font-weight-bold mt-1">Clients</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="col">
                                    <div class="d-flex align-items-center mr-2">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-45 symbol-light-danger mr-4 flex-shrink-0">
                                            <div class="symbol-label">
																		<span class="svg-icon svg-icon-lg svg-icon-danger">
																			<!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
																					<rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
																				</g>
																			</svg>
                                                                            <!--end::Svg Icon-->
																		</span>
                                            </div>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div>
                                            <div class="font-size-h4 text-dark-75 font-weight-bolder"><?= $levelOneChildLicenseCount; ?></div>
                                            <div class="font-size-sm text-muted font-weight-bold mt-1">Licenses</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                </div>
                                <!--end::Widget Item-->
                            </div>
                        </div>
                        <!--end::Items-->
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card card-custom gutter-b card-stretch">
                    <div class="card-header border-0 pt-5">
                        <div class="card-title font-weight-bolder">
                            <div class="card-label">Second Tier Stats</div>
                        </div>
                    </div>
                    <div class="card-body p-0 d-flex flex-column">
                        <!--begin::Items-->
                        <div class="flex-grow-1 card-spacer">
                            <div class="row row-paddingless mt-5 mb-10">
                                <!--begin::Item-->
                                <div class="col">
                                    <div class="d-flex align-items-center mr-2">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0">
                                            <div class="symbol-label">
																		<span class="svg-icon svg-icon-lg svg-icon-success">
																			<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																					<path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000" />
																				</g>
																			</svg>
                                                                            <!--end::Svg Icon-->
																		</span>
                                            </div>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div>
                                            <div class="font-size-h4 text-dark-75 font-weight-bolder"><?= $levelTwoChildCount; ?></div>
                                            <div class="font-size-sm text-muted font-weight-bold mt-1">Clients</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="col">
                                    <div class="d-flex align-items-center mr-2">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-45 symbol-light-danger mr-4 flex-shrink-0">
                                            <div class="symbol-label">
																		<span class="svg-icon svg-icon-lg svg-icon-danger">
																			<!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
																					<rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
																				</g>
																			</svg>
                                                                            <!--end::Svg Icon-->
																		</span>
                                            </div>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div>
                                            <div class="font-size-h4 text-dark-75 font-weight-bolder"><?= $levelTwoChildLicenseCount; ?></div>
                                            <div class="font-size-sm text-muted font-weight-bold mt-1">Licenses</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                </div>
                                <!--end::Widget Item-->
                            </div>
                        </div>
                        <!--end::Items-->
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col-xl-4">
                <!--begin::Mixed Widget 7-->
                <div class="card card-custom gutter-b card-stretch">
                    <div class="card-header border-0 pt-5">
                        <div class="card-title font-weight-bolder">
                            <div class="card-label">Total Commissions

                            </div>
                        </div>
                    </div>
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center py-1">
                            <!--begin:Pic-->
                            <div class="symbol symbol-80 symbol-light-success mr-5">
                                <span class="symbol-label">&euro;<?= $affiliateEarnings; ?></span>
                            </div>
                            <!--end:Pic-->
                            <!--begin:Title-->
                            <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
                                <a href="#" class="text-dark font-weight-bolder text-hover-primary font-size-h5">Affiliate Earnings</a>
                                <span class="text-muted font-weight-bold font-size-lg">Computed: seconds ago</span>
                            </div>
                            <!--end:Title-->
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 7-->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">First Level Users</span>
                            <span class="text-muted mt-3 font-weight-bold font-size-sm">Users that were directly registered through your affiliate link</span>
                        </h3>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2 pb-0 mt-n3">
                        <div class="tab-content mt-5" id="myTabTables11">
                            <!--begin::Table-->
                            <div class="table-responsive table-userlevels">
                                <table class="table table-bordered table-vertical-center">
                                    <thead>
                                    <tr>
                                        <th class="p-0 w-40px"></th>
                                        <th class="p-0 min-w-200px">Name</th>
                                        <th class="p-0 min-w-200px">Clients</th>
                                        <th class="p-0 min-w-100px">License</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($finalArr as $item=>$value) { ?>
                                        <tr role="row" data-toggle="collapse" data-target="#row<?= $item; ?>" class="accordion-toggle">
                                            <td role="cell">
                                                <div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0">
                                                    <div class="symbol-label">
                                                        <span class="svg-icon svg-icon-lg svg-icon-success"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo9\dist/../src/media/svg/icons\Code\Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                                                <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
                                                            </g>
                                                        </svg><!--end::Svg Icon--></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td role="cell">
                                                <span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?= $value['name']; ?></span>
                                                <div><?= $value['email']; ?></div>
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
                            <!--end::Table-->
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.accordion-toggle').click(function() {
        $(this).find('i').toggleClass('fas fa-plus fas fa-minus');
    });
</script>