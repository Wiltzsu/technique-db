<?php

// Create a class for user authentication with variables for database connection, username and password
class UserAuthenticator {
    private $pdoConnection;
    private $username;
    private $password;

    // Constructor initializes the class with a database connection and sets up the PHP environment for session and error reporting
    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
        session_start(); // Begin a new session or resume the existing one
        error_reporting(E_ALL); // Report all PHP errors
        ini_set('display_errors', 1); // Display errors to the browser
    }

    // loginUser method attempts to log in a user using provided username and password from the form
    public function loginUser($formUsername, $formPassword)
    {
        // 'this' represents the current instance of the class in which it is used
        $this->username = $formUsername;
        $this->password = $formPassword;

        // Validates input and checks credentials. Throws exceptions on failure
        $user = $this->validateInput(); // This is also used to call other methods in the same object
        $user = $this->checkCredentials();
        // Sets session variables upon successful login
        $this->setSessionVariables($user);
        return true;
    }
    

    // Validates user input and throws an exception if the username and password are empty
    private function validateInput() 
    {
        if (empty($this->username) || empty($this->password)) {
            throw new Exception('Please enter both username and password.');
        }
        return true; // Returns the Exception to the loginUser method when the if block is true
    }

    // Checks user credentials against the database. Throws exceptions on failure
    private function checkCredentials()
    {
        // '?' acts as a placeholder and tells PDO to expect a parameter when the prepared statement is executed
        $query = $this->pdoConnection->prepare("SELECT * FROM User WHERE username = ?"); 
        // Execute the prepared statement with the provided username. This replaces the '?' placeholder with the actual username, ensuring the value is properly quoted and escaped
        $query->execute([$this->username]);
        // Retrieve the result of the query as an associative array where column names are keys. This array represents the user data fetched from the database
        // Fetch is used to retrieve the next row from the result set
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        // Check if user exists
        if (!$user) { // If the user does not exist, throw an exception
            throw new Exception('No such user exists.');
        // If the user is found, verify the form input password with the database password
        } elseif (!password_verify($this->password, $user['password'])) { 
            throw new Exception('Wrong password.'); // If the password does not match, throw an exception
        }
        return $user; // Returns either the correct credentials or the exceptions
    }

    // Method to set session variables for the user
    private function setSessionVariables($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['logged_in'] = true;
    }
}

$error_message = ''; // Initiate an empty error message variable

// Usage of UserAuthenticator class

// Require database connection file
require "../db.php";
// Create a new login object that takes the database connection as a parameter
$userAuthenticator = new UserAuthenticator($pdoConnection);

// If submit button is pressed in the form, use the object to run the loginUser method with inserted credentials
if (isset($_POST['submit'])) {
    try {
        if ($userAuthenticator->loginUser($_POST['username'], $_POST['password'])) {
        // If the login is successful, redirect the user to the index page
        header("Location: ../index.php");
        exit();
        }

    } catch (Exception $e) {
        // Log the error
        error_log($e->getMessage());
        // Render an error message to the user
        $error_message = $e->getMessage();
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
    <link href="../css/style.css" rel="stylesheet">
    <style>

    </style>
</head>

<body>
    <div class="container">

        <div class="login-container">
            <div class="card p-4">
                <h2 class="text-center mb-4">Login</h2>
                <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
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
                    <a href="register.php"><p>Create an account</p></a>
                </form>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>