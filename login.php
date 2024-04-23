<?php
// Start the user session
session_start();

// Create database connection
require "db.php";

// Display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

