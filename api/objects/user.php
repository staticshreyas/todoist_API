<?php
include_once 'admin.php';
include_once 'user.php';
class User extends Admin {

    private $conn;
    private $table_name = "user_tbl";

    public $id;
    public $username;
    public $email;
    public $password;
    public $image;
    public $admin;
    public $status;

    //Fetch data
    public $allNum;
    public $allRows;
    public $completedNum;
    public $completedRows;
    public $starredNum;
    public $starredRows;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

// create new user record
    public function create(){
        $this->admin = new Admin($this->conn);
        $this->admin->adminusername = "admin1";
        $this->admin->adminpassword = "abc";


        // insert query
        $query = "INSERT INTO " . $this->table_name . "
            SET
                username = :username,
                image = :image,
                email = :email,
                password = :password";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));

        // bind the values
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':email', $this->email);

        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            $query = "SELECT id FROM ". $this->table_name . " ORDER BY ID DESC LIMIT 1 " ;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->admin->uid = $row['id'];
            if(!empty($this->admin->uid) && $this->admin->admin_create()){

                //Response code
                http_response_code(200);

                echo json_encode(array("message" => "New Admin Record was created."));
            }

            else{

                //Response code
                http_response_code(400);

                echo json_encode(array("message" => "Unable to create admin record."));
            }


            return true;
        }

        return false;
    }

// check if given email exist in the database
    public function emailExists(){

        // query to check if email exists
        $query = "SELECT id, username, image, password
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));

        // bind given email value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->image = $row['image'];
            $this->password = $row['password'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }

    public function blockStatus()
    {
        $query = "SELECT status FROM user_tbl WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->status = $row['status'];

        if($this->status == 1){
            return false;
        }
        else{
            return true;
        }



    }


// update a user record
    public function update(){

        // if password needs to be updated
        $password_set=!empty($this->password) ? ", password = :password" : "";

        // if no posted password, do not update the password
        $query = "UPDATE " . $this->table_name . "
            SET
                username = :username,
                image = :image,
                email = :email
                {$password_set}
            WHERE id = :id";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->email=htmlspecialchars(strip_tags($this->email));

        // bind the values from the form
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':email', $this->email);

        // hash the password before saving to database
        if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
        }

        // unique ID of record to be edited
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // Star task task record
    public function status_update()
    {

        // insert query
        $query = "UPDATE " . $this->table_name . "
            SET
                status = :status
            WHERE id = :id";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->status = htmlspecialchars(strip_tags($this->status));

        // bind the values
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function getAllTasks(){
        $query = " SELECT id, task, date_time, priority, status FROM task_tbl WHERE uid = :uid";

        $stmt = $this->conn->prepare( $query );

        $this->status = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':uid', $this->id);


        $stmt->execute();

        $this->allNum = $stmt->rowCount();
        $this->allRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

       /* echo json_encode(array(
            "allTasksOfUser" => $num,
            "data" => $rows
        ));*/

    }

    public function getAllCompletedTasks(){
        $query = " SELECT id, task, date_time, priority, status FROM task_tbl WHERE uid = :uid AND status = '1' ";

        $stmt = $this->conn->prepare( $query );

        $this->status = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':uid', $this->id);


        $stmt->execute();

        $this->completedNum = $stmt->rowCount();
        $this->completedRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*echo json_encode(array(
            "allCompletedTasksOfUser" => $num,
            "data" => $rows
        ));*/

    }

    public function getAllStarredTasks(){
        $query = " SELECT id, task, date_time, priority, status FROM task_tbl WHERE uid = :uid AND priority = '1' ";

        $stmt = $this->conn->prepare( $query );

        $this->status = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':uid', $this->id);


        $stmt->execute();

        $this->starredNum = $stmt->rowCount();
        $this->starredRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*echo json_encode(array(
            "allStarredTasksOfUser" => $num,
            "data" => $rows
        ));*/

    }


}