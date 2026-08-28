<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        echo "Password do not match";
        header("refresh: 2; url = customer_register.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $conn = new mysqli('localhost', 'root', '', 'restaurant');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $checkStmt->close();
        $conn->close();
        echo "User already exist with this email...";
        header("refresh: 2; url = customer_register.php");
        exit();
    }
    $checkStmt->close();

    $stmt = $conn->prepare("INSERT INTO customers (fullname, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $email, $phone, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration Successfully!!";
        header("refresh: 2; url = index.php");
        exit();
    } else {
        header("Location: customer_register.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
