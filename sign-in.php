<?php
    $pageTitle = "Sign in";

    require_once("components/db-functions.php");

    if(array_key_exists("submit", $_POST)) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        log_in($email, $password);
    }

    require_once("components/header.php");
?>

<main>
    <div class="container">
        <div class="row horizontal-centered">
            <div class="col-xs-12">
                <h1 class="text-centered">Sign in</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-8 col-lg-3">
                <form method="post">
                    <div class="horizontal-centered form-section">
                        <label class="bold-text" for="email">Email address: </label>
                        <input type="text" id="email" name="email" <?php getInputValue("email"); ?>>
                    </div>

                    <div class="horizontal-centered form-section">
                        <label class="bold-text" for="password">Password: </label>
                        <input type="password" id="password" name="password">
                    </div>

                    <div class="horizontal-centered form-section">
                        <input class="button-primary form-submit-button" type="submit" name="submit" value="Log in">
                    </div>

                    <div class="text-centered form-section">
                        <p>Not a member? <a href="register.php">Create an account!</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
    require_once("components/footer.php");
?>