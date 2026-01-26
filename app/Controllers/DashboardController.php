<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Order;


class DashboardController
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['company_id'])) {
            header('Location: /login');
            exit();
        }
        $userModel = new User();
        $orderModel = new Order();
        $kycStatus = $userModel->getKycStatus($_SESSION['company_id']);


        if ($kycStatus === 'approved') {
            $apiKey = $userModel->getApiKey($_SESSION['company_id']);
            $orders = $orderModel->getByCompany($_SESSION['company_id']);
        }
        require_once __DIR__ . '/../../views/dashboard/index.php';
    }

    public function generateKey()
    {
        session_start();

        if (!isset($_SESSION['company_id'])) {
            header('Location: /login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();

            $userModel->rotateApiKey($_SESSION['company_id']);

            header('Location: /dashboard');
            exit();
        }
    }

    public function submitKyc() {}
}
