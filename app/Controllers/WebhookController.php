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
        $companyId = $userModel->findByApiKey($apiKey);
        if (!$companyId) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
    }
}
