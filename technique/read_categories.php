<?php
require "../db.php";

// Create a class for displaying categories
class ReadCategories {
    private $pdoConnection;

    // The constructor initializes the newly created object
    // The class depends on an existing database connection (pdoConnection)
    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection; // The PDO connection object is assigned to the class's $pdoConnection property
    }

    public function readCategories()
    {
        $this->categoriesToJSON();
    }

    private function categoriesToJSON()
    {
        // SQL query to fetch the categories from the database
        $query = "SELECT * FROM Category ORDER BY categoryID DESC;";

        // Execute the SQL query using the query method of the PDO object stored in '$this->pdoConnection'
        $data = $this->pdoConnection->query($query);

        // Fetches all the rows from the query, each row will be an associative array
        $categories = $data->fetchAll(\PDO::FETCH_ASSOC); // Backlash before global class

        // Prepare array for JSON encoding
        $jsonData = ['categories' => $categories];

        // Convert the PHP array into a JSON formatted string
        $json = json_encode($jsonData, JSON_PRETTY_PRINT);

        // Write to JSON file 'categories.json'
        file_put_contents("categories.json", $json);
    }
}
?>