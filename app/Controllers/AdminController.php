<?php

namespace App\Controllers;

use App\Models\Admin;

class AdminController
{
    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit();
        }
        $adminModel = new Admin();
        $pendingCompanies = $adminModel->getPendingApplications();
        require '../views/admin/dashboard.php';
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
