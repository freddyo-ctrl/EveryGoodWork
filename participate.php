<?php
    $pageTitle = "Event registration";

    require_once("components/db-functions.php");

    if(array_key_exists("register", $_GET)) {
        $event = $_GET['register'];
        $eventType = "event";

        if(!empty($event) && is_numeric($event)) {
            $connection = dbConnect();

            $registeredEvents = getEventsForUser($_SESSION['userID']);

            if(in_array($event, $registeredEvents)) {
                $query = "DELETE FROM Registrations WHERE EventID = ? AND UserID = ?";
                $statement = $connection->stmt_init();
    
                if($statement->prepare($query)) {
                    $statement->bind_param("ii", $event, $_SESSION['userID']);

                    $statement->execute();

                    $statement->close();
                }

                header("Location: participate.php");
                exit();
            }
            else {
                $query = "INSERT INTO Registrations (EventID, UserID, EventType) VALUES (?, ?, ?)";
                $statement = $connection->stmt_init();
    
                if($statement->prepare($query)) {
                    $statement->bind_param("iis", $event, $_SESSION['userID'], $eventType);

                    $statement->execute();

                    $statement->close();
                }

                header("Location: participate.php");
                exit();
            }
        }
    }
    
    require_once("components/header.php");
?>

<main>
    <div class="container">
        <div class="row horizontal-centered">
            <div class="col-xs-12">
                <h1 class="text-centered">Events</h1>
            </div>
        </div>

        <?php
            if(isset($_SESSION["isStaff"]) && $_SESSION["isStaff"]) {
                echo "<div class=\"row\">
                          <div class=\"col-xs-10 content-staff-menu\">
                              <p class=\"bold\">Manage:</p>
                              <a class=\"button-primary\" href=\"edit-event.php\"><i class=\"fas fa-plus\"></i>&nbsp;Create new event</a>
                          </div>
                      </div>";
                }
        ?>

        <div class="row">
            <div class="col-xs-12 col-lg-3 sub-menu collapsed">
                <h3>Ways to give back:</h3>
                <div id="sub-menu-list">
                    <ul id="sub-menu-links" class="sub-menu-links">
                        <a class="link" href="give-back.php">Give back</a>
                        <a class="link" href="participate.php"><i class="fas fa-chevron-right"></i>&nbsp;Event registration</a>
                        <a class="link" href="partners.php">Become a partner</a>
                        <a class="link" href="donate.php">Donate</a>
                    </ul>
                </div>
            </div>

            <div id="events-menu-toggle" class="col-xs-12 hidden">
                <i id="events-menu-toggle-icon" class="fas fa-angle-double-down"></i>
            </div>
            
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9 row events">
                <?php retrieveEvents(); ?>
            </div>
        </div>
    </div>
</main>

