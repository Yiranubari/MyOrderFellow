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
    public function addHistory($orderId, $status, $notes)
    {
        $sql = "INSERT INTO tracking_history (order_id, status, notes, created_at) VALUES (:order_id, :status, :notes, NOW())";
        $this->conn->prepare($sql)->execute([
            ':order_id' => $orderId,
            ':status' => $status,
            ':notes' => $notes,
        ]);
        return $this->conn->lastInsertId();
    }
}
