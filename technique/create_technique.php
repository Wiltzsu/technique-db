<?php
// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}class CreateTechnique {
    private $pdoConnection;
    private $techniqueName;
    private $techniqueDescription;
    private $categoryID;
    private $positionID;
    private $difficultyID;

    // Constructor for the CreateTechnique class
    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
        error_reporting(E_ALL); // Report all PHP errors
        ini_set('display_errors', 1); // Display errors to the browser
    }

    // Add technique is the main function that adds the technique to the database
    public function addTechnique($formTechniqueName, $formTechniqueDescription, $formcategoryID, $formPositionCategory, $formdifficultyID)
    {
        // 'this' represents the current instance of the class in which it is used
        // Sets the variables to the required method parameters
        $this->techniqueName = trim($formTechniqueName);
        $this->techniqueDescription = trim($formTechniqueDescription);
        $this->categoryID = trim($formcategoryID);
        $this->positionID = trim($formPositionCategory);
        $this->difficultyID = trim($formdifficultyID);

        $this->validateInput();
        $this->createTechnique();

    }

    private function validateInput()
    {
        if (empty($this->techniqueName)) {
            throw new Exception('Please enter technique name.');
        }
        if (empty($this->categoryID)) {
            throw new Exception('Please choose category.');
        }
        if (empty($this->positionID)) {
            throw new Exception('Please choose position.');
        }  
        if (empty($this->difficultyID)) {
            throw new Exception('Please choose difficulty.');
        }
    }

    private function createTechnique() 
    {
        $insert_query = "INSERT INTO Technique (techniqueName, techniqueDescription, categoryID, positionID, difficultyID) VALUES(:techniqueName, :techniqueDescription, :categoryID, :positionID, :difficultyID)";

        // Access the private pdoConnection in the class
        $statement = $this->pdoConnection->prepare($insert_query);

            // Bind user input variables to the prepared statement as parameters to ensure safe database insertion
            $statement->bindParam(":techniqueName", $this->techniqueName, PDO::PARAM_STR);
            $statement->bindParam(":techniqueDescription", $this->techniqueDescription, PDO::PARAM_STR);
            $statement->bindParam(":categoryID", $this->categoryID, PDO::PARAM_INT);
            $statement->bindParam(":positionID", $this->positionID, PDO::PARAM_INT);
            $statement->bindParam(":difficultyID", $this->difficultyID, PDO::PARAM_INT);

            // Execute the prepared statement and check the result, throw an exception if it fails
            if (!$statement->execute()) {
                error_log("Failed to execute query: " . $statement->errorInfo()[2]); // Log SQL error
                throw new Exception("Error creating technique");
            } else {
                error_log("Technique created successfully"); // Confirm successful execution
            }
    }
}
?>