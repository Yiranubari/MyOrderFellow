<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Tracking;
use App\Services\OrderService;

class RateLimiter
{

    private $cacheDir;
    public function __construct()
    {
        $this->cacheDir = __DIR__ . '/../../cache/';
    }

    public function check($key, $limit, $windowSeconds)
    {
        $file = $this->cacheDir . 'rate_limit_' . md5($key) . '.json';
        $current_time = time();

        $data = [
            'start_time' => $current_time,
            'count' => 0
        ];

        if (file_exists($file)) {
            file_get_contents($file);
            $data = json_decode(file_get_contents($file), true);
            if ($current_time - $data['start_time'] < $windowSeconds) {
                if ($data['count'] >= $limit) {
                    return false;
                }
            } else {
                $data = [
                    'start_time' => $current_time,
                    'count' => 0
                ];
            }
            $data['count']++;
            file_put_contents($file, json_encode($data));
            return true;
        }
    }
}
