<?php
require_once 'connect.php';

if (isset($_POST['id'])) {
    $admin_id = (int) $_POST['id'];

    $sql = "DELETE FROM `admin` WHERE `admin_id` = $admin_id";

    if (mysqli_query($conn, $sql)) {
        echo 'success';  
    } else {
        echo 'error';
        // For debugging you can also: echo mysqli_error($conn);
    }
}
?>
