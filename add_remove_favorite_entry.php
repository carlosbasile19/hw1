<?php
session_start();
include("functions_db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $request_body = json_decode(file_get_contents('php://input'), true);
    $entry_id = $request_body['entry_id'];
    $user_id = $request_body['user_id'];
    
    if(!$user_id || !$entry_id){
        echo "missing data";
        exit;
    }
    
    $conn = connect_to_db();

    $entry = get_entry($conn, $entry_id);

    if(!$entry){
        echo "entry does not exist";
        exit;
    }

    if(!verify_property_user_entry($conn, $user_id, $entry_id)){
        echo "entry is NOT yours";
        exit;
    }
    
    if(verify_entry_in_favorites($conn, $entry_id, $user_id)){
        remove_entry_from_favorites($conn, $entry_id, $user_id); 
        echo "removed";
    }else{
        add_entry_to_favorites($conn, $entry_id, $user_id);
        echo "added";
    }

    disconnect_from_db($conn);

} else {
    echo "Request method not accepted";
}
?>
