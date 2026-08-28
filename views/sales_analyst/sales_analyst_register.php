
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Analyst Register</title>
    
    <link rel="stylesheet" href="../../assets/css/sales_analyst_register.css?v=1.2">

    <script src="../../assets/js/validate.js" defer></script>
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <h2>Sales Analyst Registration</h2>
            <form action="../controllers/sales_analyst_controller.php?action=register" 
                  method="POST" onsubmit="return validateCustomerForm()">
                
                <div class="input-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="input-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter your phone" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>

                <div class="input-group">
                    <label for="cpassword">Confirm Password</label>
                    <input type="password" id="cpassword" name="cpassword" placeholder="Confirm password" required>
                </div>

                <button type="submit" class="btn-register">Register</button>

                <p class="login-link">Already have an account? 
                    <a href="sales_analyst_login.php">Login here</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
