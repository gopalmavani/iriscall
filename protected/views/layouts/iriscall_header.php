<style>
    .navbar-btn {
        border-color: #096c9e !important;
        border-width: 4px !important;
        padding: 8px 10px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        line-height: 1.125em !important;
    }
    .navbar-btn:hover {
        color: #ffffff !important;
        background-color: #262937 !important;
    }
    .nav-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }
    .subheader-transparent {
        display: none;
    }
    .dropdown-menu {
        position: absolute !important;
        background: #256C9E !important;
    }
    header {
        position: sticky !important;
        top: 0;
        z-index: 5;
        padding: unset !important;
    }
    .nav>li>a:focus, .nav>li>a:hover{
        background-color: unset;
    }
</style>
<header style="position: inherit">
    <nav class="navbar" style="margin: 0">
        <div class="nav-section">
            <div class="navbar-header">
                <a class="" href="#"><img class="logo_image" src="<?= Yii::app()->baseUrl . '/images/logos/iriscall_logo_white.png' ?>" alt="" width="300" height="122"></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse nav-right" style="display: flex !important;">
                <div class="show-mob">
                    <div class="menu-logo"><img class="logo_image"
                                                src="<?= Yii::app()->baseUrl . '/images/logos/iriscall_logo_white.png' ?>">
                    </div>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                            aria-expanded="false" aria-controls="navbar">
                        X
                    </button>
                </div>
                <ul class="nav navbar-nav" style="flex-direction: row">
                    <li class="dropdown"><a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Mobiel <i class="fa fa-angle-down"></i> </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Pakketten</a>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Cloud</a>
                    </li>

                    <li class="dropdown"><a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">websites <i class="fa fa-angle-down"></i> </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">PRIZEN</a>
                            <a class="dropdown-item" href="#">TEMPLATES</a>
                        </div>
                    </li>


                    <li><a href="#">BUSINESS CLUB</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">CONTACTEER ONS</a></li>

                    <li class="hide"><a href="#">Get in Touch</a></li>

                </ul>
                <button class="btn navbar-btn show">GET STARTED</button>
            </div>
            <ul class="nav navbar-nav" style="flex-direction: row; min-width: 200px">
                <li><a href="#">ZAKELIJK</a></li>
                <li><a href="#">PARTICULIER</a></li>
            </ul>
        </div>
    </nav>
</header>
<script>
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";

    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 768px)").matches) {
            $dropdown.hover(
                function() {
                    const $this = $(this);
                    $this.addClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "true");
                    $this.find($dropdownMenu).addClass(showClass);
                },
                function() {
                    const $this = $(this);
                    $this.removeClass(showClass);
                    $this.find($dropdownToggle).attr("aria-expanded", "false");
                    $this.find($dropdownMenu).removeClass(showClass);
                }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });

</script>