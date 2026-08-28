<?php
session_start();
require_once __DIR__ . '/../../models/SalesAnalyst.php';

if (!isset($_SESSION['sales_analyst_id'])) {
    header("Location: sales_analyst_login.php");
    exit;
}

$model = new SalesAnalyst();
$stats = $model->getDashboardStats();
$customers = $model->getCustomersStats();
$areas = $model->getDeliveryAreas();
$riders = $model->getRiderActivity();
$top_items = $model->getTopSellingItems();
$profile = $model->getProfileInfo($_SESSION['sales_analyst_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Analyst Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>

<!-- Navigation Bar -->
<div class="top-bar">
    <h1>Sales Analyst Dashboard</h1>
    <div class="nav-actions">
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['sales_analyst_name']); ?>!</span>
        <a href="edit_profile.php" class="btn-profile">Edit Profile</a>
        <a href="../../controllers/sales_analyst_controller.php?action=logout" class="btn-logout">Logout</a>
    </div>
</div>

<!-- Dashboard Cards -->
<div class="dashboard-container">
    <div class="profile-summary">
        <div class="profile-card">
            <div>
                <h3><?php echo htmlspecialchars($profile['fullname']); ?></h3>
                <p><?php echo htmlspecialchars($profile['email']); ?></p>
                <p><?php echo htmlspecialchars($profile['phone']); ?></p>
            </div>
        </div>
        <br>
        <div class="cards">
            <div class="card card-users">
                <h2><?php echo $stats['total_users']; ?></h2>
                <p>Total Active Users</p>
            </div>
            <div class="card card-items">
                <h2><?php echo $stats['total_items']; ?></h2>
                <p>Total Items in Stock</p>
            </div>
            <div class="card card-riders">
                <h2><?php echo $stats['total_riders']; ?></h2>
                <p>Total Riders</p>
            </div>
            <div class="card card-sales">
                <h2><?php echo number_format($stats['total_sales'], 2); ?> ৳</h2>
                <p>Total Sales</p>
            </div>
        </div>

        <!-- FEATURE BUTTONS -->
        <div class="feature-buttons">
            <a href="#" class="feature-btn" onclick="toggleSection('customers-section')">Show Customers</a>
            <a href="#" class="feature-btn" onclick="toggleSection('delivery-monitoring')">Delivery Monitoring</a>
            <a href="#" class="feature-btn" onclick="toggleSection('top-items')">Top Selling Items</a>
            <a href="#" class="feature-btn" onclick="toggleSection('revenue-section')">Revenue & Rider Salary</a>
        </div>

        <!-- CUSTOMER TABLE -->
        <div id="customers-section" class="feature-section hidden">
            <h2>Customer Statistics</h2>
            <table class="feature-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Orders (Frequency)</th>
                        <th>Total Spent (৳)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $index => $c): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($c['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($c['email']); ?></td>
                        <td><?php echo htmlspecialchars($c['phone']); ?></td>
                        <td><?php echo $c['order_count']; ?></td>
                        <td><?php echo number_format($c['total_spent'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- DELIVERY MONITORING -->
        <div id="delivery-monitoring" class="feature-section hidden">
            <h2>Delivery Monitoring</h2>
            <div id="popular-areas">
                <h3>Most Orders by Area</h3>
                <table class="feature-table">
                    <thead>
                        <tr><th>Area</th><th>Orders Count</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($areas as $area): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($area['location']); ?></td>
                            <td><?php echo $area['order_count']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="rider-activity">
                <h3>Riders Activity</h3>
                <table class="feature-table">
                    <thead>
                        <tr><th>Rider</th><th>Orders Accepted</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riders as $r): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($r['fullname']); ?></td>
                            <td><?php echo $r['orders_count']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TOP SELLING ITEMS -->
        <div id="top-items" class="feature-section hidden">
            <h2>Top Selling Items</h2>
            <table class="feature-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Total Orders</th>
                        <th>Total Quantity Sold</th>
                        <th>Total Sales (৳)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($top_items)): ?>
                        <?php foreach ($top_items as $index => $item): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo $item['total_orders']; ?></td>
                                <td><?php echo $item['total_quantity']; ?></td>
                                <td><?php echo number_format($item['total_sales'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No items sold yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- REVENUE & RIDER SALARY (Dynamic with Ajax) -->
        <div id="revenue-section" class="feature-section hidden">
            <h2>Revenue & Rider Salary</h2>
            <button id="refresh-revenue" class="feature-btn">Refresh Data</button>
            <div id="revenue-content">
                <p>Loading data...</p>
            </div>
        </div>
    </div>
</div>

<!-- JS to toggle sections -->
<script>
function toggleSection(id) {
    const section = document.getElementById(id);
    section.classList.toggle('hidden');
    section.scrollIntoView({ behavior: 'smooth' });
}

// --- Ajax to fetch revenue & rider salary ---
document.addEventListener("DOMContentLoaded", () => {
    const refreshBtn = document.getElementById("refresh-revenue");
    const revenueContent = document.getElementById("revenue-content");

    async function loadRevenue() {
        revenueContent.innerHTML = "<p>Loading data...</p>";
        try {
            const response = await fetch("../../controllers/get_revenue.php");
            const data = await response.json();

            if (data.error) {
                revenueContent.innerHTML = `<p style="color:red;">${data.error}</p>`;
                return;
            }

            let html = `<p><strong>Total Net Revenue:</strong> ${Number(data.total_revenue).toLocaleString()} ৳</p>`;
            html += `<h3>Rider Salaries</h3>`;
            html += `<table class="feature-table">
                        <thead>
                            <tr><th>Rider</th><th>Total Salary (৳)</th></tr>
                        </thead><tbody>`;

            for (let riderId in data.rider_costs) {
                const rider = data.rider_costs[riderId];
                html += `<tr>
                            <td>${rider.fullname}</td>
                            <td>${Number(rider.salary).toLocaleString()}</td>
                        </tr>`;
            }

            html += `</tbody></table>`;
            revenueContent.innerHTML = html;

        } catch (err) {
            revenueContent.innerHTML = `<p style="color:red;">Failed to load data</p>`;
            console.error(err);
        }
    }

    // Load on page load
    loadRevenue();

    // Refresh button
    refreshBtn.addEventListener("click", loadRevenue);
});
</script>

</body>
</html>





