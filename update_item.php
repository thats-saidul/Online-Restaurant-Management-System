<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'restaurant');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $item_id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM menu WHERE id = $item_id");
    $item = $result->fetch_assoc();
}
 elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = intval($_POST['id']);
    $item_name = trim($_POST['item_name']);
    $price = (float)$_POST['price'];

    $stmt = $conn->prepare("UPDATE menu SET item_name=?, price=? WHERE id=?");
    $stmt->bind_param("sdi", $item_name, $price, $item_id);

    if ($stmt->execute()) {
        header("Location: adashboard.php");
        exit();
    } else {
        echo "Update failed: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Menu Item</title>
    <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>
<h2>Update Menu Item</h2>
<form method="POST">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    <input type="text" name="item_name" value="<?= htmlspecialchars($item['item_name']) ?>" required><br>
    <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($item['price']) ?>" required><br>
    <button type="submit">Update Item</button>
</form>
<a href="adashboard.php">Back</a>
</body>
</html>
