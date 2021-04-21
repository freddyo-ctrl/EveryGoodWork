<?php
    if(session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <?php
            // If a page title is set using the $pageTitle variable, use that string for the page's title
            if(isset($pageTitle)) { 
                echo "<title>$pageTitle - Every Good Work</title>"; 
            }
        ?>

	    <meta content="Every Good Work of North Texas" name="description">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/grid-system.css"> 
        <link rel="stylesheet" href="css/styles.css"> 
    </head>

    <body>
        <nav>
            <a class="logo" href="index.php"><img src="images/logo-black-wording.png" width="100" height="100" alt="Every Good Work logo"></a>

            <button class="navbar-toggler" data-target="#mainNavigation" type="button" aria-label="Toggle navigation menu"><i class="far fa-bars"></i></button>

            <div id="mainNavigation" class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="programs.php">Programs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="give-back.php">Give Back</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav login-sub-menu">
                    <?php
                        if(array_key_exists('name', $_SESSION)) {
                            $name = $_SESSION['name'];
                            echo "<li class=\"nav-item\">
                                      <span class=\"bold\">$name,</span>
                                      <a class=\"nav-link\" href=\"sign-out.php\">Sign out</a>
                                  </li>";
                        }
                        else {
                            echo "<li class=\"nav-item\">
                                      <a class=\"nav-link\" href=\"sign-in.php\">Log in</a>
                                  </li>
                                  <li class=\"nav-item\">
                                      <a class=\"nav-link\" href=\"register.php\">Register</a>
                                  </li>";
                        }
                    ?>
                </ul>
            </div>
        </nav>