<?php
    require_once("dbconn.php");

    session_start();

    // This function registers a new user with the site and creates an account for them
    function registerUser($name, $password, $email) {

        // Get a database connection
        $connection = dbConnect();

        // Set up a query to insert a new user into the database
        $query = "INSERT INTO Users (Name, Password, Email) VALUES (?, ?, ?)";
        $statement = $connection->stmt_init();

        if($statement->prepare($query)) {
            // Used password_hash to prevent passwords being stored in plain text in the database
            // Reference: https://www.php.net/manual/en/function.password-hash.php
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $statement->bind_param("sss", $name, $hashed, $email);
            
            if($statement->execute()) {
                log_in($email, $password);
            }

            // Close the connection to the database
            $statement->close();
        }
            // An error occurred while attempting to prepare the query
            // TODO
            //$specialMessage = createSpecialMessage("Oops!", "An internal database query failed while attempting to create your account. Please try again later.", "error");
    }

    function log_in($email, $password) {
        if(!empty($email) && !empty($password)) {
            
            // Get a database connection
            $connection = dbConnect();

            // Set up a query to retrieve a user's login credentials from the database
            $query = "SELECT UserID, Name, Password, Email, IsStaff FROM Users WHERE Email = ?";
            $statement = $connection->stmt_init();

            if($statement->prepare($query)) {
                $statement->bind_param("s", $email);

                $statement->execute();

                // Bind the login information to variables
                $statement->bind_result($UserID, $Name, $Password, $Email, $IsStaff);
                if($statement->fetch()) {

                    // If the password that the user typed in matches the hashed password stored in the database, log them in
                    // Reference: https://www.php.net/manual/en/function.password-verify.php
                    if(password_verify($password, $Password)) {

                        // Set session variables storing the user's ID, name, and permissions
                        $_SESSION["userID"] = $UserID;
                        $_SESSION["name"] = $Name;
                        $_SESSION["isStaff"] = $IsStaff;

                        // Close the connection to the database
                        $statement->close();
                        header("Location: index.php");
                        exit();
                    }
                    else {
                        // The user typed in an incorrect password
                        //$specialMessage = createSpecialMessage("Oops!", "You have entered an incorrect password. Please try again.", "error");
                    }
                }
                else {
                    // A user with the given username was not found
                    //$specialMessage = createSpecialMessage("Oops!", "User not found!", "error");
                }

                // Close the connection to the database
                $statement->close();
            }
            else {
                // An error occurred while attempting to prepare the query
                //$specialMessage = createSpecialMessage("Oops!", "Database query failed. Please try again.", "error");
            }
        }
        else {
            // The username/email address provided is empty (should not be possible)
            //$specialMessage = createSpecialMessage("Oops!", "Fields empty!", "error");
        }
    }

    function getInputValue($inputName) {
        if(isset($inputName) && array_key_exists($inputName, $_POST)) {
            $value = $_POST[$inputName];
            echo "value=\"$value\"";
        }
    }

    function getNameFromId($id) {
        $connection = dbConnect();

        // Set up a query to obtain the blog post
        $query = "SELECT Name FROM Users WHERE UserID = ?";
        $statement = $connection->stmt_init();

        if($statement->prepare($query)) {
            $statement->bind_param("i", $id);

            $statement->execute();

            // Save the post's information to variables
            $statement->bind_result($name);

            $statement->fetch();

            // Close the database connection
            $statement->close();
        }

        return $name;
    }

    function getEventsForUser($id) {
        $eventsRegisteredFor = [];

        $connection = dbConnect();
        $query = "";
        
        if($id == null || $id == 0) {
            $query = "SELECT * FROM Registrations";
        }
        else {
            $query = "SELECT * FROM Registrations WHERE UserID = ?";
        }
        
        
        $statement = $connection->stmt_init();

        if($statement->prepare($query)) {
            $statement->bind_param("i", $id);

            $statement->execute();
            $statement->bind_result($RegistrationID, $RegistrationTime, $EventID, $UserID, $EventType);

            while($statement->fetch()) {
                array_push($eventsRegisteredFor, $EventID);
            }

            $statement->close();
        }

        return $eventsRegisteredFor;
    }

    function getNumberOfRegisteredUsers($eventID) {
        $connection = dbConnect();
        $num = 0;

        $query = "SELECT UserID FROM Registrations WHERE EventID = ?";
        $statement = $connection->stmt_init();

        if($statement->prepare($query)) {
            $statement->bind_param("i", $eventID);

            $statement->execute();
            $statement->store_result();
            $statement->bind_result($UserID);
            $num = $statement->num_rows;

            $statement->close();
        }

        return $num;
    }

?>