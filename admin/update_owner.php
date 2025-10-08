<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info_id = $_POST['info_id'];
    $gcash_number = $_POST['gcash_number'];
    $gcash_name = $_POST['gcash_name'];
    $email_address = $_POST['email_address'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $facebook_account = $_POST['facebook_account'];

    $query = "UPDATE owners_info SET 
        gcash_number='$gcash_number',
        gcash_name='$gcash_name',
        email_address='$email_address',
        phone_number='$phone_number',
        address='$address',
        facebook_account='$facebook_account'
        WHERE info_id='$info_id'";

    if ($conn->query($query)) {
        echo json_encode(["status" => "success", "message" => "Owner information updated successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update record."]);
    }
}
?>
