<?php
/* @var $this UserInfoController */
/* @var $model UserInfo */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$this->pageTitle = 'Statalyse Graph';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/_reboot.scss');
// Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/newtheme/scss/_reboot.scs');
?>
<!--Begin loader-->
<div class="overlay" style="opacity:0.1 !important;position:unset !important;">
    <div class="loader">
        <!-- <div class="m-loader m-loader--lg m-loader--success" style="width: 30px; display: inline-block;"></div> -->
        <p style="font-size: 18px;"><i class="fa fa-cog fa-spin" aria-hidden="true"></i> Loading...</p>
    </div>
</div>
<!--End loader-->

<div class="row">

    <div class="col-md-12">
        <?php Yii::app()->session['controllerName'] = Yii::app()->controller->id; ?>
        <div class="row">

            <!-- For first user Graph -->
            <div class="col-md-6">
                <div class="row">
                    <!-- <div class="col-md-6"> -->
                    <div class="col-md-5">
                        <label>Select User</label>
                        <select class="form-control" id="user1">
                            <option value="">Select User</option>
                            <?php foreach ($model as $key => $value) { ?>
                                <option value="<?php echo $value->user_id; ?>"><?php echo $value->full_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- <div class="col-md-5">
                      <label>Select Table</label>
                                  <select class="form-control" id="tablename">
                        <option value="user_daily_balance">User Daily Balance</option>
                        <option value="user_daily_balance_2">User Daily Balance 2</option>
                        <option value="user_daily_balance_3">User Daily Balance 3</option>
                                  </select>
                    </div> -->
                    <!-- </div> -->
                </div>
                <br>
                <br>
                <div id="grapharea" style="display:none;">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#growth" role="tab"
                                                aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span>
                                <span class="hidden-xs-down">Growth</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#balance" role="tab"
                                                aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span>
                                <span class="hidden-xs-down">Balance</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="growth" role="tabpanel">
                            <div id="containerGrowth1"></div>
                        </div>
                        <div class="tab-pane p-20" id="balance" role="tabpanel">
                            <div id="containerBalance1"></div>
                        </div>
                    </div>
                </div>
                <div class="emptyValue hide">
                    <br>
                    <h3 class="emptyUsermsg" style="margin-left:10px;">No Data Available</h3>
                    <br>
                </div>
                <div class="col-md-12" id="userData1">

                </div>
            </div>
            <!-- <div class="col-md-1"></div> -->
            <!-- For second user Graph -->
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-5">
                        <label>Select User</label>
                        <select class="form-control" id="user2">
                            <option value="">Select User</option>
                            <?php foreach ($model as $key => $value) { ?>
                                <option value="<?php echo $value->user_id; ?>"><?php echo $value->full_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- <div class="col-md-5">
                      <label>Select Table</label>
                      <select class="form-control" id="tablename2">
                        <option value="user_daily_balance">User Daily Balance</option>
                        <option value="user_daily_balance_2">User Daily Balance 2</option>
                        <option value="user_daily_balance_3">User Daily Balance 3</option>
                      </select>
                    </div> -->
                </div>
                <br>
                <br>
                <div id="grapharea2" style="display:none;">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#growth2"
                                                role="tab" aria-selected="true"><span class="hidden-sm-up"><i
                                            class="ti-home"></i></span> <span class="hidden-xs-down">Growth</span></a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#balance2" role="tab"
                                                aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span>
                                <span class="hidden-xs-down">Balance</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="growth2" role="tabpanel">
                            <div id="containerGrowth2"></div>
                        </div>
                        <div class="tab-pane p-20" id="balance2" role="tabpanel">
                            <div id="containerBalance2"></div>
                        </div>
                    </div>
                </div>
                <div class="hide" id="emptyValue2">
                    <br>
                    <h3 class="emptyUsermsg" style="margin-left:10px;">No Data Available</h3>
                    <br>
                </div>
                <div class="col-md-12" id="userData2">

                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/highstock.js"></script>

<script>
    $(document).ready(function () {

        $('.overlay').addClass("hide");
        $('#user1,#tablename').change(function () {
            var userId = $('#user1').val();
            var tablename = $('#tablename').val();
            if (tablename == "") {
                $('#tableStatylyse').css("display", "");
                return false;
            } else {
                $('#tableStatylyse').css("display", "none");
            }
            if (userId == "") {
                $('#userData1').html("");
            }
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('/admin/mt4/usergraphdetails'); ?>",
                type: "POST",
                data: {
                    "user_id": userId,
                    "table": tablename
                },
                beforeSend: function () {
                    // setting a timeout
                    $('.overlay').removeClass("hide");
                },
                success: function (response) {
                    $('.overlay').addClass("hide");
                    var response = JSON.parse(response);
                    var result = response.result;
                    if (result.length == 0) {
                        $('#grapharea').css('display', 'none');
                        $('.emptyValue').removeClass('hide');
                        $('#userData1').html("");
                    } else {
                        var isPresent = parseInt(response.isPresent);
                        if (isPresent > 0) {
                            $('.emptyValue').addClass('hide');
                            $('#grapharea').css('display', '');

                            var balance = result.balance;
                            var growth = result.growth;
                            createChart(balance.balance, 'Balance', 1);
                            createChart(growth.balance, 'Growth', 1);
                            /*if (balance.balance != "" && balance.startData != "" && balance.baseData != "") {
                                createChart(balance.balance, balance.startData, balance.baseData, 'growth');
                                createChart(growth.balance, growth.startData, growth.baseData, 'balance');
                            }*/
                            $('#userData1').html(response.data);
                            $('.userdetails').DataTable();
                            $('.paging_simple_numbers').removeClass('dataTables_paginate');
                            // $('#DataTables_Table_0_paginate').removeClass('dataTables_paginate');
                        } else {
                            // $('#grapharea').html('<br><h3 style="margin-left:10px;">No Data Available</h3><br>');
                            $('#grapharea').css('display', 'none');
                            $('.emptyValue').removeClass('hide');
                        }
                    }

                }
            });
        });

        $('#user2,#tablename').change(function () {
            var userId = $('#user2').val();
            var tablename = $('#tablename').val();
            if (tablename == "") {
                $('#tableStatylyse').css("display", "");
                return false;
            } else {
                $('#tableStatylyse').css("display", "none");
            }
            if (userId == "") {
                $('#userData2').html("");
            }
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('/admin/mt4/usergraphdetails'); ?>",
                type: "POST",
                data: {
                    "user_id": userId,
                    "table": tablename
                },
                beforeSend: function () {
                    // setting a timeout
                    $('.overlay').removeClass("hide");
                },
                success: function (response) {
                    $('.overlay').addClass("hide");
                    var response = JSON.parse(response);
                    var result = response.result;
                    if (result.length == 0) {
                        $('#grapharea2').css('display', 'none');
                        $('#emptyValue2').removeClass('hide');
                        $('#userData2').html("");
                    } else {
                        var isPresent = parseInt(response.isPresent);
                        if (isPresent > 0) {
                            $('#emptyValue2').addClass('hide');
                            $('#grapharea2').css('display', '');

                            var balance = result.balance;
                            var growth = result.growth;
                            createChart(balance.balance, 'Balance', 2);
                            createChart(growth.balance, 'Growth', 2);
                            /*createChart(balance.balance, balance.startData, balance.baseData, 'growth2');
                            createChart(growth.balance, growth.startData, growth.baseData, 'balance2');*/
                            $('#userData2').html(response.data);
                            $('.userdetails').DataTable();
                            $('.paging_simple_numbers').removeClass('dataTables_paginate');
                            // $('#DataTables_Table_0_paginate').removeClass('dataTables_paginate');
                        } else {
                            $('#grapharea2').css('display', 'none');
                            $('#emptyValue2').removeClass('hide');
                        }
                    }
                }
            });
        });
    });
