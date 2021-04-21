<?php
    // Destroy any session variables that are set when we navigate to this page
    session_start();
    session_unset();
    session_destroy();

    // Redirect the user to the homepage
    header("Location: index.php");
    exit();

    // Set the page title
    $pageTitle = "Sign out";
?>