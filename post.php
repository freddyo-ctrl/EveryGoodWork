<?php
    // Include a connection to the database and also include a library with helpful functions used on this page
    require_once("components/dbconn.php");
    require_once("components/db-functions.php");

    if(!array_key_exists("id", $_GET) || empty($_GET['id'])) {
        header("Location: blog.php");
        exit();
    }

    // If a query string named "id" is set, attempt to retrieve the blog post with that ID from the database
    if(isset($_GET["id"]) && is_numeric($_GET["id"])) {
        // Get a database connection
        $connection = dbConnect();

        // Create a flag variable that will be set to true if we successfully retrieve a blog post
        $blogPostExists = false;

        // Set up a query to obtain the blog post
        $query = "SELECT * FROM Posts WHERE PostID = ?";
        $statement = $connection->stmt_init();

        if($statement->prepare($query)) {
            $statement->bind_param("i", $_GET["id"]);

            $statement->execute();

            // Save the post's information to variables
            $statement->bind_result($PostID, $Time, $Title, $AuthorID, $Body, $ImageURL);

            // If a blog post with the provided ID was found, set the blogPostExists flag to true
            if($statement->fetch()) {
                $blogPostExists = true;
            }
            else {
                // A blog post with the provided ID was not found, show an error message instead
                //$specialMessage = createSpecialMessage("Oops!", "This post could not be found. Please try again.", "error", "fas fa-tools");
            }

            // Close the database connection
            $statement->close();
        }
    }

    // Use the blog post's title as the title for the page and a "not found" message if a post could not be found
    $pageTitle = $blogPostExists ? $Title : "Post not found!";
    require_once("components/header.php"); 
?>

<main>
    <div class="container">
        <div class="row centered post">
            <?php
            // If a blog post was found, then print out their divs and content
            // If one wasn't found, just show an error message instead
            if($blogPostExists) {

                
            ?>

            <div class="col-xs-11 col-lg-8 post-header">
                <?php
                    // If the user is logged in and is a staff member, enable the "create new post" button
                    if(isset($_SESSION["isStaff"]) && $_SESSION["isStaff"]) {
                        echo "<div class=\"col-xs-12 content-staff-menu\">
                                  <p class=\"bold\">Manage:</p>
                                  <a class=\"button-primary\" href=\"edit-post.php?id=$PostID\"><i class=\"fas fa-edit\"></i>&nbsp;Edit post</a>
                                  <a class=\"button-primary\" href=\"edit-post.php?id=$PostID&delete=true\" onclick=\"return confirm('Are you sure you want to delete this post?');\"><i class=\"fas fa-trash-alt\"></i>&nbsp;Delete post</a>
                              </div>";
                    }

                    echo "<img class=\"blog-post-image\" src=\"$ImageURL\">";

                    echo "<h2>$Title</h2>";

                    $posterName = getNameFromId($AuthorID);

                    // Referenced https://www.php.net/manual/en/datetime.format.php to see how to format a MySQL datetime string
                    echo "<p class=\"post-time\">" . date_format(date_create($Time), "F j, Y") . " by $posterName</p>";
                ?>
            </div>
            <hr class="line-green">
            <div class="col-xs-11 col-lg-8 post-body">
                <div class="row">
                    <div class="col-xs-12 post-body-content">
                    <?php
                        echo htmlspecialchars_decode($Body);
                    ?>
                    </div>
                </div>
            </div>
            <?php
            // Insert the closing brace to the $blogPostExists if statement above 
            }
            ?>
        </div>
    </div>
</main>


<?php 
    // Include the footer of the page
    require_once("components/footer.php"); 
?>