<script>
    function init(){
        var eventButtons = document.getElementsByClassName("read-more");
        var submenu = document.getElementById("events-menu-toggle");

        for(let i = 0; i < eventButtons.length; i++) {
            eventButtons[i].addEventListener("click", function() { expandEvent(eventButtons, i) } );
        }

        submenu.className = "col-xs-12";
        document.getElementById("sub-menu-list").className = "hidden-mobile";
        document.getElementById("sub-menu-links").className = "sub-menu-links hidden-mobile";
        submenu.addEventListener("click", function() { toggleSubmenu(); } );
    }

    function expandEvent(buttons, eventNum) {
        var eventDescriptions = document.getElementsByClassName("event-description");
        var dropdownArrows = document.getElementsByClassName("dropdown-arrow");

        if(eventNum <= eventDescriptions.length) {
            if(eventDescriptions[eventNum].className.includes("hidden")) {
                eventDescriptions[eventNum].className = "event-description open";
                dropdownArrows[eventNum].className = "dropdown-arrow fas fa-sort-up";
                buttons[eventNum].className = "button-dropdown-clicked read-more";
            }
            else {
                eventDescriptions[eventNum].className = "event-description hidden";
                dropdownArrows[eventNum].className = "dropdown-arrow fas fa-sort-down";
                buttons[eventNum].className = "button-dropdown read-more";
            }
        }
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
    function retrieveEvents() {
        $eventsRegisteredFor = [];

        if(isset($_SESSION['userID'])) {
            $eventsRegisteredFor = getEventsForUser($_SESSION['userID']);
        }

        $connection = dbConnect();
        $query = "SELECT * FROM Events";
        $statement = $connection->stmt_init();
    
        if($statement->prepare($query)) {
            $statement->execute();
    
            $statement->store_result();
            $statement->bind_result($EventID, $Name, $Description, $EventDate, $StartTime, $EndTime, $NumOfVolunteers, $ImageURL);
            $numberOfEvents = $statement->num_rows;
    
            if($numberOfEvents > 0) {
                while($statement->fetch()) {
                    $StartTime = date("g:ia", strtotime($StartTime));
                    $EndTime = date("g:ia", strtotime($EndTime));
                    $numofRegisteredVolunteers = getNumberOfRegisteredUsers($EventID);
                    $RegisterLink = "participate.php?register=$EventID";
                    $RegisterButton = "";
                    $StaffButtons = "";

                    if(isset($_SESSION["isStaff"]) && $_SESSION["isStaff"]) {
                        $StaffButtons = "<a class=\"button-primary\" href=\"edit-event.php?id=$EventID\"><i class=\"fas fa-edit\"></i>&nbsp;Edit event</a>
                                        <a class=\"button-primary\"href=\"edit-event.php?id=$EventID&delete=true\"><i class=\"fas fa-trash-alt\"></i>&nbsp;Delete event</a>";
                    }

                    if(!isset($_SESSION['userID'])) {
                        $RegisterLink = "sign-in.php";
                    }
                    
                    if(in_array($EventID, $eventsRegisteredFor)) {
                        $RegisterButton = "<a class=\"button-primary register\" href=\"$RegisterLink\" onclick=\"return confirm('Cancel your registration for $Name?');\">Remove registration</a>";
                    }
                    else {
                        $RegisterButton = "<a class=\"button-primary register\" href=\"$RegisterLink\" onclick=\"return confirm('Are you sure you want to sign up for $Name?');\">Register</a>";
                    }

                    echo "<div class=\"col-xs-12 event\">
                            <div class=\"col-xs-12 col-lg-4 horizontal-centered event-image\">
                                <img src=\"$ImageURL\">
                            </div>
                            <div class=\"col-lg-4 event-name\">
                                <h2>$Name</h2>
                                <p><b>Date:</b>&nbsp;$EventDate<br>
                                <b>Time:</b>&nbsp;$StartTime to $EndTime<br>
                                <b>Description:</b>&nbsp;$Description</p>
                            </div>
                            <div class=\"col-lg-4 event-info\">
                                <p class=\"bold\">Registered volunteers: $numofRegisteredVolunteers/$NumOfVolunteers</p>
                                <a class=\"button-dropdown read-more\">More info&nbsp;<i class=\"dropdown-arrow fas fa-sort-down\"></i></a>
                                $RegisterButton
                                <div class=\"event-desktop-staff-buttons\">
                                    $StaffButtons
                                </div>
                            </div>
                            <div class=\"col-xs-12 event-description hidden\">
                                <p><b>Date:</b>&nbsp;$EventDate<br>
                                <b>Time:</b>&nbsp;$StartTime to $EndTime<br>
                                <b>Description:</b>&nbsp;$Description</p>
                                <div class=\"col-xs-12 horizontal-centered event-buttons\">
                                $RegisterButton
                                <div class=\"event-mobile-staff-buttons\">
                                    $StaffButtons
                                </div>
                                </div>
                            </div>
                        </div>
                        <hr class=\"line-green\">";
                }
            }
            else {
                echo "<div class=\"col-xs-12 event\">
                          <h2 class=\"text-centered\">No events found. Please check back later!</h2>
                      </div>";
            }
        }
    }

    require_once("components/footer.php");
?>