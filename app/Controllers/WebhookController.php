<?php

namespace App\Controllers;


use App\Models\Order;
use App\Models\User;

class WebhookController
{
    public function handleOrder()
    {
        $apiKey = $_SERVER['HTTP_X_API_KEY'] ?? '';
        $userModel = new User();
        $company = $userModel->findByApiKey($apiKey);
        if (!$company) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON payload']);
            return;
        }
        $orderModel = new Order();
        $orderData = json_encode([
            'company_id' => $company['id'],
            'external_order_id' => $data['external_order_id'] ?? '',
            'customer_email' => $data['customer_email'] ?? '',
            'delivery_address' => $data['delivery_address'] ?? '',
            'items' => $data['items'] ?? [],
        ]);
        $orderId = $orderModel->create($orderData);
        http_response_code(201);
        echo json_encode(['message' => 'Order created', 'order_id' => $orderId]);
    }
}
