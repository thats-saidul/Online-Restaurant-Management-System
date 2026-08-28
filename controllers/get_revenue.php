<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['sales_analyst_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once '../models/SalesAnalyst.php';

$model = new SalesAnalyst();
$data = $model->getRevenueAndRiderCosts();

$riderData = [];
foreach ($data['rider_costs'] as $riderId => $salary) {
    $riderData[$riderId] = [
        'fullname' => $model->getRiderNameById($riderId),
        'salary' => $salary
    ];
}

echo json_encode([
    'total_revenue' => $data['total_revenue'],
    'rider_costs' => $riderData
]);
