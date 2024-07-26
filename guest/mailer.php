<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);

//debug feature below
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = ""; // SMTP server
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = ""; // SMTP username
$mail->Password = ""; // SMTP password

$mail->isHtml(true);

return $mail;
?>