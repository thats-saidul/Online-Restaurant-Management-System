<?php
require_once __DIR__ . '/../config/db.php';

class SalesAnalyst {

    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    /* LOGIN */
    public function authenticate($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM sales_analysts WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    /* REGISTER */
    public function register($data) {
        $fullname = trim($data['fullname']);
        $email    = trim($data['email']);
        $phone    = trim($data['phone']);
        $password = password_hash($data['password'], PASSWORD_BCRYPT);

        // check duplicate email
        $check = $this->conn->prepare("SELECT id FROM sales_analysts WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            die("Email already exists");
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO sales_analysts (fullname, email, phone, password) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $fullname, $email, $phone, $password);
        $stmt->execute();
    }

    /* DASHBOARD STATS */
    public function getDashboardStats() {
        $stats = [];

        // Total active users
        $result = $this->conn->query("SELECT COUNT(*) as count FROM customers");
        $stats['total_users'] = $result->fetch_assoc()['count'];

        // Total items in stock
        $result = $this->conn->query("SELECT COUNT(*) as count FROM menu");
        $stats['total_items'] = $result->fetch_assoc()['count'];

        // Total riders
        $result = $this->conn->query("SELECT COUNT(*) as count FROM riders");
        $stats['total_riders'] = $result->fetch_assoc()['count'];

        // Total sales (sum of prices * quantity for accepted orders)
        $total_sales = 0;
        $orders = $this->conn->query("SELECT items FROM orders WHERE status='accepted'");
        while ($order = $orders->fetch_assoc()) {
            $items = json_decode($order['items'], true);
            foreach ($items as $item_id => $qty) {
                $price_row = $this->conn->query("SELECT price FROM menu WHERE id=$item_id")->fetch_assoc();
                $total_sales += $price_row['price'] * $qty;
            }
        }
        $stats['total_sales'] = $total_sales;

        return $stats;
    }

    public function getCustomersStats() {
    global $conn;
    $sql = "SELECT * FROM customers";
    $result = $conn->query($sql);
    $customers = [];

    while ($c = $result->fetch_assoc()) {
        // Get orders for customer
        $orders_sql = "SELECT items FROM orders WHERE customer_id = {$c['ID']} AND status='accepted'";
        $orders_result = $conn->query($orders_sql);
        $total_spent = 0;
        $order_count = $orders_result->num_rows;

        while ($order = $orders_result->fetch_assoc()) {
            $items = json_decode($order['items'], true);
            foreach ($items as $menu_id => $qty) {
                $price_sql = "SELECT price FROM menu WHERE id=$menu_id LIMIT 1";
                $price_result = $conn->query($price_sql);
                $price_row = $price_result->fetch_assoc();
                $total_spent += $price_row['price'] * $qty;
            }
        }

        $c['order_count'] = $order_count;
        $c['total_spent'] = $total_spent;
        $customers[] = $c;
    }

    // Sort by total_spent DESC
    usort($customers, function($a, $b) {
        return $b['total_spent'] <=> $a['total_spent'];
    });

    return $customers;
}

    // Delivery areas
public function getDeliveryAreas() {
    global $conn;
    $sql = "SELECT location, COUNT(*) as order_count 
            FROM orders 
            WHERE status='accepted'
            GROUP BY location
            ORDER BY order_count DESC";
    $result = $conn->query($sql);
    $areas = [];
    while ($row = $result->fetch_assoc()) {
        $areas[] = $row;
    }
    return $areas;
}

// Rider activity
public function getRiderActivity() {
    global $conn;
    $sql = "SELECT r.fullname, COUNT(o.id) as orders_count
            FROM riders r
            LEFT JOIN orders o ON r.id = o.rider_id AND o.status='accepted'
            GROUP BY r.id
            ORDER BY orders_count DESC";
    $result = $conn->query($sql);
    $riders = [];
    while ($row = $result->fetch_assoc()) {
        $riders[] = $row;
    }
    return $riders;
}

    public function getTopSellingItems() {
    $items = [];

    // Fetch all accepted orders
    $stmt = $this->conn->prepare("SELECT items FROM orders WHERE status='accepted'");
    $stmt->execute();
    $result = $stmt->get_result();

    $itemCounts = []; // key = menu_id, value = ['total_orders'=>x, 'total_quantity'=>y]

    while ($row = $result->fetch_assoc()) {
        $orderItems = json_decode($row['items'], true);
        if (is_array($orderItems)) {
            foreach ($orderItems as $menu_id => $qty) {
                if (!isset($itemCounts[$menu_id])) {
                    $itemCounts[$menu_id] = ['total_orders' => 0, 'total_quantity' => 0];
                }
                $itemCounts[$menu_id]['total_orders'] += 1;
                $itemCounts[$menu_id]['total_quantity'] += $qty;
            }
        }
    }

    if (!empty($itemCounts)) {
        // Fetch item names and prices from menu table
        $ids = array_keys($itemCounts);
        $ids_placeholder = implode(',', $ids); // e.g., 2,3,5

        $stmt2 = $this->conn->prepare("SELECT id, item_name, price FROM menu WHERE id IN ($ids_placeholder)");
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        while ($row = $result2->fetch_assoc()) {
            $id = $row['id'];
            $items[] = [
                'id' => $id,
                'name' => $row['item_name'],
                'total_orders' => $itemCounts[$id]['total_orders'],
                'total_quantity' => $itemCounts[$id]['total_quantity'],
                'total_sales' => $row['price'] * $itemCounts[$id]['total_quantity']
            ];
        }

        // Sort by total_quantity descending
        usort($items, function($a, $b) {
            return $b['total_quantity'] - $a['total_quantity'];
        });
    }

    return $items;
}

    public function getRevenueAndRiderCosts() {
    $orders = $this->conn->query(
        "SELECT id, rider_id, items 
         FROM orders 
         WHERE status = 'accepted'"
    );

    $totalRevenue = 0;
    $riderSalaries = [];

    while ($order = $orders->fetch_assoc()) {
        $orderTotal = 0;
        $items = json_decode($order['items'], true);

        foreach ($items as $menu_id => $qty) {
            $price = $this->conn
                ->query("SELECT price FROM menu WHERE id = $menu_id")
                ->fetch_assoc()['price'];

            $orderTotal += $price * $qty;
        }

        // Costs
        $foodCost  = $orderTotal * 0.40;
        $otherCost = $orderTotal * 0.25;
        $riderCost = max($orderTotal * 0.10, 40);

        $netRevenue = $orderTotal - ($foodCost + $otherCost + $riderCost);
        $totalRevenue += $netRevenue;

        if (!empty($order['rider_id'])) {
            if (!isset($riderSalaries[$order['rider_id']])) {
                $riderSalaries[$order['rider_id']] = 0;
            }
            $riderSalaries[$order['rider_id']] += $riderCost;
        }
    }

    return [
        'total_revenue' => $totalRevenue,
        'rider_costs' => $riderSalaries
    ];
}

    public function getRiderNameById($id) {
    $stmt = $this->conn->prepare(
        "SELECT fullname FROM riders WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['fullname'] ?? 'Unknown';
}

    public function updateProfile($id, $fullname, $email, $phone, $currentPassword) {

    // Fetch current password hash
    $stmt = $this->conn->prepare(
        "SELECT password FROM sales_analysts WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$row = $result->fetch_assoc()) {
        return "User not found";
    }

    // Verify password
    if (!password_verify($currentPassword, $row['password'])) {
        return "Incorrect password";
    }

    // Update profile info
    $update = $this->conn->prepare(
        "UPDATE sales_analysts 
         SET fullname = ?, email = ?, phone = ?
         WHERE id = ?"
    );
    $update->bind_param("sssi", $fullname, $email, $phone, $id);

    if ($update->execute()) {
        return true;
    }

    return "Failed to update profile";
}

    public function getProfileInfo($id) {
    $stmt = $this->conn->prepare(
        "SELECT fullname, email, phone 
         FROM sales_analysts 
         WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}



}
