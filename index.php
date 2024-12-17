<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Madeups Warehousing Software</h1>
    <form action = 'form_process/loginprocess.php' method="post" >
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" class="form-field" required>
	  <label for="password">Password:</label>
	  <input type="password" id="password" name="password" class="form-field" required>
	  <input type="submit" value="Submit">
      <label for="message" id="message"></label>
	</form>
    <a href="register.php" class="register-link">Don't have an account? Register Here</a>
  </div>
  <?php
if (isset($_SESSION['message'])) {
  echo '<script>document.getElementById("message").innerHTML = "'.htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8').'";</script>';
  unset($_SESSION['message']);
}
?>
</body>
</html> 