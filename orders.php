<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'restaurant');

$orders = $conn->query("
    SELECT o.id, o.customer_id, o.items, o.location, o.status, c.fullname
    FROM orders o
    JOIN customers c ON o.customer_id = c.ID
    ORDER BY o.id DESC
");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <link rel="stylesheet" href="css/orders.css">
    <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

<div class="orders-container">
    <h2>All Orders</h2>
    <table class="orders-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Items (Qty)</th>
                <th>Total Price</th>
                <th>Location</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $serial = 1;
            while ($row = $orders->fetch_assoc()) : ?>
                <tr>
                    <td><?= $serial++ ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td>
                        <?php
                        $items = json_decode($row['items'], true);
                        foreach ($items as $id => $quantity) {
                            $item_result = $conn->query("SELECT item_name FROM menu WHERE id = $id");
                            if ($item_result && $item = $item_result->fetch_assoc()) {
                                echo htmlspecialchars($item['item_name']) . " ($quantity)<br>";
                            } else {
                                echo "Unknown Item ($quantity)<br>";
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $total = 0;
                        foreach ($items as $id => $quantity) {
                            $price_result = $conn->query("SELECT price FROM menu WHERE id = $id");
                            if ($price_result && $price_row = $price_result->fetch_assoc()) {
                                $total += $price_row['price'] * $quantity;
                            }
                        }
                        echo $total . " tk";
                        ?>
                    </td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="back-btn-container">
        <a href="adashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>

