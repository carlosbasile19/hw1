<?php
session_start();
include("functions_db.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION["user_id"])) {
        header("Location: home.php");
        exit;
    }

    $name = $_POST["name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirm = $_POST["confirm_password"];

    if($password !== $password_confirm){
        header("Location: signup.php?password_error=true");
        exit;
    }


    $conn = connect_to_db();

    $name = mysqli_real_escape_string($conn, $name);
    $last_name = mysqli_real_escape_string($conn, $last_name);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $password_confirm = mysqli_real_escape_string($conn, $password_confirm);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d).{8,}$/', $password)) {
            header("Location: signup.php?password_error=true");
            exit;
        }


    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: signup.php?email_used=true");
        
    } else {
        $result = create_account($conn, $name, $last_name, $email, $hashed_password);
        
        if ($result) {
          
            $sql = "SELECT id FROM users WHERE email = '$email'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["name"] = $_POST["name"];
            $_SESSION["email"] = $_POST["email"];

            header("Location: home.php");
            exit();
        } else {
     
            header("Location: signup.php?registration_error=true");
        }
    }
    disconnect_from_db($conn);
    echo $error;

}else{
    header("Location: index.php");
    exit();}
?>
