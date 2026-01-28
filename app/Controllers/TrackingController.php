<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Tracking;
use App\Services\OrderService;

class TrackingController
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit();
        }

        $trackingModel = new Tracking();
        $allHistory = $trackingModel->getAllHistory(); // Assuming this method exists

        require __DIR__ . '/../../views/admin/tracking_index.php';
    }
}
