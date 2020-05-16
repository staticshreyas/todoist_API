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












}