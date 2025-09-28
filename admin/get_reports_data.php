<?php
require_once 'connect.php';
require_once 'validate.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateFrom = $_POST['dateFrom'] ?? date('Y-m-d', strtotime('-30 days'));
    $dateTo = $_POST['dateTo'] ?? date('Y-m-d');
    $period = $_POST['period'] ?? 'monthly';

    try {
        // Calculate total revenue
        $revenueQuery = $conn->query("
            SELECT COALESCE(SUM(p.amount), 0) as total_revenue
            FROM payment p
            INNER JOIN reservation r ON p.reservation_id = r.reservation_id
            WHERE p.payment_status = 'verified'
            AND DATE(r.reservation_date) BETWEEN '$dateFrom' AND '$dateTo'
        ");
        $totalRevenue = $revenueQuery->fetch_assoc()['total_revenue'];

        // Calculate total bookings
        $bookingsQuery = $conn->query("
            SELECT COUNT(*) as total_bookings
            FROM reservation r
            INNER JOIN payment p ON r.reservation_id = p.reservation_id
            WHERE p.payment_status = 'verified'
            AND DATE(r.reservation_date) BETWEEN '$dateFrom' AND '$dateTo'
        ");
        $totalBookings = $bookingsQuery->fetch_assoc()['total_bookings'];

        // Calculate occupancy rate (simplified)
        $totalRooms = 24; // Total rooms in your resort
        $totalCottages = 12; // Total cottages in your resort
        $totalCapacity = $totalRooms + $totalCottages;
        $occupancyRate = $totalBookings > 0 ? round(($totalBookings / $totalCapacity) * 100) : 0;

        // Calculate average booking value
        $avgBookingValue = $totalBookings > 0 ? $totalRevenue / $totalBookings : 0;

        // Sample trend data (in real application, you'd calculate this based on previous period)
        $revenueTrend = 8.5;
        $bookingsTrend = 12.2;
        $occupancyTrend = 6.8;
        $avgValueTrend = -2.3;

        echo json_encode([
            'totalRevenue' => floatval($totalRevenue),
            'totalBookings' => intval($totalBookings),
            'occupancyRate' => $occupancyRate,
            'avgBookingValue' => floatval($avgBookingValue),
            'revenueTrend' => $revenueTrend,
            'bookingsTrend' => $bookingsTrend,
            'occupancyTrend' => $occupancyTrend,
            'avgValueTrend' => $avgValueTrend
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch report data: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>