<?php
// Start a new session if a session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class SubmitTechniqueClass {
    private $pdoConnection;

    public function __construct($pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

}
?>