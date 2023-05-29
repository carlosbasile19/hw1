<?php

    session_start();
    include('functions_db.php');

    if (!isset($_SESSION['user_id'])) {
        header('Location: login_home.php');
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Diary</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="input_data.css">
    <link rel="stylesheet" href="buttons.css">
</head>
<body>
    <?php
    include('header_home.php');
    ?>
<main>
    <h1>New diary</h1>

    <form action="create_diary.php" method="post">
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>

        <button type="submit">Create Diary!</button>
    </form>
</main>

<?php
include('footer.php');
?>
</body>
</html>





