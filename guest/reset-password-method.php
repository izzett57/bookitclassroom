<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CSRF check
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token validation failed");
}

$token = $_POST["token"] ?? '';

if (empty($token)) {
    die("No token provided");
}

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/db_conn.php";
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT * FROM user WHERE Reset_Token = ? AND Token_Expire > NOW()";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("Invalid or expired token");
}

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

$sql = "UPDATE user SET Password = ?, Reset_Token = NULL, Token_Expire = NULL WHERE id = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("si", $password_hash, $user["id"]);
$stmt->execute();

if ($stmt->affected_rows > 0 || $stmt->errno === 0) {
    $_SESSION['password_reset_complete'] = true;
    header("Location: reset-password-complete.php");
    exit();
} else {
    die("Password update failed. Please try again.");
}
?>