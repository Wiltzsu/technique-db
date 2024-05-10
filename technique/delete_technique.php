<?php
// Include the database connection file
require "../db.php";

// Enable error reporting in the browser (turn off for production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['techniqueID'])) {
    // Assign the 'techniqueID' value from the form to a variable
    $techniqueID = $_POST['techniqueID'];

    // Prepare a SQL query to delete a specific technique
    $query = "DELETE FROM Technique WHERE techniqueID=:techniqueID";

    // Use PDO Object 'prepare' to prevent SQL injection
    $delete = $pdoConnection->prepare($query);

    // Bind the integer techniqueID to the SQL statement
    $delete->bindValue(':techniqueID', $techniqueID, PDO::PARAM_INT);

    // Try to excecute the query and redirect upon successful deletion
    try {
        $delete->execute();
        header("Location: home_viewtechnique.php");
        exit();
        // Otherwise give an error and log it
    } catch (Exception $e) {
        error_log("PDO Error: " . $e->getMessage());
        echo "Error: " . $e->getMessage();
    }
}
?>