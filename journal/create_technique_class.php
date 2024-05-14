<?php
// Start a new session if a session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class CreateTechniqueClass {
    private $techniqueID;
    private $classID;
    private $pdoConnection;

    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    // 'addTechniqueClass' is the main method that adds the item to the database by calling 'createTechniqueClass' method
    public function addTechniqueClass($techniqueID, $classID) {
        $this->$techniqueID = trim($techniqueID);
        $this->$classID = trim($classID);

        // Checks if inputs are empty
        $this->validateInput();
        // Calls the create method
        $this->createTechniqueClass();
    }

    private function validateInput() {
        
        if (empty($techniqueID)) {
            throw new Exception('Please choose a technique');
        }

        if (empty($classID)) {
            throw new Exception('Please choose a class');
        }
    }

    // Method that creates a log entry in the database in a table 'Techniques_Classes'
    private function createTechniqueClass() {
        $query = "INSERT INTO Techniques_Classes (techniqueID, classID) VALUES (:techniqueID, :classID)";

        // Prepares the SQL query for execution using the PDO 'prepare' method.
        // The 'prepare' method is called on the 'pdoConnection' object, which is a property of the class
        // 'this' refers to the current instance of the class, and is used to access instance properties or methods
        $statement = $this->pdoConnection->prepare($query);

            // Bind user inputs to the statement as parameters to ensure safe insertion to the database
            $statement->bindParam(":techniqueID", $this->techniqueID, PDO::PARAM_INT);
            $statement->bindParam(":classID", $this->classID, PDO::PARAM_INT);

            // Execute the statement and throw an error if unsuccessful
            if (!$statement->execute()) {
                error_log("Failed to execute query" . $statement->errorInfo()[2]);
                throw new Exception("Error creating technique");
            } else {
                error_log("Technique created successfully");
            }
    }
}
?>