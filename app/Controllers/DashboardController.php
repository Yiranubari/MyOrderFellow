<?php

namespace App\Controllers;

class DashboardController
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['company_id'])) {
            header('Location: /login');
            exit();
        }
        require_once __DIR__ . '/../../views/dashboard/index.php';
    }
}
