<?php 
// Start the session
session_start();

// Database connection
require "config/db.php";

// Display errors for debugging (remove or turn off error reporting in a production environment)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in and then greet them
$username = '';
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $greeting = "Hello, " . htmlspecialchars($username);
} else {
    header("Location: users/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
</head>
<body>

<div class="container centered-container">
    <div class="card p-4">
        <h2 class="text-center mb-4">Grappling Technique Journal</h2>
        <p class="text-center"><?php echo $greeting; ?></p>

        <div class="list-group">
            <a href="journal/journal.php" class="list-group-item list-group-item-action">
                <strong>Journal:</strong> View and log your daily practice.
            </a>

            <a href="technique/home_technique.php" class="list-group-item list-group-item-action">
                <strong>Add:</strong> Add new techniques, categories, and positions.
            </a>

            <a href="technique/home_viewtechnique.php" class="list-group-item list-group-item-action">
                <strong>View:</strong> View your techniques, categories, and positions.
            </a>

            <a href="profile.php" class="list-group-item list-group-item-action">
                <strong>Your Profile:</strong> View and edit your personal information.
            </a>
        </div>

        <?php 
        if (!isset($_SESSION['username'])) {?>
        <div class="text-center mt-3">
            <a href="users/login.php" class="btn btn-primary">Login</a>
            <a href="users/register.php" class="btn btn-secondary btn1 ml-2">Sign Up</a>
        </div>
        <?php }?>

        <?php
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {?>
                <div class="text-center mt-3">
            <a href="users/logout.php" class="btn btn-primary btn1">Logout</a>
        </div><?php
        }?>


    </div>


</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
