<?php
session_start();
include("functions_db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $request_body = json_decode(file_get_contents('php://input'), true);
    $diary_id = $request_body['diary_id'];
    $user_id = $request_body['user_id'];
    
    $conn = connect_to_db();


    if(verify_property_user_diary($conn, $user_id, $diary_id)){
        delete_diary_and_entries($conn, $diary_id);
        disconnect_from_db($conn);
    }
    else{
        echo "not your diary";
        exit;
    }
    

} else {
   
    echo "not post";
    exit();
}
?>
