<?php
require_once 'connect.php';
require_once 'validate.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $format = $_POST['format'] ?? 'excel';
    $period = $_POST['period'] ?? 'weekly';
    
    try {
        // Calculate date range based on period
        $today = new DateTime();
        $startDate = clone $today;
        
        switch($period) {
            case 'weekly':
                $startDate->modify('-7 days');
                $periodText = 'Weekly';
                break;
            case 'monthly':
                $startDate->modify('-1 month');
                $periodText = 'Monthly';
                break;
            case 'yearly':
                $startDate->modify('-1 year');
                $periodText = 'Yearly';
                break;
        }
        
        $startDateStr = $startDate->format('Y-m-d');
        $endDateStr = $today->format('Y-m-d');

        // Get data for export
        $query = $conn->prepare("
            SELECT 
                r.reservation_id,
                r.reservation_date,
                r.check_in_date,
                r.check_out_date,
                r.total_amount,
                r.status as reservation_status,
                p.amount as payment_amount,
                p.payment_date,
                p.payment_method,
                p.payment_status,
                CONCAT(g.firstname, ' ', g.lastname) as guest_name,
                CASE 
                    WHEN r.room_id IS NOT NULL THEN 'Room'
                    WHEN r.cottage_id IS NOT NULL THEN 'Cottage'
                    ELSE 'Unknown'
                END as reservation_type
            FROM reservation r
            INNER JOIN payment p ON r.reservation_id = p.reservation_id
            INNER JOIN guest g ON r.guest_id = g.guest_id
            WHERE DATE(r.reservation_date) BETWEEN ? AND ?
            AND p.payment_status = 'verified'
            ORDER BY r.reservation_date DESC
        ");
        $query->bind_param('ss', $startDateStr, $endDateStr);
        $query->execute();
        $result = $query->get_result();

        $data = [];
        $totalRevenue = 0;
        $totalBookings = 0;
        
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
            $totalRevenue += $row['payment_amount'];
            $totalBookings++;
        }
        $query->close();

        switch($format) {
            case 'csv':
                exportCSV($data, $periodText, $startDateStr, $endDateStr, $totalRevenue, $totalBookings);
                break;
            case 'pdf':
                exportPDF($data, $periodText, $startDateStr, $endDateStr, $totalRevenue, $totalBookings);
                break;
            case 'excel':
            default:
                exportExcel($data, $periodText, $startDateStr, $endDateStr, $totalRevenue, $totalBookings);
                break;
        }

    } catch (Exception $e) {
        // Redirect back with error message
        header('Location: reports.php?alert=error&message=' . urlencode('Export failed: ' . $e->getMessage()));
        exit();
    }
} else {
    header('Location: reports.php');
    exit();
}

function exportExcel($data, $periodText, $startDate, $endDate, $totalRevenue, $totalBookings) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $periodText . '_Report_' . date('Y-m-d') . '.xls"');
    
    echo $periodText . " Reservation Report\n";
    echo "Period: " . $startDate . " to " . $endDate . "\n";
    echo "Total Revenue: ₱" . number_format($totalRevenue, 2) . "\n";
    echo "Total Bookings: " . $totalBookings . "\n\n";
    
    echo "Date\tReservation ID\tGuest Name\tType\tAmount\tStatus\tPayment Method\tCheck-in\tCheck-out\n";
    
    foreach($data as $row) {
        echo $row['reservation_date'] . "\t";
        echo $row['reservation_id'] . "\t";
        echo $row['guest_name'] . "\t";
        echo $row['reservation_type'] . "\t";
        echo "₱" . number_format($row['payment_amount'], 2) . "\t";
        echo ucfirst($row['reservation_status']) . "\t";
        echo ucfirst($row['payment_method']) . "\t";
        echo $row['check_in_date'] . "\t";
        echo $row['check_out_date'] . "\n";
    }
    exit();
}

function exportCSV($data, $periodText, $startDate, $endDate, $totalRevenue, $totalBookings) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $periodText . '_Report_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // Header information
    fputcsv($output, [$periodText . ' Reservation Report']);
    fputcsv($output, ['Period:', $startDate . ' to ' . $endDate]);
    fputcsv($output, ['Total Revenue:', '₱' . number_format($totalRevenue, 2)]);
    fputcsv($output, ['Total Bookings:', $totalBookings]);
    fputcsv($output, []); // Empty line
    
    // Column headers
    fputcsv($output, [
        'Date', 'Reservation ID', 'Guest Name', 'Type', 'Amount', 
        'Status', 'Payment Method', 'Check-in', 'Check-out'
    ]);
    
    // Data rows
    foreach($data as $row) {
        fputcsv($output, [
            $row['reservation_date'],
            $row['reservation_id'],
            $row['guest_name'],
            $row['reservation_type'],
            '₱' . number_format($row['payment_amount'], 2),
            ucfirst($row['reservation_status']),
            ucfirst($row['payment_method']),
            $row['check_in_date'],
            $row['check_out_date']
        ]);
    }
    
    fclose($output);
    exit();
}

function exportPDF($data, $periodText, $startDate, $endDate, $totalRevenue, $totalBookings) {
    // For PDF export, you would typically use a library like TCPDF or Dompdf
    // This is a simplified version that outputs as HTML that can be printed as PDF
    
    header('Content-Type: text/html');
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>' . $periodText . ' Report</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 30px; }
            .summary { margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            .total-row { font-weight: bold; background-color: #e9ecef; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>' . $periodText . ' Reservation Report</h1>
            <p>Period: ' . $startDate . ' to ' . $endDate . '</p>
        </div>
        
        <div class="summary">
            <strong>Summary:</strong><br>
            Total Revenue: ₱' . number_format($totalRevenue, 2) . '<br>
            Total Bookings: ' . $totalBookings . '
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Reservation ID</th>
                    <th>Guest Name</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                </tr>
            </thead>
            <tbody>';
    
    foreach($data as $row) {
        echo '<tr>
                <td>' . $row['reservation_date'] . '</td>
                <td>' . $row['reservation_id'] . '</td>
                <td>' . $row['guest_name'] . '</td>
                <td>' . $row['reservation_type'] . '</td>
                <td>₱' . number_format($row['payment_amount'], 2) . '</td>
                <td>' . ucfirst($row['reservation_status']) . '</td>
                <td>' . ucfirst($row['payment_method']) . '</td>
                <td>' . $row['check_in_date'] . '</td>
                <td>' . $row['check_out_date'] . '</td>
            </tr>';
    }
    
    echo '</tbody>
        </table>
        
        <script>
            window.onload = function() {
                window.print();
            }
        </script>
    </body>
    </html>';
    exit();
}
?>