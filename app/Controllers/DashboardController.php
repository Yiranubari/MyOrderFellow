<?php

namespace App\Controllers;

use App\Models\User;


class DashboardController
{
    public function index()
    {
        $userModel = new User();
        session_start();
        if (!isset($_SESSION['company_id'])) {
            header('Location: /login');
            exit();
        }
        $apiKey = $userModel->getApiKey($_SESSION['company_id']);
        require_once __DIR__ . '/../../views/dashboard/index.php';
    }

    public function generateKey()
    {
        $userModel = new User();
        session_start();
        if (!isset($_SESSION['company_id'])) {
            header('Location: /login');
            exit();
        }
    }
}
