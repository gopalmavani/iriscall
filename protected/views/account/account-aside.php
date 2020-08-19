<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

    <!-- begin:: Aside Menu -->
    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1">
            <ul class="kt-menu__nav ">
                <li class="kt-menu__section kt-menu__section--first">
                    <h4 class="kt-menu__section-text">Cashback Nodes</h4>
                    <i class="kt-menu__section-icon flaticon-more-v2"></i> </li>
                <li class="kt-menu__item"><a href="<?= Yii::app()->createUrl('account/index'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">List Viewer</span></a></li>
                <li class="kt-menu__item"><a href="<?= Yii::app()->createUrl('account/matrixviewer'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Matrix Viewer</span></a></li>
                <!--<li class="kt-menu__item"><a href="cashback-earningsperlicences.php" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Earnings Per Licence</span></a></li>-->
            </ul>
        </div>
    </div>
    <!-- end:: Aside Menu -->
</div>