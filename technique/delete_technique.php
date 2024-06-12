<?php
require "../config/db.php";

// Display errors for debugging (remove or turn off error reporting in a production environment)
ini_set('log_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['techniqueID'])) {
    // Assign the 'techniqueID' value from the form to a variable
    $techniqueID = $_POST['techniqueID'];

    // Prepare a SQL query to delete a specific technique
    $query = "DELETE FROM Technique WHERE techniqueID=:techniqueID";

    // Use PDO Object 'prepare' to prevent SQL injection
    $delete = $pdoConnection->prepare($query);

    // Bind the integer techniqueID to the SQL statement
    $delete->bindValue(':techniqueID', $techniqueID, PDO::PARAM_INT);

    $delete->execute();
    header("Location: home_viewtechnique.php");
    exit();
}
?>