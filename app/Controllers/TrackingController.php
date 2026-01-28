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

        require __DIR__ . '/../../views/tracking/search.php';
    }

    public function track()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trackingId = trim($_POST['tracking_id'] ?? '');
            if (empty($trackingId)) {
                $error = "Please enter a tracking ID.";
                require __DIR__ . '/../../views/tracking/search.php';
                return;
            }
            $orderModel = new Order();
            $order = $orderModel->getOrderByTrackingId($trackingId);

            $trackingId = $order['id'];
            $trackingModel = new Tracking();
            $history = $trackingModel->getHistoryByOrderId($trackingId);
            require __DIR__ . '/../../views/tracking/history.php';
        }
        if (!$order) {
            $error = "Tracking ID not found.";
            require __DIR__ . '/../../views/tracking/search.php';
            return;
        }
    }
}
