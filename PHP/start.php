<?php
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);

	$user = $_SESSION["username"];

	if(isset($user)){
		echo "Welcome $user<br />";
		echo "<a href='logout.php'> Logout </a>";
	}
	else {
		header("index.php");
	}
?>
