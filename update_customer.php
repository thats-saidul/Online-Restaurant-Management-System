<?php

session_start();
if (!isset($_SESSION['customer'])) {
    header("Location: customer.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'restaurant');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$id = $_SESSION['customer']['id'];

$result = $conn->query("SELECT * FROM customers WHERE id = $id");
$customer = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE customers SET fullname=?, email=?, phone=?, password=? WHERE id=?");
    $stmt->bind_param("ssssi", $fullname, $email, $phone, $password, $id);

    if ($stmt->execute()) {
        $_SESSION['customer']['fullname'] = $fullname;
        header("Location: cdashboard.php");
        exit();
    } else {
        echo "Update failed: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Info</title>
    <link rel="stylesheet" href="css/update.css">
    <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

<div class="form-container">
    <h2>Update Profile</h2>
    <form method="POST">
        <label for="fullname">Full Name</label>
        <input type="text" name="fullname" value="<?= htmlspecialchars($customer['fullname']) ?>" required>

        <label for="email">E-mail</label>
        <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required>

        <label for="phone">Phone Number</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>" required>

        <label for="password">New Password</label>
        <input type="password" name="password" placeholder="New Password" required>

        <button type="submit">Update</button>
    </form>
    <a href="cdashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>
