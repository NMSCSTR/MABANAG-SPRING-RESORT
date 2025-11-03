<?php
require 'admin/connect.php';


$input = file_get_contents("php://input");
$data = json_decode($input, true);


file_put_contents('xendit_webhook_log.txt', date('Y-m-d H:i:s')." ".print_r($data, true)."\n", FILE_APPEND);


$headers = getallheaders();
$callbackToken = $headers['X-CALLBACK-TOKEN'] ?? '';
$validToken = 'YOUR_XENDIT_CALLBACK_TOKEN'; 

if ($callbackToken !== $validToken) {
    http_response_code(403);
    exit('Invalid callback token');
}

if (isset($data['id'], $data['status'])) {
    $invoice_id = mysqli_real_escape_string($conn, $data['id']);
    $status     = mysqli_real_escape_string($conn, strtoupper($data['status']));
    $paid_at    = isset($data['paid_at']) ? date('Y-m-d H:i:s', strtotime($data['paid_at'])) : null;


    $update = "
        UPDATE payment 
        SET payment_status = '" . ($status === 'PAID' ? 'verified' : 'pending') . "', 
            paid_at = '$paid_at'
        WHERE xendit_invoice_id = '$invoice_id'
    ";
    mysqli_query($conn, $update);


    if ($status === 'PAID') {
        $sql = "SELECT reservation_id FROM payment WHERE xendit_invoice_id = '$invoice_id'";
        $result = mysqli_query($conn, $sql);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $reservation_id = $row['reservation_id'];
            mysqli_query($conn, "UPDATE reservation SET is_paid_online = 1, status = 'confirmed' WHERE reservation_id = '$reservation_id'");
        }
    }

    http_response_code(200);
    echo json_encode(['message' => 'Webhook processed successfully']);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
}
?>
