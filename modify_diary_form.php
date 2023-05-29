<!DOCTYPE html>
<html>
<head>
  <title>Modify Diary</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="input_data.css">
  <link rel="stylesheet" href="buttons.css">
  <link rel="stylesheet" href="footer.css">
</head>
<body>
    <?php include("header_home.php") ?>
  <main>
    <h1>Modify Diary</h1>
    <form method="post">
      <input type="hidden" name="diary_id" value="<?php echo $diary['id']; ?>">
      <div class="form-group">
        <label class="form-label" for="title">Title:</label>
        <input class="form-input" type="text" name="title" id="title" value="<?php echo $diary['title']; ?>" required>
      </div>
      <button class="btn btn-primary" type="submit">Save</button>
    </form>
  </main>
  <?php include("footer.php") ?>
</body>
</html>
