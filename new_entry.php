<?php
    session_start();
    include('functions_db.php');

    $conn = connect_to_db();

    if (!isset($_SESSION['user_id'])) {
        header('Location: login_home.php');
        exit;
    }

    if(!isset($_GET['diary_id'])){
        echo 'Diary id not set';
        exit;
    }

    if(get_diary_by_id($conn, $_GET['diary_id']) == null){
        echo 'Diary not found';
        exit;
    }

    if(!verify_property_user_diary($conn, $_SESSION['user_id'], $_GET['diary_id'])){
        echo 'You do not have property on this diary';
        exit;
    }

    disconnect_from_db($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Entry!</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="input_data.css">
</head>
<body>
    <?php
    include('header_home.php');
    ?>
<main>
    <h1>New Entry!</h1>

    <form action="create_entry.php" method="post">
        <div>
            <input type="hidden" name="diary_id" value="<?php echo $_GET['diary_id']; ?>">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
            <label for="content">Content</label>
            <textarea id="content" name="content" rows="10" cols="50" required></textarea>
        </div>
        <button type="submit">Create Entry</button>
    </form>
</main>

<?php
include('footer.php');
?>
</body>
</html>





