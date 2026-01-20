<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    protected $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
}
