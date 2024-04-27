<?php 
// Start the session
session_start();

// Database connection
require "../db.php";

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

// Prepare category options dropdown menu
$categoryOptions = '';
$statement = $pdoConnection->query('SELECT categoryID, categoryName FROM Category');
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $categoryOptions .= 
    '<option value="' . 
    htmlspecialchars($row['categoryID']) . '">' . 
    htmlspecialchars($row['categoryName']) . 
    '</option>';
}

// Prepare position options dropdown menu
$positionOptions = '';
$statement = $pdoConnection->query('SELECT positionID, positionName FROM Position');
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $positionOptions .=
    '<option value"' .
    htmlspecialchars($row['positionID']) . '">' .
    htmlspecialchars($row['positionName']) .
    '</option>';
}

// Prepare difficulty options dropown menu
$difficultyOptions = '';
$statement = $pdoConnection->query('SELECT difficultyID, difficulty FROM Difficulty');
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $difficultyOptions .=
    '<option value"' .
    htmlspecialchars($row['difficultyID']) . '">' .
    htmlspecialchars($row['difficulty']) .
    '</option>';
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

        <div class="row">
            <!-- Technique Form Column -->
            <div class="col-md-4">
                <form action="submit_technique.php" method="POST">
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
                        <select class="form-control" id="techniqueCategory" name="techniqueCategory" required>
                            <option value="">Select a Category</option>
                            <?= $categoryOptions; ?>
                        </select>
                    </div>

                    <!-- Position -->
                    <div class="form-group">
                        <label for="techniquePosition">Position:</label>
                        <select class="form-control" id="positionCategory" name="positionCategory" required>
                            <option value="">Select a Position</option>
                            <?= $positionOptions; ?>
                        </select>
                    </div>

                    <!-- Difficulty -->
                    <div class="form-group">
                        <label for="techniqueDifficulty">Difficulty:</label>
                        <select class="form-control" id="difficultyCategory" name="difficultyCategory" required>
                            <option value="">Select a Difficulty</option>
                            <?= $difficultyOptions; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn1">Add Technique</button>
                </form>
            </div>

            <!-- Category Form Column -->
            <div class="col-md-4">
                <form action="submit_category.php" method="POST">
                    <h4>Add a New Category</h4>
                    <div class="form-group">
                        <label for="categoryName">Category Name:</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn1">Add Category</button>
                </form>
            </div>

            <!-- Position Form Column -->
            <div class="col-md-4">
                <form action="submit_position.php" method="POST">
                    <h4>Add a New Position</h4>
                    <div class="form-group">
                        <label for="positionName">Position Name:</label>
                        <input type="text" class="form-control" id="positionName" name="positionName" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn1">Add Position</button>
                </form>
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
