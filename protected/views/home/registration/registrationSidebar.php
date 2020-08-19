<nav id="sidebar">
    <div class="btnCollapse"> <i></i> </div>
    <div class="sidebar-content">

        <!-- accordion start -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <!-- accordion panel 1 start -->
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" id="headingOne">
                    <h6 class="panel-title text-blue text-uppercase text-semibold"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">CBM Global</a> </h6>
                </div>
                <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <ul class="nav flex-column mb2">
                            <li class="nav-item" id="step1-registration-link">
                                <div class="icon-play"><a href="<?= Yii::app()->createUrl('home/registrationStepOneDemo'); ?>">Demo <i class="fas fa-play-circle"></i></a></div>
                                <a class="nav-link" href="<?= Yii::app()->createUrl('home/registrationStepOneDemo'); ?>"> <i><img src="<?php echo Yii::app()->request->baseUrl ?>/images/icon-logo.svg"></i>
                                    <div><span>Step 1</span>Registration</div>
                                </a> </li>
                            <!--<li class="nav-item" id="step2-buycashbacklicenses-link">
                                <div class="icon-play"><a href="step2-buycashbacklicenses-demo.php">Demo <i class="fas fa-play-circle"></i></a></div>
                                <a class="nav-link" href="step2-buycashbacklicenses-demo.php"> <i><img src="imgs/icon-cb-license.png"></i>
                                    <div><span>Step 2</span>Buy Cashback Licenses</div>
                                </a> </li>
                            <li class="nav-item" id="step3-selectproduct-link">
                                <a class="nav-link" href="step3-selectproduct-1.php"> <i><img src="imgs/icon-select-product.svg"></i>
                                    <div><span>Step 3</span>Select Product</div>
                                </a> </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> <i><img src="imgs/icon-checkout.svg"></i>
                                    <div><span>Step 4</span>Checkout</div>
                                </a> </li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <!-- accordion panel 1 end -->
            <!-- accordion panel 2 start -->
            <!--<div class="panel panel-default">
                <div class="panel-heading active" role="tab" id="headingTwo">
                    <h6 class="panel-title text-blue text-uppercase text-semibold mb1"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Setup Trading</a> </h6>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <ul class="nav flex-column">
                            <li class="nav-item" id="step1-st-registration-link">
                                <a class="nav-link" href="step1-st-registration.php"><i><img src="imgs/icon-registration.svg"></i>
                                    <div><span>Step 1</span>Registration</div>
                                </a> </li>
                            <li class="nav-item" id="step2-st-kyc-link">
                                <a class="nav-link" href="step2-st-kyc.php"> <i><img src="imgs/icon-kyc.svg"></i>
                                    <div><span>Step 2</span>KYC</div>
                                </a> </li>
                            <li class="nav-item"> <span class="text-sm note">You will receive your account number</span> </li>
                            <li class="nav-item" id="step3-st-signinglpoa-link">
                                <a class="nav-link" href="step3-st-signinglpoa.php"> <i><img src="imgs/icon-signing-lpoa.svg"></i>
                                    <div><span>Step 3</span>Signing the LPOA</div>
                                </a> </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> <i><img src="imgs/icon-funding-account.svg"></i>
                                    <div><span>Step 4</span>Funding Your Account</div>
                                </a> </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="1.php"> <i><img src="imgs/icon-account-activation.svg"></i>
                                    <div><span>Step 5</span>Account Activation</div>
                                </a> </li>
                        </ul>
                    </div>
                </div>
            </div>-->
            <!-- accordion panel 2 end -->
        </div>
        <!-- accordion end -->

    </div>
</nav>