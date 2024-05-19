<?php
// Start the session
session_start();
// Database connection
require "../config/db.php";
// Require necessary files
include "create_options.php";
include "create_technique.php";
include "create_position.php";
include "create_category.php";

// Display errors for debugging (remove or turn off error reporting in a production environment)
error_reporting(0);
ini_set('display_errors', 0);

// Check if the user is logged in and then greet them
$username = '';
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $greeting = "Hello, " . htmlspecialchars($username);
} else {
    $greeting = "Welcome to your BJJ Technique Diary. Keep track of your training, add new techniques, and personalize your learning journey.";
}

// Set an error message variable for insertion logic
$error_message = '';

// Instantiate CreateTechnique class, providing the PDO database connection object as parameter
$createTechnique = new CreateTechnique($pdoConnection);

// Checks if form 'submitTechnique' button is clicked and uses the object to run the addTechnique method
if (isset($_POST['submitTechnique'])) {
        try {
            if ($createTechnique->addTechnique(
                $_POST['techniqueName'],
                $_POST['techniqueDescription'],
                $_POST['categoryID'],
                $_POST['positionID'],
                $_POST['difficultyID'])) {
                // If the insertion is successful, redirect
                header("Location: home_technique.php");
                exit();
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $error_message = $e->getMessage();
        }
    }

// Instantiate CreateCategory class, providing the PDO database connection object as parameter
$createCategory = new CreateCategory($pdoConnection);

// Checks if form 'submitCategory' is pressed and uses the object to call the addCategory method with given parameters
if (isset($_POST['submitCategory'])) {
    try {
        if ($createCategory->addCategory($_POST['categoryName'], $_POST['categoryDescription'])) {
            // If the insertion is successful, redirect user
            header("Location: home_technique.php");
            exit();
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        $error_message = $e->getMessage();
    }
}

// Instantiate CreatePosition class, providing the PDO database connection object as parameter
$createPosition = new CreatePosition($pdoConnection);

// Checks if form 'submitPosition' button is clicked and uses the object to call the addTechnique method
if (isset($_POST['submitPosition'])) {
    try {
        if ($createPosition->addPosition($_POST['positionName'], $_POST['positionDescription'])) {
            // If the insertion is successful, redirect user
            header("Location: home_technique.php");
            exit();
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        $error_message = $e->getMessage();
    }
}
?>