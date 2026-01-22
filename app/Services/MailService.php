<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class MailService
{
    private $mail;

    public function __construct()
    {
        // Initialize the PHPMailer object
        $this->mail = new PHPMailer(true);

        // Server Settings
        $this->mail->isSMTP();
        $this->mail->Host       = $_ENV['SMTP_HOST'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['SMTP_USERNAME']; // Matches your .env
        $this->mail->Password   = $_ENV['SMTP_PASSWORD']; // Matches your .env
        $this->mail->Port       = $_ENV['SMTP_PORT'];
    }

    public function sendOTP($recipientEmail, $otp)
    {
        try {

            $this->mail->setFrom('no-reply@myorderfellow.com', 'My Order Fellow');
            $this->mail->addAddress($recipientEmail);

            // Content
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Your Verification Code';
            $this->mail->Body    = "<h1>Your OTP Code</h1><p>Your verification code is: <b style='font-size: 20px;'>$otp</b></p>";
            $this->mail->AltBody = "Your verification code is: $otp";

            $this->mail->send();
            return true;
        } catch (Exception $e) {

            return false;
        }
    }
}
