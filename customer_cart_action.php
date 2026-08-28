<?php

session_start();
if (!isset($_SESSION['customer'])) {
    header("Location: customer.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += 1;
    } else {
        $_SESSION['cart'][$id] = 1;
    }

    header("Location: cart.php");
    exit();
} else {
    echo "Invalid action.";
}
?>
