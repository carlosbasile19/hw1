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

$entry_id = $_GET["id"];
$diary_id = $_GET["diary_id"];

if(verify_property_user_diary($conn, $_SESSION["user_id"], $diary_id)){
    $diary = get_diary_by_id($conn, $diary_id);
}
else{
    echo "not your diary";
    exit;
}


if(verify_property_diary_entry($conn, $diary_id, $entry_id)){
    $entry = get_entry_by_id($conn, $diary_id, $entry_id);
}
else{
    echo "not your entry";
    exit;
}

if (!$entry) {
    echo "Non esiste";
    exit;
}

disconnect_from_db($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entry - <?php echo $entry["title"]; ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="entry.css">
    <link rel="stylesheet" href="buttons.css">
    <script src="ajax_calls.js" defer></script>
</head>
<body>
    <?php include("header_home.php"); ?>
    <main>
        <h1>Entry: <?php echo $entry["title"]; ?></h1>
        <div class="entry-content">
            <p><?php echo $entry["content"]; ?></p>
            <p>Created At: <?php echo $entry["created_at"]; ?></p>
            <p>Updated At: <?php echo $entry["updated_at"]; ?></p>
        </div>
        <form action="modify_entry.php" method="get">
                            <input type="hidden" name="entry_id" value="<?php echo $entry['id']; ?>">
                            <input type="hidden" name="diary_id" value="<?php echo $diary_id ?>">
                           <div class="buttons-container">
                            <button type="submit" class="modify-button">Modify</button>
                            <button class="favorite-button" data-user="<?php echo $_SESSION["user_id"]; ?>" data-entry="<?php echo $entry['id']; ?>" >Add to favs!</button>                    
                            <button class="delete-button-entry" data-redirect=1 data-diary="<?php echo $diary["id"] ?>" data-user="<?php echo $_SESSION["user_id"]; ?>" data-entry="<?php echo $entry['id']; ?>">Delete</button>            
                            </div>
        </form>
        <div class="buttons-container">
            <button class="go-back-home" onclick="location.href='entries.php?id=<?php echo $diary['id'] ?>';">Go back</button>
        </div>
    </main>
    <?php include("footer.php"); ?>
</body>
</html>
