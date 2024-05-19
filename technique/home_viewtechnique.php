<?php 
// Start the session
session_start();
// Database connection
require "..config/db.php";
// Include necessary files
include "read_techniques.php";
include "read_categories.php";
include "read_positions.php";

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
$techniques_file_path = "./data/techniques.json";

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
$categories_file_path = "./data/techniques.json";

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

// Instantiate CreatePosition class, provide the PDO database connection object as a parameter
$readPositions = new ReadPositions($pdoConnection);

// Trigger the reading and JSON creating process
$readPositions->readPositions();

// Assign the JSON file path to a variable
$positions_file_path = "./data/techniques.json";

// Check if 'positions.json' exists
if (file_exists($positions_file_path)) {
    // Check if file is readable
    if (is_readable($positions_file_path)) {
        // Get file contents
        $position_json_data = file_get_contents($positions_file_path);
        // Decode the JSON data into a PHP array
        $position_array = json_decode($position_json_data, true);

        // Check if '$position_array' is an array and contains a key named 'positions'
        if (isset($position_array['positions']) && is_array($position_array['positions']))
        {
            // Iterate through each item in the array
            foreach ($position_array['positions'] as $position)
            {
                $positionID = $position['positionID'];
                $positionName = $position['positionName'];
                $positionDescription = $position['positionDescription'];
            }
        }
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
                                echo '<div class="card-body">';?>
                                <form action="delete_technique.php" method="POST">
                                    <input type="hidden" name="techniqueID" value="<?php echo $technique['techniqueID'] ?>"> <!-- Echos 'techniqueID' value from $technique array -->
                                    <button type="submit" class="btn">
                                        <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/icons/trash.svg" alt="Delete">
                                    </button>
                                </form>
                                <?php
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
                        ?> 
                        <form action="delete_category.php" method="POST">
                            <input type="hidden" name="categoryID" value="<?php echo $category['categoryID'] ?>">
                            <button type="submit" class="btn">
                                <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/icons/trash.svg" alt="Delete">
                            </button>
                        </form>
                        <?php
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
            <?php
                if (isset($position_array['positions']) && is_array($position_array['positions'])) {
                    echo '<div class="row">'; // Bootstrap layout
                    foreach ($position_array['positions'] as $position) {
                        echo '<div class="col-md-4 mb-3">'; // Each position in a column
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        ?>
                        <div class="d-flex justify-content-between align-items-center"> <!-- Flexbox for horizontal layout -->
                            <h5 class="card-title"><?php echo htmlspecialchars($position['positionName'] ?? ''); ?></h5> <!-- Position title -->
                            
                            <!-- Button to trigger modal -->
                            <button type="button" class="btn" data-toggle="modal" data-target="#modal<?php echo $position['positionID']; ?>">
                                <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/icons/trash.svg" alt="Delete">
                            </button>
                        </div>

                        <p class="card-text"><?php echo htmlspecialchars($position['positionDescription'] ?? ''); ?></p> <!-- Position description -->

                        <!-- Modal for deletion confirmation -->
                        <div class="modal fade" id="modal<?php echo $position['positionID']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the position "<?php echo htmlspecialchars($position['positionName']); ?>"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <!-- Form for deletion -->
                                        <form action="delete_position.php" method="POST">
                                            <input type="hidden" name="positionID" value="<?php echo $position['positionID']; ?>">
                                            <button type="submit" class="btn btn-danger">Delete position</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        echo '</div>'; // Card body end
                        echo '</div>'; // Card end
                        echo '</div>'; // Column end
                    }
                    echo '</div>'; // Row end
                }
                ?>
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
