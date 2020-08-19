<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Login';
?>
<main id="main-container">
    <!-- Hero Content -->
    <div class="bg-primary-dark">
        <section class="content no-padding content-full content-boxed overflow-hidden">
            <div class="push-100-t push-50 text-center">
                <h2 class="box-title m-b-20">Invalid link</h2>
            </div>
        </section>
    </div>
    <!-- Log In Form -->
    <div class="bg-white">
        <section class="content content-boxed">
            <!-- Section Content -->
            <div class="row items-push push-50-t push-30">
                <div class="col-md-12 col-md-offset-3">
                    It's seems like link that you are trying to reach is broken or invalid, You can resend password reset email by clicking<a href="<?php echo Yii::app()->createUrl('/user/forgot'); ?>"> here. </a>
                </div>
            </div>
        </section>
    </div>
</main>
<script>
    $("#changePass").click(function () {
        if($("#new_pass").val() != $("#c_pass").val()){
            $("#mismatch").html('Password do not match');
            return false;
        }
    });
</script>