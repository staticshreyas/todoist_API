<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost:8888/auth_api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// files needed to connect to database
include_once 'config/database.php';
include_once 'objects/admin.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// instantiate user object
$admin = new Admin($db);

// get posted data
//$data = json_decode(file_get_contents("php://input"));

$admin->getAllUsers();
$admin->getAllBlockedUsers();
$admin->getAllUblockedUsers();


$admin->getAllTasks();
$admin->getAllCompletedTasks();

echo json_encode(array(
    "allUsers" => $admin->allUsersNum,
    "allUsersdata" => $admin->allUsersRows,

    "allBlockedUsers" => $admin->blockedNum,
    "allBLockedUsersdata" => $admin->blockedRows,

    "allUnblockedUsers" => $admin->unblockedNum,
    "allUnblockedUsersdata" => $admin->unblockedRows,

    "allTasks" => $admin->allTasksNum,
    "allTasksdata" => $admin->allTasksRows,

    "allCompletedTasks" => $admin->allCompletedTasksNum,
    "allCompletedTasksdata" => $admin->allCompletedTasksRows,
));