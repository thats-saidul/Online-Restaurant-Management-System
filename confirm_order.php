<?php
session_start();
if (!isset($_SESSION['customer'])) {
    header("Location: ../../views/auth/customer_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['location']) && !empty($_SESSION['cart'])) {
    $location = trim($_POST['location']);
    $customerId = $_SESSION['customer']['id'];
    $items = $_SESSION['cart']; // Format: [item_id => quantity]

    $conn = new mysqli('localhost', 'root', '', 'restaurant');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $total_price = 0;

    foreach ($items as $itemId => $quantity) {
        $itemId = (int)$itemId;
        $quantity = (int)$quantity;

        if ($itemId > 0 && $quantity > 0) {
            $stmt = $conn->prepare("SELECT price FROM menu WHERE id = ?");
            $stmt->bind_param("i", $itemId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $total_price += floatval($row['price']) * $quantity;
            }

            $stmt->close();
        }
    }

    if ($total_price > 0) {
        $itemsJson = json_encode($items);

        $stmt = $conn->prepare("INSERT INTO orders (customer_id, location, items, total_price, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->bind_param("issd", $customerId, $location, $itemsJson, $total_price);

        if ($stmt->execute()) {
            unset($_SESSION['cart']);
            header("Location: cdashboard.php");
            exit();
        } else {
            echo "Failed to place order: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Cart total is zero. Cannot place order.";
    }

    $conn->close();
} else {
    echo "Invalid request or cart is empty.";
}
?>
