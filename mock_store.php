<?php


$webhookUrl = 'https://my-order-fellow.vercel.app/webhook';


$apiKey = 'd13467c0982ea1a3394c1d24892d9ddc3825e168da4bae8b';

$externalId = 'ORD-' . rand(1000, 9999) . '-TEST';
$customerEmail = 'customer' . rand(1, 100) . '@example.com';

$payload = [
    'external_order_id' => $externalId,
    'customer_email' => $customerEmail,
    'delivery_address' => '123 Fake Street, Lagos, Nigeria',
    'items' => [
        ['name' => 'Wireless Mouse', 'qty' => 1],
        ['name' => 'Mechanical Keyboard', 'qty' => 1]
    ]
];

$jsonData = json_encode($payload);


$ch = curl_init($webhookUrl);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-API-KEY: ' . $apiKey
]);

echo "Sending Order: $externalId ...\n";
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if (PHP_VERSION_ID < 80000) {
    curl_close($ch);
}

echo "HTTP Status: $httpCode\n";
echo "Response: $response\n";

if ($httpCode === 201) {
    echo "SUCCESS! Order created.\n";
} elseif ($httpCode === 429) {
    echo "BLOCKED: Rate Limit Exceeded.\n";
} else {
    echo "FAILED: Something went wrong.\n";
}
