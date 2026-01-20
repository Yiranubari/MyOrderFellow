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

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->port = $_ENV['DB_PORT'];
        $this->database = $_ENV['DB_DATABASE'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];

        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->database};";
    }
}
