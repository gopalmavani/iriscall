<?php
/* @var $this CylFieldsController */
/* @var $model CylFields */
/* @var $form CActiveForm */
?>
<div class="block-content">
    <h3 class="sub-heading">Documentation<span class="pull-right"></span></h3>
</div>

<div class="content content-boxed">
    <!-- Frequently Asked Questions -->
    <div class="block box2">
        <div class="block-content block-content-full block-content-narrow">
            <!-- Introduction -->
            <h4 class="h4 font-w600 push-30-t push">Add Product License</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/product/ProductLicenseAdd
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
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/product/ProductLicenseUpdate/1</p>
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
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/product/ViewProductLicenses</p>
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
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/product/ViewProductLicense/1</p>
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
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/ProductLicenseDelete/1</p>
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
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/product/UserLicenseAdd
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
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/product/UserLicenseUpdate/1</p>
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
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/product/ViewUserLicenses</p>
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
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/product/ViewUserLicense/1</p>
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
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/product/UserLicenseDelete/1</p>
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
        prettyJson("productlicense-delete-unsuccess", productlicense_delete_unsuccess);

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
        prettyJson("user-license-delete-unsuccess", userlicense_delete_unsuccess);

        var userLicenseAdd = <?php echo json_encode($userLicense_add, JSON_PRETTY_PRINT); ?>;
        var test = prettyJson("user-license-add", userLicenseAdd);

        var userLicenseUpdate = <?php echo json_encode($userLicense_update, JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-update", userLicenseUpdate);

        var userLicenseViewall = <?php echo json_encode($userLicense_viewall, JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-viewall", userLicenseViewall);

        var userLicenseViewSingle = <?php echo json_encode($userLicense_viewsingle, JSON_PRETTY_PRINT); ?>;
        prettyJson("user-license-viewsingle", userLicenseViewSingle);


    });
</script>