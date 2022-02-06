<?php

class Database
{
  private $host = 'localhost';
  private $dbName = 'blog';
  private $userName = 'root';
  private $password = '12345678';
  private $conn;

  public function connect()
  {
    $this->conn = null;
    try {
      $this->conn = new PDO(
        "mysql:host={$this->host};dbname={$this->dbName}",
        $this->userName,
        $this->password
      );
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $this->conn;
    } catch (PDOException $e) {
      die('Connection Error:' . $e->getMessage());
    }
  }
}
