<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Services\OrderService;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$internalId = 12;
$externalId = 'ORD-GRAND-TEST';
$customerEmail = 'yiranubari4@gmail.com';


echo "Attempting to update Order #$internalId to 'shipped'...\n";

$service = new OrderService();
$result = $service->updateOrderStatus(
    $internalId,
    'shipped',
    'Package has been handed to the courier.',
    $externalId,
    $customerEmail
);

if ($result) {
    echo "Success! Status updated, History logged, Email sent.\n";
} else {
    echo "Failed.\n";
}
