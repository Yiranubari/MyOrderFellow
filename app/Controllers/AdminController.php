<?php

namespace App\Controllers;

use App\Models\Admin;

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
            $secret = $_POST['admin_secret'] ?? '';

            if ($secret !== $systemSecret) {
                $error = "⛔ Access Denied: Incorrect System Secret.";
                require __DIR__ . '/../../views/admin/register.php';
                return;
            }
            $adminModel = new Admin();
            if ($adminModel->create($name, $email, $password)) {
                header('Location: /admin/login');
                exit();
            } else {
                $error = "Error: Email already exists or database failed.";
            }
        }

        require __DIR__ . '/../../views/admin/register.php';
    }
    public function login()
    {
        session_start();

        // If already logged in, go to dashboard
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

        // We need a simple login view for admins
        require __DIR__ . '/../../views/admin/login.php';
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
}
