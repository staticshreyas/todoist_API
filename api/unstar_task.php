<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost:8888/auth_api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



//Files for DB
include_once 'config/database.php';
include_once 'objects/user.php';
include_once 'objects/tasks.php';

//Database Connection
$database = new Database();
$db = $database->getConnection();

$task = new Tasks($db);

//Post Data
$data = json_decode(file_get_contents("php://input"));


$task->priority = $data->priority;
$task->id = $data->id;

//Creating Task
if(
    $task->priority == 0 &&
    $task->unStar()
){
    //Response code
    http_response_code(200);

    echo json_encode(array("message" => "Task was Unstarred."));
}

else{

    //Response code
    http_response_code(400);

    echo json_encode(array("message" => "Unable to Unstar Task."));
}
?>