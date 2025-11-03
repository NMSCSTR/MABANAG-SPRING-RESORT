<?php

require_once 'admin/connect.php';

$given_names   = htmlspecialchars(trim($_POST['given_names'] ?? ''));
$surname       = htmlspecialchars(trim($_POST['surname'] ?? ''));
$email         = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$mobile_number = htmlspecialchars(trim($_POST['mobile_number'] ?? ''));
$amount        = intval($_POST['amount'] ?? 0);
$description   = htmlspecialchars(trim($_POST['description'] ?? ''));

if (empty($given_names) || empty($surname) || empty($email) || empty($amount) || $amount <= 0) {
    die("<h3>Missing or invalid required fields.</h3>");
}


$base_url     = "https://mabanag-spring-resort.site";
$success_url  = $base_url . "/success.php";
$failure_url  = $base_url . "/fail.php";

// Prepare the invoice data
$data = [
    'external_id'           => 'invoice_' . uniqid(),
    'payer_email'           => $email,
    'amount'                => $amount,
    'description'           => $description ?: 'Resort Booking Payment',
    'success_redirect_url'  => $success_url,
    'failure_redirect_url'  => $failure_url,
    'customer'              => [
        'given_names'   => $given_names,
        'surname'       => $surname,
        'email'         => $email,
        'mobile_number' => $mobile_number
    ]
];
// Optional: Log data to browser console
echo "<script>console.log(" . json_encode($data) . ");</script>";

// Initialize cURL
$ch = curl_init('https://api.xendit.co/v2/invoices');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $XENDIT_API_KEY . ":");
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Send the request
$response = curl_exec($ch);
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    curl_close($ch);
    die("<h3>cURL Error:</h3><p>{$error_msg}</p>");
}

curl_close($ch);

// Process the response
$invoice = json_decode($response, true);

if (isset($invoice['invoice_url'])) {
    // Redirect customer to Xendit payment page
    header('Location: ' . $invoice['invoice_url']);
    exit;
} else {
    // Display error for debugging
    echo "<h3>Error Creating Invoice</h3>";
    echo "<pre>" . htmlspecialchars(json_encode($invoice, JSON_PRETTY_PRINT)) . "</pre>";
}

// if (isset($invoice['id'])) {
//     echo "<h3>Invoice Created Successfully!</h3>";
//     echo "<p>Invoice ID: " . htmlspecialchars($invoice['id']) . "</p>";
//     echo "<p>Invoice URL: <a href='" . htmlspecialchars($invoice['invoice_url']) . "' target='_blank'>" . htmlspecialchars($invoice['invoice_url']) . "</a></p>";
// } else {
//     echo "<h3>Error Creating Invoice</h3>";
//     echo "<p>" . htmlspecialchars($invoice['message'] ?? 'Unknown error') . "</p>";
// }
?>
