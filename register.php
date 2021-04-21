<?php
    $pageTitle = "Register";

    require_once("components/db-functions.php");

    if(array_key_exists('submit', $_POST)) {
        $name = $_POST['first-name'] . " " . $_POST['last-name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        registerUser($name, $password, $email);
        header("Location: index.php");
        exit();
    }

    require_once("components/header.php");

?>

<main>
    <div class="container">
        <div class="row horizontal-centered">
            <div class="col-xs-12">
                <h1 class="text-centered">Create an account</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-8 col-lg-3">
                <form id="registration-form" action="" method="post">
                    <div class="horizontal-centered form-section">
                        <label id="first-name-label" class="bold-text" for="first-name">First name: </label>
                        <input type="text" id="first-name" name="first-name" <?php getInputValue("first-name"); ?>>
                    </div>

                    <div class="horizontal-centered form-section">
                        <label id="last-name-label" class="bold-text" for="last-name">Last name: </label>
                        <input type="text" id="last-name" name="last-name" <?php getInputValue("last-name"); ?>>
                    </div>
                    <div class="horizontal-centered form-section">
                        <label id="email-label" class="bold-text" for="email">E-mail address: </label>
                        <input type="email" id="email" name="email" <?php getInputValue("email"); ?>>
                    </div>

                    <div class="horizontal-centered form-section">
                        <label id="password-label" class="bold-text" for="password">Password: </label>
                        <input type="password" id="password" name="password">
                    </div>

                    <div class="horizontal-centered form-section">
                        <label id="confirm-password-label" class="bold-text" for="confirm-password">Confirm password: </label>
                        <input type="password" id="confirm-password" name="confirm-password">
                    </div>

                    <div class="horizontal-centered form-section">
                        <input class="button-primary form-submit-button" type="submit" name="submit" value="Register">
                    </div>

                    <div class="text-centered register-form-section">
                        <p>Already have an account? <a href="sign-in.php">Log in here!</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>

    function init() {
        document.getElementById('registration-form').addEventListener('submit', function(e) { validateInput(e); }, false);
        console.log("init");
    }

    function removeErrorMessage(element, type) {
        if(document.getElementById(element + "-error-message-" + type) != null) {
            document.getElementById(element + "-error-message-" + type).style.display = "none";
            document.getElementById(element + "-label").style.color = "black";
        }
    }

    function createErrorMessage(element, type, message) {
        if(document.getElementById(element + "-error-message-" + type) != null) {
            document.getElementById(element + "-error-message-" + type).textContent = message;
            document.getElementById(element + "-error-message-" + type).style.display = "block";
            document.getElementById(element + "-label").style.color = "red";
            return;
        }

        var errorSpan = document.createElement("span");
        errorSpan.className = "error-message";
        errorSpan.id = element + "-error-message-" + type;
        errorSpan.innerHTML = message;

        var parentLabel = document.getElementById(element + '-label');
        parentLabel.parentNode.appendChild(errorSpan);
    }

    function validateInput(evt) {
        var numOfErrors = 0;
        var inputs = ['first-name', 'last-name', 'email', 'password', 'confirm-password'];

        for(i = 0; i < inputs.length; i++) {
            var input = document.getElementById(inputs[i]);
            console.log(input.value);
            if(input.value == null || input.value == "") {
                console.log(input.id);
                createErrorMessage(input.id, "empty", "This field may not be left blank.");
                numOfErrors++;
            }
            else {
                removeErrorMessage(input.id, "empty");
            }
        }

        var password1 = document.getElementById("password").value;
        var password2 = document.getElementById("confirm-password").value;
        if(password1 != password2) {
            createErrorMessage("password", "match", "Your passwords do not match.");
            numOfErrors++;
        }
        else {
            removeErrorMessage("password", "match");
        }

        if(numOfErrors > 0) {
            evt.preventDefault();
        }
    }

    function processInput(input) {
        var emailInput = document.getElementById(input);

        var emailPattern = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
    }

    console.log('load');
    window.addEventListener("load", init);
</script>

<?php
    require_once("components/footer.php");
?>