<?php
/*
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Logout The User Regardless of Account Type
*/
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
//Do Default Logout If Sesson Info Doesnt Fit The Site
else {
	session_destroy();
	header("Location: register.php?error=bug");
	die;
}
?>