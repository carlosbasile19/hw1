<?php
session_start();
include("functions_db.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login_home.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: home.php");
    exit;
}

$conn = connect_to_db();

$diary_id = $_GET["id"];
$diary = get_diary_by_id($conn, $diary_id);

if (!$diary && verify_property_user_diary($conn, $_SESSION["user_id"], $diary_id)) {
    header("Location: home.php");
    exit;
}

$entries = get_entries_by_diary_id($conn, $diary_id);

disconnect_from_db($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diary Entries</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="entries.css">
    <link rel="stylesheet" href="buttons.css">
   
    <script src="ajax_calls.js" defer></script>
   
</head>
<body>
    <?php include("header_home.php"); ?>
    <main>
        <h1>Diary: <?php echo $diary["title"]; ?></h1>
        <div class="entries-container">
        <?php if (count($entries) == 0): ?>
        <p>There are no entries yet! Add them.</p>
         <?php else: ?>
            <?php foreach ($entries as $entry): ?>
                <div class="entry">
                <div class="entry-name">
                    <a href="entry.php?id=<?php echo $entry['id']; ?>&diary_id=<?php echo $diary_id; ?>"><?php echo $entry['title']; ?></a>
                </div>
                    <div class="entry-actions">
                        <form action="modify_entry.php" method="get">
                            <input type="hidden" name="entry_id" value="<?php echo $entry['id']; ?>">
                            <input type="hidden" name="diary_id" value="<?php echo $diary_id ?>">
                            <button type="submit" class="modify-button">Modify</button>
                        </form>
                        <div class="button-container">
                            <button class="favorite-button" data-user="<?php echo $_SESSION["user_id"]; ?>" data-entry="<?php echo $entry['id']; ?>" >Add to favs!</button> 
                            <button class="delete-button-entry" data-redirect=0 data-diary="<?php echo $diary["id"] ?>" data-user="<?php echo $_SESSION["user_id"]; ?>" data-entry="<?php echo $entry['id']; ?>">Delete</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>

        </div>
        <div class="button-container">
                <form action="new_entry.php" method="get">
            <input type="hidden" name="diary_id" value="<?php echo $diary_id ?>">
         
               <button type="submit" >Add Entry</button>
          
        </form>
          
              <button  onclick="location.href='home.php';">Go back home</button>
           
        </div>
    </main>
    <?php include("footer.php"); ?>
</body>
</html>

