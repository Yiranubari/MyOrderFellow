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
        $this->host = $_ENV['DB_HOST'];
        $this->port = $_ENV['DB_PORT'];
        $this->database = $_ENV['DB_DATABASE'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];


        $dsn = getenv('DB_URL');
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
