<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'restaurant');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : '';

    if ($type === 'customer') {
        $stmt = $conn->prepare("DELETE FROM customers WHERE ID = ?");
    } elseif ($type === 'rider') {
        $stmt = $conn->prepare("DELETE FROM riders WHERE id = ?");
    } else {
        exit("Invalid user type.");
    }

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
header("Location: adashboard.php");
exit();
