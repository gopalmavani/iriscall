<?php
$this->pageTitle = Yii::app()->name . '| Affiliates';
?>
<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <h5 class="text-dark font-weight-bold my-1 mr-5">Promotion Tools</h5>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-muted">Affiliates</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= Yii::app()->createUrl('affiliate/promotionTools'); ?>" class="text-muted">Promotion Tools</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="d-flex flex-column-fluid" id="vue-div">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Share your link
                                <small>Copy this link</small></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--<div class="mb-3"><img src="<?/*= Yii::app()->baseUrl; */?>/images/img-mmc-demo.jpg" class="img rounded" style="width: 100% !important; height: auto !important;"></div>-->
                        <div class="mb-3">
                            <input v-model="model_link" type="text" class="form-control" name="link" id="myInput">
                        </div>
                        <div class="row row2">
                            <div class="col-6 col2"> <button v-on:click="fnOne" class="btn btn-primary btn-md btn-tall d-block kt-font-bold kt-font-transform-u" style="width: inherit">Copy link</button> </div>
                            <div class="col-6 col2"> <button v-on:click="snFnOne" class="btn btn-secondary btn-md btn-tall d-block kt-font-bold kt-font-transform-u" style="width: inherit">Visit page</button> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var app = new Vue({
        el: '#vue-div',
        data: {
            model_link: '<?php echo Yii::app()->getBaseUrl(true).'/home/signup/'.$userId; ?>'
        },
        methods: {
            fnOne: function (event) {
                var copyText = document.getElementById("myInput");
                copyFunction(copyText);
            },
            snFnOne: function (event) {
                signOutCopyFunction("<?php echo Yii::app()->getBaseUrl(true).'/home/signup/'.$userId; ?>");
            }
        }
    });
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
</script>
