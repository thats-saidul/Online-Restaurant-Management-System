<?php
session_start();

if (!isset($_SESSION['customer'])) {
    header("Location: customer.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$conn = new mysqli('localhost', 'root', '', 'restaurant');
$total = 0;
$cart_items = [];

// Remove item from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    if (isset($_SESSION['cart'][$remove_id])) {  //cart id = 3
        unset($_SESSION['cart'][$remove_id]);
    }
}

// Confirm order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['location'])) {
    $customer_id = $_SESSION['customer']['id'];
    $location = $_POST['location'];
    $items = json_encode($_SESSION['cart']);
    $status = 'pending';

    $stmt = $conn->prepare("INSERT INTO orders (customer_id, items, location, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $customer_id, $items, $location, $status);

    if ($stmt->execute()) {
        $_SESSION['cart'] = [];
        echo "<script>alert('Order placed successfully!');window.location='cdashboard.php';</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Prepare cart items for display
foreach ($_SESSION['cart'] as $id => $qty) {
    $result = $conn->query("SELECT * FROM menu WHERE id = $id");
    if ($row = $result->fetch_assoc()) {
        $row['quantity'] = $qty;
        $row['subtotal'] = $qty * $row['price'];
        $total += $row['subtotal'];
        $cart_items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/cart.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>
<div class="container">
    <h2>Your Cart</h2>
    <?php if (empty($cart_items)) : ?>
        <p>Your cart is empty.</p>
    <?php else : ?>
        <table>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
            <?php foreach ($cart_items as $item): ?> 
                <tr>
                    <td><?= htmlspecialchars($item['item_name']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $item['price'] ?> tk</td>
                    <td><?= $item['subtotal'] ?> tk</td>
                    <td><a href="?remove=<?= $item['id'] ?>" style="color: red;">Remove</a></td>
                </tr>
            <?php endforeach; ?> <!-- didn't use curly braces {} that's why use endforeach -->
        </table>
        <p class="total">Total Bill: <?= $total ?> tk</p>
        <form method="POST">
            <label>Enter your delivery location:</label><br>
            <textarea name="location" required></textarea><br>
            <button type="submit">Confirm Order</button>
        </form>
    <?php endif; ?>  <!-- did not use curly braces {} that's why use endif -->
    <a href="cdashboard.php">← Back to Menu</a>
</div>
</body>
</html>
