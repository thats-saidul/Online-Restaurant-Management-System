<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Rider Login</title>
  <link rel="stylesheet" href="../../assets/css/login.css">
  <link rel="icon" type="image/png" href="../../assets/images/favicon.png">
</head>
<body>
  <div class="login-container">
    <h2>Rider Login</h2>
    <form action="rider_login.php" method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="rider_register.php">Register</a></p>
  </div>
</body>
</html>
