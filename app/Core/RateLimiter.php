<?php

namespace App\Core; // Correct Namespace

class RateLimiter
{
    private $cacheDir;

    public function __construct()
    {
        // Go up two levels from 'Core' to reach root, then into 'cache'
        $this->cacheDir = __DIR__ . '/../../cache/';

        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    public function check($key, $limit, $windowSeconds)
    {
        $file = $this->cacheDir . 'rate_limit_' . md5($key) . '.json';
        $current_time = time();

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
