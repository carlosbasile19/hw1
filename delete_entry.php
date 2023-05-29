<?php
session_start();
include("functions_db.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $request_body = json_decode(file_get_contents('php://input'), true);
    $diary_id = $request_body['diary_id'];
    $entry_id = $request_body['entry_id'];
    $user_id = $request_body['user_id'];

    echo "diary: " . $diary_id . " entry id " . $entry_id . " user id " . $user_id;
    echo "\n";
    
    if(!$entry_id || !$user_id || !$diary_id){
        echo "missing data";
        exit;
    }
    
    // Connect to the database
    $conn = connect_to_db();

    if (!$conn) {
        die('Unable to connect to the database');
    }

    $entry = get_entry_by_id($conn, $diary_id, $entry_id);

    if(!$entry){
        echo "entry does not exist";
        exit;
    }

    if(!verify_property_user_diary($conn, $user_id, $diary_id)){
        echo "not your diary";
        exit;
    }

    if(!verify_property_diary_entry($conn, $diary_id, $entry_id)){
        echo "not your entry";
        exit;
    }

    delete_entry($conn, $entry_id);

   
    disconnect_from_db($conn);
    

} else {
    // Request method is not POST, redirect to the home page
    echo "not post";
    exit();
}
?>
