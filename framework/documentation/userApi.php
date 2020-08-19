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
    <div class="block">
        <div class="block-content block-content-full block-content-narrow">
            <!-- Introduction -->
            <h4 class="h4 font-w600 push-30-t push">Add User</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/user/add</p>
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
                        <div class="json-format" id="api-user-add"></div>
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
                        <div class="json-format" id="user-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="user-unsuccess"></div>
                    </div>
                </div>
            </div>

            <!-- Update -->
            <h4 class="h4 font-w600 push-30-t push">Update User</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/user/update/1
            </>
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
                        <div class="json-format" id="user-update-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="user-update-unsuccess"></div>
                    </div>
                </div>
            </div>
            <!--End update-->
            <!-- View -->
            <h4 class="h4 font-w600 push-30-t push">View All User</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/user</>
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
            <h4 class="h4 font-w600 push-30-t push">View Specific User</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/user/2</>
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
            <h4 class="h4 font-w600 push-30-t push">Delete User</h4>
            <p><b>End Point : </b><?php echo Yii::app()->params['siteUrl'] ?>/app/api/user/delete/1
            </>
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
                        <div class="json-format" id="user-delete-success"></div>
                        </p>
                        <p><b>Unsuccessful Response : </b>
                        <div class="json-format" id="user-delete-unsuccess"></div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var obj = <?php echo json_encode($UserAddArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("api-user-add", obj);

        var update_obj = <?php echo json_encode($UserUpdateArray, JSON_PRETTY_PRINT); ?>;
        prettyJson("update_data", update_obj);

        var viewAll_obj = <?php echo json_encode($UserViewAll, JSON_PRETTY_PRINT); ?>;
        prettyJson("view_all_data", viewAll_obj);

        var viewSingle_obj = <?php echo json_encode($UserSingle, JSON_PRETTY_PRINT); ?>;
        prettyJson("view_single_data", viewSingle_obj);

        var user_save_success = <?php echo json_encode($UserAddResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-success", user_save_success);

        var user_save_unsuccess = <?php echo json_encode($UserAddResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-unsuccess", user_save_unsuccess);

        var user_update_success = <?php echo json_encode($UserUpdateResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-update-success", user_update_success);

        var user_update_unsuccess = <?php echo json_encode($UserUpdateResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-update-unsuccess", user_update_unsuccess);

        var user_delete_success = <?php echo json_encode($UserDeleteResponnse['success'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-delete-success", user_delete_success);

        var user_delete_unsuccess = <?php echo json_encode($UserDeleteResponnse['unsuccess'], JSON_PRETTY_PRINT); ?>;
        prettyJson("user-delete-unsuccess", user_delete_unsuccess);

    });
</script>