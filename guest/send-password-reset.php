<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_POST["Email"])) {
    header("Location: forgot-password.php?error=Email is required.");
    exit();
}

$email = filter_var($_POST["Email"], FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: forgot-password.php?error=Invalid email format.");
    exit();
}

$mysqli = require __DIR__ . "/db_conn.php";
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if email exists
$check_sql = "SELECT id FROM user WHERE Email = ?";
$check_stmt = $mysqli->prepare($check_sql);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows === 0) {
    // Email doesn't exist, but don't reveal this information
    $_SESSION['password_reset_complete'] = true;
    header("Location: forgot-password-complete.php");
    exit();
}

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$sql = "UPDATE user SET Reset_Token = ?, Token_Expire = ? WHERE Email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($mysqli->affected_rows) {
    // Verify the token was stored correctly
    $verify_sql = "SELECT Reset_Token FROM user WHERE Email = ?";
    $verify_stmt = $mysqli->prepare($verify_sql);
    $verify_stmt->bind_param("s", $email);
    $verify_stmt->execute();
    $verify_result = $verify_stmt->get_result();
    $verify_row = $verify_result->fetch_assoc();
    
    if ($verify_row['Reset_Token'] === $token_hash) {
        echo "Token successfully stored in database.<br>";
    } else {
        echo "Error: Token not stored correctly in database.<br>";
    }

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("noreply@bookitclassroom.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset - BookItClassroom";
    $mail->Body = <<<END
    Click <a href="http://localhost:5500/guest/reset-password.php?token=$token">here</a> 
    to reset your password. This link will expire in 30 minutes.
    END;

    try {
        $mail->send();
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer error: {$mail->ErrorInfo}");
        // Don't reveal the error to the user
    }
}

$_SESSION['password_reset_complete'] = true;
header("Location: forgot-password-complete.php");
exit();
?>