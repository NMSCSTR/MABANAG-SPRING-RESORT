<?php
	require_once 'connect.php';
	mysql_query("DELETE FROM `cottage` WHERE `cottage_id` = '$_REQUEST[cottage_id]'") or die(mysql_error());
	header("location:cottage.php");
?>