</script>
<script>
    //var seriesOptions = [], seriesCounter = 0, names = ['Balance', 'Equity'];
    /**
     * Create the chart when all data is loaded
     * @returns {undefined}
     */
    function createChart(baldata, type, tabId) {
        //var base = baseData;
        Highcharts.stockChart('container' + type + tabId, {

            rangeSelector: {
                selected: 5
            },
            chart: {
                height: 500,
                type: 'line'
            },
            yAxis: {
                labels: {
                    /*formatter: function () {
                        if(type == 'growth'){
                            return (this.value > 0 ? ' + ' : '') + this.value + '%';
                        } else {
                            return (this.value > 0 ? ' + ' : '') + this.value;
                        }

                    }*/
                },
                plotLines: [{
                    value: 0,
                    width: 2,
                    color: 'silver'
                }],
                opposite: false
            },
            tooltip: {
                /*formatter: function(args){
                    var s = "";
                    $.each(this.points, function(i, point){
                        if(i < 2 ){
                            if(type == 'growth'){
                                var perc = (this.y + 100)*base/100;
                                s += '<span style="color:' + this.series.color +'">' + this.series.name + ': <b>' + Highcharts.numberFormat(perc,2) + '</b><b> (' + Highcharts.numberFormat(this.y,2) + '%) </b><br></span>'
                            } else {
                                var perc = (this.y - base)*100/base;
                                s += '<span style="color:' + this.series.color +'">' + this.series.name + ': <b>' + Highcharts.numberFormat(this.y,2) + '</b><b> (' + Highcharts.numberFormat(perc,2) + '%) </b><br>'
                            }

                        }
                    });
                    return s;
                },*/
                shared: true
            },

            series: [{
                name: type,
                data: baldata
            }/*,{
                name: 'Equity',
                data: equdata,
                color: '#90ED7D'
            },*/ /*{
                name: 'Default',
                data: startdata,
                tooltip: {
                    enabled: false
                },
                color: '#686161'
            }*/],
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

</script>
