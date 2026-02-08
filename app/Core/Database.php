<?php

namespace App\Core;

use PDO;
use PDOException;


class Database
{
    private $host;
    private $port;
    private $database;
    private $username;
    private $password;

    protected $pdo;

    public function __construct()
    {
        // Ensure environment variables are loaded
        if (!isset($_ENV['DB_URL']) && !isset($_ENV['POSTGRES_URL']) && !isset($_ENV['DB_DATABASE_URL'])) {
            if (file_exists(__DIR__ . '/../../.env')) {
                $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
                $dotenv->load();
            }
        }

        // Try multiple possible environment variable names (check Vercel's custom names first)
        $connectionUrl = $_ENV['DB_DATABASE_URL'] ?? $_ENV['POSTGRES_URL'] ?? $_ENV['DB_URL'] ??
            getenv('DB_DATABASE_URL') ?: getenv('POSTGRES_URL') ?: getenv('DB_URL') ?: getenv('DATABASE_URL');

        if (!$connectionUrl) {
            die("Error: Database URL environment variable is not set.");
        }

        $db = parse_url($connectionUrl);

        $this->host = $db['host'];
        $this->port = isset($db['port']) ? $db['port'] : null;
        $this->username = $db['user'];
        $this->password = $db['pass'];
        $this->database = ltrim($db['path'], '/');

        $dsn = "pgsql:host={$this->host};";
        if ($this->port) {
            $dsn .= "port={$this->port};";
        }
        $dsn .= "dbname={$this->database};sslmode=require";

        // Debug output for troubleshooting
        error_log("[DEBUG] DSN: $dsn");
        error_log("[DEBUG] Database: {$this->database}");
        error_log("[DEBUG] User: {$this->username}");

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }
    public function connect()
    {
        return $this->pdo;
    }
}
