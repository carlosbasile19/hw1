<!DOCTYPE html>
<html>
<head>
  <title>Modify Entry</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="footer.css">
  <link rel="stylesheet" href="input_data.css">
  <link rel="stylesheet" href="buttons.css">
</head>
<body>
    <?php include("header_home.php") ?>
  <main>
    <h1>Modify Entry:</h1>
    <form action="modify_entry.php" method="post">
            <input type="hidden" name="diary_id" value="<?php echo $diary_id; ?>">
            <input type="hidden" name="entry_id" value="<?php echo $entry_id; ?>">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo $entry['title']; ?>" required>  
            <label for="content">Content</label>
            <textarea id="content" name="content" rows="10" cols="50" required><?php echo $entry['content']; ?></textarea>
            <button type="submit">Modify Entry</button>
    </form>
  </main>
  <?php include("footer.php") ?>
</body>
</html>
