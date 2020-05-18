<?php

class Database{

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "auth_api";
    private $username = "root";
    private $password = "root";
    private $charset = "utf8mb4";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=".$this->charset, $this->username, $this->password);
            echo "DB Connected.";
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>


