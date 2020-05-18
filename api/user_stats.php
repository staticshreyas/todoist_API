<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost:8888/auth_api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// files needed to connect to database
include_once 'config/database.php';
include_once 'objects/user.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate user object
$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

$user->id = $data->uid;

/*echo "User Stats";
$admin->getAllUsers();
$admin->getAllBlockedUsers();
$admin->getAllUblockedUsers();*/


echo "Task Stats";
$user->getAllTasks();
$user->getAllCompletedTasks();
$user->getAllStarredTasks();
