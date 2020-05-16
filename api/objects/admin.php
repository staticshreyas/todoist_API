<?php
class Admin{

    private $conn;
    private $table_name = "admin_tbl";

    public $adminid;
    public $adminusername;
    public $adminpassword;
    public $uid;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

// create new user record
    function admin_create(){

        // insert query
        $query = "INSERT INTO " . $this->table_name . "
            SET
                username = :username,
                uid = :uid,
                password = :password
                ";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->adminusername=htmlspecialchars(strip_tags($this->adminusername));
        $this->uid=htmlspecialchars(strip_tags($this->uid));
        $this->adminpassword=htmlspecialchars(strip_tags($this->adminpassword));

        // bind the values
        $stmt->bindParam(':username', $this->adminusername);
        $stmt->bindParam(':uid', $this->uid);

        // hash the password before saving to database
        $password_hash = password_hash($this->adminpassword, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }




}