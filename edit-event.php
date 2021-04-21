<?php
    // Include a connection to the database
    require_once("components/db-functions.php");

    if(!isset($_SESSION["isStaff"]) || !$_SESSION["isStaff"]) {
        header("Location: sign-in.php");
        exit();
    }

    $editingEvent = false;

    if(isset($_GET["id"]) && is_numeric($_GET["id"]) && isset($_GET["delete"]) && $_GET["delete"] === "true") {
        $connection = dbConnect();

        $query = "DELETE FROM Events WHERE EventID = ?";
        $statement = $connection->stmt_init();

        if($statement->prepare($query)) {
            $statement->bind_param("i", $_GET["id"]);

            // If the event was deleted successfully, also delete any registrations that were associated with the event
            if($statement->execute()) {
                $query = "DELETE FROM Registrations WHERE EventID = ?";
                $statement = $connection->stmt_init();

                if($statement->prepare($query)) {
                    $statement->bind_param("i", $_GET["id"]);

                    $statement->execute();
                }
            }

            $statement->close();
        }

        header("Location: participate.php");
        exit();
    }

    if(isset($_GET["id"]) && is_numeric($_GET["id"])) {

        // Get a database connection
        $connection = dbConnect();

        // Set up a query to obtain all created events
        $query = "SELECT * FROM Events WHERE EventID = ?";
        $statement = $connection->stmt_init();

        if($statement->prepare($query)) {
            $statement->bind_param("i", $_GET["id"]);

            $statement->execute();

            // Bind the request information to variables
            $statement->bind_result($EventID, $Name, $Description, $EventDate, $StartTime, $EndTime, $VolunteersNeeded, $ImageURL);
            
            if($statement->fetch()) {
                // If an existing database entry was found, set $existingResponseID to its ID
                $editingEvent = true;
            }
            else {
                // A post with the given ID could not be found
                //$specialMessage = createSpecialMessage("Oops!", "The specified blog post could not be found. Please try another ID.", "error", "fas fa-eye-slash");
            }

            // Close the database connection
            $statement->close();
        }
        else {
            // An error occurred while attempting to prepare the query
           // $specialMessage = createSpecialMessage("Oops!", "Unfortunately, a database query failed. Please try again.", "error", "fas fa-tools");
        }
    }
    
    if(!isset($_GET["id"]) && array_key_exists('submit', $_POST)) {

        /*
        // Create arrays for expected, required, and missing form fields
        $expected = array("post-title", "post-body");
        $required = array("post-title", "post-body");
        $missing = array();

        // If any form fields are missing, add them to the $missing array
        foreach($expected as $field) {
            $fieldBeingChecked = $_POST[$field];

            if(in_array($field, $required) && empty($fieldBeingChecked)) {
                array_push($missing, $field);
            }
        }

        // If there are any missing fields, display an error message
        if(!empty($missing)) {
            $missingFields = implode(", ", $missing);

            $specialMessage = createSpecialMessage("Oops!", "The following fields are required:<br><br>$missingFields<br><br>Please fill them in before attempting to create the blog post.", "error");
        }
        else {
        */
            $imageName = "images/missing-image.jpg";

            // Upload the image for the post
            if(array_key_exists('event-image', $_FILES)) {
                $allowedFileTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG); 
                $detectedFileType = exif_imagetype($_FILES['event-image']['tmp_name']);
                
                if(in_array($detectedFileType, $allowedFileTypes)) { 
                    if (move_uploaded_file($_FILES['event-image']['tmp_name'], str_replace(" ", "-", "/home/cwhutacl/ctec4350.cwh8053.uta.cloud/project-site-v2/images/uploads/" . $_FILES['event-image']['name']))){
                        $imageName = str_replace(" ", "-", "images/uploads/" . $_FILES['event-image']['name']);
                    } 
                    else {
                        //$specialMessage = createSpecialMessage("Oops!", "An error occurred while attempting to upload the post's thumbnail. Please try again.", "error");
                    }
                }
                else {
                    //$specialMessage = createSpecialMessage("Oops!", "Only the following image formats are accepted: .png, .jpg, .gif", "error");
                }
            }

            // Get a database connection
            $connection = dbConnect();

            // Set up a query to obtain all created blog posts
            $query = "INSERT INTO Events (Name, Description, EventDate, StartTime, EndTime, VolunteersNeeded, ImageURL) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $statement = $connection->stmt_init();

            if($statement->prepare($query)) {
                $statement->bind_param("sssssis", htmlspecialchars($_POST["event-title"]), htmlspecialchars($_POST["event-description"]), htmlspecialchars($_POST["event-date"]), htmlspecialchars($_POST["event-start-time"]), htmlspecialchars($_POST["event-end-time"]), htmlspecialchars($_POST["event-volunteers-needed"]), $imageName);
                
                if($statement->execute()) {

                    // Close the database connection
                    $statement->close();

                    header("Location: participate.php");
                    exit();
                }
                else {
                    // A post with the given ID could not be found
                    //$specialMessage = createSpecialMessage("Oops!", "The specified blog post could not be found. Please try another ID.", "error", "fas fa-eye-slash");
                }

                // Close the database connection
                $statement->close();
            }
            else {
                // An error occurred while attempting to prepare the query
                //$specialMessage = createSpecialMessage("Oops!", "Unfortunately, a database query failed. Please try again.", "error", "fas fa-tools");
            }
        //}
    }
    else if(isset($_GET["id"]) && $editingEvent && array_key_exists('submit', $_POST)) {
         
        // Get a database connection
        $connection = dbConnect();

        // Set up a query to obtain all created blog posts
        $query = "UPDATE Events SET Name=?, Description=?, EventDate=?, StartTime=?, EndTime=?, VolunteersNeeded=?, ImageURL=? WHERE EventID=?";
        $statement = $connection->stmt_init();

        if($statement->prepare($query)) {
            $image = empty($_POST["event-image"]) ? $ImageURL : htmlspecialchars($_POST["event-image"]);
            $statement->bind_param("sssssisi", htmlspecialchars($_POST["event-title"]), htmlspecialchars($_POST["event-description"]), htmlspecialchars($_POST["event-date"]), htmlspecialchars($_POST["event-start-time"]), htmlspecialchars($_POST["event-end-time"]), htmlspecialchars($_POST["event-volunteers-needed"]), $image, $EventID);
        
            $statement->execute();

            $statement->close();

            header("Location: participate.php");
            exit();
        }
    }

    function getEventName() {
        global $Name;
        
        if(isset($Name) && !empty($Name)) {
            echo "value=\"$Name\"";
        }
    }

    function getEventDescription() {
        global $Description;
        
        if(isset($Description) && !empty($Description)) {
            echo $Description;
        }
    }

    function getEventDate() {
        global $EventDate;
        
        if(isset($EventDate) && !empty($EventDate)) {
            echo "value=\"$EventDate\"";
        }
    }

    function getEventStartTime() {
        global $StartTime;
        
        if(isset($StartTime) && !empty($StartTime)) {
            echo "value=\"$StartTime\"";
        }
    }

    function getEventEndTime() {
        global $EndTime;
        
        if(isset($EndTime) && !empty($EndTime)) {
            echo "value=\"$EndTime\"";
        }
    }

    function getEventVolunteers() {
        global $VolunteersNeeded;
        
        if(isset($VolunteersNeeded) && !empty($VolunteersNeeded)) {
            echo "value=\"$VolunteersNeeded\"";
        }
    }

    // Set the title of this page and include the header and nav bar
    $pageTitle = $editingEvent == false ? "Create new event" : "Edit event";
    include_once("components/header.php"); 
