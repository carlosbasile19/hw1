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
    <title>Signup</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="forms.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <script src="validations.js"></script>
</head>
<body>
    <?php include("header.php") ?>

    <div class="container">
    <form class="form" action="register.php" method="post" onsubmit="return validateForm()">
      <h1>Create an account</h1>
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="last_name">Last Name:</label>
      <input type="text" id="last_name" name="last_name" required>

      <label for="email">Email:</label>
      <input type="text" id="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" required>

      <button type="submit">Create account</button>

      <?php if (isset($_GET["email_used"])): ?>
        <p>Email already registered. Please try with another one.</p>
      <?php endif; ?>

      <?php if (isset($_GET["registration_error"])): ?>
        <p>Error creating account, try again.</p>
      <?php endif; ?>

      <?php if (isset($_GET["password_error"])): ?>
        <p>Passwords do not match.</p>
      <?php endif; ?>
    </form>
  </div>

    <?php include("footer.php") ?>

</body>
</html>
