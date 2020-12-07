<style>
    .navbar-btn {
        border-color: #096c9e !important;
        border-width: 4px !important;
        padding: 1.4em 2.4em 1.3em !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        line-height: 1.125em !important;
        border-radius: 50px !important;
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
        background: #1d202b !important;
    }
    header {
        position: sticky !important;
        top: 0;
        z-index: 5;
    }
    .nav>li>a:focus, .nav>li>a:hover{
        background-color: unset;
    }
</style>
<header style="position: inherit">
    <nav class="navbar" style="margin-bottom: 0">
        <div class="nav-section">
            <div class="navbar-header">
                <a class="" href="#"><img class="logo_image" src="https://dev.iriscall.be/mobiel/wp-content/uploads/2020/07/IC-Logo-no-baseline-300x122-1.png" alt="" width="300" height="122"></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse nav-right" style="text-align: right !important;display: flex !important;justify-content: flex-end;">
                <div class="show-mob">
                    <div class="menu-logo"><img class="logo_image"
                                                src="https://dev.iriscall.be/mobiel/wp-content/uploads/2020/07/IC-Logo-no-baseline-300x122-1.png">
                    </div>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                            aria-expanded="false" aria-controls="navbar">
                        X
                    </button>
                </div>
                <ul class="nav navbar-nav" style="flex-direction: row">
                    <li class="dropdown"><a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Mobiel</a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Zakelijk</a>
                            <a class="dropdown-item" href="#">Particulier</a>
                            <a class="dropdown-item" href="#">Home 3</a>
                            <a class="dropdown-item" href="#">Home Boxed</a>
                            <a class="dropdown-item" href="#">Elementor Home</a>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Features</a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Typography</a>
                            <a class="dropdown-item" href="#">Shortcodes</a>
                            <a class="dropdown-item" href="#">Store</a>
                            <a class="dropdown-item" href="#">Gallery</a>
                            <a class="dropdown-item" href="#">Brussels</a>
                            <a class="dropdown-item" href="#">Privacy Policy</a>
                        </div>
                    </li>

                    <li class="dropdown"><a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">About</a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Databundels</a>
                            <a class="dropdown-item" href="#">Buitenland</a>
                        </div>
                    </li>


                    <li><a href="#">Services</a></li>
                    <li><a href="#">Packages</a></li>
                    <li><a href="#">Blog</a></li>

                    <li class="hide"><a href="#">Get in Touch</a></li>

                </ul>
                <button class="btn navbar-btn show">Get Started</button>
            </div>
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