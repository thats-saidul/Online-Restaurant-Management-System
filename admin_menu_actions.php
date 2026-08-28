<?php

session_start();

if (!isset($_SESSION['admin'])) {
    die("Access denied. Please login as admin.");
}

$conn = new mysqli('localhost', 'root', '', 'restaurant');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$action = $_GET['action'] ?? ''; //'' provide a default value, ?? If the variable exists and is not null

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);

    $stmt = $conn->prepare("INSERT INTO menu (name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $price);
    $stmt->execute();
    $stmt->close();
    header("Location: adashboard.php");
    exit();

} elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("UPDATE menu SET price = ? WHERE id = ?");
    $stmt->bind_param("di", $price, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: adashboard.php");
    exit();

} elseif ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: adashboard.php");
    exit();
} else {
    echo "Invalid action.";
}

$conn->close();
?>
