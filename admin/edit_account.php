<?php
require_once 'connect.php';

if (isset($_POST['edit_account'])) {

    $admin_id = (int) $_POST['admin_id']; // cast to int for safety
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    if (! empty($password)) {
        // update everything if a new password is given
        $sql = "UPDATE `admin`
                SET `name`='$name', `username`='$username', `password`='$password'
                WHERE `admin_id`=$admin_id";
    } else {
        // keep the current password
        $sql = "UPDATE `admin`
                SET `name`='$name', `username`='$username'
                WHERE `admin_id`=$admin_id";
    }

    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    header("Location: account.php");
    exit();
}
