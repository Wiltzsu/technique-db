<?php
require "../config/db.php";

// Display errors for debugging (remove or turn off error reporting in a production environment)
ini_set('log_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);


// Check if form with 'positionID' name is submitted
if (isset($_POST['positionID'])) {
    // Assign the value of 'positionID' to a variable
    $positionID = $_POST['positionID'];

    // Set the SQL query to delete a position from database with form positionID
    $query = "DELETE FROM Position WHERE positionID=:positionID";

    // Use PDO Object prepare to prevent SQL injection attacks
    $delete = $pdoConnection->prepare($query);

    // Bind the integer positionID to the SQL statement
    $delete->bindValue(':positionID', $positionID, PDO::PARAM_INT);

    $delete->execute();
    header("Location: home_viewtechnique.php");
    exit();

}
?>