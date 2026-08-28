<?php

session_start();
if (!isset($_SESSION['rider'])) {
    header("Location: ../auth/rider_login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'restaurant');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rider_id = $_SESSION['rider']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accept'])) {
    $order_id = intval($_GET['accept']);
    $stmt = $conn->prepare("UPDATE orders SET status='accepted', rider_id=? WHERE id=? AND status='pending'");
    $stmt->bind_param("ii", $rider_id, $order_id);
    $stmt->execute();
    $stmt->close();
    header("Location: rdashboard.php");
    exit();
}

$orders = $conn->query("
    SELECT o.id, o.items, o.location, c.fullname, c.phone 
    FROM orders o 
    JOIN customers c ON o.customer_id = c.ID 
    WHERE o.status = 'pending'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rider Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/rdashboard.css">
    <link rel="icon" type="image/png" href="../../assets/images/Images/favicon.png">
</head>
<body>

<div class="top-bar">
    <div class="logo">
        <img src="../../assets/images/Images/logo.png" alt="Fresco & Flame">
        <span>Fresco & Flame</span>
    </div>
    <div class="nav-links">
        <a href="update_rider.php">👤 Update Profile</a>
        <a href="../auth/rlogout.php" class="logout">↪ Logout</a>
    </div>
</div>

<h2>Welcome, <?= htmlspecialchars($_SESSION['rider']['fullname']) ?></h2>

<?php if ($orders->num_rows > 0): ?>
    <h3>Available Deliveries</h3>
    <table>
        <tr>
            <th>Customer Name</th>
            <th>Phone</th>
            <th>Items</th>
            <th>Location</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $orders->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['fullname']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td>
                <?php
                $items = json_decode($row['items'], true);
                foreach ($items as $itemId => $qty) {
                    $stmt = $conn->prepare("SELECT item_name FROM menu WHERE id = ?");
                    $stmt->bind_param("i", $itemId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($item = $result->fetch_assoc()) {
                        echo htmlspecialchars($item['item_name']) . " ($qty)<br>";
                    }
                    $stmt->close();
                }
                ?>
            </td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><a href="?accept=<?= $row['id'] ?>">Accept ✓</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No delivery available at this moment.</p>
<?php endif; ?>



</body>
</html>
