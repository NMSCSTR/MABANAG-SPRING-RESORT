<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $format = $_POST['format'] ?? 'excel';
    $period = $_POST['period'] ?? 'weekly';

    // Calculate date range
    $today = new DateTime();
    $startDate = clone $today;

    switch($period) {
        case 'weekly': $startDate->modify('-7 days'); break;
        case 'monthly': $startDate->modify('-1 month'); break;
        case 'yearly': $startDate->modify('-1 year'); break;
    }

    $startDateStr = $startDate->format('Y-m-d');
    $endDateStr = $today->format('Y-m-d');

    // Fetch data
    $query = $conn->query("
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
        WHERE DATE(r.reservation_date) BETWEEN '$startDateStr' AND '$endDateStr'
        ORDER BY r.reservation_date DESC
    ");

    $rows = [];
    while ($row = $query->fetch_assoc()) {
        $rows[] = $row;
    }

    // === EXPORT HANDLERS ===
    $filename = "Reservation_Report_" . ucfirst($period) . "_" . date('Ymd_His');

    if ($format === 'csv') {
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=$filename.csv");
        $output = fopen("php://output", "w");
        fputcsv($output, array('Reservation ID', 'Date', 'Guest', 'Type', 'Amount', 'Reservation Status', 'Payment Status'));
        foreach ($rows as $row) {
            fputcsv($output, [
                $row['reservation_id'],
                $row['reservation_date'],
                $row['guest_name'],
                $row['reservation_type'],
                $row['amount'],
                ucfirst($row['reservation_status']),
                ucfirst($row['payment_status'])
            ]);
        }
        fclose($output);
        exit;
    }

    elseif ($format === 'excel') {
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename.xls");
        echo "Reservation ID\tDate\tGuest\tType\tAmount\tReservation Status\tPayment Status\n";
        foreach ($rows as $row) {
            echo "{$row['reservation_id']}\t{$row['reservation_date']}\t{$row['guest_name']}\t{$row['reservation_type']}\t{$row['amount']}\t{$row['reservation_status']}\t{$row['payment_status']}\n";
        }
        exit;
    }

    elseif ($format === 'pdf') {
        require_once __DIR__ . '/fpdf186/fpdf.php'; // Ensure FPDF is in /admin/fpdf186/

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, "Reservation Report (" . ucfirst($period) . ")", 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 10, 'Res ID');
        $pdf->Cell(40, 10, 'Date');
        $pdf->Cell(35, 10, 'Guest');
        $pdf->Cell(25, 10, 'Type');
        $pdf->Cell(30, 10, 'Amount');
        $pdf->Cell(30, 10, 'Status');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 11);
        foreach ($rows as $row) {
            $pdf->Cell(30, 10, $row['reservation_id']);
            $pdf->Cell(40, 10, $row['reservation_date']);
            $pdf->Cell(35, 10, $row['guest_name']);
            $pdf->Cell(25, 10, $row['reservation_type']);
            $pdf->Cell(30, 10, '₱' . $row['amount']);
            $pdf->Cell(30, 10, ucfirst($row['reservation_status']));
            $pdf->Ln();
        }
        $pdf->Output('D', $filename . '.pdf');
        exit;
    }
}
?>
