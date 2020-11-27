<?php
require "PHPAssets/dir.php";
function isEmployee(object $con, string $logged_code) {
	$actual_code = getEmployeeCodeAccess($con);
	if(strcmp($logged_code, $actual_code) != 0) {
		session_destroy();
		header("Location: employeeverify.php?error=employeeverifyfailed");
		die;
	}
}
?>