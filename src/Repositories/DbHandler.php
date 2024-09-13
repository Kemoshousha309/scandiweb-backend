<?php

namespace App\Repositories;

use App\Utils\EnvLoader;
use Exception;
use PDO;
use PDOException;

class DbHandler
{
    private $pdo;
    private static $dbHandler = null;

    // Constructor to initialize the PDO connection
    private function __construct($host, $dbname, $username, $password, $charset = 'utf8mb4')
    {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT         => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    // Method to execute a query with optional parameters
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Query execution failed: " . $e->getMessage());
        }
    }

    // Method to fetch all records from a query
    public function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    // Method to fetch a single record from a query
    public function fetchOne($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    // Method to insert a new record and return the inserted ID
    public function insert($sql, $params = [])
    {
        $this->query($sql, $params);
        return $this->pdo->lastInsertId();
    }

    // Method to get the PDO instance if needed
    public function getPdo()
    {
        return $this->pdo;
    }

    // Destructor to close the connection
    public function __destruct()
    {
        $this->pdo = null;
    }
   
    // singleton pattern 
    public static function getInstance(): DbHandler
    {
        EnvLoader::loadEnv(__DIR__ . '/../../.env');
        if (self::$dbHandler == null) {
            $dbHandler = new DbHandler(
                getenv('DB_HOST'),
                getenv('DB_NAME'),
                getenv('DB_USER_NAME'),
                getenv('DB_PASSWORD')
            );
        }
        return $dbHandler;
    }
}
