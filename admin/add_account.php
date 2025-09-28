<?php
include_once 'connect.php';

if (isset($_POST['add_account'])) {

    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $query = $conn->query("SELECT * FROM `admin` WHERE `username` = '$username'")
             or die(mysqli_error($conn));
    $check_exist = $query->num_rows;

    if ($check_exist > 0) {
        echo 'Username has been taken. Use another username!';
    } else {
        $conn->query("INSERT INTO `admin` (name, username, password)
                      VALUES ('$name', '$username', '$password')")
              or die(mysqli_error($conn));
        header('Location: account.php');
        exit();
    }
}
?>
