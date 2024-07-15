<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$user_id = $_SESSION['ID'];

// Ensure upload directory exists
$uploadDir = '../assets/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$query = "SELECT * FROM user WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if the user has a profile picture
$profilePicture = '../assets/uploads/default-profile.png'; // Default image path
if (!empty($user['ProfilePicture'])) {
    $uploadedImage = '../assets/uploads/' . $user['ProfilePicture'];
    if (file_exists($uploadedImage)) {
        $profilePicture = $uploadedImage . '?t=' . time();
    } else {
        error_log("Profile picture file not found: " . $uploadedImage);
    }
} else {
    error_log("No profile picture set for user ID: " . $user_id);
}
$stmt->close();
$conn->close();
?>