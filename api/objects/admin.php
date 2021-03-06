<?php
include_once 'user.php';
include_once 'tasks.php';

class Admin{

    private $conn;
    private $table_name = "admin_tbl";

    public $adminid;
    public $adminusername;
    public $adminpassword;
    public $uid;

    //Fetch data
    public $allUsersNum;
    public $allUsersRows;
    public $blockedNum;
    public $blockedRows;
    public $unblockedNum;
    public $unblockedRows;
    public $allTasksNum;
    public $allTasksRows;
    public $allCompletedTasksNum;
    public $allCompletedTasksRows;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

// create new user record
    public function admin_create(){

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

    // check if given username exist in the database
    public function usernameExists(){

        // query to check if email exists
        $query = "SELECT id, username, uid, password
            FROM " . $this->table_name . "
            WHERE username = ?
            LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->adminusername=htmlspecialchars(strip_tags($this->adminusername));

        // bind given email value
        $stmt->bindParam(1, $this->adminusername);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->adminid = $row['id'];
            $this->adminusername = $row['username'];
            $this->uid = $row['uid'];
            $this->adminpassword = $row['password'];

            // return true because username exists in the database
            return true;
        }

        // return false if username does not exist in the database
        return false;
    }

    public function getAllUsers(){
        $query = "SELECT id, username,email, image, status FROM user_tbl";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $this->allUsersNum = $stmt->rowCount();
        $this->allUsersRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*echo json_encode(array(
            "totalUsers" => $num,
            "data" => $rows
        ));*/

    }

    public function getAllBlockedUsers(){
        $query = " SELECT id, username,email, image, status FROM user_tbl WHERE status = '0' ";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $this->blockedNum = $stmt->rowCount();
        $this->blockedRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*echo json_encode(array(
            "blockedUsers" => $num,
            "data" => $rows
        ));*/

    }

    public function getAllUblockedUsers(){
        $query = " SELECT id, username,email, image, status FROM user_tbl WHERE status = '1' ";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $this->unblockedNum = $stmt->rowCount();
        $this->unblockedRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*echo json_encode(array(
            "unblockedUsers" => $num,
            "data" => $rows
        ));*/

    }

    public function getAllTasks(){
        $query = " SELECT id, task, date_time, priority, status FROM task_tbl ";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $this->allTasksNum = $stmt->rowCount();
        $this->allTasksRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*echo json_encode(array(
            "allTasks" => $num,
            "data" => $rows
        ));*/

    }

    public function getAllCompletedTasks(){
        $query = " SELECT id, task, date_time, priority, status FROM task_tbl WHERE status = '1' ";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $this->allCompletedTasksNum = $stmt->rowCount();
        $this->allCompletedTasksRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

       /* echo json_encode(array(
            "allCompletedTasks" => $num,
            "data" => $rows
        ));*/

    }








}