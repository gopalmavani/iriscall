<?php
$this->pageTitle = Yii::app()->name;
?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
            <!-- begin:: Subheader -->
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-container kt-container--fluid ">
                    <div class="kt-subheader__main">
                        <h3 class="kt-subheader__title"> Dashboard </h3>
                        <span class="kt-subheader__separator kt-hidden"></span>
                        <div class="kt-subheader__breadcrumbs">
                            <a href="<?= Yii::app()->createUrl('home/index'); ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                            <span class="kt-subheader__breadcrumbs-separator"></span>
                            <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Dashboard</span>
                        </div>
                    </div>
                    <div class="kt-subheader__toolbar">
                        <div class="kt-subheader__wrapper"> <a href="#" class="btn btn-label-brand btn-bold btn-sm">Actions</a>
                            <div class="dropdown dropdown-inline" data-placement="left">
                                <a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success kt-svg-icon--md">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000" />
                                        </g>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-md dropdown-menu-right">
                                    <!--begin::Nav-->
                                    <ul class="kt-nav">
                                        <li class="kt-nav__head"> Quick Actions:</li>
                                        <li class="kt-nav__separator"></li>
                                        <li class="kt-nav__item"> <a href="<?= Yii::app()->createUrl('order/index'); ?>" class="kt-nav__link"> <i class="kt-nav__link-icon flaticon2-drop"></i> <span class="kt-nav__link-text">Orders</span> </a> </li>
                                        <!--<li class="kt-nav__item"> <a href="#" class="kt-nav__link"> <i class="kt-nav__link-icon flaticon2-calendar-8"></i> <span class="kt-nav__link-text">Ticket</span> </a> </li>-->
                                        <li class="kt-nav__item"> <a href="<?= Yii::app()->createUrl('wallet/index'); ?>" class="kt-nav__link"> <i class="kt-nav__link-icon flaticon2-telegram-logo"></i> <span class="kt-nav__link-text">Wallet</span> </a> </li>
                                        <!--<li class="kt-nav__item"> <a href="#" class="kt-nav__link"> <i class="kt-nav__link-icon flaticon2-new-email"></i> <span class="kt-nav__link-text">Support Case</span> <span class="kt-nav__link-badge"> <span class="kt-badge kt-badge--success">5</span> </span> </a> </li>-->
                                        <!--<li class="kt-nav__separator"></li>
                                        <li class="kt-nav__foot"> <a class="btn btn-label-brand btn-bold btn-sm" href="#">Upgrade plan</a> <a class="btn btn-clean btn-bold btn-sm" href="#" data-toggle="kt-tooltip" data-placement="right" title="Click to learn more...">Learn more</a> </li>-->
                                    </ul>
                                    <!--end::Nav-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end:: Subheader -->
            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <div class="row">
                    <div class="col-xl-8 col-lg-6">
                        <div class="kt-portlet kt-portlet--tab">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label"> <span class="kt-portlet__head-icon kt-hidden"> <i class="la la-gear"></i> </span>
                                    <h3 class="kt-portlet__head-title"> Monthly Earnings </h3>
                                </div>
                                <div class="kt-portlet__head-toolbar">
                                    <select class="form-control custom-select btn btn-label-brand btn-bold btn-sm dropdown-toggle" id="commission-graph-selector">
                                        <option value="2020" selected>2020</option>
                                        <option value="2019">2019</option>
                                        <option value="2018">2018</option>
                                        <option value="2017">2017</option>
                                        <option value="2016">2016</option>
                                    </select>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div id="commission-graph-container-card" style="display: none">
                                    <h4 class="card-title">No Commission Data found</h4>
                                    <p class="card-text">This might be because of commission not distributed yet. Please wait till the
                                        month end...</p>
                                </div>
                                <div id="commission-graph-container" style="width: 100%; min-height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">GRID Licenses</h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body kt-portlet__body--fluid">
                                <div class="kt-widget12">
                                    <div class="kt-widget12__content">
                                        <div class="row">
                                            <div class="col-6 col-sm-6 custom-line">
                                                <h5 class="mb-1">Available Licenses :</h5>
                                                <p><strong><?= $availableLicenses; ?></strong></p>
                                            </div>
                                            <div class="col-6 col-sm-6 custom-line">
                                                <h5 class="mb-1">Total Licenses :</h5>
                                                <p><strong><?= $totalLicenses; ?></strong></p>
                                            </div>
                                        </div>
                                        <!--<ul class="partner-programs">
                                            <li style="padding-top: 0">

                                            </li>
                                        </ul>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title"> Partner Programs </h3>
                                </div>
                                <div class="kt-portlet__head-toolbar"> <a href="<?= Yii::app()->createUrl('partnerproducts/list') ?>" class="small" data-toggle="dropdown"> View All </a> </div>
                            </div>
                            <div class="kt-portlet__body kt-portlet__body--fluid" style="padding-bottom: 0">
                                <div class="kt-widget12">
                                    <div class="kt-widget12__content">
                                        <ul class="partner-programs">
                                            <!--<li class="announcement">
                                                <div class="row">
                                                    <div class="col-4 col-sm-5"> <img src="<?/*= Yii::app()->baseUrl; */?>/images/logos/logo-realestate.jpg" class="img-fluid"> </div>
                                                    <div class="col-8 col-sm-7">
                                                        <div><strong>Offered by :</strong> Company</div>
                                                        <div><strong>Min. Investment :</strong> &euro;5000</div>
                                                        <div class="mb-2"><strong>MMC :</strong> Amortisation Nodes</div>
                                                        <button type="button" class="btn btn-sm btn-secondary">More Info</button>
                                                    </div>
                                                </div>
                                            </li>-->
                                            <li>
                                                <div class="row">
                                                    <div class="col-12 col-sm-5 mb-2"> <img src="<?= Yii::app()->baseUrl; ?>/images/logos/logo-nt.jpg" class="img-fluid"> </div>
                                                    <div class="col-12 col-sm-7">
                                                        <div class="row">
                                                            <div class="col-4 col-sm-5"><strong>Start</strong></div>
                                                            <div class="col-8 col-sm-7 text-right"><?= date('d-M-Y', strtotime($nexi_trading['registration_date'])); ?></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-4 col-sm-5"><strong>Status</strong></div>
                                                            <?php if(CBMAccountHelper::getAccountStatus($nexi_trading['group']) == 'Active') { ?>
                                                                <div class="col-8 col-sm-7 text-right"><span class="kt-badge kt-badge--inline kt-badge--success">Active</span></div>
                                                            <?php } else {?>
                                                                <div class="col-8 col-sm-7 text-right"><span class="kt-badge kt-badge--inline kt-badge--danger">Inactive</span></div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-5">
                                                        <div><strong>Type :</strong> FX CFD's</div>
                                                        <div><strong>Product :</strong>NexiMax EA</div>
                                                    </div>
                                                    <div class="col-12 col-sm-7">
                                                        <div><strong>Deposit : </strong>&euro;<?= round($nexi_trading_deposit,2); ?></div>
                                                    </div>
                                                    <?php if($nexiMaxAccountNumber != '') { ?>
                                                        <div class="col-12 col-sm-12">
                                                            <div><strong>Account Number: </strong><?= $nexiMaxAccountNumber; ?></div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-12 col-sm-5 mb-2"> <img src="<?= Yii::app()->baseUrl; ?>/images/logos/logo-tu.jpg" class="img-fluid"> </div>
                                                    <div class="col-12 col-sm-7">
                                                        <div class="row">
                                                            <div class="col-4 col-sm-5"><strong>Start</strong></div>
                                                            <div class="col-8 col-sm-7 text-right"><?= date('d-M-Y', strtotime($unity_trading['registration_date'])); ?></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-4 col-sm-5"><strong>Status</strong></div>
                                                            <?php if(CBMAccountHelper::getAccountStatus($unity_trading['group']) == 'Active') { ?>
                                                                <div class="col-8 col-sm-7 text-right"><span class="kt-badge kt-badge--inline kt-badge--success">Active</span></div>
                                                            <?php } else {?>
                                                                <div class="col-8 col-sm-7 text-right"><span class="kt-badge kt-badge--inline kt-badge--danger">Inactive</span></div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-5">
                                                        <div><strong>Type :</strong> FX CFD's</div>
                                                        <div><strong>Product :</strong>UnityMax EA</div>
                                                    </div>
                                                    <div class="col-12 col-sm-7">
                                                        <div><strong>Deposit : </strong>&euro;<?= round($unity_trading_deposit,2); ?></div>
                                                    </div>
                                                    <?php if($unityMaxAccountNumber != '') { ?>
                                                        <div class="col-12 col-sm-12">
                                                            <div><strong>Account Number: </strong><?= $unityMaxAccountNumber; ?></div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-12">
                        <div class="kt-portlet kt-portlet--height-fluid kt-portlet--skin-solid kt-portlet-- kt-bg-secondary w-info">
                            <div class="kt-portlet__body">
                                <div class="row d-flex align-items-center" style="height: 100%;">
                                    <div class="col-4 col-sm-4 text-center"><i class="fas fa-male"></i><i class="fas fa-female"></i></div>
                                    <div class="row" style="width: 120px">
                                        <div class="col-6">
                                            <h6 class="mb-2">Lvl 1</h6>
                                            <h1 class="mb-0"><?= $levelOneChildCount; ?></h1>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="mb-2">Lvl 2</h6>
                                            <h1 class="mb-0"><?= $levelTwoChildCount; ?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-12">
                        <div class="kt-portlet kt-portlet--height-fluid w-info">
                            <div class="kt-portlet__body">
                                <!--<a href="javascript:void();" class="settings"><i class="fas fa-cog"></i></a>-->
                                <div class="row d-flex align-items-center">
                                    <div class="col-4 col-sm-4 text-center"><i class="fas fa-wallet icon"></i></div>
                                    <div class="col-8 col-sm-8">
                                        <h5 class="mb-1">Settings :</h5>
                                        <p>Min &euro;50, Max &euro;250</p>
                                        <h5 class="mb-1">Available :</h5>
                                        <p class="mb-0">&euro;<?= $totalEarnings; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="kt-portlet kt-portlet--height-fluid kt-portlet--skin-solid kt-portlet-- kt-bg-primary">
                            <div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">Affiliate Link</h3>
                                </div>
                                <!--<div class="kt-portlet__head-toolbar">
                                    <a href="#" class="small">View All Affiliate Links</a>
                                </div>-->
                            </div>
                            <div class="kt-portlet__body pt-0">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="myInput" value="<?php echo Yii::app()->getBaseUrl(true).'/home/signup/'.$user_id; ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" onclick="fnOne()" type="button">Copy URL</button>
                                    </div>
                                </div>
                                <!--<div class="text-right">
                                    <a href="https://micromaxcash.com" target="_blank">Visit Page <i class="fas fa-external-link-alt"></i></a>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="kt-portlet kt-portlet--height-fluid">
                            <!--<a href="javascript:void()" class="settings"><i class="fas fa-cog"></i></a>-->
                            <div class="kt-widget14">
                                <div class="row d-flex align-items-center">
                                    <div id="nodes-donut-pie-graph-container" style="width: 100%; min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end:: Content -->
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/highstock.js"></script>
<script>
    /*
    * Create commission and affiliate graph
    * */
    function commissionGraph(data) {
        Highcharts.chart('commission-graph-container', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
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
                    text: 'Euro'
                }
            },
            series: data
        })
    }

    /*
    * Copy Function
    * */
    function fnOne() {
        let copyText = document.getElementById("myInput");
        copyText.select();
        document.execCommand("Copy");
    }

    /*
    * Node chart function
    * */
    function createNodesChart(data){
        let updateddata = [];
        $.each(data, function (index, value) {
            //updateddata.push(['name' : value.name, 'y' : value.y]);
            var temp = {};
            temp['name'] = value.name;
            temp['y'] = parseFloat(value.y);
            updateddata.push(temp);
        });
        Highcharts.chart('nodes-donut-pie-graph-container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Node Presence in Matrix'
            },
            subtitle: {
                text: 'Matrix node details'
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            series: [ {
                name: 'Nodes',
                data: updateddata,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
                    formatter: function () {
                        // display only if larger than 1
                        return this.y > 1 ? '<b>' + this.point.name + ':</b> ' + this.y : null;
                    }
                },
                id: 'nodes'
            }]
        });
    }

    /*
    * Growth chart with both client and
    * MAM details
    * */
    function createClientGrowthChart(data, login_number) {
        Highcharts.stockChart('containerCumulativeGrowth_' + login_number, {
            rangeSelector: {
                selected: 5
            },
            chart: {
                height: 500,
                zoomType: 'x'
            },
            title: {
                text: 'Cumulative Growth graph'
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">Growth</span>: <b>{point.y}</b> %<br/>',
                split: false
            },
            series: [{
                name: 'Cumulative Growth Graph',
                type: 'area',
                data: data
            }],
            legend: {
                enabled: true
            },
            navigation: {
                menuItemStyle: {
                    fontSize: '10px'
                }
            }
        });
    }

    //Create Commission graph
    let commissionGraphData = JSON.parse('<?= $commission_graph_data; ?>');
    if (commissionGraphData.result) {
        $('#commission-graph-container-card').css('display', 'block');
    } else {
        commissionGraph(commissionGraphData);
    }

    //Create Node chart
    let nodesCounter = '<?= json_encode($nodesCounter); ?>';
    if(nodesCounter != ''){
        let nodesData = JSON.parse(nodesCounter);
        createNodesChart(nodesData);
    }

    /*
    * On change event for commission graph
    * */
    $("#commission-graph-selector").change(function () {
        let year = $('option:selected', this).val();
        let commission_graph_url = "<?= Yii::app()->createUrl('home/ajaxEarningGraph'); ?>";
        $.ajax({
            url: commission_graph_url,
            type: "POST",
            data: {
                year: year
            },
            success: function (response) {
                let commissionGraphData = JSON.parse(response);
                if (commissionGraphData.result) {
                    $('#commission-graph-container-card').css('display', 'block');
                    $('#commission-graph-container').css('display', 'none');
                } else {
                    $('#commission-graph-container-card').css('display', 'none');
                    $('#commission-graph-container').css('display', 'block');
                    commissionGraph(commissionGraphData);
                }
            }
        })
    });
</script>
