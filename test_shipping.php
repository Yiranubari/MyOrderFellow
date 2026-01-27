<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Services\OrderService;

// 1. Load Environment Variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 2. Configuration (Use an Order ID that actually exists in your DB!)
$internalId = 12; // Change this to the ID of the order you just made (check pgAdmin)
$externalId = 'ORD-GRAND-TEST'; // Change this to match that order
$customerEmail = 'yiranubari4@gmail.com'; // Change this so YOU get the email

// 3. Run the Service
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
    echo "✅ Success! Status updated, History logged, Email sent.\n";
} else {
    echo "❌ Failed.\n";
}
