<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Admin
{
    protected $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function login($email, $password)
    {
        $sql = "SELECT * FROM admins WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }

    public function getPendingApplications()
    {
        $sql = "SELECT * FROM companies WHERE kyc_status = 'submitted' ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateKycStatus($companyId, $status)
    {
        $sql = "UPDATE companies SET kyc_status = :status WHERE id = :company_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':status' => $status, ':company_id' => $companyId]);
    }
}
