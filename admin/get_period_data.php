<?php
require_once 'connect.php';

// Get selected period from AJAX
$period = isset($_POST['period']) ? $_POST['period'] : 'weekly';

switch($period) {
    case 'monthly':
        $startDate = date('Y-m-01');
        $label = "This Month";
        break;
    case 'yearly':
        $startDate = date('Y-01-01');
        $label = "This Year";
        break;
    default:
        $startDate = date('Y-m-d', strtotime('-7 days'));
        $label = "This Week";
        break;
}

$endDate = date('Y-m-d');

// Fetch reservations and payments
$query = $conn->query("
    SELECT r.reservation_id, r.reservation_date, r.status AS reservation_status,
           p.amount, p.payment_status,
           g.firstname AS guest_name,
           CASE 
               WHEN r.room_id IS NOT NULL THEN 'Room'
               WHEN r.cottage_id IS NOT NULL THEN 'Cottage'
               ELSE 'Unknown'
           END AS reservation_type
    FROM reservation r
    LEFT JOIN payment p ON r.reservation_id = p.reservation_id
    LEFT JOIN guest g ON r.guest_id = g.guest_id
    WHERE DATE(r.reservation_date) BETWEEN '$startDate' AND '$endDate'
    ORDER BY r.reservation_date DESC
") or die(mysqli_error($conn));

// Initialize metrics
$totalRevenue = 0;
$totalBookings = 0;
$verifiedPayments = 0;
$totalGuests = [];
$rows = [];

while($row = $query->fetch_assoc()) {
    $rows[] = $row;
    if ($row['payment_status'] == 'verified') {
        $totalRevenue += $row['amount'];
        $verifiedPayments++;
    }
    $totalBookings++;
    $totalGuests[$row['guest_name']] = true;
}

// Derived metrics
$avgBookingValue = $verifiedPayments > 0 ? ($totalRevenue / $verifiedPayments) : 0;
$occupancyRate = $totalBookings > 0 ? round(($verifiedPayments / $totalBookings) * 100, 1) : 0;

// Return JSON
echo json_encode([
    'periodLabel' => $label,
    'data' => $rows,
    'metrics' => [
        'totalRevenue' => $totalRevenue,
        'totalBookings' => $totalBookings,
        'occupancyRate' => $occupancyRate,
        'avgBookingValue' => $avgBookingValue
    ]
]);
?>
