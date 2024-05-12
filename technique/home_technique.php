<?php 
// Start the session
session_start();
// Database connection
require "../db.php";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="container centered-container">
    
    <div class="card p-4">
        <h2 class="text-center mb-4">Grappling Technique Journal</h2>
        <p class="text-center"><?php echo $greeting; ?></p>


        <div id="accordion">
        <a href="../index.php" class="btn btn-primary btn1">Back to Home</a>

            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Add a technique to the database.
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">

                    <!-- Technique Form Column -->
                    <div class="col-md-4">
                        <form action="home_technique.php" method="POST">
                            <h4>Add a New Technique</h4>

                            <!-- Name -->
                            <div class="form-group">
                                <label for="techniqueName">Technique Name:</label>
                                <input type="text" class="form-control" id="techniqueName" name="techniqueName" required>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="techniqueDescription">Description:</label>
                                <textarea class="form-control" id="techniqueDescription" name="techniqueDescription" required></textarea>
                            </div>

                            <!-- Category -->
                            <div class="form-group">
                                <label for="techniqueCategory">Category:</label>
                                <select class="form-control" id="categoryID" name="categoryID" required>
                                    <option value="">Select a Category</option>
                                    <?= $categoryOptions; ?>
                                </select>
                            </div>

                            <!-- Position -->
                            <div class="form-group">
                                <label for="techniquePosition">Position:</label>
                                <select class="form-control" id="positionID" name="positionID" required>
                                    <option value="">Select a Position</option>
                                    <?= $positionOptions; ?>
                                </select>
                            </div>

                            <!-- Difficulty -->
                            <div class="form-group">
                                <label for="techniqueDifficulty">Difficulty:</label>
                                <select class="form-control" id="difficultyID" name="difficultyID" required>
                                    <option value="">Select a Difficulty</option>
                                    <?= $difficultyOptions; ?>
                                </select>
                            </div>

                            <button type="submit" name="submitTechnique" class="btn btn-primary btn1">Add Technique</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <div class="card">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Add a category to the database.
                </button>
            </h5>
        </div>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
                <!-- Category Form Column -->
                <div class="col-md-4">
                    <form action="home_technique.php" method="POST">

                        <!-- Category name -->
                        <h4>Add a New Category</h4>
                        <div class="form-group">
                            <label for="categoryName">Category Name:</label>
                            <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                        </div>

                        <div class="form-group">
                            <label for="categoryDescription">Category Name:</label>
                            <input type="text" class="form-control" id="categoryDescription" name="categoryDescription" required>
                        </div>
                        <button type="submit" name="submitCategory" class="btn btn-primary btn1">Add Category</button>
                    </form>
                </div>        
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Add a position to the database.
                </button>
            </h5>
        </div>

        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                <!-- Position Form Column -->
                <div class="col-md-4">
                    <form action="home_technique.php" method="POST">

                        <!-- Position name -->
                        <h4>Add a New Position</h4>
                        <div class="form-group">
                            <label for="positionName">Position Name:</label>
                            <input type="text" class="form-control" id="positionName" name="positionName" required>
                        </div>

                        <!-- Position description -->
                        <div class="form-group">
                            <label for="positionDescription">Position Name:</label>
                            <input type="text" class="form-control" id="positionDescription" name="positionDescription" required>
                        </div>
                        <button type="submit" name="submitPosition" class="btn btn-primary btn1">Add Position</button>
                    </form>
                </div>        
            </div>
        </div>
    </div>


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
