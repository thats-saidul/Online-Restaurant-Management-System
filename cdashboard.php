<?php
session_start();

if (!isset($_SESSION['customer'])) {
    header("Location: customer.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'restaurant');
$menu = $conn->query("SELECT * FROM menu");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fresco & Flame</title>
      <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="css/cdashboard.css">
</head>
<body>

<!-- Top Bar -->
<div class="top-bar">
    <div class="logo">
        <img src="images/logo.png">
        <span class="brand-name">Fresco & Flame</span>
    </div>
    <div class="nav-links">
        <a href="update_customer.php">👤 Update Info</a>
        <a href="cart.php">
            <img src="images/cart.png" class="cart-icon">
            <!-- <span id="cart-count">0</span> -->
        </a>
        <a href="logout.php">↪ Logout</a>
    </div>
</div>

<!-- Slideshow Section -->
<div class="slideshow-container">
    <img class="slide" src="images/slide1.jpg" alt="Slide 1">
    <img class="slide" src="images/slide2.jpg" alt="Slide 2">
    <img class="slide" src="images/slide3.jpg" alt="Slide 3">
    <img class="slide" src="images/slide4.jpg" alt="Slide 4">
    <img class="slide" src="images/slide5.jpg" alt="Slide 5">
    <img class="slide" src="images/slide6.jpg" alt="Slide 6">
    <img class="slide" src="images/slide7.jpg" alt="Slide 7">
</div>
<hr>
<h2>Menu</h2>

<div class="menu-container">
    <?php while ($row = $menu->fetch_assoc()) { ?>
        <div class="menu-item">
            <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['item_name']) ?>">
            <h3><?= htmlspecialchars($row['item_name']) ?></h3>
            <p>Price: <?= $row['price'] ?> tk</p>
            <a href="#" onclick="addToCart(<?= $row['id'] ?>)">Add to Cart</a>
        </div>
    <?php } ?>
</div>

<script>
    
function addToCart(id) {
    fetch('customer_cart_action.php?action=add&id=' + id)
        .then(response => response.text())
        .then(data => {
            alert("Item added to cart!");
            // updateCartCount();
        })
        .catch(() => alert("Error adding to cart."));
}

// function updateCartCount() {
//     const xhr = new XMLHttpRequest();
//     xhr.open("GET", "get_cart_count.php", true);
//     xhr.onload = function () {
//         if (xhr.status === 200) {
//             document.getElementById("cart-count").textContent = xhr.responseText;
//         }
//     };
//     xhr.send();
// }

// Slideshow
let slideIndex = 0;
const slides = document.getElementsByClassName("slide");

function showSlides() {
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) 
    {
        slideIndex = 1; 
    }
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 3000);
}
showSlides();
// updateCartCount();
</script>

<!-- Footer -->
<footer class="custom-footer">
    <div class="footer-container">
        <div class="footer-left">
            <h3>Contacts</h3>
            <p>🖂 Email: support@frescoflame.com</p>
            <p>🕻 Phone: +880 123 456 789</p>
            <p>☎ Fax: +880 987 654 321</p>

            <h3>Follow</h3>
            <div class="social">
                <span>𝕏 Twitter</span>
                <span>ⓕ Facebook</span>
                <span>🅾 Instagram</span>
                <span>▶ YouTube</span>
                <span>𝐆 Google</span>
            </div>
        </div>

        <div class="footer-right">
            <h3>Contact Us</h3>
            <form method="post">
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <textarea name="message" placeholder="Message" rows="4" required></textarea>
                <button type="submit" name="submit">Send</button>
            </form>
        </div>
    </div>
</footer>


<?php
if (isset($_POST['submit'])) {
    $myfile = fopen("footer.txt", "a");
    fwrite($myfile, "Name: " . $_POST['name'] . "\n");
    fwrite($myfile, "Email: " . $_POST['email'] . "\n");
    fwrite($myfile, "Message: " . $_POST['message'] . "\n");
    fclose($myfile);
    echo"<br>";
}
?>


</body>
</html>
