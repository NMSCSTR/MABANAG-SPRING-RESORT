<?php
require_once 'connect.php';

$type = $_POST['type'] ?? 'weekly';
$data = [];
$today = date('Y-m-d');

if ($type === 'weekly') {
    $start = date('Y-m-d', strtotime('monday this week'));
    $end   = date('Y-m-d', strtotime('sunday this week'));
} elseif ($type === 'monthly') {
    $start = date('Y-m-01');
    $end   = date('Y-m-t');
} else { // yearly
    $start = date('Y-01-01');
    $end   = date('Y-12-31');
}

$query = $conn->query("
    SELECT 
        p.payment_id,
        p.reservation_id,
        DATE_FORMAT(p.payment_date, '%b %d, %Y %h:%i %p') AS payment_date,
        p.payment_method,
        p.payment_reference,
        p.amount,
        p.payment_status
    FROM payment p
    INNER JOIN reservation r ON p.reservation_id = r.reservation_id
    WHERE p.payment_status = 'verified'
      AND DATE(p.payment_date) BETWEEN '$start' AND '$end'
    ORDER BY p.payment_date DESC
");

$i = 1;
while ($row = $query->fetch_assoc()) {
    $data[] = [
        'no' => $i++,
        'reservation_id' => $row['reservation_id'],
        'payment_date' => $row['payment_date'],
        'payment_method' => $row['payment_method'],
        'payment_reference' => $row['payment_reference'],
        'amount' => number_format($row['amount'], 2),
        'payment_status' => ucfirst($row['payment_status'])
    ];
}

echo json_encode(['data' => $data]);
?>
