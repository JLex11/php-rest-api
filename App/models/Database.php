<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
  private static $instance = null;
  private $connection;

  private function __construct()
  {
    $host = 'localhost';
    $dbname = 'users-rest-api';
    $username = 'postgres';
    $password = 'J1193553556a';
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $dsn = "pgsql:host=$host;dbname=$dbname;user=$username;password=$password";

    try {
      $this->connection = new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
      die("Error connecting to database " . $e->getMessage());
    }
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function getConnection()
  {
    return $this->connection;
  }
}
