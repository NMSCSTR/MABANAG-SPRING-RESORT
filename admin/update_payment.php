<?php
require_once 'connect.php';
require_once 'validate.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_id = mysqli_real_escape_string($conn, $_POST['payment_id']);
    $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);
    
    // Validate payment status
    $allowed_statuses = ['verified', 'rejected'];
    if (!in_array($payment_status, $allowed_statuses)) {
        $_SESSION['alert_type'] = 'error';
        $_SESSION['alert_title'] = 'Error';
        $_SESSION['alert_message'] = 'Invalid payment status.';
        header("location: transaction.php");
        exit();
    }
    
    // Update payment status
    $update_query = $conn->query("UPDATE payment SET payment_status = '$payment_status' WHERE payment_id = '$payment_id'");
    
    if ($update_query) {
        // If payment is verified, also update reservation status to confirmed
        if ($payment_status == 'verified') {
            $reservation_query = $conn->query("UPDATE reservation SET status = 'confirmed' WHERE reservation_id = (SELECT reservation_id FROM payment WHERE payment_id = '$payment_id')");
            
            if ($reservation_query) {
                $_SESSION['alert_type'] = 'success';
                $_SESSION['alert_title'] = 'Success';
                $_SESSION['alert_message'] = 'Payment verified and reservation confirmed successfully!';
            } else {
                $_SESSION['alert_type'] = 'warning';
                $_SESSION['alert_title'] = 'Warning';
                $_SESSION['alert_message'] = 'Payment verified but failed to update reservation status.';
            }
        } else {
            // If payment is rejected, update reservation status to cancelled
            $reservation_query = $conn->query("UPDATE reservation SET status = 'cancelled' WHERE reservation_id = (SELECT reservation_id FROM payment WHERE payment_id = '$payment_id')");
            
            if ($reservation_query) {
                $_SESSION['alert_type'] = 'success';
                $_SESSION['alert_title'] = 'Success';
                $_SESSION['alert_message'] = 'Payment rejected and reservation cancelled.';
            } else {
                $_SESSION['alert_type'] = 'warning';
                $_SESSION['alert_title'] = 'Warning';
                $_SESSION['alert_message'] = 'Payment rejected but failed to update reservation status.';
            }
        }
    } else {
        $_SESSION['alert_type'] = 'error';
        $_SESSION['alert_title'] = 'Error';
        $_SESSION['alert_message'] = 'Failed to update payment status: ' . mysqli_error($conn);
    }
    
    header("location: transaction.php");
    exit();
} else {
    // If not POST request, redirect to transaction page
    header("location: transaction.php");
    exit();
}
?>
