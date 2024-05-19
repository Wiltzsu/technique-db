<?php
// Start session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class CreateCategory {
    private $pdoConnection;
    private $categoryName;
    private $categoryDescription;

    // Constructor for the CreateCategory class
    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
        error_reporting(E_ALL); // Report all PHP errors
        ini_set('display,errors', 1); // Display errors to the browser
    }

    // Main function to add a new category the the database
    public function addCategory($categoryName, $categoryDescription)
    {
        // 'this' refers to the current instance of the class
        // Set the variables to the addCategory method
        $this->categoryName = trim($categoryName);
        $this->categoryDescription = trim($categoryDescription);

        // Validate input and execute the insertion
        $this->validateInput();
        $this->createCategory();
    }

    public function validateInput()
    {
        if (empty($this->categoryName)) {
            throw new Exception("Please enter a name for the category");
        }
    }

    // Insert logic to add a new category
    public function createCategory() 
    {
        $insert_query = "INSERT INTO Category (categoryName, categoryDescription) VALUES (:categoryName, :categoryDescription)";

        // Prepares the SQL query for execution using the PDO 'prepare' method.
        // The 'prepare' method is called on the 'pdoConnection' object, which is a property of the class
        // 'this' refers to the current instance of the class, and is used to access instance properties or methods
        $statement = $this->pdoConnection->prepare($insert_query);

        // Bind user input variables to the prepared statements as parameters to ensure safe insertion to the database
        // 'bindParam' is a method of a PDO statement object that binds a PHP variable to a placeholder in the SQL statement that was prepared
        // ':categoryName' is a named placeholder
        // '$this->categoryName' refers to a property named 'categoryName' of the boject from which this method is being called. Holds the value that will replace the :categoryName placeholder
        // 'PDO::PARAM_STR' indicates the data type of the parameter being bound
        $statement->bindParam(":categoryName", $this->categoryName, PDO::PARAM_STR);
        $statement->bindParam(":categoryDescription", $this->categoryDescription, PDO::PARAM_STR);

        // Execute the statement
        $statement->execute();
    }
}
?>