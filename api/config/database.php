<?php

class Database{

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "id13824238_auth_api";
    private $username ="id13824238_admin";
    private $password = "Z1y2x3w4-shreyas";
    private $charset = "utf8mb4";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=".$this->charset, $this->username, $this->password);
            echo "DB Connected.\n";
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>


