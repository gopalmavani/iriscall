<?php
$this->pageTitle = Yii::app()->name . '| Affiliates';
?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-container kt-container--fit  kt-container--fluid  kt-grid kt-grid--ver">
            <?php echo $this->renderPartial('aside',[]);  ?>
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                <!-- begin:: Subheader -->
                <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title">Affiliate Program </h3>
                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="<?= Yii::app()->createUrl('affiliate/promotiontools'); ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a> <span class="kt-subheader__breadcrumbs-separator"></span> <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Promotion Tools</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->

                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="kt-portlet">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-6 offset-lg-3">
                                    <h4 class="text-center mb-2">Share your link</h4>
                                    <p class="text-center mb-4">Copy this link</p>
                                    <div class="mb-3"><img src="<?= Yii::app()->baseUrl; ?>/images/img-mmc-demo.jpg" class="img rounded" style="width: 100% !important; height: auto !important;"></div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="link" id="myInput" value="<?php echo Yii::app()->getBaseUrl(true).'/home/signup/'.$userId; ?>">
                                    </div>
                                    <div class="row row2">
                                        <div class="col-6 col2"> <button onclick="fnOne()" class="btn btn-primary btn-md btn-tall d-block kt-font-bold kt-font-transform-u" style="width: inherit">Copy link</button> </div>
                                        <div class="col-6 col2"> <button onclick="snFnOne()" class="btn btn-secondary btn-md btn-tall d-block kt-font-bold kt-font-transform-u" style="width: inherit">Visit page</button> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Content -->
            </div>
        </div>
    </div>
</div>
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
    function snFnOne() {
        signOutCopyFunction("<?php echo Yii::app()->getBaseUrl(true).'/home/signup/'.$userId; ?>");
    }
</script>
