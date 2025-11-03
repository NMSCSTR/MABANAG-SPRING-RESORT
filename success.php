<?php
require 'vendor/autoload.php';
use Xendit\Xendit;
require_once 'admin/connect.php';

$XENDIT_API_KEY = 'YOUR_XENDIT_API_KEY';
Xendit::setApiKey($XENDIT_API_KEY);

$invoice_id = $_GET['invoice_id'] ?? '';

if (!$invoice_id) {
    die("<h3>Invalid access. No invoice ID found.</h3>");
}

// Get invoice details from Xendit
$ch = curl_init("https://api.xendit.co/v2/invoices/$invoice_id");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $XENDIT_API_KEY . ":");
$response = curl_exec($ch);
curl_close($ch);

$invoice = json_decode($response, true);

if ($invoice['status'] === 'PAID') {
    $external_id = $invoice['external_id'];

    // Update DB
    mysqli_query($conn, "
        UPDATE payment 
        SET status='Paid', payment_date=NOW() 
        WHERE external_id='$external_id'
    ");
    mysqli_query($conn, "
        UPDATE reservation r 
        JOIN payment p ON r.reservation_id = p.reservation_id
        SET r.reservation_status='Confirmed'
        WHERE p.external_id='$external_id'
    ");

    echo "<h2>✅ Payment successful! Thank you, {$invoice['customer']['given_names']}.</h2>";
} else {
    echo "<h2>⚠️ Payment not completed yet.</h2>";
}
?>
