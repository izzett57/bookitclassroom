<?php

if (!isset($_POST["Email"])) {
    // Handle the error, e.g., redirect back to the form or display an error message.
    header("Location: forgot-password.php?error=Email is required.");
    exit();
}

$email = filter_var($_POST["Email"], FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // The email is not valid.
    header("Location: forgot-password.php?error=Invalid email format.");
    exit();
}

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require __DIR__ . "/db_conn.php";

$sql = "UPDATE user
        SET Reset_Token = ?,
            Token_Expire = ?
        WHERE Email = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($mysqli->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("noreply@bookitclassroom.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    Click <a href="http://localhost:5500/guest/reset-password.php?token=$token">here</a> 
    to reset your password.

    END;

    try {

        $mail->send();

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";

    }

}

echo "Message sent, please check your inbox.";
?>