<?php
    
    session_start();
    include('functions_db.php');

    if (!isset($_SESSION['user_id'])) {
        header('Location: login_home.php');
        exit;
    }

    $conn = connect_to_db();

    $diaries = get_diaries_by_user_id($conn, $_SESSION['user_id']);

    disconnect_from_db($conn);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obsidian Memories - Home</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="buttons.css">
    <script src="ajax_calls.js" defer></script>
</head>

<body>
<?php include("header_home.php") ?>
    <main>
        <h1>Welcome to Obsidian.</h1>
        <p>In this place you're going to be able to commit your memories, forever.</p>

        <h2>Your Diaries</h2>
        <div class="diaries-container">
            <div class="diary-row diary-header-row">
                <div class="diary-name">Name</div>
                <div class="diary-actions">Actions</div>
            </div>
            <?php if (isset($_GET["diary_error"])): ?>
                 <p>ERROR CREATING DIARY!</p>
            <?php endif; ?>
            <?php if (count($diaries) == 0): ?>
                 <p>There are no diaries yet! Add them.</p>
         <?php else: ?>
            <?php foreach ($diaries as $diary): ?>
                <div class="diary-row">
                    <div class="diary-name"><a href="entries.php?id=<?php echo $diary['id']; ?>"><?php echo $diary['title']; ?></a></div>
                    <div class="button-container">
                        <form action="modify_diary.php" method="get">
                          <input type="hidden" name="id" value="<?php echo $diary['id']; ?>">
                          <button>Edit</button>
                        </form>                     
                        <button class="delete-button-diary" data-user="<?php echo $_SESSION['user_id']; ?>" data-diary-id="<?php echo $diary['id']; ?>">Delete</button>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="button-container">
            <form action="new_diary.php" method="get">
                <button >Add Diary</button>
            </form>
            <form action="favorite_entries.php" method="get">
                <button>Favorite Entries</button>
            </form>
            <form action="delete_account.php" method="post">
                    <button class="delete-button-account">DELETE ACCOUNT</button>
            </form>
        </div>


    </main>


<?php include("footer.php") ?>
</body>

</html>
