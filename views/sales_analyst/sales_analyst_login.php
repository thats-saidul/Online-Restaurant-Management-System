<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Analyst Login</title>
    <link rel="stylesheet" href="../../assets/css/sales_analyst_login.css">
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>Sales Analyst Login</h2>

        <?php
        if (isset($_SESSION['login_error'])) {
            echo '<p style="color:red;margin-bottom:15px;">' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']);
        }
        ?>

        <form action="../../controllers/sales_analyst_controller.php?action=login" method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="extra-actions">
            <a href="../../views/sales_analyst/sales_analyst_register.php" class="btn-register">
                Register as Sales Analyst
            </a>

            <p class="forgot-password">
                <a href="#">Forgot Password?</a>
            </p>
        </div>

    </div>
</div>

</body>
</html>



