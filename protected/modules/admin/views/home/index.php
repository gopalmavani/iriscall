<?php $this->pageTitle = 'Dashboard'; ?>
<style>
    .table>tbody>tr>td{
        padding: 12px 10px;
    }.nav>li>a {
          background-color:  unset !important;
         color: black !important;
     }
    .scroll {
        height: 475px;
    }.scroll:hover{
        overflow-y: scroll;
    } .order {
            display:block;
            height:210px;
            overflow-y:scroll;
     } thead, tbody tr {
          display:table;
          width:100%;
          table-layout:fixed;/* even columns width , fix width of table too*/
      }
    .overscroll{
        height: 495px;
    } .overscroll:hover{
        overflow-y: scroll !important;
    }
</style>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl. '/css/daterangepicker.css'; ?>" />
<!-- Page Content -->
<div class="content">
    <!-- Draggable Items with jQueryUI (.js-draggable-items class is initialized in App() -> uiHelperDraggableItems()) -->
    <!--First row for draggable small widgets-->
    <div class="row">
        <div class="col-md-3">
            <div class="col-xs-6 col-lg-12 block   ">
            </div>

            <div class="col-xs-6 col-lg-12 block ">
                <div class="block-header ">
                    <div class="pull-right push-15-t push-15">
                        <a href="<?php echo Yii::app()->createUrl('admin/userInfo/admin')?>">
                            <i class="fa fa-users fa-2x text-primary"></i>
                        </a>
                    </div>
                    <div class="h2 text-primary" data-toggle="countTo" data-to="<?= $users; ?>"><?= $users; ?></div>
                    <a href="<?php echo Yii::app()->createUrl('admin/userInfo/admin')?>">
                        <div class="text-uppercase font-w600 font-s12 text-muted"><?= Yii::app()->params['appName']; ?> Users</div>
                    </a>
                </div>
            </div>

            <div class="col-xs-6 col-lg-12 block  ">
                <div class="block-header ">
                </div>
            </div>

            <div class="col-xs-6 col-lg-12 block ">
            </div>

        </div>
        <div class="col-md-9">
            <div class="block" id="orderDetails">
                <div class="block-header">
                    <ul class="block-options">
                        <div class='picker'>
<!--                            <i class="fa fa-calendar"></i>-->
                            <!--<input type="text" name="daterange" value="/01/2018 - 01/15/2018"  />-->
                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </ul>
                    <h3 class="block-title">Order Details</h3>
                </div>
                <div class="block-content clearfix" style="height: 390px;">
                    <div class='row'>
                        <div class='col-md-4'>
                            <div class='block-header bg-info'>
                                <ul class='block-options'>
                                    <li>
                                        <span id="TotalorderCount" class='block-title' style=' color: #fff;'></span>
                                    </li>
                                </ul>
                                <h3 class='block-title' style=' color: #fff;'>Total Orders</h3>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='block-header bg-primary'>
                                <ul class='block-options'>
                                    <li>
                                     <span class='block-title' id="TotalLicenesCount" style=' color: #fff;'></span></h6>
                                    </li>
                                </ul>
                                <h3 class='block-title' >Total Licenses</h3>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='block-header bg-warning'>
                                <ul class='block-options'>
                                    <li>
                                     <span class='block-title' id="TotalPendingOrder" style=' color: #fff;'></span></h6>
                                    </li>
                                </ul>
                                <h3 class='block-title' style=' color: #fff;'>Pending Orders</h3>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div id="order">
                        <table class="table table-borderless table-striped table-vcenter order" >

                                <tbody >

                                </tbody>

                        </table>
                    </div>


                    <!--<div class="pull-right m-b-10">-->
                        <?php //echo CHtml::link('See More', array('orderInfo/admin'),['class'=>'text-smooth']); ?>
                    <!--</div>-->
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="block block-opt-refresh-icon4">
                <div class="block-header">
                    <ul class="block-options">
<!--                        <li>-->
<!--                            <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>-->
<!--                        </li>-->
                        <li>
                            <button id="cbmuseraccount" type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="close"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="block-content clearfix overscroll" style="height: 495px; overflow-y: hidden;">
                    <table class="table table-borderless table-striped table-vcenter" id="cbmAccUser">
                        <tbody>
                        </tbody>
                    </table>
                    <div class="pull-right m-b-10">
                        <?php //echo CHtml::link('See More', array('cbmuseraccount/index'),['class'=>'text-smooth']); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs">
<!--                <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs">-->
                    <li class="pull-right">
                       <ul class="block-options" style="margin-top:10px; margin-right:15px; ">
