<?php 
// Start the session
session_start();

class CreateTechnique {
    private $pdoConnection;
    private $techniqueName;
    private $techniqueDescription;
    private $categoryID;
    private $positionID;
    private $difficultyID;

    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
        error_reporting(E_ALL); // Report all PHP errors
        ini_set('display_errors', 1); // Display errors to the browser
    }

    // Add technique is the main function that adds the technique to the database
    public function addTechnique($formTechniqueName, $formTechniqueDescription, $formcategoryID, $formPositionCategory, $formdifficultyID)
    {
        // 'this' represents the current instance of the class in which it is used
        // Sets the variables to the required method parameters
        $this->techniqueName = trim($formTechniqueName);
        $this->techniqueDescription = trim($formTechniqueDescription);
        $this->categoryID = trim($formcategoryID);
        $this->positionID = trim($formPositionCategory);
        $this->difficultyID = trim($formdifficultyID);

        $this->validateInput();
        $this->createTechnique();

    }

    private function validateInput()
    {
        if (empty($this->techniqueName)) {
            throw new Exception('Please enter technique name.');
        }
        if (empty($this->categoryID)) {
            throw new Exception('Please choose category.');
        }
        if (empty($this->positionID)) {
            throw new Exception('Please choose position.');
        }  
        if (empty($this->difficultyID)) {
            throw new Exception('Please choose difficulty.');
        }
    }

    private function createTechnique() 
    {
        $insert_query = "INSERT INTO Technique (techniqueName, techniqueDescription, categoryID, positionID, difficultyID) VALUES(:techniqueName, :techniqueDescription, :categoryID, :positionID, :difficultyID)";

        // Access the private pdoConnection in the class
        $statement = $this->pdoConnection->prepare($insert_query);

            // Bind user input variables to the prepared statement as parameters to ensure safe database insertion
            $statement->bindParam(":techniqueName", $this->techniqueName, PDO::PARAM_STR);
            $statement->bindParam(":techniqueDescription", $this->techniqueDescription, PDO::PARAM_STR);
            $statement->bindParam(":categoryID", $this->categoryID, PDO::PARAM_INT);
            $statement->bindParam(":positionID", $this->positionID, PDO::PARAM_INT);
            $statement->bindParam(":difficultyID", $this->difficultyID, PDO::PARAM_INT);

            // Execute the prepared statement and check the result, throw an exception if it fails
            if (!$statement->execute()) {
                error_log("Failed to execute query: " . $statement->errorInfo()[2]); // Log SQL error
                throw new Exception("Error creating technique");
            } else {
                error_log("Technique created successfully"); // Confirm successful execution
            }
    }
}

$error_message = '';

// Usage of CreateTechnique class

// Require database connection file
require "../db.php";
// Instantiate CreateTechnique class, providing the PDO database connection object as parameter
$createTechnique = new CreateTechnique($pdoConnection);

// Checks if form submit button is clicked and use the object to run the addTechnique method
if (isset($_POST['submit'])) {
// Before calling addTechnique, validate that the IDs exist in their respective tables
$validPosition = $pdoConnection->prepare("SELECT 1 FROM Position WHERE positionID = ?");
$validPosition->execute([$_POST['positionID']]);
if ($validPosition->fetch()) {
    // The positionID exists
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
} else {
    error_log("The provided positionID does not exist in the Position table.");
    $error_message = "Invalid positionID.";
    // Handle the error as needed
}

}


// Database connection
require "../db.php";

// Require create_technique.php
require "../technique/create_technique.php";

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
    '<option value="' .
    htmlspecialchars($row['positionID']) . '">' .
    htmlspecialchars($row['positionName']) .
    '</option>';
}

// Prepare difficulty options dropown menu
$difficultyOptions = '';
$statement = $pdoConnection->query('SELECT difficultyID, difficulty FROM Difficulty');
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $difficultyOptions .=
    '<option value="' .
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

                    <button type="submit" name="submit" class="btn btn-primary btn1">Add Technique</button>
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
