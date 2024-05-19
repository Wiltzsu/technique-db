<?php
require "../db.php";

// Display errors for debugging (remove or turn off error reporting in a production environment)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Checks if categoryID is present in the POST request to process the deletion
if (isset($_POST['categoryID'])) {
    // Assign the post value 'categoryID' to a variable
    $categoryID = $_POST['categoryID'];
    
    // Prepare a SQL query to delete a specific category ID
    $query = "DELETE FROM Category WHERE categoryID=:categoryID";
    
    // Prepares the SQL statement for execution to prevent SQL injection
    $delete = $pdoConnection->prepare($query);

    // Bind the integer categoryID to the SQL statement
    $delete->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);

    // Execute the query and redirect to home_viewtechnique.php upon successful deletion
    $delete->execute();
    header("Location: home_viewtechnique.php");
    exit();

}
?>