<?php

namespace App\Classes;

use \PDO;
use \PDOException;

class Database
{
  // Connection variables
  private $host = DBHOST;
  private $username = DBUSER;
  private $password = DBPASSWORD;
  private $database = DBNAME;

  // Connection object
  private ?\PDO $conn = null;

  // Connect to database
  public function connect()
  {
    try {
      $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
    }
    return $this->conn;
  }
}
