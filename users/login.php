<?php

class UserAuthenticator {
    private $pdoConnection;
    private $username;
    private $password;

    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
        // Start the user session
        session_start();
        // Display errors
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    public function loginUser($formUsername, $formPassword)
    {
        $this->username = $formUsername;
        $this->password = $formPassword;
    
        try {
            if (!$this->validateInput()) {
                throw new Exception('Both username and password are required.');
            }
    
            $user = $this->checkCredentials();
            if (!$user) {
                throw new Exception('No such user exists or wrong password.');
            }
    
            $this->setSessionVariables($user);
            header("Location: index.php");
            exit();
        } catch (Exception $e) {
            // Display the error message or log it
            echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
        }
    }
    

    private function validateInput() 
    {
        if (empty($this->username) || empty($this->password)) {
            echo '<div class="alert alert-danger">Please enter both username and password</div>';
            return false;
        }
        return true;
    }

    private function checkCredentials()
    {
        $query = $this->pdoConnection->prepare("SELECT * FROM user WHERE username = ?"); // '?' acts as a placeholder and tells PDO to expect a parameter when the prepared statement is executed
        $query->execute([$this->username]);
        $user = $query->fetch(PDO::FETCH_ASSOC); // 'FETCH_ASSOC' returns the next row from fetch as an associative array
        
        // Check if user exists
        if (!$user) {
            echo '<div class="alert alert-danger">No such user exists</div>';
            return false;
        } elseif (!password_verify($this->password, $user['password'])) {
            echo '<div class="alert alert-danger">Wrong password</div>';
            return false;
        }
        return $user;
    }

    private function setSessionVariables($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['logged_in'] = true;
    }
}

// Usage
require "../db.php";
$userAuthenticator = new UserAuthenticator($pdoConnection);
if (isset($_POST['submit'])) {
    $userAuthenticator->loginUser($_POST['username'], $_POST['password']);
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