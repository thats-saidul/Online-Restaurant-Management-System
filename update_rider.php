<?php
session_start();

if (!isset($_SESSION['rider'])) {
    header("Location: ../../views/auth/rider_login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'restaurant');
$rider = $_SESSION['rider'];

// Prevent warnings
$fullnameValue = isset($rider['fullname']) ? htmlspecialchars($rider['fullname']) : ''; //'' provide a default value
$emailValue = isset($rider['email']) ? htmlspecialchars($rider['email']) : '';
$phoneValue = isset($rider['phone']) ? htmlspecialchars($rider['phone']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $id = $rider['id'];

    $stmt = $conn->prepare("UPDATE riders SET fullname=?, email=?, phone=?, password=? WHERE id=?");
    $stmt->bind_param("ssssi", $fullname, $email, $phone, $password, $id);

    if ($stmt->execute()) {
        $_SESSION['rider']['fullname'] = $fullname;
        $_SESSION['rider']['email'] = $email;
        $_SESSION['rider']['phone'] = $phone;
        header("Location: rdashboard.php");
        exit();
    } else {
        echo "Update failed: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Rider Info</title>
    <link rel="stylesheet" href="../../assets/css/update.css">
    <link rel="icon" type="image/png" href="../../assets/images/Images/favicon.png">

</head>
<body>
<div class="form-container">
    <h2>Update Profile</h2>
    <form method="POST">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" value="<?= $fullnameValue ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= $emailValue ?>" required>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?= $phoneValue ?>" required>

        <label for="password">New Password</label>
        <input type="password" id="password" name="password" placeholder="New Password" required>

        <button type="submit">Update</button>
    </form>
    <a href="rdashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>
