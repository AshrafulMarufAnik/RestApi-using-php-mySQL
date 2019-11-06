<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// instantiate database and user object
$database = new database();
$db = $database->getConnection();
 
// initialize object
$user = new user($db);
 
// query products
$stmt = $user->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    //user array
    $users_arr=array();
    $users_arr["users"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $user_item=array(
            "userId" => $userId,
            "name" => $name,
            "title" => $title,
            "body" => $body,
            "status" => $status,
        );
 
        array_push($users_arr["users"], $user_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($users_arr);
}
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no user data found
    echo json_encode(
        array("message" => "No products found.")
    );
}

?>