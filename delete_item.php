<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

if (isset($_GET['id'])) {
    $item_id = intval($_GET['id']); //get always comes as string thats why use intval

    $conn = new mysqli('localhost', 'root', '', 'restaurant');
    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->bind_param("i", $item_id);

    if ($stmt->execute()) {
        header("Location: adashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
