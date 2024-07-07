<?php
session_start();
include "db_conn.php";

if (isset($_POST['Email'])) {
    $email = htmlspecialchars(trim($_POST['Email']));
    
    if (!empty($email)) {
        $sql = "SELECT * FROM user WHERE Email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $token = bin2hex(random_bytes(50)); // Generate a random token
            $sql = "UPDATE user SET reset_token='$token', token_expire=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE Email='$email'";
            mysqli_query($conn, $sql);

            // Send email (this is a simplified example)
            $resetLink = "http://yourdomain.com/reset-password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Click the link to reset your password: $resetLink";
            mail($email, $subject, $message, "From: no-reply@yourdomain.com");

            header("Location: forgot-password-complete.php");
            exit();
        } else {
            header("Location: forgot-password.php?error=Email not found");
            exit();
        }
    } else {
        header("Location: forgot-password.php?error=Email is required");
        exit();
    }
} else {
    header("Location: forgot-password.php");
    exit();
}
?>
