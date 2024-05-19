<?php
// Include necessary files
include "read_techniques.php";
include "read_categories.php";
include "read_positions.php";

// Display errors for debugging (remove or turn off error reporting in a production environment)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Instantiate CreatePosition class, providing the PDO database connection object as parameter
$readTechniques = new ReadTechniques($pdoConnection);

// Trigger the reading and JSON creation process
$readTechniques->readTechniques();

// Assign the JSON file path to a variable
$techniques_file_path = __DIR__ . '/../data/techniques.json'; // Corrected path

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
$categories_file_path = __DIR__ . '/../data/categories.json'; // Corrected path

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
$positions_file_path = __DIR__ . '/../data/positions.json'; // Corrected path

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