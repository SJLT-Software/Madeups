

<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <h1>Madeups Warehousing Software</h1>
    <form action="form_process/registerprocess.php" method="POST">
    <label for="name">Name:</label>
      <input type="text" id="name" name="name" class="form-field" required>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" class="form-field" required>
	  <label for="password">Password:</label>
	  <input type="password" id="password" name="password" class="form-field" required>
	  <input type="submit" value="Register">
	</form>
    <a href="index.php" class="register-link">Have an account? Login Here</a>
  </div>
  <?php
session_start();
if (isset($_SESSION['error'])) {
  echo "<script>alert('".htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8')."');</script>";    
  unset($_SESSION['error']);
}
?>
</body>
</html> 