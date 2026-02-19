<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;


class MailService
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = getenv('SMTP_HOST') ?: $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = getenv('SMTP_USERNAME') ?: $_ENV['SMTP_USERNAME'] ?? '';
        $this->mail->Password = getenv('SMTP_PASSWORD') ?: $_ENV['SMTP_PASSWORD'] ?? '';
        $this->mail->Port = getenv('SMTP_PORT') ?: $_ENV['SMTP_PORT'] ?? 456;
        $this->mail->SMTPSecure = getenv('SMTP_ENCRYPTION') ?: $_ENV['SMTP_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->CharSet = 'UTF-8';
    }

    public function sendOTP($recipientEmail, $otp)
    {
        $fromEmail = getenv('SMTP_FROM_ADDRESS') ?: $_ENV['SMTP_FROM_ADDRESS'] ?? 'yiranubari4@gmail.com';
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
        $fromEmail = getenv('SMTP_FROM_ADDRESS') ?: $_ENV['SMTP_FROM_ADDRESS'] ?? 'yiranubari4@gmail.com';
        $this->mail->setFrom($fromEmail, 'My Order Fellow');
        $this->mail->addAddress($recipientEmail);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Order Confirmation';
        $this->mail->Body = "<h1>Order Confirmation</h1><p>Your order with ID <strong>$orderId</strong> has been confirmed.</p>";
        $this->mail->send();
        return true;
    }

    public function sendStatusUpdate($recipientEmail, $orderId, $newStatus)
    {
        $this->mail->clearAddresses();
        $fromEmail = getenv('SMTP_FROM_ADDRESS') ?: $_ENV['SMTP_FROM_ADDRESS'] ?? 'yiranubari4@gmail.com';
        $this->mail->setFrom($fromEmail, 'My Order Fellow');
        $this->mail->addAddress($recipientEmail);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Order Status Update';
        $this->mail->Body = "<h1>Order Status Update</h1><p>Your order with ID <strong>$orderId</strong> status has been updated to: <strong>$newStatus</strong>.</p>";
        $this->mail->send();
        return true;
    }

    public function sendKycApproval($recipientEmail)
    {
        $this->mail->clearAddresses();
        $fromEmail = getenv('SMTP_FROM_ADDRESS') ?: $_ENV['SMTP_FROM_ADDRESS'] ?? 'yiranubari4@gmail.com';
        $this->mail->setFrom($fromEmail, 'My Order Fellow');
        $this->mail->addAddress($recipientEmail);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'KYC Approval Notification';
        $this->mail->Body = "<h1>KYC Approval Notification</h1><p>Your KYC application has been approved.</p>";
        $this->mail->send();
        return true;
    }
}
