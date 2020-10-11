<?php
$this->pageTitle = Yii::app()->name . '| Wallet';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/datatables/jquery.dataTables.css');
?>
<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Wallet</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="<?= Yii::app()->createUrl('wallet/index'); ?>" class="text-muted">All Transactions</a>
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
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-body">
                        <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block"><?= money_format('%(#1n',$balance); ?></span>
                        <div class="text-inverse-white font-weight-bolder font-size-h5 mb-2 mt-5">Current Balance</div>
                        <div class="font-weight-bold text-inverse-white font-size-sm">Including affiliates and payouts</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card card-custom bg-info bg-hover-state-info card-stretch gutter-b">
                    <div class="card-body">
                        <span class="card-title font-weight-bolder text-inverse-info font-size-h2 mb-0 mt-6 d-block"><?= money_format('%(#1n',$max_balance); ?></span>
                        <div class="text-inverse-info font-weight-bolder font-size-h5 mb-2 mt-5">Maximum Balance</div>
                        <div class="font-weight-bold text-inverse-info font-size-sm"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
                    <div class="card-body">
                        <span class="card-title font-weight-bolder text-inverse-info font-size-h2 mb-0 mt-6 d-block"><?= money_format('%(#1n',$total_payout); ?></span>
                        <div class="text-inverse-danger font-weight-bolder font-size-h5 mb-2 mt-5">Total Payouts</div>
                        <div class="font-weight-bold text-inverse-danger font-size-sm">Including wallet orders and direct payouts</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <div class="example">
                            <div class="example-preview">
                                <ul class="nav nav-tabs nav-tabs-line">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#all_trans_tab">All</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#affiliates_tab">Affiliate Earnings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#payouts_tab" tabindex="-1" aria-disabled="true">Payouts</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="all_trans_tab" role="tabpanel">
                                        <div class="row d-flex align-items-center mb-3">
                                            <div class="col-md-9 col-lg-10">
                                                <div class="checkbox-inline" style="margin: 15px">
                                                    <label for="all_trans_affiliates" class="checkbox">
                                                        <input type="checkbox" name="all_trans" id="all_trans_affiliates" value="2"
                                                                checked=""><span></span>Affiliate Earnings
                                                    </label>
                                                    <!--<label for="all_trans_cashback" class="checkbox">
                                                        <input type="checkbox" name="all_trans" id="all_trans_cashback" value="1"
                                                                checked=""><span></span>Cashback
                                                    </label>-->
                                                    <label for="all_trans_payouts" class="checkbox">
                                                        <input type="checkbox" name="all_trans" id="all_trans_payouts" value="3"
                                                                checked=""><span></span>Payouts
                                                    </label>
                                                    <!--<label for="all_trans_order_payments" class="checkbox">
                                                        <input type="checkbox" name="all_trans" id="all_trans_order_payments" value="4"
                                                                checked="">Order Payments<span></span>
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
                                                <div class="checkbox-inline" style="margin: 15px">
                                                    <label for="affiliate_first_tier" class="checkbox">
                                                        <input type="checkbox" name="affiliates" id="affiliate_first_tier" value="1"
                                                                checked=""><span></span>First Tier
                                                    </label>
                                                    <label for="affiliate_second_tier" class="checkbox">
                                                        <input type="checkbox" name="affiliates" id="affiliate_second_tier" value="2"
                                                                checked=""><span></span>Second Tier
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
                                    <div class="tab-pane" id="payouts_tab" role="tabpanel">
                                        <div class="alert alert-info mb-5 mt-5">Please note that you are eligible for payout when the total balance in your wallet reaches 50€. An administration fee of 5€ will be deducted with every payout.</div>
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
        </div>
    </div>
</div>
<script src="<?= Yii::app()->baseUrl . '/plugins/datatables/jquery.dataTables.min.js' ?>"></script>
<script type="text/javascript">

    //Default All Transactions Data
    var allTransArr = [];
    $("[name='all_trans']:checked").each(function () {
        allTransArr.push($(this).val());
    });
    getAllTransactions(allTransArr);

    //Default Affiliate Data
    var affiliateArr = [];
    $("[name='affiliates']:checked").each(function () {
        affiliateArr.push($(this).val());
    });
    getAffiliates(affiliateArr);


    //Default Payout Data
    getPayout();

    //Default Order Payment Data
    //getOrderPayment();

    //On Change event for All Transactions checkbox
    $("[name='all_trans']").change(function () {
        var allTransArr = [];
        $("[name='all_trans']:checked").each(function () {
            allTransArr.push($(this).val());
        });
        getAllTransactions(allTransArr);
    });

    //On Change event for Affiliate checkbox
    $("[name='affiliates']").change(function () {
        var affiliateArr = [];
        $("[name='affiliates']:checked").each(function () {
            affiliateArr.push($(this).val());
        });
        getAffiliates(affiliateArr);
    });

    //To Get All Transactions Data
    function getAllTransactions(checkedValues) {
        var allTransDataUrl = "<?= Yii::app()->createUrl('wallet/getAllTransactionsData'); ?>";
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
        var affiliateDataUrl = "<?= Yii::app()->createUrl('wallet/getAffiliateData'); ?>";
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
    function getPayout() {
        var payoutDataUrl = "<?= Yii::app()->createUrl('wallet/getPayoutData'); ?>";
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
        var orderPaymentUrl = "<?= Yii::app()->createUrl('wallet/getOrderPaymentData'); ?>";
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
        var dataTable = $('#' + table_name ).DataTable({
            destroy: true,
            "ordering": false
        });
        dataTable.clear().draw();
        var lenghtx = response.length;
        if(lenghtx != 0) {
            var dt = JSON.parse(response);
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
        var dataTable = $('#' + table_name ).DataTable({
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
        var lenghtx = response.length;
        if(lenghtx != 0) {
            var dt = JSON.parse(response);
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
        var dataTable = $('#' + table_name ).DataTable({
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
        var lenghtx = response.length;
        if(lenghtx != 0){
            var dt = JSON.parse(response);
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