<?php /* @var $this Controller */
Yii::import('application.components.NavCheck');

$limit = 20;
$notifications = NotificationHelper::ShowNotiticationLimit();
$notificationsVpamm = NotificationHelper::ShowNotiticationVpamm();

$todaydate = strtotime(date('Y-m-d H:i:s'));
$folder = Yii::app()->params['basePath'];
?>
<style>
    .nav-main a > i{
        min-width: 15px;
    }
</style>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <?php
    Yii::app()->clientScript->registerCssFile('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/css/bootstrap.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/css/oneui.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/select2/dist/css/select2.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/css/jquery.treegrid.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/adminStyle.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/fullcalendar/fullcalendar.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/slick/slick.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/slick/slick-theme.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/font-awesome-4.7.0/css/font-awesome.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/fontawesome-iconpicker.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/nested-menu/jqtree.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/footable/css/footable.core.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/css/custom.css?v=1');
    ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logos/iriscall-favicon.png">

    <title><?php echo ucfirst(Yii::app()->params['applicationName']); ?></title>
</head>
<body>
<div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">
    <!-- Side Overlay-->
   <aside id="side-overlay">
                <!-- Side Overlay Scroll Container -->
                <div id="side-overlay-scroll">
                    <!-- Side Header -->
                    <div class="side-header side-content">
                        <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                        <button class="btn btn-default pull-right" type="button" data-toggle="layout" data-action="side_overlay_close">
                            <i class="fa fa-times"></i>
                        </button>
                        <span>
                            <span class="font-w600 push-10-l">Notifications</span>
                        </span>
                    </div>
                    <!-- END Side Header -->

                    <!-- Side Content -->
                    <div class="side-content remove-padding-t">
                        <!-- Side Overlay Tabs -->
                        <div class="block pull-r-l border-t">
                            <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs">
                                <li class="active">
                                    <a href="#tabs-side-overlay-overview"><i class="fa fa-cart-plus"></i> General</a>
                                </li>
                                <li>
                                    <a href="#tabs-side-overlay-sales"><i class="fa fa-fw fa-line-chart"></i> VPAMM</a>
                                </li>
                            </ul>
                            <div class="block-content tab-content">
                                <!-- Overview Tab -->
                                <div class="tab-pane fade fade-right in active" id="tabs-side-overlay-overview">
                                    <!-- Activity -->
                                    <div class="block pull-r-l">
                                        <?php if (count(NotificationHelper::ShowNotiticationLimit()) > 0){ ?>
                                            <a href="javascript:void(0);" data-id="0" class="pull-right deleteAllGeneral" style="margin-right: 20px;">
                                                Clear All
                                            </a>
                                            <br>
                                        <?php } ?>
                                        <div class="block-content" id="order-noti">

                                            <!-- Activity List -->
                                            <ul class="list list-activity" id="alert-notify">
                                                <?php if ($notifications) {
                                                $i = 0; ?>

                                            <!-- <div id="style-10" class="scroll-notification"> -->
                                            <?php
                                            foreach ($notifications as $notification) {
                                                $i++;
                                                $highlight = "background:#f9f9f9;"
                                                ?>
                                                <li id="<?= $notification->id; ?>">
                                                    <i class="si si-wallet text-success"></i>
                                                    <div>
                                                        <a href="<?php echo Yii::app()->createUrl('admin/userInfo/view/'.
                                                        $notification->sender_Id); ?>"><?php echo NotificationHelper::  ShowNotiticationUserName($notification->sender_Id); ?></a>
                                                        <a href="javascript:void(0);" class="pull-right "><i class="fa fa-times delete delete_notify" id="notify_<?= $notification->id; ?>"></i></a>
                                                    </div>
                                                    <?php $amount = explode(" ",$notification->body_html); ?>
                                                    <div class="font-w600">
                                                        placed an <a href="<?php echo $notification->url; ?>">order of <?php print_r($amount[4]); ?></a>
                                                    </div>
                                                    <div><small class="text-muted"><?php echo NotificationHelper::time_elapsed_string($notification->created_at); ?></small></div>
                                                </li>

                                            <?php } ?>
                                        <!-- </div> -->
                                    <?php }else{?>
                                        <li class="notify" style="border-bottom:1px solid lightgrey;padding: 0px 10px 0px 10px;">
                                            <p style="text-align: center; margin-top: 40px !important;">No notification</p>
                                        </li>
                                    <?php } ?>
                                            </ul>
                                            <!-- END Activity List -->
                                        </div>
                                        <div class="block-header bg-gray-lighter">
                                            <ul class="block-options">
                                                <li>
                                                    <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo">
                                                        <!-- <i class="si si-refresh"></i> -->
                                                    </button>
                                                </li>

                                                <!-- <li>
                                                    <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                                                </li> -->

                                            </ul>
                                            <?php if (count(NotificationHelper::ShowNotiticationLimit()) > 0){ ?>
                                                <a align="Center" href="<?= Yii::app()->createUrl('admin/notificationManager/view'); ?>">
                                                    <h3 class="block-title">
                                                        View all
                                                    </h3>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- END Activity -->

                                </div>
                                <!-- END Overview Tab -->

                                <!-- Sales Tab -->
                                <div class="tab-pane fade fade-left" id="tabs-side-overlay-sales">
                                    <div class="block pull-r-l">
                                        <?php if (count(NotificationHelper::ShowNotiticationVpamm()) > 0){ ?>
                                            <a href="javascript:void(0);" class="pull-right deleteall deleteAllVpamm"  style="margin-right: 20px;">
                                               Clear All
                                            </a>
                                            <br>
                                        <?php } ?>
                                        <div class="block-content">

                                             <ul class="list list-activity pull-r-l" id="vapamm-notify">

                                                 <?php if ($notificationsVpamm) {
                                                    $i = 0; ?>
                                                 <!-- <div id="style-10" class="scroll-notification"> -->
                                                 <?php
                                                 foreach ($notificationsVpamm as $notification) {
                                                     $i++;
//                                                     if($notification->type_of_notification == 'deposit'){

                                                 $highlight = "background:#f9f9f9;"
                                                 ?>
                                                <li id="<?= $notification->id; ?>">
                                                    <i class="si si-wallet text-success"></i>
                                                    <?php $amount = explode(" ",$notification->body_html); ?>
                                                    <div><a href="<?php echo Yii::app()->createUrl('admin/userInfo/view/'.
                                                            $notification->sender_Id); ?>"></a>
                                                        <a href="javascript:void(0);" class="pull-right" style="margin-right: 15px;"><i class="fa fa-times delete delete_notify" id="notify_<?= $notification->id; ?>"></i></a>
                                                    </div>
                                                    <?php $amount = explode(" ",$notification->body_html); ?>
                                                    <div class="font-w600">
                                                        <a href="<?php echo $notification->url; ?>"> <?php echo $notification->body_html; ?></a>
                                                    </div>
                                                    <div><small class="text-muted"><?php echo NotificationHelper::time_elapsed_string($notification->created_at); ?></small></div>
                                                </li>
                                                <?php //} ?>
<!--                                                <li>-->
<!--                                                    <i class="fa fa-circle text-success"></i>-->
<!--                                                    <div class="font-w600">New sale! + $129</div>-->
<!--                                                    <div><small class="text-muted">50 min ago</small></div>-->
<!--                                                </li>-->
                                            <?php } ?>
                                                     <?php }else{?>
                                                     <li class="notify" style="border-bottom:1px solid lightgrey;padding: 0px 10px 0px 10px;">
                                                         <p style="text-align: center; margin-top: 40px !important;">No notification</p>
                                                     </li>
                                                 <?php } ?>
                                             </ul>
                                        </div>
                                        <!-- END Today -->

                                        <!-- More -->
                                        <!-- <div class="text-center">
                                            <small><a href="javascript:void(0)">Load More..</a></small>
                                        </div> -->
                                        <!-- END More -->
                                    </div>
                                </div>
                                <!-- END Sales Tab -->
                            </div>
                        </div>
                        <!-- END Side Overlay Tabs -->
                    </div>
                    <!-- END Side Content -->
                </div>
                <!-- END Side Overlay Scroll Container -->
            </aside>
    <!-- END Side Overlay -->

    <!-- Sidebar -->
    <nav id="sidebar">
        <!-- Sidebar Scroll Container -->
        <div id="sidebar-scroll">
            <!-- Sidebar Content -->
            <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
            <div class="sidebar-content">
                <!-- Side Header -->
                <div class="side-header side-content bg-white-op">
                    <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                    <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button"
                            data-toggle="layout" data-action="sidebar_close">
                        <i class="fa fa-times"></i>
                    </button>
                    <?php $application = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", Yii::app()->params['applicationName']))?>
                    <a class="h5 text-white " href="<?php echo Yii::app()->createUrl('admin/home/index'); ?>">
                        <img src="<?php echo Yii::app()->baseUrl.'/images/logos/iriscall-logo.svg' ?>" style="max-width: 200px; max-height: 50px;">
                    </a>
                </div>
                <div class="side-content" id="mainmenu">
                    <ul class="nav-main" id="yw0">
                        <?php if(Yii::app()->controller->id == 'home'){ $active = "active";}else{ $active = " ";} ?>
                        <li><a class="nav-menu <?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/home/index'); ?>"><i class="si si-home"></i> <span class="sidebar-mini-hide"> Home </span></a></li>
                        <?php $action = Yii::app()->controller->id;
                        if($action == 'userInfo' || $action == 'roles'){ $open = "open";}else{ $open = " ";} ?>
                        <li class="<?= $open; ?>"><a class="nav-submenu " data-toggle="nav-submenu" href="javascript::void(0);"><i class="fa fa-users"></i> <span class=""> Customers </span></a>
                            <ul>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/userInfo/admin'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/userInfo/admin');?>"><i class="fa fa-user"></i> <span class="sidebar-mini-hide"> Users </span></a></li>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/Roles/admin'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/Roles/admin'); ?>"><i class="fa fa-briefcase"></i> <span class="sidebar-mini-hide"> Roles </span></a></li>
                            </ul>
                        </li>
                        <?php $action = Yii::app()->controller->id;
                        if($action == 'telecom' ){ $open = "open";}else{ $open = "";} ?>
                        <li class="<?= $open; ?>"><a class="nav-submenu " data-toggle="nav-submenu" href="javascript::void(0);"><i class="fa fa-phone-square"></i> <span class=""> Telecom </span></a>
                            <ul>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/telecom/index'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/telecom/index');?>"><i class="fa fa-address-book"></i> <span class="sidebar-mini-hide"> Telecom Details </span></a></li>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/telecom/accounts'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/telecom/accounts');?>"><i class="fa fa-list"></i> <span class="sidebar-mini-hide"> Telecom Accounts </span></a></li>
                            </ul>
                        </li>
                        <?php $action = Yii::app()->controller->id;
                        if($action == 'calldatarecords'){ $open = "open";}else{ $open = "";} ?>
                        <li class="<?= $open; ?>"><a class="nav-submenu " data-toggle="nav-submenu" href="javascript::void(0);"><i class="fa fa-mobile"></i> <span class=""> iPerity </span></a>
                            <ul>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/calldatarecords/admin'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/calldatarecords/admin');?>"><i class="fa fa-users"></i> <span class="sidebar-mini-hide"> iPerity Users </span></a></li>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/calldatarecords/cdrinfo'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/calldatarecords/cdrinfo');?>"><i class="fa fa-paperclip"></i> <span class="sidebar-mini-hide"> CDR Info </span></a></li>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/calldatarecords/cdrdetails'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="nav-menu <?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/calldatarecords/cdrdetails');?>"><i class="fa fa-phone"></i><span class="sidebar-mini-hide"> CDR Details </span></a></li>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/calldatarecords/cdrcostrules'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="nav-menu <?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/calldatarecords/cdrcostrules');?>"><i class="fa fa-money"></i><span class="sidebar-mini-hide"> CDR Cost Rules </span></a></li>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/calldatarecords/settings'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="nav-menu <?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/calldatarecords/settings');?>"><i class="fa fa-wrench"></i><span class="sidebar-mini-hide"> Settings </span></a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav-main" id="yw1">
                        <?php $action = Yii::app()->controller->id;
                        if($action == 'productInfo' || $action == 'categories'){ $open = "open";}else{ $open = "";} ?>
                        <li class="<?= $open; ?>"><a class="nav-submenu " data-toggle="nav-submenu" href="javascript::void(0);"><i class="fa fa-product-hunt"></i> <span class=""> Product </span></a>
                            <ul>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/productInfo/admin'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/productInfo/admin');?>"><i class="fa fa-product-hunt"></i> <span class="sidebar-mini-hide"> Products </span></a></li>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/categories/admin'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/categories/admin');?>"><i class="fa fa-tags"></i> <span class="sidebar-mini-hide"> Products Categories </span></a></li>
                            </ul>
                        </li>
                        <?php $action = Yii::app()->controller->id;
                        if($action == 'orderInfo' || $action == 'orderCreditMemo' || $action == 'subscription'){ $open = "open";}else{ $open = "";} ?>
                        <li class="<?= $open; ?>"><a class="nav-submenu " data-toggle="nav-submenu" href="javascript::void(0);"><i class="fa fa-reorder"></i> <span class=""> Sales </span></a>
                            <ul>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/orderInfo/admin'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/orderInfo/admin');?>"><i class="fa fa-file-text-o"></i> <span class="sidebar-mini-hide"> Orders </span></a></li>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/orderCreditMemo/admin'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/orderCreditMemo/admin');?>"><i class="fa fa-book"></i> <span class="sidebar-mini-hide"> Order Credit Memo </span></a></li>
                            </ul>
                        </li>
                        <?php $action = Yii::app()->controller->id;
                        if($action == 'wallet' || $action == 'walletTypeEntity'){ $open = "open";}else{ $open = "";} ?>
                        <li class="<?= $open; ?>"><a class="nav-submenu " data-toggle="nav-submenu" href="javascript::void(0);"><i class="si si-wallet"></i> <span class=""> Wallet Management </span></a>
                            <ul>
                                <?php /*if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/wallet/overview'){ $active = "active";}else{ $active = " ";} */?><!--
                                <li><a class="<?/*= $active; */?>" href="<?php /*echo Yii::app()->createUrl('/admin/wallet/overview"><i class="si si-wallet');*/?>"></i> <span class="sidebar-mini-hide"> Wallet Overview </span></a></li>-->
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/wallet/user'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/wallet/user');?>"><i class="si si-wallet"></i> <span class="sidebar-mini-hide"> User Balance </span></a></li>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/wallet/admin'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/wallet/admin');?>"><i class="si si-wallet"></i> <span class="sidebar-mini-hide">All Wallet Transactions </span></a></li>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/walletTypeEntity/admin'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/walletTypeEntity/admin');?>"><i class="si si-wallet"></i> <span class="sidebar-mini-hide"> Wallet Settings </span></a></li>
                            </ul>
                        </li>
                        <?php if(Yii::app()->controller->id == 'rank'){ $active = "active";}else{ $active = " ";} ?>
                        <li><a class="nav-menu <?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/rank/admin');?>"><i class="fa fa-sort-numeric-asc"></i><span class="sidebar-mini-hide"> Ranks </span></a></li>
                        <?php /*$action = Yii::app()->controller->id;
                        if($action == 'voucher'){ $open = "open";}else{ $open = "";} */?><!--
                        <li class="<?/*= $open; */?>"><a class="nav-submenu " data-toggle="nav-submenu" href="javascript::void(0);"><i class="si si-wallet"></i> <span class=""> Vouchers</span></a>
                            <ul>
                                <?php /*if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/voucher/index'){ $active = "active";}else{ $active = " ";} */?>
                                <li><a class="<?/*= $active; */?>" href="<?php /*echo Yii::app()->createUrl('/admin/voucher/index"><i class="fa fa-money');*/?>"></i> <span class="sidebar-mini-hide"> Voucher Details </span></a></li>
                                <?php /*if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/voucherReference/index'){ $active = "active";}else{ $active = " ";} */?>
                                <li><a class="<?/*= $active; */?>" href="<?php /*echo Yii::app()->createUrl('/admin/voucherReference/index"><i class="si si-wallet');*/?>"></i> <span class="sidebar-mini-hide"> Voucher Reference </span></a></li>
                            </ul>
                        </li>-->

                        <?php if(Yii::app()->controller->id == 'notificationManager'){ $active = "active";}else{ $active = " ";} ?>
                        <li><a class="nav-menu <?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/notificationManager/view');?>"><i class="fa fa-bell-o"></i> <span class="sidebar-mini-hide"> Notifications </span></a></li>
                        <?php if(Yii::app()->controller->id == 'test'){ $active = "active";}else{ $active = " ";} ?>
                        <li><a class="nav-menu <?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/test');?>"><i class="fa fa-question"></i><span class="sidebar-mini-hide"> Test Cases </span></a></li>
                        <?php if(Yii::app()->controller->id == 'report'){ $active = "active";}else{ $active = " ";} ?>
                        <li><a class="nav-menu <?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/report');?>"><i class="fa fa-bar-chart"></i><span class="sidebar-mini-hide"> Reports </span></a></li>
                        <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/nautilus/registration' || Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/nautilus/deposits'){ $open = "open";}else{ $open = "";} ?>
                        <li class="<?= $open; ?>"><a class="nav-submenu hide" data-toggle="nav-submenu" href="javascript::void(0);"><i class="fa fa-ticket"></i> <span class=""> Nautilus Fund </span></a>
                            <ul>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/nautilus/registration'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/nautilus/registration');?>"><i class="fa fa-ticket"></i> <span class="sidebar-mini-hide"> Registrations </span></a></li>
                                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/nautilus/deposits'){ $active = "active";}else{ $active = " ";} ?>
                                <li><a class="<?= $active; ?>" href="<?php echo Yii::app()->createUrl('/admin/nautilus/deposits');?>"><i class="fa fa-cogs"></i> <span class="sidebar-mini-hide"> Deposit/Withdraws </span></a></li>
                            </ul>
                        </li>
                   </ul>
                </div>
                <!-- mainmenu -->

            </div>
            <!-- Sidebar Content -->
        </div>
        <!-- END Sidebar Scroll Container -->
    </nav>
    <!-- END Sidebar -->

    <!--BEGIN LOADER-->
    <div class="overlay hide">
        <div class="loader">
            <i class="fa fa-5x fa-cog fa-spin"></i>
        </div>
    </div>
    <!--END LOADER-->

    <header id="header-navbar" class="content-mini content-mini-full">

        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-7">
                </div>
                <div class="col-sm-5">
                    <div class="row">
                        <ul class="nav-header">
                            <li class="pull-right">
                                <div class="btn-group admin-btn-group">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                                        <i class="si si-user admin-icon user-admin-icon"></i>&nbsp;&nbsp;<?php echo isset($_SESSION['user']) ? ucfirst($_SESSION['user']) : ''; ?>
                                        Admin<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-header">Profile</li>
                                        <li>
                                            <a tabindex="-1" href="<?php echo Yii::app()->createUrl('user/autologin').'?id='.Yii::app()->session['adminLoginId'] ?>">
                                                <i class="fa fa-arrow-right pull-right"></i>Go to front-end
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li class="dropdown-header">Actions</li>
                                        <li>
                                            <a tabindex="-1" href="<?php echo Yii::app()->createUrl('home/logout'); ?>">
                                                <i class="si si-logout pull-right"></i>Log out
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </li>
                            <li class="pull-right">
                                <button class="btn btn-default" data-toggle="layout" data-action="side_overlay_toggle" type="button" style="height: 34px;">
                                    <i class="fa fa-bell-o"></i>
                                    <span id="noticounts" style="right:unset !important;" class="badge bg-warning"></span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>e

    <main id="main-container" style="min-height: 342px;">
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7" style="padding-top: 42px; height : 55px;">
                    <h1 class="page-heading">
                        <?php echo $this->getPageTitle(); ?>
                    </h1>
                </div>
                <?php if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'admin/mt4/statalysegraph'){ ?>

                <div class="col-sm-3 pull-right" style="padding-top: 25px; height : 55px;">
                  <label>Select Table</label>
                  <select class="form-control" id="tablename">
                    <option value="user_daily_balance">User Daily Balance</option>
                    <!--<option value="user_daily_balance_2">User Daily Balance 2</option>-->
                    <!-- <option value="user_daily_balance_3">User Daily Balance 3</option> -->
                  </select>
                  <p id="tableStatylyse" style="color:red;display:none;">Please Select Table</p>
                </div>
                <?php } ?>
            </div>
        </div>

        <?php
        $flashMessages = Yii::app()->user->getFlashes();
        if($flashMessages){
            foreach($flashMessages as $key => $message) {
                ?>
                <div class="alert alert-success" role="alert" id="autoalert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="alert-heading text-center"><?php echo $message; ?></h4>
                </div>
                <?php
            }
        }
        else if(isset($_SESSION['delete'])){
            ?>
            <div class="alert alert-success" role="alert" id="autoalert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="alert-heading text-center"><?php if(isset($_SESSION['delete'])){ echo $_SESSION['delete']; unset($_SESSION['delete']); }; ?></h4>
            </div>
        <?php } ?>

        <div class="alert alert-success hide" role="alert" id="myHideEffect">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="alert-heading text-center">Password updated successfully..</h4>
        </div>
        <?php if ($this->uniqueid == "admin/home" && $this->action->Id == "index"){
            echo $content;
        }elseif($this->uniqueid == "admin/home" && $this->action->Id == "edit") {
            ?>
            <div class="content">
                <div class="block">
                    <?php echo $content; ?>
                </div>
            </div>
            <?php
        }elseif ($this->uniqueid == "admin/events" && $this->action->Id == "view"){
            ?>
            <div class="block">
                <div class="block-content">
                    <?php echo $content; ?>
                </div>
            </div>
            <?php

        }else{
            ?>
            <div class="content">
                <div class="block">
                    <div class="block-content">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </main>
    <!-- Footer -->
    <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">

        <div class="pull-right"> <i class="fa fa-code" aria-hidden="true"></i> with <i class="fa fa-heart"></i> by
            <a class="font-w600" href="http://abptechnologies.com/" target="_blank">ABP Technologies</a>
        </div>
        <div class="pull-left">
            <a class="font-w600" href="<?php echo Yii::app()->createUrl('admin/home/index'); ?>"><?= Yii::app()->params['applicationName']; ?></a> &copy; <span
                    class="js-year-copy"></span>
        </div>
    </footer>
    <!-- END Footer -->
</div>
</body>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/core/jquery.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/core/bootstrap.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/core/jquery.slimscroll.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/core/jquery.scrollLock.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/core/jquery.appear.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/core/jquery.countTo.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/core/jquery.placeholder.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/core/js.cookie.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/app.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/datatables/jquery.dataTables.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/base_tables_datatables.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jquery-validation/jquery.validate.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/jquery-validation/additional-methods.min.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/custom.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/select2/dist/js/select2.full.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/fontawesome-iconpicker.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/nested-menu/jquery-nested.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/nested-menu/tree.jquery.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/sweetalert/sweetalert.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/footable/js/footable.all.min.js');
?>


<!--Begin not allowed action Modal -->
<div class="modal fade shop-login-modal" id="trialexpired" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Unauthorized action</h5>
            </div>
            <div class="modal-body">
                You are unauthorized to perform this action.
                <p></p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" onclick="history.go(-1)">Go back</a>
            </div>
        </div>
    </div>
</div>
<!--End of not allowed action Modal-->

<!-- Modal -->
<div class="modal fade" id="exportmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>How to use exported application..</b>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h5>
            </div>
            <div class="modal-body">
                <p>1. Extract the archive and put it in the folder you want.</p>
                <p>2. Find database .sql file in the folder and setup database.</p>
                <p>3. You can login with email and password with which you created application.</p>

                <p>And that's it, go to your domain and login:</p>
                <p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button

            </div>
        </div>
    </div>
</div>

</html>

<script>
    $("#exportbutton").click(function(){
        $('#exportmodal').modal('show');
    });

    $(document).ready(function(){
        var denied = $('#unauth').val();
        if(denied == 'denied'){
            $('#trialexpired').modal('show');
        }
    });

//    $(document).ready(function () {
//        $(".activeO").parent().parent().addClass('open');
//        $(".activeO a").addClass('active');
//        $(".active-li a").addClass('active');
//    });

    $(document).ready(function(){
        var updated = localStorage.getItem('updatedpassword');
        if(updated == 'yes'){
            $('#myHideEffect').removeClass('hide');
            $('#myHideEffect').fadeOut(4000);
            localStorage.clear();
        }
    });

    $(document).ready(function () {
        $('#autoalert').fadeOut(5500);
    });

</script>
<?php
function isItemActive($route,$id)
{
    if($id == "Roles/admin" || $id == "Modules/index") {
        $id = lcfirst($id);
    }

    $menu = explode("/", $route);

    return $menu[1] . "/" . $menu[2] == $id ? true : false;
}
?>
<script>
    $("#gotoAdmin").click(function () {
        var appname = '<?php echo Yii::app()->params['applicationName']; ?>';
        $.ajax({
            url: "<?php echo Yii::app()->params['templateCurlUrl']; ?>/admin/app/autologin",
            type: "POST",
            data: {'appname':appname},
            beforeSend: function () {
                $(".overlay").removeClass("hide");
            },
            success: function (response) {
                var Result = JSON.parse(response);
                if (Result.token == 1){
                    window.location.href = '<?php echo Yii::app()->params['templateCurlUrl']; ?>/admin/app/admin';
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    });
</script>



<!--<script src="https://js.pusher.com/4.1/pusher.min.js"></script>-->
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;
    var authKey = '<?= Yii::app()->params['NotificationAuthKey']; ?>';

    var pusher = new Pusher(authKey, {
        cluster: 'ap2',
        encrypted: true
    });

    var channel = pusher.subscribe('my-channel');

    channel.bind('my-event', function(data) {
        var val = $("#noticounts").html();
        if(val == ""){
            val = 1;
        }
        else{
            val = parseInt(val) + parseInt(1);
        }

        $('#noticounts').html(val);
        if(data.type == 'order'){
            $('#alert-notify').prepend('<li id="'+data.nid+'"><i class="si si-wallet text-success"></i><div><a href="'+data.userInfoUrl+'">'+data.username+'</a><a href="javascript:void(0);" class="pull-right "><i class="fa fa-times delete delete_notify" id="notify_'+data.nid+'"></i></a></div><div class="font-w600">placed an <a href="'+data.url+'">order of '+data.amount+'</a></div><div><small class="text-muted">'+ data.date +'</small></div></li>');
        }else{
            $('#vapamm-notify').prepend('<li id="'+data.nid+'"><i class="si si-wallet text-success"></i><div><a href="'+data.accountInfoUrl+'">'+data.emails+'</a><a href="javascript:void(0);" class="pull-right "><i class="fa fa-times delete delete_notify" id="notify_'+data.nid+'"></i></a></div><div class="font-w600">'+data.message+'<a href="'+data.url+'">'+data.amount+'</a></div><div><small class="text-muted">'+ data.date +'</small></div></li>');
        }
    });
</script>


<script>

    $(document).on('click','.delete_notify',function () {
        var attrId = $(this).attr('id');
        var id = attrId.split('_');
        var Nid = id[1];
        $.ajax({
            url: "<?= Yii::app()->createUrl('admin/notificationManager/Delete')?>",
            type: "POST",
            data:{'id' : id},
            success: function (response) {
                var Result = JSON.parse(response);
                if (Result.token == 1){
                    /!* window.location.reload();*!/
                    $('#' + Nid).hide();
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });

    });


    $(".deleteAllGeneral").on('click',function () {
        var type = "general";
        $.ajax({
            url: "<?= Yii::app()->createUrl('admin/notificationManager/Deleteall')?>",
            type: "POST",
            data:{'type' : type},
            success: function (response) {
                var Result = JSON.parse(response);
                if (Result.token == 1){
                    /!*window.location.reload();*!/
                    $('#alert-notify').html('<li class="notify" style="border-bottom:1px solid lightgrey;padding: 0px 10px 0px 10px;"><p style="text-align: center; margin-top: 40px !important;">No notification</p></li>');
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    });


    $(".deleteAllVpamm").on('click',function () {
        var type = "deposit";
        $.ajax({
            url: "<?= Yii::app()->createUrl('admin/notificationManager/Deleteall')?>",
            type: "POST",
            data:{'type' : type},
            success: function (response) {
                var Result = JSON.parse(response);
                if (Result.token == 1){
                    /!*window.location.reload();*!/
                    $('#vapamm-notify').html('<li class="notify" style="border-bottom:1px solid lightgrey;padding: 0px 10px 0px 10px;"><p style="text-align: center; margin-top: 40px !important;">No notification</p></li>');
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });

    });


</script>
