<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login_home.php");
    exit();
}

include('functions_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $diary_id = $_POST["diary_id"];
    $title = $_POST["title"];
    $content = $_POST["content"];

    $conn = connect_to_db();


    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);
   

    $result = add_entry($conn, $diary_id, $title, $content);

    if ($result) {
        header("Location: entries.php?id=$diary_id");
        exit();
    } else {
        echo "Entry creation failed.";
    }
    
} else {

    header("Location: home.php");
    exit();
}
?>
