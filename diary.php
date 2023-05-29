
<?php

include('functions_db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login_home.php');
   die;
}

if(isset($_GET["id"])){
    
    $conn = connect_to_db();
    $diary = get_diary_by_id($conn, $_GET['id']);
    

    if(verify_property_user_diary($conn, $_SESSION['user_id'],  $_GET['id'])){
        disconnect_from_db($conn);              
        include('entries.php');
        die;
    }

    else{
        disconnect_from_db($conn);

        header("Location: index.php");
        die;
    }
}

?>


