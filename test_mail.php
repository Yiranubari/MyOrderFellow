<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Services\MailService;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$mailer = new MailService();


try {
    $mailer->sendOTP('yiranubari4@gmail.com', '569309');
    echo "Success! Check your Mailtrap Inbox.";
} catch (Exception $e) {
    echo "Failed to send. Error: " . $e->getMessage();
}
