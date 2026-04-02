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

    public function create($name, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->createWithHash($name, $email, $hashedPassword);
    }

    public function createWithHash($name, $email, $passwordHash)
    {
        $checkSql = "SELECT id FROM admins WHERE email = :email LIMIT 1";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->fetch()) {
            return false;
        }

        $sql = "INSERT INTO admins (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $passwordHash
        ]);
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM admins WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        $sql = "UPDATE companies
                SET kyc_status = :status,
                    is_approved = CASE
                        WHEN :status = 'approved' THEN TRUE
                        WHEN :status = 'rejected' THEN FALSE
                        ELSE is_approved
                    END
                WHERE id = :company_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':status' => $status, ':company_id' => $companyId]);
    }

    public function findEmailByCompanyId($companyId)
    {
        $sql = "SELECT email FROM companies WHERE id = :company_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':company_id' => $companyId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['email'] : null;
    }
}
