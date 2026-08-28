<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'restaurant');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username']);
    $newPassword = $_POST['password'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $adminId = $_SESSION['admin']['id'];

    $stmt = $conn->prepare("UPDATE admins SET username = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $newUsername, $hashedPassword, $adminId);

    if ($stmt->execute()) {
        echo "<div class='success'>Admin info updated successfully!</div>";
        $_SESSION['admin']['fullname'] = $newUsername;
    } else {
        echo "<div class='error'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Admin Info</title>
    <link rel="stylesheet" href="css/aupdate.css">
    <link rel="icon" type="image/png" href="images/favicon.png">

    <style>
       
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Update Admin Info</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="New Username" required><br>
            <input type="password" name="password" placeholder="New Password" required><br>
            <button type="submit">Update</button>
        </form>
        <a href="adashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
