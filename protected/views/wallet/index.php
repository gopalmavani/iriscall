<?php
$this->pageTitle = Yii::app()->name . '| Wallet';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/datatables/jquery.dataTables.css');
?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
            <!-- begin:: Subheader -->
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-container kt-container--fluid ">
                    <div class="kt-subheader__main">
                        <h3 class="kt-subheader__title"> Wallet </h3>
                        <span class="kt-subheader__separator kt-hidden"></span>
                        <div class="kt-subheader__breadcrumbs"> <a href="<?= Yii::app()->createUrl('wallet/index'); ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a> <span class="kt-subheader__breadcrumbs-separator"></span> <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Wallet</span> </div>
                    </div>
                </div>
            </div>
            <!-- end:: Subheader -->
            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="kt-portlet kt-portlet--skin-solid kt-bg-brand kt-portlet--height-fluid">
                            <div class="kt-portlet__body">
                                <div class="kt-portlet__content">
                                    <h1><?= money_format('%(#1n',$balance); ?></h1>
                                    <div>Current Balance</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <!--begin::Portlet-->
                        <div class="kt-portlet kt-portlet--skin-solid kt-bg-success kt-portlet--height-fluid">
                            <div class="kt-portlet__body">
                                <div class="kt-portlet__content">
                                    <h1><?= money_format('%(#1n',$max_balance); ?></h1>
                                    <div>Maximum Balance</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Portlet-->
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <!--begin::Portlet-->
                        <div class="kt-portlet kt-portlet--skin-solid kt-bg-warning kt-portlet--height-fluid">
                            <div class="kt-portlet__body">
                                <div class="kt-portlet__content">
                                    <h1><?= money_format('%(#1n',$total_payout); ?></h1>
                                    <div>Total Payouts</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="kt-portlet">
                            <div class="kt-portlet__body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#all_trans_tab"
                                                            role="tab"><span
                                                    class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                                    class="hidden-xs-down">All</span></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#affiliates_tab"
                                                            role="tab"><span
                                                    class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                                    class="hidden-xs-down">Affiliate Earnings</span></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#commissions_tab"
                                                            role="tab"><span
                                                    class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                                    class="hidden-xs-down">Cashback</span></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#payouts_tab" role="tab"><span
                                                    class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                                    class="hidden-xs-down">Payouts</span></a></li>
                                    <!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#order_payments_tab" role="tab"><span
                                                    class="hidden-sm-up"><i class="ti-email"></i></span><span
                                                    class="hidden-xs-down">Order Payments</span></a></li>-->
                                    <li class="nav-item" style="display: none"><a class="nav-link" data-toggle="tab" href="#withdrawals_tab" role="tab"><span
                                                    class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                                    class="hidden-xs-down">Withdrawals</span></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="all_trans_tab" role="tabpanel">
                                        <div class="row d-flex align-items-center mb-3">
                                            <div class="col-md-9 col-lg-10">
                                                <div class="kt-checkbox-inline checkbox-group" style="text-align: center">
                                                    <label for="all_trans_affiliates" class="kt-checkbox">
                                                        <input type="checkbox" name="all_trans" id="all_trans_affiliates" value="2"
                                                               class="filled-in chk-col-custom-light-blue" checked="">Affiliate Earnings<span></span>
                                                    </label>
                                                    <label for="all_trans_cashback" class="kt-checkbox">
                                                        <input type="checkbox" name="all_trans" id="all_trans_cashback" value="1"
                                                               class="filled-in chk-col-custom-light-blue" checked="">Cashback<span></span>
                                                    </label>
                                                    <label for="all_trans_payouts" class="kt-checkbox">
                                                        <input type="checkbox" name="all_trans" id="all_trans_payouts" value="3"
                                                               class="filled-in chk-col-custom-light-blue" checked="">Payouts<span></span>
                                                    </label>
                                                    <!--<label for="all_trans_order_payments" class="kt-checkbox">
                                                        <input type="checkbox" name="all_trans" id="all_trans_order_payments" value="4"
                                                               class="filled-in chk-col-custom-light-blue" checked="">Order Payments<span></span>
                                                    </label>-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive table-responsive3 mb-4">
                                            <table class="table table-wallet" id="all_trans_table">
                                                <thead role="rowgroup" class="thead-light">
                                                <tr>
                                                    <th role="columnheader">Type</th>
                                                    <th role="columnheader">Description</th>
                                                    <th role="columnheader">Amount</th>
                                                    <th role="columnheader">Status</th>
                                                    <th role="columnheader">Date</th>
                                                    <th role="columnheader" style="display: none">Sorting Date</th>
                                                </tr>
                                                </thead>
                                                <tbody id="all_trans_table_body" role="rowgroup"></tbody>
                                            </table>
                                            <div class="pages" align="right">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="affiliates_tab" role="tabpanel">
                                        <div class="row d-flex align-items-center mb-3">
                                            <div class="col-md-9 col-lg-10">
                                                <div class="kt-checkbox-inline checkbox-group" style="text-align: center">
                                                    <label for="affiliate_first_tier" class="kt-checkbox">
                                                        <input type="checkbox" name="affiliates" id="affiliate_first_tier" value="1"
                                                               class="filled-in chk-col-custom-light-blue" checked="">First Tier<span></span>
                                                    </label>
                                                    <label for="affiliate_second_tier" class="kt-checkbox">
                                                        <input type="checkbox" name="affiliates" id="affiliate_second_tier" value="2"
                                                               class="filled-in chk-col-custom-light-blue" checked="">Second Tier<span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-wallet" id="affiliate_table">
                                                <thead>
                                                <tr>
                                                    <th>Tier</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Order Id</th>
                                                    <th>From</th>
                                                    <th>Date</th>
                                                </tr>
                                                </thead>
                                                <tbody id="affiliate_table_body"></tbody>
                                            </table>
                                            <div class="pages" align="right"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="commissions_tab" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-wallet" id="commission_table">
                                                <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                </tr>
                                                </thead>
                                                <tbody id="commission_table_body"></tbody>
                                            </table>
                                            <div class="pages" align="right"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="payouts_tab" role="tabpanel">
                                        <div class="alert alert-info">Please note that you are eligible for payout when the total balance in your wallet reaches 50€. An administration fee of 5€ will be deducted with every payout.</div>
                                        <div class="table-responsive">
                                            <table class="table table-wallet" id="payout_table">
                                                <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Paid On</th>
                                                </tr>
                                                </thead>
                                                <tbody id="payout_table_body"></tbody>
                                            </table>
                                            <div class="pages" align="right"></div>
                                        </div>
                                    </div>
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
<script src="<?= Yii::app()->baseUrl . '/plugins/datatables/jquery.dataTables.min.js' ?>"></script>
<script type="text/javascript">

    //Default All Transactions Data
    let allTransArr = [];
    $("[name='all_trans']:checked").each(function () {
        allTransArr.push($(this).val());
    });
    getAllTransactions(allTransArr);

    //Default Affiliate Data
    let affiliateArr = [];
    $("[name='affiliates']:checked").each(function () {
        affiliateArr.push($(this).val());
    });
    getAffiliates(affiliateArr);

    //Default Commissions Data
    getCommissions();

    //Default Payout Data
    getPayout();

    //Default Order Payment Data
    //getOrderPayment();

    //On Change event for All Transactions checkbox
    $("[name='all_trans']").change(function () {
        let allTransArr = [];
        $("[name='all_trans']:checked").each(function () {
            allTransArr.push($(this).val());
        });
        getAllTransactions(allTransArr);
    });

    //On Change event for Affiliate checkbox
    $("[name='affiliates']").change(function () {
        let affiliateArr = [];
        $("[name='affiliates']:checked").each(function () {
            affiliateArr.push($(this).val());
        });
        getAffiliates(affiliateArr);
    });

    //On Change event for Commission checkbox
    /*$("[name='commissions']").change(function () {
        let commissionArr = [];
        $("[name='commissions']:checked").each(function () {
            commissionArr.push($(this).val());
        });
        getCommissions(commissionArr);
    });*/

    //To Get All Transactions Data
    function getAllTransactions(checkedValues) {
        let allTransDataUrl = "<?= Yii::app()->createUrl('wallet/getAllTransactionsData'); ?>";
        $.ajax({
            url: allTransDataUrl,
            type: "POST",
            data: {
                data: checkedValues
            },
            success: function (response) {
                setDataInAllTransactionTables(response, 'all_trans_table');
            }
        });
    }

    //To Get Affiliate Data
    function getAffiliates(checkedValues) {
        let affiliateDataUrl = "<?= Yii::app()->createUrl('wallet/getAffiliateData'); ?>";
        $.ajax({
            url: affiliateDataUrl,
            type: "POST",
            data: {
                data: checkedValues
            },
            success: function (response) {
                //$("#example").dataTable().fnDestroy();
                setDataInAffiliateTables(response, 'affiliate_table');
            }
        });
    }

    //To Get Commission Data
    function getCommissions() {
        let commissionDataUrl = "<?= Yii::app()->createUrl('wallet/getCommissionData'); ?>";
        $.ajax({
            url: commissionDataUrl,
            type: "POST",
            success: function (response) {
                setDataInTables(response, 'commission_table');
            }
        });
    }

    //To Get Commission Data
    function getPayout() {
        let payoutDataUrl = "<?= Yii::app()->createUrl('wallet/getPayoutData'); ?>";
        $.ajax({
            url: payoutDataUrl,
            type: "POST",
            success: function (response) {
                setDataInTables(response, 'payout_table');
            }
        });
    }

    //To Get Order Payment Data
    function getOrderPayment() {
        let orderPaymentUrl = "<?= Yii::app()->createUrl('wallet/getOrderPaymentData'); ?>";
        $.ajax({
            url: orderPaymentUrl,
            type: "POST",
            success: function (response) {
                setDataInTables(response, 'order_payments_table');
            }
        });
    }

    //To Set data in the table view
    function setDataInTables(response, table_name) {
        if(table_name == 'commission_table'){
            var dataTable = $('#' + table_name ).DataTable({
                destroy: true,
                "columnDefs": [
                    {
                        "targets": [ 4 ],
                        "visible": false
                    },
                    {
                        "targets": [1,2],
                        "width": "25%"
                    }
                ],
                "ordering": false
            });
        } else {
            var dataTable = $('#' + table_name ).DataTable({
                destroy: true,
                "ordering": false
            });
        }
        dataTable.clear().draw();
        let lenghtx = response.length;
        if(lenghtx != 0) {
            let dt = JSON.parse(response);
            $.each(dt, function (index, value) {
                dataTable.row.add([
                    value.description,
                    value.earnings,
                    value.transaction_status,
                    value.date,
                    value.earning_date
                ]).draw(false);
            });
        }
    }

    //To set data in All Transaction table
    function setDataInAllTransactionTables(response, table_name) {
        let dataTable = $('#' + table_name ).DataTable({
            destroy: true,
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [0, 1, 3, 4]
                },
                {
                    "targets": [ 5 ],
                    "visible": false
                },
                { width: '20%', targets: [0, 1, 2, 3, 4] }
            ],
            "order": [[ 5, "desc" ]]
        });
        dataTable.clear().draw();
        let lenghtx = response.length;
        if(lenghtx != 0) {
            let dt = JSON.parse(response);
            $.each(dt, function (index, value) {
                dataTable.row.add([
                    value.scheme,
                    value.description,
                    value.earnings,
                    value.transaction_status,
                    value.date,
                    value.sorting_date
                ]).draw(false);
            });
        }
    }

    //To set data in affiliate table
    function setDataInAffiliateTables(response, table_name) {
        //CSS width is necessary because of tabbed view
        $('#' + table_name ).css("width","100%");
        let dataTable = $('#' + table_name ).DataTable({
            destroy: true,
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [2, 3, 4]
                }
            ],
            "columns": [
                { "width": "10%" },
                { "width": "18%" },
                { "width": "18%" },
                { "width": "18%" },
                { "width": "18%" },
                { "width": "18%" }
            ],
            "order": [[ 5, "desc" ]]
        });
        dataTable.clear().draw();
        let lenghtx = response.length;
        if(lenghtx != 0){
            let dt = JSON.parse(response);
            $.each(dt, function (index, value) {
                dataTable.row.add([
                    value.tier,
                    value.earnings,
                    value.transaction_status,
                    value.order_id,
                    value.from,
                    value.date
                ]).draw(false);
            });
        }
    }
</script>