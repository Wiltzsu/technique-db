<?php
require "../config/db.php";

// Create a class for displaying positions
class ReadPositions {
    private $pdoConnection;

    // Constructor initializes the newly created object
    // The class depends on an existing database connection (pdoConnection)
    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    public function readPositions()
    {
        $this->positionsToJSON();
    }

    private function positionsToJSON() 
    {
        // Query to fetch positions from the database
        $query = "SELECT * FROM Position ORDER BY positionID DESC;";

        // Execute the query using the query method PDO object stored in '$this->pdoConnection'
        $data = $this->pdoConnection->query($query);

        // Fetches all the rows from the query, each row as an associative array
        $positions = $data->fetchAll(\PDO::FETCH_ASSOC); // Search for global class in global namespace with backlash

        // Prepare array for JSON encoding
        // Creates an associative array with a single key named 'positions'
        $jsonData = ['positions' => $positions];

        // Convert the PHP array into a JSON formatted string
        $json = json_encode($jsonData, JSON_PRETTY_PRINT);

        // Write to JSON file 'positions.json'
        // file_put_contents will create the file if it doesn't exist
        file_put_contents("positions.json", $json);
    }
}