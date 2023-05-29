
<?php

include('functions_db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login_home.php');
   die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $diary_id = $_POST['diary_id'];
    $entry_id = $_POST['entry_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $conn = connect_to_db();

    if(verify_property_user_diary($conn, $_SESSION['user_id'], $diary_id) && verify_property_diary_entry($conn, $diary_id, $entry_id)){
        modify_entry($conn, $entry_id, $title, $content);
        header("Location: entries.php?id=$diary_id");
        disconnect_from_db($conn);
    }else{
    
        disconnect_from_db($conn);
  
        header("Location: index.php");
        die;
    }


} else if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        
        $conn = connect_to_db();
           
        if(isset($_GET['diary_id']) && isset($_GET['entry_id'])){
    
            if(verify_property_user_diary($conn, $_SESSION['user_id'], $_GET['diary_id'])){
                $diary_id = $_GET['diary_id'];
                $entry_id = $_GET['entry_id'];
            }
            else{
                disconnect_from_db($conn);
                echo "You don't have the permission to modify this entry";
                die;
            }
    
                $entry = get_entry_by_id($conn, $_GET['diary_id'], $_GET['entry_id']);
                $diary_id = $_GET['diary_id'];
                $entry_id = $_GET['entry_id'];
                disconnect_from_db($conn);
                if($entry){
                    include('modify_entry_form.php');
                    die;
                }
                else{
                    echo "There is no entry with this id";
                    die;
                }
            
        } else{
            disconnect_from_db($conn);
            echo "You did not specify the diary id or the entry id";
            die;
        }
    }
        
?>