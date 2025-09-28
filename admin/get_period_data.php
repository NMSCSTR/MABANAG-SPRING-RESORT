<?php
require_once 'connect.php';
require_once 'validate.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $period = $_POST['period'] ?? 'weekly';
    
    try {
        // Calculate date range based on period
        $today = new DateTime();
        $startDate = clone $today;
        
        switch($period) {
            case 'weekly':
                $startDate->modify('-7 days');
                break;
            case 'monthly':
                $startDate->modify('-1 month');
                break;
            case 'yearly':
                $startDate->modify('-1 year');
                break;
        }
        
        $startDateStr = $startDate->format('Y-m-d');
        $endDateStr = $today->format('Y-m-d');

        // Calculate total revenue
        $revenueQuery = $conn->query("
            SELECT COALESCE(SUM(p.amount), 0) as total_revenue
            FROM payment p
            INNER JOIN reservation r ON p.reservation_id = r.reservation_id
            WHERE p.payment_status = 'verified'
            AND DATE(r.reservation_date) BETWEEN '$startDateStr' AND '$endDateStr'
        ");
        $totalRevenue = $revenueQuery->fetch_assoc()['total_revenue'];

        // Calculate total bookings
        $bookingsQuery = $conn->query("
            SELECT COUNT(*) as total_bookings
            FROM reservation r
            INNER JOIN payment p ON r.reservation_id = p.reservation_id
            WHERE p.payment_status = 'verified'
            AND DATE(r.reservation_date) BETWEEN '$startDateStr' AND '$endDateStr'
        ");
        $totalBookings = $bookingsQuery->fetch_assoc()['total_bookings'];

        // Calculate occupancy rate
        $totalRooms = 24;
        $totalCottages = 12;
        $totalCapacity = $totalRooms + $totalCottages;
        $occupancyRate = $totalBookings > 0 ? round(($totalBookings / $totalCapacity) * 100) : 0;

        // Calculate average booking value
        $avgBookingValue = $totalBookings > 0 ? $totalRevenue / $totalBookings : 0;

        // Get transactions for the period
        $transactionsQuery = $conn->query("
            SELECT r.reservation_id, r.reservation_date, r.status as reservation_status,
                   p.amount, p.payment_status,
                   g.firstname as guest_name,
                   CASE 
                       WHEN r.room_id IS NOT NULL THEN 'Room'
                       WHEN r.cottage_id IS NOT NULL THEN 'Cottage'
                       ELSE 'Unknown'
                   END as reservation_type
            FROM reservation r
            LEFT JOIN payment p ON r.reservation_id = p.reservation_id
            LEFT JOIN guest g ON r.guest_id = g.guest_id
            WHERE p.payment_status = 'verified'
            AND DATE(r.reservation_date) BETWEEN '$startDateStr' AND '$endDateStr'
            ORDER BY r.reservation_date DESC
            LIMIT 100
        ");

        $transactions = [];
        while($row = $transactionsQuery->fetch_assoc()) {
            $transactions[] = [
                'date' => $row['reservation_date'],
                'id' => $row['reservation_id'],
                'guest' => $row['guest_name'],
                'type' => $row['reservation_type'],
                'amount' => floatval($row['amount']),
                'status' => $row['reservation_status'],
                'paymentStatus' => $row['payment_status']
            ];
        }

        // Sample trend data (in real app, calculate based on previous period)
        $trendData = [
            'weekly' => ['revenue' => 12.5, 'bookings' => 8.3, 'occupancy' => 5.2, 'avgValue' => 3.7],
            'monthly' => ['revenue' => 15.2, 'bookings' => 12.8, 'occupancy' => 8.1, 'avgValue' => 2.1],
            'yearly' => ['revenue' => 18.7, 'bookings' => 14.3, 'occupancy' => 6.9, 'avgValue' => 3.8]
        ];

        $trends = $trendData[$period] ?? $trendData['weekly'];

        echo json_encode([
            'totalRevenue' => floatval($totalRevenue),
            'totalBookings' => intval($totalBookings),
            'occupancyRate' => $occupancyRate,
            'avgBookingValue' => floatval($avgBookingValue),
            'revenueTrend' => $trends['revenue'],
            'bookingsTrend' => $trends['bookings'],
            'occupancyTrend' => $trends['occupancy'],
            'avgValueTrend' => $trends['avgValue'],
            'transactions' => $transactions
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch period data: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>