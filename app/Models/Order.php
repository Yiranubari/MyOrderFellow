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
        json_encode($data['items']);
        $sql = "INSERT INTO orders (company_id, external_order_id, customer_email, deliver_address, items) VALUES (:company_id, :external_order_id, :customer_email, :deliver_address, :items)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':company_id' => $data['company_id'],
            ':external_order_id' => $data['external_order_id'],
            ':customer_email' => $data['customer_email'],
            ':deliver_address' => $data['deliver_address'],
            ':items' => json_encode($data['items'])
        ]);
        return $this->conn->lastInsertId();
    }
}
