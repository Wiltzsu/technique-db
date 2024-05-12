<?php
// Prepare the technique options dropdown menu
$techniqueOptions = '';
$statement = $pdoConnection->query('SELECT techniqueID, techniqueName FROM Technique');
// Iterate through each row and fetch the values as an array
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $techniqueOptions .= 
    '<option value="' . 
    htmlspecialchars($row['techniqueID']) . '">' . 
    htmlspecialchars($row['techniqueName']) . 
    '</option>';
}

// Prepare the class options dropdown menu
$classOptions = '';
$statement = $pdoConnection->query('SELECT classID, instructor, location, date FROM Class');
// Iterate through the rows and fetch the values
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $classOptions .= 
    '<option value="' . 
    htmlspecialchars($row['classID']) . '">' .
    htmlspecialchars($row['instructor']) . ' "> ' . 
    htmlspecialchars($row['location']) . ' "> ' . 
    htmlspecialchars($row['date']) . 
    '</option>';
}
?>