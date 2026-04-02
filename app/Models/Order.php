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
        $sql = "INSERT INTO orders (
                    company_id,
                    external_order_id,
                    customer_email,
                    delivery_address,
                    items,
                    item_description,
                    quantity,
                    status
                ) VALUES (
                    :company_id,
                    :external_order_id,
                    :customer_email,
                    :delivery_address,
                    :items,
                    :item_description,
                    :quantity,
                    :status
                )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':company_id' => $data['company_id'],
            ':external_order_id' => $data['external_order_id'],
            ':customer_email' => $data['customer_email'],
            ':delivery_address' => $data['delivery_address'],
            ':items' => $jsonItems,
            ':item_description' => $data['item_description'] ?? null,
            ':quantity' => $data['quantity'] ?? null,
            ':status' => $data['status'] ?? 'pending',
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
        $sql = "UPDATE orders SET status = :status WHERE id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'status' => $newStatus,
            'order_id' => $orderId,
        ]);
    }

    public function getAllOrders()
    {
        $sql = "SELECT * FROM orders ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id)
    {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderByExternalId($externalId)
    {
        $sql = "SELECT * FROM orders WHERE external_order_id = :external_order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':external_order_id' => $externalId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createMarketplaceOrder($data)
    {
        $quantity = isset($data['quantity']) ? (int) $data['quantity'] : 1;
        if ($quantity < 1) {
            $quantity = 1;
        }

        $items = [
            [
                'name' => $data['item_description'],
                'qty' => $quantity,
            ],
        ];

        $sql = "INSERT INTO orders (
                    company_id,
                    external_order_id,
                    customer_name,
                    customer_email,
                    customer_phone,
                    item_description,
                    pickup_address,
                    delivery_address,
                    items,
                    quantity,
                    status
                ) VALUES (
                    :company_id,
                    :external_order_id,
                    :customer_name,
                    :customer_email,
                    :customer_phone,
                    :item_description,
                    :pickup_address,
                    :delivery_address,
                    :items,
                    :quantity,
                    :status
                )";

        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([
            ':company_id' => $data['company_id'],
            ':external_order_id' => $data['external_order_id'],
            ':customer_name' => $data['customer_name'],
            ':customer_email' => $data['customer_email'],
            ':customer_phone' => $data['customer_phone'],
            ':item_description' => $data['item_description'],
            ':pickup_address' => $data['pickup_address'],
            ':delivery_address' => $data['delivery_address'],
            ':items' => json_encode($items),
            ':quantity' => $quantity,
            ':status' => $data['status'] ?? 'pending',
        ]);

        if (!$ok) {
            return false;
        }

        return $this->conn->lastInsertId();
    }
}