?>

<main>
    <div class="container">
        <div class="row centered">
            <div class="col-xs-10 col-lg-5 edit-event">
                <h2 class="text-centered"><?php echo ($editingEvent == false ? "Create new event" : "Edit event"); ?></h2>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="horizontal-centered form-section">
                        <label class="bold-text" for="event-title">Event title: </label>
                        <input class="title-input" type="text" id="event-title" name="event-title" <?php getEventName(); ?>>
                    </div>

                    <div class="horizontal-centered form-section">
                        <label class="bold-text" for="text-editor">Description: </label>
                        <textarea id="text-editor" name="event-description" rows="20" cols="30"><?php getEventDescription(); ?></textarea>
                    </div>

                    <div class="horizontal-centered form-section">
                        <label class="bold-text" for="text-editor">Date: </label>
                        <input type="date" id="event-date" name="event-date" <?php getEventDate(); ?>>
                    </div>

                    <div class="horizontal-centered form-section">
                        <label class="bold-text" for="text-editor">Start time: </label>
                        <input type="time" id="event-start-time" name="event-start-time" <?php getEventStartTime(); ?>>
                    </div>

                    <div class="horizontal-centered form-section">
                        <label class="bold-text" for="text-editor">End time: </label>
                        <input type="time" id="event-end-time" name="event-end-time" <?php getEventEndTime(); ?>>
                    </div>

                    <div class="horizontal-centered form-section">
                        <label class="bold-text" for="text-editor">Volunteers needed: </label>
                        <input type="input" id="event-volunteers-needed" name="event-volunteers-needed" <?php getEventVolunteers(); ?>>
                    </div>

                    <div class="horizontal-centered form-section">
                        <label class="bold-text" for="event-image">Event image: </label>
                        <input id="event-image" type="file" name="event-image">
                    </div>

                    <div class="horizontal-centered form-section-buttons">
                        <input class="col-xs-3 button-primary" type="submit" name="submit" value="Submit">
                        <a class="col-xs-3 text-centered button-primary" href="participate.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php 
    // Include the footer of the page
    include_once("components/footer.php");
?>