<?php
/**
 * Created by PhpStorm.
 * User: Deepak
 * Date: 2/2/2017
 * Time: 5:54 PM
 */

//echo "<pre>";
//print_r($data->username); die;
?>

<form action="pages_profile_edit.html" method="post" onsubmit="return false;">
    <div class="block">

        <!-- Password Tab -->
        <div class="block-header">
            <h4 class="page-heading">Change Password</h4>
        </div>
        <div class="row items-push">
            <div class="col-sm-5 col-sm-offset-3 form-horizontal">
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="profile-password">Current Password</label>
                        <input class="form-control" type="password" id="profile-password"
                               name="profile-password">
                        <div id="pass-mismatch"></div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="profile-password-new">New Password</label>
                        <input class="form-control" type="password" id="profile-password-new"
                               name="profile-password-new">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="profile-password-new-confirm">Confirm New Password</label>
                        <input class="form-control" type="password" id="profile-password-new-confirm" name="profile-password-new-confirm">
                    </div>
                    <div id="check"></div>
                </div>
                <div class="block-content block-content-full text-center">
                    <button class="btn btn-sm change-pass btn-primary" type="submit"><i class="fa fa-check push-5-r"></i> Change Password
                    </button>
                    <div id="password-success-change"></div>

                </div>
            </div>
        </div>
            <!-- END Password Tab -->
    </div>
</form>

<script>
    var EditAdmin = '<?php echo Yii::app()->createUrl('admin/admin/UpdateEmail'); ?>';
    var ChangePass = '<?php echo Yii::app()->createUrl('admin/admin/ChangePass'); ?>';
</script>