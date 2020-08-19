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
    <div class="block box1" style="display: none;">
        <div class="block-content block-content-full block-content-narrow">
            <!-- Introduction -->
            <h4 class="h4 font-w600 push-30-t push">Add Product Info</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/add
            </p>
            <p><b>Type : </b>POST</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#productInfo-faq1">JSON Request</a>
                    </h3>
                </div>
                <div id="productInfo-faq1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="product-info-add"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#productInfo-faq1-2">JSON Response</a>
                    </h3>
                </div>
                <div id="productInfo-faq1-2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="product-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="product-unsuccess"></div>
                    </div>
                </div>
            </div>

            <!-- Update -->
            <h4 class="h4 font-w600 push-30-t push">Update Product Info</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/update/1</p>
            <p><b>Type : </b>Put</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq2"
                           href="#productInfo-faq2">JSON Request</a>
                    </h3>
                </div>
                <div id="productInfo-faq2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="product-info-update"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq2"
                           href="#productInfo-faq2-2">JSON Response</a>
                    </h3>
                </div>
                <div id="productInfo-faq2-2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="product-update-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="product-update-unsuccess"></div>
                    </div>
                </div>
            </div>
            <!--End update-->
            <!-- View -->
            <h4 class="h4 font-w600 push-30-t push">View All Product Info</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product</p>
            <p><b>Type : </b>GET</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq3"
                           href="#productInfo-faq3">JSON Response</a>
                    </h3>
                </div>
                <div id="productInfo-faq3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="product-info-viewall"></div>
                    </div>
                </div>
            </div>
            <!-- View Single-->
            <h4 class="h4 font-w600 push-30-t push">View Specific Product Info</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/2</p>
            <p><b>Type : </b>Get</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq4"
                           href="#productInfo-faq4">JSON Response</a>
                    </h3>
                </div>
                <div id="productInfo-faq4" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="product-info-viewsingle"></div>
                    </div>
                </div>
            </div>
            <!--End View Single-->
            <h4 class="h4 font-w600 push-30-t push">Delete Product Info</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/delete/1</p>
            <p><b>Type : </b>Delete </p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq5"
                           href="#productInfo-faq5">JSON Response</a>
                    </h3>
                </div>
                <div id="productInfo-faq5" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="product-delete-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="product-delete-unsuccess"></div>
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
            <h4 class="h4 font-w600 push-30-t push">Add Product License</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/ProductLicenseAdd
            </p>
            <p><b>Type : </b>POST</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#productLicense_faq1">JSON Request</a>
                    </h3>
                </div>
                <div id="productLicense_faq1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="api-product-add"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#productLicense_faq1-2">JSON Response</a>
                    </h3>
                </div>
                <div id="productLicense_faq1-2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="productlicense-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="productlicense-unsuccess"></div>
                    </div>
                </div>
            </div>

            <!-- Update -->
            <h4 class="h4 font-w600 push-30-t push">Update Product License</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/ProductLicenseUpdate/1</p>
            <p><b>Type : </b>Put</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq2"
                           href="#productLicense_faq2">JSON Request</a>
                    </h3>
                </div>
                <div id="productLicense_faq2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="update_data"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq2"
                           href="#productLicense_faq2-2">JSON Response</a>
                    </h3>
                </div>
                <div id="productLicense_faq2-2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="productlicense-update-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="productlicense-update-unsuccess"></div>
                    </div>
                </div>
            </div>
            <!--End update-->
            <!-- View -->
            <h4 class="h4 font-w600 push-30-t push">View All Product License</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/ViewProductLicenses</p>
            <p><b>Type : </b>GET</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq3"
                           href="#productLicense_faq3">JSON Response</a>
                    </h3>
                </div>
                <div id="productLicense_faq3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="view_all_data"></div>
                    </div>
                </div>
            </div>
            <!-- View Single-->
            <h4 class="h4 font-w600 push-30-t push">View Specific Product License</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/ViewProductLicense/1</p>
            <p><b>Type : </b>Get</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq4"
                           href="#productLicense_faq3-2">JSON Response</a>
                    </h3>
                </div>
                <div id="productLicense_faq3-2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="view_single_data"></div>
                    </div>
                </div>
            </div>
            <!--End View Single-->
            <h4 class="h4 font-w600 push-30-t push">Delete Product License</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>ProductLicenseDelete/1</p>
            <p><b>Type : </b>Delete </p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq5"
                           href="#productLicense_faq4">JSON Response</a>
                    </h3>
                </div>
                <div id="productLicense_faq4" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="productlicense-delete-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="productlicense-delete-unsuccess"></div>
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
            <h4 class="h4 font-w600 push-30-t push">Add User License</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/UserLicenseAdd
            </p>
            <p><b>Type : </b>POST</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#userlicense-faq1">JSON Request</a>
                    </h3>
                </div>
                <div id="userlicense-faq1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="user-license-add"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1"
                           href="#userlicense-faq2">JSON Response</a>
                    </h3>
                </div>
                <div id="userlicense-faq2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="user-license-success"></div>
                        <
                        /p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="user-license-unsuccess"></div>
                    </div>
                </div>
            </div>

            <!-- Update -->
            <h4 class="h4 font-w600 push-30-t push">Update User Licenses</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/UserLicenseUpdate/1</p>
            <p><b>Type : </b>Put</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq2"
                           href="#userlicense-faq3">JSON Request</a>
                    </h3>
                </div>
                <div id="userlicense-faq3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="user-license-update"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq2"
                           href="#userlicense-faq4">JSON Response</a>
                    </h3>
                </div>
                <div id="userlicense-faq4" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="user-license-update-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="user-license-update-unsuccess"></div>
                    </div>
                </div>
            </div>
            <!--End update-->
            <!-- View -->
            <h4 class="h4 font-w600 push-30-t push">View All User Licenses</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/ViewUserLicenses</p>
            <p><b>Type : </b>GET</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq3"
                           href="#userlicense-faq5">JSON Response</a>
                    </h3>
                </div>
                <div id="userlicense-faq5" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="user-license-viewall"></div>
                    </div>
                </div>
            </div>
            <!-- View Single-->
            <h4 class="h4 font-w600 push-30-t push">View Specific User License</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/ViewUserLicense/1</p>
            <p><b>Type : </b>Get</p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq4"
                           href="#userlicense-faq6">JSON Response</a>
                    </h3>
                </div>
                <div id="userlicense-faq6" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="json-format" id="user-license-viewsingle"></div>
                    </div>
                </div>
            </div>
            <!--End View Single-->
            <h4 class="h4 font-w600 push-30-t push">Delete User License</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/<?php echo $currentApp;  ?>/api/product/UserLicenseDelete/1</p>
            <p><b>Type : </b>Delete </p>
            <p><b>Content Type : </b>application/json</p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq5"
                           href="#userlicense-faq7">JSON Response</a>
                    </h3>
                </div>
                <div id="userlicense-faq7" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p><b>Successful Response : </b>
                        <div class="json-format" id="user-license-delete-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="user-license-delete-unsuccess"></div>
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

        var productlicense_save_success = <?php echo json_encode($ProductAddResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("productlicense-success", productlicense_save_success);

        var productlicense_save_unsuccess = <?php echo json_encode($ProductAddResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("productlicense-unsuccess", productlicense_save_unsuccess);

        var productlicense_update_success = <?php echo json_encode($ProductUpdateResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("productlicense-update-success", productlicense_update_success);

        var productlicense_update_unsuccess = <?php echo json_encode($ProductUpdateResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("productlicense-update-unsuccess", productlicense_update_unsuccess);

        var productlicense_delete_success = <?php echo json_encode($ProductDeleteResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("productlicense-delete-success", productlicense_delete_success);

        var productlicense_delete_unsuccess = <?php echo json_encode($ProductDeleteResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("productlicense-delete-unsuccess", product_delete_unsuccess);

        var obj = <?php echo json_encode($ProductAddArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("api-product-add", obj);

        var update_obj = <?php echo json_encode($ProductUpdateArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("update_data", update_obj);

        var viewAll_obj = <?php echo json_encode($ProductViewAll, JSON_PRETTY_PRINT); ?>;
        prettyJson("view_all_data", viewAll_obj);

        var viewSingle_obj = <?php echo json_encode($ProductSingle, JSON_PRETTY_PRINT); ?>;
        prettyJson("view_single_data", viewSingle_obj);

        var product_save_success = <?php echo json_encode($ProductAddResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("product-success", product_save_success);

        var product_save_unsuccess = <?php echo json_encode($ProductAddResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("product-unsuccess", product_save_unsuccess);

        var product_update_success = <?php echo json_encode($ProductUpdateResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("product-update-success", product_update_success);

        var product_update_unsuccess = <?php echo json_encode($ProductUpdateResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("product-update-unsuccess", product_update_unsuccess);

        var product_delete_success = <?php echo json_encode($ProductDeleteResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("product-delete-success", product_delete_success);

        var product_delete_unsuccess = <?php echo json_encode($ProductDeleteResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("product-delete-unsuccess", product_delete_unsuccess);

//        var productInfoAdd = <?php //echo json_encode($productInfo_add, JSON_PRETTY_PRINT); ?>//;
//        prettyJson("product-info-add", productInfoAdd);
//
//        var productInfoUpdate = <?php //echo json_encode($productInfo_update, JSON_PRETTY_PRINT); ?>//;
//        prettyJson("product-info-update", productInfoUpdate);
//
//        var productInfoViewall = <?php //echo json_encode($productInfo_viewall, JSON_PRETTY_PRINT); ?>//;
//        prettyJson("product-info-viewall", productInfoViewall);
//
//        var productInfoViewSingle = <?php //echo json_encode($productInfo_viewsingle, JSON_PRETTY_PRINT); ?>//;
//        prettyJson("product-info-viewsingle", productInfoViewSingle);


        var userlicense_save_success = <?php echo json_encode($ProductAddResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-success", userlicense_save_success);

        var userlicense_save_unsuccess = <?php echo json_encode($ProductAddResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-unsuccess", userlicense_save_unsuccess);

        var userlicense_update_success = <?php echo json_encode($ProductUpdateResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-update-success", userlicense_update_success);

        var userlicense_update_unsuccess = <?php echo json_encode($ProductUpdateResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-update-unsuccess", userlicense_update_unsuccess);

        var userlicense_delete_success = <?php echo json_encode($ProductDeleteResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-delete-success", userlicense_delete_success);

        var userlicense_delete_unsuccess = <?php echo json_encode($ProductDeleteResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-delete-unsuccess", product_delete_unsuccess);

        var userLicenseAdd = <?php echo json_encode($userLicense_add, JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-add", userLicenseAdd);

        var userLicenseUpdate = <?php echo json_encode($userLicense_update, JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-update", userLicenseUpdate);

        var userLicenseViewall = <?php echo json_encode($userLicense_viewall, JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-viewall", userLicenseViewall);

        var userLicenseViewSingle = <?php echo json_encode($userLicense_viewsingle, JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-viewsingle", userLicenseViewSingle);


    });
</script>