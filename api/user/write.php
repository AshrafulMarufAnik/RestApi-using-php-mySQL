<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/user.php';
 
$database = new database();
$db = $database->getConnection();
 
$user = new user($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->userId) &&
    !empty($data->name) &&
    !empty($data->title) &&
    !empty($data->body) &&
    !empty($data->status)
){
 
    // set product property values
    $user->userId = $data->userId;
    $user->name = $data->name;
    $user->title = $data->title;
    $user->body = $data->body;
    $user->status = $data->status;
 
    // create the product
    if($user->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "new user was created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create new user."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400); 
    // tell the user
    echo json_encode(array("message" => "Unable to create new user. Data is incomplete."));
}

?>