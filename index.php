<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fresco & Flame</title>
  <link rel="icon" type="image/png" href="./assets/pic/Images/favicon.png">
  <link rel="stylesheet" href="./assets/css/login.css">
</head>
<body>
  <div class="login-container">
    <h2>Customer Login</h2>

    <form action=".customer_login.php" method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <p>Don't have an account?
      <a href="./views/auth/customer_register.php">Register</a>
    </p>

 
    <div class="divider">OR</div>

    <a href="./views/sales_analyst/sales_analyst_login.php" class="alt-btn analyst-btn">
      Sales Analyst Login
    </a>


  </div>
</body>
</html>

