<?php
// Start the user session
session_start();

// Create database connection
require "db.php";

// Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// If the login button is submitted, execute the login code
if (isset($_POST['submit'])) {
    $formUsername = $_POST['username']; // Stores the value from form name 'username' in a variable
    $formPassword = $_POST['password']; // Stores the value from form name 'password'

    // Check if username and password are provided
    if (empty($formUsername) || empty($formPassword)) {
        echo '<div class="alert alert-danger">Please enter both username and password</div>';
    } else {
        // Retrieve the user data from the database
        $query = $PDOConnection->prepare("SELECT * FROM user WHERE username = ?"); // '?' acts as a placeholder and tells PDO to expect a parameter when the prepared statement is executed
        $user = $query->fetch(PDO::FETCH_ASSOC); // 'FETCH_ASSOC' returns the next row from fetch as an associative array

        // Check if user exists
        if (!$user) {
            echo '<div class="alert alert-danger">No such user exists</div>';
        } else {
            // Check if input password matches with the database password
            if (!password_verify($formPassword, $user['password'])) {
                // If it does not match, give error
                echo '<div class="alert alert-danger">Wrong password</div>';
            } else {
                // If user is found and password is correct, set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['logged_in'] = true; // Session to indicate that the user is logged in

                // Upon succesful login, redirect the user to index.php
                header("Location: index.php");
                exit;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>

    </style>
</head>

<body>
    <div class="container">

        <div class="login-container">
            <div class="card p-4">
                <h2 class="text-center mb-4">Login</h2>
                <?php if (!empty($login_error)): ?>
                <div class="alert alert-danger"><?php echo $login_error; ?></div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block loginbutton" name="submit">Login</button>
                    <a href="create_user.php"><p>Create an account</p></a>
                </form>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>