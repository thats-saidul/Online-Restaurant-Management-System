<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Customer Registration</title>
  <link rel="stylesheet" href="css/registration.css">
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>
  <div class="register-container">
    <h2>Registration</h2>
    <form action="customer_register_action.php" method="POST" onsubmit="return validateCustomerForm()">
      <input type="text" id="fullname" name="fullname" placeholder="Full Name" required>
      <input type="email" id="email" name="email" placeholder="Email" required>
      <input type="text" id="phone" name="phone" placeholder="Phone" required>
      <input type="password" id="password" name="password" placeholder="Password" required>
      <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
      <button type="submit">Register</button>
    </form>
    <a class="back-btn" href="index.php">Back</a>
  </div>

    <script src="validate.js"></script>
</body>
</html>
