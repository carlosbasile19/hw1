<?php
session_start();
include("functions_db.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $entry_id = $_GET["entry_id"];

    if(!$entry_id){
        echo "missing data";
        exit;
    }

    $conn = connect_to_db();

    $entry = get_entry($conn, $entry_id);

    if(!$entry){
        echo "entry does not exist";
        exit;
    }

    if(entry_in_favorites($conn, $entry_id)){
        echo json_encode(array("status" => "favorite"));
    }else{
        echo json_encode(array("status" => "not favorite"));
    }

    disconnect_from_db($conn);
}
?>
