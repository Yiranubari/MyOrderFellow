<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Tracking;
use App\Core\RateLimiter; // Ensure this matches your file namespace

class TrackingController
{
    public function index()
    {
        $error = $_GET['error'] ?? null;
        require __DIR__ . '/../../views/tracking/search.php';
    }

    public function track()
    {
        // 1. Open the POST block ONCE
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // --- SECURITY CHECK (First Thing) ---
            $userIP = $_SERVER['REMOTE_ADDR'];
            $limiter = new RateLimiter();

            if (!$limiter->check($userIP, 5, 60)) {
                $error = "Too many attempts. Please wait a minute.";
                require __DIR__ . '/../../views/tracking/search.php';
                return; // Stop here if blocked
            }
            // ------------------------------------

            // --- BUSINESS LOGIC (Only runs if security passes) ---
            $trackingId = trim($_POST['tracking_id'] ?? '');

            if (empty($trackingId)) {
                $error = "Please enter a tracking ID.";
                require __DIR__ . '/../../views/tracking/search.php';
                return;
            }

            $orderModel = new Order();
            $order = $orderModel->getOrderByExternalId($trackingId);

            if (!$order) {
                $error = "Tracking ID not found.";
                require __DIR__ . '/../../views/tracking/search.php';
                return;
            }

            $orderId = $order['id'];
            $trackingModel = new Tracking();
            $history = $trackingModel->getHistoryByOrderId($orderId);

            require __DIR__ . '/../../views/tracking/history.php';
            return; // Stop here so we don't hit the redirect below
        }

        // If it wasn't a POST request at all, send them back
        header('Location: /track');
        exit();
    }
}
