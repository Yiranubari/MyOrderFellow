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
        $stmt = $this->pdo->prepare("SELECT count, window_start FROM rate_limits WHERE rate_key = :key");
        $stmt->execute([':key' => $key]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $now = new DateTime();
    }
}
