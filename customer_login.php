<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'restaurant');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT ID, fullname, password FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $fullname, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['customer'] = ["id" => $id, "fullname" => $fullname];
            header("Location: cdashboard.php");
            exit();
        } else {
            echo "Invalid password.";
            header("refresh: 2; url = index.php");
        }
    } else {
        echo "No account found with this email.";
        header("refresh: 2; url = index.php");
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
