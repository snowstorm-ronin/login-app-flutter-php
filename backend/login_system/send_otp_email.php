<?php
// send_otp_email.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendOtpEmail($recipientEmail, $otp) {
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration for Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'saumil.kalavikatte2211@gmail.com';
        $mail->Password   = 'fxtpdahqmyksrlci';   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('saumil.kalavikatte2211@gmail.com', 'Login App');
        $mail->addAddress($recipientEmail);

        // Content
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