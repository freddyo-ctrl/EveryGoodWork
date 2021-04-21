<?php
    $pageTitle = "Give back";

    require_once("components/header.php");
?>

<main>
    <div class="container">
        <div class="row horizontal-centered">
            <div class="col-xs-12 col-lg-12">
                <img class="banner" src="images/give-back-desktop.jpg">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-3 sub-menu collapsed">
                <h3>Ways to give back:</h3>
                <div id="sub-menu-list">
                    <ul id="sub-menu-links" class="sub-menu-links">
                        <a class="link" href="give-back.php"><i class="fas fa-chevron-right"></i>&nbsp;Give back</a>
                        <a class="link" href="participate.php">Event registration</a>
                        <a class="link" href="partners.php">Become a partner</a>
                        <a class="link" href="donate.php">Donate</a>
                    </ul>
                </div>
            </div>

            <div id="events-menu-toggle" class="col-xs-12 hidden">
                <i id="events-menu-toggle-icon" class="fas fa-angle-double-down"></i>
            </div>
            
            <div class="col-xs-11 col-sm-8 col-md-9 col-lg-8 row content-area">
                <div>
                    <h2 class="text-centered"><i class="fas fa-handshake"></i>&nbsp;Give back</h2>
                    <p>Want to support our mission in helping children and young adults in the local community? <a href="participate.php">Sign up</a> to volunteer
                       for one of our locally run events! Alternatively, you could <a href="donate.php">donate</a> to provide financial support that will
                       directly impact peoples' lives in the D/FW area.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function init(){
        var submenu = document.getElementById("events-menu-toggle");
        
        submenu.className = "col-xs-12";
        document.getElementById("sub-menu-list").className = "hidden-mobile";
        document.getElementById("sub-menu-links").className = "sub-menu-links hidden-mobile";
        submenu.addEventListener("click", function() { toggleSubmenu(); } );
    }

    function toggleSubmenu() {
        var list = document.getElementById("sub-menu-list");
        var menu = document.getElementById("sub-menu-links");
        var menuButton = document.getElementById("events-menu-toggle-icon");

        if(menu.className.includes("hidden-mobile")) {
            list.className = "";
            menu.className = "sub-menu-links";
            menuButton.className = "fas fa-angle-double-up";
        }
        else {
            list.className = "hidden-mobile";
            menu.className = "sub-menu-links hidden-mobile";
            menuButton.className = "fas fa-angle-double-down";
        }
    }

    window.addEventListener('load', init, false);
</script>

<?php
    require_once("components/footer.php");
?>