<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class AdminController
{
    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit();
        }
    }
}
