<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\AdminRegistrationOtp;
use App\Models\Order;
use App\Models\Tracking;
use App\Models\User;
use App\Services\MailService;
use App\Services\OrderService;


class AdminController
{

    public function register()
    {
        session_start();
        $userModel = new User();
        $approvedCompanies = $userModel->getApprovedCompanies();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $companyId = (int) ($_POST['company_id'] ?? 0);

            if (empty($name) || empty($email) || empty($password)) {
                $error = "All fields are required.";
                require __DIR__ . '/../../views/admin/register.php';
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Please enter a valid email address.";
                require __DIR__ . '/../../views/admin/register.php';
                return;
            }

            if ($companyId < 1 || !$userModel->findApprovedById($companyId)) {
                $error = "Please select a valid approved logistics company.";
                require __DIR__ . '/../../views/admin/register.php';
                return;
            }

            $adminModel = new Admin();

            if ($adminModel->findByEmail($email)) {
                $error = "Email already exists.";
                require __DIR__ . '/../../views/admin/register.php';
                return;
            }

            $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $otpModel = new AdminRegistrationOtp();
            $otpSaved = $otpModel->createOrReplace($name, $email, $passwordHash, $otpCode, 10);

            if (!$otpSaved) {
                $error = "Could not start verification. Please try again.";
                require __DIR__ . '/../../views/admin/register.php';
                return;
            }

            try {
                $mailService = new MailService();
                $mailService->sendOTP($email, $otpCode);
            } catch (\Throwable $e) {
                $error = "Unable to send verification code. Please try again.";
                require __DIR__ . '/../../views/admin/register.php';
                return;
            }

            $_SESSION['admin_verify_email'] = $email;
            $_SESSION['admin_verify_company_id'] = $companyId;
            $_SESSION['admin_register_success'] = 'A verification code has been sent to your email.';

            header('Location: /admin/verify');
            exit();
        }

        require __DIR__ . '/../../views/admin/register.php';
    }

    public function verifyRegistrationOtp()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? ($_SESSION['admin_verify_email'] ?? ''));
            $otpCode = trim($_POST['otp_code'] ?? '');
            $companyId = (int) ($_SESSION['admin_verify_company_id'] ?? 0);

            if (empty($email) || empty($otpCode)) {
                $error = "Email and OTP are required.";
                require __DIR__ . '/../../views/admin/verify_otp.php';
                return;
            }

            if (!preg_match('/^\d{6}$/', $otpCode)) {
                $error = "OTP must be a valid 6-digit code.";
                require __DIR__ . '/../../views/admin/verify_otp.php';
                return;
            }

            if ($companyId < 1) {
                $error = "Registration session expired. Please register again.";
                require __DIR__ . '/../../views/admin/verify_otp.php';
                return;
            }

            $otpModel = new AdminRegistrationOtp();
            $pendingRegistration = $otpModel->consumeOtp($email, $otpCode);

            if (!$pendingRegistration) {
                $error = "Invalid or expired OTP code.";
                require __DIR__ . '/../../views/admin/verify_otp.php';
                return;
            }

            $adminModel = new Admin();

            if ($adminModel->findByEmail($email)) {
                $error = "An admin account already exists for this email.";
                require __DIR__ . '/../../views/admin/verify_otp.php';
                return;
            }

            if ($adminModel->createWithHash($pendingRegistration['name'], $email, $pendingRegistration['password_hash'], $companyId)) {
                unset($_SESSION['admin_verify_email']);
                unset($_SESSION['admin_verify_company_id']);
                $_SESSION['admin_register_success'] = 'Admin account verified. Please login.';
                header('Location: /admin/login');
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }

        $email = $_SESSION['admin_verify_email'] ?? ($_GET['email'] ?? '');
        require __DIR__ . '/../../views/admin/verify_otp.php';
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
                $_SESSION['admin_company_id'] = $admin['company_id'] ?? null;
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
        unset($_SESSION['admin_company_id']);
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
        $adminCompanyId = (int) ($_SESSION['admin_company_id'] ?? 0);
        $orders = $adminCompanyId > 0 ? $orderModel->getByCompany($adminCompanyId) : [];
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
