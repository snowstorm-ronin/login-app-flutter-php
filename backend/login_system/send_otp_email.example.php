<?php
// send_otp_email.example.php
// RENAME THIS FILE TO send_otp_email.php AND ADD YOUR CREDENTIALS

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendOtpEmail($recipientEmail, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'YOUR_GMAIL@gmail.com';        // ← ADD YOUR GMAIL
        $mail->Password   = 'YOUR_16_CHAR_APP_PASSWORD';   // ← ADD YOUR APP PASSWORD
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom('YOUR_GMAIL@gmail.com', 'Login App');
        $mail->addAddress($recipientEmail);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for registration';
        $mail->Body    = "Your OTP is: <b>$otp</b>. It is valid for 10 minutes.";
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>