<?php

session_start();
if (!isset($_SESSION['rider'])) {
    header("Location: ../../views/auth/rider_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $orderId = (int)$_GET['id'];
    $riderId = $_SESSION['rider']['id'];

    $conn = new mysqli('localhost', 'root', '', 'restaurant');

    $stmt = $conn->prepare("UPDATE orders SET status = 'accepted', rider_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $riderId, $orderId);

    if ($stmt->execute()) {
        header("Location: rdashboard.php");
        exit();
    } else {
        echo "Failed to accept delivery: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
