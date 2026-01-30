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

        // Default state for a new window or new user
        $data = [
            'start_time' => $current_time,
            'count' => 0
        ];

        if (file_exists($file)) {
            // Read the file
            $json = file_get_contents($file);
            $existingData = json_decode($json, true);

            // Check if the time window is still active
            if ($current_time - $existingData['start_time'] < $windowSeconds) {
                // Window is active, check if they are ALREADY blocked
                if ($existingData['count'] >= $limit) {
                    return false; // Block immediately
                }
                // Use the existing data (preserve the count)
                $data = $existingData;
            }
            // If window expired, $data stays as the 'Default' (0) we set above
        }

        // Increment and Save
        $data['count']++;
        file_put_contents($file, json_encode($data));

        return true; // Allow the request
    }
}
