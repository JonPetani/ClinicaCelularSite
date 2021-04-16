<?php
/*
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Account Maintenence Functions
*/
require "PHPAssets/dir.php";
//Verifies If User Is Listed Employee For Extra Security
function isEmployee(object $con, array $verify_array) {
	//Employee Site Code
	$actual_code = getEmployeeCodeAccess($con);
	//Checks The Listed Site Code
	if(strcmp($verify_array['CodeValue'], $actual_code) != 0) {
		session_destroy();
		header("Location: employeeverify.php?error=employeeverifyfailed");
		die;
	}
	//Checks The Password
	if(isset($verify_array['Password'])) {
		$pcheck = $con -> prepare("SELECT * FROM employee WHERE Password = :pass");
		$pcheck -> bindParam(':pass', $verify_array['Password']);
		$pcheck -> execute();
		if($pcheck -> rowCount() < 1) {
			session_destroy();
			header("Location: employeeverify.php?error=employeeverifyfailed");
			die;
		}
	}
	else {
		if(!isset($_POST['EPassword'])) {
			header("Location: employeelogin.php?error=earlylogout");
			die;
		}
	}
}
?>