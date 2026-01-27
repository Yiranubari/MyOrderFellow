<?php


require_once __DIR__ . '/vendor/autoload.php';


use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

use App\Core\Database;

try {
    echo "Attempting to connect...\n";

    $db = new Database();
    $conn = $db->connect();

    if ($conn) {
        echo "SUCCESS: Connected to PostgreSQL database '" . $_ENV['DB_DATABASE'] . "'!\n";
        echo "Connection Object: \n";
        var_dump($conn);
    } else {
        echo "FAILURE: The connect() method returned null.\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
