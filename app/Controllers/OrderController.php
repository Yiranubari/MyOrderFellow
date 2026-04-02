<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Tracking;
use App\Models\User;

class OrderController
{
    public function create()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userModel = new User();
        $approvedCompanies = $userModel->getApprovedCompanies();

        $error = $_SESSION['order_error'] ?? null;
        $success = $_SESSION['order_success'] ?? null;
        unset($_SESSION['order_error'], $_SESSION['order_success']);

        require __DIR__ . '/../../views/orders/create.php';
    }

    public function store()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /orders/create');
            exit();
        }

        $companyId = (int) ($_POST['company_id'] ?? 0);
        $customerName = trim($_POST['customer_name'] ?? '');
        $customerEmail = trim($_POST['customer_email'] ?? '');
        $customerPhone = trim($_POST['customer_phone'] ?? '');
        $itemDescription = trim($_POST['item_description'] ?? '');
        $quantityRaw = $_POST['quantity'] ?? null;
        $quantity = filter_var($quantityRaw, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $pickupAddress = trim($_POST['pickup_address'] ?? '');
        $deliveryAddress = trim($_POST['delivery_address'] ?? '');

        if (
            $companyId < 1 ||
            $customerName === '' ||
            $customerEmail === '' ||
            $customerPhone === '' ||
            $itemDescription === '' ||
            $quantity === false ||
            $pickupAddress === '' ||
            $deliveryAddress === ''
        ) {
            $_SESSION['order_error'] = 'Please complete all required fields.';
            header('Location: /orders/create');
            exit();
        }

        if (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['order_error'] = 'Please provide a valid email address.';
            header('Location: /orders/create');
            exit();
        }

        $userModel = new User();
        $company = $userModel->findApprovedById($companyId);

        if (!$company) {
            $_SESSION['order_error'] = 'Selected logistics company is not available.';
            header('Location: /orders/create');
            exit();
        }

        $externalOrderId = 'MKT-' . strtoupper(bin2hex(random_bytes(5)));

        $orderData = [
            'company_id' => $companyId,
            'external_order_id' => $externalOrderId,
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'customer_phone' => $customerPhone,
            'item_description' => $itemDescription,
            'quantity' => (int) $quantity,
            'pickup_address' => $pickupAddress,
            'delivery_address' => $deliveryAddress,
            'status' => 'pending',
        ];

        $orderModel = new Order();
        $orderId = $orderModel->createMarketplaceOrder($orderData);

        if (!$orderId) {
            $_SESSION['order_error'] = 'Unable to place order. Please try again.';
            header('Location: /orders/create');
            exit();
        }

        $trackingModel = new Tracking();
        $trackingModel->addHistory($orderId, 'Order Created', 'Order submitted from public marketplace page.');

        $_SESSION['order_success'] = 'Order submitted successfully. Tracking ID: ' . $externalOrderId;
        header('Location: /orders/create');
        exit();
    }
}
