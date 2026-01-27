<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Order
{

    protected $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function create($data)
    {
        $jsonItems = json_encode($data['items']);
        $sql = "INSERT INTO orders (company_id, external_order_id, customer_email, delivery_address, items) VALUES (:company_id, :external_order_id, :customer_email, :delivery_address, :items)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':company_id' => $data['company_id'],
            ':external_order_id' => $data['external_order_id'],
            ':customer_email' => $data['customer_email'],
            ':delivery_address' => $data['delivery_address'],
            ':items' => $jsonItems,
        ]);
        return $this->conn->lastInsertId();
    }

    public function getByCompany($companyId)
    {
        $sql = "SELECT * FROM orders WHERE company_id = :company_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':company_id' => $companyId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($orderId, $newStatus)
    {
        $sql = "UPDATE orders SET status = :status, updated_at = NOW() WHERE id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':status' => $newStatus,
            ':order_id' => $orderId,
        ]);
    }
}
