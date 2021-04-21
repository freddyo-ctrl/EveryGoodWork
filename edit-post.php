<?php
    // Include a connection to the database
    require_once("components/db-functions.php");

    if(!isset($_SESSION["isStaff"]) || !$_SESSION["isStaff"]) {
        header("Location: sign-in.php");
        exit();
    }

    $editingPost = false;

    if(isset($_GET["id"]) && is_numeric($_GET["id"]) && isset($_GET["delete"]) && $_GET["delete"] === "true") {
        $connection = dbConnect();

        $query = "DELETE FROM Posts WHERE PostID = ?";
        $statement = $connection->stmt_init();

        if($statement->prepare($query)) {
            $statement->bind_param("i", $_GET["id"]);

            $statement->execute();

            $statement->close();
        }

        header("Location: blog.php");
        exit();
    }

    if(isset($_GET["id"]) && is_numeric($_GET["id"])) {

        // Get a database connection
        $connection = dbConnect();

        // Set up a query to obtain all created blog posts
        $query = "SELECT * FROM Posts WHERE PostID = ?";
        $statement = $connection->stmt_init();

        if($statement->prepare($query)) {
            $statement->bind_param("i", $_GET["id"]);

            $statement->execute();

            // Bind the request information to variables
            $statement->bind_result($PostID, $Time, $Title, $AuthorID, $Body, $ImageURL);
            
            if($statement->fetch()) {
                // If an existing database entry was found, set $existingResponseID to its ID
                $editingPost = true;
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
    else if(!isset($_GET["id"]) && array_key_exists('submit', $_POST)) {

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
            if(array_key_exists('post-image', $_FILES)) {
                $allowedFileTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG); 
                $detectedFileType = exif_imagetype($_FILES['post-image']['tmp_name']);
                
                if(in_array($detectedFileType, $allowedFileTypes)) { 
                    if (move_uploaded_file($_FILES['post-image']['tmp_name'], str_replace(" ", "-", "/home/cwhutacl/ctec4350.cwh8053.uta.cloud/project-site/images/uploads/" . $_FILES['post-image']['name']))){
                        $imageName = str_replace(" ", "-", "images/uploads/" . $_FILES['post-image']['name']);
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
            $query = "INSERT INTO Posts (Title, AuthorID, Body, ImageURL) VALUES (?, ?, ?, ?)";
            $statement = $connection->stmt_init();

            if($statement->prepare($query)) {
                $statement->bind_param("siss", htmlspecialchars($_POST["post-title"]), $_SESSION['userID'], htmlspecialchars($_POST["post-body"]), $imageName);
                
                if($statement->execute()) {

                    // Get the ID of the inserted row above without needing to use another query
                    // Reference: https://www.w3schools.com/php/php_mysql_insert_lastid.asp
                    $newPostID = $connection->insert_id;

                    // Close the database connection
                    $statement->close();

                    header("Location: post.php?id=" . $newPostID);
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

    function getPostTitle() {
        global $Title;
        
        if(isset($Title) && !empty($Title)) {
            echo "value=\"$Title\"";
        }
    }

    function getPostBody() {
        global $Body;
        
        if(isset($Body) && !empty($Body)) {
            echo $Body;
        }
    }

    function getPostID() {
        global $PostID;
        
        if(isset($PostID) && !empty($PostID)) {
            echo $PostID;
        }
    }

    // Set the title of this page and include the header and nav bar
    $pageTitle = $editingPost == false ? "Create new post" : "Edit post";
    include_once("components/header.php"); 
?>

<script src="https://cdn.tiny.cloud/1/ypdokuhrtmdofumxisnhfpr6ycpodnp75svyzqj2xdukyhge/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<main>
    <div class="container">
        <div class="row centered">
            <div class="col-xs-8 col-lg-5 edit-post">
                <h2 class="text-centered"><?php echo ($editingPost == false ? "Create new post" : "Edit post"); ?></h2>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-section">
                        <label class="bold-text" for="post-title">Post title: </label>
                        <input class="title-input" type="text" id="post-title" name="post-title" <?php getPostTitle(); ?>>
                    </div>

                    <div class="form-section">
                        <label class="bold-text" for="text-editor">Post body: </label>
                        <textarea id="text-editor" name="post-body" rows="20" cols="50"><?php getPostBody(); ?> </textarea>
                    </div>

                    <div class="form-section">
                        <label class="bold-text" for="post-image">Post image: </label>
                        <input id="post-image" type="file" name="post-image">
                    </div>

                    <div class="horizontal-centered form-section-buttons">
                        <input class="col-xs-3 button-primary" type="submit" name="submit" value="Submit">
                        <a class="col-xs-3 text-centered button-primary" href="post.php?id=<?php getPostID(); ?>">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    /*tinymce.init({
      selector: '#text-editor',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
   });*/
</script>

<?php 
    // Include the footer of the page
    include_once("components/footer.php");
?>