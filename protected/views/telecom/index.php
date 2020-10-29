<?php
$this->pageTitle = "Telecom dashboard";
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/datatables/datatables.bundle.css');
?>
<div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-2">
            <h5 class="text-dark font-weight-bold my-1 mr-5">Your Telecom Account</h5>
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
            <div class="d-flex align-items-center" id="kt_subheader_search">
                <span class="text-dark-50 font-weight-bold" id="kt_subheader_total"><?= $telecom_user->first_name.' '.$telecom_user->last_name ?></span>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <a href="<?= Yii::app()->createUrl('home/index') ?>" class="btn btn-default font-weight-bold">Back</a>
        </div>
    </div>
</div>
<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="card card-custom gutter-b">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-shrink-0 mr-7">
                        <div class="symbol symbol-50 symbol-lg-120">
                            <img alt="Pic" src="<?= Yii::app()->baseUrl . '/images/user.png' ?>" />
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex align-items-center justify-content-between flex-wrap" style="margin-top: 20px">
                            <!--begin::User-->
                            <div class="mr-3">
                                <div class="d-flex align-items-center mr-3">
                                    <a href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3"><?= $telecom_user->first_name.' '.$telecom_user->middle_name.' '.$telecom_user->last_name ?></a>
                                    <?php if($telecom_user->telecom_user_status == 1) { ?>
                                        <span class="label label-light-success label-inline font-weight-bolder mr-1"><?= ServiceHelper::getCycloneFieldLabel('telecom_user_status', $telecom_user->telecom_user_status) ?></span>
                                    <?php } else { ?>
                                        <span class="label label-light-danger label-inline font-weight-bolder mr-1"><?= ServiceHelper::getCycloneFieldLabel('telecom_user_status', $telecom_user->telecom_user_status) ?></span>
                                    <?php } ?>
                                </div>
                                <!--begin::Contacts-->
                                <div class="d-flex flex-wrap my-2">
                                    <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
															<span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
																		<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span><?= $telecom_user->email ?></a>
                                    <a href="#" class="text-muted text-hover-primary font-weight-bold">
															<span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Map/Marker2.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z" fill="#000000" />
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span><?= $telecom_user->city ?></a>
                                </div>
                                <!--end::Contacts-->
                                <div class="mb-10">
                                    <a href="<?= Yii::app()->createUrl('telecom/view').'/'.$telecom_user->id; ?>" class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-2">View More</a>
                                    <a href="<?= Yii::app()->createUrl('account/newconnection') ?>" class="btn btn-sm btn-success font-weight-bolder text-uppercase mr-2">Request New Account</a>
                                </div>
                            </div>
                            <!--begin::User-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Info-->
                </div>
            </div>
        </div>
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">All Your Telecom accounts
                        <span class="text-muted pt-2 font-size-sm d-block"></span></h3>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-checkable" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>Account type</th>
                        <th>Rate</th>
                        <th>Phone Number</th>
                        <th>Voice Mail</th>
                        <th>Tariff Plan</th>
                        <th>Activation Date</th>
                        <th>Request Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($telecom_accounts as $telecom_account) { ?>
                        <tr>
                            <td><?= $telecom_account->account_type; ?></td>
                            <td><?= $telecom_account->rate; ?></td>
                            <td><?= $telecom_account->phone_number; ?></td>
                            <?php if($telecom_account->is_voice_mail_enabled == 1) { ?>
                                <td><span class="label label-lg font-weight-bold label-light-primary label-inline">Enabled</span></td>
                            <?php } else { ?>
                                <td><span class="label label-lg font-weight-bold label-light-danger label-inline">Disabled</span></td>
                            <?php } ?>
                            <td><?= $telecom_account->tariff_plan; ?></td>
                            <?php if($telecom_account->activation_date != '') { ?>
                                <td><?= date('d M, y', strtotime($telecom_account->activation_date)); ?></td>
                            <?php } else { ?>
                                <td>Not Activated</td>
                            <?php } ?>
                            <?php if($telecom_account->telecom_request_status == 1) { ?>
                                <td><span class="label label-lg font-weight-bold label-light-primary label-inline"><?= ServiceHelper::getCycloneFieldLabel('telecom_request_status',$telecom_account->telecom_request_status) ?></span></td>
                            <?php } else { ?>
                                <td><span class="label label-lg font-weight-bold label-light-danger label-inline"><?= ServiceHelper::getCycloneFieldLabel('telecom_request_status',$telecom_account->telecom_request_status) ?></span></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?= Yii::app()->baseUrl . '/js/datatables/datatables.bundle.js' ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#kt_datatable').dataTable({
            "ordering": false,
            dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
        });
    });
</script>