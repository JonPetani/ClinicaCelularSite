<?php
require "PHPAssets/connect.php";
if(isset($_SESSION['type']) or isset($_SESSION['CodeValue'])) {
	switch($_SESSION['type']) {
		case 'customer':
		$destination = "login.php?info=logout";
		break;
	
		case 'employee':
		$destination = "employeeverify.php?info=logout";
		break;
		
		default:
		$destination = "login.php?info=logout";
		break;
	}
	session_destroy();
	header("Location: " . $destination);
	die;
}
else {
	session_destroy();
	header("Location: register.php?error=bug");
	die;
}
?>