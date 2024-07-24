<?php

// Function to get the current script name (e.g., 'index.php')
function getCurrentScript() {
    return basename($_SERVER['SCRIPT_NAME']);
}

// Function to get the current directory (e.g., 'member', 'user', 'admin')
function getCurrentDirectory() {
    $path = dirname($_SERVER['PHP_SELF']);
    return basename($path);
}

// Check if user is logged in
if (!isset($_SESSION['ID']) || !isset($_SESSION['User_Type'])) {
    // If not logged in, redirect to login page
    header("Location: ../guest/login.php");
    exit();
}

$userType = $_SESSION['User_Type'];
$currentScript = getCurrentScript();
$currentDirectory = getCurrentDirectory();

// Determine the correct directory based on user type
$correctDirectory = '';
switch ($userType) {
    case 'MEMBER':
        $correctDirectory = 'member';
        break;
    case 'LECTURER':
    case 'CLUB_LEAD':
        $correctDirectory = 'user';
        break;
    case 'ADMIN':
        $correctDirectory = 'admin';
        break;
    default:
        // Handle unexpected user type
        error_log("Unexpected user type: $userType");
        header("Location: ../guest/login.php");
        exit();
}

// Redirect only if the user is not in the correct directory
if ($currentDirectory !== $correctDirectory) {
    $redirectPath = "../$correctDirectory/index.php";
    header("Location: $redirectPath");
    exit();
}

// If we're here, the user is in the correct directory for their user type
// No redirect is needed, and the script will continue to execute the rest of the page
?>