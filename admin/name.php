<?php
require 'connect.php';
$admin_id = $_SESSION['admin_id'];
$query = $conn->query("SELECT * FROM `admin` WHERE `admin_id` = '$admin_id'") 
         or die(mysqli_error($conn));
$fetch = $query->fetch_assoc();
$name  = $fetch['name'];
?>
