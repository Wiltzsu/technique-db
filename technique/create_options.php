<?php
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