<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Tracking
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function addHistory($orderId, $status, $description)
    {
        $sql = "INSERT INTO tracking_history (order_id, status, description, created_at) VALUES (:order_id, :status, :description, NOW())";
        $this->conn->prepare($sql)->execute([
            ':order_id' => $orderId,
            ':status' => $status,
            ':description' => $description,
        ]);
        return $this->conn->lastInsertId();
    }
}
