<?php
require "../config/db.php";

// Create a class for displaying techniques
class ReadTechniques {
    private $pdoConnection;

    // The constructor initializes the newly created object
    // The class depends on an existing database connection (pdoConnection)
    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection; // The PDO connection object is assigned to the class's $pdoConnection property
    }

    public function readTechniques()
    {
        $this->techniquesToJSON();
    }

    private function techniquesToJSON() 
    {
        // SQL query to get the techniques from the database
        $query = "SELECT Technique.techniqueID, Technique.techniqueName, Technique.techniqueDescription, Category.categoryName, Difficulty.difficulty, Position.positionName
        FROM Technique
        INNER JOIN Category
        ON Technique.categoryID = Category.categoryID
        INNER JOIN Difficulty
        ON Technique.difficultyID = Difficulty.difficultyID
        INNER JOIN Position
        ON Technique.positionID = Position.positionID
        ORDER BY techniqueID DESC;";
        // Executes the SQL query using the query method of the PDO object stored in '$this->pdoConnection', result is stored in '$data'
        $data = $this->pdoConnection->query($query);

        // Fetches all the rows from the query, each row will be an associative array with column names as keys
        $techniques = $data->fetchAll(\PDO::FETCH_ASSOC); // Use backlash before global class to search in global namespace

        // Prepare array for JSON encoding
        // Creates an associative array with a single key 'techniques'
        $jsonData = ['techniques' => $techniques];

        // Converts the PHP array into a JSON-formatted string
        // PRETTY_PRINT makes the JSON string more readable
        $json = json_encode($jsonData, JSON_PRETTY_PRINT);

        // Write to JSON file 'techniques.json'
        // file_put_contents will create the file if it doesn't exist
        file_put_contents("techniques.json", $json);
    }
}
?>