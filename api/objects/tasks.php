<?php
class Tasks
{

    private $conn;
    private $table_name = "task_tbl";

    public $id;
    public $task;
    public $datetime;
    public $priority;
    public $status;
    public $uid;

    // constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

// create new task record
    function create()
    {

        // insert query
        $query = "INSERT INTO " . $this->table_name . "
            SET
                task = :task,
                date_time = :datetime,
                uid = :uid";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->task = htmlspecialchars(strip_tags($this->task));
        $this->datetime = htmlspecialchars(strip_tags($this->datetime));
        $this->uid = htmlspecialchars(strip_tags($this->uid));

        // bind the values
        $stmt->bindParam(':task', $this->task);
        $stmt->bindParam(':datetime', $this->datetime);
        $stmt->bindParam(':uid', $this->uid);
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }


// Star task task record
    function star()
    {

        // insert query
        $query = "UPDATE " . $this->table_name . "
            SET
                priority = :priority
            WHERE id = :id";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->priority = htmlspecialchars(strip_tags($this->priority));

        // bind the values
        $stmt->bindParam(':priority', $this->priority);
        $stmt->bindParam(':id', $this->id);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }



// Complete task task record
    function complete()
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

    // Complete task task record
    function delete()
    {

        // insert query
        $query = "DELETE FROM " . $this->table_name . "
            
            WHERE id = :id";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // bind the values
        $stmt->bindParam(':id', $this->id);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // Complete task task record
    function update()
    {

        // insert query
        $query = "UPDATE " . $this->table_name . "
        SET
           task = :task  
        WHERE id = :id";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // bind the values
        $stmt->bindParam(':task', $this->task);

        $stmt->bindParam(':id', $this->id);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }






}