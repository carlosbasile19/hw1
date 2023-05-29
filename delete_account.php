<?php
session_start();
include("functions_db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION["user_id"])) {
        header("Location: home.php");
        exit;
    }

    $conn = connect_to_db();

    if (!$conn) {
        die('Unable to connect to the database');
    }

    delete_account($conn, $_SESSION["user_id"]);

    disconnect_from_db($conn);
    include("logout.php");    

    
}else{
    header("Location: index.php");
    exit();}
?>
