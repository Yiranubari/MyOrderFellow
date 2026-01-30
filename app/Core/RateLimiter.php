<?php

namespace App\Core;

use PDO;
use DateTime;

class RateLimiter
{
    protected $pdo;
    protected $limit;
    protected $window;

    public function __construct(PDO $pdo, $limit = 100, $window = 60)
    {
        $this->pdo = $pdo;
        $this->limit = $limit;
        $this->window = $window;
    }

    public function check($key)
    {
        $stmt = $this->pdo->prepare("SELECT count, last_reset FROM rate_limits WHERE key = :key");
        $stmt->execute([':key' => $key]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $now = new DateTime();

        if (!$row) {
            $stmt = $this->pdo->prepare("INSERT INTO rate_limits (key, count, last_reset) VALUES (:key, 1, :now)");
            $stmt->execute([':key' => $key, ':now' => $now->format('Y-m-d H:i:s')]);
            return true;
        }

        $lastReset = new DateTime($row['last_reset']);
        $elapsed = ($now->getTimestamp() - $lastReset->getTimestamp());

        if ($elapsed > $this->window) {
            $stmt = $this->pdo->prepare("UPDATE rate_limits SET count = 1, last_reset = :now WHERE key = :key");
            $stmt->execute([':now' => $now->format('Y-m-d H:i:s'), ':key' => $key]);
            return true;
        }

        if ($row['count'] < $this->limit) {
            $stmt = $this->pdo->prepare("UPDATE rate_limits SET count = count + 1 WHERE key = :key");
            $stmt->execute([':key' => $key]);
            return true;
        }
        return false;
    }
}
