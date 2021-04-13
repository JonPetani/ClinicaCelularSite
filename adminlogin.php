<?php
include "PHPAssets/connect.php";
include "PHPAssets/pagetools.php";
include "PHPAssets/accounttools.php";
if(!isset($_SESSION['CodeValue'])) {
		session_destroy();
		header("Location: employeeverify.php?error=employeeverifyfailed");
		die;
}
if(!isset($_SESSION['Password'])) {
	header("Location: employeelogin.php?error=earlylogout");
	die;
}
$verify_array = array("CodeValue" => decryptDisplay($_SESSION['CodeValue'], $con), "Password" => decryptDisplay($_SESSION['Password'], $con));
isEmployee($con, $verify_array);
unset($verify_array);
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$account = decryptDisplay($_SESSION['EmailAddress'], $con);
	$apcheck = $con -> prepare('SELECT * FROM employee WHERE EmailAddress = :acc');
	$apcheck -> bindParam(':acc', $account);
	$apcheck -> execute();
	$admin_code = $apcheck -> fetch(PDO::FETCH_ASSOC);
	if(strcmp($admin_code['AdminPassword'], $_POST['ACode']) == 0) {
		$_SESSION['admin'] = true;
		header("Location: employeehome.php?info=adminlogged");
		die;
	}
	else {
		header("Location: employeehome.php?error=password");
		die;
	}
}
else {
	header("Location: employeehome.php");
	die;
}
?>