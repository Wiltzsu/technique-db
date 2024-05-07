<?php
require "../db.php";

// Display errors for debugging (remove or turn off error reporting in a production environment)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['categoryID'])) {
    $categoryID = $_POST['categoryID'];
    $query = "DELETE FROM Category WHERE categoryID=:categoryID";
    $delete = $pdoConnection->prepare($query);

    $delete->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);

    try {
        $delete->execute();
        header("Location: home_viewtechnique.php");
    } catch (PDOException $e) {
        error_log("PDO Error: " . $e->getMessage());
        echo "Error: " . $e->getMessage();
    } 
}
?>