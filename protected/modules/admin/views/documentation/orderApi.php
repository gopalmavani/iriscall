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
    <!-- Frequently Asked Questions -->
    <div class="block box1">
        <div class="block-content block-content-full block-content-narrow">
            <!-- Introduction -->
            <h4 class="h4 font-w600 push-30-t push">Add Order</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/order/add
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
                        <div class="json-format" id="api-order-add"></div>
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
                        <div class="json-format" id="order-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="order-unsuccess"></div>
                    </div>
                </div>
            </div>

            <!-- Update -->
            <h4 class="h4 font-w600 push-30-t push">Update Order</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/order/update/1</>
            <p><b>Type : </b>Put</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq2"
                           href="#faq2_q1">JSON Request</a>
                    </h3>
                </div>
                <div id="faq2_q1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="update_data"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq2"
                           href="#faq2_q2">JSON Response</a>
                    </h3>
                </div>
                <div id="faq2_q2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="order-update-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="order-update-unsuccess"></div>
                    </div>
                </div>
            </div>
            <!--End update-->

            <!-- View Single-->
            <h4 class="h4 font-w600 push-30-t push">View Order</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/order/2</>
            <p><b>Type : </b>Get</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq3"
                           href="#req">JSON Request</a>
                    </h3>
                </div>
                <div id="req" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="view_req_data"></div>
                    </div>
                </div>
            </div>
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
            <h4 class="h4 font-w600 push-30-t push">Delete Order</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/order/delete/1</>
            <p><b>Type : </b>Delete </p>
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
                        <div class="json-format" id="order-delete-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="order-delete-unsuccess"></div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END view -->
    </div>

    <div class="block box2">
        <div class="block-content block-content-full block-content-narrow">
            <!-- Introduction -->
            <h4 class="h4 font-w600 push-30-t push">Add Cart Item</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/order/addcart/
            </p>
            <p><b>Type : </b>POST</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#faq1_q12">JSON Request</a>
                    </h3>
                </div>
                <div id="faq1_q12" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="api-cart-add"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#faq1_q22">JSON Response</a>
                    </h3>
                </div>
                <div id="faq1_q22" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="cart-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="cart-unsuccess"></div>
                    </div>
                </div>
            </div>

            <!-- View -->
            <h4 class="h4 font-w600 push-30-t push">View All Cart Item</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/viewallcart</>
            <p><b>Type : </b>GET</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq3"
                           href="#faq3_q22">JSON Response</a>
                    </h3>
                </div>
                <div id="faq3_q22" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="api-cart-viewall"></div>
                    </div>
                </div>
            </div>
            <!-- View Single-->
            <h4 class="h4 font-w600 push-30-t push">View Specific Cart Item</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/order/viewcart/1</>
            <p><b>Type : </b>Get</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq4"
                           href="#faq4_q22">JSON Response</a>
                    </h3>
                </div>
                <div id="faq4_q22" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="api-cart-viewsingle"></div>
                    </div>
                </div>
            </div>
            <!--End View Single-->
            <h4 class="h4 font-w600 push-30-t push">Delete Cart Item</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/order/delete/cartdelete/1</>
            <p><b>Type : </b>Delete </p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq5"
                           href="#faq5_q22">JSON Response</a>
                    </h3>
                </div>
                <div id="faq5_q22" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="cart-delete-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="cart-delete-unsuccess"></div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END view -->
    </div>

    <div class="block">
        <div class="block-content block-content-full block-content-narrow">
            <!-- Introduction -->
            <h4 class="h4 font-w600 push-30-t push">Add Credit Memo</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/order/addmemo
            </p>
            <p><b>Type : </b>POST</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#faq1_q123">JSON Request</a>
                    </h3>
                </div>
                <div id="faq1_q123" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="api-memo-add"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#faq1_q223">JSON Response</a>
                    </h3>
                </div>
                <div id="faq1_q223" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="memo-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="memo-unsuccess"></div>
                    </div>
                </div>
            </div>

            <!-- Introduction -->
            <h4 class="h4 font-w600 push-30-t push">Update Credit Memo</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/order/addmemo
            </p>
            <p><b>Type : </b>POST</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#faq1_q12-3">JSON Request</a>
                    </h3>
                </div>
                <div id="faq1_q12-3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="api-memo-update"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#faq1_q22-3">JSON Response</a>
                    </h3>
                </div>
                <div id="faq1_q22-3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="memo-update-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="memo-update-unsuccess"></div>
                    </div>
                </div>
            </div>

            <!-- View -->
            <h4 class="h4 font-w600 push-30-t push">View All Memo Item</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/viewallcart</>
            <p><b>Type : </b>GET</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq3"
                           href="#faq3_q223">JSON Response</a>
                    </h3>
                </div>
                <div id="faq3_q223" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="api-memo-viewall"></div>
                    </div>
                </div>
            </div>
            <!-- View Single-->
            <h4 class="h4 font-w600 push-30-t push">View Specific Memo Item</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/order/viewcart/1</>
            <p><b>Type : </b>Get</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq4"
                           href="#faq4_q223">JSON Response</a>
                    </h3>
                </div>
                <div id="faq4_q223" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="api-memo-viewsingle"></div>
                    </div>
                </div>
            </div>
            <!--End View Single-->
            <h4 class="h4 font-w600 push-30-t push">Delete Memo Item</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp; ?>/api/order/delete/cartdelete/1</>
            <p><b>Type : </b>Delete </p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq5"
                           href="#faq5_q223">JSON Response</a>
                    </h3>
                </div>
                <div id="faq5_q223" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="memo-delete-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="memo-delete-unsuccess"></div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END view -->
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var obj = <?php echo json_encode($OrderAddArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("api-order-add", obj);

        var update_obj = <?php echo json_encode($OrderUpdateArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("update_data", update_obj);

        var viewreq_obj = <?php echo json_encode($OrderViewRequest, JSON_PRETTY_PRINT); ?>;
        prettyJson("view_req_data", viewreq_obj);

        var viewSingle_obj = <?php echo json_encode($OrderSingle, JSON_PRETTY_PRINT); ?>;
        prettyJson("view_single_data", viewSingle_obj);

        var order_save_success = <?php echo json_encode($OrderAddResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("order-success", order_save_success);

        var order_save_unsuccess = <?php echo json_encode($OrderAddResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("order-unsuccess", order_save_unsuccess);

        var order_update_success = <?php echo json_encode($OrderUpdateResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("order-update-success", order_update_success);

        var order_update_unsuccess = <?php echo json_encode($OrderUpdateResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("order-update-unsuccess", order_update_unsuccess);

        var order_delete_success = <?php echo json_encode($OrderDeleteResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("order-delete-success", order_delete_success);

        var order_delete_unsuccess = <?php echo json_encode($OrderDeleteResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("order-delete-unsuccess", order_delete_unsuccess);

        var cartadd = <?php echo json_encode($CartAddArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("api-cart-add", cartadd);

        var cartviewall = <?php echo json_encode($CartViewAll, JSON_PRETTY_PRINT); ?>;
        prettyJson("api-cart-viewall", cartviewall);

        var cartviewsingle = <?php echo json_encode($CartSingle, JSON_PRETTY_PRINT); ?>;
        prettyJson("api-cart-viewsingle", cartviewsingle);

        var cart_save_success = <?php echo json_encode($OrderAddResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("cart-success", cart_save_success);

        var cart_save_unsuccess = <?php echo json_encode($OrderAddResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("cart-unsuccess", cart_save_unsuccess);

        var cart_delete_success = <?php echo json_encode($OrderDeleteResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("cart-delete-success", cart_delete_success);

        var cart_delete_unsuccess = <?php echo json_encode($OrderDeleteResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("cart-delete-unsuccess", cart_delete_unsuccess);

        //memo api json
        var memoadd = <?php echo json_encode($MemoAddArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("api-memo-add", memoadd);

        var memoupdate = <?php echo json_encode($MemoUpdateArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("api-memo-update", memoupdate);

        var memoviewall = <?php echo json_encode($MemoViewallArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("api-memo-viewall", memoviewall);

        var memoviewsingle = <?php echo json_encode($MemoViewsingleArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("api-memo-viewsingle", memoviewsingle);

        var memo_success = <?php echo json_encode($OrderAddResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("memo-success", memo_success);

        var memo_unsuccess = <?php echo json_encode($OrderAddResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("memo-unsuccess", memo_unsuccess);

        var cart_update_success = <?php echo json_encode($OrderUpdateResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("memo-update-success", cart_update_success);

        var cart_update_unsuccess = <?php echo json_encode($OrderUpdateResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("memo-update-unsuccess", cart_update_unsuccess);

        var cart_delete_success = <?php echo json_encode($OrderDeleteResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("memo-delete-success", cart_delete_success);

        var cart_delete_unsuccess = <?php echo json_encode($OrderDeleteResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("memo-delete-unsuccess", cart_delete_unsuccess);


    });
</script>