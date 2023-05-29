<?php
session_start();
include("functions_db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login_home.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];

    $conn = connect_to_db();

    $title = mysqli_real_escape_string($conn, $title);

    $result = add_diary($conn, $_SESSION["user_id"], $title);

    if ($result) {
        header("Location: home.php");
        exit();
    } else {
        header("Location: home.php?diary_error=true");
        exit();
    }

} else {
   
    header("Location: home.php");
    exit();
}
?>
