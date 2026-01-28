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
        $error = $_GET['error'] ?? null;

        require __DIR__ . '/../../views/admin/tracking_index.php';
    }
}
