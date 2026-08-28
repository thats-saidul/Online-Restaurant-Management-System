<?php

session_start();
if (!isset($_SESSION['admin'])) { //checking login
    header("Location: admin.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'restaurant');
$menu = $conn->query("SELECT * FROM menu");
$customers = $conn->query("SELECT * FROM customers");
$riders = $conn->query("SELECT * FROM riders");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="css/adashboard.css">
    <style>
    
    </style>
</head>
<body>

<div class="top-bar">
    <div class="logo">
        <img src="images/logo.png" alt="Fresco & Flame">
        <span>Fresco & Flame</span>
    </div>
 </div>


<div class="main-section">

<div class="sidebar">
    <h3>Admin Panel</h3>
    <ul>
        <li class="li"><a href="#users">👥 Users</a></li>
        <li class="li"><a href="#menu">📜 Menu</a></li>
        <li class="li"><a href="orders.php">📦 Orders</a></li>
        <li class="li"><a href="update_admin.php">👤 Update Info</a></li>
        <li class="li"><a href="alogout.php">↪ Logout</a></li>
    </ul>
</div>

<div class="content">
    <h2 id="users">User Details</h2>

    <h3 class="customer">Customers</h3>
    <ul class="user-list">
        <?php while ($row = $customers->fetch_assoc()) {  //full row accessing at a time ?> 
            <div class="hover">
            <li>
                <?= htmlspecialchars($row['fullname']) ?> (<?= htmlspecialchars($row['email']) //Safe from XSS attacks and It converts special characters to safe versions ?>)
                <form action="delete_user.php" method="POST" class="inline">
                    <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                     <input type="hidden" name="type" value="customer"> <!-- submitting form and hide it from the user -->
                    <button type="submit" class="button delete-btn">Remove</button>
                </form>
            </li>
            </div>
        <?php } ?>
    </ul>

    <h3 class="rider">Riders</h3>
    <ul class="user-list">
        <?php while ($row = $riders->fetch_assoc()) { ?>
            <div class="hover">
            <li>
                <?= htmlspecialchars($row['fullname']) ?> (<?= htmlspecialchars($row['email']) ?>)
                <form action="delete_user.php" method="POST" class="inline">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="type" value="rider">
                    <button type="submit" class="button delete-btn">Remove</button>
                </form>
            </li>
            </div>
        <?php } ?>
    </ul>

    <h2 id="menu">Menu Management</h2>
    <form class="add-menu" action="add_item.php" method="POST" enctype="multipart/form-data"> <!-- uploading images -->
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required> <!-- step: Allows decimal values-->
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" class="button">Add Item</button>
    </form>

    <ul class="menu-list">
        <?php while ($item = $menu->fetch_assoc()) { ?>
            <div class="hover">
            <li class="menu-item">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['item_name']) ?>">
                <strong><?= htmlspecialchars($item['item_name']) ?></strong> - $<?= htmlspecialchars($item['price']) ?> <!-- stong make text bold-->
                <form action="admin_menu_actions.php?action=update" method="POST" class="inline"> <!-- doesn't use button name that's why set action name update  -->
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <input type="number" step="0.01" name="price" value="<?= $item['price'] ?>" required>
                    <button  type="submit" class="button">⚙︎ Update</button>
                </form>
                <form action="admin_menu_actions.php?action=delete" method="POST" class="inline">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <button type="submit" class="button delete-btn">Delete</button>
                </form>
            </li>
            </div>
        <?php } ?>
    </ul>
</div>
</div>
</body>
</html>
