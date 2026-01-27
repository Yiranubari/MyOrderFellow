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
        $this->mail->Host = getenv('SMTP_HOST') ?: $_ENV['SMTP_HOST'] ?? 'sandbox.smtp.mailtrap.io';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = getenv('SMTP_USERNAME') ?: $_ENV['SMTP_USERNAME'] ?? '';
        $this->mail->Password = getenv('SMTP_PASSWORD') ?: $_ENV['SMTP_PASSWORD'] ?? '';
        $this->mail->Port = getenv('SMTP_PORT') ?: $_ENV['SMTP_PORT'] ?? 2525;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->CharSet = 'UTF-8';
    }

    public function sendOTP($recipientEmail, $otp)
    {
        $fromEmail = getenv('SMTP_FROM_EMAIL') ?: $_ENV['SMTP_FROM_EMAIL'] ?? 'noreply@orderfellow.com';
        $this->mail->setFrom($fromEmail, 'My Order Fellow');
        $this->mail->addAddress($recipientEmail);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Your OTP Code';
        $this->mail->Body = "<h1>Your OTP Code</h1><p>Your OTP code is: <strong>$otp</strong></p>";
        $this->mail->send();
        return true;
    }

    public function sendOrderConfirmation($recipientEmail, $orderId)
    {
        $this->mail->clearAddresses();
        $fromEmail = getenv('SMTP_FROM_EMAIL') ?: $_ENV['SMTP_FROM_EMAIL'] ?? 'noreply@orderfellow.com';
        $this->mail->setFrom($fromEmail, 'My Order Fellow');
        $this->mail->addAddress($recipientEmail);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Order Confirmation';
        $this->mail->Body = "<h1>Order Confirmation</h1><p>Your order with ID <strong>$orderId</strong> has been confirmed.</p>";
        $this->mail->send();
        return true;
    }
}
