<?php
session_start();
include("functions_db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login_home.php");
    exit;
}

$conn = connect_to_db();

$favorites = get_favorites_by_user_id($conn, $_SESSION["user_id"]);

disconnect_from_db($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Entries</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="favorites.css">
    <link rel="stylesheet" href="buttons.css">
</head>
<body>
    <?php include("header_home.php"); ?>
    <main>
        <h1>Favorites.</h1>
        <h3>Here you find the best of the best!</h3>
        <div class="entries-container">
            <?php if (count($favorites) == 0): ?>
               <p>You dont have favorites. add them.</p>
             <?php else: ?>
                <?php foreach ($favorites as $entry): ?>
                    <div class="entry">
                    <div class="entry-name"><a href="entry.php?id=<?php echo $entry['id']; ?>&diary_id=<?php echo $entry['diary_id']; ?>"><?php echo $entry['title']; ?></a></div>         
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="button-container">     
            <button class="go-back-home" onclick="location.href='home.php';">Go back home</button>
        </div>
        
    </main>
    <?php include("footer.php"); ?>
</body>
</html>

