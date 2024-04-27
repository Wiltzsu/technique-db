<?php
class CreateTechnique {
    private $pdoConnection;
    private $techniqueName;
    private $techniqueDescription;
    private $techniqueCategory;
    private $techniquePosition;
    private $techniqueDifficulty;

    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
        session_start(); // Begin a new session or resume an existing one
        error_reporting(E_ALL); // Report all PHP errors
        ini_set('display_errors', 1); // Display errors to the browser
    }

    // Add technique is the main function that adds the technique to the database
    public function addTechnique($formTechniqueName, $formTechniqueDescription, $formTechniqueCategory, $formTechniquePosition, $formTechniqueDifficulty)
    {
        // 'this' represents the current instance of the class in which it is used
        // Sets the variables to the required method parameters
        $this->techniqueName = trim($formTechniqueName);
        $this->techniqueDescription = trim($formTechniqueDescription);
        $this->techniqueCategory = trim($formTechniqueCategory);
        $this->techniquePosition = trim($formTechniquePosition);
        $this->techniqueDifficulty = trim($formTechniqueDifficulty);

        $this->validateInput();

    }

    private function validateInput()
    {
        if (empty($this->techniqueName)) {
            throw new Exception('Please enter technique name.');
        }
        if (empty($this->techniqueCategory)) {
            throw new Exception('Please choose category.');
        }
        if (empty($this->techniquePosition)) {
            throw new Exception('Please choose position.');
        }  
        if (empty($this->techniqueDifficulty)) {
            throw new Exception('Please choose difficulty.');
        }
    }
}
?>