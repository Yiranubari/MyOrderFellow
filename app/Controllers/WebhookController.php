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
    }
}
