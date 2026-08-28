<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rider Registration</title>
  <link rel="stylesheet" href="../../assets/css/registration.css">
  <link rel="icon" type="image/png" href="../../assets/images/Images/favicon.png">


</head>
<body>
  <div class="register-container">
    <h2>Register as Rider</h2>
    <form action="rider_register_action.php" method="POST" onsubmit="return validateRiderForm()">
      <input type="text" id="fullname" name="fullname" placeholder="Full Name" required>
      <input type="email" id="email" name="email" placeholder="Email" required>
      <input type="text" id="phone" name="phone" placeholder="Phone" required>
      <input type="password" id="password" name="password" placeholder="Password" required>
      <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
      <button type="submit">Register</button>
    </form>
    <a href="../rider/rider.php" class="back-btn">Back</a>
  </div>

  <script src="../../assets/js/validate.js"></script>

</body>
</html>
