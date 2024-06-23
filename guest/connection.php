<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "bookitclassroom";

// Create connection
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if (!$con) {
    // Log the error message for debugging
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
    
    // Display a user-friendly message
    die("Sorry, there was a problem connecting to the database.");
}

?>
