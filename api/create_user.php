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
include_once 'objects/admin.php';


//Database Connection
$database = new Database();
$db = $database->getConnection();


$user = new User($db);

//Post Data
$data = json_decode(file_get_contents("php://input"));


$user->username = $data->username;
$user->email = $data->email;
$user->password = $data->password;
$user->image = $data->image;


$email_exists = $user->emailExists();

if(!$email_exists) {


//Creating User
    if (
        !empty($user->username) &&
        !empty($user->email) &&
        !empty($user->password) &&
        !empty($user->image) &&
        $user->create()
    ) {

        //Response code
        http_response_code(200);

        echo json_encode(array("message" => "User was created."));
    } else {

        //Response code
        http_response_code(400);

        echo json_encode(array("message" => "Unable to create user."));
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message" => "Email Already Exists."));
}
?>


