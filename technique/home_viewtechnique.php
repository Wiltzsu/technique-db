<?php 
// Start the session
session_start();
// Database connection
require "../db.php";
// Include necessary files
include "read_techniques.php";
include "read_categories.php";

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

// Instantiate CreatePosition class, providing the PDO database connection object as parameter
$readTechniques = new ReadTechniques($pdoConnection);

// Trigger the reading and JSON creation process
$readTechniques->readTechniques();

// Assign the JSON file path to a variable
$techniques_file_path = "techniques.json";

// Check if 'techniques.json' exists
if (file_exists($techniques_file_path)) {
    // Check if file is readable
    if (is_readable($techniques_file_path)) {
        // Get file contents
        $technique_json_data = file_get_contents($techniques_file_path);
        // Decode the JSON data into a PHP array
        $technique_array = json_decode($technique_json_data, true);

        // Check if '$technique_array is an array and contains a key named 'techniques'
        if (isset($technique_array['techniques']) && is_array($technique_array['techniques'])) 
        {
            // Iterate through each item in the array
            foreach ($technique_array['techniques'] as $technique) 
            {
                $techniqueID = $technique['techniqueID'];
                $techniqueName = $technique['techniqueName'];
                $techniqueDescription = $technique['techniqueDescription'];
                $categoryName = $technique['categoryName'];
                $difficulty = $technique['difficulty'];
                $positionName = $technique['positionName'];
            }
        }
    }
}

// Instantiate CreateCategory class, providing the PDO database connection object as a parameter
$readCategories = new ReadCategories($pdoConnection);

// Trigger the reading and JSON creating process
$readCategories->readCategories();

// Assign the JSON file path to a variable
$categories_file_path = "categories.json";

// Check if 'categories.json' exists
if (file_exists($categories_file_path)) {
    // Check if file is readable
    if (is_readable($categories_file_path)) {
        // Get file contents
        $category_json_data = file_get_contents($categories_file_path);
        // Decode the JSON data into a PHP array
        $category_array = json_decode($category_json_data, true);

        // Check if '$category_array' is an array and contains a key named 'categories'
        if (isset($category_array['categories']) && is_array($category_array['categories']))
        {
            // Iterate through each item in the array
            foreach ($category_array['categories'] as $category)
            {
                $categoryID = $category['categoryID'];
                $categoryName = $category['categoryName'];
                $categoryDescription = $category['categoryDescription'];
            }
        }
    }
}

// 
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
                        View your techniques.
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                    <?php
                        if (isset($technique_array['techniques']) && is_array($technique_array['techniques'])) 
                        {
                            echo '<div class="row">'; // Row for better bootstrap layout
                            foreach ($technique_array['techniques'] as $technique) 
                            {
                                echo '<div class="col-md-4 mb-3">'; // Each technique in a column
                                echo '<div class="card">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . htmlspecialchars($technique['techniqueName']) . "</h5>";
                                echo '<p class="card-text">' . htmlspecialchars($technique['techniqueDescription']) . '</p>';
                                echo '<p class="card-text">' . htmlspecialchars($technique['categoryName']) . '</p>';
                                echo '<p class="card-text">' . htmlspecialchars($technique['positionName']) . '</p>';
                                echo '<p class="card-text">' . htmlspecialchars($technique['difficulty']) . '</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

    <div class="card">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                View your categories.
                </button>
            </h5>
        </div>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
            <?php
                if (isset($category_array['categories']) && is_array($category_array['categories']))
                {
                    echo '<div class="row">'; // Bootstrap layout
                    foreach ($category_array['categories'] as $category)
                    {
                        echo '<div class="col-md-4 mb-3">'; // Each technique in a column
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        // The null coalesing operator '??' used to provide a default value if field value is null
                        echo '<h5 class="card-title">' . htmlspecialchars($category['categoryName'] ?? '') . "</h5>";
                        echo '<p class="card-text">' . htmlspecialchars($category['categoryDescription'] ?? '') . "</p>";
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            ?>
      
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