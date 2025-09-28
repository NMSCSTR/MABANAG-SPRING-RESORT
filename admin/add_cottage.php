<?php
	if(isset($_POST['add_cottage'])){
		$cottage_type = $_POST['cottage_type'];
		$cottage_price = $_POST['cottage_price'];
		$cottage_availability = $_POST['cottage_availability'];
		$photo = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
		$photo_name = addslashes($_FILES['photo']['name']);
		$photo_size = getimagesize($_FILES['photo']['tmp_name']);
		move_uploaded_file($_FILES['photo']['tmp_name'],"../photo/" . $_FILES['photo']['name']);
		$conn->query("INSERT INTO `cottage`(`cottage_type`, `cottage_price`, `cottage_availability`, `photo`) VALUES ('$cottage_type','$cottage_pric','$cottage_availability','$photo_name',)") or die(mysqli_error());
		header("location:cottage.php");
	}
?>