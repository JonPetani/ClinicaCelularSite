<?php
require "PHPAssets/dir.php";
function isEmployee(object $con, array $verify_array) {
	$actual_code = getEmployeeCodeAccess($con);
	if(strcmp($verify_array['CodeValue'], $actual_code) != 0) {
		session_destroy();
		header("Location: employeeverify.php?error=employeeverifyfailed");
		die;
	}
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