<?php
session_start();
require_once __DIR__ . '/../../models/SalesAnalyst.php';

if (!isset($_SESSION['sales_analyst_id'])) {
    header("Location: sales_analyst_login.php");
    exit;
}

$model = new SalesAnalyst();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $password = $_POST['password'];

    $success = $model->updateProfile(
        $_SESSION['sales_analyst_id'],
        $fullname,
        $email,
        $phone,
        $password
    );

    if ($success) {
        $_SESSION['sales_analyst_name'] = $fullname;
        $message = "Profile updated successfully.";
    } else {
        $message = "Incorrect password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="../../assets/css/edit_profile.css">
</head>
<body>

<div class="dashboard-container">
    <h2>Edit Personal Information</h2>

    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="fullname" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone</label>
        <input type="text" name="phone" required>

        <label>Confirm Password</label>
        <input type="password" name="password" required>

        <button type="submit">Update Profile</button>
    </form>

    <br>
    <a href="dashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>