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
}
