<?php
    $pageTitle = "Home";

    require_once("components/header.php");
?>

<main>
    <div class="container">
        <div class="row horizontal-centered">
            <div class="col-xs-12">
                <h1 class="text-centered"><i class="fas fa-donate"></i>&nbsp;Donate</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-lg-3 sub-menu collapsed">
                <h3>Ways to give back:</h3>
                <div id="sub-menu-list">
                    <ul id="sub-menu-links" class="sub-menu-links">
                        <a class="link" href="give-back.php">Give back</a>
                        <a class="link" href="participate.php">Event registration</a>
                        <a class="link" href="partners.php">Become a partner</a>
                        <a class="link" href="donate.php"><i class="fas fa-chevron-right"></i>&nbsp;Donate</a>
                    </ul>
                </div>
            </div>

            <div id="events-menu-toggle" class="col-xs-12 hidden">
                <i id="events-menu-toggle-icon" class="fas fa-angle-double-down"></i>
            </div>

            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9 row content-area">
                <div class="col-xs-10 col-md-8 horizontal-centered">
                    <p>If you would like to support our organization and the work that we do in the D/FW metroplex,
                       please consider donating! We assure you that all of your donation will be put to good use
                       benefiting and supporting children and young adults in the Arlington area.</p>
                </div>

                <div class="col-xs-10 col-md-8 horizontal-centered">
                    <img src="images/donation-placeholder.png" width="425" height="150">
                </div>

                <div class="col-xs-10 col-md-8">
                    <p>We also accept donations by mail! See the <a href="about.php?display=contact">contact page</a> for our mailing address.</p>
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