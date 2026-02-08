<?php

/**
 * Database Migration Script
 * Run this script to set up all tables in your Vercel Neon database
 * 
 * Usage: php migrate_database.php
 */

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== My Order Fellow Database Migration ===\n\n";

// Get database connection from environment
$dbUrl = $_ENV['DB_URL'] ?? null;

if (!$dbUrl) {
    die("Error: DB_URL not found in environment variables.\n");
}

echo "Connecting to database...\n";
echo "DB URL: " . substr($dbUrl, 0, 30) . "...\n";

try {
    // Convert postgresql:// to pgsql:// for PHP PDO
    $connectionString = str_replace('postgresql://', 'pgsql://', $dbUrl);

    // Parse and reconstruct the connection string
    $parsed = parse_url($dbUrl);
    $dsn = sprintf(
        "pgsql:host=%s;port=%d;dbname=%s;sslmode=require",
        $parsed['host'],
        $parsed['port'] ?? 5432,
        ltrim($parsed['path'], '/')
    );

    $pdo = new PDO($dsn, $parsed['user'], $parsed['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    echo "✓ Connected successfully!\n\n";
} catch (PDOException $e) {
    die("✗ Connection failed: " . $e->getMessage() . "\n");
}

// Read migration SQL file
$sqlFile = __DIR__ . '/migrate.sql';
if (!file_exists($sqlFile)) {
    die("✗ Migration file not found: $sqlFile\n");
}

$sql = file_get_contents($sqlFile);

echo "Running migrations...\n";
echo "-------------------\n";

try {
    // Execute the entire migration
    $pdo->exec($sql);
    echo "✓ All tables created successfully!\n\n";

    // Verify tables
    echo "Verifying tables...\n";
    $tables = ['companies', 'admins', 'orders', 'tracking_history', 'rate_limits'];

    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_name = '$table'");
        $exists = $stmt->fetchColumn();

        if ($exists) {
            echo "✓ Table '$table' exists\n";
        } else {
            echo "✗ Table '$table' not found\n";
        }
    }

    echo "\n=== Migration completed successfully! ===\n";
} catch (PDOException $e) {
    die("\n✗ Migration failed: " . $e->getMessage() . "\n");
}
