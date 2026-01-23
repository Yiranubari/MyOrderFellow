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
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = $_ENV['SMTP_HOST'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['SMTP_USERNAME'];
        $this->mail->Password = $_ENV['SMTP_PASSWORD'];
        $this->mail->Port = $_ENV['SMTP_PORT'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->CharSet = 'UTF-8';
    }

    public function sendOTP($recipientEmail, $otp)
    {
        $this->mail->setFrom($_ENV['SMTP_FROM_EMAIL'], 'My Order Fellow');
        $this->mail->addAddress($recipientEmail);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Your OTP Code';
        $this->mail->Body = "<h1>Your OTP Code</h1><p>Your OTP code is: <strong>$otp</strong></p>";
        $this->mail->send();
        return true;
    }
}
