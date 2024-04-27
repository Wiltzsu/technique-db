<?php

// Create class for new user registering
class UserRegistration {
    private $pdoConnection;
    private $username;
    private $email;
    private $password;
    private $hashed_password;

    // Constructor initializes the class with a database connection and sets up the PHP environment for session and error reporting
    public function __construct($pdoConnection)
    {
        // This represents the current instance of the class in which it is used
        $this->pdoConnection = $pdoConnection;
        session_start();
        error_reporting(E_ALL); // Report all PHP errors
        ini_set('display_errors', 1); // Display errors to the browser
    }
    // registerUser attempts to register the user with the given parameters and methods
    public function registerUser($formUsername, $formEmail, $formPassword)
    {
        // 'this' represents the current instance of the class in which it is used
        $this->username = trim($formUsername);
        $this->email = trim($formEmail);
        $this->password = trim($formPassword);
        $this->hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        $this->validateInput();
        $this->createUser();
    }

    // validateInput checks if any of the inputs are empty when submitting form
    private function validateInput() {
        if (empty($this->username)) {
            throw new Exception('Please enter a username.');
        }
        if (empty($this->email)) {
            throw new Exception('Please enter your email.');
        }
        if (empty($this->password)) {
            throw new Exception ('Please enter a password.');
        }
        if (empty($_POST['password_confirm'])) {
            throw new Exception ('Please confirm your password.');
        }
        // Checks if the second password field's input is the same as first
        if ($this->password !== $_POST['password_confirm']) {
            throw new Exception('Passwords do not match.');
        }
    }

    private function createUser()
    {
        $insert_query = "INSERT INTO User (username, email, password) VALUES(:username, :email, :password)";
        
        // Use $this to access the pdoConnection since it is set as a private property in the class
        // $this keyword is used within class methods to refer to the current object, regardless of wheter they're public, protected or private
        $statement = $this->pdoConnection->prepare($insert_query);
            
            // Bind variables to the prepared statement as parameters
            $statement->bindParam(":username", $this->username, PDO::PARAM_STR);
            $statement->bindParam(":email", $this->email, PDO::PARAM_STR);
            $statement->bindParam(":password", $this->hashed_password, PDO::PARAM_STR);

            if (!$statement->execute()) {
                throw new Exception("Error creating user.");
            }
    }
}

$error_message = ''; // Initiate an empty error message variable

// Usage of the userRegistration class

// Require database connection file
require "../db.php";
// Create a new register object that takes the database connection as a parameter
$userRegistration = new UserRegistration($pdoConnection);

// If submit button is pressed, use the object to run the registerUser method 
if (isset($_POST['submit'])) {
    try {
        $userRegistration->registerUser($_POST['username'], $_POST['email'], $_POST['password']);
        $_SESSION['username'] = $_POST['username']; // Consider setting this only after successful registration.
        header("Location: login.php"); // This should only happen if no exception was thrown.
        exit();
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
    <title>Create user</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="register-container">
            <div class="card p-4">
                <h2 class="text-center mb-4">Register</h2>
                <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <form method="POST" action="register.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password1">Password</label>
                        <input type="password" class="form-control" id="password1" name="password" placeholder="Enter password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password2">Re-enter password</label>
                        <input type="password" class="form-control" id="password2" name="password_confirm" placeholder="Enter password">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
                    <a href="login.php"><p>Login</p></a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
