<?php 
// Start the session
session_start();

// Database connection
require "db.php";

// Display errors for debugging (remove or turn off error reporting in a production environment)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in and then greet them
$username = '';
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $greeting = "Hello, " . htmlspecialchars($username);
} else {
    $greeting = "Welcome to your BJJ Technique Diary. Keep track of your training, add new techniques, and personalize your learning journey.";
}

if (!isset($_SESSION['username']))
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
        <h2 class="text-center mb-4">BJJ Technique Diary</h2>
        <p class="text-center"><?php echo $greeting; ?></p>

        <div class="list-group">
            <a href="diary.php" class="list-group-item list-group-item-action">
                <strong>Diary:</strong> View and log your daily technique practice.
            </a>
            <a href="edit.php" class="list-group-item list-group-item-action">
                <strong>Edit Techniques:</strong> Add new techniques, categories, and positions.
            </a>
            <a href="profile.php" class="list-group-item list-group-item-action">
                <strong>Your Profile:</strong> View and edit your personal information.
            </a>
        </div>

        <?php 
        if (!isset($_SESSION['username'])) {?>
        <div class="text-center mt-3">
            <a href="users/login.php" class="btn btn-primary">Login</a>
            <a href="users/register.php" class="btn btn-secondary ml-2">Sign Up</a>
        </div>
        <?php }?>

        <?php
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {?>
                <div class="text-center mt-3">
            <a href="users/logout.php" class="btn btn-primary">Logout</a>
        </div><?php
        }?>


    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
