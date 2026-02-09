<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = getenv('SMTP_HOST') ?: 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = getenv('SMTP_USERNAME') ?: '9e5cbdbb3c2938';
    $mail->Password = getenv('SMTP_PASSWORD') ?: 'c6489a0354647a';
    $mail->Port = getenv('SMTP_PORT') ?: 2525;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom('noreply@orderfellow.com', 'Mailtrap Test');
    $mail->addAddress('yiranubari4@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = 'Mailtrap SMTP Test';
    $mail->Body = '<h1>This is a test email from Mailtrap SMTP!</h1>';

    if ($mail->send()) {
        echo "Test email sent successfully!";
    } else {
        echo "Failed to send test email.";
    }
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
