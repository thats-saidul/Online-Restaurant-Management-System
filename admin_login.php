<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'restaurant');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, fullname, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $fullname, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['admin'] = ["id" => $id, "fullname" => $fullname];
            header("Location: adashboard.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No admin found with that username.";
        header("refresh: 2; url = admin.php");
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
