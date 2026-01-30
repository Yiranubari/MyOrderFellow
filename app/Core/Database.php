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
        // 1. Get the URL from the environment
        // Supports both naming conventions just in case
        $connectionUrl = getenv('DB_URL') ?: getenv('DATABASE_URL');

        if (!$connectionUrl) {
            die("Error: DB_URL environment variable is not set.");
        }

        // 2. Parse the URL (Break it into parts)
        $db = parse_url($connectionUrl);

        $this->host = $db['host'];
        $this->port = $db['port'];
        $this->username = $db['user'];
        $this->password = $db['pass'];
        $this->database = ltrim($db['path'], '/'); // Remove the leading slash

        // 3. Build the DSN (The format PDO understands)
        // We force sslmode=require because Render requires it
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->database};sslmode=require";

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
