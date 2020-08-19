<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/promote.css'); ?>
<div class="row">
    <div class="col-lg-12 col-xlg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb5-md">
                        <div class="affiliate-program-bl">
                            <h4 class="card-title text-center mb-2">Share your link</h4>
                            <p class="text-center mb-4">Copy this link</p>
                            <div class="mb-4"><img src="<?= Yii::app()->baseUrl; ?>/images/img-cbm-demo.jpg" class="img-fluid"></div>
                            <?php if($model->affiliate_disclosure == 1) { ?>
                                <div class="mb-2">
                                    <input type="text" id="myInput" name="link" readonly="readonly" class="form-control" value="<?php echo Yii::app()->getBaseUrl(true).'/home/signup/'.$model->user_id; ?>">
                                </div>
                                <div class="row row2">
                                    <div class="col-6 col2"> <button onclick="fnOne()" class="btn btn-bl btn-primary">Copy link</button> </div>
                                    <div class="col-6 col2"> <button onclick="snFnOne()" class="btn btn-bl btn-secondary">Visit page</button> </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-sm-12">
                                    <p>Please read our <a href="#" class="affiliate-btn">Affiliate Disclosure</a> policy to generate your Affiliate link</p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="affiliate-program-bl">
                            <h4 class="card-title text-center mb-2">Public website www.cbmglobal.io</h4>
                            <p class="text-center mb-4">Copy this link to guide people to the public website using your personal link.</p>
                            <div class="mb-4"><img src="<?= Yii::app()->baseUrl; ?>/images/img-cbm.jpg" class="img-fluid"></div>
                            <?php if($model->affiliate_disclosure == 1) { ?>
                                <div class="mb-2">
                                    <input type="text" id="staticSite" readonly="readonly" class="form-control" value="https://www.cbmglobal.io/?signup=<?= $model->user_id; ?>">
                                </div>
                                <div class="row row2">
                                    <div class="col-6 col2"> <button onclick="fnTwo();" class="btn btn-bl btn-primary">Copy link</button> </div>
                                    <div class="col-6 col2"> <button onclick="snFnTwo();" class="btn btn-bl btn-secondary">Visit page</button> </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-sm-12">
                                    <p>Please read our <a href="#" class="affiliate-btn">Affiliate Disclosure</a> policy to generate your Affiliate link</p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="map-box">
                    <h3 style="margin-left: 12px;">Share Your Link</h3>
                    </br>
                    <h6 style="margin-left: 12px;">Copy Your Personal Referral Link and share it with Your Network</h6>
                    </br>
                    <div class="row">
                    <?php /*if($model->affiliate_disclosure == 1) { */?>
                        <div class="col-sm-8" >
                            <input type="text" id="myInput" name="link" readonly="readonly" value="<?php /*echo Yii::app()->getBaseUrl(true).'/home/signup/'.$model->user_id; */?>" class="form-control">
                        </div>
                        <div class="col-sm-4" >
                            <button class="btn btn-success" onclick="myFunction()">Copy Link</button>
                        </div>
                    <?php /*} else { */?>
                        <div class="col-sm-12">
                            <p>Please read our <a href="#" id="affiliate-btn">Affiliate Disclosure</a> policy to generate your Affiliate link</p>
                        </div>
                    <?php /*} */?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->

<script type="text/javascript">
    function signOutCopyFunction(newUrl) {
        $.ajax({
            url: '<?= Yii::app()->createUrl('user/ajaxLogout'); ?>',
            type: 'POST',
            success: function (data) {
                window.open(newUrl,'_blank');
            }
        });
    }
	function copyFunction(copyText) {
        copyText.select();
        document.execCommand("Copy");
    }
    function fnOne() {
        let copyText = document.getElementById("myInput");
        copyFunction(copyText)
    }
    function fnTwo() {
        let copyText = document.getElementById("staticSite");
        copyFunction(copyText)
    }
    function snFnOne() {
        signOutCopyFunction("<?php echo Yii::app()->getBaseUrl(true).'/home/signup/'.$model->user_id; ?>");
    }
    function snFnTwo() {
        let url = "https://www.cbmglobal.io/?signup="+"<?= $model->user_id; ?>";
        signOutCopyFunction(url);
    }
    $('.affiliate-btn').on('click', function () {
        var affiliateUrl = '<?= Yii::app()->getBaseUrl(true) . '/Affiliate/affiliate.html'; ?>';
        window.open(affiliateUrl,'_blank');
//        $.ajax({
//            url: '<?//= Yii::app()->createUrl('user/updateAffiliate'); ?>//',
//            type: 'GET',
//            success: function (data) {
//                window.location.reload();
//                window.open(affiliateUrl,'_blank');
//            }
//        });
    });
</script>