<?php
    $pageTitle = "About us";

    require_once("components/header.php");
?>

<main>
    <div class="container">
        <div class="row horizontal-centered">
            <div class="col-xs-12 col-lg-12">
                <img class="banner" src="images/about-us-desktop.jpg">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 sub-menu">
                <h3>On this page:</h3>
                <div>
                    <ul class="sub-menu-links">
                        <a class="link" href="about.php"><i class="fas fa-chevron-right hidden"></i>&nbsp;About us</a>
                        <a class="link" href="about.php?display=mission"><i class="fas fa-chevron-right hidden"></i>&nbsp;Our mission</a>
                        <a class="link" href="about.php?display=news"><i class="fas fa-chevron-right hidden"></i>&nbsp;News</a>
                        <a class="link" href="about.php?display=contact"><i class="fas fa-chevron-right hidden"></i>&nbsp;Contact us</a>
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10 row content-area <?php addHiddenAttribute("about"); ?>">
                <div class= "col-xs-12 col-sm-8 col-md-9 col-lg-10 about">
                    <h2 class="text-centered"><i class="fas fa-users"></i>&nbsp;About Us</h2>
                    <p>Every Good Work In North Texas began it's journey in 2006 when the idea to start a nonprofit to benefit youth in the Dallas Forth Worth arose. After years of offering youth services to the community through volunteer services and mentoring programs, our organization took shape and began relaunch to offer more oppurtinities to youth within the region today.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10 row content-area <?php addHiddenAttribute("mission"); ?>">
                <!-- Place our mission page elements here -->
                <div class= "col-xs-12 col-sm-8 col-md-9 col-lg-10 mission">
                   <h2 class="text-centered"><i class="fas fa-scroll"></i>&nbsp;Our Mission</h2>
                   <p>At Every Good Work In North Texas, our goal is to provide opportunities to youth to grow, share and spread goodwill throughout the communnity. We offer assistance to those in need, support causes and give back to the community in numerous ways. We strive to deliver the best possible service we can to communities, which in turn provides youth volunteers the opportunity to become active members in their neighborhoods and provide a lasting, positive impact on society as a whole. </p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10 row content-area <?php addHiddenAttribute("news"); ?>">
                <!-- Place newsletter page elements here -->
                <div class= "col-xs-12 col-sm-8 col-md-9 col-lg-10 newsletter">
                    <h2 class="text-centered"><i class="fas fa-mail-bulk"></i>&nbsp;Join our Mailing List!</h2>
                    <p> Sign up below to recieve email updates and news on youth volunteer opportunities in North Texas.</p>
                    <form class="col-xs-8 col-lg-3" method="post">
                        <div class="horizontal-centered form-section">
                            <label class="bold-text" for="Email">Email: </label>
                            <input type="text" id="Email" name="email" value="johndoe@gmail.com">
                        </div>

                        <div class="horizontal-centered form-section-buttons">
                            <input class="button-primary" type="submit" value="Submit" name="submit" id="submit">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10 row content-area <?php addHiddenAttribute("contact"); ?>">
                <!-- Place contact us page elements here -->
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10 contact">
                    <h2 class="text-centered"><i class="fas fa-file-signature"></i>&nbsp;Reach out!</h2>
                    <p>Any other questions? Feel free to reach out to us using the form below.</p>

                    <form class="col-xs-8 col-lg-3" method="post">
                        <div class="horizontal-centered form-section">
                            <label class="bold-text" for="Name">Name: </label>
                            <input type="text" id="Name" name="name" value="John Doe">
                        </div>

                        <div class="horizontal-centered form-section">
                            <label class="bold-text" for="Email">Email: </label>
                            <input type="text" id="Email" name="Email" value="johndoe@gmail.com">
                        </div>

                        <div class="horizontal-centered form-section">
                            <label class="bold-text" for="Email">Message: </label>
                            <input type="text" id="Message" name="Message" value="Message">
                        </div>

                        <div class="horizontal-centered form-section-buttons">
                            <input class="button-primary" type="submit" value="Send" name="submit" id="submit">
                        </div>
                    </form>
                    <div class="contact-details">
                        <p><b>Contact info</b><br>
                        <i class="fas fa-phone"></i>&nbsp;Phone: (214)-716-0266<br>
                        <i class="fas fa-envelope"></i>&nbsp;Email: kphipps@everygoodworkntx.org<br>
                        <i class="fas fa-home"></i>&nbsp;Address: P.O. Box 174122, Arlington, TX 76003</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function init(){
        var links = document.querySelectorAll(".sub-menu-links .link");
        var linkArrows = document.querySelectorAll(".sub-menu-links .link i");

        for(let i = 0; i < links.length; i++) {
            links[i].addEventListener("click", function(e) { showInfo(e, i)});
        }

        // Reference: get GET parameters in JS - https://stackoverflow.com/questions/5448545/how-to-retrieve-get-parameters-from-javascript
        var $getParams = window.location.search.substr(1);

        if($getParams == "") {
            linkArrows[0].className = "fas fa-chevron-right";
        }
        else {
            // break up GET parameters - https://stackoverflow.com/a/21210643/14635775
            var queryDict = {}
            location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]})

            if(queryDict['display'] != null) {
                for(let i = 0; i < links.length; i++) {
                    console.log(links[i].getAttribute("href"));
                    if(links[i].getAttribute("href").includes(queryDict['display'])) {
                        linkArrows[i].className = 'fas fa-chevron-right';
                    }
                }
            }
        }
    }

    function showInfo(evt, divNum) {
        evt.preventDefault();

        var contentAreas = document.querySelectorAll(".content-area");
        var linkArrows = document.querySelectorAll(".sub-menu-links .link i");

        if(divNum <= contentAreas.length) {
            for(let i = 0; i < contentAreas.length; i++) {
                contentAreas[i].className = "col-xs-12 col-sm-8 col-md-9 col-lg-10 row content-area hidden";
                linkArrows[i].className = 'fas fa-chevron-right hidden';
            }

            contentAreas[divNum].className = "col-xs-12 col-sm-8 col-md-9 col-lg-10 row content-area";
            linkArrows[divNum].className = 'fas fa-chevron-right';
        }
    }

    window.addEventListener('load', init, false);
</script>

<?php

    /* Hides divs that should not be displayed based on the 'display' attribute
       in the $_GET array. This is used in addition to the JavaScript above
       so that users who have JS disabled (or don't have JS) can still see
       all four sections properly */
    function addHiddenAttribute($currentPage) {
        if(array_key_exists("display", $_GET)) {
            $page = $_GET['display'];

            if($currentPage !== $page) {
                echo 'hidden';
            }
        }
        else {
            if($currentPage !== "about") {
                echo 'hidden';
            }
        }
    }

    require_once("components/footer.php");
?>