<!--                           <li>-->
<!--                               <button id="cbmuseraccount" type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>-->
<!--                           </li>-->
                           <li>
                               <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                           </li>
                           <li>
                               <button type="button" data-toggle="block-option" data-action="close"><i class="si si-close"></i></button>
                           </li>
                       </ul>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <div class="tab-pane active scroll" id="btabs-alt-static-home" >
                        <h4 class="push-15">Not Registered With Us </h4>
                        <table class="table table-borderless table-striped table-vcenter" id="cbmAccUser">
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane scroll" id="btabs-alt-static-profile">
                        <!--<h4 class="font-w300 push-15">Not Registered With Mt4</h4>-->
                        <h4 class="push-15">Not Registered With Mt4 </h4>
                        <table class="table table-borderless table-striped table-vcenter" id="cbmAccUser">
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <!-- Main Dashboard Chart -->
            <div class="block" id="chartDisplay">
                <div class="block-header">
                    <ul class="block-options">
                        <!--<li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>-->
                        <li>
                            <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="close"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Commision Monthly Overview</h3>
                </div>

                <div class="block-content text-center">
                    <div class="row items-push text-center">
                        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
            <!-- END Main Dashboard Chart -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="block block-opt-refresh-icon4 ">
                <div class="block-header bg-gray-lighter ">
                    <ul class="block-options">
                        <!--                        <li>-->
                        <!--                            <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>-->
                        <!--                        </li>-->
                        <li>
                            <button type="button" id="latestDeposit" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="close"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Latest Deposits / Withdraw</h3>
                </div>
                <div class="block-content clearfix">
                    <table class="table table-borderless table-striped table-vcenter" id="DepositLatest">
                        <tbody>

                        </tbody>
                    </table>
                    <div class="pull-right m-b-10">
                        <?php echo CHtml::link('See More', array('mt4/depositWithdraw'),['class'=>'text-smooth']); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- END Page Content -->
<script src="<?php echo Yii::app()->baseUrl. '/plugins/slick/slick.min.js'; ?>"></script>
<script src="<?php echo Yii::app()->baseUrl. '/plugins/chartjs/Chart.min.js'; ?>"></script>
<script src="<?php echo Yii::app()->baseUrl. '/plugins/jquery-ui/jquery-ui.min.js'; ?>"></script>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl. '/js/moment.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl. '/js/daterangepicker.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl. '/js/highcharts.js'; ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl. '/js/exporting.js'; ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl. '/js/export-data.js'; ?>"></script>

<script>
    jQuery(function () {
        // Init page helpers (Slick Slider plugin)
        App.initHelpers('slick');
    });

    jQuery(function () {
        // Init page helpers (Appear + CountTo plugins)
        App.initHelpers(['appear', 'appear-countTo']);
    });

    /*
     *  Document   : base_pages_dashboard.js
     *  Author     : pixelcave
     *  Description: Custom JS code used in Dashboard Page
     */


</script>
<script>
    jQuery(function () {
        // Init page helpers (jQueryUI)
        App.initHelpers('draggable-items');
    });
</script>

<script>
    jQuery(function () {
        // Init page helpers (Appear + CountTo plugins)
        App.initHelpers(['appear', 'appear-countTo']);
    });
</script>
<script type="text/javascript">
 // for date change filter wise search.

    $(function() {

        var start = moment().subtract(14, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var startdate = start.format('YYYY-MM-DD');
            var enddate = end.format('YYYY-MM-DD');
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('admin/home/OrderFilter')?>',
                type: "post",
                data:{'startdate':startdate,'enddate':enddate},
                beforeSend: function (response) {
                    $('#orderDetails').addClass('block-opt-refresh');
                },
                success: function (response) {
                    $('#orderDetails').removeClass('block-opt-refresh');
                    var result = jQuery.parseJSON(response);

                    $('#order').html(result.reponse_detail);
                    $('#TotalorderCount').html(result.no_of_orders);
                    $('#TotalLicenesCount').html(result.total_license);
                    $('#TotalPendingOrder').html(result.pending_orders);

                }
            });
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);


    });
</script>

<script>

    $(document).ready(function () {

        $.ajax({
            url: '<?php echo Yii::app()->createUrl('admin/home/ChartWallet')?>',
            type: "get",
            beforeSend: function (response) {
                $('#chartDisplay').addClass('block-opt-refresh');
            },
            success: function (response) {
                $('#chartDisplay').removeClass('block-opt-refresh');
                var result = jQuery.parseJSON(response);
                /*var asd = result.data;*/

                if((result.status == false)){
                    $('#container').css("height","50px");
                    $('#container').html("<span align='center'>No Data Found</span>");
                }else{
                    Highcharts.chart('container', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Monthly Commision Average Graph'
                        },
                        /*subtitle: {
                         text: 'Source: WorldClimate.com'
                         },*/
                        xAxis: {
                            categories: [
                                'Jan',
                                'Feb',
                                'Mar',
                                'Apr',
                                'May',
                                'Jun',
                                'Jul',
                                'Aug',
                                'Sep',
                                'Oct',
                                'Nov',
                                'Dec'
                            ],
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Commission'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px;">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0"></td>' +
                            '<td style="padding:0;width: 50px;"><b>{point.y:.1f} </b></td></tr>',
                            footerFormat: '</table>',

                            useHTML: true
                        },credits: {
                            enabled: false
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        series:result.series

                    });
                }

            }
        });



    })
</script>
