<?php
    $pageTitle = "Blog";

    require_once("components/db-functions.php");

    require_once("components/header.php");
?>

<main>
    <div class="container">
        <div class="row horizontal-centered">
            <div class="col-xs-12 col-lg-12">
                <img class="banner" src="images/blog-desktop.jpg">
            </div>
        </div>
        <?php
            if(isset($_SESSION["isStaff"]) && $_SESSION["isStaff"]) {
                echo "<div class=\"row\">
                          <div class=\"col-xs-10 content-staff-menu\">
                              <p class=\"bold\">Manage:</p>
                              <a class=\"button-primary\" href=\"edit-post.php\"><i class=\"fas fa-plus\"></i>&nbsp;Create new post</a>
                          </div>
                      </div>";
            }
        ?>
        <div class="row blog-posts-list">
            <?php retrieveBlogPosts(); ?>
        </div>
    </div>
</main>

<?php

    function retrieveBlogPosts() {
        $connection = dbConnect();

        $query = "SELECT * FROM Posts";
        $statement = $connection->stmt_init();
    
        if($statement->prepare($query)) {
            $statement->execute();
    
            $statement->store_result();
            $statement->bind_result($PostID, $TimePosted, $Title, $AuthorID, $Body, $ImageURL);
            $numberOfPosts = $statement->num_rows;
    
            if($numberOfPosts > 0) {
                $postNumber = 1;
                while($statement->fetch()) {
                    $authorName = getNameFromId($AuthorID);
                    $excerpt = strlen($Body) >= 200 ? htmlspecialchars(substr($Body, 0, 197)) . "..." : $Body;
                    $excerpt = htmlspecialchars_decode($excerpt);
                    $postLink = "post.php?id=$PostID";

                    echo "<div class=\"col-xs-12 col-lg-10 blog-post\">
                            <div class=\"col-xs-12 col-lg-3 post-image\">
                                <img src=\"$ImageURL\" width=\"300\" height=\"300\">
                            </div>
                            <div class=\"col-lg-9 post-details\">
                                <div class=\"post-description\">
                                    <h2><a class=\"link\" href=\"$postLink\">$Title</a></h2>
                                    <p class=\"no-vertical-margins\">Posted by $authorName</p>
                                    <p>$excerpt</p>
                                </div>
                                <div class=\"post-read-more\">
                                    <a class=\"button-primary\" href=\"$postLink\">Read more</a>
                                </div>
                            </div>
                        </div>";

                    // If the post is not the last post being echoed to the page, print a horizontal line
                    // Used to prevent an unnecessary divider from being placed between the last post and the
                    // footer of the page 
                    if($postNumber < $numberOfPosts) { 
                        echo "<hr class=\"line-green\">";
                    }

                    // Increment the postNumber variable
                    $postNumber++;
                }
            }
            else {
                echo "<div class=\"col-xs-12 col-lg-10 blog-post\">
                          <h2 class=\"text-centered\">No posts yet. Please check back later!</h2>  
                      </div>";
            }
    
            $statement->close();
        }
    }

    require_once("components/footer.php");
?>