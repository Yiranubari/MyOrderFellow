<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Tracking;
use App\Services\OrderService;


class AdminController
{

    public function register()
    {
        session_start();
        $systemSecret = "MOF-MASTER-KEY";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $secret = $_POST['admin_secret'] ?? '';

            if ($secret !== $systemSecret) {
                $error = "Access Denied: Incorrect System Secret.";
                require __DIR__ . '/../../views/admin/register.php';
                return;
            }
            $adminModel = new Admin();
            if ($adminModel->create($name, $email, $hashedPassword)) {
                header('Location: /admin/login');
                exit();
            } else {
                $error = "Error: Email already exists or registration failed.";
            }
        }

        require __DIR__ . '/../../views/admin/register.php';
    }
    public function login()
    {
        session_start();
        if (isset($_SESSION['admin_id'])) {
            header('Location: /admin/dashboard');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $adminModel = new Admin();
            $admin = $adminModel->login($email, $password);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                header('Location: /admin/dashboard');
                exit();
            } else {
                $error = "Invalid admin credentials";
            }
        }
        require __DIR__ . '/../../views/admin/login.php';
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        session_destroy();
        header('Location: /admin/login');
        exit();
    }

    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit();
        }
        $adminModel = new Admin();
        $pendingCompanies = $adminModel->getPendingApplications();
        require __DIR__ . '/../../views/admin/dashboard.php';
    }

    public function approve()
    {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $companyId = $_POST['company_id'] ?? null;
            if ($companyId) {
                $adminModel = new Admin();
                $adminModel->updateKycStatus($companyId, 'approved');
                $mailService = new \App\Services\MailService();
                $email = $adminModel->findEmailByCompanyId($companyId);
                $mailService->sendKycApproval($email);
            }
        }
        header('Location: /admin/dashboard');
        exit();
    }

    public function reject()
    {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $companyId = $_POST['company_id'] ?? null;
            if ($companyId) {
                $adminModel = new Admin();
                $adminModel->updateKycStatus($companyId, 'rejected');
            }
        }
        header('Location: /admin/dashboard');
        exit();
    }
    public function index()
    {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit();
        }
        $orderModel = new Order();
        $orders = $orderModel->getAllOrders();
        require __DIR__ . '/../../views/admin/orders.php';
    }
    public function details()
    {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit();
        }

        $orderId = $_GET['id'] ?? null;
        if (!$orderId) {
            header('Location: /admin/orders');
            exit();
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newStatus = $_POST['status'];
            $note = $_POST['note'] ?? 'Status updated by Admin';

            $orderModel = new Order();
            $order = $orderModel->getOrderById($orderId);

            $orderService = new OrderService();
            $orderService->updateOrderStatus(
                $orderId,
                $newStatus,
                $note,
                $order['external_order_id'],
                $order['customer_email']
            );

            header("Location: /admin/order/details?id=$orderId");
            exit();
        }

        $orderModel = new Order();
        $order = $orderModel->getOrderById($orderId);

        $trackingModel = new Tracking();
        $history = $trackingModel->getHistoryByOrderId($orderId);

        require __DIR__ . '/../../views/admin/order_details.php';
    }
}
