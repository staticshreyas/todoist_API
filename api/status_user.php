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

$user = new User($db);

//Post Data
$data = json_decode(file_get_contents("php://input"));


$user->status = $data->status;
$user->id = $data->id;

//Changing status
if(
    $user->status == 0 &&
    $user->status_update()
){
    //Response code
    http_response_code(200);

    echo json_encode(array("message" => "User was blocked"));
}

else if(
    $user->status == 1 &&
    $user->status_update()
){
    http_response_code(200);

    echo json_encode(array("message" => "User was unblocked"));

}


else{

    //Response code
    http_response_code(400);

    echo json_encode(array("message" => "Unable to block or unblock User."));
}
?>