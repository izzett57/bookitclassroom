<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Debugging information:<br>";

// Set PHP timezone to match the database timezone
date_default_timezone_set('Europe/Berlin');

// CSRF check
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token validation failed");
}

$token = $_POST["token"] ?? '';

if (empty($token)) {
    die("No token provided");
}

echo "Received token: " . htmlspecialchars($token) . "<br>";

// Hash the token before comparing with the database
$token_hash = hash("sha256", $token);
echo "Hashed token: " . $token_hash . "<br>";

$mysqli = require __DIR__ . "/db_conn.php";
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Set MySQL session timezone to match PHP
$mysqli->query("SET time_zone = '+02:00'");

// Check if the token exists without considering expiration
$check_token_sql = "SELECT *, NOW() as db_now FROM user WHERE Reset_Token = ?";
$check_token_stmt = $mysqli->prepare($check_token_sql);
$check_token_stmt->bind_param("s", $token_hash);
$check_token_stmt->execute();
$check_token_result = $check_token_stmt->get_result();

if ($check_token_result->num_rows > 0) {
    $user = $check_token_result->fetch_assoc();
    echo "Token found in database. User ID: " . $user['ID'] . "<br>";
    echo "Token expiration: " . $user['Token_Expire'] . "<br>";
    echo "Current time (PHP): " . date('Y-m-d H:i:s') . "<br>";
    echo "Current time (DB): " . $user['db_now'] . "<br>";
    
    if (strtotime($user['Token_Expire']) < strtotime($user['db_now'])) {
        echo "Token has expired.<br>";
    } else {
        echo "Token is still valid.<br>";
        
        // Proceed with password reset
        if (strlen($_POST["password"]) < 12) {
            die("Password must be at least 12 characters");
        }

        if (!preg_match("/[a-z]/", $_POST["password"]) ||
            !preg_match("/[A-Z]/", $_POST["password"]) ||
            !preg_match("/[0-9]/", $_POST["password"])) {
            die("Password must contain at least one lowercase letter, one uppercase letter, and one number");
        }

        if ($_POST["password"] !== $_POST["password_confirmation"]) {
            die("Passwords must match");
        }

        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $sql = "UPDATE user SET Password = ?, Reset_Token = NULL, Token_Expire = NULL WHERE ID = ?";
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            die("SQL error: " . $mysqli->error);
        }

        $stmt->bind_param("si", $password_hash, $user["ID"]);
        $stmt->execute();

        if ($stmt->affected_rows > 0 || $stmt->errno === 0) {
            $_SESSION['password_reset_complete'] = true;
            header("Location: reset-password-complete.php");
            exit();
        } else {
            die("Password update failed. Please try again.");
        }
    }
} else {
    echo "No user found with the given token.<br>";
}

echo "Server timezone: " . date_default_timezone_get() . "<br>";

// Check if any users have a reset token
$check_sql = "SELECT COUNT(*) as count FROM user WHERE Reset_Token IS NOT NULL";
$check_result = $mysqli->query($check_sql);
$check_row = $check_result->fetch_assoc();
echo "Number of users with reset tokens: " . $check_row['count'] . "<br>";

// Display all tokens, including expired ones
$all_tokens_sql = "SELECT ID, Email, Reset_Token, Token_Expire FROM user WHERE Reset_Token IS NOT NULL";
$all_tokens_result = $mysqli->query($all_tokens_sql);
echo "All reset tokens:<br>";
while ($row = $all_tokens_result->fetch_assoc()) {
    echo "User ID: " . $row['ID'] . ", Email: " . $row['Email'] . ", Expires: " . $row['Token_Expire'] . "<br>";
}

die("Invalid or expired token");
?>