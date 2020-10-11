<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2"><?= date('Y'); ?>©</span>
            <a href="#" target="_blank" class="text-dark-75 text-hover-primary"><?= Yii::app()->params['applicationName']; ?></a>
        </div>
        <!--end::Copyright-->
        <!--begin::Nav-->
        <div class="nav nav-dark order-1 order-md-2">
            <a href="#" target="_blank" class="nav-link pr-3 pl-0">About</a>
            <a href="#" target="_blank" class="nav-link px-3">Terms &amp; Conditions</a>
            <a href="#" target="_blank" class="nav-link pl-3 pr-0">Privacy Policy</a>
            <a href="#" target="_blank" class="nav-link pl-3 pr-0">Cookie Policy</a>
        </div>
        <!--end::Nav-->
    </div>
    <!--end::Container-->
</div>
<script>
    $(document).ready(function () {
       $('.kt-header__topbar-wrapper').on('click',function () {
           //if($(".kt-header__topbar-item").hasClass("show")){
               $('.steps').css('opacity','0.5');
           //}
       });
        $(window).click(function() {
            $('.steps').css('opacity','1');
        });
    });
</script>