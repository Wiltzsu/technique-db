<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class CreatePosition {
    private $pdoConnection;
    private $positionName;
    private $positionDescription;

    // Constructor for the CreatePosition class
    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
        error_reporting(E_ALL); // Report all PHP errors
        ini_set('display,errors', 1); // Display errors to the browser
    }

    // The main function to add a new position to the database
    public function addPosition($positionName, $positionDescription)
    {
        // 'this' represents the current instance of the class in which it is used
        // Sets the variables to the required method 'addPosition()' parameters
        $this->positionName = trim($positionName);
        $this->positionDescription = trim($positionDescription);

        // Validates the input and executes the insertion
        $this->validateInput();
        $this->createPosition();
    }

    // Validates the input and checks if 'positionName' field is empty
    public function validateInput() 
    {
        if (empty($this->positionName)) {
            throw new Exception("Please enter a name for the position.");
        }
    }

    // Insertion logic to add a new position
    public function createPosition() 
    {
        $insert_query = "INSERT INTO Position (positionName, positionDescription) VALUES(:positionName, :positionDescription)"; // ':' are placeholders before the actual values are bound

        // Prepares the SQL query for execution using the PDO 'prepare' method.
        // The 'prepare' method is called on the 'pdoConnection' object, which is a property of the class
        // 'this' refers to the current instance of the class, and is used to access instance properties or methods
        $statement = $this->pdoConnection->prepare($insert_query); 

        // Bind user input variables to the prepared statements as parameters to ensure safe insertion to the database
        $statement->bindParam(":positionName", $this->positionName, PDO::PARAM_STR);
        $statement->bindParam(":positionDescription", $this->positionDescription, PDO::PARAM_STR);

        $statement->execute();
    }
}

?>