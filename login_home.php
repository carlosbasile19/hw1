<?php
    session_start();
    if (isset($_SESSION["user_id"])) {
        header("Location: home.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obsidian Memories - Login</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="forms.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <?php include("header.php") ?>

    <main>
        <div class="container">

        <form class="form" action="login.php" method="post">
        <h1>Login</h1>
            <label for="email">Email:</label>
            <input type="text" id="username" name="email">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password">

            <input type="submit" value="Go!">

            <?php if (isset($_GET["login_failed"])): ?>
                <p>Login failed. Please try again.</p>
            <?php endif; ?> 
            
            <?php if (isset($_GET["password_failed"])): ?>
                <p>Password wrong. Please try again.</p>
            <?php endif; ?> 
            
        </form>
        </div>

        
       
    </main>

    <?php include("footer.php") ?>

</body>
</html>
