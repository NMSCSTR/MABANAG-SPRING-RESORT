<?php
require_once 'admin/connect.php';
header('Content-Type: application/json');
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['transaction_ref']) || empty($_POST['transaction_ref'])) {
        echo json_encode(['success' => false, 'message' => 'Missing transaction reference.']);
        exit;
    }

    $transaction_ref = $_POST['transaction_ref'];

    $check = $conn->query("SELECT * FROM reservation WHERE transaction_reference = '$transaction_ref'");
    if ($check->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Reservation not found.']);
        exit;
    }

    $reservation = $check->fetch_assoc();
    $id = $reservation['reservation_id'];
    $remarks = "Requesting for cancellation";

    // Update status to cancelled
    $update = $conn->query("UPDATE `reservation` SET `remarks`='$remarks' WHERE `reservation_id` = '$id'");
    if ($update) {
        echo json_encode(['success' => true, 'message' => 'Requesting cancellation success.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed requesting cancellation.']);
    }
}
?>
