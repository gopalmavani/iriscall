<?php
/* @var $this CylFieldsController */
/* @var $model CylFields */
/* @var $form CActiveForm */
$currentApp = file_get_contents("../common/.current");
?>
<div class="block-content">
    <h3 class="sub-heading">Documentation<span class="pull-right">2 OF 2</span></h3>
</div>
<div class="content content-boxed">
    <div class="block">
        <div class="block-content block-content-full block-content-narrow">
            <h4 class="h4 font-w600 push-30-t push">Add Wallet Details</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/wallet/add
            </p>
            <p><b>Type : </b>POST</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#faq1_q1">JSON Request</a>
                    </h3>
                </div>
                <div id="faq1_q1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="api-wallet-add"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#faq1_q2">JSON Response</a>
                    </h3>
                </div>
                <div id="faq1_q2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="wallet-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="wallet-unsuccess"></div>
                    </div>
                </div>
            </div>

            <h4 class="h4 font-w600 push-30-t push">View Wallet Records</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/wallet/ViewWallet
            </p>
            <p><b>Type : </b>POST</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#faq1_qv1">JSON Request</a>
                    </h3>
                </div>
                <div id="faq1_qv1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="view-wallet"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#faq1_qv2">JSON Response</a>
                    </h3>
                </div>
                <div id="faq1_qv2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="wallet-view-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="wallet-view-unsuccess"></div>
                    </div>
                </div>
            </div>


            <!-- View -->
            <h4 class="h4 font-w600 push-30-t push">Get All Portals</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/wallet/getportals</>
            <p><b>Type : </b>GET</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq3"
                           href="#faq3_q2">JSON Response</a>
                    </h3>
                </div>
                <div id="faq3_q2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="view_all_data"></div>
                    </div>
                </div>
            </div>
            <!-- View Single-->
            <h4 class="h4 font-w600 push-30-t push">Get All Wallet Type</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/wallet/2</>
            <p><b>Type : </b>Get</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq4"
                           href="#faq4_q2">JSON Response</a>
                    </h3>
                </div>
                <div id="faq4_q2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="view_single_data"></div>
                    </div>
                </div>
            </div>
            <!--End View Single-->
            <h4 class="h4 font-w600 push-30-t push">Get Denomination Type</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/wallet/GetDenominationType</>
            <p><b>Type : </b>Get </p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq5"
                           href="#faq5_dq2">JSON Response</a>
                    </h3>
                </div>
                <div id="faq5_dq2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="wallet-denomination-type"></div>
                        </p>
                    </div>
                </div>
            </div>

            <h4 class="h4 font-w600 push-30-t push">Get Currency Name</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/wallet/getcurrencyname</>
            <p><b>Type : </b>Get </p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq5"
                           href="#faq5_q2">JSON Response</a>
                    </h3>
                </div>
                <div id="faq5_q2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="wallet-currency-type"></div>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var obj = <?php echo json_encode($WalletAddArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("api-wallet-add", obj);

        var viewAll_obj = <?php echo json_encode($WalletViewPortals, JSON_PRETTY_PRINT); ?>;
        prettyJson("view_all_data", viewAll_obj);

        var viewAll_obj = <?php echo json_encode($WalletView, JSON_PRETTY_PRINT); ?>;
        prettyJson("view-wallet", viewAll_obj);

        var viewSingle_obj = <?php echo json_encode($WalletType, JSON_PRETTY_PRINT); ?>;
        prettyJson("view_single_data", viewSingle_obj);

        var viewDenomiantion_obj = <?php echo json_encode($GetDenomination, JSON_PRETTY_PRINT); ?>;
        prettyJson("wallet-denomination-type", viewDenomiantion_obj);

        var viewCurrency_obj = <?php echo json_encode($GetCurrency, JSON_PRETTY_PRINT); ?>;
        prettyJson("wallet-currency-type", viewCurrency_obj);

        var wallet_save_success = <?php echo json_encode($WalletAddResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("wallet-success", wallet_save_success);

        var wallet_save_unsuccess = <?php echo json_encode($WalletAddResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("wallet-unsuccess", wallet_save_unsuccess);

        var wallet_view_success = <?php echo json_encode($WalletResponse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("wallet-view-success", wallet_view_success);

        var wallet_view_unsuccess = <?php echo json_encode($WalletResponse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("wallet-view-unsuccess", wallet_view_unsuccess);
    });
</script>