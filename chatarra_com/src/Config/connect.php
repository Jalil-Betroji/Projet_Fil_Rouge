<?php
class Dbh {
  private $host = "localhost";
  private $username = "root";
  private $password = "";
  private $dbName = "chattara";

  public function connect(){
      try{
          $dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
          $conn = new PDO($dsn, $this->username, $this->password);
          $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
          return $conn;
      }catch(PDOException $e){
          echo "Connection failed: " . $e->getMessage();
      }
  }
}


?>
