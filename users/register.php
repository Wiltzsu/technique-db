<?php
// Database connection
require "db.php";

// Display errors
ini_set('display errors', 1);
error_reporting(E_ALL);

// Create and initialize login variables with empty values
$username = $email = $password = "";
$username_error = $email_error = $password_error = "";

// Process form data when form is submitted
// '$_SERVER' is a PHP superglobal variable which holds information about headers, paths and script locations
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Extract and trim the username from the POST data
    $username = trim($_POST['username']);
    // Validate username, assign to error variable if empty
    if (empty($username)) {
        $username_error = "Please enter a username";
    }

    // Extract and trim the email from the POST data
    $email = trim($_POST['email']);
    // Validate email, assign to error variable if empty
    if (empty($email)) {
        $email_error = "Please enter an email address.";
    }

    // Extract and trim the password from the POST data
    $password = trim($_POST['password']);
    // Validate password, assign to error variable if empty
    if (empty($password)) {
        $password_error = "Please enter a password.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Check if any input errors
    if (empty($username_error) && (empty($email_error)) && empty($password_error)) {
        // Prepare an insert statement to insert the values to the database
        $user_values = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";

        // The prepare() method attempts to prepare the SQL statement for execution and returns a PDO statement object on success, or false on failure
        // The returned value is then assigned to a variable
        if ($statement = $PDOConnection->prepare($user_values)) {

            // 'bindParam' method binds a PHP variable to a corresponding named or question mark placeholder in the SQL statement that was prepared
            // ':username', ':email' and ':password are the placeholders in the SQL statement 
            // 'PDO::PARAM_STR' indicates that the parameters are strings
            $statement->bindParam(":username", $param_username, PDO::PARAM_STR);
            $statement->bindParam(":email", $param_email, PDO::PARAM_STR);
            $statement->bindParam(":password", $param_password, PDO::PARAM_STR);

            // 'param_username', 'param_email' and 'param_password' are the PHP variables that are bound to these placeholders
            $param_username = $username;
            $param_email = $email;
            $param_password = $password;

            // Attempt to execute the prepared statement, start a new session if successful
            if ($statement->execute()) {
                // Start a session
                session_start();

                // Store the user data in session variables
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;

                // Upon successful user creation, redirect the user to the login page
                header("Location: login.php");
                exit();
            } else {
                $errorInfo = $statement->errorInfo();
                echo '<div style="background-color: red; color: white; padding: 10px; text-align: center;">User creation unsuccessful: ' . $errorInfo[2] . '</div>';
            }
        }
    }
}
?>