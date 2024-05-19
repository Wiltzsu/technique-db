<?php
// Start the session for session management
session_start();
// Require database connection file
require "../Config/db.php";
// Include necessary files
include "technique_class_options.php";
include "read_technique_class.php";

// Display errors for debugging (remove or turn off error reporting in a production environment)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in and then greet them
$username = '';
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $greeting = "Hello, " . htmlspecialchars($username);
} else {
    header("Location: ../users/login.php");
}

// Instantiate CreateTechniqueClass class, providing the PDO database connection as a parameter
//$readTechniqueClass = new CreateTechniqueClass($pdoConnection);

// Trigger the reading and JSON creation process
//$readTechniqueClass->readTechniqueClass();
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
                        Log training
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">

                    <div class="col-md-4">
                    <!-- Journal Form -->
                    <form action="" method="POST">
                        <h4>Add a journal note</h4>

                        <!-- Technique ID -->
                        <div class="form-group">
                            <label for="techniqueID">Technique:</label>
                            <select class="form-control" id="techniqueID" name="techniqueID" required>
                                <option value="">Select a technique</option>
                                <?= $techniqueOptions; ?>
                            </select>
                        </div>

                        <!-- Class ID -->
                        <div class="form-group">
                            <label for="classID">Class:</label>
                            <select class="form-control" id="classID" name="classID" required>
                                <option value="">Select a class</option>
                                <?= $classOptions; ?>
                            </select>
                        </div>

                        <button type="submit" name="submitTechniqueClass" class="btn btn-primary btn1">Add to journal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Journal
                </button>
            </h5>
        </div>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">


            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                View your positions.
                </button>
            </h5>
        </div>

        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">

            </div>        
        </div>
    </div>


        <?php
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {?>
                <div class="text-center mt-3">
            <a href="../users/logout.php" class="btn btn-primary btn1">Logout</a>
        </div><?php
        }?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
