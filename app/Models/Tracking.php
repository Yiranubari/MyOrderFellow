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
    public function getHistoryByOrderId($orderId)
    {
        $sql = "SELECT * FROM tracking_history WHERE order_id = :order_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderByTrackingId($trackingId)
    {
        $sql = "SELECT * FROM orders WHERE id = :tracking_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tracking_id' => $trackingId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
