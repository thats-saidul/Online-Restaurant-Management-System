<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

//when when saving data across pages use session
//when insert, delete, update something use request method


if ($_SERVER['REQUEST_METHOD'] === 'POST') {       //return get, post
    $item_name = trim($_POST['item_name']);  //trim remove spaces
    $price = (float)$_POST['price'];

    
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {  //UPLOAD_ERR_OK means success
        $image_name = basename($_FILES['image']['name']); //basename removes any directory path and gives just the file name
        $target_dir = "images/"; //save image in this folder
        $target_file = $target_dir . time() . "_" . $image_name; //make unique file name remove duplicate names

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    //SQL Injection Protection, effeciency, easy to handle, type handling easy

    $conn = new mysqli('localhost', 'root', '', 'restaurant');
    $stmt = $conn->prepare("INSERT INTO menu (item_name, price, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $item_name, $price, $image_path);

    if ($stmt->execute()) {
        header("Location: adashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Menu Item</title>
<link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>
<h2>Add New Menu Item</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="item_name" placeholder="Item Name" required><br>
    <input type="number" step="0.01" name="price" placeholder="Price" required><br>
    <input type="file" name="image" accept="image/*" required><br>
    <button type="submit">Add Item</button>
</form>
<a href="adashboard.php">Back</a>
</body>
</html>