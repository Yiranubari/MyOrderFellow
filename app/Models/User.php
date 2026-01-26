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

    public function create($data)
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO companies (name, email, password, otp_code) VALUES (:name, :email, :password, :otp_code)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $hashedPassword,
            ':otp_code' => $data['otp_code']
        ]);
        return $this->conn->lastInsertId();
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM companies WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyUser($email)
    {

        $sql = "UPDATE companies SET is_verified = TRUE, otp_code = NULL WHERE email = :email";


        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([':email' => $email]);
    }

    public function rotateApiKey($companyId)
    {
        $newApiKey = bin2hex(random_bytes(24));
        $sql = "UPDATE companies SET api_secret = :api_secret WHERE id = :company_id";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute([':api_secret' => $newApiKey, ':company_id' => $companyId])) {
            return $newApiKey;
        }
        return false;
    }

    public function getApiKey($companyId)
    {
        $sql = "SELECT api_secret FROM companies WHERE id = :company_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':company_id' => $companyId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['api_secret'] : null;
    }

    public function findByApiKey($apiKey)
    {
        $sql = "SELECT * FROM companies WHERE api_secret = :api_secret LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':api_secret' => $apiKey]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function submitKyc($companyId, $data)
    {
        $sql = "UPDATE companies 
                SET business_reg_number = :reg_no, 
                    business_address = :address, 
                    contact_person = :contact, 
                    kyc_status = 'submitted' 
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':reg_no' => $data['reg_no'],
            ':address' => $data['address'],
            ':contact' => $data['contact'],
            ':id' => $companyId
        ]);
    }

    public function getKycStatus($companyId)
    {
        $sql = "SELECT kyc_status FROM companies WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $companyId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['kyc_status'] : 'pending';
    }
}
