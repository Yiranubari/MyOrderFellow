<?php

// 1. Load the Composer Autoloader
require_once __DIR__ . '/vendor/autoload.php';

// 2. Load the Environment Variables
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 3. Import your Database Class
use App\Core\Database;

// 4. Test the Connection
try {
    echo "Attempting to connect...\n";

    $db = new Database();
    $conn = $db->connect();

    if ($conn) {
        echo "✅ SUCCESS: Connected to PostgreSQL database '" . $_ENV['DB_DATABASE'] . "'!\n";
        echo "Connection Object: \n";
        var_dump($conn);
    } else {
        echo "❌ FAILURE: The connect() method returned null.\n";
    }
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
