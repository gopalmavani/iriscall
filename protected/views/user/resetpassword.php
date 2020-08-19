<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Login';
?>
<style>
    #password-strength-status-forget {padding: 5px 10px;color: #FFFFFF; border-radius:4px;margin-top:5px;}
    .medium-password{background-color: #E4DB11;border:#BBB418 1px solid;}
    .weak-password{background-color: #FF6600;border:#AA4502 1px solid;}
    .strong-password{background-color: #12CC1A;border:#0FA015 1px solid;}
</style>
<main id="main-container">
    <!-- Hero Content -->
    <div class="bg-primary-dark">
        <section class="content no-padding content-full content-boxed overflow-hidden">
            <div class="push-100-t push-50 text-center">
                <h2 class="box-title m-b-20">Update your password</h2>
            </div>
        </section>
    </div>
    <!-- Log In Form -->
    <div class="bg-white">
        <section class="content content-boxed">
            <!-- Section Content -->
            <div class="row items-push push-50-t push-30">
                <div class="col-md-12 col-md-offset-3">
                    <form class="form-horizontal" id="reset-form" action="<?php echo Yii::app()->getBaseUrl(true); ?>/user/passwordreset" method="post">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary">
                                    <label for="frontend-login-username">Enter new password</label>
                                    <input type="password" id="new_pass" name="new-password" class="form-control">
                                    <span class="errornew" style="color:red"></span><br />
                                    <div id="password-strength-status-forget"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 5px;">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary">
                                    <label for="frontend-login-username">Confirm new password</label>
                                    <input type="password" id="c_pass" name="confirm-password" class="form-control">
                                    <span class="error" style="color:red"></span><br />

                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 8px;">
                            <div id="mismatch" class="mismatch"></div>
                        </div>

                        <div class="form-group" style="margin-top: 25px;margin-bottom: 0;">
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                                    <button id="changePass" class="btn btn-block btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="user_id" name="user-id" value="<?php echo (isset($user->user_id)) ? $user->user_id : '' ?>">
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
<script>
    $(document).ready(function() {
        $('#new_pass').keyup(function(){
             //console.log("pass");
            checkPasswordStrength();
        });
    });
    function checkPasswordStrength() {
        var number = /([0-9])/;
        var alphabets = /([a-z])/;
        var special_characters = /([A-Z])/;
        $('.errornew').text('');
        if($('#new_pass').val().length<8) {
            $('#password-strength-status-forget').removeClass();
            $('#password-strength-status-forget').addClass('weak-password');
            $('#password-strength-status-forget').html("Weak (should be atleast 8 characters with capital,small and number.)");
        } else {
            if($('#new_pass').val().match(number) && $('#new_pass').val().match(alphabets) && $('#new_pass').val().match(special_characters)) {
                $('#password-strength-status-forget').removeClass();
                $('#password-strength-status-forget').addClass('strong-password');
                $('#password-strength-status-forget').html("Strong");
            } else {
                $('#password-strength-status-forget').removeClass();
                $('#password-strength-status-forget').addClass('medium-password');
                $('#password-strength-status-forget').html("Medium (Please enter atleast 8 characters including atleast 1 upprcase ,1 lower case and a number.)");
            }
        }
    }
    $('#c_pass').keyup(function(e){
        //get values
        var pass = $('#new_pass').val();
        var confpass = $(this).val();

        //check the strings
        if(pass == confpass){
            //if both are same remove the error and allow to submit
            $('.error').text('');
        }else{
            //if not matching show error and not allow to submit
            $('.error').text('The password you entered doesn’t match.');
            return false;
        }
    });
    $("#changePass").click(function () {

        if($('#new_pass').val().length == 0){
            $('.errornew').text('Please Enter Password');
            if($("#c_pass").val().length == 0){
                $('.error').text('Please Enter Confirm Password');
                return false;
            }
            return false;
        }
        else {
            var number = /([0-9])/;
            var alphabets = /([a-z])/;
            var special_characters = /([A-Z])/;
            if($('#new_pass').val().length<8) {
                $('.errornew').text('Password must contain atleast 8 characters including atleast 1 upprcase ,1 lower case and a number.');
                return false;
            } else {
                if($('#new_pas').val().match(number) && $('#new_pass').val().match(alphabets) && $('#new_pass').val().match(special_characters)) {
                    $('.errornew').text('');
                } else {
                    $('.errornew').text('Password must contain atleast 8 characters including atleast 1 upprcase ,1 lower case and a number.');
                    return false;
                }
            }
            if($("#new_pass").val() == $("#c_pass").val()){
                //if both are same remove the error and allow to submit
                $('.error').text('');
                form.submit();
            }else{
                //if not matching show error and not allow to submit
                $('.error').text('The password you entered doesn’t match.');
                return false;
            }
        }
    });
</script>