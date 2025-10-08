<?php
	if(isset($_POST['login'])){
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$query = $conn->query("SELECT * FROM `admin` WHERE `username` = '$username' && `password` = '$password'") or die(mysqli_error());
		$fetch = $query->fetch_array();
		$row = $query->num_rows;
		
		if($row > 0){
			session_start();
			$admin_id = $fetch['admin_id'];
			$_SESSION['admin_id'] = $fetch['admin_id'];
			$conn->query("UPDATE `admin` SET `last_login` = NOW() WHERE `admin_id` = '$admin_id'");
			header('location:home.php');
		}else{
			echo "<center><labe style = 'color:red;'>Invalid username or password</label></center>";
		}
	}
?>