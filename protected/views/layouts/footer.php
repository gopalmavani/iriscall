<div class="kt-footer kt-grid__item" id="kt_footer">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-footer__wrapper">
            <div class="kt-footer__copyright"> 2020&nbsp;&copy;&nbsp;<a href="https://micromaxcash.com/" target="_blank" class="kt-link">Iriscall</a> </div>
            <div class="kt-footer__menu">
                <a href="#" class="kt-link">Contact</a>
                <a href="#" class="kt-link">Terms &amp; Conditions</a>
                <a href="#"  class="kt-link">Privacy Policy</a>
                <a href="#" class="kt-link">Cookie Policy</a> </div>
        </div>
    </div>
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