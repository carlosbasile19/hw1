<?php
session_start();
include("functions_db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION["user_id"])) {
        header("Location: home.php");
        exit;
    }

    $username = $_POST["email"];
    $password = $_POST["password"];

    $conn = connect_to_db();

    $sql = "SELECT id, name, email, password FROM users WHERE email = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (!password_verify($password, $row["password"]))
        {
            header("Location: login_home.php?password_failed=true");
            exit();
        }

        $_SESSION["user_id"] = $row["id"];
        $_SESSION["name"] = $row["name"];
        $_SESSION["email"] = $row["email"];


        header("Location: home.php");
        exit();

    } else {
        header("Location: login_home.php?login_failed=true");
        exit();
    }
    
}else{

    if (isset($_SESSION["user_id"])) {
        header("Location: home.php");
        exit;
    }

    header("Location: index.php");
    exit();
}

?>
