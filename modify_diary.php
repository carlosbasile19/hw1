
<?php
include('functions_db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login_home.php');
   die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $diary_id = $_POST['diary_id'];
    $title = $_POST['title'];
    

    $conn = connect_to_db();

    if(verify_property_user_diary($conn, $_SESSION['user_id'], $diary_id )){
        
        modify_diary($conn, $diary_id, $title);

        disconnect_from_db($conn);

        header("Location: home.php");
        die();

    }

    else{
    
        disconnect_from_db($conn);

        header("Location: index.php");
        die;
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'GET'){
     
        $conn = connect_to_db();
       
        $diary = get_diary_by_id($conn, $_GET['id']);
        

        if(isset($_GET['id'])){
            if(verify_property_user_diary($conn, $_SESSION['user_id'],  $_GET['id'])){
                
                disconnect_from_db($conn);              
                include('modify_diary_form.php');
                die;
            }
            else{
                disconnect_from_db($conn);
                header("Location: index.php");
                die;
            }
        }

        disconnect_from_db($conn);

    }
?>


