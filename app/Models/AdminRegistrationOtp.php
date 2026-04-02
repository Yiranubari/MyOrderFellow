<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class AdminRegistrationOtp
{
    protected $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function createOrReplace($name, $email, $passwordHash, $otpCode, $expiryMinutes = 10)
    {
        $deleteSql = "DELETE FROM admin_registration_otps WHERE email = :email AND is_used = FALSE";
        $deleteStmt = $this->conn->prepare($deleteSql);
        $deleteStmt->execute([':email' => $email]);

        $insertSql = "INSERT INTO admin_registration_otps (name, email, password_hash, otp_code, expires_at)
                      VALUES (:name, :email, :password_hash, :otp_code, (NOW() + (:expiry_minutes || ' minutes')::interval))";
        $insertStmt = $this->conn->prepare($insertSql);

        return $insertStmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password_hash' => $passwordHash,
            ':otp_code' => $otpCode,
            ':expiry_minutes' => (int) $expiryMinutes,
        ]);
    }

    public function consumeOtp($email, $otpCode)
    {
        $sql = "SELECT * FROM admin_registration_otps
                WHERE email = :email
                  AND otp_code = :otp_code
                  AND is_used = FALSE
                  AND expires_at > NOW()
                ORDER BY id DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':otp_code' => $otpCode,
        ]);

        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$record) {
            return false;
        }

        $updateSql = "UPDATE admin_registration_otps SET is_used = TRUE WHERE id = :id";
        $updateStmt = $this->conn->prepare($updateSql);
        $updateStmt->execute([':id' => $record['id']]);

        return $record;
    }
}
