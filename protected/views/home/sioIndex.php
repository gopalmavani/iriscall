<div class="logo mb6" data-aos="fade-down">
    <a href="#"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/logos/iriscall-logo.svg" alt="" style="width: 35%" /></a>
</div>
<div class="login-box mb6">
    <div class="login-form" style="min-height: 300px">
        <h4 class="mb5">Login To <?= Yii::app()->params['applicationName']; ?></h4>
        <form class="mb3" style="margin-top: 70px">
            <a href="<?= Yii::app()->params['SSO_URL'].'login?application='.Yii::app()->params['applicationName'] ?>" class="signInBtn">
                Sign in using Sign In Once
                <img src="<?= Yii::app()->request->baseUrl ?>/images/sio/logo-sio-icon.png" alt="" />
            </a>
        </form>
    </div>
    <div class="login-vector" data-aos="fade-left" data-aos-delay="300">
        <div class="vector-icon">
            <img src="<?= Yii::app()->request->baseUrl ?>/images/sio/icon-vector.png" alt="" />
        </div>
    </div>
</div>

<div class="sio-flex">
    <div class="sio-logo">
        <img src="<?php echo Yii::app()->request->baseUrl ?>/images/sio/logo-sio-icon.png" alt="" />
    </div>
    <div class="sio-text">
        <p class="sio-heading">
            <?= Yii::app()->params['applicationName']; ?> registration is powered by Sign In Once
        </p>
        <p class="sio-sub-heading">
            By continuing, you agree to the
            <a target="_blank" href="https://www.cbmglobal.io/legal/terms-conditions.html">terms & conditions.</a>
        </p>
    </div>
</div>